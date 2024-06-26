<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerTableSeeder extends Seeder{
    public array $banners = [
        [
            "restaurant_id" => 1,
            "status"        => Status::ACTIVE,
        ],
        [
            "restaurant_id" => 2,
            "status"        => Status::ACTIVE,
        ],
        [
            "restaurant_id" => 3,
            "status"        => Status::ACTIVE,
        ],
        [
            "restaurant_id" => 4,
            "status"        => Status::ACTIVE,
        ],
        [
            "restaurant_id" => 5,
            "status"        => Status::ACTIVE,
        ],
        [
            "restaurant_id" => 6,
            "status"        => Status::ACTIVE,
        ],
        [
            "restaurant_id" => 7,
            "status"        => Status::ACTIVE,
        ],
        [
            "restaurant_id" => 8,
            "status"        => Status::ACTIVE,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->banners as $banner) {
                $bannerObject = Banner::create([
                    'restaurant_id' => $banner['restaurant_id'],
                    'status'        => $banner['status'],
                ]);
                if (file_exists( public_path('/images/seeder/banner/banner1.jpg'))) {
                    $bannerObject->addMedia(
                        public_path('/images/seeder/banner/banner1.jpg'),
                    )->preservingOriginal()->toMediaCollection('banner');
                }
            }
        }
    }
}
