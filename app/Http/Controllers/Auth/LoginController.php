<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Providers\RouteServiceProvider;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    //protected $redirectTo = RouteServiceProvider::HOME;

    protected $redirectTo;

    protected function redirectTo() {
        $type = Session::get('type');
        if (Auth::check() && $type == 'employer_login' && Auth::user()->user_type != 'employee'){
            $user = User::find(Auth::id());
            $user->user_type = 'seller';
            $user->save();
            $seller = Seller::where('user_id',Auth::id())->first();
            $seller->employer_status = 1;
            $seller->save();
            return $this->redirectTo = route('employer-dashboard');
        }
        if (Auth::check() && $type == 'work_order_login' && Auth::user()->user_type == 'buyer'){
            return $this->redirectTo = route('buyer.work-order.dashboard');
        }
        if (Auth::check() && $type == 'work_order_login' && Auth::user()->user_type == 'seller'){
            return $this->redirectTo = route('seller.work-order.dashboard');
        }
        if (Auth::check() && Auth::user()->user_type == 'buyer') {
            return $this->redirectTo = route('buyer.dashboard');
        }
        elseif (Auth::check() && Auth::user()->user_type == 'seller') {
            return $this->redirectTo = route('seller.dashboard');
        }
        elseif (Auth::check() && Auth::user()->user_type == 'employee') {
            return $this->redirectTo = route('employee.dashboard');
        }
        else {
            return('/');
        }
    }



//    protected function credentials(Request $request)
//    {
//        if(is_numeric($request->get('email'))){
//            return ['phone'=>$request->get('email'),'password'=>$request->get('password')];
//        }
//        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
//            return ['email' => $request->get('email'), 'password'=>$request->get('password')];
//        }
//        return ['username' => $request->get('email'), 'password'=>$request->get('password')];
//    }

    protected function credentials(Request $request)
    {
        Session::put('password',$request->get('password'));
        return ['phone' => $request->get('phone'), 'password'=>$request->get('password'),'banned'=>0];
    }

    public function username()
    {
        return 'phone';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
