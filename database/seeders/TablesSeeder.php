<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\Table;
class TablesSeeder extends Seeder
{
    public array $tableOptions = [
        [
            "restaurant_id" => 1,
            "name"          => "Table 1",
            "capacity"      => 4,
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 1,
            "name"          => "Table 2",
            "capacity"      => 6,
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 1,
            "name"          => "Table 3",
            "capacity"      => 8,
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 1,
            "name"          => "Table 4",
            "capacity"      => 10,
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 1,
            "name"          => "Table 5",
            "capacity"      => 12,
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 2,
            "name"          => "Table 5",
            "capacity"      => 12,
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 2,
            "name"          => "Table 4",
            "capacity"      => 10,
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 2,
            "name"          => "Table 3",
            "capacity"      => 8,
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 2,
            "name"          => "Table 2",
            "capacity"      => 6,
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 2,
            "name"          => "Table 1",
            "capacity"      => 4,
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->tableOptions as $tableOption) {
                Table::create([
                    'restaurant_id' => $tableOption['restaurant_id'],
                    'name'          => $tableOption['name'],
                    'capacity'      => $tableOption['capacity'],
                    'status'        => $tableOption['status'],
                    'creator_type'  => $tableOption['creator_type'],
                    'creator_id'    => $tableOption['creator_id'],
                    'editor_type'   => $tableOption['editor_type'],
                    'editor_id'     => $tableOption['editor_id'],
                ]);
            }
        }
    }
}
