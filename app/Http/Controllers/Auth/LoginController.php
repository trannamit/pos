<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('homePage')->with(['code' => 'ERROR', 'message' => 'logged ']);
        }
        return view('login.index', [
            'title' => 'Đăng nhập'
        ]);
    }

    public function login()
    {
        $input = (request()->all());

        $validator = validator($input, [
            'username' => 'required| max:100',
            'password' => 'required| max:100',
        ]);

        if ($validator->fails()) {
            return ['code' => 'ERROR', 'message' => $validator->errors()];
        }

        $credentials = [
            'user_id' => $input['username'],
            'password' => $input['password'],
        ];

        if (!auth()->attempt($credentials)) {
            return ['code' => 'ERROR', 'message' => 'user or password is incorrect'];
        }
        return ['code' => 'SUCCESS', 'userName' => auth()->user()->name];
    }

    public function logOut()
    {
        auth()->logOut();
        return redirect()->route('login')->with(['code' => 'SUCCESS', 'message' => 'log-out complete ']);
    }
}
