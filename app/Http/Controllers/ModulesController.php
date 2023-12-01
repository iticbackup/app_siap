<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Modules;

use \Carbon\Carbon;
use Validator;
use DataTables;
use File;
class ModulesController extends Controller
{
    function __construct(
        Modules $modules
    )
    {
        $this->modules = $modules;
    }

    public function f_index()
    {
        $data['modules'] = $this->modules->paginate(5);
        return view('modules',$data);
    }

    public function b_index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->modules->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<button type="button" onclick="edit(`'.$row->id.'`)" class="btn btn-warning btn-icon">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>';
                                $btn.= '<button type="button" onclick="hapus_file(`'.$row->id.'`)" class="btn btn-danger btn-icon">
                                            <i class="fa fa-trash"></i>
                                        </button>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }
        return view('modules.index');
    }

    public function b_simpan(Request $request)
    {
        $rules = [
            'title' => 'required',
        ];

        $messages = [
            'title.required'  => 'Judul Module wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            if (!File::isDirectory(public_path('module/'))) {
                File::makeDirectory(public_path('module/'),0777,true);
            }

            $file = $request->file('files');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('module/'), $fileName);

            $modules = $this->modules->create([
                'title' => $request->title,
                'files' => $fileName
            ]);

            if ($modules) {
                $message_title="Berhasil !";
                $message_content="Module Berhasil Disimpan";
                $message_type="success";
                $message_succes = true;

                $array_message = array(
                    'success' => $message_succes,
                    'message_title' => $message_title,
                    'message_content' => $message_content,
                    'message_type' => $message_type,
                );

                return response()->json($array_message);
            }
        }
        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

    public function b_detail($id)
    {
        $modules = $this->modules->find($id);
        if (empty($modules)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Data Tidak Ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $modules
        ]);
    }

    public function b_update(Request $request)
    {
        $rules = [
            'edit_title' => 'required',
            'edit_files' => 'required',
        ];

        $messages = [
            'edit_title.required'  => 'Judul Module wajib diisi.',
            'edit_files.required'  => 'Upload File Module wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->passes()) {
            $modules = $this->modules->find($request->edit_id);
            if (!File::isDirectory(public_path('module/'))) {
                File::makeDirectory(public_path('module/'),0777,true);
            }

            File::delete(public_path('module/'.$modules->files));

            $file = $request->file('edit_files');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('module/'), $fileName);

            $input['title'] = $request->edit_title;
            $input['files'] = $fileName;

            $modules->update($input);

            if ($modules) {
                $message_title="Berhasil !";
                $message_content="Module Berhasil Diupdate";
                $message_type="success";
                $message_succes = true;

                $array_message = array(
                    'success' => $message_succes,
                    'message_title' => $message_title,
                    'message_content' => $message_content,
                    'message_type' => $message_type,
                );

                return response()->json($array_message);
            }
        }
        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

    public function b_delete($id)
    {
        $modules = $this->modules->find($id);
        if (empty($modules)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }
        $modules->delete();
        File::delete(public_path('module/'.$modules->files));

        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Data berhasil dihapus'
        ]);
    }

    public function f_download($id)
    {
        $modules = $this->modules->find($id);
        return response()->download(public_path('module/'.$modules->files));
        // return public_path('module/'.$modules->files);
    }
}
