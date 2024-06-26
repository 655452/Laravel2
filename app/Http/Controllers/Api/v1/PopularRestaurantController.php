<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\CurrentStatus;
use App\Enums\RestaurantStatus;
use App\Http\Resources\v1\PopularRestaurantResource;
use App\Models\Restaurant;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BackendController;

class PopularRestaurantController extends BackendController
{
    use ApiResponse;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api');

    }
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $current_time = now()->format('H:i');

        $bestSellingRestaurants  = Restaurant::leftJoin('orders', 'restaurant_id', '=', 'restaurants.id')
            ->select('restaurants.id', 'restaurants.name', 'restaurants.slug','restaurants.description','restaurants.address','restaurants.address')
            ->selectRaw('count("orders.id") as orders_count')
            ->groupBy('restaurants.id')
            ->orderBy('orders_count', 'desc')
            ->where('restaurants.status', RestaurantStatus::ACTIVE)
            ->where('restaurants.current_status', CurrentStatus::YES)
            ->where([['opening_time', '>', 'closing_time'],['opening_time', '<', $current_time]])
            ->Orwhere([['opening_time', '<', 'closing_time'],['opening_time', '<', $current_time],['closing_time', '>', $current_time]])
            ->get();
        try{

            return $this->successResponse(['status'=> 200, 'data' =>  PopularRestaurantResource::collection(($bestSellingRestaurants))]);
        } catch (\Exception $e){
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }

    }


}
