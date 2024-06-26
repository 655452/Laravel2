<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Models\Cuisine;
use App\Models\Discount;
use App\Enums\CouponType;
use App\Models\Restaurant;
use App\Enums\CouponStatus;
use App\Enums\DiscountType;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CouponRequest;
use App\Http\Services\CouponService;
use App\Http\Controllers\BackendController;

class CouponController extends BackendController
{

    /**
     * Category Controller constructor.
     */
    protected $couponService;
    public function __construct(CouponService $couponService)
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Coupons';
        $this->couponService = $couponService;
        $this->middleware(['permission:coupon'])->only('index');
        $this->middleware(['permission:coupon_create'])->only('create', 'store');
        $this->middleware(['permission:coupon_edit'])->only('edit', 'update');
        $this->middleware(['permission:coupon_delete'])->only('destroy');
        $this->middleware(['permission:coupon_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return $this->getCoupon($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!blank(auth()->user()->restaurant)) {
            $today = date('Y-m-d h:i:s');
            $coupons = Coupon::where('restaurant_id', auth()->user()->restaurant->id)
                ->whereDate('to_date', '>=', $today)
                ->whereDate('from_date', '<=', $today)
                ->where('limit', '>', 0)
                ->get();

            $data = [];
            if (!blank($coupons)) {
                foreach ($coupons as $coupon) {
                    $total_used = Discount::where('coupon_id', $coupon->id)->where('status', \App\Enums\DiscountStatus::ACTIVE)->count();
                    if ($total_used < $coupon->limit) {
                        $data[] = $coupon;
                    }
                }
            }
            if (!blank($data)) {
                return redirect()->back()->withError('This Restaurant already has an active voucher.');
            }
        }
        $this->data['restaurants'] = Restaurant::select('id', 'name')->get();
        return view('admin.coupon.create', $this->data);
    }


    public function store(CouponRequest $request)
    {

        $coupon = $this->couponService->store($request);
        return redirect(route('admin.coupon.index'))->withSuccess('The data inserted successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['coupon'] = Coupon::findOrFail($id);
        $this->data['restaurants'] = Restaurant::select('id', 'name')->get();
        return view('admin.coupon.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, $id)
    {
        $coupon = $this->couponService->update($id, $request);
        return redirect(route('admin.coupon.index'))->withSuccess('The data updated successfully.');
    }



    public function show($id)
    {
        $this->data['coupon'] = $this->couponService->show($id);
        return view('admin.coupon.show', $this->data);
    }




    public function destroy($id)
    {
        Coupon::findOrFail($id)->delete();
        return redirect(route('admin.coupon.index'))->withSuccess('The data deleted successfully.');
    }

    private function getCoupon($request)
    {
        if (request()->ajax()) {
            $queryArray = [];

            if (auth()->user()->myrole != 1 && !blank(auth()->user()->restaurant)) {
                $queryArray['restaurant_id'] = auth()->user()->restaurant->id;
            }

            if ($request->discount_type) {
                $queryArray['discount_type'] = $request->discount_type;
            }
            if ($request->coupon_type) {
                $queryArray['coupon_type'] = $request->coupon_type;
            }

            if (!blank($queryArray)) {
                $coupons = Coupon::where($queryArray)->descending()->get();
            } else {
                $coupons = Coupon::descending()->get();
            }

            $i = 0; 
           return Datatables::of($coupons)
                ->addColumn('action', function ($coupon) {
                    $retAction = '';

                        if (auth()->user()->can('coupon_show')) {
                            $retAction .= '<a href="' . route('admin.coupon.show', $coupon) . '" class="btn btn-sm btn-icon float-left btn-info mr-2" data-toggle="tooltip" data-placement="top" title="View"> <i class="far fa-eye"></i></a>';
                        }

                        if (auth()->user()->can('coupon_edit')) {
                            $retAction .= '<a href="' . route('admin.coupon.edit', $coupon) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="far fa-edit"></i></a>';
                        }

                        if (auth()->user()->can('coupon_delete')) {
                            $retAction .= '<form  id="detete-'.$coupon->id.'" class="float-left pl-2" action="' . route('admin.coupon.destroy', $coupon) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                            '<button type="button" data-id="'.$coupon->id.'"
                            class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                            <i class="fa fa-trash"></i>
                            </button></form>';
                        }
                    return $retAction;
                })
                ->editColumn('id', function ($coupon) use (&$i) {
                    return ++$i;
                })
                ->editColumn('name', function ($coupon) {
                    return $coupon->name;
                })
                ->editColumn('slug', function ($coupon) {
                    return $coupon->slug;
                })
                ->editColumn('coupon_type', function ($coupon) {
                    return trans('coupon_types.' . $coupon->coupon_type);
                })
                ->editColumn('limit', function ($coupon) {
                    return $coupon->limit;
                })
                ->editColumn('status', function ($coupon) {

                    $status = trans('coupon_status.' . CouponStatus::ACTIVE);
                    $today = date('Y-m-d h:i:s');
                    $total_used = Discount::where('coupon_id', $coupon->id)->where('status', \App\Enums\DiscountStatus::ACTIVE)->count();
                    if ($total_used >= $coupon->limit) {
                        $status = trans('coupon_status.' . CouponStatus::EXPIRED);
                    } elseif (!(($coupon->to_date >= $today) && ($coupon->from_date <= $today))) {
                        $status = trans('coupon_status.' . CouponStatus::EXPIRED);
                    } else {
                        $status = trans('coupon_status.' . CouponStatus::ACTIVE);
                    }
                    return $status;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.coupon.index');
    }

    public function allCoupons()
    {
        $coupons = $this->couponService->allCoupons();
        return $coupons;
    }

    public function singleRestaurantCoupon(Request $request)
    {
        $coupons = $this->couponService->singleRestaurantCoupon($request);
        return $coupons;
    }
}
