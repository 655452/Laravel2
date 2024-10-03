<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Enums\Status;
use App\Models\Cuisine;
use App\Enums\TableStatus;
use App\Models\Restaurant;
use App\Enums\PickupStatus;
use Illuminate\Http\Request;
use App\Enums\DeliveryStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Services\RatingsService;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Log; // for logging
use App\Models\MenuItem;
// for menu items  rating  specially
use App\Models\MenuItemRating;

class SearchController extends FrontendController
{
    protected $expeditionMap;

    public function __construct(protected RatingsService $ratingService)
    {
        parent::__construct();
        $this->data['site_title'] = 'Search Restaurants';
        $this->expeditionMap = [
            'delivery' => DeliveryStatus::ENABLE,
            'pickup' => PickupStatus::ENABLE,
            'table' => TableStatus::ENABLE,
        ];
    }

   
    public function filter(Request $request)
{
    $expedition = $request->get('expedition');

    // Log request parameters
    Log::info('Restaurant search initiated.', [
        'username' => $request->get('username'),
        'lat' => $request->get('lat'),
        'long' => $request->get('long'),
        'distance' => $request->get('distance'),
        'query' => $request->get('query'),
        'cuisines' => $request->get('cuisines'),
    ]);

    // Base query for searching restaurants
    $restaurants = Restaurant::query()
        ->with(['media', 'ratings', 'menuItems.media', 'menuItems.ratings']) // Load menuItems with media and ratings
        ->where(['status' => Status::ACTIVE, 'current_status' => Status::ACTIVE]);

    // Filter by cuisines
    if (!blank($request->get('cuisines'))) {
        $cuisineSlugs = $request->get('cuisines');
        $restaurants->whereHas('cuisines', function ($query) use ($cuisineSlugs) {
            $query->whereIn('slug', $cuisineSlugs);
        });
    }

    // Filter by search query (restaurant name or menu item)
    $menuItems = collect(); // Collection for storing menu item results
    if (!blank($request->get('query'))) {
        $query = $request->get('query');

        // Search by restaurant name or menu item name
        $restaurants->where(function ($restaurantQuery) use ($query) {
            $restaurantQuery->where('name', 'like', '%' . $query . '%') // Search by restaurant name
                ->orWhereHas('menuItems', function ($menuItemQuery) use ($query) {
                    $menuItemQuery->where('name', 'like', '%' . $query . '%'); // Search by menu item name
                });
        });

        // Also search menu items separately to get specific menu item results
        $menuItems = MenuItem::with(['media', 'ratings']) // Load menu item media and ratings
            ->where('name', 'like', '%' . $query . '%')
            ->get();
    }

    // Filter by expedition type (delivery, pickup, table)
    if (array_key_exists($expedition, $this->expeditionMap)) {
        $statusColumn = $expedition . '_status';
        $status = $this->expeditionMap[$expedition];
        $restaurants->where($statusColumn, $status);
    }

    // Filter by location (latitude and longitude) and distance
    if (!blank($request->get('lat')) && !blank($request->get('long'))) {
        $lat = $request->get('lat');
        $long = $request->get('long');
        $distance = $request->get('distance') ?? setting('geolocation_distance_radius');

        $restaurants->select(DB::raw('*, ( 6367 * acos( cos( radians(' . $lat . ') ) * cos( radians( `lat` ) ) * cos( radians( `long` ) - radians(' . $long . ') ) + sin( radians(' . $lat . ') ) * sin( radians( `lat` ) ) ) ) AS distance'))
            ->having('distance', '<', $distance)
            ->orderBy('distance');
    }

    // Get the results for both restaurants and menu items for the map
    $mapRestaurants = $restaurants->get()->map(function ($restaurant) {
        return [
            'name' => $restaurant->name,
            'slug' => $restaurant->slug,
            'image' => $restaurant->image,
            'logo' => $restaurant->logo,
            'lat' => $restaurant->lat,
            'long' => $restaurant->long,
            'address' => $restaurant->address,
            'url' => route('restaurant.show', [$restaurant]),
        ];
    })->all();

    // Paginate the restaurant results
    $restaurants = $restaurants->paginate(8);

    // Pass data to the view
    $this->data['cuisines'] = Cuisine::select('id', 'name', 'slug')->orderBy('name', 'desc')->get();
    $this->data['restaurants'] = $restaurants;
    $this->data['menuItems'] = $menuItems; // Include menu items in data
    $this->data['mapRestaurants'] = $mapRestaurants;
    $this->data['current_data'] = Carbon::now()->format('H:i:s');

    // If the request is AJAX, return JSON response for load more functionality
    if ($request->ajax()) {
        return response()->json([
            'restaurants' => view('frontend.restaurant.search-restaurant', compact('restaurants', 'menuItems', 'current_data'))->render(),
            'next_page_url' => $restaurants->nextPageUrl(),
        ]);
    }

    return view('frontend.search', $this->data);
}


}
