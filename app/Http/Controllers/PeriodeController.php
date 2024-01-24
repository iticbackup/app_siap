<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Periode;
use \Carbon\Carbon;
use Validator;
use DataTables;
class PeriodeController extends Controller
{

    function __construct(
        Periode $periode
    ){
        $this->middleware('permission:periode-list', ['only' => [
        'index','detail','update','delete'
        ]]);
        $this->periode = $periode;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->periode->get();

            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('status', function($row){
                                if ($row->status == 'y') {
                                    return '<span class="badge bg-success">Aktif</span>';
                                }else{
                                    return '<span class="badge bg-danger">Non Aktif</span>';
                                }
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="button-items">';
                                $btn .= '<button class="btn btn-warning" onclick="edit('.$row->id.')"><i class="fas fa-edit"></i> Edit</button>';
                                $btn .= '<button class="btn btn-danger" onclick="hapus('.$row->id.')"><i class="fas fa-trash"></i> Delete</button>';
                                $btn .= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action','status'])
                            ->make(true);
        }

        return view('periode.index');
    }

    public function simpan(Request $request)
    {
        $rules = [
            'periode' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'periode.required'  => 'Periode wajib diisi.',
            'status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $input['periode'] = $request->periode;
            $input['status'] = $request->status;
            $periode = $this->periode->create($input);
            if ($periode) {
                $message_title="Berhasil !";
                $message_content="Periode ".$input['periode']." Berhasil Dibuat";
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
        $periode = $this->periode->find($id);
        if (empty($periode)) {
            return [
                'success' => false,
                'message_content' => 'Data Tidak Ditemukan'
            ];
        }

        return [
            'success' => true,
            'data' => $periode
        ];
    }

    public function update(Request $request)
    {
        $rules = [
            'edit_periode' => 'required',
            'edit_status' => 'required',
        ];

        $messages = [
            'edit_periode.required'  => 'Periode wajib diisi.',
            'edit_status.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $periode = $this->periode->find($request->edit_id);
            $input['periode'] = $request->edit_periode;
            $input['status'] = $request->edit_status;
            $periode->update($input);
            if ($periode) {
                $message_title="Berhasil !";
                $message_content="Periode ".$input['periode']." Berhasil Diupdate";
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

    public function delete($id)
    {
        $periode = $this->periode->find($id);
        if (empty($periode)) {
            return [
                'success' => false,
                'message_content' => 'Data Tidak Ditemukan'
            ];
        }
        $periode->delete();
        return [
            'success' => true,
            'message_title' => 'Berhasil!',
            'message_content' => 'Periode Berhasil Dihapus'
        ];
    }
}
