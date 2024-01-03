<?php

namespace App\Http\Controllers\AuthAbsensi;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        return [
            'username' => request()->username,
            'password' => request()->password,
            // 'is_active' => 1
        ];
    }

    public function login(Request $request)
    {   
        $input = $request->all();
  
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ],[
            'username.required' => 'NIK / Username Wajib diisi',
            'password.required' => 'Password Wajib diisi'
        ]);
        
        // if(auth()->attempt(array($input['username'])))
        // $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'])))
        {
            auth()->logoutOtherDevices(request()->password);
            return redirect()->route('absensi.home');
            // return redirect()->intended();
        }else{
            // return redirect()->route('login')
            //     ->with('error','Username / Password Salah.');
        }
    }
}
