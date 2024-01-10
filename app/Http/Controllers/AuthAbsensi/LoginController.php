<?php

namespace App\Http\Controllers\AuthAbsensi;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\DepartemenUser;
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
            if (auth()->user()->nik == 0000000) {
                return redirect()->route('absensi.home');
            }else{
                $akses_departemen = DepartemenUser::whereIn('departemen_id',[3,4])->where('nik',auth()->user()->nik)->first();
                if (empty($akses_departemen)) {
                    return redirect()->back()->with('error','Maaf Anda Tidak Bisa Akses Halaman Absensi');
                }else{
                    return redirect()->route('absensi.home');
                }
            }
            // return redirect()->intended();
        }else{
            return redirect()->route('absensi.login')
                ->with('error','Username / Password Salah.');
        }
    }
}
