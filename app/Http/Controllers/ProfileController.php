<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;

class ProfileController extends Controller
{
    protected $user;

    function __construct(
        User $user
    ){
        $this->user = $user;
    }

    public function index()
    {
        return view('profile.index');
    }

    public function personal_info_update(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $input['name'] = $request->name;
            if (!empty($request->email)) {
                $input['email'] = $request->email;
            }
            $update_user = $this->user->find(auth()->user()->id)->update($input);
            if($update_user){
                $message_title="Berhasil !";
                $message_content="Akun Berhasil Diupdate";
                $message_type="success";
                $message_succes = true;
            }
            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
            );
            return response()->json($array_message);
        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

    public function password_personal_update(Request $request)
    {
        $rules = [
            'password' => 'required',
            'password_confirmation' => 'required',
        ];

        $messages = [
            'password.required'  => 'Password wajib diisi.',
            'password_confirmation.required'  => 'Confirm Password wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            if ($request->password == $request->password_confirmation) {
                $input['password'] = Hash::make($request->password_confirmation);
            }else{
                $message_title="Gagal !";
                $message_content="Password Akun Tidak Sama";
                $message_type="error";
                $message_succes = false;

                $array_message = array(
                    'success' => $message_succes,
                    'message_title' => $message_title,
                    'message_content' => $message_content,
                    'message_type' => $message_type,
                );
                return response()->json($array_message);
            }
            $update_user = $this->user->find(auth()->user()->id)->update($input);
            if($update_user){
                $message_title="Berhasil !";
                $message_content="Password Akun Berhasil Diubah";
                $message_type="success";
                $message_succes = true;
            }
            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
            );
            return response()->json($array_message);
        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }
}
