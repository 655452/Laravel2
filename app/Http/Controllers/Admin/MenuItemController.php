<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryStatus;
use App\Enums\MenuItemStatus;
use App\Enums\Status;
use App\Http\Controllers\BackendController;
use App\Http\Requests\MenuItemRequest;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\MenuItemOption;
use App\Models\MenuItemVariation;
use App\Models\Restaurant;
use App\Rules\IniAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class MenuItemController extends BackendController
{

    /**
     * MenuItemController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Menu Items';

        $this->middleware(['permission:menu-items'])->only('index');
        $this->middleware(['permission:menu-items_create'])->only('create', 'store');
        $this->middleware(['permission:menu-items_edit'])->only('edit', 'update');
        $this->middleware(['permission:menu-items_delete'])->only('destroy');
        $this->middleware(['permission:menu-items_show'])->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getMenuItem($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['categories'] = Category::where(['status' => CategoryStatus::ACTIVE])->get();
        $this->data['restaurants'] = Restaurant::where(['status' => Status::ACTIVE])->get();
        return view('admin.menu-item.create', $this->data);
    }

    /**
     * @param MenuItemRequest $request
     * @return mixed
     */
    public function store(MenuItemRequest $request)
    {
        $menus = MenuItem::where('restaurant_id', $request->get('restaurant_id'))->get();
        $menu_array = [];
        if (isset($menus)) {
            foreach ($menus as $menu) {
                $menu_array[] = $menu->menu_number;
            }
        }
        $menuNumber = $this->checkMenuNumber($menu_array);
        $menuItem                 = new MenuItem;
        $menuItem->restaurant_id  = $request->get('restaurant_id');
        $menuItem->name           = $request->get('name');
        $menuItem->description    = $request->get('description');
        $menuItem->unit_price     = $request->get('unit_price');
        $menuItem->discount_price = $request->get('discount_price') ?? 0;
        $menuItem->status         = $request->get('status');
        $menuItem->menu_number         = $menuNumber;
        $menuItem->save();

        $menuItem->categories()->sync($request->get('categories'));

        //Store Image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $menuItem->addMediaFromRequest('image')->toMediaCollection('menu-items');
        }

        return redirect()->route('admin.menu-items.index')->withSuccess('The data inserted successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param MenuItem $MenuItem
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(MenuItem $menuItem)
    {
        return view('admin.menu-item.show', compact('menuItem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param MenuItem $MenuItem
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(MenuItem $menuItem)
    {
        $this->data['menuItem']            = $menuItem;
        $this->data['categories']          = Category::where(['status' => CategoryStatus::ACTIVE])->get();
        $this->data['menuItem_categories'] = $menuItem->categories()->pluck('id')->toArray();
        $this->data['restaurants'] = Restaurant::where(['status' => Status::ACTIVE])->get();

        return view('admin.menu-item.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param MenuItemRequest $request
     * @param $id
     * @return mixed
     */
    public function update(MenuItemRequest $request, $id)
    {
        $menuItem                 = MenuItem::owner()->findOrFail($id);
        $menuItem->restaurant_id  = $request->get('restaurant_id');
        $menuItem->name           = $request->get('name');
        $menuItem->description    = $request->get('description');
        $menuItem->unit_price     = $request->get('unit_price');
        $menuItem->discount_price = $request->get('discount_price') ?? 0;
        $menuItem->status         = $request->get('status');
        $menuItem->save();

        $menuItem->categories()->sync($request->get('categories'));

        //Update Image
        if ($request->hasFile('image') && $request->file('image')->isValid()) { 
            $menuItem->deleteMedia('menu-items', $menuItem->id);
            $menuItem->addMediaFromRequest('image')->toMediaCollection('menu-items');
        }

        return redirect()->route('admin.menu-items.index')->withSuccess('The data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MenuItem::owner()->findOrFail($id)->delete();
        return redirect()->route('admin.menu-items.index')->withSuccess('The Data Deleted Successfully');
    }

    private function getMenuItem($request)
    {
        if (request()->ajax()) {
            $queryArray = [];
            if (!empty($request->status) && (int) $request->status) {
                $queryArray['status'] = $request->status;
            }
            if (auth()->user()->myrole != 1 && auth()->user()->restaurant){
                $queryArray['restaurant_id'] =auth()->user()->restaurant->id;
            }

            if (!blank($queryArray)) {
                $menuItems = MenuItem::with('categories')->where($queryArray)->descending()->get();
            } else {
                $menuItems = MenuItem::with('categories')->descending()->get();
            }

            $i = 0;
            return Datatables::of($menuItems)
                ->addColumn('action', function ($menuItem) {
                    $retAction = '';

                    if (auth()->user()->can('menu-items_edit')) {
                        $retAction .= '<a href="' . route('admin.menu-items.modify', $menuItem) . '" class="btn btn-sm btn-icon float-left btn-success mr-2" data-toggle="tooltip" data-placement="top" title="Add Variation/Option"> <i class="far fa-list-alt"></i></a>';
                    }

                    if (auth()->user()->can('menu-items_show')) {
                        $retAction .= '<a href="' . route('admin.menu-items.show', $menuItem) . '" class="btn btn-sm btn-icon mr-2  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }

                    if (auth()->user()->can('menu-items_edit')) {
                        $retAction .= '<a href="' . route('admin.menu-items.edit', $menuItem) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('menu-items_delete')) {
                        $retAction .= '<form id="detete-'.$menuItem->id.'" class="float-left pl-2" action="' . route('admin.menu-items.destroy', $menuItem) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                         '<button type="button" data-id="'.$menuItem->id.'"
                         class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                         <i class="fa fa-trash"></i>
                         </button></form>';
                    }

                    return $retAction;
                })
                ->editColumn('id', function ($menuItem) use (&$i) {
                    return ++$i;
                })
                ->editColumn('categories', function ($menuItem) {
                    $categories = implode(', ', $menuItem->categories()->pluck('name')->toArray());
                    return Str::limit($categories, 30);
                })
                ->editColumn('name', function ($menuItem) {
                    $col = '<p class="p-0 m-0">' . Str::limit($menuItem->name, 20) . '</p>';
                    $col .= '<small class="text-muted">' . Str::limit($menuItem->description, 20) . '</small>';
                    return $col;
                })
                ->editColumn('status', function ($menuItem) {
                    return trans('menu_item_statuses.' . $menuItem->status) ?? trans('menu_item_statuses.' . MenuItemStatus::INACTIVE);
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
        return view('admin.menu-item.index', $this->data);
    }

    public function getMedia(Request $request)
    {

        $menuItem       = MenuItem::owner()->where('status', MenuItemStatus::ACTIVE)->find($request->id);
        $menuItemImages = $menuItem->iamges;

        $i      = 0;
        $retArr = [];
        if (!blank($menuItemImages)) {
            foreach ($menuItemImages as $menuItemImage) {
                $i++;
                $retArr[$i]['name'] = $menuItemImage->file_name;
                $retArr[$i]['size'] = $menuItemImage->size;
                $retArr[$i]['url']  = asset($menuItemImage->getUrl());
            }
        }
        echo json_encode($retArr);
    }

    public function storeMedia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'nullable|image|mimes:jpeg,jpg,png|max:3096',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first('file'),
            ]);
        }

        $path = storage_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function updateMedia(Request $request, $id)
    {

        $menuItem = MenuItem::owner()->find($id);
        if (!blank($menuItem)) {
            $validator = Validator::make($request->all(), [
                'file' => 'nullable|image|mimes:jpeg,jpg,png|max:3096',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first('file'),
                ]);
            }

            $path = storage_path('tmp/uploads');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file = $request->file('file');
            $name = uniqid() . '_' . trim($file->getClientOriginalName());
            $file->move($path, $name);

            $menuItem->addMedia(storage_path('tmp/uploads/' . $name))->toMediaCollection('menu-items');
            return response()->json([
                'name'          => $name,
                'original_name' => $file->getClientOriginalName(),
            ]);
        }
    }

    public function removeMedia(Request $request)
    {
        $menuItem = MenuItem::owner()->find($request->id);
        $menuItem->deleteMedia($menuItem, $request->media, $request->id);
        return $this->getMedia($request);
    }

    public function modify($id)
    {
        $menuItem = MenuItem::owner()->findOrFail($id);

        $this->data['menuItem']             = $menuItem;
        $this->data['menu_item_variations'] = $menuItem->variations;
        $this->data['menu_item_options']    = $menuItem->options;

        return view('admin.menu-item.modify', $this->data);
    }

    public function modifyUpdate(Request $request, $id)
    {
        if (blank($request->all())) {
            return redirect(route('admin.menu-items.modify', $id))->withError("The meun item variation/option required.");
        }

        $menuItem       = MenuItem::owner()->findOrFail($id);

        $variationArray = $request->variation;

        if (!blank($variationArray)) {
            $requestArray['variation.*.name']           = ['required', 'string'];
            $requestArray['variation.*.price']          = ['required', 'numeric', 'gt:0', new IniAmount()];
            $requestArray['variation.*.discount_price'] = ['nullable', 'numeric', 'gte:0', new IniAmount()];
        }

        $requestArray['option.*.name']  = ['nullable', 'string'];
        $requestArray['option.*.price'] = ['nullable', 'numeric', 'gt:0', new IniAmount()];

        $validator = Validator::make($request->all(), $requestArray);
        $validator->after(function ($validator) use ($request) {
            $requestVariationArray = $request->variation;
            if (!blank($requestVariationArray)) {
                foreach ($requestVariationArray as $key => $variation) {
                    if ($this->priceValidationCheck($variation)) {
                        $validator->errors()->add("variation.$key.discount_price", 'This discount price cann\'t be greater than unit price.');
                    }
                }
            }
        });

        if ($validator->fails()) {
            $sessionVariationArray = !blank($request->variation) ? array_keys($request->variation) : [];
            $request->session()->flash('variation', $sessionVariationArray);

            $sessionOptionArray = !blank($request->option) ? array_keys($request->option) : [];
            $request->session()->flash('option', $sessionOptionArray);
            return redirect(route('admin.menu-items.modify', $menuItem))->withErrors($validator)->withInput();
        }

        if (!blank($variationArray)) {

            $key                = array_key_first($variationArray);

            $smallPrice         = isset($variationArray[$key]) ? $variationArray[$key]['price'] : 0;
            $smallDiscountPrice = isset($variationArray[$key]) ? $variationArray[$key]['discount_price'] : 0;

            $menuItemVariation = MenuItemVariation::where('menu_item_id', $menuItem->id)->get()->pluck('id', 'id')->toArray();

            $setVariationArray = [];
            foreach ($variationArray as $key => $variation) {

                $setVariationArray[$key] = $key;

                if ($variation['price'] < $smallPrice) {
                    $smallPrice         = $variation['price'];
                    $smallDiscountPrice = $variation['discount_price'];
                }

                if (isset($menuItemVariation[$key])) {
                    $menuItemVariationItem = MenuItemVariation::where(['id' => $key])->first();

                    $menuItemVariationItem->menu_item_id   = $menuItem->id;
                    $menuItemVariationItem->restaurant_id  = $menuItem->restaurant_id;
                    $menuItemVariationItem->name           = $variation['name'];
                    $menuItemVariationItem->price          = $variation['price'];
                    $menuItemVariationItem->discount_price = $variation['discount_price'] ?? 0;
                    $menuItemVariationItem->save();
                } else {
                    $menuItemVariationArray['menu_item_id']   = $menuItem->id;
                    $menuItemVariationArray['restaurant_id']  = $menuItem->restaurant_id;
                    $menuItemVariationArray['name']           = $variation['name'];
                    $menuItemVariationArray['price']          = $variation['price'];
                    $menuItemVariationArray['discount_price'] = $variation['discount_price'] ?? 0;
                    MenuItemVariation::insert($menuItemVariationArray);
                }
            }

            $menuItem->unit_price     = $smallPrice;
            $menuItem->discount_price = $smallDiscountPrice ?? 0;
            $menuItem->save();

            $deleteArray = array_diff($menuItemVariation, $setVariationArray);
            if (!blank($deleteArray)) {
                MenuItemVariation::whereIn('id', $deleteArray)->delete();
            }
        }

        MenuItemOption::where('menu_item_id', $id)->delete();
        $mainOptionArray = $request->option;
        if (!blank($mainOptionArray)) {
            $i           = 0;
            $optionArray = [];
            foreach ($mainOptionArray as $option) {
                if ($option['name'] == '' || $option['price'] == '') {
                    continue;
                }
                $optionArray[$i]['restaurant_id'] = $menuItem->restaurant_id;
                $optionArray[$i]['menu_item_id']  = $id;
                $optionArray[$i]['name']          = $option['name'];
                $optionArray[$i]['price']         = $option['price'];
                $i++;
            }
            MenuItemOption::insert($optionArray);
        }

        return redirect(route('admin.menu-items.modify', $id))->withSuccess("The Meun item updated successfully.");
    }

    private function priceValidationCheck($array)
    {
        if ($array['price'] < $array['discount_price']) {
            return true;
        }
        return false;
    }
    function checkMenuNumber($menu_array)
    {
        $menuNumber = rand(1000, 9999);
        $menuNumber = in_array($menuNumber, $menu_array) ? $this->checkMenuNumber($menu_array) : $menuNumber;
        return $menuNumber;
    }
}
