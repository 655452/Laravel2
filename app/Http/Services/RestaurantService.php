<?php


namespace App\Http\Services;


use App\Enums\CurrentStatus;
use App\Models\User;
use Carbon\Carbon;
use App\Enums\Status;
use App\Models\Order;
use App\Models\Cuisine;
use App\Models\MenuItem;

use App\Enums\UserStatus;
use App\Enums\OrderStatus;
use App\Models\Restaurant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\RestaurantStatus;
use Spatie\Permission\Models\Role;

class RestaurantService
{
    public function getallrestaurant($id,$status,$applied)
    {

        if(is_null($id)){
            $queryArray = [];
            $queryArray['status']=RestaurantStatus::ACTIVE;
            $queryArray['current_status']=CurrentStatus::YES;

            if (!empty($applied)) {
                $queryArray['applied'] = $applied;
            }
            $current_time = now()->format('H:i');
            if (!blank($queryArray)) {
                $restaurants = Restaurant::where([['opening_time', '>', 'closing_time'],['opening_time', '<', $current_time]])
                    ->Orwhere([['opening_time', '<', 'closing_time'],['opening_time', '<', $current_time],['closing_time', '>', $current_time]])
                    ->where($queryArray)->restaurantowner()->descending()->select()->get();
            } else {
                $restaurants = Restaurant::where([['opening_time', '>', 'closing_time'],['opening_time', '<', $current_time]])
                    ->Orwhere([['opening_time', '<', 'closing_time'],['opening_time', '<', $current_time],['closing_time', '>', $current_time]])->
                    restaurantowner()->descending()->select()->get();
            }

            return  $restaurants;
        }
       return  $this->show($id);


    }

    public function show($id)
    {

        if ($id == 0) {
            $this->data['cuisines'] = Cuisine::where(['status' => Status::ACTIVE])->get();
            return $this->data;
        }
        $restaurant = Restaurant::restaurantowner()->findOrFail($id);
        if (blank($restaurant->user)) {
            $this->data['error']='the user not found';
            return $this->data;
        }
        $orders = Order::where(['restaurant_id' => $id])->whereDate('created_at', Carbon::today())->orderowner()->get();

        $this->data['total_order']     = $orders->count();
        $this->data['pending_order']   = $orders->where('status', OrderStatus::PENDING)->count();
        $this->data['process_order']   = $orders->where('status', OrderStatus::PROCESS)->count();
        $this->data['completed_order'] = $orders->where('status', OrderStatus::COMPLETED)->count();

        $this->data['restaurant'] = $restaurant;
        $this->data['images'] = $this->getMedia( $id);
        $this->data['menuitems'] = $this->getMenuItem($id);


        return  $this->data;
    }

    public function store(Request $request)
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
        if ( !blank($request->input('document')) ) {
            foreach ($request->input('document', []) as $file) {
                $restaurant->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('restaurant');
            }
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
            $message='Restaurant saved';
            return $message;
        }
        $message=$depositService->message;
        return $message;
    }



    public function update( $request,$restaurant)
    {

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
                    $restaurant->media()->delete($restaurant->id);
                    $restaurant->addMediaFromRequest('image')->toMediaCollection('restaurant');
                }
                $message='The data updated successfully.';
                return $message;
            }
            $message=$depositService->message;
            return $message;

    }

    public function delete($table)
    {
        $table->delete();
    }
    public function getMenuItem($id)
    {

            $queryArray = [];
            if (!empty($id) && (int) $id) {
                $queryArray['restaurant_id'] = $id;
            }

            if (!blank($queryArray)) {
                $menuItems = MenuItem::owner()->with('categories')->where($queryArray)->descending()->select();
            } else {
                $menuItems = MenuItem::owner()->with('categories')->descending()->select();
            }

            return $menuItems;

    }
    public function getMedia( $id)
    {
        $restaurant   = Restaurant::find($id);
        $addMedias = $restaurant->getMedia('restaurant');
        $retArr    = [];
        if ( count($addMedias) ) {
            $i = 0;
            foreach ( $addMedias as $addMedia ) {
                $i++;
                $retArr[ $i ]['name'] = $addMedia->file_name;
                $retArr[ $i ]['size'] = $addMedia->size;
                $retArr[ $i ]['url']  = asset($addMedia->getUrl());
            }
        }
        return $retArr;
    }
    public function storeMedia( $request)
    {
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
    public function updateMedia( $request,$restaurant)
    {
        $path = storage_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);
        $restaurant->addMedia($path.'/'.$name)->toMediaCollection('restaurant');

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function deleteMedia(Request $request)
    {
        $path = storage_path('tmp/uploads/' . $request->filename);
        if ( file_exists($path) ) {
            unlink($path);
        }
    }


    public function removeMedia( Request $request )
    {
        $restaurant = Restaurant::find($request->id);
        $restaurant->deleteMedia($restaurant, $request->media, $request->id);
        return $this->getMedia($request);
    }


}
