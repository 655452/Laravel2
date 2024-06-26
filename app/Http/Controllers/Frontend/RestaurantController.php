<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Discount;
use App\Models\MenuItem;
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
        foreach ($products as $product) {
            $product_categories = $product->categories;
            if (!blank($product_categories)) {
                foreach ($product_categories as $product_category) {
                    $categories[$product_category->id]            = $product_category;
                    $categories_products[$product_category->id][] = $product;
                }
            } else {
                $other_products[] = $product;
            }
        }
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

}
