<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\BackendController;
use App\Models\Restaurant;
use App\Traits\ApiResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminCommissionReportController extends BackendController
{
    use ApiResponse;
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Admin Commission Report';
    }

    public function index(Request $request)
    {
        $this->data['showView']      = false;
        $this->data['set_restaurant_id']   = '';
        $this->data['set_from_date'] = '';
        $this->data['set_to_date']   = '';

        $this->data['restaurants'] = Restaurant::restaurantowner()->get();


        if ($_POST) {

            $request->validate([
                'restaurant_id'   => 'required|numeric',
                'from_date' => 'nullable|date',
                'to_date'   => 'nullable|date|after_or_equal:from_date',
            ]);

            $this->data['showView']      = true;
            $this->data['set_restaurant_id']   = $request->restaurant_id;
            $this->data['set_from_date'] = $request->from_date;
            $this->data['set_to_date']   = $request->to_date;

            if ((int) $request->restaurant_id) {
                $restaurant_id = $request->restaurant_id;
            }

            $dateBetween = [];
            if ($request->from_date != '' && $request->to_date != '') {
                $dateBetween['from_date'] = date('Y-m-d', strtotime($request->from_date)) . ' 00:00:00';
                $dateBetween['to_date']   = date('Y-m-d', strtotime($request->to_date)) . ' 23:59:59';
            }

            if (!blank($dateBetween)) {
                $transactions = Transaction::where(['source_balance_id' => 1])->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->get();
            } else {
                $transactions = Transaction::where(['source_balance_id' => 1])->get();
            }

            $this->data['transactions'] = [];
            if($transactions) {
                foreach ($transactions as $key => $transaction) {
                    if(isset($transaction->meta['restaurant_id']) && ($transaction->meta['restaurant_id'] == $restaurant_id)) {
                        $this->data['transactions'][] = $transaction;
                    }
                }
            }
        }

        return $this->successresponse(['status'=>200,'data'=>$this->data]);
    }

}
