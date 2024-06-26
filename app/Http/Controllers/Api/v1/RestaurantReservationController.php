<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\ReservationRequest;
use App\Http\Resources\v1\BannerResource;
use App\Models\Reservation;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Services\ReservationService;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Frontend\ReservationBookRequest;
use App\Http\Resources\v1\ReservationResource;
use App\Http\Resources\v1\TimeSlotResource;
use Illuminate\Support\Facades\Validator;

class RestaurantReservationController extends BackendController
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
        $reservations = !blank(auth()->user()->restaurant) ? Reservation::where('restaurant_id',auth()->user()->restaurant->id)->get():[];
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

}
