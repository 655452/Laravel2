<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\Collection;
use App\Models\Order;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class CollectionReportController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Delivery Boy Collection Report';
        $this->middleware(['permission:delivery-boy-collection-report'])->only('index');
    }

    public function index(Request $request)
    {

        $this->data['showView']      = false;
        $this->data['set_user_id']   = '';
        $this->data['set_from_date'] = '';
        $this->data['set_to_date']   = '';

        $role                = Role::find(4);
        $this->data['users'] = User::role($role->name)->latest()->get();

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
                $this->data['collections'] = Collection::with('user')->CollectionOwner()->where($queryArray)->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->get();
            } elseif ($user_id) {
                $this->data['collections'] = Collection::with('user')->CollectionOwner()->where($queryArray)->get();
            } elseif (!blank($dateBetween)) {
                $this->data['collections'] = Collection::with('user')->CollectionOwner()->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->get();
            } else {
                $this->data['collections'] = Collection::with('user')->CollectionOwner()->latest()->get();
            }
        }
        return view('admin.report.collectionreport.index', $this->data);
    }

    public function pdf($set_shop_id, $set_from_date = '', $set_to_date = '')
    {
        $this->data['showView']      = true;
        $this->data['set_shop_id']   = $set_shop_id;
        $this->data['set_from_date'] = $set_from_date;
        $this->data['set_to_date']   = $set_to_date;

        $queryArray = [];
        if ((int) $set_shop_id) {
            $shop_id               = $set_shop_id;
            $queryArray['shop_id'] = $shop_id;
        }

        $dateBetween = [];
        if ($set_from_date != '' && $set_to_date != '') {
            $dateBetween['from_date'] = date('Y-m-d', strtotime($set_from_date)) . ' 00:00:00';
            $dateBetween['to_date']   = date('Y-m-d', strtotime($set_to_date)) . ' 23:59:59';
        }

        if (!blank($dateBetween)) {
            $this->data['orders'] = Order::where($queryArray)->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->orderOwner()->get();
        } else {
            $this->data['orders'] = Order::where($queryArray)->orderOwner()->get();
        }


        $pdf = PDF::loadView('admin.report.shopownersales.pdf', $this->data);
        return $pdf->download('shopownersalesreport-' . date('d-M-Y H:i A') . '.pdf');
    }
}
