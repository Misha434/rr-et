<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;

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
     * ログアウトしたときの画面遷移先
     */
    protected function loggedOut(\Illuminate\Http\Request $request)
    {
        return redirect()->route('home')->with('status', 'ログアウトしました。');
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

    public function guestLogin()
    {
        $email = "guest-user@example.com";
        $password = "AwRto3CFzREx7g";

        if ($guestUser = User::where('email', $email)->first()) {
            Auth::loginUsingID($guestUser->id, true);
            return redirect()->route('scripts.index')->with('status', 'ゲストユーザーとしてログインしました。');
            ;
        } else {
            $createdGuestUser = User::create([
                'name' => "Guest",
                'email' => $email,
                'password' => $password,
            ]);

            Auth::loginUsingID($createdGuestUser->id, true);
            return redirect()->route('scripts.index')->with('status', 'ゲストユーザーとしてログインしました。');
        }
    }
}
