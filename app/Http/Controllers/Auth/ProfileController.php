<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use DB;
use Hash;

class ProfileController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.profile.index', [
            'title' => 'Thông tin cá nhân',
        ]);
    }

    public function updateName()
    {
        $name = request('name');
        if (!isset($name) || strlen($name) < 7) {
            return ['code' => 'ERROR', 'message' => 'Tên không xác định hoặc không đủ độ dài tối thiểu 7 ký tự'];
        }
        /* dd($name, auth()->user()->user_id); */
        try {
            DB::table('users')
                ->where('user_id', auth()->user()->user_id)
                ->update(['name' => $name]);
        } catch (\Exception $e) {
            return ['code' => 'ERROR', 'message' => $e->errorInfo];
        }

        return ['code' => 'SUCCESS'];
    }

    public function changePassword()
    {
        $input = request()->all();
        $validation = validator($input, [
            'password' => 'required|max:100|min:8',
            'password_new' =>   'required|max:100|min:8',
        ]);
        if ($validation->fails()) {
            return ['code' => 'ERROR', 'message' =>  ' Mật khẩu ít nhất 8 ký tự ' , 'error' => $validation->errors()];
        }
        $password = $input['password'];
        $password_new = $input['password_new'];

        if (!Hash::check($password, auth()->user()->password)) {
            return ['code' => 'ERROR', 'message' => 'Mật khẩu không khớp'];
        }

        /* dd($name, auth()->user()->user_id); */
        try {
            DB::table('users')
                ->where('id', auth()->user()->id)
                ->update([
                    'password' => bcrypt($password_new),
                    'updated_at' => now(),
                ]);
        } catch (\Exception $e) {
            return ['code' => 'ERROR', 'message' => $e->errorInfo];
        }
        return ['code' => 'SUCCESS'];
    }
}
