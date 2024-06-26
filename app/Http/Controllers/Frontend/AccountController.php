<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Report;
use App\Models\Address;
use App\Enums\AddressType;
use App\Enums\OrderStatus;
use App\Enums\ReportStatus;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OrderLineItem;
use App\Models\RestaurantRating;
use Yajra\Datatables\Datatables;
use App\Http\Services\OrderService;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\RatingsRequest;
use Spatie\MediaLibrary\Models\Media;
use App\Http\Services\ComplaintService;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\ChangePasswordRequest;

class AccountController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'My Orders';
    }

    public function index()
    {
        $this->data['site_title'] = 'Profile';
        $this->data['user'] = auth()->user();
        return view('frontend.account.profile', $this->data);
    }

    public function profileUpdate()
    {
        $this->data['user'] = auth()->user();
        return view('frontend.account.profile-update', $this->data);
    }
    public function getPassword()
    {
        $this->data['site_title'] = 'Change Password';
        return view('frontend.account.change-password', $this->data);
    }

    public function review()
    {
        return view('frontend.account.review', $this->data);
    }

    public function getReservation()
    {
        $this->data['reservations'] = auth()->user()->reservations()->latest()->paginate(8);

        $this->data['statusClasses'] = [
            1 => 'yellow',
            2 => 'green',
            3 => 'red',
            4 => 'maroon',
        ];
        $this->data['site_title'] = 'My Reservation';
        return view('frontend.account.my-reservation', $this->data);
    }


    public function getOrder()
    {

        $this->data['orders'] = auth()->user()->orders()->latest()->paginate(8);
        $this->data['reports'] = pluck(Report::select('status', 'order_id')->get(), 'status', 'order_id');
        return view('frontend.account.my-order', $this->data);
    }

    public function update(ProfileRequest $request){
        $user                    = auth()->user();
        $user->first_name        = $request->get('first_name');
        $user->last_name         = $request->get('last_name');
        $user->email             = $request->get('email');
        $user->phone             = $request->get('phone');
        $user->username          = $request->username ?? $this->username($request->email);
        $user->address           = $request->get('address');
        $user->country_code      = $request->get('countrycode');
        $user->country_code_name = $request->get('countrycodename');
        $user->save();

        if ($user->address != $request->get('address')) {
            Address::create([
                'label' => AddressType::HOME,
                'address' => $request->get('address'),
                'label_name' => trans('address_types.' . AddressType::HOME),
                'user_id' => $user->id,
            ]);
        }

        if (request()->file('image')) {
            $user->media()->delete();
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        return redirect(route('account.profile'))->with('success', 'The Profile Has Been Updated Successfully');
    }

    public function reportView($id)
    {
        $report = Report::where('order_id', $id)->first();
        if (blank($report)) {
            $this->data['order'] = Order::findOrFail($id);
            return view('frontend.account.report', $this->data);
        } else {
            $notificationColor = trans('report_status_color.' . $report->status);

            $message = trans('report_statuses_frontend.' . $report->status);
            return redirect(route('account.order'))->with($notificationColor, $message);
        }

         return redirect(route('account.profile'))->with('success', 'The Profile Has Been Updated Successfully');

    }

    public function storeReport(ReportRequest $request)
    {
        $report = app(ComplaintService::class)->storeReport($request);
        if ($report) {
            return redirect(route('account.order'))->with('success', 'Your report has successfully been placed.');
        } else {
            return view('errors.404');
        }
    }

    private function username($email)
    {
        $emails = explode('@', $email);
        return $emails[0] . mt_rand();
    }

    public function password_update(ChangePasswordRequest $request)
    {
        $user           = auth()->user();
        $user->password = Hash::make(request('password'));
        $user->save();
        return redirect(route('account.password'))->with('success', 'The Password Updated Successfully');
    }


    public function orderShow($id)
    {
        $this->data['order'] = Order::where('user_id', auth()->id())->findOrFail($id);
        $this->data['items'] = OrderLineItem::with('menuItem', 'variation')->with('restaurant')->where(['order_id' => $this->data['order']->id])->get();

        return view('frontend.account.order_details', $this->data);
    }

    public function orderCancel($id)
    {
        if ($id) {
            $order = Order::where([
                'user_id' => auth()->id(),
                'status'  => OrderStatus::PENDING
            ])->find($id);
            if (!blank($order)) {
                $orderService = app(OrderService::class)->cancel($id);
                if ($orderService->status) {
                    return redirect(route('account.order.show', $order->id))->withSuccess('Successfully order cancel');
                } else {
                    return redirect(route('account.order.show', $order->id))->withError($orderService->message);
                }
            } else {
                return redirect(route('account.order'));
            }
        } else {
            return redirect(route('account.order'));
        }
    }

    public function getTransactions()
    {
        $this->data['site_title'] = 'My Transaction';

        $transactions = Transaction::orWhere('source_balance_id', auth()->user()->balance_id)
        ->orWhere(['destination_balance_id' => auth()->user()->balance_id])->orderBy('id', 'DESC')->paginate(8);

        return view('frontend.account.transaction', $this->data,  compact('transactions') ) ;
    }

    private function showTransactionItem($transaction)
    {
        $roleID = auth()->user()->myrole ?? 0;

        if ($roleID == 1) {
            if (($transaction->source_balance_id == null && ($transaction->destination_balance_id == auth()->user()->balance_id)) || ($transaction->source_balance_id == 1 && $transaction->destination_balance_id != 1)) {
                return false;
            }
        } else if ($roleID == 3) {
            if (($transaction->source_balance_id == null && ($transaction->destination_balance_id == auth()->user()->balance_id)) || ($transaction->source_balance_id == 1)) {
                return false;
            }
        } else {
            if (($transaction->source_balance_id == null && ($transaction->destination_balance_id == auth()->user()->balance_id)) || ($transaction->source_balance_id == auth()->user()->balance_id)) {
                return false;
            }
        }
        return true;
    }


    public function shopProductRatings(Shop $shop, Product $product)
    {
        $this->data['shopProductRating'] = RestaurantRating::where(['user_id' => auth()->user()->id, 'shop_id' => $shop->id, 'product_id' => $product->id])->first();
        if (!blank($shop) && !blank($product)) {
            $this->data['shop']        = $shop;
            $this->data['product']     = $product;
            $this->data['site_title']  = $product->name;
            $this->data['shopProduct'] = ShopProduct::where(['shop_id' => $shop->id, 'product_id' => $product->id])->first();
            return view('frontend.account.shop_product_ratings', $this->data);
        }

        return abort(404);
    }

    public function shopProductRatingsUpdate(RatingsRequest $request)
    {
        $shopProductRating = RestaurantRating::where(['user_id' => auth()->user()->id, 'product_id' => $request->product_id, 'shop_id' => $request->shop_id])->first();
        if ($shopProductRating) {
            $shopProductRating->rating = $request->rating;
            $shopProductRating->review = $request->review;
            $shopProductRating->save();
            return redirect(route('account.review'))->withSuccess('The Data Update Successfully');
        } else {

            $shopProductRating             = new RestaurantRating;
            $shopProductRating->user_id    = auth()->id();
            $shopProductRating->product_id = $request->product_id;
            $shopProductRating->shop_id    = $request->shop_id;
            $shopProductRating->rating     = $request->rating;
            $shopProductRating->review     = $request->review;
            $shopProductRating->status     = $request->status;
            $shopProductRating->save();
            return redirect(route('account.review'))->withSuccess('The Data Inserted Successfully');
        }
    }

    public function getReview(Request $request)
    {
        $shop_products    = auth()->user()->orders()->latest()->where('status', OrderStatus::COMPLETED)->get();
        $i                = 1;
        $shopProductArray = [];
        $itenCheckArray   = [];
        if (!blank($shop_products)) {
            foreach ($shop_products as $shop_product) {
                foreach ($shop_product->items as $shopProduct) {
                    if (isset($itenCheckArray[$shopProduct->shop_id][$shopProduct->product_id])) {
                        continue;
                    } else {
                        $itenCheckArray[$shopProduct->shop_id][$shopProduct->product_id] = true;
                    }
                    $shopProductArray[$i]                 = $shopProduct;
                    $shopProductArray[$i]['images']       = $shopProduct->product->images;
                    $shopProductArray[$i]['product_slug'] = $shopProduct->product->slug;
                    $shopProductArray[$i]['shop_slug']    = $shopProduct->shop->slug;
                    $shopProductArray[$i]['product']      = Str::limit($shopProduct->product->name, 30);
                    $shopProductArray[$i]['shop']         = Str::limit($shopProduct->shop->name, 30);
                    $i++;
                }
            }
        }
        return Datatables::of($shopProductArray)
            ->addColumn('action', function ($shopProduct) {
                return '<a href="' . route('account.shop-product-ratings', [$shopProduct->shop_slug, $shopProduct->product_slug]) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
            })
            ->addColumn('product_image', function ($shopProduct) {
                return '<img class="rounded-circle img-sm border" src="' . $shopProduct->images . '" alt="" /></figure>';
            })
            ->editColumn('product_name', function ($shopProduct) {
                return $shopProduct->product;
            })
            ->editColumn('shop_name', function ($shopProduct) {
                return $shopProduct->shop;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function getOrderList(Request $request)
    {
        $orders = auth()->user()->orders()->latest()->get();

        $i          = 1;
        $orderArray = [];
        if (!blank($orders)) {
            foreach ($orders as $order) {
                $orderArray[$i]          = $order;
                $orderArray[$i]['setID'] = $order->order_code;
                $i++;
            }
        }

        return Datatables::of($orderArray)
            ->addColumn('action', function ($order) {
                return '<a href="' . route('account.order.show', $order->id) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
            })
            ->editColumn('created_at', function ($order) {
                return Carbon::parse($order->created_at)->format('d M Y, h:i A');
            })
            ->editColumn('order_code', function ($order) {
                return $order->order_code;
            })
            ->editColumn('total', function ($order) {
                return currencyFormat($order->total);
            })
            ->editColumn('status', function ($order) {
                return trans('order_status.' . $order->status);
            })
            ->editColumn('payment_status', function ($order) {
                return trans('payment_status.' . $order->payment_status);
            })
            ->make(true);
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

}
