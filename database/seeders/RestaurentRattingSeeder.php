<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\Status;
use App\Models\RestaurantRating;

class RestaurentRattingSeeder extends Seeder
{
    public array $restaurentRattings = [
        [
            'user_id'       => "5",
            'restaurant_id' => "1",
            'rating'        => "3",
            'review'        => "Good food and good place. love it.",
            'status'        => Status::ACTIVE,
            'creator_type'  => "App\Models\User",
            'creator_id'    => "5",
            'editor_type'   => "App\Models\User",
            'editor_id'     => "5",
        ],
        [
            'user_id'       => "15",
            'restaurant_id' => "1",
            'rating'        => "4",
            'review'        => "Delicious food provider.",
            'status'        => Status::ACTIVE,
            'creator_type'  => "App\Models\User",
            'creator_id'    => "5",
            'editor_type'   => "App\Models\User",
            'editor_id'     => "5",
        ],
        [
            'user_id'       => "5",
            'restaurant_id' => "2",
            'rating'        => "3",
            'review'        => "Good Food",
            'status'        => Status::ACTIVE,
            'creator_type'  => "App\Models\User",
            'creator_id'    => "5",
            'editor_type'   => "App\Models\User",
            'editor_id'     => "5",
        ],
        [
            'user_id'       => "5",
            'restaurant_id' => "4",
            'rating'        => "5",
            'review'        => "Noodle Haven's miso ramen is a flavor symphony. The broth is rich, noodles perfectly cooked, and the pork belly is heavenly. A must-try for ramen lovers!",
            'status'        => Status::ACTIVE,
            'creator_type'  => "App\Models\User",
            'creator_id'    => "5",
            'editor_type'   => "App\Models\User",
            'editor_id'     => "5",
        ],
        [
            'user_id'       => "5",
            'restaurant_id' => "5",
            'rating'        => "5",
            'review'        => "Addis Spice Palace delivers an authentic Ethiopian experience. The injera is a delight, and the spices transport you to another world. A flavorful journey not to be missed.",
            'status'        => Status::ACTIVE,
            'creator_type'  => "App\Models\User",
            'creator_id'    => "5",
            'editor_type'   => "App\Models\User",
            'editor_id'     => "5",
        ],
        [
            'user_id'       => "5",
            'restaurant_id' => "6",
            'rating'        => "4",
            'review'        => "Spice Odyssey offers an interesting Ethiopian experience. While the injera was authentic and flavorful, some dishes fell flat. The inconsistency left me undecided.",
            'status'        => Status::ACTIVE,
            'creator_type'  => "App\Models\User",
            'creator_id'    => "5",
            'editor_type'   => "App\Models\User",
            'editor_id'     => "5",
        ],
        [
            'user_id'       => "5",
            'restaurant_id' => "7",
            'rating'        => "2",
            'review'        => "Slurp Spot's ramen left me wanting. The broth lacked depth, and the noodles were overcooked. Even the pork belly couldn't save it. Disappointing for a ramen enthusiast.",
            'status'        => Status::ACTIVE,
            'creator_type'  => "App\Models\User",
            'creator_id'    => "5",
            'editor_type'   => "App\Models\User",
            'editor_id'     => "5",
        ],
        [
            'user_id'       => "5",
            'restaurant_id' => "3",
            'rating'        => "5",
            'review'        => "Tacos Al Fresco is a street food dream. The tacos are a burst of authentic flavors, with perfectly grilled meats and a salsa bar that adds a personal touch. A fiesta for your taste buds!",
            'status'        => Status::ACTIVE,
            'creator_type'  => "App\Models\User",
            'creator_id'    => "5",
            'editor_type'   => "App\Models\User",
            'editor_id'     => "5",
        ],
        [
            'user_id'       => "1",
            'restaurant_id' => "1",
            'rating'        => "4",
            'review'        => "Nice food and good enviorenment.",
            'status'        => Status::ACTIVE,
            'creator_type'  => "App\Models\User",
            'creator_id'    => "5",
            'editor_type'   => "App\Models\User",
            'editor_id'     => "5",
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->restaurentRattings as $restaurentRatting) {
                RestaurantRating::create([
                    'user_id'       => $restaurentRatting['user_id'],
                    'restaurant_id' => $restaurentRatting['restaurant_id'],
                    'rating'        => $restaurentRatting['rating'],
                    'review'        => $restaurentRatting['review'],
                    'status'        => $restaurentRatting['status'],
                    'creator_type'  => $restaurentRatting['creator_type'],
                    'creator_id'    => $restaurentRatting['creator_id'],
                    'editor_type'   => $restaurentRatting['editor_type'],
                    'editor_id'     => $restaurentRatting['editor_id'],
                ]);
            }
        }
    }
}
