<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\BackendController;
use App\Http\Requests\Api\TableRequest;
use App\Http\Resources\v1\TableResource;
use App\Models\Table;
use App\Http\Services\TableService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TableController extends BackendController
{
    use ApiResponse;
    protected  $tableService;

    public function __construct(TableService $tableService)
    {
        parent::__construct();
        $this->middleware('auth:api');
        $this->tableService = $tableService;

    }
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $tables = $this->tableService->allTables($request);
            $data = new TableResource($tables);
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
        $validator = new TableRequest();
        $validator = Validator::make($request->all(), $validator->rules());
        if (!$validator->fails()){

            try {
                DB::beginTransaction();
                $table = $this->tableService->store($request);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('table saved');

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
     * @param  Table $table
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Table $table)
    {
        try {
            return $this->successResponse($table->toArray());
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
        $table = Table::where(['id' => $id, 'restaurant_id' => auth()->user()->restaurant->id])->first();
        if (!blank($table)) {
            $validator = new TableRequest();
            $validator = Validator::make($request->all(), $validator->rules());
            if ($validator->fails()) {
                return response()->json([
                    'code'  => 422,
                    'error' => $validator->errors(),
                ], 422);
            }

            try {
                DB::beginTransaction();
                $this->tableService->update($request, $table);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('table updated');
        }
        return $this->errorResponse('You don\'t created table',401);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $table = Table::where(['id' => $id, 'restaurant_id' => auth()->user()->restaurant->id])->first();
        if (!blank($table)) {
            try {
                $this->tableService->delete($table);
            } catch (\Exception $e) {
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('table deleted');
        }
        return $this->errorResponse('You don\'t created table',401);

    }
}
