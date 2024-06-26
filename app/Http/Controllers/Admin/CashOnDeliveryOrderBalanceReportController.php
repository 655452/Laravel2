<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\DeliveryBoyAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CashOnDeliveryOrderBalanceReportController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Cash On delivery Order Balance Report';
        $this->middleware([ 'permission:cash-on-delivery-order-balance-report' ])->only('index');
    }

    public function index( Request $request )
    {
        $this->data['showView']    = false;
        $this->data['set_user_id'] = '';
        $role                      = Role::find(4);
        $this->data['users']       = User::role($role->name)->latest()->get();
        if ( $_POST ) {
            $request->validate([
                'user_id' => 'nullable|numeric',
            ]);
            $this->data['showView']    = true;
            $this->data['set_user_id'] = $request->user_id;
            if ( $request->user_id ) {
                $this->data['deliveryBoyAccounts'] = DeliveryBoyAccount::where('user_id', (int)$request->user_id)->latest()->get();
            } else {
                $this->data['deliveryBoyAccounts'] = DeliveryBoyAccount::all();
            }
        }
        return view('admin.report.cashDeliveryOrderBalance.index', $this->data);
    }
}
