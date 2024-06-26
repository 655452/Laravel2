<?php

/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 19/4/20
 * Time: 10:59 PM
 */

namespace App\Http\Controllers\Admin;

use App\Enums\OrderTypeStatus;
use App\Http\Services\PushNotificationService;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OrderLineItem;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Requests\OrderRequest;
use App\Http\Services\OrderService;
use App\Notifications\OrderUpdated;
use App\Http\Controllers\BackendController;

class OrderController extends BackendController
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Orders';
        $this->middleware('license-activate');
        $this->middleware(['permission:orders'])->only('index');
        $this->middleware(['permission:orders_create'])->only('create', 'store');
        $this->middleware(['permission:orders_edit'])->only('edit', 'update');
        $this->middleware(['permission:orders_delete'])->only('destroy');
        $this->middleware(['permission:orders_show'])->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderowner()->orderBy('id', 'desc')->get();

        $this->data['total_order']     = $orders->count();
        $this->data['pending_order']   = $orders->where('status', OrderStatus::PENDING)->count();
        $this->data['process_order']   = $orders->where('status', OrderStatus::PROCESS)->count();
        $this->data['completed_order'] = $orders->where('status', OrderStatus::COMPLETED)->count();

        return view('admin.orders.index', $this->data);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $this->data['order'] = Order::orderowner()->findOrFail($id);
        $this->data['items'] = OrderLineItem::with('menuItem', 'variation')->with('restaurant')->where(['order_id' => $this->data['order']->id])->get();
        return view('admin.orders.view', $this->data);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delivery($id)
    {
        $this->data['order'] = Order::where('delivery_boy_id', '!=', null)->orderowner()->findOrFail($id);
        if (blank($this->data['order']->delivery)) {
            return redirect(route('admin.orders.index'))->withError('The delivery boy not found');
        }
        return view('admin.orders.delivery', $this->data);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $this->data['order'] = Order::findOrFail($id);
        $this->data['items'] = OrderLineItem::with('menuItem', 'variation')->with('restaurant')->where(['order_id' => $this->data['order']->id])->get();

        $this->getOrderStatus($this->data['order']);
        $this->showStatusReceiveForm($this->data['order']);

        return view('admin.orders.edit', $this->data);
    }

    /**
     * @param OrderRequest $request
     * @param $id
     *
     * @return mixed
     */
    public function update(OrderRequest $request, $id)
    {
        $orderService = app(OrderService::class)->orderUpdate($id, $request->status);
        $order = Order::findOrFail($id);
        if ($orderService->status) {
            try {
                if ($request->status == OrderStatus::ACCEPT) {
                    $role  = Role::find(4);
                    $deliveryBoy    = User::role($role->name)->whereNotNull('device_token')->get();
                    $deliveryBoyWeb = User::role($role->name)->whereNotNull('web_token')->get();
                    if (!blank($deliveryBoy)) {
                        foreach ($deliveryBoy as $delivery) {
                            app(PushNotificationService::class)->sendNotificationOrderUpdate($order, $delivery,'deliveryboy');
                        }
                    }
                    if (!blank($deliveryBoyWeb)) {
                        foreach ($deliveryBoyWeb as $deliveryweb) {
                            app(PushNotificationService::class)->sendNotificationOrderUpdate($order, $deliveryweb,'deliveryboy');
                        }
                    }
                } else {
                    if (!blank($order->delivery_boy_id)) {
                        app(PushNotificationService::class)->sendNotificationOrderUpdate($order, $order->delivery,'deliveryboy');
                    }
                }
                app(PushNotificationService::class)->sendNotificationOrderUpdate($order, $order->user,'customer');
            } catch (\Exception $e) {
            }
            return redirect(route('admin.orders.index'))->withSuccess('Order successfully updated');
        } else {
            return redirect(route('admin.orders.index'))->withError($orderService->message);
        }
    }

    /**
     * @param OrderRequest $request
     * @param $id
     *
     * @return mixed
     */
    public function productReceive(Request $request, $id)
    {

        $this->validate($request, ['product_received' => 'required|numeric']);

        $productReceive = app(OrderService::class)->productReceive($id, $request->post('product_received'));

        if ($productReceive->status) {
            return redirect(route('admin.orders.show', $id))->withSuccess('The Data Updated Successfully');
        } else {
            return redirect(route('admin.orders.show', $id))->withError($productReceive->message);
        }
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        Order::orderowner()->findOrFail($id)->delete();
        return redirect(route('admin.orders.index'))->withSuccess('The Data Deleted Successfully');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getOrder(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->status)) {
                $startDate = $request->startDate;
                $endDate   = $request->endDate;
                $orders    = Order::where(['status' => $request->status])->where(function ($query) use (
                    $startDate,
                    $endDate
                ) {
                    if (!blank($startDate)) {
                        $startDate = Carbon::parse($startDate)->startOfDay()->toDateTimeString();
                        $endDate   = Carbon::parse(blank($endDate) ? $startDate : $endDate)->endOfDay()->toDateTimeString();
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }
                })->latest()->orderowner()->get();
            } else {
                $orders = Order::latest()->orderowner()->get();
            }

            $i          = 1;
            $orderArray = [];
            if (!blank($orders)) {
                foreach ($orders as $order) {
                    $drop = '';
                    $statusData = false;
                    $activeStatus = 'Change Status';
                    foreach (trans("order_status") as $key => $status) {
                        if ($order->status == \App\Enums\OrderStatus::CANCEL && $order->status == \App\Enums\OrderStatus::REJECT) {
                            $statusColor = 'bg-danger ';
                        } elseif ($order->status == \App\Enums\OrderStatus::COMPLETED) {
                            $statusColor = 'bg-success';
                        } elseif ($order->status == \App\Enums\OrderStatus::PROCESS) {
                            $statusColor = 'bg-primary';
                        } else {
                            $statusColor = 'bg-warning';
                        }
                        if ($order->status == $key) {
                            $activeStatus = $status;
                        }
                    }
                    $this->getOrderStatus($order);
                    $this->showStatusReceiveForm($order);
                    if ($this->data['showReceive']) {
                        $statusData = true;
                        $drop .= '<a class="dropdown-item order-status-item border  rounded bg-warning text-light" href="' . route('admin.orders.product-receive-index', [$order->id, 10]) . '">Not Receive</a>';
                        $drop .= '<a class="dropdown-item order-status-item border  rounded bg-warning text-light" href="' . route('admin.orders.product-receive-index', [$order->id, 5]) . '">Receive</a>';
                    } elseif (!blank($this->data['orderStatusArray'])) {
                        $statusData = true;
                        foreach ($this->data['orderStatusArray'] as $key => $status) {
                            $drop .= '<a class="dropdown-item order-status-item border  rounded bg-warning text-light" href="' . route('admin.order.change-status', [$order->id, $key]) . '">' . $status . '</a>';
                        }
                    }
                    $orderArray[$i]          = $order;
                    $orderArray[$i]['setID'] = $order->order_code;
                    $orderArray[$i]['drop'] = $drop;
                    $orderArray[$i]['statusData'] = $statusData;
                    $orderArray[$i]['activeStatus'] = $activeStatus;
                    $orderArray[$i]['statusColor'] = $statusColor;
                    $i++;
                }
            }

            return Datatables::of($orderArray)
                ->addColumn('action', function ($order) {
                    $retAction = '';

                    if (auth()->user()->can('orders_show')) {
                        $retAction .= '<a href="' . route(
                            'admin.orders.show',
                            $order
                        ) . '" class="btn btn-sm btn-icon btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }

                    if ($order->statusData && auth()->user()->can('orders_edit') && $order->status != OrderStatus::COMPLETED) {
                        $retAction .= '&nbsp;&nbsp;&nbsp;<a href="' . route('admin.orders.edit', $order) . '" class="pl-2 btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('orders_show') && $order->delivery_boy_id && auth()->user()->id != $order->delivery_boy_id) {
                        $retAction .= '&nbsp;&nbsp;&nbsp;<a href="' . route('admin.orders.delivery', $order) . '" class="btn btn-sm btn-icon btn-success" data-toggle="tooltip" data-placement="top" title="Delivery"><i class="far fa-list-alt"></i></a>';
                    }

                    return $retAction;
                })
                ->editColumn('user_id', function ($order) {
                    return (!blank($order->user) ? Str::limit(
                        $order->user->first_name . ' ' . $order->user->last_name,
                        20
                    ) : '');
                })
                ->editColumn('created_at', function ($order) {
                    return Carbon::parse($order->created_at)->format('d M Y, h:i A');
                })
                ->editColumn('order_type', function ($order) {
                    return $order->getOrderType;
                })
                ->editColumn('total', function ($order) {
                    return currencyFormat($order->total);
                })
                ->editColumn('status', function ($order) {
                    if ($order->statusData) {
                        return '<div class="dropdown">
                            <button class="dropdown_btn order-status-btn btn btn-outline-secondary dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                            .  $order->activeStatus
                            . '</button>
                          <div class="dropdown-menu order-status-div" aria-labelledby="dropdownMenuButton">' . $order->drop . '</div></div>';
                    } else {
                        return '<span class="badge order-badge ' . $order->statusColor . ' text-white">' . $order->activeStatus . '</span>';
                    }
                })
                ->editColumn('id', function ($order) {
                    return $order->setID;
                })->escapeColumns([])
                ->make(true);
        }
    }

    private function getOrderStatus($order)
    {
        $myRole      = auth()->user()->myrole;
        $allowStatus = [];

        if ($myRole == 2) {
            $allowStatus = [OrderStatus::CANCEL];
        } else if ($myRole == 3) {
            if ($order->status == OrderStatus::PENDING) {
                $allowStatus = [OrderStatus::ACCEPT, OrderStatus::REJECT];
            } elseif ($order->status == OrderStatus::ACCEPT) {
                if($order->order_type == OrderTypeStatus::PICKUP){
                    $allowStatus = [OrderStatus::COMPLETED];
                }else {
                    $allowStatus = [OrderStatus::PROCESS];
                }
            }
        } else if ($myRole == 4) {
            if ($order->status == OrderStatus::PROCESS) {
                $allowStatus = [];
            } elseif ($order->status == OrderStatus::ON_THE_WAY) {
                $allowStatus = [OrderStatus::COMPLETED];
            } elseif ($order->status == OrderStatus::COMPLETED) {
                $allowStatus = [];
            } else {
                $allowStatus = [OrderStatus::ON_THE_WAY, OrderStatus::COMPLETED];
            }
        }

        $orderStatusArray = [];
        if (!blank($allowStatus)) {
            foreach (trans('order_status') as $key => $status) {
                if (in_array($key, $allowStatus)) {
                    $orderStatusArray[$key] = $status;
                }
            }
        }
        $this->data['orderStatusArray'] = $orderStatusArray;
    }

    private function showStatusReceiveForm($order)
    {
        $myrole = auth()->user()->myrole;

        $showStatus = true;
        if ($myrole == 1 || $myrole == 4) {
            $showStatus = false;
        }

        $showReceive = false;
        if (($order->status == 15) && $myrole == 4) {
            $showStatus  = false;
            $showReceive = true;
        }

        if (($order->status == 17) && $myrole == 4) {
            $showStatus = true;
        }

        if (($order->status == 17) && $myrole == 3) {
            $showStatus = false;
        }

        $this->data['showStatus']  = $showStatus;
        $this->data['showReceive'] = $showReceive;
    }

    public function getDownloadFile($id)
    {
        if ((int)$id) {
            $order = Order::find($id);
            if (!blank($order)) {
                $file = $order->getMedia('orders');
                return $this->fileDownloadResponse($file[0]);
            }
        }
    }

    private function fileDownloadResponse(Media $mediaItem)
    {
        return $mediaItem;
    }

    public function changeStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $orderService = app(OrderService::class)->orderUpdate($order->id, $status);
        if ($orderService->status) {

            try {
                if ($status == OrderStatus::ACCEPT) {
                    $role  = Role::find(4);
                    $deliveryBoy    = User::role($role->name)->whereNotNull('device_token')->get();
                    $deliveryBoyWeb = User::role($role->name)->whereNotNull('web_token')->get();
                    if (!blank($deliveryBoy)) {
                        foreach ($deliveryBoy as $delivery) {
                            app(PushNotificationService::class)->sendNotificationOrderUpdate($order, $delivery,'deliveryboy');
                        }
                    }
                    if (!blank($deliveryBoyWeb)) {
                        foreach ($deliveryBoyWeb as $deliveryweb) {
                            app(PushNotificationService::class)->sendNotificationOrderUpdate($order, $deliveryweb,'deliveryboy');
                        }
                    }
                } else {
                    if (!blank($order->delivery_boy_id)) {
                        app(PushNotificationService::class)->sendNotificationOrderUpdate($order, $order->delivery,'deliveryboy');
                    }
                }
                app(PushNotificationService::class)->sendNotificationOrderUpdate($order, $order->user,'customer');
            } catch (\Exception $e) {}
            return redirect(route('admin.orders.index'))->withSuccess('Order successfully updated');
        } else {
            return redirect(route('admin.orders.index'))->withError($orderService->message);
        }
    }

    public function productReceiveIndex($id, $status)
    {
        $productReceive = app(OrderService::class)->productReceive($id, $status);

        if ($productReceive->status) {
            return redirect(route('admin.orders.show', $id))->withSuccess('The Data Updated Successfully');
        } else {
            return redirect(route('admin.orders.show', $id))->withError($productReceive->message);
        }
    }

    public function liveOrders()
    {
        return view('admin.orders.liveOrders', $this->data);
    }

    public function getLiveOrders()
    {
        $orderCount            = Order::with('restaurant', 'user')->whereDate('created_at', Carbon::today())->orderowner()->orderBy('id', 'desc')->get();
        $this->data['total_order']     = $orderCount->count();
        $this->data['pending_order']   = $orderCount->where('status', OrderStatus::PENDING)->count();
        $this->data['process_order']   = $orderCount->where('status', OrderStatus::PROCESS)->count();
        $this->data['completed_order'] = $orderCount->where('status', OrderStatus::COMPLETED)->count();


        $this->data['new_orders'] = [];
        $this->data['accepted_orders']  = [];
        $this->data['done_orders']      = [];

        $orders = Order::with('restaurant', 'user')->whereDate('created_at', Carbon::today())->orderowner()->orderBy('id', 'desc')->get();
        foreach ($orders as $order) {
            if ($order->status == OrderStatus::PENDING) {
                $this->data['new_orders'][] = $order;
            } elseif ($order->status == OrderStatus::ACCEPT) {
                $this->data['accepted_orders'][]  = $order;
            } else {
                $this->data['done_orders'][] = $order;
            }
        }
        return view('admin.orders.live_order_data', $this->data);
    }
}
