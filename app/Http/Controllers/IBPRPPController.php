<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\IBPRPPPeriode;
use App\Models\IBPRPPCategoryArea;
use App\Models\IBPRPPDepartemen;
use App\Models\IBPRPP;
use \Carbon\Carbon;
use Validator;
use DataTables;
use PDF;

class IBPRPPController extends Controller
{
    function __construct(
        IBPRPP $ibprpp,
        IBPRPPPeriode $ibprpp_periode,
        IBPRPPCategoryArea $ibprpp_category_area,
        IBPRPPDepartemen $ibprpp_departemen
    ){
        $this->ibprpp = $ibprpp;
        $this->ibprpp_periode = $ibprpp_periode;
        $this->ibprpp_category_area = $ibprpp_category_area;
        $this->ibprpp_departemen = $ibprpp_departemen;
    }

    public function ibprpp_periode(Request $request)
    {
        // if ($request->ajax()) {
        //     $data = $this->ibprpp_periode->all();

        //     return DataTables::of($data)
        //                     ->addIndexColumn()
        //                     ->addColumn('status', function($row){
        //                         switch ($row->status) {
        //                             case 'aktif':
        //                                 return '<span class="badge bg-success">Aktif</span>';
        //                                 break;

        //                             case 'nonaktif':
        //                                 return '<span class="badge bg-danger">Non Aktif</span>';
        //                                 break;
                                    
        //                             default:
        //                                 # code...
        //                                 break;
        //                         }
        //                     })
        //                     ->addColumn('action', function($row){
        //                         // $btn = '<div class="btn-group">';
        //                         // $btn.= '<a href='.route('departemen.detail_team',$row->id).' class="btn btn-primary btn-icon">
        //                         //             <i class="fas fa-cube"></i> Input Team
        //                         //         </a>';
        //                         // $btn.= '<button type="button" onclick="edit(`'.$row->id.'`)" class="btn btn-warning btn-icon">
        //                         //             <i class="fa fa-edit"></i> Edit
        //                         //         </button>';
        //                         // $btn.= '<button type="button" onclick="hapus(`'.$row->id.'`)" class="btn btn-danger btn-icon">
        //                         //             <i class="fa fa-trash"></i>
        //                         //         </button>';
        //                         // $btn.= '</div>';
        //                         // return $btn;
        //                     })
        //                     ->rawColumns(['action','status'])
        //                     ->make(true);
        // }

        $data['periodes'] = $this->ibprpp_periode->select('periode')->get();

        return view('ibprpp.index',$data);
    }

    public function ibprpp_index($periode)
    {
        $data['periode'] = $periode;

        $data['departemens'] = $this->ibprpp_departemen->select('id','departemen')->where('status','aktif')->get();

        return view('ibprpp.detail',$data);
    }

    public function ibprpp_departemen_input($periode,$departemen_id)
    {
        $data['periode'] = $periode;
        
        $data['departemen'] = $this->ibprpp_departemen->select('id','departemen')->find($departemen_id);
        
        if (empty($data['departemen'])) {
            return back()->with('error','Departemen Tidak Ditemukan');
        }

        $data['category_areas'] = $this->ibprpp_category_area->select('id','category_area')->where('status','aktif')->get();

        return view('ibprpp.input',$data);
    }

    public function ibprpp_departemen_input_simpan(Request $request, $periode,$departemen_id)
    {
        $rules = [
            // 'aktifitas_pekerja' => 'required',
        ];

        $messages = [
            // 'aktifitas_pekerja.required' => 'Aktifitas Pekerja Wajib Diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->passes()) {
            // dd($request->all());
            $periode = $this->ibprpp_periode->select('id')->where('periode',$periode)->first();
            $input['id'] = Str::uuid()->toString();
            $input['ibprpp_periode_id'] = $periode->id;
            $input['ibprpp_category_area_id'] = $request->ibprpp_category_area_id;
            $input['ibprpp_departemen_id'] = $departemen_id;
            $input['aktivitas_pekerja'] = $request->aktifitas_pekerja;
            $input['jenis_aktivitas'] = $request->jenis_aktivitas;
            $input['body'] = json_encode($request->body);
            // $input['penilaian_risiko_pengendalian'] = json_encode($request->penilaian_risiko_pengendalian);
            $input['status'] = 'Aktif';
            // $input['penilaian_risiko'] = $request->penilaian_risiko_pengendalian;
            // $input['pengendalian'] = $request->penilaian_risiko_pengendalian;
            // dd($input);
            $ibprpp = $this->ibprpp->create($input);

            if ($ibprpp) {
                $message_title="Berhasil !";
                $message_content="IBPRPP Berhasil Dibuat";
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
        // $request->validate([
        //     'aktifitas_pekerja' => 'required',
        // ],[
        //     'aktifitas_pekerja.required' => 'Aktifitas Pekerja wajib diisi',
        // ]);
    }

    public function ibprpp_departemen_input_preview($periode,$departemen_id)
    {
        $data['periode'] = $this->ibprpp_periode->select('id','periode')->where('periode',$periode)->first();
        $data['departemen_id'] = $departemen_id;

        $data['ibprpps'] = $this->ibprpp->where('ibprpp_periode_id',$data['periode']['id'])
                                        ->where('ibprpp_departemen_id',$departemen_id)
                                        ->orderBy('created_at','asc')
                                        ->get();
        
        if (empty($data['ibprpps'])) {
            return back()->with('error', 'IBPRPP Tidak Ditemukan');
        }

        // dd($data);

        return view('ibprpp.preview',$data);
    }

    public function ibprpp_departemen_download_pdf($periode,$departemen_id)
    {
        // $periode = $this->ibprpp_periode->select('id')->where('periode',$periode)->first();

        // $data['ibprpp'] = $this->ibprpp->where('ibprpp_periode_id',$periode->id)
        //                                 ->where('ibprpp_departemen_id',$departemen_id)
        //                                 ->first();
        
        // if (empty($data['ibprpp'])) {
        //     return back()->with('error', 'IBPRPP Tidak Ditemukan');
        // }
        // $data['periode'] = $periode;
        $data['periode'] = $this->ibprpp_periode->select('id','periode')->where('periode',$periode)->first();
        $data['ibprpp_category_areas'] = $this->ibprpp_category_area->where('status','aktif')->get();
        $data['departemen_id'] = $departemen_id;

        // $data['ibprpps'] = $this->ibprpp->where('ibprpp_periode_id',$data['periode']['id'])
        //                                 ->where('ibprpp_departemen_id',$departemen_id)
        //                                 ->get();

        // return view('ibprpp.old.pdfnew', $data);
        return view('ibprpp.pdf', $data);
        $pdf = PDF::loadView('ibprpp.pdf', $data);
        // $pdf = PDF::loadView('ibprpp.old.pdfnew', $data);
        // $pdf = PDF::loadView('ibprpp.old.pdf', $data);
        $pdf->set_paper('a3', 'landscape');

        return $pdf->stream();
    }

    public function ibprpp_departemen_download_table_matriks($periode,$departemen_id)
    {
        $pdf = PDF::loadView('ibprpp.tableMatriks');
        $pdf->set_paper('a3', 'landscape');
        return $pdf->stream('Tabel Matriks Risiko.pdf');

        // return view('ibprpp.tableMatriks');
    }
}
