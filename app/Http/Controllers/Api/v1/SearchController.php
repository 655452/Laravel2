<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\CurrentStatus;
use App\Http\Resources\v1\PopularRestaurantResource;
use App\Models\TimeSlot;
use App\Enums\TableStatus;
use App\Models\Restaurant;
use App\Enums\PickupStatus;
use App\Enums\RatingStatus;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Enums\DeliveryStatus;
use App\Enums\RestaurantStatus;
use App\Models\RestaurantRating;
use App\Http\Services\RatingsService;
use App\Http\Services\RestaurantService;
use App\Http\Resources\v1\RatingResource;
use App\Http\Controllers\BackendController;
use App\Http\Resources\v1\MenuItemResource;
use App\Http\Resources\v1\RestaurantResource;


class SearchController extends BackendController
{
    use ApiResponse;
    protected  $restaurantService;

    public function __construct(RestaurantService $restaurantService)
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Restaurants';
        $this->middleware('auth:api');
        $this->restaurantService = $restaurantService;
    }
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $name = null;
        if (!blank($request->get('name'))) {
            $name = $request->get('name');
        }

        $expedition = null;
        if (!blank($request->get('expedition'))) {
            $expedition = $request->get('expedition');
        }
        try {
            $restaurants = $this->getallrestaurant($name, $expedition);
            return $this->successResponse(['status' => 200, 'data' => PopularRestaurantResource::collection($restaurants)]);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }


    public function getallrestaurant($name, $expedition)
    {
        $queryArray = [];
        $queryArray['status']=RestaurantStatus::ACTIVE;
        $queryArray['current_status']=CurrentStatus::YES;
        
        if (!blank($expedition)) {
            if ($expedition == 'delivery') {
                $queryArray['delivery_status'] = DeliveryStatus::ENABLE;
            } elseif ($expedition == 'pickup') {
                $queryArray['pickup_status'] = PickupStatus::ENABLE;
            } elseif ($expedition == 'table') {
                $queryArray['table_status'] = TableStatus::ENABLE;
            }
        }


        $current_time = now()->format('H:i');

        if (!blank($queryArray) && !blank($name)) {
            $restaurants = Restaurant::where([['opening_time', '>', 'closing_time'],['opening_time', '<', $current_time]])
            ->Orwhere([['opening_time', '<', 'closing_time'],['opening_time', '<', $current_time],['closing_time', '>', $current_time]])
            ->where($queryArray)->where('name', 'like', '%' . $name . '%')
            ->descending()->select()->get();
        } elseif (!blank($expedition)) {
            $restaurants = Restaurant::where([['opening_time', '>', 'closing_time'],['opening_time', '<', $current_time]])
            ->Orwhere([['opening_time', '<', 'closing_time'],['opening_time', '<', $current_time],['closing_time', '>', $current_time]])
            ->where($queryArray)
            ->descending()->select()->get();
        } elseif (!blank($name)) {
            $restaurants = Restaurant::where('name', 'like', '%' . $name . '%')
            ->where([['opening_time', '>', 'closing_time'],['opening_time', '<', $current_time]])
            ->Orwhere([['opening_time', '<', 'closing_time'],['opening_time', '<', $current_time],['closing_time', '>', $current_time]])
            ->descending()->select()->get();
        } else {
            $restaurants = Restaurant::where([['opening_time', '>', 'closing_time'],['opening_time', '<', $current_time]])
            ->Orwhere([['opening_time', '<', 'closing_time'],['opening_time', '<', $current_time],['closing_time', '>', $current_time]])
            ->where($queryArray)
            ->descending()->select()->get();
        }

        return  $restaurants;
    }
}
