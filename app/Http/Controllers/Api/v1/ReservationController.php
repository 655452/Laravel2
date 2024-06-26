<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\ReservationStatus;
use App\Http\Requests\Api\ReservationRequest;
use App\Http\Resources\v1\BannerResource;
use App\Http\Services\PushNotificationService;
use App\Models\Reservation;
use App\Notifications\ReservationUpdate;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Services\ReservationService;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Frontend\ReservationBookRequest;
use App\Http\Resources\v1\ReservationResource;
use App\Http\Resources\v1\TimeSlotResource;
use Illuminate\Support\Facades\Validator;

class ReservationController extends BackendController
{
    use ApiResponse;
    protected  $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        parent::__construct();
        $this->middleware('auth:api');
        $this->reservationService = $reservationService;
    }
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $reservations = auth()->user()->reservations;
        try {
            $reservations = ReservationResource::collection($reservations);
            return $this->successResponse(['status' => 200, 'data' => $reservations]);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = new ReservationRequest();
        $rules = $validator->rules();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }

        $reservationService    = new ReservationService();
        $table = $reservationService->CheckReservation(true, date('Y-m-d', strtotime($request->get('reservation_date'))), $request->get('guest'), $request->get('restaurant_id'));

        $tableArray = collect($table)->sortBy('capacity')->toArray();
        $first_name = '';
        $last_name  = '';
        if ($request->has('name')) {
            $parts      = $this->split_name($request->get('name'));
            $first_name = $parts[0];
            $last_name  = $parts[1];
        }

        $reservation = new Reservation;
        $reservation->first_name = $first_name;
        $reservation->last_name = $last_name;
        $reservation->email = $request->get('email');
        $reservation->phone = $request->get('phone');
        $reservation->reservation_date = date('Y-m-d', strtotime($request->get('reservation_date')));
        $reservation->restaurant_id = $request->get('restaurant_id');
        $reservation->table_id = $table[array_key_first($tableArray)]['tableID'];
        $reservation->time_slot_id = $request->get('time_slot');
        $reservation->guest_number = $request->get('guest');
        $reservation->user_id = auth()->user()->id;
        $reservation->status = ReservationStatus::PENDING;
        $reservation->save();

        try {
            app(PushNotificationService::class)->sendNotificationReservation($reservation,$reservation->restaurant->user,'store');
        } catch (\Exception $exception) {
            //
        }
        try {
            return $this->successresponse(['status' => 200, 'message' => 'The Data Inserted Successfully','data'=> new ReservationResource($reservation)]);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    private function split_name($name)
    {
        $name       = trim($name);
        $last_name  = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
        return [$first_name, $last_name];
    }

    public function check(Request $request)
    {
        $reservationService    = new ReservationService();
        $timeSlots = $reservationService->CheckReservation(false, date('Y-m-d', strtotime($request->date)), $request->capacity, $request->restaurant_id);
        try {
            return $this->successResponse(['status' => 200, 'data' =>  TimeSlotResource::collection($timeSlots) ]);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    public function update(Request $request, $id )
    {
        if ($id) {
            $reservation = Reservation::find($id);
            if ( !blank($reservation) ) {
                $reservation->status =$request->status;
                $reservation->save();
                try {
                    app(PushNotificationService::class)->sendNotificationReservation($reservation,$reservation->user,'update');
                } catch (\Exception $exception) {
                    //
                }

                return response()->json([
                    'status'  => 200,
                    'message' => 'You reservation successfully',
                ], 200);

            } else {
                return response()->json([
                    'status'  => 422,
                    'message' => 'The reservation not found',
                ], 422);
            }
        } else {
            return response()->json([
                'status'  => 422,
                'message' => 'The reservation id not found',
            ], 422);
        }
    }

}
