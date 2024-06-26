<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\BackendController;
use App\Http\Requests\Api\MenuItemRequest;
use App\Http\Resources\v1\MenuItemResource;
use App\Models\MenuItem;
use App\Http\Services\MenuItemService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class   MenuItemController extends BackendController
{
    use ApiResponse;
    protected  $menuItemService;

    public function __construct(MenuItemService $menuItemService)
    {
        parent::__construct();
        $this->middleware('auth:api');
        $this->menuItemService = $menuItemService;

    }
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $menuItems = $this->menuItemService->allMenuItems($request);
            $data = new MenuItemResource($menuItems);
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
        $validator = new MenuItemRequest();
        $validator = Validator::make($request->all(), $validator->rules());
        if (!$validator->fails()){

            try {
                DB::beginTransaction();
                $menuItem = $this->menuItemService->store($request);
                $this->menuItemService->media($menuItem);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('menuItem saved');

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try{
            $menuitem= new MenuItemResource($this->menuItemService->show($id));
            return $this->successResponse(['status'=>200,'data'=>$menuitem]);
        } catch(\Exception $e){
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  MenuItem $menuItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(MenuItem $menuItem)
    {
        try {
            return $this->successResponse($menuItem->toArray());
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
        $menuItem = MenuItem::where(['id' => $id, 'restaurant_id' => auth()->user()->restaurant->id])->first();
        if (!blank($menuItem)) {
            $validator = new MenuItemRequest();
            $validator = Validator::make($request->all(), $validator->rules());
            if ($validator->fails()) {
                return response()->json([
                    'code'  => 422,
                    'error' => $validator->errors(),
                ], 422);
            }

            try {
                DB::beginTransaction();
                $this->menuItemService->update($request, $menuItem);
                $this->menuItemService->updateMedia($menuItem);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('menuItem updated');
        }
        return $this->errorResponse('You don\'t created menuItem',401);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $menuItem = MenuItem::where(['id' => $id, 'restaurant_id' => auth()->user()->restaurant->id])->first();
        if (!blank($menuItem)) {
            try {
                $this->menuItemService->delete($menuItem);
            } catch (\Exception $e) {
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('menuItem deleted');
        }
        return $this->errorResponse('You don\'t created menuItem',401);

    }
}
