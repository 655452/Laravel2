<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\BackendController;
use App\Http\Requests\Api\CuisineRequest;
use App\Http\Resources\v1\CuisineResource;
use App\Http\Resources\v1\PopularRestaurantResource;
use App\Http\Resources\v1\RestaurantResource;
use App\Http\Services\CuisineService;
use App\Models\Cuisine;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CuisineController extends BackendController
{
    use ApiResponse;
    protected  $cuisineService;

    public function __construct(CuisineService $cuisineService)
    {
        parent::__construct();
        $this->middleware('auth:api');
        $this->cuisineService = $cuisineService;

    }
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $cuisines = CuisineResource::collection($this->cuisineService->allCuisines($request));
            return $this->successResponse(['status'=> 200, 'data' => $cuisines]);

        } catch (\Exception $e){
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    public function show($id)
    {
        $cuisine = $this->cuisineService->show($id);
        try{
            $this->data['cuisine'] = new CuisineResource($cuisine);
            $this->data['restaurants'] = PopularRestaurantResource::collection($cuisine->restaurants);

            return $this->successResponse(['status'=> 200, 'data' =>  $this->data]);
        } catch (\Exception $e){
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

}
