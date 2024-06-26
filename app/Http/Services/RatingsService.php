<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 5/3/20
 * Time: 11:25 AM
 */

namespace App\Http\Services;

use App\Enums\RatingStatus;
use App\Models\RestaurantRating;

class RatingsService
{

    public function avgRating($restaurantID)
    {
        $RestaurantRatings = RestaurantRating::where(['restaurant_id' => $restaurantID, 'status' => RatingStatus::ACTIVE])->get();

        $authID = auth()->id();

        $countUser = 0;
        $avgRating = 0;

        $myRatingArray    = [];
        $myRatingArray[0] = [];
        
        if (!blank($RestaurantRatings)) {
            $sumRating = 0;
            $k         = 1;
            foreach ($RestaurantRatings as $rating) {
                if ($rating->user_id == $authID) {
                    $myRatingArray[0] = $rating;
                } else {
                    $myRatingArray[$k] = $rating;
                    $k++;
                }

                $sumRating += $rating->rating;
                $countUser++;
            }
            $avgRating = (int) ($sumRating / $countUser);
        }

        if (blank($myRatingArray[0])) {
            unset($myRatingArray[0]);
        }

        $data['countUser'] = $countUser;
        $data['avgRating'] = $avgRating;
        $data['ratings']   = $myRatingArray;
        return $data;
    }

}
