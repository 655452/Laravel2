<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DeliveryBoyAccount;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	 */

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make(
			$data,
			[
				'roles'           => ['required', 'numeric'],
				'first_name'      => ['required', 'string', 'max:255'],
				'last_name'       => ['required', 'string', 'max:255'],
				'phone'           => ['required', 'numeric'],
				'address'         => ['nullable', 'string', 'max:255'],
				'register_email'  => ['required', 'string', 'email', Rule::unique("users", "email"), 'email', 'max:100'],
				'username'        => request('username') ? ['required', 'string', Rule::unique("users", "username"), 'max:60'] : ['nullable'],
				'password'        => ['required', 'string', 'min:6', 'confirmed'],
				'countrycode'     => ['required', 'numeric'],
				'countrycodename' => ['required', 'string', 'max:255'],
			],
			[
				'register_email.required' => 'The Email field is required.'
			]
		);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\Models\User
	 */
	protected function create(array $data)
	{
		$user = User::create([
			'first_name'        => $data['first_name'],
			'last_name'         => $data['last_name'],
			'username'          => $data['username'] ?? $this->username($data['register_email']),
			'phone'             => $data['phone'],
			'address'           => $data['address'],
			'email'             => $data['register_email'],
			'password'          => Hash::make($data['password']),
			'country_code'      => $data['countrycode'],
			'country_code_name' => $data['countrycodename'],
		]);

		$role = Role::find($data['roles']);
		if (!blank($user) && !blank($role)) {
			$user->assignRole($role->name);
		}

		if (!blank($role) && ($role->id == 4)) {
			$deliveryBoyAccount                  = new DeliveryBoyAccount();
			$deliveryBoyAccount->user_id         = $user->id;
			$deliveryBoyAccount->delivery_charge = 0;
			$deliveryBoyAccount->balance         = 0;
			$deliveryBoyAccount->save();
		}
		return $user;
	}


	private function username($email)
	{
		$emails = explode('@', $email);
		return $emails[0] . mt_rand();
	}
}
