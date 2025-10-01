<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\ValidasiRepresentative;
use App\Models\ValidasiDocumentControl;
use App\Models\Departemen;

use DataTables;
use Validator;

class ValidasiDocumentControlController extends Controller
{
    function __construct(
        ValidasiRepresentative $validasiRepresentative,
        ValidasiDocumentControl $validasiDocumentControl,
        Departemen $departemen
    ){
        $this->validasiRepresentative = $validasiRepresentative;
        $this->validasiDocumentControl = $validasiDocumentControl;
        $this->departemen = $departemen;
    }

    public function index()
    {
        $data['departemens'] = $this->departemen->where('id','!=',1)->get();

        return view('validasi_document_control.index',$data);
    }

    public function validasiRepresentativeIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->validasiRepresentative->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('status', function($row){
                                switch ($row->status) {
                                    case 'Y':
                                        return '<span class="badge bg-success">Aktif</span>';
                                        break;
                                    case 'N':
                                        return '<span class="badge bg-danger">NonAktif</span>';
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="button-items">';
                                $btn.= '<button type="button" class="btn btn-warning btn-icon" onclick="editRepresentative(`'.$row->id.'`)">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>';
                                // $btn.= \Form::open(['method' => 'DELETE', 'route' => ['validasiRepresentative.delete', $row->id], 'style' => 'display:inline']);
                                // $btn.= '<button type="submit" class="btn btn-danger btn-icon">
                                //             <i class="fa fa-trash"></i> Delete
                                //         </button>';
                                // $btn.= \Form::close();
                                $btn.= '<a class="btn btn-danger btn-icon" id="deleteRepresentative" data-id="'.$row->id.'">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>';
                                $btn .= '</div>';

                                return $btn;
                            })
                            ->rawColumns(['action','status'])
                            ->make(true);
        }
    }

    public function validasiRepresentativeSimpan(Request $request)
    {
        $rules = [
            'team' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'team.required'  => 'Team Representative wajib diisi',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $input['id'] = Str::uuid()->toString();
            $input['nik'] = explode('|',$request->team)[0];
            $input['nama_validasi'] = explode('|',$request->team)[1];
            $input['status'] = $request->status;
            $simpanRepresentative = $this->validasiRepresentative->create($input);
            if ($simpanRepresentative) {
                $message_title="Berhasil !";
                $message_content= "Validasi Representative Berhasil Dibuat";
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

    public function validasiRepresentativeDetail($id)
    {
        $data = $this->validasiRepresentative->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Valdasi Representative Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $data->id,
                'team' => $data->nik.'|'.$data->nama_validasi,
                'status' => $data->status
            ]
        ]);
    }

    public function validasiRepresentativeUpdate(Request $request)
    {
        $rules = [
            'team' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'team.required'  => 'Team Representative wajib diisi',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $input['nik'] = explode('|',$request->team)[0];
            $input['nama_validasi'] = explode('|',$request->team)[1];
            $input['status'] = $request->status;
            $updateRepresentative = $this->validasiRepresentative->find($request->id)->update($input);
            if ($updateRepresentative) {
                $message_title="Berhasil !";
                $message_content= "Validasi Representative Berhasil Diupdate";
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

    public function validasiRepresentativeDelete($id)
    {
        $data = $this->validasiRepresentative->find($id);

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Valdasi Representative Tidak Ditemukan'
            ]);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil!',
            'message_content' => 'Validasi Representative Berhasil Dihapus'
        ]);

    }

    public function validasiDocumentControlIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->validasiDocumentControl->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('status', function($row){
                                switch ($row->status) {
                                    case 'Y':
                                        return '<span class="badge bg-success">Aktif</span>';
                                        break;
                                    case 'N':
                                        return '<span class="badge bg-danger">NonAktif</span>';
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="button-items">';
                                $btn.= '<button type="button" class="btn btn-warning btn-icon" onclick="editDocumentControl(`'.$row->id.'`)">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>';
                                // $btn.= \Form::open(['method' => 'DELETE', 'route' => ['validasiRepresentative.delete', $row->id], 'style' => 'display:inline']);
                                // $btn.= '<button type="submit" class="btn btn-danger btn-icon">
                                //             <i class="fa fa-trash"></i> Delete
                                //         </button>';
                                // $btn.= \Form::close();
                                $btn.= '<a class="btn btn-danger btn-icon" id="deleteDocumentControl" data-id="'.$row->id.'">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>';
                                $btn .= '</div>';

                                return $btn;
                            })
                            ->rawColumns(['action','status'])
                            ->make(true);
        }
    }

    public function validasiDocumentControlSimpan(Request $request)
    {
        $rules = [
            'team' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'team.required'  => 'Team Document Control wajib diisi',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $input['id'] = Str::uuid()->toString();
            $input['nik'] = explode('|',$request->team)[0];
            $input['nama_validasi'] = explode('|',$request->team)[1];
            $input['status'] = $request->status;
            $simpanDocumentControl = $this->validasiDocumentControl->create($input);
            if ($simpanDocumentControl) {
                $message_title="Berhasil !";
                $message_content= "Validasi Document Control Berhasil Dibuat";
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

    public function validasiDocumentControlDetail($id)
    {
        $data = $this->validasiDocumentControl->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Valdasi Document Control Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $data->id,
                'team' => $data->nik.'|'.$data->nama_validasi,
                'status' => $data->status
            ]
        ]);
    }

    public function validasiDocumentControlUpdate(Request $request)
    {
        $rules = [
            'team' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'team.required'  => 'Team Document Control wajib diisi',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $input['nik'] = explode('|',$request->team)[0];
            $input['nama_validasi'] = explode('|',$request->team)[1];
            $input['status'] = $request->status;
            $updateRepresentative = $this->validasiDocumentControl->find($request->id)->update($input);
            if ($updateRepresentative) {
                $message_title="Berhasil !";
                $message_content= "Validasi Document Control Berhasil Diupdate";
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
