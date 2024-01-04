<?php

namespace App\Http\Controllers\Absensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinPro;
use App\Models\BiodataKaryawan;
use App\Models\IticDepartemen;
use App\Models\EmpJabatan;
use App\Models\EmpPosisi;
use App\Models\PresensiInfo;
use \Carbon\Carbon;
use Validator;
use DataTables;
use DB;
class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BiodataKaryawan::where(function($query) {
                                        return $query->where('nik','!=','1000001')
                                                    ->where('nik','!=','1000002')
                                                    ->where('nik','!=','1000003');
                                    })
                                    ->where('pin',1298)
                                    ->where('status_karyawan','!=','R')
                                    // ->paginate(20);
                                    ->get();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('departemen', function($row){
                                $cek_satuan_kerja = \App\Models\IticDepartemen::where('id_departemen',$row->satuan_kerja)->first();
                                if (empty($cek_satuan_kerja)) {
                                    $satuan_kerja = '-';
                                }else{
                                    if ($cek_satuan_kerja->nama_departemen >= 1) {
                                        $satuan_kerja = $cek_satuan_kerja->nama_unit;
                                    }else{
                                        $satuan_kerja = $cek_satuan_kerja->nama_departemen;
                                    }
                                }

                                return $satuan_kerja;
                            })
                            ->addColumn('posisi', function($row){
                                $cek_posisi = EmpJabatan::where('id_jabatan',$row->id_posisi)->first();
                                if (empty($cek_posisi)) {
                                    $posisi = '-';
                                }else{
                                    $posisi = $cek_posisi->nama_jabatan;
                                }
                                return $posisi;
                            })
                            ->addColumn('jam_masuk', function($row){
                                // $date_live_year = Carbon::now()->format('Y');
                                // $date_live_month = Carbon::now()->format('m');
                                // $date_live_date = Carbon::now()->format('d');

                                // $date_live = Carbon::now()->format('Y-m-d');

                                // $mesin_finger = FinPro::whereYear('scan_date',$date_live_year)
                                //                     ->whereMonth('scan_date',$date_live_month)
                                //                     ->whereDate('scan_date',$date_live_date)
                                //                     ->where('pin',$row->pin)
                                //                     ->where('inoutmode',1)
                                //                     ->first();
                                // $date_live = '2023-12-20';
                                $date_live = Carbon::now()->format('Y-m-d');
                                $mesin_finger = FinPro::where('scan_date','LIKE','%'.$date_live.'%')
                                                    ->where('pin',$row->pin)
                                                    ->where('inoutmode',1)
                                                    ->first();
                                if (empty($mesin_finger)) {
                                    $inoutmode = 0;
                                    $presensi_info = PresensiInfo::where('scan_date','LIKE','%'.$date_live.'%')
                                                                ->where('pin',$row->pin)
                                                                ->orderBy('scan_date','asc')
                                                                ->first();
                                    if (empty($presensi_info)) {
                                        $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`'.$date_live.'`,`'.$row->pin.'`,`'.$inoutmode.'`)"><i class="bx bxs-plus-circle bx-sm bx-tada text-success"></i></a>';
                                    }else{
                                        if ($presensi_info->status == 4) {
                                            $jam_masuk = '<a type="button" onclick="detail_edit_non_absensi_jam_masuk(`'.$presensi_info->att_rec.'`)" style="color: red">Sakit</a>';
                                        }elseif($presensi_info->status == 7){
                                            // $jam_masuk = 'Absen';
                                            $jam_masuk = 'Absen';
                                        }elseif($presensi_info->status == 13){
                                            $jam_masuk = 'Cuti';
                                        }
                                        else{
                                            // $jam_masuk = $presensi_info->scan_date;
                                            $jam_masuk = '<a type="button" onclick="detail_edit_non_absensi_jam_masuk(`'.$presensi_info->att_rec.'`)">'.$presensi_info->scan_date.'</a>';
                                        }
                                    }
                                }else{
                                    $date_jam_masuk = Carbon::create($mesin_finger->scan_date)->format('H:i');
                                    $jam_masuk = '<a type="button" onclick="detail_absensi_jam_masuk(`'.$mesin_finger->scan_date.'`,`'.$mesin_finger->pin.'`)" style="color: blue">'.$date_jam_masuk.'</a>';
                                }
                                return $jam_masuk;
                            })
                            ->addColumn('jam_pulang', function($row){
                                $date_live = '2023-12-20';
                                $mesin_finger = FinPro::where('scan_date','LIKE','%'.$date_live.'%')
                                                    ->where('pin',$row->pin)
                                                    ->where('inoutmode',2)
                                                    ->first();
                                if (empty($mesin_finger)) {
                                    // $jam_keluar = '-';
                                    $jam_keluar = '<a type="button"><i class="bx bxs-plus-circle bx-sm bx-tada text-success"></i></a>';
                                }else{
                                    $jam_keluar = Carbon::create($mesin_finger->scan_date)->format('H:i');
                                }
                                return $jam_keluar;
                            })
                            ->addColumn('total_jam', function($row){
                                $date_live = '2023-12-20';
                                $mesin_finger_jam_masuk = FinPro::where('scan_date','LIKE','%'.$date_live.'%')
                                                        ->where('pin',$row->pin)
                                                        ->where('inoutmode',1)
                                                        ->first();
                                if (empty($mesin_finger_jam_masuk)) {
                                    $jam_masuk = 0;
                                }else{
                                    $jam_masuk = Carbon::create($mesin_finger_jam_masuk->scan_date)->format('H:i');
                                }

                                $mesin_finger_jam_keluar = FinPro::where('scan_date','LIKE','%'.$date_live.'%')
                                                        ->where('pin',$row->pin)
                                                        ->where('inoutmode',2)
                                                        ->first();
                                if (empty($mesin_finger_jam_keluar)) {
                                    $jam_keluar = 0;
                                }else{
                                    $jam_keluar = Carbon::create($mesin_finger_jam_keluar->scan_date)->format('H:i');
                                }

                                $awal = strtotime($jam_masuk);
                                $akhir = strtotime($jam_keluar);
                                $diff  = $akhir - $awal;

                                $jam   = floor($diff / (60 * 60));
                                $menit = $diff - ( $jam * (60 * 60) );
                                $detik = $diff % 60;

                                $selisih_jam = ($jam).':'.floor($menit/60);

                                if ($awal == 0  && $akhir == 0) {
                                    $total_jam = '-';
                                }elseif($awal > 0 && $akhir == 0){
                                    $total_jam = '-';
                                }else{
                                    $total_jam = $selisih_jam;
                                }

                                return $total_jam;
                                // return $jam_keluar-$jam_masuk;
                            })
                            // ->addColumn('action', function($row){
                            //     $date_live = '2023-12-20';
                                
                            //     $btn = '<div class="btn-group">';
                            //     $btn.= '<button type="button" class="btn btn-success" onclick="detail(`'.$row->scan_date.'`,`'.$row->pin.'`)"><i class="bx bxs-bullseye bx-tada"></i></button>';
                            //     $btn.= '<button type="button" class="btn btn-primary"><i class="bx bxs-file bx-tada"></i></button>';
                            //     $btn.= '</div>';
                            //     return $btn;
                            // })
                            ->rawColumns(['jam_masuk','jam_pulang'])
                            ->make(true);
        }
        $data['status_absensis'] = DB::connection('absensi')->table('att_status')->get();
        // dd($data);
        return view('absensi.home.index',$data);
    }

    public function input_modal_nofinger_jam_masuk_absensi($date_live,$pin,$inout)
    {
        $mesin_finger = FinPro::where('scan_date','LIKE','%'.$date_live.'%')
                                ->where('pin',$pin)
                                ->where('inoutmode',$inout)
                                ->first();
        if (empty($mesin_finger)) {
            $biodata_karyawan = BiodataKaryawan::where('pin',$pin)->first();
            if (empty($biodata_karyawan)) {
                return response()->json([
                    'success' => false,
                    'message_title' => 'Data Karyawan Tidak Ditemukan'
                ]);
            }
            $date_live = Carbon::now()->format('Y-m-d');
            // $date_live = Carbon::now()->isoFormat('DD MMMM YYYY');
            // dd(Carbon::parse($date_live)->format('Y-m-d'));
            return response()->json([
                'success' => true,
                // 'message_title' => 'Data Tidak Ditemukan'
                'data' => $biodata_karyawan,
                'tanggal' => $date_live
            ]);
        }
        return response()->json([
            'success' => true,
            // 'data_karyawan' => $biodata_karyawan
            // 'data' => $mesin_finger
        ]);
    }

    public function input_modal_edit_nofinger_jam_masuk_absensi($att_rec)
    {
        $presensi_info = PresensiInfo::where('att_rec',$att_rec)->first();
        if (empty($presensi_info)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Presensi Tidak Ditemukan'
            ]);
        }

        $explode_keterangan = explode('@',$presensi_info->keterangan);
        
        $penyesuaian_jam_masuk_jam = Carbon::create($explode_keterangan[1])->format('H');
        $penyesuaian_jam_masuk_menit = Carbon::create($explode_keterangan[1])->format('i');
        $penyesuaian_istirahat_jam_masuk = Carbon::create($explode_keterangan[2])->format('H');
        $penyesuaian_istirahat_jam_menit = Carbon::create($explode_keterangan[2])->format('i');
        $penyesuaian_pulang_jam_masuk = Carbon::create($explode_keterangan[3])->format('H');
        $penyesuaian_pulang_jam_menit = Carbon::create($explode_keterangan[3])->format('i');
        
        $biodata_karyawan = BiodataKaryawan::where('pin',$presensi_info->pin)->first();
        return response()->json([
            'success' => true,
            // 'message_title' => 'Data Tidak Ditemukan'
            'att_rec' => $presensi_info->att_rec,
            'karyawan' => $biodata_karyawan,
            'date' => Carbon::create($presensi_info->scan_date)->format('Y-m-d'),
            'time' => Carbon::create($presensi_info->scan_date)->format('H:i:s'),
            'status' => $presensi_info->status,
            'penyesuaian_jam_masuk_jam' => $penyesuaian_jam_masuk_jam,
            'penyesuaian_jam_masuk_menit' => $penyesuaian_jam_masuk_menit,
            'penyesuaian_istirahat_jam_masuk_jam' => $penyesuaian_istirahat_jam_masuk,
            'penyesuaian_istirahat_jam_masuk_menit' => $penyesuaian_istirahat_jam_menit,
            'penyesuaian_pulang_jam_masuk_jam' => $penyesuaian_pulang_jam_masuk,
            'penyesuaian_pulang_jam_menit_menit' => $penyesuaian_pulang_jam_menit,
            'keterangan' => $explode_keterangan[0]
        ]);
    }

    public function input_modal_nofinger_jam_masuk_simpan(Request $request)
    {
        $rules = [
            'jam_masuk_status_non_absen_masuk' => 'required',
            // 'penyesuaian_masuk_jam_masuk_jam' => 'required',
            // 'penyesuaian_masuk_jam_masuk_menit' => 'required',
            // 'penyesuaian_istirahat_jam_masuk_jam' => 'required',
            // 'penyesuaian_istirahat_jam_masuk_menit' => 'required',
            // 'penyesuaian_pulang_jam_masuk_jam' => 'required',
            // 'penyesuaian_pulang_jam_masuk_menit' => 'required',
            // 'jam_masuk_keterangan' => 'required',
        ];

        $messages = [
            'jam_masuk_status_non_absen_masuk.required'  => 'Status wajib diisi.',
            // 'jam_masuk_keterangan.required'  => 'Keterangan wajib diisi.',
            // 'penyesuaian_masuk_jam_masuk_jam.required'  => 'Penyesuaian Jam Masuk Jam wajib diisi.',
            // 'penyesuaian_masuk_jam_masuk_menit.required'  => 'Penyesuaian Jam Masuk Menit wajib diisi.',
            // 'penyesuaian_istirahat_jam_masuk_jam.required'  => 'Penyesuaian Jam Istirahat Jam wajib diisi.',
            // 'penyesuaian_istirahat_jam_masuk_menit.required'  => 'Penyesuaian Jam Istirahat Menit wajib diisi.',
            // 'penyesuaian_pulang_jam_masuk_jam.required'  => 'Penyesuaian Jam Istirahat Jam wajib diisi.',
            // 'penyesuaian_pulang_jam_masuk_menit.required'  => 'Penyesuaian Jam Istirahat Menit wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            // $input['scan_date'] = $request->tanggal_non_absen_masuk.' '.$request->jam_non_absen_masuk.':'.$request->menit_non_absen_masuk.':'.$request->detik_non_absen_masuk;
            // $input['pin'] = $request->pin_non_absen_masuk;
            // $input['status'] = $request->jam_masuk_status_non_absen_masuk;
            // // dd($input);
            // return response()->json([
            //     'success' => true,
            //     // 'data' => $input
            // ]);
            $norut = PresensiInfo::max('att_rec');
            $input['att_id'] = Carbon::now()->format('Y').$norut+1;
            $input['scan_date'] = $request->tanggal_non_absen_masuk.' '.$request->jam_non_absen_masuk.':'.$request->menit_non_absen_masuk.':'.$request->detik_non_absen_masuk;
            $input['pin'] = $request->pin_non_absen_masuk;
            $input['status'] = $request->jam_masuk_status_non_absen_masuk;
            if (!empty($request->penyesuaian_masuk_jam_masuk_jam_non_absen) && !empty($request->penyesuaian_masuk_jam_masuk_menit_non_absen)) {
                $penyesuaian_jam_masuk_jam = $request->penyesuaian_masuk_jam_masuk_jam_non_absen.':'.$request->penyesuaian_masuk_jam_masuk_menit_non_absen;
            }else{
                $penyesuaian_jam_masuk_jam = null;
            }
            
            if (!empty($request->penyesuaian_istirahat_jam_masuk_jam_non_absen) && !empty($request->penyesuaian_istirahat_jam_masuk_menit_non_absen)) {
                $penyesuaian_jam_istirahat_jam = $request->penyesuaian_istirahat_jam_masuk_jam_non_absen.':'.$request->penyesuaian_istirahat_jam_masuk_menit_non_absen;
            }else{
                $penyesuaian_jam_istirahat_jam = null;
            }
    
            if (!empty($request->penyesuaian_pulang_jam_masuk_jam_non_absen) && !empty($request->penyesuaian_pulang_jam_masuk_menit_non_absen)) {
                $penyesuaian_jam_pulang_jam = $request->penyesuaian_pulang_jam_masuk_jam_non_absen.':'.$request->penyesuaian_pulang_jam_masuk_menit_non_absen;
            }else{
                $penyesuaian_jam_pulang_jam = null;
            }
    
            $input['keterangan'] = $request->keterangan_jam_masuk_non_absen.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;

            $presensi_info = PresensiInfo::create($input);
            if ($presensi_info) {
                $message_title="Berhasil !";
                $message_content="Absensi Jam Masuk Berhasil Dibuat";
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
        // dd($input);
    }

    public function input_modal_edit_nofinger_jam_masuk_update(Request $request)
    {
        $rules = [
            'edit_jam_masuk_status_non_absen_masuk' => 'required',
        ];

        $messages = [
            'edit_jam_masuk_status_non_absen_masuk.required'  => 'Status Presensi wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            
            $presensi_info = PresensiInfo::where('att_rec',$request->edit_att_rec_non_absen)->first();
            if (!empty($request->edit_penyesuaian_masuk_jam_masuk_jam_non_absen) && !empty($request->edit_penyesuaian_masuk_jam_masuk_menit_non_absen)) {
                $penyesuaian_jam_masuk_jam = $request->edit_penyesuaian_masuk_jam_masuk_jam_non_absen.':'.$request->edit_penyesuaian_masuk_jam_masuk_menit_non_absen;
            }else{
                $penyesuaian_jam_masuk_jam = null;
            }
            
            if (!empty($request->edit_penyesuaian_istirahat_jam_masuk_jam_non_absen) && !empty($request->edit_penyesuaian_istirahat_jam_masuk_menit_non_absen)) {
                $penyesuaian_jam_istirahat_jam = $request->edit_penyesuaian_istirahat_jam_masuk_jam_non_absen.':'.$request->edit_penyesuaian_istirahat_jam_masuk_menit_non_absen;
            }else{
                $penyesuaian_jam_istirahat_jam = null;
            }
    
            if (!empty($request->edit_penyesuaian_pulang_jam_masuk_jam_non_absen) && !empty($request->edit_penyesuaian_pulang_jam_masuk_menit_non_absen)) {
                $penyesuaian_jam_pulang_jam = $request->edit_penyesuaian_pulang_jam_masuk_jam_non_absen.':'.$request->edit_penyesuaian_pulang_jam_masuk_menit_non_absen;
            }else{
                $penyesuaian_jam_pulang_jam = null;
            }

            $input['status'] = $request->edit_jam_masuk_status_non_absen_masuk;
            $input['keterangan'] = $request->edit_keterangan_jam_masuk_non_absen.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;
            // dd($input['keterangan']);
            $presensi_info->update($input);
            if ($presensi_info) {
                $message_title="Berhasil !";
                $message_content="Absensi Jam Masuk Berhasil Diupdate";
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

    public function detail_jam_masuk($scan_date,$pin){
        // $fin_pro = FinPro::with('biodata_karyawan')
        //                 ->where('scan_date','LIKE','%'.$scan_date.'%')
        //                 ->where('pin',$pin)
        //                 ->where('inoutmode',1)
        //                 ->first();
        // // dd($fin_pro);
        // if (empty($fin_pro)) {
        //     return response()->json([
        //         'success' => false,
        //         'message_title' => 'Data Karyawan Tidak Ditemukan'
        //     ]);
        // }

        // return response()->json([
        //     'success' => true,
        //     'biodata_karyawan' => $fin_pro->biodata_karyawan,
        //     'data' => [
        //         'sn' => $fin_pro->sn,
        //         // 'scan_date' => Carbon::create(◘)->isoFormat('DD MMMM YYYY HH:mm:ss'),
        //         'scan_date' => $fin_pro->scan_date,
        //         'pin' => $fin_pro->pin,
        //         'verifymode' => $fin_pro->verifymode,
        //         'inoutmode' => $fin_pro->inoutmode,
        //         'reserved' => $fin_pro->reserved,
        //         'work_code' => $fin_pro->work_code,
        //         'att_id' => $fin_pro->att_id,
        //     ]
        // ]);

        $presensi_info = PresensiInfo::where('scan_date','LIKE','%'.$scan_date.'%')
                                        ->where('pin',$pin)
                                        ->orderBy('scan_date','asc')
                                        ->first();
        if(empty($presensi_info)){
            // return response()->json([
            //     'success' => false,
            //     'message_title' => 'Presensi Tidak Ditemukan'
            // ]);
            $fin_pro = FinPro::with('biodata_karyawan')
                            ->where('scan_date','LIKE','%'.$scan_date.'%')
                            ->where('pin',$pin)
                            ->where('inoutmode',1)
                            ->first();
            // dd($fin_pro);
            if (empty($fin_pro)) {
                return response()->json([
                    'success' => false,
                    'message_title' => 'Data Karyawan Tidak Ditemukan'
                ]);
            }
    
            return response()->json([
                'success' => true,
                'biodata_karyawan' => $fin_pro->biodata_karyawan,
                'data' => [
                    'sn' => $fin_pro->sn,
                    // 'scan_date' => Carbon::create(◘)->isoFormat('DD MMMM YYYY HH:mm:ss'),
                    'scan_date' => $fin_pro->scan_date,
                    'pin' => $fin_pro->pin,
                    'verifymode' => $fin_pro->verifymode,
                    'inoutmode' => $fin_pro->inoutmode,
                    'reserved' => $fin_pro->reserved,
                    'work_code' => $fin_pro->work_code,
                    'att_id' => $fin_pro->att_id,
                ]
            ]);
        }

        $explode_keterangan = explode('@',$presensi_info->keterangan);

        return response()->json([
            'success' => true,
            'biodata_karyawan' => $presensi_info->biodata_karyawan,
            'data' => [
                'att_rec' => $presensi_info->att_rec,
                'att_id' => $presensi_info->att_id,
                'scan_date' => $presensi_info->scan_date,
                'pin' => $presensi_info->pin,
                'status' => $presensi_info->status,
                'penyesuaian_masuk_jam' => Carbon::create($explode_keterangan[1])->format('H'),
                'penyesuaian_masuk_menit' => Carbon::create($explode_keterangan[1])->format('i'),
                'penyesuaian_istirahat_jam' => Carbon::create($explode_keterangan[2])->format('H'),
                'penyesuaian_istirahat_menit' => Carbon::create($explode_keterangan[2])->format('i'),
                'penyesuaian_pulang_jam' => Carbon::create($explode_keterangan[3])->format('H'),
                'penyesuaian_pulang_menit' => Carbon::create($explode_keterangan[3])->format('i'),
                'keterangan' => $explode_keterangan[0],
            ]
        ]);
    }

    public function detail_jam_masuk_simpan(Request $request){
        $rules = [
            'detail_masuk_jam_masuk_status' => 'required',
        ];

        $messages = [
            'detail_masuk_jam_masuk_status.required'  => 'Status Presensi wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $presensi_info = PresensiInfo::where('scan_date','LIKE','%'.$request->detail_masuk_tanggal_masuk.'%')
                                        ->where('pin',$request->detail_masuk_pin)
                                        ->first();
            if (empty($presensi_info)) {
                $norut = PresensiInfo::max('att_rec');
                $input['att_id'] = Carbon::now()->format('Y').$norut+1;
                $input['scan_date'] = $request->detail_masuk_tanggal_masuk;
                $input['pin'] = $request->detail_masuk_pin;
                $input['status'] = $request->detail_masuk_jam_masuk_status;
                if (!empty($request->detail_masuk_penyesuaian_masuk_jam_masuk_jam) && !empty($request->detail_masuk_penyesuaian_masuk_jam_masuk_menit)) {
                    $penyesuaian_jam_masuk_jam = $request->detail_masuk_penyesuaian_masuk_jam_masuk_jam.':'.$request->detail_masuk_penyesuaian_masuk_jam_masuk_menit;
                }else{
                    $penyesuaian_jam_masuk_jam = null;
                }
                
                if (!empty($request->detail_masuk_penyesuaian_istirahat_jam_masuk_jam) && !empty($request->detail_masuk_penyesuaian_istirahat_jam_masuk_menit)) {
                    $penyesuaian_jam_istirahat_jam = $request->detail_masuk_penyesuaian_istirahat_jam_masuk_jam.':'.$request->detail_masuk_penyesuaian_istirahat_jam_masuk_menit;
                }else{
                    $penyesuaian_jam_istirahat_jam = null;
                }
        
                if (!empty($request->detail_masuk_penyesuaian_pulang_jam_masuk_jam) && !empty($request->detail_masuk_penyesuaian_pulang_jam_masuk_jam)) {
                    $penyesuaian_jam_pulang_jam = $request->detail_masuk_penyesuaian_pulang_jam_masuk_jam.':'.$request->detail_masuk_penyesuaian_pulang_jam_masuk_jam;
                }else{
                    $penyesuaian_jam_pulang_jam = null;
                }
        
                $input['keterangan'] = $request->detail_masuk_keterangan_jam_masuk.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;
    
                $save_presensi_info = PresensiInfo::create($input);
                if ($save_presensi_info) {
                    $message_title="Berhasil !";
                    $message_content="Presensi Masuk Berhasil Dibuat";
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

            $input['scan_date'] = $request->detail_masuk_tanggal_masuk;
            $input['pin'] = $request->detail_masuk_pin;
            $input['status'] = $request->detail_masuk_jam_masuk_status;
            if (!empty($request->detail_masuk_penyesuaian_masuk_jam_masuk_jam) && !empty($request->detail_masuk_penyesuaian_masuk_jam_masuk_menit)) {
                $penyesuaian_jam_masuk_jam = $request->detail_masuk_penyesuaian_masuk_jam_masuk_jam.':'.$request->detail_masuk_penyesuaian_masuk_jam_masuk_menit;
            }else{
                $penyesuaian_jam_masuk_jam = null;
            }
            
            if (!empty($request->detail_masuk_penyesuaian_istirahat_jam_masuk_jam) && !empty($request->detail_masuk_penyesuaian_istirahat_jam_masuk_menit)) {
                $penyesuaian_jam_istirahat_jam = $request->detail_masuk_penyesuaian_istirahat_jam_masuk_jam.':'.$request->detail_masuk_penyesuaian_istirahat_jam_masuk_menit;
            }else{
                $penyesuaian_jam_istirahat_jam = null;
            }
    
            if (!empty($request->detail_masuk_penyesuaian_pulang_jam_masuk_jam) && !empty($request->detail_masuk_penyesuaian_pulang_jam_masuk_jam)) {
                $penyesuaian_jam_pulang_jam = $request->detail_masuk_penyesuaian_pulang_jam_masuk_jam.':'.$request->detail_masuk_penyesuaian_pulang_jam_masuk_jam;
            }else{
                $penyesuaian_jam_pulang_jam = null;
            }
    
            $input['keterangan'] = $request->detail_masuk_keterangan_jam_masuk.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;

            $presensi_info->update($input);
            if ($presensi_info) {
                $message_title="Berhasil !";
                $message_content="Presensi Masuk Berhasil Diupdate";
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

    public function fin_tes()
    {
        return FinPro::all();
    }
}
