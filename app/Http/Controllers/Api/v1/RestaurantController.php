<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Discount;
use App\Models\TimeSlot;
use App\Enums\OrderStatus;
use App\Models\Restaurant;
use App\Enums\RatingStatus;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Enums\DiscountStatus;
use App\Models\RestaurantRating;
use App\Http\Services\RatingsService;
use App\Http\Services\RestaurantService;
use App\Http\Resources\v1\CouponResource;
use App\Http\Resources\v1\RatingResource;
use App\Http\Controllers\BackendController;
use App\Http\Resources\v1\MenuItemResource;
use App\Http\Resources\v1\RestaurantResource;
use Illuminate\Support\Facades\Log;
use App\Models\MenuItem;
use App\Models\MenuItemRating;
use App\Http\Resources\v1\UserResource; // Import the resource for user data

class RestaurantController extends BackendController
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
    public function index($id = null, $status = null, $applied = null)
    {
        try {
            $restaurants = $this->restaurantService->getallrestaurant($id, $status, $applied);
            return $this->successResponse(['status' => 200, 'data' => RestaurantResource::collection($restaurants)]);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }


    public function show($id)
    {
        $this->data['restaurant'] = Restaurant::with('media')->findOrFail($id);
        $this->data['restaurantX'] = Restaurant::with(['media','user'])->findOrFail($id);
        

         Log::info('show under for restaurant  menu items', ['request' => $this->data['restaurant']]);
        $rating      = new RatingsService();
        $ratingArray = $rating->avgRating($this->data['restaurant']->id);
        $RestaurantRatings = RestaurantRating::where(['restaurant_id' => $this->data['restaurant']->id, 'status' => RatingStatus::ACTIVE])->get();
        $this->data['timeSlots'] = TimeSlot::where(['restaurant_id' => $this->data['restaurant']->id])->get();

        $this->data['restaurant'] = new RestaurantResource($this->data['restaurant']);
//      Log::info('show only  menu items', ['request' => $this->data['restaurant']->menuItems]);
        $this->data['menuItems'] = MenuItemResource::collection($this->data['restaurant']->menuItems);

            // Fetch and process menu items with ratings and reviews
    $this->data['menuItemsX'] = MenuItem::with('media')
        ->with('categories')
        ->where(['restaurant_id' => $id])
        ->get();

    // Fetch ratings and reviews for menu items
    $menuItemRatings = MenuItemRating::with('user')
        ->whereIn('menu_item_id', $this->data['menuItemsX']->pluck('id'))
        ->where('status', RatingStatus::ACTIVE)
        ->get()
        ->groupBy('menu_item_id');

    // Attach ratings and reviews to menu items
    foreach ($this->data['menuItemsX'] as $menuItem) {
        $menuItem->ratings = $menuItemRatings->get($menuItem->id, collect());
        $menuItem->average_rating = $menuItem->ratings->avg('rating');
        $menuItem->total_reviews = $menuItem->ratings->count();
    }


        Log::info('show only  menu itemsX', ['request' => $this->data['menuItemsX']]);
        $this->data['reviews']    = RatingResource::collection($RestaurantRatings);
        $this->data['countUser']   = $ratingArray['countUser'];
        $this->data['avgRating']   = $ratingArray['avgRating'];



        $this->data['vouchers'] = [];
        $today = date('Y-m-d h:i:s');
        $vouchers = Coupon::whereDate('to_date', '>', $today)
            ->where('restaurant_id', '=', $this->data['restaurant']->id)
            ->whereDate('from_date', '<', $today)
            ->where('limit', '>', 0)->get();
        if (!blank($vouchers)) {
            $data = [];
            foreach ($vouchers as $voucher) {
                $total_used = Discount::where('coupon_id', $voucher->id)->where('status', \App\Enums\DiscountStatus::ACTIVE)->count();
                if ($total_used < $voucher->limit) {
                    $data[] = $voucher;
                }
            }
            if (!blank($data)) {
                $this->data['vouchers']         = CouponResource::collection($data);
            }
        }

        if (auth()->user()) {
            $order = Order::where([
                'restaurant_id' => $id,
                'status'        => OrderStatus::COMPLETED,
                'user_id'       => auth()->user()->id
            ])->get();
        } else {
            $order = [];
        }
        $this->data['order_status']        = !blank($order);

        try {
                Log::info('show under for menu items', ['request' => $this->data]);
            return $this->successResponse(['status' => 200, 'data' => $this->data]);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }


                        public function getStaticMenuItem()
{
    // Define the static array of menu item names
    $staticMenuItemNames = [
        'Ragi Brownies (min 4 pc)',
        'Motichoor Tart',
        'Dream Tin Cake',
        'Mini Grazing Box Hamper',
        'Date & Walnut cake',
        'Wheat Stawberry Tart',
        'Miniature tartlets (Min 4 pc)',
        'Rakhi',
        'Demo1',
        'Demo2',
        'Demo3',
    ];

    try {
        // Query the menu_items table for items with the specified names
       $this->data['menuitems']=MenuItemResource::collection(MenuItem::with('media')->whereIn('name', $staticMenuItemNames)->get());
        $this->data['menuItemsX'] =MenuItem::with('media')->with('ratings.user')->with('categories')->whereIn('name', $staticMenuItemNames)->get();
        

                 // Query the menu_items table for items with the specified names
        $menuItems = MenuItem::with('media')
            ->whereIn('name', $staticMenuItemNames)
            ->get();

        // Fetch ratings and reviews for each menu item
        $menuItemRatings = MenuItemRating::whereIn('menu_item_id', $menuItems->pluck('id'))
            ->where('status', RatingStatus::ACTIVE)
            ->get()
            ->groupBy('menu_item_id');

        // Attach ratings and reviews to menu items
        foreach ($menuItems as $menuItem) {
            $menuItem->ratings = $menuItemRatings->get($menuItem->id, collect());
            $menuItem->average_rating = $menuItem->ratings->avg('rating');
            $menuItem->total_reviews = $menuItem->ratings->count();
        }
        Log::info('show get ratings for menu items', ['request' => $menuItems]);
       // $this->data['menuItems'] = MenuItemResource::collection($menuItems);
         $this->data['menuItems'] = $menuItems;
        // Return the data as a JSON response using the MenuItemResource
                 Log::info('showget static  for menu items', ['request' =>  $this->data['menuItems']]);
                 Log::info('showget static  for menu items', ['request' =>  $this->data['menuitems']]);
                 Log::info('showget static  for menu items', ['request' =>  $this->data['menuItemsX']]);
        return $this->successResponse([
            'status' => 200,
            'data' => $this->data,
        ]);
    } catch (\Exception $e) {
        // Handle any exceptions that occur during the query
        return response()->json([
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'trace' => $e->getTrace(),
        ]);
    }
}

}