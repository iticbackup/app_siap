<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SertifikasiMesinProduksi;
use App\Models\SertifikasiMesinProduksiList;
use \Carbon\Carbon;

use PDF;
use Validator;
use DataTables;

class SertifikasiMesinProduksiController extends Controller
{
    function __construct(
        SertifikasiMesinProduksi $sertifikasi_mesin_produksi,
        SertifikasiMesinProduksiList $sertifikasi_mesin_produksi_list
    ){
        $this->sertifikasi_mesin_produksi = $sertifikasi_mesin_produksi;
        $this->sertifikasi_mesin_produksi_list = $sertifikasi_mesin_produksi_list;

        $this->middleware('permission:hrga_list', ['only' => [
            'index','list_mesin'
        ]]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->sertifikasi_mesin_produksi->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('tgl_sertifikat_pertama', function($row){
                                return Carbon::create($row->tgl_sertifikat_pertama)->isoFormat('DD MMMM YYYY');
                            })
                            ->addColumn('status', function($row){
                                $live_date = Carbon::now()->format('Y-m-d');
                                $data_sertifikasi_mesin_produksi_list = $this->sertifikasi_mesin_produksi_list->where('sertifikasi_mesin_id',$row->id)
                                                                            // ->where('tgl_resertifikat_selanjutnya','like','%'.$live_date.'%')
                                                                            ->orderBy('tgl_resertifikat_selanjutnya','asc')
                                                                            ->limit(2)
                                                                            ->get();
                                                                            // dd($data_sertifikasi_mesin_produksi_list);
                                foreach ($data_sertifikasi_mesin_produksi_list as $key => $mesin_produksi_list) {
                                    // if(strtotime(Carbon::create($mesin_produksi_list->tgl_resertifikat_selanjutnya)->subMonth()->format('Y-m-d')) >= strtotime($live_date) || strtotime(Carbon::create($mesin_produksi_list->tgl_resertifikat_selanjutnya)->subMonth()->format('Y-m-d')) <= strtotime($live_date)){
                                    //     return '<span class="badge bg-success">'.'Aktif '.$mesin_produksi_list->tgl_resertifikat_selanjutnya.'</span>';
                                    // }elseif (strtotime(Carbon::create($mesin_produksi_list->tgl_resertifikat_selanjutnya)->subMonth()->format('Y-m-d')) >= strtotime($live_date)) {
                                    //     return '<span class="badge bg-warning">'.'Resertifikasi '.$mesin_produksi_list->tgl_resertifikat_selanjutnya.'</span>';
                                    // }else{
                                    //     return '<span class="badge bg-danger">'.'Kadaluwarsa '.$mesin_produksi_list->tgl_resertifikat_selanjutnya.'</span>';
                                    // }

                                    if (strtotime($live_date) >= strtotime(Carbon::create($mesin_produksi_list->tgl_resertifikat_selanjutnya)->subMonth()->format('Y-m-d'))) {
                                        return '<span class="badge bg-warning">'.'Resertifikasi '.$mesin_produksi_list->tgl_resertifikat_selanjutnya.'</span>';
                                    }else{
                                        return '<span class="badge bg-success">'.'Aktif '.$mesin_produksi_list->tgl_resertifikat_selanjutnya.'</span>';
                                    }
                                }
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="button-items">';
                                $btn .= '<button class="btn btn-success" onclick="detail(`'.$row->id.'`)">'.'<i class="fas fa-eye"></i> '.'Detail'.'</button>';
                                $btn .= '<a class="btn btn-primary" href='.route('hrga.sertifikasi.mesin_produksi.list_mesin',['id' => $row->id]).'>'.'<i class="fas fa-pencil-alt"></i> '.'Input Resertifikasi'.'</a>';
                                $btn .= '<button class="btn btn-warning" onclick="edit(`'.$row->id.'`)">'.'<i class="fas fa-edit"></i> '.'Edit'.'</button>';
                                $btn .= '<button class="btn btn-danger" onclick="hapus(`'.$row->id.'`)">'.'<i class="fas fa-trash"></i> '.'Delete'.'</button>';
                                $btn .= '</div>';

                                return $btn;
                            })
                            ->rawColumns(['action','status'])
                            ->make(true);
        }
        return view('sertifikasi.mesin_produksi.index');
    }

    public function create()
    {
        return view('sertifikasi.mesin_produksi.create');
    }

    public function simpan(Request $request)
    {
        $rules = [
            'jenis_mesin' => 'required',
            'no_sertifikat' => 'required',
            'tgl_sertifikat_pertama' => 'required',
            'periode_resertifikasi' => 'required',
        ];

        $messages = [
            'jenis_mesin.required'  => 'Jenis Mesin wajib diisi',
            'no_sertifikat.required'  => 'No. Sertifikat wajib diisi.',
            'tgl_sertifikat_pertama.required'  => 'Tanggal Sertifikat Pertama wajib diisi.',
            'periode_resertifikasi.required'  => 'Periode Resertifikasi wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $input = $request->all();
            $sertifikasi_mesin_produksi = $this->sertifikasi_mesin_produksi->create($input);
            if ($sertifikasi_mesin_produksi) {
                $message_title="Berhasil !";
                $message_content= $request->jenis_mesin." Nomor Sertifikat : ".$request->no_sertifikat." Berhasil Dibuat";
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
        $data = $this->sertifikasi_mesin_produksi->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $data->id,
                'jenis_mesin' => $data->jenis_mesin,
                'no_sertifikat' => $data->no_sertifikat,
                // 'tgl_sertifikat_pertama' => Carbon::create($data->tgl_sertifikat_pertama)->isoFormat('DD MMMM YYYY'),
                'tgl_sertifikat_pertama' => $data->tgl_sertifikat_pertama,
                'periode_resertifikasi' => $data->periode_resertifikasi,
            ],
            'data_list' => $data->sertifikasi_mesin_produksi_list
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'edit_jenis_mesin' => 'required',
            'edit_no_sertifikat' => 'required',
            'edit_tgl_sertifikat_pertama' => 'required',
            'edit_periode_resertifikasi' => 'required',
        ];

        $messages = [
            'edit_jenis_mesin.required'  => 'Jenis Mesin wajib diisi',
            'edit_no_sertifikat.required'  => 'No. Sertifikat wajib diisi.',
            'edit_tgl_sertifikat_pertama.required'  => 'Tanggal Sertifikat Pertama wajib diisi.',
            'edit_periode_resertifikasi.required'  => 'Periode Resertifikasi wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $input['jenis_mesin'] = $request->edit_jenis_mesin;
            $input['no_sertifikat'] = $request->edit_no_sertifikat;
            $input['tgl_sertifikat_pertama'] = $request->edit_tgl_sertifikat_pertama;
            $input['periode_resertifikasi'] = $request->edit_periode_resertifikasi;

            $sertifikasi_mesin_produksi = $this->sertifikasi_mesin_produksi->find($request->edit_id)->update($input);
            if ($sertifikasi_mesin_produksi) {
                $message_title="Berhasil !";
                $message_content= $input['jenis_mesin']." Nomor Sertifikat : ".$input['no_sertifikat']." Berhasil Diupdate";
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
        $data = $this->sertifikasi_mesin_produksi->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil!',
            'message_content' => 'Data Berhasil Dihapus'
        ]);
    }

    public function list_mesin(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = $this->sertifikasi_mesin_produksi_list->where('sertifikasi_mesin_id',$id)
                                                        ->get();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('tgl_resertifikasi_selanjutnya', function($row){
                                return $row->tgl_resertifikat_selanjutnya;
                                // return Carbon::create($row->tgl_periksa_uji)->addYear($row->sertifikasi_mesin_produksi->periode_resertifikasi)->format('Y-m-d');
                            })
                            ->addColumn('status', function($row){
                                
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="button-items">';
                                $btn .= '<button class="btn btn-warning" onclick="edit(`'.$row->sertifikasi_mesin_id.'`,`'.$row->id.'`)">'.'<i class="fas fa-edit"></i> '.'Edit'.'</button>';
                                $btn .= '<button class="btn btn-danger" onclick="hapus(`'.$row->sertifikasi_mesin_id.'`,`'.$row->id.'`)">'.'<i class="fas fa-trash"></i> '.'Delete'.'</button>';
                                // $btn .= '<button class="btn btn-primary" onclick="inputResertifikasi(`'.$row->id.'`)">'.'<i class="fas fa-pencil-alt"></i> '.'Input Resertifikasi'.'</button>';
                                // $btn .= '<button class="btn btn-warning" onclick="edit(`'.$row->id.'`)">'.'<i class="fas fa-edit"></i> '.'Edit'.'</button>';
                                // $btn .= '<button class="btn btn-danger" onclick="delete(`'.$row->id.'`)">'.'<i class="fas fa-trash"></i> '.'Delete'.'</button>';
                                $btn .= '</div>';

                                return $btn;
                            })
                            ->rawColumns(['action','status'])
                            ->make(true);
        }
        $data['mesin_produksi'] = $this->sertifikasi_mesin_produksi->find($id);
        return view('sertifikasi.mesin_produksi.list.index',$data);
    }

    public function list_simpan(Request $request,$id)
    {
        $rules = [
            'tgl_periksa_uji' => 'required',
            'tgl_terbit_sertifikat' => 'required',
            'no_sertifikat_terakhir' => 'required',
            'keterangan' => 'required',
        ];

        $messages = [
            'tgl_periksa_uji.required'  => 'Jenis Mesin wajib diisi',
            'tgl_terbit_sertifikat.required'  => 'No. Sertifikat wajib diisi.',
            'no_sertifikat_terakhir.required'  => 'Tanggal Sertifikat Pertama wajib diisi.',
            'keterangan.required'  => 'Periode Resertifikasi wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $sertifikasi_mesin_produksi = $this->sertifikasi_mesin_produksi->find($id);
            $input['sertifikasi_mesin_id'] = $id;
            $input['tgl_periksa_uji'] = $request->tgl_periksa_uji;
            $input['tgl_terbit_sertifikat'] = $request->tgl_terbit_sertifikat;
            $input['no_sertifikat_terakhir'] = $request->no_sertifikat_terakhir;
            $input['tgl_resertifikat_selanjutnya'] = Carbon::create($input['tgl_periksa_uji'])->addYear($sertifikasi_mesin_produksi->periode_resertifikasi)->format('Y-m-d');
            $input['keterangan'] = $request->keterangan;

            $sertifikasi_mesin_produksi_list = $this->sertifikasi_mesin_produksi_list->create($input);
            if ($sertifikasi_mesin_produksi_list) {
                $message_title="Berhasil !";
                $message_content= "Data Berhasil Dibuat";
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

    public function detail_list($id,$mesin_list_id)
    {
        $data = $this->sertifikasi_mesin_produksi_list->where('id',$mesin_list_id)
                                                    ->where('sertifikasi_mesin_id',$id)
                                                    ->first();
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $data->id,
                'sertifikasi_mesin_id' => $data->sertifikasi_mesin_id,
                'tgl_periksa_uji' => $data->tgl_periksa_uji,
                'tgl_terbit_sertifikat' => $data->tgl_terbit_sertifikat,
                'no_sertifikat_terakhir' => $data->no_sertifikat_terakhir,
                'tgl_resertifikat_selanjutnya' => $data->tgl_resertifikat_selanjutnya,
                'keterangan' => $data->keterangan,
            ],
        ]);
    }

    public function update_list(Request $request,$id)
    {
        $rules = [
            'edit_tgl_periksa_uji' => 'required',
            'edit_tgl_terbit_sertifikat' => 'required',
            'edit_no_sertifikat_terakhir' => 'required',
            'edit_keterangan' => 'required',
        ];

        $messages = [
            'edit_tgl_periksa_uji.required'  => 'Jenis Mesin wajib diisi',
            'edit_tgl_terbit_sertifikat.required'  => 'No. Sertifikat wajib diisi.',
            'edit_no_sertifikat_terakhir.required'  => 'Tanggal Sertifikat Pertama wajib diisi.',
            'edit_keterangan.required'  => 'Periode Resertifikasi wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $sertifikasi_mesin_produksi_list = $this->sertifikasi_mesin_produksi_list->where('id',$request->edit_id)
                                                                                    ->where('sertifikasi_mesin_id',$id)
                                                                                    ->first();

            $input['sertifikasi_mesin_id'] = $id;
            $input['tgl_periksa_uji'] = $request->edit_tgl_periksa_uji;
            $input['tgl_terbit_sertifikat'] = $request->edit_tgl_terbit_sertifikat;
            $input['no_sertifikat_terakhir'] = $request->edit_no_sertifikat_terakhir;
            $input['tgl_resertifikat_selanjutnya'] = Carbon::create($input['tgl_periksa_uji'])->addYear($sertifikasi_mesin_produksi_list->sertifikasi_mesin_produksi->periode_resertifikasi)->format('Y-m-d');
            $input['keterangan'] = $request->edit_keterangan;
            
            $sertifikasi_mesin_produksi_list->update($input);

            if ($sertifikasi_mesin_produksi_list) {
                $message_title="Berhasil !";
                $message_content= "No. Sertifikat ".$input['no_sertifikat_terakhir']." Berhasil Diupdate";
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

    public function delete_list($id,$mesin_list_id)
    {
        $data = $this->sertifikasi_mesin_produksi_list->where('id',$mesin_list_id)
                                                    ->where('sertifikasi_mesin_id',$id)
                                                    ->first();
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil!',
            'message_content' => 'Data Berhasil Dihapus'
        ]);
    }

    public function download_pdf()
    {
        $data['mesin_produksis'] = $this->sertifikasi_mesin_produksi
                                        ->whereHas('sertifikasi_mesin_produksi_list', function($query){
                                            $query->orderBy('tgl_resertifikat_selanjutnya','desc');
                                            // $query->whereYearBetween('tgl_resertifikat_selanjutnya',[$request['from_pdf_periode'],$request['to_pdf_periode']]);
                                        })
                                        ->get();
        // $data['mesin_produksis'] = $this->sertifikasi_mesin_produksi->with('sertifikasi_mesin_produksi_list')
        //                                                             ->whereHas('sertifikasi_mesin_produksi_list', function($query) use($request){
        //                                                                 $query->whereYear('tgl_resertifikat_selanjutnya','>=',$request['from_pdf_periode'].'-01-01')
        //                                                                 ->whereYear('tgl_resertifikat_selanjutnya','<=',$request['to_pdf_periode'].'-01-01');
        //                                                                 // $query->whereYearBetween('tgl_resertifikat_selanjutnya',[$request['from_pdf_periode'],$request['to_pdf_periode']]);
        //                                                             })->get();
        // dd($data);
        $pdf = PDF::loadView('sertifikasi.mesin_produksi.download_pdf',$data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('List Sertifikasi Mesin Produksi.pdf');
    }
}
