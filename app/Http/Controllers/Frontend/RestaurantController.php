<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Discount;
use App\Models\MenuItem;
// for menu items  rating  specially
use App\Models\MenuItemRating;
use App\Http\Requests\MenuItemRatingRequest;
use App\Http\Services\MenuItemRatingsService;
use App\Enums\OrderStatus;
use App\Models\Restaurant;
use App\Enums\RatingStatus;
use App\Enums\DiscountStatus;
use App\Enums\MenuItemStatus;
use Illuminate\Support\Carbon;
use App\Models\RestaurantRating;

use Sopamo\LaravelFilepond\Filepond;
use App\Http\Requests\RatingsRequest;
use App\Http\Services\RatingsService;
use Illuminate\Support\Facades\Redirect;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Admin\UserController;
use DB;


 
class RestaurantController extends FrontendController
{
    protected $restaurant;
    protected $filepond;
    public function __construct(protected RatingsService $ratingsService, Filepond $filepond)
    {
        parent::__construct();
        $this->data['site_title'] = 'Frontend';
    }


    public function show(Restaurant $restaurant, Filepond $filepond)
    {
        $this->restaurant = $restaurant;
        $this->filepond   = $filepond;

        if (session('session_cart_restaurant_id') !=  $this->restaurant->id) {
            session()->forget('cart');
        }
        
        
    // Load the user (owner) relationship eagerly
    $restaurantWithOwner = $restaurant->load('user');  // Eager load the user

         // Log the restaurant owner information
    Log::info('Restaurant Owner Username: ' . json_encode($restaurantWithOwner->user));
       // log::info(UserController::show($restaurant->user_id));
        

        $this->loadCategoriesAndProducts();
        $this->loadRatings();
        $this->data['order_status'] = auth()->id() ? Order::where(['restaurant_id' => $this->restaurant->id, 'status' => OrderStatus::COMPLETED, 'user_id' => auth()->id()])->get() : [];
        $this->loadVouchers();
        $this->loadViewData();
        return view('frontend.restaurant.show', $this->data);
    }

    private function loadCategoriesAndProducts()
    {
        $categories          = [];
        $other_products      = [];
        $categories_products = [];
        
        

        $products            = MenuItem::with('categories')->with('media')->with('variations')->with('options')->where(['restaurant_id' => $this->restaurant->id])->where('status', MenuItemStatus::ACTIVE)->get();

    
    // $ratings = MenuItemRating::select('menu_item_id', \DB::raw('AVG(rating) as average_rating'), \DB::raw('GROUP_CONCAT(review SEPARATOR ", ") as total_reviews'))
    //     ->groupBy('menu_item_id')
    //     ->get()
    //     ->keyBy('menu_item_id'); // Key by menu_item_id for easy lookup

    // dd($ratings);
    foreach ($products as $product) {
      
            
   
            $product_categories = $product->categories;
            if (!blank($product_categories)) {
                foreach ($product_categories as $product_category) {
                    $categories[$product_category->id]            = $product_category;

                     // Add the product to the categories_products array
                $categories_products[$product_category->id][] = $product->toArray(); // Convert product to array first

              
                }
            } else {
                $other_products[] = $product;
            }
            
            Log::info('Updating under for loop', ['request' => $categories_products]);

        }
        // dd( $categories_products);
        Log::info('Updating menu item under updateMedia restaurant categories_product', ['request' => $categories_products]);
        Log::info('Updating menu item under updateMedia restaurant categories ', ['request' => $categories]);
        Log::info('Updating menu item under updateMedia restaurant  other products', ['request' => $other_products]);
        $this->data['categories']          = $categories;
        $this->data['other_products']      = $other_products;
        $this->data['categories_products'] = $categories_products;
    }


    private function loadRatings()
    {
        $this->data['ratings'] = RestaurantRating::with('user')
            ->where(['restaurant_id' => $this->restaurant->id, 'status' => RatingStatus::ACTIVE])
            ->paginate(5);

        $ratingInfo = $this->ratingsService->avgRating($this->restaurant->id);
        $this->data['rating_user_count'] = $ratingInfo['countUser'];
        $this->data['average_rating']    = $ratingInfo['avgRating'];
    }

    private function loadVouchers()
    {
        $today = date('Y-m-d h:i:s');
        $this->data['vouchers'] = [];
        $vouchers = Coupon::whereDate('to_date', '>', $today)
            ->where('restaurant_id', '=', $this->restaurant->id)
            ->whereDate('from_date', '<', $today)
            ->where('limit', '>', 0)->get();

        if (!blank($vouchers)) {
            $data = [];
            foreach ($vouchers as $voucher) {
                $total_used = Discount::where('coupon_id', $voucher->id)->where('status', DiscountStatus::ACTIVE)->count();
                if ($total_used < $voucher->limit) {
                    $data[] = $voucher;
                }
            }

            if (!blank($data)) {
                $this->data['vouchers']         = pluck($data, 'obj', 'restaurant_id');
            }
        }
    }


    private function loadViewData()
    {
        $this->data['restaurant']  = $this->restaurant;
        $this->data['qrCode']      = $this->qrCode();
        $this->data['currenttime'] = now()->format('H:i:s');
    }

    private function qrCode()
    {
        if ($this->restaurant) {
            $image = QrCode::size(480)->format('png')->margin(1)->encoding('UTF-8');

            if (isset($this->restaurant->qrCode)) {
                $colors = isset($this->restaurant->qrCode->color) ? explode(",", $this->restaurant->qrCode->color) : [0, 0, 0];
                $bgColors = isset($this->restaurant->qrCode->background_color) ? explode(",", $this->restaurant->qrCode->background_color) : [255, 255, 255];

                $image = $image
                    ->style($this->restaurant->qrCode->style ?? 'square')
                    ->eye($this->restaurant->qrCode->eye_style ?? 'square')
                    ->color(intval($colors[0]), intval($colors[1]), intval($colors[2]))
                    ->backgroundColor(intval($bgColors[0]), intval($bgColors[1]), intval($bgColors[2]));

                if ($this->restaurant->qrCode->mode == 'logo' && !blank($this->restaurant->qrCode->qrcode_logo)) {
                    $path = $this->filepond->getPathFromServerId($this->restaurant->qrCode->qrcode_logo);
                    $image = $image->merge($path, .2, true);
                }
            }

            $image = $image->generate(route('restaurant.show', $this->restaurant->slug));
            return base64_encode($image);
        }
    }

    public function Ratings(RatingsRequest $request)
    {
        // dd($request);
        $restaurantRating = RestaurantRating::with('user')->where([
            'user_id' => auth()->id(),
            'restaurant_id' => $request->restaurant_id
        ])->first();

        if ($restaurantRating) {
            $restaurantRating->rating = $request->rating;
            $restaurantRating->review = $request->review;
            $restaurantRating->save();
            return Redirect::back()->withSuccess('The Data Update Successfully');
        } else {
            $restaurantRating = new RestaurantRating;
            $restaurantRating->user_id = auth()->id();
            $restaurantRating->restaurant_id = $request->restaurant_id;
            $restaurantRating->rating = $request->rating;
            $restaurantRating->review = $request->review;
            $restaurantRating->status = $request->status;
            $restaurantRating->save();
            return Redirect::back()->withSuccess('The Data Inserted Successfully');
        }
    }
    // for menu item  ratings
    public function ItemRatings(MenuItemRatingRequest $request)
    {
        // dd($request);
        $menuItemRating = MenuItemRating::with('user')->where([
            'user_id' => auth()->id(),
            'menu_item_id' => $request->menu_item_id
        ])->first();

        if ($menuItemRating) {
            $menuItemRating->rating = $request->rating;
            $menuItemRating->review = $request->review;
            $menuItemRating->save();
            return Redirect::back()->withSuccess('The Data Updated Successfully');
        } else {
            $menuItemRating = new MenuItemRating;
            $menuItemRating->user_id = auth()->id();
            $menuItemRating->menu_item_id = $request->menu_item_id;
            $menuItemRating->rating = $request->rating;
            $menuItemRating->review = $request->review;
            $menuItemRating->status = $request->status;
            $menuItemRating->save();
            return Redirect::back()->withSuccess('The Data Inserted Successfully');
        }
    }

}
