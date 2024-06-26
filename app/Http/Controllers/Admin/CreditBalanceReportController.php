<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CreditBalanceReportController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Credit Balance Report';
        $this->middleware([ 'permission:credit-balance-report' ])->only('index');
    }

    public function index( Request $request )
    {
        $this->data['showView']    = false;
        $this->data['set_user_id'] = '';
        $this->data['set_role_id'] = '';
        $this->data['roles']       = Role::all();
        $this->data['users']       = User::All();
        if ( $request->role_id ) {
            $role = $request->post('role_id');
            if ( ((int)$role) ) {
                $role                = Role::find($role);
                $this->data['users'] = User::role($role->name)->latest()->get();
            }
        }
        if ( $_POST ) {
            $request->validate([
                'user_id' => 'nullable|numeric',
                'role_id' => 'nullable|numeric',
            ]);
            $this->data['showView']    = true;
            $this->data['set_user_id'] = $request->user_id;
            $this->data['set_role_id'] = $request->role_id;
            $user_id                   = $request->user_id;
            $role_id                   = $request->role_id;
            if ( $role_id && $user_id ) {
                $role                         = Role::find($role_id);
                $this->data['creditBalances'] = User::with('roles','media','balance','getrole')->role($role->name)->where('id', $user_id)->latest()->get();
            } elseif ( $user_id ) {
                $this->data['creditBalances'] = User::with('roles','media','balance','getrole')->where('id', $user_id)->latest()->get();
            } elseif ( $role_id ) {
                $role                         = Role::find($role_id);
                $this->data['creditBalances'] = User::with('roles','media','balance','getrole')->role($role->name)->latest()->get();
                $this->data['users']          = User::with('roles','media','balance','getrole')->role($role->name)->latest()->get();
            } else {
                $this->data['creditBalances'] = User::with('roles','media','balance','getrole')->get();
            }
        }
        return view('admin.report.creditBalance.index', $this->data);
    }


    public function getUsers( Request $request )
    {
        $role = $request->get('role');
        if ( ((int)$role) ) {
            $role  = Role::find($role);
            $users = User::with('roles','media','balance')->role($role->name)->latest()->get();
            if ( !blank($users) ) {
                $select = 'Select user';
                echo "<option value=''>" . $select . "</option>";
                foreach ( $users as $user ) {
                    if($user->phone) {
                        echo "<option value='" . $user->id . "'>" . $user->name .' '.'('.$user->phone.')'. "</option>";
                    } else {
                        echo "<option value='" . $user->id . "'>" . $user->name . "</option>";
                    }
                }
            }
        }
    }
}
