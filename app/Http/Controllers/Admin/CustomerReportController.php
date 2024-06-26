<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CustomerReportController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'user Report';

        $this->middleware(['permission:customer-report'])->only('index');

    }

    public function index(Request $request)
    {
        $this->data['showView']      = false;
        $this->data['set_user_id']   = '';
        $this->data['set_from_date'] = '';
        $this->data['set_to_date']   = '';
        $role                = Role::find(2);
        $this->data['users'] = User::role($role->name)->latest()->get();

        if ($_POST) {

            $request->validate([
                'user_id'   => 'nullable|numeric',
                'from_date' => 'nullable|date',
                'to_date'   => 'nullable|date|after_or_equal:from_date',
            ]);
            $this->data['showView']      = true;
            $this->data['set_user_id'] = $request->user_id;
            $this->data['set_from_date'] = $request->from_date;
            $this->data['set_to_date']   = $request->to_date;

            $user_id                   = $request->user_id;

            $dateBetween = [];
            if ($request->from_date != '' && $request->to_date != '') {
                $dateBetween['from_date'] = date('Y-m-d', strtotime($request->from_date)) . ' 00:00:00';
                $dateBetween['to_date']   = date('Y-m-d', strtotime($request->to_date)) . ' 23:59:59';
            }

            if($user_id && !blank($dateBetween)) {
                $role                = Role::find(2);
                $this->data['userdetails'] = User::with('orders','balance')->role($role->name)->where('id', $user_id)->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->latest()->get();
            } elseif($user_id) {
                $role                = Role::find(2);
                $this->data['userdetails'] = User::with('orders','balance')->role($role->name)->where('id', $user_id)->latest()->get();
            } elseif( !blank($dateBetween)){
                $role                = Role::find(2);
                $this->data['userdetails'] = User::with('orders','balance')->role($role->name)->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->latest()->get();
            }else{
                $role                = Role::find(2);
                $this->data['userdetails'] = User::with('orders','balance')->role($role->name)->latest()->get();
            }

        }
        return view('admin.report.customerReport.index', $this->data);
    }

    public function pdf($set_user_id, $set_from_date = '', $set_to_date = '')
    {
        $this->data['showView']      = true;
        $this->data['set_user_id']   = $set_user_id;
        $this->data['set_from_date'] = $set_from_date;
        $this->data['set_to_date']   = $set_to_date;

        if ((int) $set_user_id) {
            $user_id = $set_user_id;
        }

        $dateBetween = [];
        if ($set_from_date != '' && $set_to_date != '') {
            $dateBetween['from_date'] = date('Y-m-d', strtotime($set_from_date)) . ' 00:00:00';
            $dateBetween['to_date']   = date('Y-m-d', strtotime($set_to_date)) . ' 23:59:59';
        }

        if($user_id) {
            $role                = Role::find(2);
            $this->data['userdetails'] = User::role($role->name)->where('id', $user_id)->latest()->get();
        } elseif( !blank($dateBetween)){
            $role                = Role::find(2);
            $this->data['userdetails'] = User::role($role->name)->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->latest()->get();
        }else{
            $role                = Role::find(2);
            $this->data['userdetails'] = User::role($role->name)->latest()->get();
        }

        $pdf = PDF::loadView('admin.report.customerReport.pdf', $this->data);
        return $pdf->download('customerreport-' . date('d-M-Y H:i A') . '.pdf');
    }
}
