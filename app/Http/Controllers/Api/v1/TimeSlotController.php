<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\BackendController;
use App\Http\Requests\Api\TimeSlotRequest;
use App\Http\Resources\v1\TimeSlotResource;
use App\Http\Services\TimeSlotService;
use App\Models\TimeSlot;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TimeSlotController extends BackendController
{
    use ApiResponse;
    protected  $timeSlotService;

    public function __construct(TimeSlotService $timeSlotService)
    {
        parent::__construct();
        $this->middleware('auth:api');
        $this->middleware(['permission:time-slots'])->only('index');
        $this->middleware(['permission:time-slots_create'])->only('create', 'store');
        $this->middleware(['permission:time-slots_edit'])->only('edit', 'update');
        $this->middleware(['permission:time-slots_delete'])->only('destroy');
        $this->timeSlotService = $timeSlotService;

    }
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $timeSlots = $this->timeSlotService->allTimeSlots($request);
            $data = new TimeSlotResource($timeSlots);
            return $this->successResponse($data);
        } catch (\Exception $e){
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = new TimeSlotRequest();
        $validator = Validator::make($request->all(), $validator->rules());
        if (!$validator->fails()){

            try {
                DB::beginTransaction();
                $timeSlot = $this->timeSlotService->store($request);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('TimeSlot saved');

        }else {
            return response()->json([
                'code'  => 422,
                'error' => $validator->errors(),
            ], 422);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TimeSlot $timeSlot
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(TimeSlot $timeSlot)
    {
        try {
            return $this->successResponse($timeSlot->toArray());
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $timeSlot = TimeSlot::where(['id' => $id, 'restaurant_id' => auth()->user()->restaurant->id])->first();
        if (!blank($timeSlot)) {
            $validator = new TimeSlotRequest();
            $validator = Validator::make($request->all(), $validator->rules());
            if ($validator->fails()) {
                return response()->json([
                    'code'  => 422,
                    'error' => $validator->errors(),
                ], 422);
            }

            try {
                DB::beginTransaction();
                $this->timeSlotService->update($request, $timeSlot);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('TimeSlot updated');
        }
        return $this->errorResponse('You don\'t created TimeSlot',401);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $timeSlot = TimeSlot::where(['id' => $id, 'restaurant_id' => auth()->user()->restaurant->id])->first();
        if (!blank($timeSlot)) {
            try {
                $this->timeSlotService->delete($timeSlot);
            } catch (\Exception $e) {
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('TimeSlot deleted');
        }
        return $this->errorResponse('You don\'t created TimeSlot',401);

    }
}
