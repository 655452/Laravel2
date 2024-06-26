<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Http\Requests\RestaurantOwnerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class RestaurantOwnerController extends BackendController
{
    public function __construct()
    {
        $this->data['siteTitle'] = 'Restaurant Owner';

        $this->middleware(['permission:restaurant-owners'])->only('show');
        $this->middleware(['permission:restaurant-owners_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return $this->getRestaurantOwner($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail(3);

        $this->data['user'] = User::with('roles','media')->role($role->name)->findOrFail($id);
        return view('admin.restaurant-owner.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RestaurantOwnerRequest $request, $id)
    {

        $role = Role::findOrFail(3);
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

        if (request()->file('image')) {
            $user->deleteMedia('user', $user->id); 
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        return redirect(route('admin.restaurant-owners.index'))->withSuccess('The data updated successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role               = Role::findOrFail(3);
        $this->data['user'] = User::with('media','roles')->role($role->name)->findOrFail($id);
        return view('admin.restaurant-owner.show', $this->data);
    }

    public function getRestaurantOwner($request)
    {
        if (request()->ajax()) {
            $role  = Role::findOrFail(3);
            $users = User::role($role->name)->latest()->select();

            $i = 1;
            return Datatables::of($users)
                ->addColumn('action', function ($user) {
                    $retAction = '';

                    if (auth()->user()->can('restaurant-owners_show')) {
                        $retAction .= '<a href="' . route('admin.restaurant-owners.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }
                    if (auth()->user()->can('restaurant-owners_edit')) {
                        $retAction .= '<a href="' . route('admin.restaurant-owners.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2"data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';

                    }
                    return $retAction;
                })
                ->addColumn('image', function ($user) {
                    return '<figure class="avatar mr-2"><img src="' . $user->image . '" alt="' . $user->name . '"></figure>';
                })
                ->addColumn('name', function ($user) {
                    return $user->name;
                })
                ->editColumn('id', function ($category) use (&$i) {
                    return ++$i;
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.restaurant-owner.index');
    }

}
