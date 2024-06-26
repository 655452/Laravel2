<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\BackendController;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Resources\v1\CategoryResource;
use App\Http\Resources\v1\PopularRestaurantResource;
use App\Http\Services\CategoryService;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BackendController
{
    use ApiResponse;
    protected  $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();
        $this->middleware('auth:api');
        $this->middleware(['permission:category_create'])->only('create', 'store');
        $this->middleware(['permission:category_edit'])->only('edit', 'update');
        $this->middleware(['permission:category_delete'])->only('destroy');
        $this->categoryService = $categoryService;

    }
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        try{
            $categories = CategoryResource::collection($this->categoryService->allCategories($request));
            return $this->successResponse(['status'=> 200, 'data' => $categories]);
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
        $categories = $this->categoryService->show($id);
        $restaurants = [];
        if(!blank($categories->MenuItems)){
            foreach ($categories->MenuItems as $menuItem){
                if (!array_key_exists($menuItem->restaurant_id, $restaurants)){
                    $restaurants[$menuItem->restaurant_id] = $menuItem->restaurant;
                }
            }
        }
        try{
            $this->data['category'] = new CategoryResource($categories);
            $this->data['restaurants'] = PopularRestaurantResource::collection($restaurants);

            return $this->successResponse(['status'=> 200, 'data' => $this->data]);
        } catch (\Exception $e){
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

}
