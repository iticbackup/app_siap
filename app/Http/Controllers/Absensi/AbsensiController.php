<?php

namespace App\Http\Controllers\Absensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinPro;
use App\Models\BiodataKaryawan;
use App\Models\DepartemenUser;
use App\Models\IticDepartemen;
use App\Models\EmpJabatan;
use App\Models\EmpPosisi;
use App\Models\PresensiInfo;
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use Validator;
use DataTables;
use DB;
class AbsensiController extends Controller
{
    function __construct(
        FinPro $fin_pro,
        BiodataKaryawan $biodata_karyawan,
        DepartemenUser $departemen_user,
        IticDepartemen $itic_departemen,
        EmpJabatan $emp_jabatan,
        EmpPosisi $emp_posisi,
        PresensiInfo $presensi_info
    ){
        $this->fin_pro = $fin_pro;
        $this->biodata_karyawan = $biodata_karyawan;
        $this->departemen_user = $departemen_user;
        $this->itic_departemen = $itic_departemen;
        $this->emp_jabatan = $emp_jabatan;
        $this->emp_posisi = $emp_posisi;
        $this->presensi_info = $presensi_info;
    }
    public function index(Request $request)
    {
        if (auth()->user()->nik == 0000000) {
            $data['biodata_karyawans'] = $this->biodata_karyawan->with('departemen')
                                                        // ->select([
                                                        //     'id','nik','nama','alamat','id_posisi','id_jabatan',
                                                        //     'pin'
                                                        // ])
                                                        ->where(function($query) {
                                                            return $query->where('nik','!=','1000001')
                                                                        ->where('nik','!=','1000002')
                                                                        ->where('nik','!=','1000003');
                                                        })
                                                        // ->where('pin',1298)
                                                        ->orderBy('id_departemen','asc')
                                                        ->where('status_karyawan','!=','R')
                                                        // ->take(20)
                                                        ->paginate(20);
                                                        // ->get();
            // // dd($data);
            $data['status_absensis'] = DB::connection('absensi')->table('att_status')->get();
            // $start_year_now = Carbon::now()->startOfYear()->format('Y-m');
            // $end_year_now = Carbon::now()->endOfYear()->format('Y-m');
            // for ($i=$start_year_now; $i <= $end_year_now; $i++) { 
            //     $data['periode'][] = Carbon::create($i)->isoFormat('MMMM YYYY');
            //     $total_absen_masuk = $this->fin_pro->where('scan_date','LIKE','%'.$i.'%')
            //                                         ->whereTime('scan_date','<=','11:59')
            //                                         ->orderBy('scan_date','desc')
            //                                         ->take(1)
            //                                         ->count();
            //     // dd($total_absen_masuk);
            //     $data['hasil'][] = $total_absen_masuk;
            // }

            $data['fin_pro'] = $this->fin_pro;
            $data['presensi_info'] = $this->presensi_info;
            $data['departemens'] = $this->itic_departemen->all();
            // dd($data);
            return view('absensi.home.index',$data);
        }else{
            $akses_departemen = $this->departemen_user->whereIn('departemen_id',[3,4])->where('nik',auth()->user()->nik)->first();
            // dd($akses_departemen);
            if (empty($akses_departemen)) {
                return redirect()->back()->with('error','Maaf Anda Tidak Bisa Akses Halaman Absensi');
            }else{
                if ($akses_departemen->nik == auth()->user()->nik) {
                    $data['biodata_karyawans'] = $this->biodata_karyawan->where(function($query) {
                                                                    return $query->where('nik','!=','1000001')
                                                                                ->where('nik','!=','1000002')
                                                                                ->where('nik','!=','1000003');
                                                                })
                                                                // ->where('pin',1298)
                                                                ->where('status_karyawan','!=','R')
                                                                ->paginate(20);
                    $data['status_absensis'] = DB::connection('absensi')->table('att_status')->get();
                    // $start_year_now = Carbon::now()->startOfYear()->format('Y-m');
                    // $end_year_now = Carbon::now()->endOfYear()->format('Y-m');
                    // for ($i=$start_year_now; $i <= $end_year_now; $i++) { 
                    //     $data['periode'][] = Carbon::create($i)->isoFormat('MMMM YYYY');
                    //     $total_absen_masuk = $this->fin_pro->where('scan_date','LIKE','%'.$i.'%')
                    //                                         ->whereTime('scan_date','<=','11:59')
                    //                                         ->orderBy('scan_date','desc')
                    //                                         ->take(1)
                    //                                         ->count();
                    //     // dd($total_absen_masuk);
                    //     $data['hasil'][] = $total_absen_masuk;
                    // }
                    $data['fin_pro'] = $this->fin_pro;
                    $data['presensi_info'] = $this->presensi_info;
                    return view('absensi.home.index',$data);

                    // if ($request->ajax()) {
                    //     $data = $this->biodata_karyawan->with('departemen','posisi')
                    //                                             ->where(function($query) {
                    //                                                 return $query->where('nik','!=','1000001')
                    //                                                             ->where('nik','!=','1000002')
                    //                                                             ->where('nik','!=','1000003');
                    //                                             })
                    //                                             ->orderBy('satuan_kerja','asc')
                    //                                             ->where('status_karyawan','!=','R')
                    //                                             ->paginate(20);
                    //     foreach ($data as $key => $biodata_karyawan) {
                    //         $date_live = Carbon::now()->format('Y-m-d');
                    //         $mesin_jam_masuk = $this->fin_pro->where('scan_date', 'LIKE', '%'.$date_live.'%')
                    //                                         ->whereTime('scan_date','<=','11:59:59')
                    //                                         ->where('pin', $biodata_karyawan->pin)
                    //                                         ->orderBy('scan_date','asc')
                    //                                         ->first();
                    //         if (empty($mesin_jam_masuk)) {
                    //             $presensi_info_masuk = $this->presensi_info->where('scan_date', 'LIKE', '%' . $date_live . '%')
                    //                                                         ->where('pin', $biodata_karyawan->pin)
                    //                                                         ->whereTime('scan_date','<=','11:59:59')
                    //                                                         ->first();
                    //             if (empty($presensi_info_masuk)) {
                    //                 $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)"><i class="bx bxs-plus-circle bx-sm bx-tada text-success"></i></a>';
                    //             }else{
                    //                 if ($presensi_info_masuk->status == 4) {
                    //                     $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: red">Sakit</a>';
                    //                 } elseif ($presensi_info_masuk->status == 7) {
                    //                     $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: purple">Absen</a>';
                    //                 } elseif ($presensi_info_masuk->status == 13) {
                    //                     $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: orange">Cuti</a>';
                    //                 } else {
                    //                     $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`'.$presensi_info_masuk->att_rec.'`)">'.$presensi_info_masuk->scan_date.'</a>';
                    //                 }
                    //             }
                    //         }else{
                    //             $absensi_masuk = $this->presensi_info->with('presensi_status')
                    //                                                 ->where('scan_date', 'LIKE', '%' . $date_live . '%')
                    //                                                 ->where('pin', $biodata_karyawan->pin)
                    //                                                 ->whereTime('scan_date','<=','11:59:59')
                    //                                                 ->first();
                    //             if (empty($absen_masuk)) {
                    //                 $date_jam_masuk = Carbon::create($mesin_jam_masuk->scan_date)->format('H:i');
                    //                 $jam_masuk = '<a type="button" onclick="detail_absensi_jam_masuk(`' . $mesin_jam_masuk->scan_date . '`,`' . $mesin_jam_masuk->pin . '`,`' . $mesin_jam_masuk->inoutmode . '`)" style="color: blue">' . $date_jam_masuk . '</a>';
                    //             } else {
                    //                 $date_jam_masuk = Carbon::create($mesin_jam_masuk->scan_date)->format('H:i');
                    //                 $jam_masuk = '<a type="button" onclick="detail_absensi_jam_masuk(`' . $mesin_jam_masuk->scan_date . '`,`' . $mesin_jam_masuk->pin . '`,`' . $mesin_jam_masuk->inoutmode . '`)" style="color: blue">' . $date_jam_masuk . ' (' . $absen_masuk->presensi_status->status_info . ')</a>';
                    //             }
                    //         }
        
                    //         $mesin_jam_pulang = $this->fin_pro->where('scan_date', 'LIKE', '%'.$date_live.'%')
                    //                                         ->whereTime('scan_date','>=','12:00:00')
                    //                                         ->where('pin', $biodata_karyawan->pin)
                    //                                         ->orderBy('scan_date','desc')
                    //                                         ->first();
                    //         if (empty($mesin_jam_pulang)) {
                    //             $presensi_info_2 = $this->fin_pro->where('scan_date', 'LIKE', '%' . $date_live . '%')
                    //                                             ->where('pin', $biodata_karyawan->pin)
                    //                                             ->whereTime('scan_date','>=','12:00:00')
                    //                                             ->orderBy('scan_date','desc')
                    //                                             ->first();
                    //             if (empty($presensi_info_2)) {
                    //                 $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)"><i class="bx bxs-plus-circle bx-sm bx-tada text-success"></i></a>';
                    //             } else {
                    //                 if ($presensi_info_2->status == 4) {
                    //                     $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: red">Sakit</a>';
                    //                 } elseif ($presensi_info_2->status == 7) {
                    //                     $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: purple">Absen</a>';
                    //                 } elseif ($presensi_info_2->status == 13) {
                    //                     $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: orange">Cuti</a>';
                    //                 } else {
                    //                     $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`'.$date_live.'`,`'.$biodata_karyawan->pin.'`,`'. 0 .'`)">'.$presensi_info_2->scan_date.'</a>';
                    //                 }
                    //             }
                    //         }else{
                    //             $absen_keluar = $this->presensi_info->with('presensi_status')
                    //                                                 ->where('scan_date', 'LIKE', '%' . $date_live . '%')
                    //                                                 ->where('pin', $biodata_karyawan->pin)
                    //                                                 ->whereTime('scan_date','>=','12:00:00')
                    //                                                 ->orderBy('scan_date','desc')
                    //                                                 ->first();
                    //             if (empty($absen_keluar)) {
                    //                 $date_jam_keluar = Carbon::create($mesin_jam_pulang->scan_date)->format('H:i');
                    //                 $jam_keluar = '<a type="button" onclick="detail_absensi_jam_keluar(`' . $mesin_jam_pulang->scan_date . '`,`' . $mesin_jam_pulang->pin . '`,`' . $mesin_jam_pulang->inoutmode . '`)" style="color: blue">' . $date_jam_keluar . '</a>';
                    //             } else {
                    //                 $date_jam_keluar = Carbon::create($mesin_jam_pulang->scan_date)->format('H:i');
                    //                 $jam_keluar = '<a type="button" onclick="detail_absensi_jam_keluar(`' . $mesin_jam_pulang->scan_date . '`,`' . $mesin_jam_pulang->pin . '`,`' . $mesin_jam_pulang->inoutmode . '`)" style="color: red">' . $date_jam_keluar . ' (' . $absen_keluar->presensi_status->status_info . ')</a>';
                    //             }
                    //         }
        
                    //         $data_karyawan[] = [
                    //             'id' => $biodata_karyawan->id,
                    //             'nik' => $biodata_karyawan->nik,
                    //             'nama' => $biodata_karyawan->nama,
                    //             'departemen' => $biodata_karyawan->departemen->nama_departemen >= 1 ? $biodata_karyawan->departemen->nama_unit : $biodata_karyawan->departemen->nama_departemen,
                    //             'posisi' => $biodata_karyawan->posisi->nama_posisi,
                    //             'jam_masuk' => $jam_masuk,
                    //             'jam_pulang' => $jam_keluar,
                    //         ];
                    //     }
                    //     return $data_karyawan;
                    // }
                    // $data['status_absensis'] = DB::connection('absensi')->table('att_status')->get();
                    // return view('absensi.home.index',$data);
                }else{
                    return redirect()->back()->with('error','Maaf Anda Tidak Bisa Akses Halaman Absensi');
                }
            }
        }

        // if (auth()->user()->nik == 0000000) {
        //     $data['biodata_karyawans'] = $this->biodata_karyawan->where(function($query) {
        //                                                             return $query->where('nik','!=','1000001')
        //                                                                         ->where('nik','!=','1000002')
        //                                                                         ->where('nik','!=','1000003');
        //                                                         })
        //                                                         ->orderBy('id_departemen','asc')
        //                                                         ->where('status_karyawan','!=','R')
        //                                                         ->paginate(20);
        //     // dd($data);
        //     $data['status_absensis'] = DB::connection('absensi')->table('att_status')->get();
        //     $data['fin_pro'] = $this->fin_pro;
        //     $data['presensi_info'] = $this->presensi_info;
        //     return view('absensi.home.index',$data);
        // }
    }

    // public function detail($nik){
    //     return $nik;
    // }

    public function input_modal_nofinger_jam_masuk_absensi($date_live,$pin,$inoutmode)
    {
        $presensi_info = $this->presensi_info->where('scan_date','LIKE','%'.$date_live.'%')
                                            ->where('pin',$pin)
                                            ->where('inoutmode',$inoutmode)
                                            ->first();
        // dd($presensi_info);
        if (empty($presensi_info)){
            $biodata_karyawan = $this->biodata_karyawan->where('pin',$pin)->first();
            if (empty($biodata_karyawan)) {
                return response()->json([
                    'success' => false,
                    'message_title' => 'Data Karyawan Tidak Ditemukan'
                ]);
            }
            $date_live = Carbon::now()->format('Y-m-d');
            return response()->json([
                'success' => true,
                'data' => $biodata_karyawan,
                'tanggal' => $date_live,
                'inoutmode' => $inoutmode
            ]);
        }

        $explode_keterangan = explode('@',$presensi_info->keterangan);

        return response()->json([
            'success' => true,
            'data' => $presensi_info->biodata_karyawan,
            'tanggal' => Carbon::create($presensi_info->scan_date)->format('Y-m-d'),
            'jam' => Carbon::create($presensi_info->scan_date)->format('H'),
            'menit' => Carbon::create($presensi_info->scan_date)->format('i'),
            'detik' => Carbon::create($presensi_info->scan_date)->format('s'),
            'status' => $presensi_info->status,
            'inoutmode' => $inoutmode,
            'penyesuaian_masuk_jam' => Carbon::create($explode_keterangan[1])->format('H'),
            'penyesuaian_masuk_menit' => Carbon::create($explode_keterangan[1])->format('i'),
            'penyesuaian_istirahat_jam' => Carbon::create($explode_keterangan[2])->format('H'),
            'penyesuaian_istirahat_menit' => Carbon::create($explode_keterangan[2])->format('i'),
            'penyesuaian_pulang_jam' => Carbon::create($explode_keterangan[3])->format('H'),
            'penyesuaian_pulang_menit' => Carbon::create($explode_keterangan[3])->format('i'),
            'keterangan' => $explode_keterangan[0],
        ]);
    }

    public function input_modal_nofinger_jam_masuk_simpan(Request $request)
    {
        $rules = [
            'status_non_absen_masuk' => 'required',
        ];

        $messages = [
            'status_non_absen_masuk.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $presensi_info = $this->presensi_info->where('scan_date','LIKE','%'.$request->tanggal_non_absen_masuk.'%')
                                        ->where('pin',$request->pin_non_absen_masuk)
                                        ->where('inoutmode',$request->inoutmode_non_absen_masuk)
                                        ->first();
            if (empty($presensi_info)) {
                $norut = $this->presensi_info->max('att_rec');
                $input['att_id'] = Carbon::now()->format('Y').$norut+1;
                $input['scan_date'] = $request->tanggal_non_absen_masuk.' '.$request->jam_non_absen_masuk.':'.$request->menit_non_absen_masuk.':'.$request->detik_non_absen_masuk;
                $input['pin'] = $request->pin_non_absen_masuk;
                $input['inoutmode'] = $request->inoutmode_non_absen_masuk;
                $input['status'] = $request->status_non_absen_masuk;
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
    
                $presensi_info = $this->presensi_info->create($input);
                if ($presensi_info) {
                    $message_title="Berhasil !";
                    $message_content="Presensi Jam Masuk Berhasil Dibuat";
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

            $input['scan_date'] = $request->tanggal_non_absen_masuk.' '.$request->jam_non_absen_masuk.':'.$request->menit_non_absen_masuk.':'.$request->detik_non_absen_masuk;
            $input['pin'] = $request->pin_non_absen_masuk;
            $input['inoutmode'] = $request->inoutmode_non_absen_masuk;
            $input['status'] = $request->status_non_absen_masuk;
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
        // dd($input);
    }

    public function input_modal_nofinger_jam_pulang_absensi($date_live,$pin,$inoutmode)
    {
        $presensi_info = $this->presensi_info->where('scan_date','LIKE','%'.$date_live.'%')
                                            ->where('pin',$pin)
                                            ->where('inoutmode',$inoutmode)
                                            // ->orderBy('scan_date','asc')
                                            ->first();
        // dd($presensi_info);
        if (empty($presensi_info)){
            $biodata_karyawan = $this->biodata_karyawan->where('pin',$pin)->first();
            if (empty($biodata_karyawan)) {
                return response()->json([
                    'success' => false,
                    'message_title' => 'Data Karyawan Tidak Ditemukan'
                ]);
            }
            $date_live = Carbon::now()->format('Y-m-d');
            return response()->json([
                'success' => true,
                'data' => $biodata_karyawan,
                'tanggal' => $date_live,
                'inoutmode' => $inoutmode
            ]);
        }

        $explode_keterangan = explode('@',$presensi_info->keterangan);

        return response()->json([
            'success' => true,
            'data' => $presensi_info->biodata_karyawan,
            'tanggal' => Carbon::create($presensi_info->scan_date)->format('Y-m-d'),
            'jam' => Carbon::create($presensi_info->scan_date)->format('H'),
            'menit' => Carbon::create($presensi_info->scan_date)->format('i'),
            'detik' => Carbon::create($presensi_info->scan_date)->format('s'),
            'status' => $presensi_info->status,
            'inoutmode' => $inoutmode,
            'penyesuaian_masuk_jam' => Carbon::create($explode_keterangan[1])->format('H'),
            'penyesuaian_masuk_menit' => Carbon::create($explode_keterangan[1])->format('i'),
            'penyesuaian_istirahat_jam' => Carbon::create($explode_keterangan[2])->format('H'),
            'penyesuaian_istirahat_menit' => Carbon::create($explode_keterangan[2])->format('i'),
            'penyesuaian_pulang_jam' => Carbon::create($explode_keterangan[3])->format('H'),
            'penyesuaian_pulang_menit' => Carbon::create($explode_keterangan[3])->format('i'),
            'keterangan' => $explode_keterangan[0],
        ]);
    }

    public function input_modal_nofinger_jam_pulang_simpan(Request $request)
    {
        $rules = [
            'status_non_absen_keluar' => 'required',
        ];

        $messages = [
            'status_non_absen_keluar.required'  => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $presensi_info = $this->presensi_info->where('scan_date','LIKE','%'.$request->jam_non_absen_keluar.'%')
                                        ->where('pin',$request->pin_non_absen_keluar)
                                        ->where('inoutmode',$request->inoutmode_non_absen_keluar)
                                        ->first();
            if (empty($presensi_info)) {
                $norut = $this->presensi_info->max('att_rec');
                $input['att_id'] = Carbon::now()->format('Y').$norut+1;
                $input['scan_date'] = $request->tanggal_non_absen_keluar.' '.$request->jam_non_absen_keluar.':'.$request->menit_non_absen_keluar.':'.$request->detik_non_absen_keluar;
                $input['pin'] = $request->pin_non_absen_keluar;
                $input['inoutmode'] = $request->inoutmode_non_absen_keluar;
                $input['status'] = $request->status_non_absen_keluar;
                if (!empty($request->penyesuaian_masuk_jam_keluar_jam_non_absen) && !empty($request->penyesuaian_masuk_jam_keluar_menit_non_absen)) {
                    $penyesuaian_jam_masuk_jam = $request->penyesuaian_masuk_jam_keluar_jam_non_absen.':'.$request->penyesuaian_masuk_jam_keluar_menit_non_absen;
                }else{
                    $penyesuaian_jam_masuk_jam = null;
                }
                
                if (!empty($request->penyesuaian_istirahat_jam_keluar_jam_non_absen) && !empty($request->penyesuaian_istirahat_jam_keluar_menit_non_absen)) {
                    $penyesuaian_jam_istirahat_jam = $request->penyesuaian_istirahat_jam_keluar_jam_non_absen.':'.$request->penyesuaian_istirahat_jam_keluar_menit_non_absen;
                }else{
                    $penyesuaian_jam_istirahat_jam = null;
                }
        
                if (!empty($request->penyesuaian_pulang_jam_keluar_jam_non_absen) && !empty($request->penyesuaian_pulang_jam_keluar_menit_non_absen)) {
                    $penyesuaian_jam_pulang_jam = $request->penyesuaian_pulang_jam_keluar_jam_non_absen.':'.$request->penyesuaian_pulang_jam_keluar_menit_non_absen;
                }else{
                    $penyesuaian_jam_pulang_jam = null;
                }
        
                $input['keterangan'] = $request->keterangan_jam_keluar_non_absen.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;
    
                $presensi_info = $this->presensi_info->create($input);
                if ($presensi_info) {
                    $message_title="Berhasil !";
                    $message_content="Presensi Jam Pulang Berhasil Dibuat";
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

            $input['scan_date'] = $request->tanggal_non_absen_keluar.' '.$request->jam_non_absen_keluar.':'.$request->menit_non_absen_keluar.':'.$request->detik_non_absen_keluar;
            $input['pin'] = $request->pin_non_absen_keluar;
            $input['inoutmode'] = $request->inoutmode_non_absen_keluar;
            $input['status'] = $request->status_non_absen_keluar;
            if (!empty($request->penyesuaian_masuk_jam_keluar_jam_non_absen) && !empty($request->penyesuaian_masuk_jam_keluar_menit_non_absen)) {
                $penyesuaian_jam_masuk_jam = $request->penyesuaian_masuk_jam_keluar_jam_non_absen.':'.$request->penyesuaian_masuk_jam_keluar_menit_non_absen;
            }else{
                $penyesuaian_jam_masuk_jam = null;
            }
            
            if (!empty($request->penyesuaian_istirahat_jam_keluar_jam_non_absen) && !empty($request->penyesuaian_istirahat_jam_keluar_menit_non_absen)) {
                $penyesuaian_jam_istirahat_jam = $request->penyesuaian_istirahat_jam_keluar_jam_non_absen.':'.$request->penyesuaian_istirahat_jam_keluar_menit_non_absen;
            }else{
                $penyesuaian_jam_istirahat_jam = null;
            }
    
            if (!empty($request->penyesuaian_pulang_jam_keluar_jam_non_absen) && !empty($request->penyesuaian_pulang_jam_keluar_menit_non_absen)) {
                $penyesuaian_jam_pulang_jam = $request->penyesuaian_pulang_jam_keluar_jam_non_absen.':'.$request->penyesuaian_pulang_jam_keluar_menit_non_absen;
            }else{
                $penyesuaian_jam_pulang_jam = null;
            }
    
            $input['keterangan'] = $request->keterangan_jam_keluar_non_absen.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;
            $presensi_info->update($input);
            if ($presensi_info) {
                $message_title="Berhasil !";
                $message_content="Presensi Pulang Berhasil Diupdate";
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

    // public function input_modal_edit_nofinger_jam_masuk_absensi($att_rec)
    // {
    //     $presensi_info = PresensiInfo::where('att_rec',$att_rec)->first();
    //     if (empty($presensi_info)) {
    //         return response()->json([
    //             'success' => false,
    //             'message_title' => 'Presensi Tidak Ditemukan'
    //         ]);
    //     }

    //     $explode_keterangan = explode('@',$presensi_info->keterangan);
    //     if (empty($explode_keterangan[1]) && empty($explode_keterangan[2]) && empty($explode_keterangan[3])) {
    //         $penyesuaian_jam_masuk_jam = null;
    //         $penyesuaian_jam_masuk_menit = null;
    //         $penyesuaian_istirahat_jam_masuk = null;
    //         $penyesuaian_istirahat_jam_menit = null;
    //         $penyesuaian_pulang_jam_masuk = null;
    //         $penyesuaian_pulang_jam_menit = null;
    //     }else{
    //         $penyesuaian_jam_masuk_jam = Carbon::create($explode_keterangan[1])->format('H');
    //         $penyesuaian_jam_masuk_menit = Carbon::create($explode_keterangan[1])->format('i');
    //         $penyesuaian_istirahat_jam_masuk = Carbon::create($explode_keterangan[2])->format('H');
    //         $penyesuaian_istirahat_jam_menit = Carbon::create($explode_keterangan[2])->format('i');
    //         $penyesuaian_pulang_jam_masuk = Carbon::create($explode_keterangan[3])->format('H');
    //         $penyesuaian_pulang_jam_menit = Carbon::create($explode_keterangan[3])->format('i');
    //     }
        
        
    //     $biodata_karyawan = BiodataKaryawan::where('pin',$presensi_info->pin)->first();
    //     return response()->json([
    //         'success' => true,
    //         // 'message_title' => 'Data Tidak Ditemukan'
    //         'att_rec' => $presensi_info->att_rec,
    //         'karyawan' => $biodata_karyawan,
    //         'date' => Carbon::create($presensi_info->scan_date)->format('Y-m-d'),
    //         'time' => Carbon::create($presensi_info->scan_date)->format('H:i:s'),
    //         'status' => $presensi_info->status,
    //         'penyesuaian_jam_masuk_jam' => $penyesuaian_jam_masuk_jam,
    //         'penyesuaian_jam_masuk_menit' => $penyesuaian_jam_masuk_menit,
    //         'penyesuaian_istirahat_jam_masuk_jam' => $penyesuaian_istirahat_jam_masuk,
    //         'penyesuaian_istirahat_jam_masuk_menit' => $penyesuaian_istirahat_jam_menit,
    //         'penyesuaian_pulang_jam_masuk_jam' => $penyesuaian_pulang_jam_masuk,
    //         'penyesuaian_pulang_jam_menit_menit' => $penyesuaian_pulang_jam_menit,
    //         'keterangan' => $explode_keterangan[0]
    //     ]);
    // }

    // public function input_modal_edit_nofinger_jam_masuk_update(Request $request)
    // {
    //     $rules = [
    //         'edit_jam_masuk_status_non_absen_masuk' => 'required',
    //     ];

    //     $messages = [
    //         'edit_jam_masuk_status_non_absen_masuk.required'  => 'Status Presensi wajib diisi.',
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $messages);
    //     if ($validator->passes()) {
            
    //         $presensi_info = PresensiInfo::where('att_rec',$request->edit_att_rec_non_absen)->first();
    //         if (!empty($request->edit_penyesuaian_masuk_jam_masuk_jam_non_absen) && !empty($request->edit_penyesuaian_masuk_jam_masuk_menit_non_absen)) {
    //             $penyesuaian_jam_masuk_jam = $request->edit_penyesuaian_masuk_jam_masuk_jam_non_absen.':'.$request->edit_penyesuaian_masuk_jam_masuk_menit_non_absen;
    //         }else{
    //             $penyesuaian_jam_masuk_jam = null;
    //         }
            
    //         if (!empty($request->edit_penyesuaian_istirahat_jam_masuk_jam_non_absen) && !empty($request->edit_penyesuaian_istirahat_jam_masuk_menit_non_absen)) {
    //             $penyesuaian_jam_istirahat_jam = $request->edit_penyesuaian_istirahat_jam_masuk_jam_non_absen.':'.$request->edit_penyesuaian_istirahat_jam_masuk_menit_non_absen;
    //         }else{
    //             $penyesuaian_jam_istirahat_jam = null;
    //         }
    
    //         if (!empty($request->edit_penyesuaian_pulang_jam_masuk_jam_non_absen) && !empty($request->edit_penyesuaian_pulang_jam_masuk_menit_non_absen)) {
    //             $penyesuaian_jam_pulang_jam = $request->edit_penyesuaian_pulang_jam_masuk_jam_non_absen.':'.$request->edit_penyesuaian_pulang_jam_masuk_menit_non_absen;
    //         }else{
    //             $penyesuaian_jam_pulang_jam = null;
    //         }

    //         $input['status'] = $request->edit_jam_masuk_status_non_absen_masuk;
    //         $input['keterangan'] = $request->edit_keterangan_jam_masuk_non_absen.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;
    //         // dd($input['keterangan']);
    //         $presensi_info->update($input);
    //         if ($presensi_info) {
    //             $message_title="Berhasil !";
    //             $message_content="Absensi Jam Masuk Berhasil Diupdate";
    //             $message_type="success";
    //             $message_succes = true;
    //         }
    //         $array_message = array(
    //             'success' => $message_succes,
    //             'message_title' => $message_title,
    //             'message_content' => $message_content,
    //             'message_type' => $message_type,
    //         );
    //         return response()->json($array_message);
    //     }
    //     return response()->json(
    //         [
    //             'success' => false,
    //             'error' => $validator->errors()->all()
    //         ]
    //     );
    // }

    public function detail_jam_masuk($scan_date,$pin,$inoutmode){
        $presensi_info = $this->presensi_info->where('scan_date','LIKE','%'.$scan_date.'%')
                                            ->where('pin',$pin)
                                            ->where('inoutmode',$inoutmode)
                                            // ->orderBy('scan_date','asc')
                                            ->first();
        if(empty($presensi_info)){
            $fin_pro = $this->fin_pro->with('biodata_karyawan')
                            ->where('scan_date','LIKE','%'.$scan_date.'%')
                            ->where('pin',$pin)
                            ->where('inoutmode',$inoutmode)
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
                'inoutmode' => $presensi_info->inoutmode,
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
            $presensi_info = $this->presensi_info->where('scan_date','LIKE','%'.$request->detail_masuk_tanggal_masuk.'%')
                                        ->where('pin',$request->detail_masuk_pin)
                                        ->first();
            if (empty($presensi_info)) {
                $norut = $this->presensi_info->max('att_rec');
                $input['att_id'] = Carbon::now()->format('Y').$norut+1;
                $input['scan_date'] = $request->detail_masuk_tanggal_masuk;
                $input['pin'] = $request->detail_masuk_pin;
                $input['inoutmode'] = $request->detail_masuk_inoutmode;
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
        
                if (!empty($request->detail_masuk_penyesuaian_pulang_jam_masuk_jam) && !empty($request->detail_masuk_penyesuaian_pulang_jam_masuk_menit)) {
                    $penyesuaian_jam_pulang_jam = $request->detail_masuk_penyesuaian_pulang_jam_masuk_jam.':'.$request->detail_masuk_penyesuaian_pulang_jam_masuk_menit;
                }else{
                    $penyesuaian_jam_pulang_jam = null;
                }
        
                $input['keterangan'] = $request->detail_masuk_keterangan_jam_masuk.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;
    
                $save_presensi_info = $this->presensi_info->create($input);
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
            $input['inoutmode'] = $request->detail_masuk_inoutmode;

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

    public function detail_jam_keluar($scan_date,$pin,$inoutmode){
        // $presensi_info = PresensiInfo::where('scan_date','LIKE','%'.$scan_date.'%')
        //                                 ->where('pin',$pin)
        //                                 ->orderBy('scan_date','desc')
        //                                 ->first();
        // $fin_pro = FinPro::with('biodata_karyawan')
        //                 ->where('scan_date','LIKE','%'.$scan_date.'%')
        //                 ->where('pin',$pin)
        //                 ->where('inoutmode',2)
        //                 ->first();

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

        $presensi_info = $this->presensi_info->where('scan_date','LIKE','%'.$scan_date.'%')
                                        ->where('pin',$pin)
                                        ->where('inoutmode',$inoutmode)
                                        // ->orderBy('scan_date','asc')
                                        ->first();
        if(empty($presensi_info)){
            $fin_pro = $this->fin_pro->with('biodata_karyawan')
                            ->where('scan_date','LIKE','%'.$scan_date.'%')
                            ->where('pin',$pin)
                            ->where('inoutmode',$inoutmode)
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
                'inoutmode' => $presensi_info->inoutmode,
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

    public function detail_jam_keluar_simpan(Request $request){
        $rules = [
            'detail_keluar_jam_keluar_status' => 'required',
        ];

        $messages = [
            'detail_keluar_jam_keluar_status.required'  => 'Status Presensi wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $presensi_info = $this->presensi_info->where('scan_date','LIKE','%'.$request->detail_masuk_tanggal_masuk.'%')
                                        ->where('pin',$request->detail_masuk_pin)
                                        ->first();
            if (empty($presensi_info)) {
                $norut = $this->presensi_info->max('att_rec');
                $input['att_id'] = Carbon::now()->format('Y').$norut+1;
                $input['scan_date'] = $request->detail_keluar_tanggal_keluar;
                $input['pin'] = $request->detail_keluar_pin;
                $input['inoutmode'] = $request->detail_keluar_inoutmode;
                $input['status'] = $request->detail_keluar_jam_keluar_status;
                if (!empty($request->detail_keluar_penyesuaian_keluar_jam_masuk_jam) && !empty($request->detail_keluar_penyesuaian_masuk_jam_keluar_menit)) {
                    $penyesuaian_jam_masuk_jam_keluar = $request->detail_keluar_penyesuaian_masuk_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_masuk_jam_keluar_menit;
                }else{
                    $penyesuaian_jam_masuk_jam_keluar = null;
                }
                
                if (!empty($request->detail_keluar_penyesuaian_istirahat_jam_keluar_jam) && !empty($request->detail_keluar_penyesuaian_istirahat_jam_keluar_menit)) {
                    $penyesuaian_jam_istirahat_jam_keluar = $request->detail_keluar_penyesuaian_istirahat_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_istirahat_jam_keluar_menit;
                }else{
                    $penyesuaian_jam_istirahat_jam_keluar = null;
                }
        
                if (!empty($request->detail_keluar_penyesuaian_pulang_jam_keluar_jam) && !empty($request->detail_keluar_penyesuaian_pulang_jam_keluar_jam)) {
                    $penyesuaian_jam_pulang_jam_keluar = $request->detail_keluar_penyesuaian_pulang_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_pulang_jam_keluar_jam;
                }else{
                    $penyesuaian_jam_pulang_jam_keluar = null;
                }

                $input['keterangan'] = $request->detail_keluar_keterangan_jam_keluar.'@'.$penyesuaian_jam_masuk_jam_keluar.'@'.$penyesuaian_jam_istirahat_jam_keluar.'@'.$penyesuaian_jam_pulang_jam_keluar;
                $save_presensi_info = $this->presensi_info->create($input);
                if ($save_presensi_info) {
                    $message_title="Berhasil !";
                    $message_content="Presensi Pulang Berhasil Dibuat";
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

            $input['scan_date'] = $request->detail_keluar_tanggal_keluar;
            $input['pin'] = $request->detail_keluar_pin;
            $input['inoutmode'] = $request->detail_keluar_inoutmode;
            $input['status'] = $request->detail_keluar_jam_keluar_status;
            if (!empty($request->detail_keluar_penyesuaian_keluar_jam_masuk_jam) && !empty($request->detail_keluar_penyesuaian_masuk_jam_keluar_menit)) {
                $penyesuaian_jam_keluar_jam = $request->detail_keluar_penyesuaian_masuk_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_masuk_jam_keluar_menit;
            }else{
                $penyesuaian_jam_keluar_jam = null;
            }
            
            if (!empty($request->detail_keluar_penyesuaian_istirahat_jam_keluar_jam) && !empty($request->detail_keluar_penyesuaian_istirahat_jam_keluar_menit)) {
                $penyesuaian_jam_istirahat_jam = $request->detail_keluar_penyesuaian_istirahat_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_istirahat_jam_keluar_menit;
            }else{
                $penyesuaian_jam_istirahat_jam = null;
            }
    
            if (!empty($request->detail_keluar_penyesuaian_pulang_jam_keluar_jam) && !empty($request->detail_keluar_penyesuaian_pulang_jam_keluar_jam)) {
                $penyesuaian_jam_pulang_jam = $request->detail_keluar_penyesuaian_pulang_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_pulang_jam_keluar_jam;
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
            // $fin_pro = FinPro::where('scan_date','LIKE','%'.$request->detail_keluar_tanggal_keluar.'%')
            //                 ->where('pin',$request->detail_keluar_pin)
            //                 ->where('inoutmode',2)
            //                 ->first();
            // if (empty($fin_pro)) {
            //     $norut = PresensiInfo::max('att_rec');
            //     $input['att_id'] = Carbon::now()->format('Y').$norut+1;
            //     $input['scan_date'] = $request->detail_keluar_tanggal_keluar;
            //     $input['pin'] = $request->detail_keluar_pin;
            //     $input['status'] = $request->detail_keluar_jam_keluar_status;
            //     if (!empty($request->detail_keluar_penyesuaian_keluar_jam_masuk_jam) && !empty($request->detail_keluar_penyesuaian_masuk_jam_keluar_menit)) {
            //         $penyesuaian_jam_keluar_jam = $request->detail_keluar_penyesuaian_masuk_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_masuk_jam_keluar_menit;
            //     }else{
            //         $penyesuaian_jam_keluar_jam = null;
            //     }
                
            //     if (!empty($request->detail_keluar_penyesuaian_istirahat_jam_keluar_jam) && !empty($request->detail_keluar_penyesuaian_istirahat_jam_keluar_menit)) {
            //         $penyesuaian_jam_istirahat_jam = $request->detail_keluar_penyesuaian_istirahat_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_istirahat_jam_keluar_menit;
            //     }else{
            //         $penyesuaian_jam_istirahat_jam = null;
            //     }
        
            //     if (!empty($request->detail_keluar_penyesuaian_pulang_jam_keluar_jam) && !empty($request->detail_keluar_penyesuaian_pulang_jam_keluar_jam)) {
            //         $penyesuaian_jam_pulang_jam = $request->detail_keluar_penyesuaian_pulang_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_pulang_jam_keluar_jam;
            //     }else{
            //         $penyesuaian_jam_pulang_jam = null;
            //     }

            //     $input['keterangan'] = $request->detail_masuk_keterangan_jam_masuk.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;
            //     $save_presensi_info = PresensiInfo::create($input);
            //     if ($save_presensi_info) {
            //         $message_title="Berhasil !";
            //         $message_content="Presensi Pulang Berhasil Dibuat";
            //         $message_type="success";
            //         $message_succes = true;
            //     }
            //     $array_message = array(
            //         'success' => $message_succes,
            //         'message_title' => $message_title,
            //         'message_content' => $message_content,
            //         'message_type' => $message_type,
            //     );
            //     return response()->json($array_message);
            // }

            // $input['scan_date'] = $request->detail_keluar_tanggal_keluar;
            // $input['pin'] = $request->detail_keluar_pin;
            // $input['status'] = $request->detail_keluar_jam_keluar_status;

            // if (!empty($request->detail_keluar_penyesuaian_keluar_jam_masuk_jam) && !empty($request->detail_keluar_penyesuaian_masuk_jam_keluar_menit)) {
            //     $penyesuaian_jam_keluar_jam = $request->detail_keluar_penyesuaian_masuk_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_masuk_jam_keluar_menit;
            // }else{
            //     $penyesuaian_jam_keluar_jam = null;
            // }
            
            // if (!empty($request->detail_keluar_penyesuaian_istirahat_jam_keluar_jam) && !empty($request->detail_keluar_penyesuaian_istirahat_jam_keluar_menit)) {
            //     $penyesuaian_jam_istirahat_jam = $request->detail_keluar_penyesuaian_istirahat_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_istirahat_jam_keluar_menit;
            // }else{
            //     $penyesuaian_jam_istirahat_jam = null;
            // }
    
            // if (!empty($request->detail_keluar_penyesuaian_pulang_jam_keluar_jam) && !empty($request->detail_keluar_penyesuaian_pulang_jam_keluar_jam)) {
            //     $penyesuaian_jam_pulang_jam = $request->detail_keluar_penyesuaian_pulang_jam_keluar_jam.':'.$request->detail_keluar_penyesuaian_pulang_jam_keluar_jam;
            // }else{
            //     $penyesuaian_jam_pulang_jam = null;
            // }

            // $input['keterangan'] = $request->detail_masuk_keterangan_jam_masuk.'@'.$penyesuaian_jam_masuk_jam.'@'.$penyesuaian_jam_istirahat_jam.'@'.$penyesuaian_jam_pulang_jam;
            // $update_presensi_info = PresensiInfo::where('')
        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

    public function search_name(Request $request)
    {
        // dd($request->all());
        // $data['biodata_karyawans'] = $this->biodata_karyawan->where(function($query) {
        //                                                 return $query->where('nik','!=','1000001')
        //                                                             ->where('nik','!=','1000002')
        //                                                             ->where('nik','!=','1000003');
        //                                             })
        //                                             ->where('nik','LIKE','%'.$request->cari.'%')
        //                                             // ->whereIn('status_karyawan',['A','K'])
        //                                             ->where('id_departemen',$request->departemen)
        //                                             ->where('nama','LIKE','%'.$request->cari.'%')
        //                                             ->orderBy('id_departemen','asc')
        //                                             ->where('status_karyawan','!=','R')
        //                                             // ->orderBy('satuan_kerja','asc')
        //                                             ->paginate(20)->withQueryString();
        $data['biodata_karyawans'] = $this->biodata_karyawan->whereNotIn('nik',array('1000001','1000002','1000003'))
                                                            ->where(function($query) use($request){
                                                                if ($request->cari) {
                                                                    $query->where('nik','LIKE','%'.$request->cari.'%')
                                                                        ->orwhere('nama','LIKE','%'.$request->cari.'%')
                                                                        ->where('id_departemen',$request->departemen)
                                                                        ->where('status_karyawan','!=','R')
                                                                        ;
                                                                }else{
                                                                    $query->where('id_departemen',$request->departemen)
                                                                        ->where('status_karyawan','!=','R')
                                                                        ;
                                                                }
                                                            })
                                                            ->orderBy('nama','asc')
                                                            ->paginate(20)->withQueryString();
        // dd($data);
        $data['status_absensis'] = DB::connection('absensi')->table('att_status')->get();
        // $data['total_absen_kemarin'] = FinPro::where('scan_date','LIKE','%'.Carbon::yesterday()->format('Y-m-d').'%')->where('inoutmode',1)->count();
        // $data['total_absen_hari_ini'] = FinPro::where('scan_date','LIKE','%'.Carbon::today()->format('Y-m-d').'%')->where('inoutmode',1)->count();
        // // dd($data);
        // if ($data['total_absen_kemarin'] == $data['total_absen_hari_ini']) {
        //     $data['persentase'] = '<small class="font-13">(0%)</small>';
        // }elseif($data['total_absen_kemarin'] >= $data['total_absen_hari_ini']){
        //     $hitung = ($data['total_absen_kemarin']/$data['total_absen_hari_ini'])*100;
        //     $data['persentase'] = '<small class="text-success font-13">(+'.$hitung.'%)</small>';
        // }elseif($data['total_absen_kemarin'] <= $data['total_absen_hari_ini']){
        //     $hitung = ($data['total_absen_kemarin']/$data['total_absen_hari_ini'])*100;
        //     $data['persentase'] = '<small class="text-danger font-13">(-'.$hitung.'%)</small>';
        // }
        $start_year_now = Carbon::now()->startOfYear()->format('Y-m');
        $end_year_now = Carbon::now()->endOfYear()->format('Y-m');
        for ($i=$start_year_now; $i <= $end_year_now; $i++) { 
            $data['periode'][] = Carbon::create($i)->isoFormat('MMMM YYYY');
            $total_absen_masuk = $this->fin_pro->where('scan_date','LIKE','%'.$i.'%')->where('inoutmode',1)->count();
            // dd($total_absen_masuk);
            $data['hasil'][] = $total_absen_masuk;
        }
        $data['departemens'] = $this->itic_departemen->all();
        // dd($data);
        return view('absensi.home.search',$data);
    }

    public function absensi()
    {
        $start_year_now = Carbon::now()->startOfYear()->format('Y-m');
        $end_year_now = Carbon::now()->endOfYear()->format('Y-m');
        for ($i=$start_year_now; $i <= $end_year_now; $i++) { 
            $data[] = [
                'name' => $i,
                'y' => 5,
                'drilldown' => $i
            ];
        }
        return response()->json($data);
        // return CarbonPeriod::between($start_year_now,$end_year_now);
        // return Carbon::now()->startOfYear()->format('Y-m-d').' - '.Carbon::now()->endOfYear()->format('Y-m-d');
        // $fin_pro = FinPro::where('scan_date','LIKE','%'.Carbon::now()->format('Y-m-d').'%')->where('inoutmode',1)->count();
    }

    public function fin_tes()
    {
        return FinPro::all();
    }
}
