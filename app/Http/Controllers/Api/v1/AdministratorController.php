<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\UserStatus;
use App\Http\Controllers\BackendController;
use App\Http\Requests\AdministratorRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class AdministratorController extends BackendController
{
    use ApiResponse;
    public function __construct()
    {
        $this->data['siteTitle'] = 'Administrator';

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['users']=$this->getAdministrators();
        return view('admin.administrators.index', $this->data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministratorRequest $request)
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
        $user->save();

        if (request()->file('image')) {
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        $role = Role::find(1);
        $user->assignRole($role->name);

        return $this->successresponse(['status'=>200,'message'=>'The Data Inserted Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role               = Role::find(1);
        $this->data['user'] = User::role($role->name)->findOrFail($id);
        return $this->successresponse(['status'=>200, 'data'=>$this->data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find(1);
        $user = User::role($role->name)->findOrFail($id);

        if ($this->modifyPermission($user)) {
            $this->data['user'] = $user;
            return $this->successresponse(['status'=>200, 'data'=>$this->data]);
        }
        return $this->successresponse(['status'=>200, 'message'=>'You do not have permission to change this']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdministratorRequest $request, $id)
    {
        $role = Role::find(1);
        $user = User::role($role->name)->findOrFail($id);

        if ($this->modifyPermission($user)) {

            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->email      = $request->email;
            $user->username   = $request->username ?? generateUsername($request->email);

            if ($request->password) {
                $user->password = Hash::make(request('password'));
            }

            $user->phone   = $request->phone;
            $user->address = $request->address;
            if ($user->id != 1) {
                $user->status = $request->status;
            } else {
                $user->status = UserStatus::ACTIVE;
            }
            $user->save();

            if (request()->file('image')) {
                $user->media()->delete();
                $user->addMedia(request()->file('image'))->toMediaCollection('user');
            }
            return $this->successresponse(['status'=>200, 'message'=>'The Data Updated Successfully']);
        }
        return $this->successresponse(['status'=>200, 'message'=>'You don\'t have permission to update this data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find(1);
        $user = User::role($role->name)->findOrFail($id);
        if ($this->deletePermission($user)) {
            $user->delete();
            return $this->successresponse(['status'=>200, 'message'=>'The Data Deleted Successfully']);
        }
        return $this->successresponse(['status'=>200, 'message'=>'You don\'t have permission to delete this data']);
    }

    public function getAdministrators()
    {
        $role  = Role::find(1);
        $users = User::role($role->name)->latest()->select();

        $i = 0;
        return $users;
    }

    private function modifyPermission($user)
    {
        return ($user->id != 1) || (auth()->id() == 1);
    }

    private function deletePermission($user)
    {
        return ($user->id != 1) && (auth()->id() == 1);
    }
}
