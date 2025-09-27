<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\ListValidasiDisetujui;
use App\Models\ListValidasiDiperiksa;
use App\Models\ListValidasiDibuat;

use App\Models\Departemen;

use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use Validator;
use DataTables;

class ListValidasiController extends Controller
{
    function __construct(
        ListValidasiDisetujui $listValidasiDisetujui,
        ListValidasiDiperiksa $listValidasiDiperiksa,
        ListValidasiDibuat $listValidasiDibuat,
        Departemen $departemen
    ){
        $this->listValidasiDisetujui = $listValidasiDisetujui;
        $this->listValidasiDiperiksa = $listValidasiDiperiksa;
        $this->listValidasiDibuat = $listValidasiDibuat;
        $this->departemen = $departemen;
    }

    public function indexValidasiDisetujui(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->listValidasiDisetujui->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            // ->addColumn('departemen_user_id', function($row){
                            //     return $row->departemen_user->team;
                            // })
                            ->addColumn('departemen_id', function($row){
                                return $row->departemen->departemen;
                            })
                            ->addColumn('status', function($row){
                                switch ($row->status) {
                                    case 'Active':
                                        return '<span class="badge bg-success">Aktif</span>';
                                        break;
                                    case 'InActive':
                                        return '<span class="badge bg-danger">Tidak Aktif</span>';
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<button type="button" class="btn btn-warning btn-icon" onclick="editDisetujui(`'.$row->id.'`)">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>';
                                $btn.= '<a class="btn btn-danger btn-icon" onclick="deleteDisetujui(`'.$row->id.'`)">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['status','action'])
                            ->make(true);
        }
        $data['departemen_disetujuis'] = $this->departemen->where('id',1)->get();
        $data['departemen_diperiksas'] = $this->departemen->whereIn('id',[3,4,5,6,7,8,9,10,13])->get();
        return view('dc.listValidasi.index',$data);
    }

    public function validasiDisetujuiSimpan(Request $request)
    {
        $rules = [
            'name' => 'required',
            'departemen_id' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama Validasi Disetujui wajib diisi.',
            'departemen_id.required'  => 'Departemen wajib diisi.',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->passes()) {
            $input['id'] = Str::uuid()->toString();
            $input['code'] = 'VALID'.rand(1000,9999);
            $input['name'] = $request->name;
            $input['departemen_id'] = $request->departemen_id;
            $input['status'] = $request->status;

            $simpan = $this->listValidasiDisetujui->create($input);

            if ($simpan) {
                $message_title="Berhasil !";
                $message_content="Data Validasi Disetujui Berhasil Dibuat";
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

    public function validasiDisetujuiUpdate(Request $request)
    {
        $rules = [
            'name' => 'required',
            'departemen_id' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama Validasi Disetujui wajib diisi.',
            'departemen_id.required'  => 'Departemen wajib diisi.',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->passes()) {
            $update = $this->listValidasiDisetujui->find($request->id);
            
            $input['name'] = $request->name;
            $input['departemen_id'] = $request->departemen_id;
            $input['status'] = $request->status;

            $update->update($input);

            if ($update) {
                $message_title="Berhasil !";
                $message_content="Data Validasi Disetujui ".$input['name']." Berhasil Diupdate";
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

    public function validasiDisetujuiDelete($id)
    {
        $data = $this->listValidasiDisetujui->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal!',
                'message_content' => 'Validasi Disetujui Tidak Ditemukan',
                'message_type' => 'danger',
            ]);
        }

        $data->delete();

        return response()->json(
            [
                'success' => true,
                'message_title' => 'Berhasil!',
                'message_content' => 'Validasi Disetujui Berhasil Dihapus',
                'message_type' => 'success',
            ]
        );
    }

    public function validasiDisetujuiDetail($id)
    {
        $data = $this->listValidasiDisetujui->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal!',
                'message_content' => 'Validasi Disetujui Tidak Ditemukan',
                'message_type' => 'danger',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function indexValidasiDiperiksa(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->listValidasiDiperiksa->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('departemen_id', function($row){
                                return $row->departemen->departemen;
                            })
                            ->addColumn('status', function($row){
                                switch ($row->status) {
                                    case 'Active':
                                        return '<span class="badge bg-success">Aktif</span>';
                                        break;
                                    case 'InActive':
                                        return '<span class="badge bg-danger">Tidak Aktif</span>';
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<button type="button" class="btn btn-warning btn-icon" onclick="editDiperiksa(`'.$row->id.'`)">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>';
                                $btn.= '<a class="btn btn-danger btn-icon" onclick="deleteDiperiksa(`'.$row->id.'`)">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['status','action'])
                            ->make(true);
        }
    }

    public function validasiDiperiksaSimpan(Request $request)
    {
        $rules = [
            'name' => 'required',
            'departemen_id' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama Validasi Diperiksa wajib diisi.',
            'departemen_id.required'  => 'Departemen wajib diisi.',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->passes()) {
            $input['id'] = Str::uuid()->toString();
            $input['code'] = 'VALID'.rand(1000,9999);
            $input['name'] = $request->name;
            $input['departemen_id'] = $request->departemen_id;
            $input['status'] = $request->status;

            $simpan = $this->listValidasiDiperiksa->create($input);

            if ($simpan) {
                $message_title="Berhasil !";
                $message_content="Data Validasi Diperiksa Berhasil Dibuat";
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

    public function validasiDiperiksaDetail($id)
    {
        $data = $this->listValidasiDiperiksa->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal!',
                'message_content' => 'Validasi Diperiksa Tidak Ditemukan',
                'message_type' => 'danger',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function validasiDiperiksaUpdate(Request $request)
    {
        $rules = [
            'name' => 'required',
            'departemen_id' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama Validasi Disetujui wajib diisi.',
            'departemen_id.required'  => 'Departemen wajib diisi.',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->passes()) {
            $update = $this->listValidasiDiperiksa->find($request->id);
            
            $input['name'] = $request->name;
            $input['departemen_id'] = $request->departemen_id;
            $input['status'] = $request->status;

            $update->update($input);

            if ($update) {
                $message_title="Berhasil !";
                $message_content="Data Validasi Diperiksa ".$input['name']." Berhasil Diupdate";
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

    public function validasiDiperiksaDelete($id)
    {
        $data = $this->listValidasiDiperiksa->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal!',
                'message_content' => 'Validasi Diperiksa Tidak Ditemukan',
                'message_type' => 'danger',
            ]);
        }

        $data->delete();

        return response()->json(
            [
                'success' => true,
                'message_title' => 'Berhasil!',
                'message_content' => 'Validasi Diperiksa Berhasil Dihapus',
                'message_type' => 'success',
            ]
        );
    }

    public function indexValidasiDibuat(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->listValidasiDibuat->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            // ->addColumn('departemen_user_id', function($row){
                            //     return $row->departemen_user->team;
                            // })
                            // ->addColumn('kpi_departemen_id', function($row){
                            //     return $row->kpi_departemen->departemen;
                            // })
                            ->addColumn('departemen_id', function($row){
                                return $row->departemen->departemen;
                            })
                            ->addColumn('status', function($row){
                                switch ($row->status) {
                                    case 'Active':
                                        return '<span class="badge bg-success">Aktif</span>';
                                        break;
                                    case 'InActive':
                                        return '<span class="badge bg-danger">Tidak Aktif</span>';
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<button type="button" class="btn btn-warning btn-icon" onclick="editDibuat(`'.$row->id.'`)">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>';
                                $btn.= '<a class="btn btn-danger btn-icon" onclick="deleteDibuat(`'.$row->id.'`)">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['status','action'])
                            ->make(true);
        }
    }

    public function validasiDibuatSimpan(Request $request)
    {
        $rules = [
            'name' => 'required',
            'departemen_id' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama Validasi Diperiksa wajib diisi.',
            'departemen_id.required'  => 'Departemen wajib diisi.',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->passes()) {
            $input['id'] = Str::uuid()->toString();
            $input['code'] = 'VALID'.rand(1000,9999);
            $input['name'] = $request->name;
            $input['departemen_id'] = $request->departemen_id;
            $input['status'] = $request->status;

            $simpan = $this->listValidasiDibuat->create($input);

            if ($simpan) {
                $message_title="Berhasil !";
                $message_content="Data Validasi Dibuat Berhasil Dibuat";
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

    public function validasiDibuatDetail($id)
    {
        $data = $this->listValidasiDibuat->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal!',
                'message_content' => 'Validasi Dibuat Tidak Ditemukan',
                'message_type' => 'danger',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function validasiDibuatUpdate(Request $request)
    {
        $rules = [
            'name' => 'required',
            'departemen_id' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama Validasi Disetujui wajib diisi.',
            'departemen_id.required'  => 'Departemen wajib diisi.',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->passes()) {
            $update = $this->listValidasiDibuat->find($request->id);
            
            $input['name'] = $request->name;
            $input['departemen_id'] = $request->departemen_id;
            $input['status'] = $request->status;

            $update->update($input);

            if ($update) {
                $message_title="Berhasil !";
                $message_content="Data Validasi Dibuat ".$input['name']." Berhasil Diupdate";
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

    public function validasiDibuatDelete($id)
    {
        $data = $this->listValidasiDibuat->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal!',
                'message_content' => 'Validasi Dibuat Tidak Ditemukan',
                'message_type' => 'danger',
            ]);
        }

        $data->delete();

        return response()->json(
            [
                'success' => true,
                'message_title' => 'Berhasil!',
                'message_content' => 'Validasi Dibuat Berhasil Dihapus',
                'message_type' => 'success',
            ]
        );
    }

}
