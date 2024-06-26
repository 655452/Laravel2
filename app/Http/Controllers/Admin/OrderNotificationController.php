<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 19/4/20
 * Time: 10:59 PM
 */

namespace App\Http\Controllers\Admin;

use App\Enums\DeliveryHistoryStatus;
use App\Enums\OrderStatus;
use App\Enums\OrderTypeStatus;
use App\Http\Controllers\BackendController;
use App\Models\DeliveryBoyAccount;
use App\Models\DeliveryStatusHistories;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class OrderNotificationController extends BackendController
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Order Notitifications';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order-notification.index', $this->data);
    }

    public function accept(Request $request, $id, $deliveryStatus)
    {
        $order = Order::where(['id' => $id, 'delivery_boy_id' => null])->first();
        if ($this->getLimitAmount() < $order->total) {
            return redirect(route('admin.order-notification.index'))->withError('You balance amount cross the order limit amount.');
        }

        if (!blank($order) && auth()->user()->myrole == 4) {
            $message = 'Order reject successfully';
            if ($deliveryStatus == DeliveryHistoryStatus::ACCEPT) {
                $order->delivery_boy_id = auth()->user()->id;
                $order->save();
                $message = 'Order accept successfully';
            }

            $deliveryStatusHistories = DeliveryStatusHistories::where(['order_id' => $order->id, 'user_id' => auth()->user()->id])->first();
            if (blank($deliveryStatusHistories)) {
                DeliveryStatusHistories::create([
                    'order_id' => $order->id,
                    'user_id'  => auth()->user()->id,
                    'status'   => $deliveryStatus,
                ]);
            }
            return redirect(route('admin.order-notification.index'))->withSuccess($message);
        }
        return redirect(route('admin.order-notification.index'))->withError('You dont have permission to access this feature.');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getOrderNotification(Request $request)
    {
        if (request()->ajax()) {

            $deliveryStatusHistoriesArray = DeliveryStatusHistories::where([
                'user_id' => auth()->user()->id,
                'status'  => DeliveryHistoryStatus::CANCEL,
            ])->get()->pluck('order_id')->toArray();

            $orders = Order::where(['delivery_boy_id' => null,'order_type' =>OrderTypeStatus::DELIVERY])->whereIn('status', [OrderStatus::ACCEPT, OrderStatus::PROCESS])->latest()->whereNotIn('id', $deliveryStatusHistoriesArray)->get();

            $i          = 1;
            $orderArray = [];
            if (!blank($orders)) {
                foreach ($orders as $order) {
                    if ($this->getLimitAmount() < $order->total) {
                        continue;
                    }

                    $orderArray[$i]          = $order;
                    $orderArray[$i]['setID'] = $order->order_code;
                    $i++;
                }
            }

            return Datatables::of($orderArray)
                ->addColumn('action', function ($order) {

                    $retAction = '<a href="' . route('admin.order-notification.accept', [$order, 5]) . '" class="btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="Accept"><i class="far fa-eye"></i> Accept</a>';

                    $retAction .= '&nbsp;&nbsp;&nbsp;<a href="' . route('admin.order-notification.accept', [$order, 10]) . '" class="pl-2 btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Reject"><i class="far fa-edit"></i> Reject</a>';

                    return $retAction;
                })
                ->editColumn('created_at', function ($order) {
                    return Carbon::parse($order->created_at)->format('d M Y, h:i A');
                })
                ->editColumn('status', function ($order) {
                    return trans('order_status.' . $order->status);
                })
                ->editColumn('id', function ($order) {
                    return $order->setID;
                })->make(true);
        }
    }

    private function getLimitAmount()
    {
        $userLimitAmount    = (auth()->user()->deposit->limit_amount > 0) ? auth()->user()->deposit->limit_amount : setting('delivery_boy_order_amount_limit');
        $deliveryBoyBalance = (DeliveryBoyAccount::where('user_id', auth()->user()->id)->first())->balance ?? 0;
        $acceptOrder        = Order::where('delivery_boy_id', auth()->id())->where('status', '!=', OrderStatus::COMPLETED)->sum('total');
        $deliveryBoyBalance = $deliveryBoyBalance + $acceptOrder;

        return $this->notZero(($userLimitAmount - $deliveryBoyBalance));

    }

    private function notZero($amount)
    {
        if ($amount <= 0) {
            return 0;
        }
        return $amount;
    }
}
