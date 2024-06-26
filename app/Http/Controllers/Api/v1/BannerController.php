<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\BannerStatus;
use App\Http\Controllers\BackendController;
use App\Http\Requests\BannerRequest;
use App\Http\Resources\v1\BannerResource;
use App\Traits\ApiResponse;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends BackendController
{
    use ApiResponse;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $banners= Banner::where('status',BannerStatus::ACTIVE)->orderBy('sort', 'asc')->get();
        return $this->successresponse(['success'=>200, 'data'=> BannerResource::collection($banners)]);
    }
}
