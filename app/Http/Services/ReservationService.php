<?php

namespace App\Http\Services;

use App\Enums\Status;
use App\Enums\TableStatus;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\TimeSlot;


class ReservationService
{


    public function __construct()
    {
    }


    public function CheckReservation( $tableReturn, $date, $capacity, $restaurant_id )
    {
        $reservations = Reservation::where(['reservation_date' => $date, 'restaurant_id' => $restaurant_id])->get();

        $reservationArrays = [];
        if(!blank($reservations)) {
            foreach($reservations as $reservation) {
                $reservationArrays[$reservation->reservation_date][$reservation->time_slot_id][$reservation->table_id] = $reservation;
            }
        }

        $timeSlots = TimeSlot::where(['restaurant_id' => $restaurant_id, 'status' => Status::ACTIVE])->get();
        $tables    = Table::where([
            'restaurant_id' => $restaurant_id,
            'status'        => TableStatus::ENABLE
        ])->where('capacity', '>=', $capacity)->get();

        $timeTableArrays = [];
        if(!blank($timeSlots) && !blank($tables)) {
            foreach($timeSlots as $slot) {
                foreach($tables as $table) {
                    if(!isset($reservationArrays[$date][$slot->id][$table->id])) {
                        $timeTableArrays[$date][$slot->id][$table->id] = [
                            'tableID'  => $table->id,
                            'capacity' => $table->capacity,
                            'start_time' => $slot->start_time
                        ];
                    }
                }
            }
        }

        if(count($timeTableArrays)) {
            foreach($timeTableArrays as $dateKey => $timeTableArray) {
                foreach($timeTableArray as $timeKey => $times) {
                    foreach($times as $tableKey => $time) {
                        if(isset($reservationArrays[$dateKey][$timeKey][$tableKey])) {
                            unset($timeTableArrays[$dateKey][$timeKey][$tableKey]);
                        }
                    }
                }
            }
        }
        $response = [];
        if(count($timeSlots)) {
            foreach($timeSlots as $timeSlot) {
                if(isset($timeTableArrays[$date][$timeSlot->id])) {
                    if($tableReturn) {
                        $response = $timeTableArrays[$date][$timeSlot->id];
                    } else {
                        $response[$timeSlot->id] = [
                            'id'         => $timeSlot->id,
                            'start_time' => $timeSlot->start_time,
                            'end_time'   => $timeSlot->end_time
                        ];
                    }
                }
            }
        }

        if(!blank($response)) {
            foreach($response as $k => $r) {
                if(strtotime($date) == strtotime(date('Y-m-d'))) {
                    $min  = 30;
                    $time = date('H:i:s', strtotime("+{$min} minutes"));
                    if($time > $r['start_time']) {
                        unset($response[$k]);
                    }
                }
            }
        }

        return $response;
    }



}
