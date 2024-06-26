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

    public function filter(Request $request){ 
        $expedition = $request->get('expedition');

        $restaurants = Restaurant::query()
            ->with('media')
            ->where(['status' => Status::ACTIVE, 'current_status' => Status::ACTIVE]);

        if (!blank($request->get('cuisines'))) {
            $cuisineSlugs = $request->get('cuisines');
            $restaurants->whereHas('cuisines', function ($query) use ($cuisineSlugs) {
                $query->whereIn('slug', $cuisineSlugs);
            });
        }

        if (!blank($request->get('query'))) {
            $query = $request->get('query');
            $restaurants->where('name', 'like', '%' . $query . '%');
        }

        if (array_key_exists($expedition, $this->expeditionMap)) {
            $statusColumn = $expedition . '_status';
            $status = $this->expeditionMap[$expedition];
            $restaurants->where($statusColumn, $status);
        }

        if(!blank($request->get('lat')) && !blank($request->get('long'))) {
            $restaurants->where(['status' => 5])
            ->select(DB::raw('*, ( 6367 * acos( cos( radians('.$request->get('lat').') ) * cos( radians( `lat` ) ) * cos( radians( `long` ) - radians('.$request->get('long').') ) + sin( radians('.$request->get('lat').') ) * sin( radians( `lat` ) ) ) ) AS distance'))
                ->having('distance', '<', $request->get('distance') ?? setting('geolocation_distance_radius'))
                ->orderBy('distance');
        }

        $mapRestaurants = [];

        $mapRestaurants = $restaurants->with('media')->get()->map(function ($restaurant) {
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

        $this->data['cuisines'] = Cuisine::select('id', 'name', 'slug')->orderBy('name', 'desc')->get();
        $this->data['restaurants'] = $restaurants->paginate(8)->appends(request()->query());
        $this->data['mapRestaurants'] = $mapRestaurants;
        $this->data['current_data'] = Carbon::now()->format('H:i:s');
        return view('frontend.search', $this->data);
    }
}
