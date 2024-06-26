<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Carbon\Carbon;
use App\Enums\Status;
use App\Models\Order;
use App\Models\Cuisine;
use App\Models\MenuItem;
use App\Enums\UserStatus;
use App\Enums\OrderStatus;
use App\Models\Restaurant;
use App\Enums\WaiterStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\RestaurantStatus;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Yajra\Datatables\Datatables;
use App\Imports\RestaurantImport;
use Spatie\Permission\Models\Role;
use App\Http\Services\DepositService;
use App\Http\Requests\RestaurantRequest;
use App\Http\Controllers\BackendController;
use App\Http\Requests\RestaurantStoreRequest;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\Http;

class RestaurantController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Restaurants';
        $this->middleware('license-activate');
        $this->middleware(['permission:restaurants'])->only('index');
        $this->middleware(['permission:restaurants_create'])->only('create', 'store');
        $this->middleware(['permission:restaurants_edit'])->only('edit', 'update');
        $this->middleware(['permission:restaurants_delete'])->only('destroy');
        $this->middleware(['permission:restaurants_show'])->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->myrole == 3) {
            $restaurantID = auth()->user()->restaurant->id ?? 0;
            if ($restaurantID == 0) {
                $this->data['cuisines'] = Cuisine::with('media')->where(['status' => Status::ACTIVE])->get();
                return view('admin.restaurant.restaurantCreate', $this->data);
            }
            return $this->show($restaurantID);
        }

        return view('admin.restaurant.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->data['cuisines'] = Cuisine::with('media')->where(['status' => Status::ACTIVE])->get();

        return view('admin.restaurant.create', $this->data);
    }

    /**
     * @param RestaurantRequest $request
     * @return mixed
     */
    public function store(RestaurantRequest $request)
    {
        $user             = new User;
        $user->first_name = $request->get('first_name');
        $user->last_name  = $request->get('last_name');
        $user->email      = $request->get('email');
        $user->username   = $request->username ?? generateUsername($request->email);
        $user->phone      = $request->get('phone');
        $user->address    = $request->get('address');
        $user->status     = $request->get('userstatus');
        $user->password   = bcrypt($request->get('password'));
        $user->save();

        $role = Role::find(3);
        $user->assignRole($role->name);

        $restaurant                  = new Restaurant;
        $restaurant->user_id         = $user->id;
        $restaurant->name            = $request->name;
        $restaurant->description     = $request->description;
        $restaurant->lat             = $request->lat;
        $restaurant->long            = $request->long;
        $restaurant->opening_time    = date('H:i:s', strtotime($request->opening_time));
        $restaurant->closing_time    = date('H:i:s', strtotime($request->closing_time));
        $restaurant->address         = $request->restaurantaddress;
        $restaurant->current_status  = $request->current_status;
        $restaurant->waiter_status   = $request->waiter_status;
        $restaurant->delivery_status = $request->delivery_status;
        $restaurant->pickup_status   = $request->pickup_status;
        $restaurant->table_status    = $request->table_status;
        $restaurant->status          = $request->status;
        if ($user->status == UserStatus::INACTIVE) {
            $restaurant->status = RestaurantStatus::INACTIVE;
        }
        $restaurant->applied = false;
        $restaurant->save();
        $restaurant->cuisines()->sync($request->get('cuisines'));

        
        //Store Image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $restaurant->addMediaFromRequest('image')->toMediaCollection('restaurant');
        }
        if ($request->hasFile('restaurant_logo') && $request->file('restaurant_logo')->isValid()) {
            $restaurant->addMediaFromRequest('restaurant_logo')->toMediaCollection('restaurant_logo');
        }
        $depositAmount = $request->deposit_amount;
        if (blank($depositAmount)) {
            $depositAmount = 0;
        }
        $limitAmount = $request->limit_amount;
        if (blank($limitAmount)) {
            $limitAmount = 0;
        }
        $depositService = app(DepositService::class)->depositAdjust($user->id, $depositAmount, $limitAmount);
        if ($depositService->status) {
            return redirect(route('admin.restaurants.index'))->withSuccess('The Data Inserted Successfully');
        }
        return redirect(route('admin.restaurants.index'))->withError($depositService->message);
    }

 
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $this->data['restaurant']          = Restaurant::restaurantowner()->findOrFail($id);
        $this->data['cuisines']            = Cuisine::where(['status' => Status::ACTIVE])->get();
        $this->data['restaurant_cuisines'] =  $this->data['restaurant']->cuisines()->pluck('id')->toArray();
        return view('admin.restaurant.edit', $this->data);
    }

    /**
     * @param RestaurantRequest $request
     * @param restaurant $restaurant
     * @return mixed
     */
    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        if (!blank($restaurant->user)) {
            $user = $restaurant->user;

            $depositAmount  = blank($request->deposit_amount) ? 0 : $request->deposit_amount;
            $limitAmount    = blank($request->limit_amount) ? 0 : $request->limit_amount;
            $depositService = app(DepositService::class)->depositAdjust($user->id, $depositAmount, $limitAmount);

            if ($depositService->status) {

                $user->first_name = $request->get('first_name');
                $user->last_name  = $request->get('last_name');
                $user->email      = $request->get('email');
                $user->username   = $request->username ?? generateUsername($request->email);
                $user->phone      = $request->get('phone');
                $user->address    = $request->get('address');
                $user->status     = $request->get('userstatus');

                if (!blank($request->get('password')) && (strlen($request->get('password')) >= 4)) {
                    $user->password = bcrypt($request->get('password'));
                }

                $user->save();

                $role = Role::find(3);
                $user->assignRole($role->name);

                $restaurant->user_id         = $user->id;
                $restaurant->name            = $request->name;
                $restaurant->description     = $request->description;
                $restaurant->lat             = $request->lat;
                $restaurant->long            = $request->long;
                $restaurant->opening_time    = date('H:i:s', strtotime($request->opening_time));
                $restaurant->closing_time    = date('H:i:s', strtotime($request->closing_time));
                $restaurant->address         = $request->restaurantaddress;
                $restaurant->current_status  = $request->current_status;
                $restaurant->waiter_status   = $request->waiter_status;
                $restaurant->delivery_status = $request->delivery_status;
                $restaurant->pickup_status   = $request->pickup_status;
                $restaurant->table_status    = $request->table_status;
                $restaurant->status          = $request->status;
                if ($user->status == UserStatus::INACTIVE) {
                    $restaurant->status = RestaurantStatus::INACTIVE;
                }
                $restaurant->save();
                $restaurant->cuisines()->sync($request->get('cuisines'));


                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $this->deleteMedia('restaurant', $restaurant->id);
                    $restaurant->addMediaFromRequest('image')->toMediaCollection('restaurant');
                }

                if ($request->hasFile('restaurant_logo') && $request->file('restaurant_logo')->isValid()) {
                    $this->deleteMedia('restaurant_logo', $restaurant->id);
                    $restaurant->addMediaFromRequest('restaurant_logo')->toMediaCollection('restaurant_logo');
                }

                return redirect(route('admin.restaurants.index'))->withSuccess('The data updated successfully.');
            }
            return redirect(route('admin.restaurants.index'))->withError($depositService->message);
        }
        return redirect(route('admin.restaurants.index'))->withError('The user not found.');
    }

    public function show($id)
    {
        $restaurant = Restaurant::restaurantowner()->findOrFail($id);
        if (blank($restaurant->user)) {
            return redirect(route('admin.restaurant.index'))->withError('The user not found.');
        }
        $orders = Order::where(['restaurant_id' => $id])->whereDate('created_at', Carbon::today())->orderowner()->get();

        $this->data['total_order']     = $orders->count();
        $this->data['pending_order']   = $orders->where('status', OrderStatus::PENDING)->count();
        $this->data['process_order']   = $orders->where('status', OrderStatus::PROCESS)->count();
        $this->data['completed_order'] = $orders->where('status', OrderStatus::COMPLETED)->count();

        $this->data['restaurant'] = $restaurant;
        $this->data['user']       = $restaurant->user;

        return view('admin.restaurant.show', $this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Restaurant::restaurantowner()->findOrFail($id)->delete();
        return redirect(route('admin.restaurants.index'))->withSuccess('The Data Deleted Successfully');
    }

    public function getRestaurant(Request $request)
    {
        if (request()->ajax()) {

            $queryArray = [];
            if (!empty($request->status) && (int) $request->status) {
                $queryArray['status'] = $request->status;
            }

            if (!empty($request->applied)) {
                $queryArray['applied'] = $request->applied;
            }

            if (!blank($queryArray)) {
                $restaurants = Restaurant::where($queryArray)->restaurantowner()->descending()->select();
            } else {
                $restaurants = Restaurant::restaurantowner()->descending()->select();
            }

            $i = 0;
            return Datatables::of($restaurants)
                ->addColumn('action', function ($restaurant) {
                    $retAction = '';

                    if (auth()->user()->can('restaurants_show')) {
                        $retAction .= '<a href="' . route('admin.restaurants.show', $restaurant) . '" class="btn btn-sm btn-icon float-left btn-info mr-2" data-toggle="tooltip" data-placement="top" title="View"> <i class="far fa-eye"></i></a>';
                    }

                    if (auth()->user()->can('restaurants_edit')) {
                        $retAction .= '<a href="' . route('admin.restaurants.edit', $restaurant) . '" class="btn btn-sm btn-icon float-left btn-primary mr-2" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('restaurants_delete')) {
                        $retAction .='<form id="detete-'.$restaurant->id.'" class="float-left" action="' . route('admin.restaurants.destroy', $restaurant) . '" method="POST">'
                        . method_field('DELETE') . csrf_field() . '
                            <button type="button" data-id="'.$restaurant->id.'"
                            class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                            <i class="fa fa-trash"></i>  </button> </form>';
                    }
                    return $retAction;
                })
                ->editColumn('user_id', function ($restaurant) {
                    return Str::limit($restaurant->user->name ?? null, 20);
                })
                ->editColumn('status', function ($restaurant) {
                    return ($restaurant->status == 5 ? trans('statuses.' . Status::ACTIVE) : trans('statuses.' . Status::INACTIVE));
                })
                ->editColumn('waiter_status', function ($restaurant) {
                    return ($restaurant->waiter_status == 5 ? trans('waiter_statuses.' . WaiterStatus::ACTIVE) : trans('waiter_statuses.' . WaiterStatus::INACTIVE));
                })
                ->editColumn('id', function ($restaurant) use (&$i) {
                    $i++;
                    return $i;
                })
                ->make(true);
        }
    }

    public function getMenuItem(Request $request)
    {
        if (request()->ajax()) {
            $queryArray = [];
            if (!empty($request->restaurant_id) && (int) $request->restaurant_id) {
                $queryArray['restaurant_id'] = $request->restaurant_id;
            }

            if (!blank($queryArray)) {
                $menuItems = MenuItem::owner()->with('categories')->where($queryArray)->descending()->select();
            } else {
                $menuItems = MenuItem::owner()->with('categories')->descending()->select();
            }

            $i = 0;
            return Datatables::of($menuItems)
                ->addColumn('action', function ($menuItem) {
                    $retAction = '';

                    if (auth()->user()->can('menu-items_show')) {

                        $retAction .= '<a href="' . route('admin.menu-items.modify', $menuItem) . '" class="btn btn-sm btn-icon float-left btn-success mr-2" data-toggle="tooltip" data-placement="top" title="Add Variation/Option"> <i class="far fa-list-alt"></i></a>';

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
                ->editColumn('created_at', function ($menuItem) {
                    return $menuItem->created_at->diffForHumans();
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
    }

    public function restaurantStore(RestaurantStoreRequest $request)
    {
        $restaurant                  = new Restaurant;
        $restaurant->user_id         = auth()->id();
        $restaurant->name            = $request->name;
        $restaurant->description     = $request->description;
        $restaurant->lat             = $request->lat;
        $restaurant->long            = $request->long;
        $restaurant->opening_time    = date('H:i:s', strtotime($request->opening_time));
        $restaurant->closing_time    = date('H:i:s', strtotime($request->closing_time));
        $restaurant->address         = $request->address;
        $restaurant->current_status  = $request->current_status;
        $restaurant->waiter_status   = $request->waiter_status;
        $restaurant->delivery_status = $request->delivery_status;
        $restaurant->pickup_status   = $request->pickup_status;
        $restaurant->table_status    = $request->table_status;
        $restaurant->status          = RestaurantStatus::INACTIVE;
        $restaurant->applied         = true;
        $restaurant->save();
        $restaurant->cuisines()->sync($request->get('cuisines'));

        //Store Image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $restaurant->addMediaFromRequest('image')->toMediaCollection('restaurant');
        }
        if ($request->hasFile('restaurant_logo') && $request->file('restaurant_logo')->isValid()) {
            $restaurant->addMediaFromRequest('restaurant_logo')->toMediaCollection('restaurant_logo');
        }
        return redirect(route('admin.restaurants.index'))->withSuccess('The data inserted successfully.');
    }

    public function restaurantEdit($id)
    {
        $this->data['restaurant'] = Restaurant::restaurantowner()->findOrFail($id);
        $this->data['cuisines']         = Cuisine::where(['status' => Status::ACTIVE])->get();
        $this->data['restaurant_cuisines'] =  $this->data['restaurant']->cuisines()->pluck('id')->toArray();
        return view('admin.restaurant.restaurantEdit', $this->data);
    }

    public function restaurantUpdate(RestaurantStoreRequest $request, $id)
    {
        $restaurant = Restaurant::restaurantowner()->findOrFail($id);

        $restaurant->user_id         = auth()->id();
        $restaurant->name            = $request->name;
        $restaurant->description     = $request->description;
        $restaurant->lat             = $request->lat;
        $restaurant->long            = $request->long;
        $restaurant->opening_time    = date('H:i:s', strtotime($request->opening_time));
        $restaurant->closing_time    = date('H:i:s', strtotime($request->closing_time));
        $restaurant->address         = $request->address;
        $restaurant->current_status  = $request->current_status;
        $restaurant->waiter_status   = $request->waiter_status;
        $restaurant->delivery_status = $request->delivery_status;
        $restaurant->pickup_status   = $request->pickup_status;
        $restaurant->table_status    = $request->table_status;
        $restaurant->applied         = true;
        $restaurant->save();
        $restaurant->cuisines()->sync($request->get('cuisines'));

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $this->deleteMedia('restaurant', $restaurant->id);
            $restaurant->addMediaFromRequest('image')->toMediaCollection('restaurant');
        }
        if ($request->hasFile('restaurant_logo') && $request->file('restaurant_logo')->isValid()) {
            $this->deleteMedia('restaurant_logo', $restaurant->id);
            $restaurant->addMediaFromRequest('restaurant_logo')->toMediaCollection('restaurant_logo');
        }
        return redirect(route('admin.restaurants.index'))->withSuccess('The data updated successfully.');
    }

    public function deleteMedia($mediaName, $mediaId)
    {
        $media = Media::where([
            'collection_name' => $mediaName,
            'model_id' => $mediaId,
            'model_type' => Restaurant::class,
        ])->first();

        if ($media) {
            $media->delete();
        }
    }

    public function fileImportExport()
    {
        if (auth()->user()->myrole == 1) {
            return view('admin.import.restaurantImport');
        }
        return view('errors.403');
    }

    public function fileImport(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);
        try {
            $import = new RestaurantImport();
            $import->import($request->file('file'));
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $importErrors = [];
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
                $importErrors[$failure->row()][] = $failure->errors()[0];
            }
            return back()->with('importErrors', $importErrors);
        }

        return back()->withSuccess('The Data Inserted Successfully');
    }
}
