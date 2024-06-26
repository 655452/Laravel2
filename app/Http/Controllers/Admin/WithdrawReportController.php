<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\Withdraw;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;

class WithdrawReportController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Withdraw Report';
        $this->middleware(['permission:withdraw-report'])->only('index');
    }

    public function index(Request $request)
    {

        $this->data['showView']      = false;
        $this->data['set_user_id']   = '';
        $this->data['set_from_date'] = '';
        $this->data['set_to_date']   = '';

        $this->data['users'] = User::role([
            UserRole::RESTAURANTOWNER,
            UserRole::DELIVERYBOY
        ])->latest()->get();

        if ($_POST) {

            $request->validate([
                'user_id'   => 'numeric',
                'from_date' => 'nullable|date',
                'to_date'   => 'nullable|date|after_or_equal:from_date',
            ]);

            $this->data['showView']      = true;
            $this->data['set_user_id']   = $request->user_id;
            $this->data['set_from_date'] = $request->from_date;
            $this->data['set_to_date']   = $request->to_date;


            $user_id               = $request->user_id;
            $queryArray['user_id'] = $user_id;

            $dateBetween = [];
            if ($request->from_date != '' && $request->to_date != '') {
                $dateBetween['from_date'] = date('Y-m-d', strtotime($request->from_date)) . ' 00:00:00';
                $dateBetween['to_date']   = date('Y-m-d', strtotime($request->to_date)) . ' 23:59:59';
            }

            if ($user_id && !blank($dateBetween)) {
                $this->data['withdraws'] = Withdraw::with('user')->where($queryArray)->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->get();
            } elseif ($user_id) {
                $this->data['withdraws'] = Withdraw::with('user')->where($queryArray)->get();
            } elseif (!blank($dateBetween)) {
                $this->data['withdraws'] = Withdraw::with('user')->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->get();
            } else {
                $this->data['withdraws'] = Withdraw::with('user')->latest()->get();
            }
        }
        return view('admin.report.withdrawreport.index', $this->data);
    }


}
