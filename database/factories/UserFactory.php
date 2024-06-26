<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;



class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $roleArray = [UserRole::ADMIN, UserRole::CUSTOMER, UserRole::RESTAURANTOWNER, UserRole::DELIVERYBOY];

        static $password;
        return [
            'first_name'     => $this->faker->firstName,
            'last_name'      => $this->faker->lastName,
            'username'       => $this->faker->userName,
            'email'          => $this->faker->unique()->safeEmail,
            'phone'          => $this->faker->phoneNumber,
            'address'        => $this->faker->address,
            'roles'          => $roleArray[array_rand($roleArray, 1)],
            'password'       => $password ?: $password = bcrypt('123456'),
            'remember_token' => Str::random(10),
        ];
    }
}
