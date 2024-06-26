<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

     public $data;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $this->data['site_title'] = 'login';
        return view('auth.login', $this->data);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    protected function authenticated(Request $request, $user)
    {
        if($user->status != 5) {
            auth()->logout();
            return redirect(route('login'))->withBlock('Your account currently inactive. you can\'t login our system.')->withInput();
        }
        // if ($this->checkCartContent()) {
        //     return redirect(route('checkout.index'));
        // }
        if('admin' == $request->type){
            return redirect(route('admin.dashboard.index'));
        }else{
            return redirect(route('home'));
        }
    }

    // private function checkCartContent()
    // {
    //     return blank(Cart::content()) ? false : true;
    // }
}
