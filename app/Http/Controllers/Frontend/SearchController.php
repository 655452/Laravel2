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

        $restaurants = Restaurant::query()
            ->with('media', 'ratings') // Load media and ratings relationships
            ->where(['status' => Status::ACTIVE, 'current_status' => Status::ACTIVE]);

        // Filter by cuisinesas
        if (!blank($request->get('cuisines'))) {
            $cuisineSlugs = $request->get('cuisines');
            $restaurants->whereHas('cuisines', function ($query) use ($cuisineSlugs) {
                $query->whereIn('slug', $cuisineSlugs);
            });
        }

        // Filter by search query
        if (!blank($request->get('query'))) {
            $query = $request->get('query');
            $restaurants->where('name', 'like', '%' . $query . '%');
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

        // Sort by ratings
        // $restaurants = $restaurants->leftJoin('ratings', 'restaurants.id', '=', 'ratings.restaurant_id')
        //     ->select('restaurants.*', DB::raw('AVG(ratings.rating) as avg_rating'))
        //     ->groupBy('restaurants.id')
        //     ->orderBy('avg_rating', 'desc'); // Sort by average rating

        // Get restaurants for the map
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
                // 'avg_rating' => $restaurant->avg_rating, // Include rating
            ];
        })->all();

        // Paginate the results
        $restaurants = $restaurants->paginate(8);

        // Pass data to the view
        $this->data['cuisines'] = Cuisine::select('id', 'name', 'slug')->orderBy('name', 'desc')->get();
        $this->data['restaurants'] = $restaurants;
        $this->data['mapRestaurants'] = $mapRestaurants;
        $this->data['current_data'] = Carbon::now()->format('H:i:s');

        // If the request is AJAX, return JSON response for load more functionality
        if ($request->ajax()) {
            return response()->json([
                'restaurants' => view('frontend.restaurant.search-restaurant', compact('restaurants', 'current_data'))->render(),
                'next_page_url' => $restaurants->nextPageUrl()
            ]);
        }

        return view('frontend.search', $this->data);
    }
}
