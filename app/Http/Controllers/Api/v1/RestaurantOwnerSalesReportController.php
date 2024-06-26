<?php

namespace App\Http\Controllers\Api\v1;


use App\Models\Order;
use App\Models\Restaurant;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BackendController;


class RestaurantOwnerSalesReportController extends BackendController
{
    use ApiResponse;

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Restaurant Owner Sales Report';
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

            $queryArray = [];
            if ((int) $request->restaurant_id) {
                $restaurant_id               = $request->restaurant_id;
                $queryArray['restaurant_id'] = $restaurant_id;
            }

            $dateBetween = [];
            if ($request->from_date != '' && $request->to_date != '') {
                $dateBetween['from_date'] = date('Y-m-d', strtotime($request->from_date)) . ' 00:00:00';
                $dateBetween['to_date']   = date('Y-m-d', strtotime($request->to_date)) . ' 23:59:59';
            }

            if (!blank($dateBetween)) {
                $this->data['orders'] = Order::where($queryArray)->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->orderowner()->get();
            } else {
                $this->data['orders'] = Order::where($queryArray)->orderowner()->get();
            }
        }
        return $this->successresponse(['status' => 200, 'data' => $this->data]);
    }
}
