<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Address;
use App\Enums\AddressType;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CustomerRequest;
use App\Http\Controllers\BackendController;

class CustomerController extends BackendController
{
    public function __construct()
    {
        $this->data['siteTitle'] = 'Customers';

        $this->middleware(['permission:customers'])->only('index');
        $this->middleware(['permission:customers_create'])->only('create', 'store');
        $this->middleware(['permission:customers_edit'])->only('edit', 'update');
        $this->middleware(['permission:customers_delete'])->only('destroy');
        $this->middleware(['permission:customers_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.customer.index', $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find(2);

        $this->data['user'] = User::with('media', 'roles')->role($role->name)->findOrFail($id);
        return view('admin.customer.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find(2);

        $this->data['user'] = User::with('media', 'roles')->role($role->name)->findOrFail($id);
        return view('admin.customer.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $role = Role::find(2);
        $user = User::role($role->name)->findOrFail($id);

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

        if ($user->address != $request->address) {
            Address::create([
                'label' => AddressType::HOME,
                'label_name' => trans('address_types.' . AddressType::HOME),
                'address' => $request->address,
                'user_id' => $user->id,
            ]);
        }

        if (request()->file('image')) {
            $user->deleteMedia('user', $user->id);
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        $role = Role::find(2);
        $user->assignRole($role->name);

        return redirect(route('admin.customers.index'))->withSuccess('The Data Updated Successfully');
    }

    public function getCustomers()
    {
        $role  = Role::find(2);
        $users = User::role($role->name)->latest()->get();

        $i = 0;
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                $retAction = '';

                if (auth()->user()->can('customers_show')) {
                    $retAction .= '<a href="' . route('admin.customers.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                }

                if (auth()->user()->can('customers_edit')) {
                    $retAction .= '<a href="' . route('admin.customers.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
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
}
