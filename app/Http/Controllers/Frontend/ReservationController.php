<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ReservationStatus;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\Frontend\ReservationBookRequest;
use App\Http\Requests\ReservationRequest;
use App\Http\Services\PushNotificationService;
use App\Http\Services\ReservationService;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\TimeSlot;
use App\Models\User;
use App\Notifications\ReservationCreated;
use Illuminate\Http\Request;

class ReservationController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'Restaurant Booking';
    }

    public function booking( ReservationBookRequest $request )
    {
        $this->data['reservationDate'] = $request->get('reservation_date');
        $this->data['guest']           = $request->get('qtyInput');
        $this->data['timeSlot']        = TimeSlot::findOrFail($request->get('time_slot'));
        $this->data['restaurant']      = Restaurant::findOrFail($request->get('restaurant_id'));
        return view('frontend.restaurant.booking', $this->data);
    }

    public function store( ReservationRequest $request )
    {

        $reservationService = new ReservationService();
        $table              = $reservationService->CheckReservation(true, date('Y-m-d', strtotime($request->get('reservation_date'))), $request->get('guest'), $request->get('restaurant_id'));

        $tableArray = collect($table)->sortBy('capacity')->toArray();


        $reservation                   = new Reservation;
        $reservation->first_name       = $request->get('first_name');
        $reservation->last_name        = $request->get('last_name');
        $reservation->email            = $request->get('email');
        $reservation->phone            = $request->get('countrycode').$request->get('phone') ;
        $reservation->reservation_date = date('Y-m-d', strtotime($request->get('reservation_date')));
        $reservation->restaurant_id    = $request->get('restaurant_id');
        $reservation->table_id         = $table[array_key_first($tableArray)]['tableID'];
        $reservation->time_slot_id     = $request->get('time_slot');
        $reservation->guest_number     = $request->get('guest');
        $reservation->user_id          = auth()->user()->id;
        $reservation->status           = ReservationStatus::PENDING;
        $reservation->save();

        try {
            app(PushNotificationService::class)->sendNotificationReservation($reservation,$reservation->restaurant->user,'store');
        } catch (\Exception $exception) {
            //
        }

        $this->data['reservation'] = $reservation;
        return redirect()->route('reservation.confirmation');
    }

    public function check( Request $request )
    {
        $reservationService = new ReservationService();
        $timeSlots          = $reservationService->CheckReservation(false, date('Y-m-d', strtotime($request->date)), $request->capacity, $request->restaurant);
        return view('frontend.restaurant.timeSlot', compact('timeSlots'));
    }

    public function confirmation()
    {
        $userId = auth()->user()->id;
        $reservation = Reservation::where(['user_id' => $userId])
                       ->orderBy('created_at', 'desc')->select('email')->first();
        $this->data['reservation'] = $reservation;

        return view('frontend.restaurant.booking-confirmation', $this->data);
    }

}
