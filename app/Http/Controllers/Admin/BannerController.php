<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Models\Banner;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Requests\BannerRequest;
use App\Http\Controllers\BackendController;

class BannerController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Banners';

        $this->middleware(['permission:banner'])->only('index');
        $this->middleware(['permission:banner_create'])->only('create', 'store');
        $this->middleware(['permission:banner_edit'])->only('edit', 'update');
        $this->middleware(['permission:banner_delete'])->only('destroy');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $queryArray = [];
        if (auth()->user()->myrole != 1 && auth()->user()->restaurant) {
            $queryArray['restaurant_id'] = auth()->user()->restaurant->id;
        }

        if (!blank($queryArray)) {
            $this->data['banners'] = Banner::where($queryArray)->orderBy('sort', 'asc')->get();
        } else {
            $this->data['banners'] = Banner::orderBy('sort', 'asc')->get();
        }

        return view('admin.banner.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['restaurants'] = Restaurant::where(['status' => Status::ACTIVE])->get();
        return view('admin.banner.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {

        $banner                    = new Banner;
        $banner->restaurant_id     = $request->restaurant_id;
        $banner->title             = $request->name;
        $banner->short_description = $request->description;
        $banner->link              = $request->url;
        $banner->status            = $request->status;
        $banner->save();

        //Store Image Media Libraty Spatie
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $banner->addMediaFromRequest('image')->toMediaCollection('banner');
        }

        $banner->sort = $banner->id;
        $banner->save();

        return redirect(route('admin.banner.index'))->withSuccess('The data inserted successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['banner'] = Banner::findOrFail($id);
        $this->data['restaurants'] = Restaurant::where(['status' => Status::ACTIVE])->get();
        return view('admin.banner.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, $id)
    {

        $banner                    = Banner::findOrFail($id);
        $banner->restaurant_id     = $request->restaurant_id;
        $banner->title             = $request->name;
        $banner->short_description = $request->description;
        $banner->link              = $request->url;
        $banner->status            = $request->status;
        $banner->save();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $banner->media()->delete($id);
            $banner->addMediaFromRequest('image')->toMediaCollection('banner');
        }

        return redirect(route('admin.banner.index'))->withSuccess('The data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Banner::findOrFail($id)->delete();
        return redirect(route('admin.banner.index'))->withSuccess('The data deleted successfully.');
    }

    public function sortBanner(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));
            foreach ($arr as $sortOrder => $id) {
                $banner       = Banner::find($id);
                $banner->sort = ++$sortOrder;
                $banner->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }
}
