<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use \Carbon\Carbon;
use DB;
use Validator;
use DataTables;

class PermissionController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:permission-list', ['only' => ['index']]);
        //  $this->middleware('permission:permissions-edit', ['only' => ['index','edit']]);
        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('created_at', function($row){
                                return Carbon::parse($row->created_at)->isoFormat('LLLL');
                            })
                            ->addColumn('updated_at', function($row){
                                return Carbon::parse($row->updated_at)->isoFormat('LLLL');
                            })
                            ->addColumn('action', function($row){
                                // dd($row->name);
                                $btn = '';
                                // if ($row->name == 'permissions_edit') {
                                //     $btn .= '<button type="button" onclick="edit(`'.$row->id.'`)" class="btn btn-warning btn-icon">
                                //                 <i class="fa fa-edit"></i>
                                //             </button>';
                                // }
                                $btn .= '<button type="button" onclick="edit(`'.$row->id.'`)" class="btn btn-warning btn-icon">
                                            <i class="fa fa-edit"></i>
                                        </button>';
                                
                                // if ($row->name == 'permissions_delete') {
                                //     $btn.= '<button type="button" onclick="hapus(`'.$row->id.'`)" class="btn btn-danger btn-icon">
                                //                 <i class="fa fa-trash"></i>
                                //             </button>';
                                // }
                                $btn.= '<button type="button" onclick="hapus(`'.$row->id.'`)" class="btn btn-danger btn-icon">
                                            <i class="fa fa-trash"></i>
                                        </button>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }
        return view('permissions.index');
    }

    public function simpan(Request $request)
    {
        $rules = [
            'name' => 'required',
            'guard_name' => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama Permission wajib diisi.',
            'guard_name.required'  => 'Nama Akses wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $input = $request->all();
            $permission = Permission::create($input);
            $permission->syncPermissions($request->input('permission'));

            if($permission){
                $message_title="Berhasil !";
                $message_content="Data Berhasil Dibuat";
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

    public function detail($id)
    {
        $permission = Permission::find($id);
        if (empty($permission)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data tidak ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $permission
        ]);
    }
    
    public function update(Request $request)
    {
        $rules = [
            'edit_name' => 'required',
            'edit_guard_name' => 'required',
        ];

        $messages = [
            'edit_name.required'  => 'Nama Permission wajib diisi.',
            'edit_guard_name.required'  => 'Nama Akses wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $permission = Permission::find($request->edit_id);
            $permission->name = $request->edit_name;
            $permission->guard_name = $request->edit_guard_name;
            $permission->update();
            $permission->syncPermissions($request->input('permission'));
            if($permission){
                $message_title="Berhasil !";
                $message_content="Data Berhasil Diupdate";
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
