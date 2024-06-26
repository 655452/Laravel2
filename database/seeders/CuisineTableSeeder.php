<?php

namespace Database\Seeders;

use App\Models\Cuisine;
use Illuminate\Database\Seeder;
use App\Enums\CategoryStatus;

class CuisineTableSeeder extends Seeder{
    public array $cusines = [
        [
            'name'         => "Bangladeshi",
            'slug'         => "bangladeshi",
            'description'  => "<p>This Cuisine refers to a distinctive style or method of cooking, often associated with a particular region or culture. It encompasses a wide range of ingredients, flavors, and cooking techniques that reflect the culinary traditions of a community.&nbsp;</p>",
            'depth'        => "0",
            'left'         => "0",
            'right'        => "0",
            'parent_id'    => "0",
            'status'       => CategoryStatus::ACTIVE,
            'requested'    => "5",
            'creator_type' => 'App\Models\User',
            'creator_id'   => 1,
            'editor_type'  => 'App\Models\User',
            'editor_id'    => 1,
        ],
        [
            'name'         => "American",
            'slug'         => "american",
            'description'  => "<p>This Cuisine refers to a distinctive style or method of cooking, often associated with a particular region or culture. It encompasses a wide range of ingredients, flavors, and cooking techniques that reflect the culinary traditions of a community.&nbsp;<br></p>",
            'depth'        => "0",
            'left'         => "0",
            'right'        => "0",
            'parent_id'    => "0",
            'status'       => CategoryStatus::ACTIVE,
            'requested'    => "5",
            'creator_type' => 'App\Models\User',
            'creator_id'   => 1,
            'editor_type'  => 'App\Models\User',
            'editor_id'    => 1,
        ],
        [
            'name'         => "Asian",
            'slug'         => "asian",
            'description'  => "<p>This Cuisine refers to a distinctive style or method of cooking, often associated with a particular region or culture. It encompasses a wide range of ingredients, flavors, and cooking techniques that reflect the culinary traditions of a community.&nbsp;</p>",
            'depth'        => "0",
            'left'         => "0",
            'right'        => "0",
            'parent_id'    => "0",
            'status'       => CategoryStatus::ACTIVE,
            'requested'    => "5",
            'creator_type' => 'App\Models\User',
            'creator_id'   => 1,
            'editor_type'  => 'App\Models\User',
            'editor_id'    => 1,
        ],
        [
            'name'         => "Mexican",
            'slug'         => "mexican",
            'description'  => "<p>This Cuisine refers to a distinctive style or method of cooking, often associated with a particular region or culture. It encompasses a wide range of ingredients, flavors, and cooking techniques that reflect the culinary traditions of a community.&nbsp;</p>",
            'depth'        => "0",
            'left'         => "0",
            'right'        => "0",
            'parent_id'    => "0",
            'status'       => CategoryStatus::ACTIVE,
            'requested'    => "5",
            'creator_type' => 'App\Models\User',
            'creator_id'   => 1,
            'editor_type'  => 'App\Models\User',
            'editor_id'    => 1,
        ],
        [
            'name'         => "Pizza",
            'slug'         => "pizza",
            'description'  => "<p>This Cuisine refers to a distinctive style or method of cooking, often associated with a particular region or culture. It encompasses a wide range of ingredients, flavors, and cooking techniques that reflect the culinary traditions of a community.&nbsp;</p>",
            'depth'        => "0",
            'left'         => "0",
            'right'        => "0",
            'parent_id'    => "0",
            'status'       => CategoryStatus::ACTIVE,
            'requested'    => "5",
            'creator_type' => 'App\Models\User',
            'creator_id'   => 1,
            'editor_type'  => 'App\Models\User',
            'editor_id'    => 1,
        ],
        [
            'name'         => "Burger",
            'slug'         => "burger",
            'description'  => "<p>This Cuisine refers to a distinctive style or method of cooking, often associated with a particular region or culture. It encompasses a wide range of ingredients, flavors, and cooking techniques that reflect the culinary traditions of a community.&nbsp;</p>",
            'depth'        => "0",
            'left'         => "0",
            'right'        => "0",
            'parent_id'    => "0",
            'status'       => CategoryStatus::ACTIVE,
            'requested'    => "5",
            'creator_type' => 'App\Models\User',
            'creator_id'   => 1,
            'editor_type'  => 'App\Models\User',
            'editor_id'    => 1,
        ],
        [
            'name'         => "Dessert",
            'slug'         => "dessert",
            'description'  => "<p>This Cuisine refers to a distinctive style or method of cooking, often associated with a particular region or culture. It encompasses a wide range of ingredients, flavors, and cooking techniques that reflect the culinary traditions of a community.&nbsp;</p>",
            'depth'        => "0",
            'left'         => "0",
            'right'        => "0",
            'parent_id'    => "0",
            'status'       => CategoryStatus::ACTIVE,
            'requested'    => "5",
            'creator_type' => 'App\Models\User',
            'creator_id'   => 1,
            'editor_type'  => 'App\Models\User',
            'editor_id'    => 1,
        ],
        [
            'name'         => "Chicken",
            'slug'         => "chicken",
            'description'  => "<p>This Cuisine refers to a distinctive style or method of cooking, often associated with a particular region or culture. It encompasses a wide range of ingredients, flavors, and cooking techniques that reflect the culinary traditions of a community.&nbsp;</p>",
            'depth'        => "0",
            'left'         => "0",
            'right'        => "0",
            'parent_id'    => "0",
            'status'       => CategoryStatus::ACTIVE,
            'requested'    => "5",
            'creator_type' => 'App\Models\User',
            'creator_id'   => 1,
            'editor_type'  => 'App\Models\User',
            'editor_id'    => 1,
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->cusines as $cusine) {
                $cusineObject = Cuisine::create([
                    'name'         => $cusine['name'],
                    'slug'         => $cusine['slug'],
                    'description'  => $cusine['description'],
                    'depth'        => $cusine['depth'],
                    'left'         => $cusine['left'],
                    'right'        => $cusine['right'],
                    'parent_id'    => $cusine['parent_id'],
                    'status'       => $cusine['status'],
                    'requested'    => $cusine['requested'],
                    'creator_type' => $cusine['creator_type'],
                    'creator_id'   => $cusine['creator_id'],
                    'editor_type'  => $cusine['editor_type'],
                    'editor_id'    => $cusine['editor_id'],
                ]);
                if (file_exists(
                    public_path('/images/seeder/cusine/' . $cusine['slug'].'.jpg')
                )) {
                    $cusineObject->addMedia(
                        public_path('/images/seeder/cusine/' .  $cusine['slug'].'.jpg')
                    )->preservingOriginal()->toMediaCollection('cuisines');
                }
            }
        }
    }
}
