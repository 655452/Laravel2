<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Exception;
use Socialite;
use App\Libraries\MyString;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialController extends Controller
{ 
    public $valid_provider = [
        'google',
        'facebook'
    ];

    public function socialRedirect($provider)
    {
        if (in_array($provider, $this->valid_provider)) {
            return Socialite::driver($provider)->redirect();
        }
    }
    public function loginWithSocial($provider)
    {
        try {
            if (in_array($provider, $this->valid_provider)) {
                $user_social = Socialite::driver($provider)->user();
                $isUser = User::where('email', '=', $user_social->getEmail())
                    ->orWhere('provider_id', $user_social->id)
                    ->first();



                if ($isUser) {
                    Auth::login($isUser);
                    return redirect()->route('home');
                } else {

                    $first_name = '';
                    $last_name  = '';
                    $parts      = $this->split_name($user_social->getName());
                    $first_name = $parts[0];
                    $last_name  = $parts[1];


                    $username = '';
                    $username = $this->username($user_social->getEmail());


                    $user     = User::create([
                        'first_name'              => $first_name,
                        'last_name'              => $last_name,
                        'email'             => $user_social->getEmail(),
                        'email_verified_at' => now(),
                        'username'          => $username,
                        'password'          => Hash::make('123456'),
                        'provider_id'       => $user_social->id,
                        'provider'          => $provider,
                    ]);
                    $role     = Role::find(2);
                    $user->assignRole($role->name);

                    Auth::login($user);
                    return redirect(route('home'));
                }
            }
            return redirect()->route('login');
        } catch (Exception $exception) {
        }
    }

    private function split_name($name)
    {
        $name       = trim($name);
        $last_name  = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
        return [$first_name, $last_name];
    }

    private function username($email)
    {
        $emails = explode('@', $email);
        return $emails[0] . mt_rand();
    }
}
