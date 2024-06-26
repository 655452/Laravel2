<?php

namespace App\Imports;

use App\Models\User;
use App\Enums\UserStatus;
use App\Enums\TableStatus;
use App\Models\Restaurant;
use App\Enums\PickupStatus;
use App\Enums\CurrentStatus;
use App\Enums\DeliveryStatus;
use App\Enums\RestaurantStatus;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Http\Services\DepositService;




class RestaurantImport implements ToModel, WithHeadingRow ,WithValidation , SkipsEmptyRows
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $user                   = new User;
        $user->address          = $row['address'];
        $user->first_name       = $row['first_name'];
        $user->last_name        = $row['last_name'];
        $user->email            = $row['email'];
        $user->username         = generateUsername($row['email']);
        $user->password         = bcrypt($row['password']);
        $user->phone            = $row['phone'];
        $user->status           =  $row['user_status'] ? UserStatus::ACTIVE : UserStatus::INACTIVE;
        $user->save();

        $role = Role::find(3);
        $user->assignRole($role->name);

        $restaurant                         = new Restaurant;
        $restaurant->user_id                = $user->id;
        $restaurant->name                   = $row['name'];
        $restaurant->description            = $row['description'];
        $restaurant->opening_time           = $row['opening_time'];
        $restaurant->closing_time           = $row['closing_time'];
        $restaurant->lat                    = $row['latitude'];
        $restaurant->long                   = $row['longitude'];
        $restaurant->address                = $row['address'];
        $restaurant->applied                = false;
        $restaurant->status                 =$row['status'] ? RestaurantStatus::ACTIVE : RestaurantStatus::INACTIVE;
        $restaurant->current_status         = $row['current_status'] ? CurrentStatus::YES : CurrentStatus::NO;
        $restaurant->delivery_status        = $row['delivery_status'] ? DeliveryStatus::ENABLE:DeliveryStatus::DISABLE;
        $restaurant->pickup_status          = $row['pickup_status'] ? PickupStatus::ENABLE : PickupStatus::DISABLE;
        $restaurant->table_status           = $row['table_status'] ? TableStatus::ENABLE : TableStatus::DISABLE;

        $depositAmount = $row['deposit_amount'];
        if (blank($depositAmount)) {
            $depositAmount = 0;
        }

        $limitAmount = 0;
        $depositService = app(DepositService::class)->depositAdjust($user->id, $depositAmount, $limitAmount);
        return $restaurant;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string', 'max:60'],
            'first_name' => ['required','string','max:60'],
            'last_name' => ['required','string','max:60'],
            'address' => ['required','max:200',],
            'phone' => ['required','numeric',],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'email' => ['required','string',Rule::unique("users", "email")],
            'password' => ['required'],
        ];
    }
}
