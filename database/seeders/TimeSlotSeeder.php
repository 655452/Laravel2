<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimeSlot;
class TimeSlotSeeder extends Seeder
{
    public array $timeSlotOptions = [
        [
            "restaurant_id" => 1,
            "start_time"    => "09:00:00",
            "end_time"      => "10:00:00",
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 1,
            "start_time"    => "10:00:00",
            "end_time"      => "11:00:00",
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 1,
            "start_time"    => "12:00:00",
            "end_time"      => "13:00:00",
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 1,
            "start_time"    => "13:00:00",
            "end_time"      => "14:00:00",
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 1,
            "start_time"    => "14:00:00",
            "end_time"      => "15:00:00",
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 2,
            "start_time"    => "10:00:00",
            "end_time"      => "11:00:00",
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 2,
            "start_time"    => "11:00:00",
            "end_time"      => "12:00:00",
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 2,
            "start_time"    => "12:00:00",
            "end_time"      => "13:00:00",
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 2,
            "start_time"    => "13:00:00",
            "end_time"      => "14:00:00",
            "status"        => 5,
            "creator_type"  => "App\Models\User",
            "creator_id"    => 1,
            "editor_type"   => "App\Models\User",
            "editor_id"     => 1,
        ],
        [
            "restaurant_id" => 2,
            "start_time"    => "15:00:00",
            "end_time"      => "16:00:00",
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
            foreach ($this->timeSlotOptions as $timeSlotOption) {
                TimeSlot::create([
                    'restaurant_id' => $timeSlotOption['restaurant_id'],
                    'start_time'    => $timeSlotOption['start_time'],
                    'end_time'      => $timeSlotOption['end_time'],
                    'status'        => $timeSlotOption['status'],
                    'creator_type'  => $timeSlotOption['creator_type'],
                    'creator_id'    => $timeSlotOption['creator_id'],
                    'editor_type'   => $timeSlotOption['editor_type'],
                    'editor_id'     => $timeSlotOption['editor_id'],
                ]);
            }
        }
    }
}
