<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Address;
use App\Models\Cuisine;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddressRequest;
use App\Http\Services\AddressService;
use App\Http\Services\CuisineService;
use App\Http\Requests\Api\CuisineRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\v1\AddressResource;
use App\Http\Resources\v1\CuisineResource;
use App\Http\Controllers\BackendController;
use App\Http\Resources\v1\RestaurantResource;
use App\Http\Resources\v1\PopularRestaurantResource;

class AddressController extends BackendController
{
    use ApiResponse;
    protected  $addressService;

    public function __construct(AddressService $addressService)
    {
        parent::__construct();
        $this->middleware('auth:api');
        $this->addressService = $addressService;

    }
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{
            $addresses = AddressResource::collection($this->addressService->allAddresses());
            return response()->json(['status'=> 200, 'data' => $addresses]);

        } catch (\Exception $e){
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    public function store(AddressRequest $request)
    {
        $address = app(AddressService::class)->store($request);
        if ($address) {
            return $this->successResponse(['status'=> 200, 
                                            'address'=>new AddressResource($address), 
                                            'message' => "Address Added Successfully !"
                                        ]);
        }
        return $this->successResponse(['status'=> 401, 'message' => "Something Wrong !"]);
    }

    public function update(AddressRequest $request, $id)
    {
        $address = Address::findOrFail($id);
        $address = app(AddressService::class)->update($address,$request);
        if ($address) {
            return $this->successResponse(['status'=> 200,
                                            'address'=>new AddressResource($address), 
                                            'message' => "Address Updated Successfully !"]);
        }
        return $this->successResponse(['status'=> 401, 'message' => "Something Wrong !"]);

    }

    public function destroy($id)
    {
        $address = Address::find($id);
        if($address){
            $address->delete();
            return $this->successResponse(['status'=> 200, 'message' => "Address Deleted Successfully !"]);
        }
        return $this->successResponse(['status'=> 401, 'message' => "Something Wrong !"]);


    }

}
