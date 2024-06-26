<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserApplied;
use App\Http\Controllers\BackendController;
use App\Http\Requests\DeliveryBoyRequest;
use App\Http\Services\DepositService;
use App\Models\DeliveryBoyAccount;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class DeliveryBoyController extends BackendController
{
    public function __construct()
    {
        $this->data['siteTitle'] = 'Delivery Boys';

        $this->middleware(['permission:delivery-boys_create'])->only('create', 'store');
        $this->middleware(['permission:delivery-boys_edit'])->only('edit', 'update');
        $this->middleware(['permission:delivery-boys_delete'])->only('destroy');
        $this->middleware(['permission:delivery-boys_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.delivery-boy.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.delivery-boy.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryBoyRequest $request)
    {
        $user             = new User;
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->username   = $request->username ?? generateUsername($request->email);
        $user->password   = Hash::make(request('password'));
        $user->phone      = $request->phone;
        $user->address    = $request->address;
        $user->status     = $request->status;
        $user->applied    = UserApplied::ADMIN;
        $user->save();

        if (request()->file('image')) {
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        $role = Role::find(4);
        if (!blank($role)) {
            $user->assignRole($role->name);
        }

        $deliveryBoyAccount                  = new DeliveryBoyAccount();
        $deliveryBoyAccount->user_id         = $user->id;
        $deliveryBoyAccount->delivery_charge = 0;
        $deliveryBoyAccount->balance         = 0;
        $deliveryBoyAccount->save();

        $depositAmount = $request->deposit_amount;
        if (blank($depositAmount)) {
            $depositAmount = 0;
        }

        $limitAmount = $request->limit_amount;
        if (blank($limitAmount)) {
            $limitAmount = 0;
        }

        $depositService = app(DepositService::class)->depositAdjust($user->id, $depositAmount, $limitAmount);
        if ($depositService->status) {
            return redirect(route('admin.delivery-boys.index'))->withSuccess('The Data Inserted Successfully');
        } else {
            return redirect(route('admin.delivery-boys.index'))->withError($depositService->message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role               = Role::find(4);
        $this->data['user'] = User::with('media','roles')->role($role->name)->findOrFail($id);
        return view('admin.delivery-boy.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role               = Role::find(4);
        $this->data['user'] = User::with('media','roles')->role($role->name)->findOrFail($id);
        return view('admin.delivery-boy.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryBoyRequest $request, $id)
    {
        $role = Role::find(4);
        if (!blank($role)) {
            $user = User::role($role->name)->find($id);
            if (!blank($user)) {
                $depositAmount = $request->deposit_amount;
                if (blank($depositAmount)) {
                    $depositAmount = 0;
                }

                $limitAmount = $request->limit_amount;
                if (blank($limitAmount)) {
                    $limitAmount = 0;
                }

                $depositService = app(DepositService::class)->depositAdjust($user->id, $depositAmount, $limitAmount);
                if ($depositService->status) {
                    $user->first_name = $request->first_name;
                    $user->last_name  = $request->last_name;
                    $user->email      = $request->email;
                    $user->username   = $request->username ?? generateUsername($request->email);

                    if ($request->password) {
                        $user->password = Hash::make(request('password'));
                    }

                    $user->phone   = $request->phone;
                    $user->address = $request->address;
                    $user->status  = $request->status;
                    $user->save();

                    if (request()->file('image')) {
                        $user->deleteMedia('user', $user->id);
                        $user->addMedia(request()->file('image'))->toMediaCollection('user');
                    }
                    $user->assignRole($role->name);
                    return redirect(route('admin.delivery-boys.index'))->withSuccess('The Data Updated Successfully');
                } else {
                    return redirect(route('admin.delivery-boys.index'))->withError($depositService->message);
                }
            } else {
                return redirect(route('admin.delivery-boys.index'))->withError('The User Not Found');
            }
        } else {
            return redirect(route('admin.delivery-boys.index'))->withError('The Role Not Found');
        }
    }

    public function getDeliveryBoy()
    {
        $role  = Role::find(4);
        $users = User::role($role->name)->latest()->select();

        $i = 0;
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                $retAction = '';

                if (auth()->user()->can('delivery-boys_show')) {
                    $retAction .= '<a href="' . route('admin.delivery-boys.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                }

                if (auth()->user()->can('delivery-boys_edit')) {
                    $retAction .= '<a href="' . route('admin.delivery-boys.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2"data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';

                }
                return $retAction;
            })
            ->addColumn('image', function ($user) {
                return '<figure class="avatar mr-2"><img src="' . $user->image . '" alt=""></figure>';
            })
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('id', function ($user) use (&$i) {
                return ++$i;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function history(Request $request)
    {
        if (request()->ajax()) {
            $orders = Order::where(['delivery_boy_id' => $request->delivery_boy_id])->orderBy('id', 'desc')->select();

            return Datatables::of($orders)
                ->addColumn('action', function ($order) {
                    if (auth()->user()->can('delivery-boys_show')) {
                        return '<a href="' . route('admin.orders.show', $order) . '" class="btn btn-sm btn-icon btn-info"><i class="far fa-eye"></i></a>';
                    }
                })
                ->editColumn('user_id', function ($order) {
                    return (!blank($order->user) ? Str::limit($order->user->name, 20) : '');
                })
                ->editColumn('created_at', function ($order) {
                    return Carbon::parse($order->created_at)->format('d M Y, h:i A');
                })
                ->editColumn('status', function ($order) {
                    return trans('order_status.' . $order->status);
                })
                ->editColumn('id', function ($order) {
                    return $order->order_code;
                })->make(true);
        }
    }
}
