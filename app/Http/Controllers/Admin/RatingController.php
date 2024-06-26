<?php

namespace App\Http\Controllers\Admin;
use App\Enums\Status;
use App\Enums\RatingStatus;
use App\Http\Controllers\BackendController;
use App\Models\RestaurantRating;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class RatingController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Ratings';

        $this->middleware(['permission:rating']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data= RestaurantRating::latest()->get();
        return view('admin.rating.index', $this->data);
    }

    public function update(Request $request, $id)
    {
        $rating         = RestaurantRating::findOrFail($id);
        $rating->status = $rating->status == 10 ? RatingStatus::ACTIVE : RatingStatus::INACTIVE;
        $rating->save();

        return redirect(route('admin.rating.index'))->withSuccess('The Data Updated Successfully');
    }

    public function getRating(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->status) && (int) $request->status) {
                $ratings = RestaurantRating::where(['status' => $request->status])->latest()->get();
            } else {
                $ratings = RestaurantRating::latest()->get();
            }

            $i           = 1;
            $ratingArray = []; 

            if (!blank($ratings)) {
                foreach ($ratings as $rating) {
                    $ratingArray[$i]                 = $rating;
                    $ratingArray[$i]['user_name']     = $rating->user->name;
                    $ratingArray[$i]['restaurant_name']   = Str::limit($rating->restaurant->name, 30);
                    $ratingArray[$i]['rating']       = number_format($rating->rating, 1);
                    $ratingArray[$i]['review']       = Str::limit($rating->review, 30);
                    $ratingArray[$i]['setID']        = $i;
                    $i++;
                }
            }

            return Datatables::of($ratingArray)
                ->addColumn('action', function ($rating) {
                    $retAction = '';

                    if (auth()->user()->can('rating')) {
                        $retAction .= '<form class="float-left pl-2" action="' . route('admin.rating.update', $rating) . '" method="POST">' . method_field('PUT') . csrf_field() .
                        '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Active / Inactive"><i class="fa fa-trash"></i></button></form>';
                    }
                    return $retAction;
                })->editColumn('id', function ($rating) {
                    return $rating->setID;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }
}
