<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Kpi;
use App\Models\KpiDetail;
use App\Models\KpiDepartemen;
use App\Models\KpiBobot;
use App\Models\KpiTeam;
use App\Models\KpiIndikator;
use App\Models\KpiCulture;
use App\Models\KpiCultureVerifikasi;
use App\Models\KpiDetailCulture;
use App\Models\KpiTotalNilai;
use App\Models\DepartemenUser;

use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use Validator;
use DataTables;

class KPIController extends Controller
{

    function __construct(
        Kpi $kpi,
        KpiDetail $kpi_detail,
        KpiDepartemen $kpi_departemen,
        KpiIndikator $kpi_indikator,
        KpiBobot $kpi_bobot,
        KpiTeam $kpi_team,
        KpiCulture $kpi_culture,
        KpiCultureVerifikasi $kpi_culture_verifikasi,
        KpiDetailCulture $kpi_detail_culture,
        KpiTotalNilai $kpi_total_nilai,
        DepartemenUser $departemen_user
    ){
        $this->kpi = $kpi;
        $this->kpi_detail = $kpi_detail;
        $this->kpi_departemen = $kpi_departemen;
        $this->kpi_indikator = $kpi_indikator;
        $this->kpi_bobot = $kpi_bobot;
        $this->kpi_team = $kpi_team;
        $this->kpi_culture = $kpi_culture;
        $this->kpi_culture_verifikasi = $kpi_culture_verifikasi;
        $this->kpi_detail_culture = $kpi_detail_culture;
        $this->kpi_total_nilai = $kpi_total_nilai;
        $this->departemen_user = $departemen_user;
        // Nik Direktur
        $this->mengetahui = '1910125';
        $this->date = '2024-05-15';
    }

    public function index()
    {
        $data['date'] = Carbon::now()->format('d-m-Y');
        // $data['date'] = Carbon::create($this->date)->format('d-m-Y');
        $data['departemens'] = $this->kpi_departemen
                                    // ->whereHas('kpi_team', function ($query){
                                    //     $query->where('status','y');
                                    // })
                                    ->get();
        return view('kpi.index',$data);
    }

    public function kpi_indikator(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->nik == '0000000') {
                $data = $this->kpi_team
                            ->where('status','y')
                            ->get();
            }else{
                $departemen_user = $this->departemen_user->where('nik',auth()->user()->nik)->first();
                $data_kpi_team = $this->kpi_team->where('departemen_user_id',$departemen_user->id)->first();
                $data = $this->kpi_team
                            ->where('kpi_departemen_id',$data_kpi_team->kpi_departemen_id)
                            ->get();
            }
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('departemen_user_id', function($row){
                                return $row->departemen_user->team;
                            })
                            ->addColumn('kpi_departemen_id', function($row){
                                return $row->kpi_departemen->departemen;
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<a href='.route('kpi_indikator_buat',['departemen_user_id' => $row->departemen_user_id]).' class="btn btn-primary btn-icon">
                                            <i class="fa fa-plus"></i> Buat Indikator
                                        </a>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }
        return view('kpi.kpi_indikator');
    }

    public function kpi_indikator_buat($departemen_user_id)
    {
        $data['kpi_team'] = $this->kpi_team->where('departemen_user_id',$departemen_user_id)->first();
        $data['kpi_indikators'] = $this->kpi_indikator->where('kpi_team_id',$data['kpi_team']['id'])->get();
        return view('kpi.buat_indikator',$data);
    }

    public function kpi_indikator_simpan(Request $request, $departemen_user_id)
    {
        $kpi_team = $this->kpi_team->where('departemen_user_id',$departemen_user_id)->first();
        $kpi_indikator = $this->kpi_indikator->create([
            'kpi_team_id' => $kpi_team->id,
            'indikator' => $request->indikator,
            'bobot' => $request->bobot
        ]);
        if ($kpi_indikator) {
            return redirect()->route('kpi_indikator_buat',$departemen_user_id);
        }
        return redirect()->back();
    }

    public function kpi_indikator_edit($departemen_user_id,$id)
    {
        $data['kpi_indikator'] = $this->kpi_indikator->find($id);
        if(empty($data['kpi_indikator'])){
            return redirect()->back();
        }
        $data['kpi_team'] = $this->kpi_team->where('departemen_user_id',$departemen_user_id)->first();
        return view('kpi.edit_indikator',$data);
    }

    public function kpi_indikator_update(Request $request, $departemen_user_id, $id)
    {
        $kpi_indikator = $this->kpi_indikator->find($id);
        if(empty($kpi_indikator)){
            return redirect()->back();
        }
        $kpi_indikator->update([
            'indikator' => $request->indikator,
            'bobot' => $request->bobot
        ]);
        if ($kpi_indikator) {
            return redirect()->route('kpi_indikator_buat',$departemen_user_id);
        }
        return redirect()->back();
    }

    public function kpi_indikator_delete($departemen_user_id,$id)
    {
        $kpi_indikator = $this->kpi_indikator->find($id);
        if(empty($kpi_indikator)){
            return redirect()->back();
        }
        $kpi_indikator->delete();
        return redirect()->route('kpi_indikator_buat',$departemen_user_id);
    }

    public function kpi_departemen(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->nik == '0000000') {
                $data = $this->kpi_departemen->all();
            }
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<button onclick="buat_team('.$row->id.')" class="btn btn-success btn-icon">
                                            <i class="fa fa-plus"></i> Input Team
                                        </button>';
                                $btn.= '<button onclick="detail_team('.$row->id.')" class="btn btn-info btn-icon">
                                            <i class="fa fa-user"></i> Detail Team
                                        </button>';
                                $btn.= '<button onclick="edit_team('.$row->id.')" class="btn btn-warning btn-icon">
                                            <i class="fa fa-edit"></i> Edit Team
                                        </button>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }
        return view('kpi.departemen.kpi_departemen');
    }

    public function kpi_departemen_detail($id)
    {
        $departemen_user = $this->departemen_user->where('id','!=',1)
                                                ->where('id','!=',2)
                                                ->where('status','Y')
                                                ->get();
        $kpi_departemen = $this->kpi_departemen->find($id);
        return response()->json([
            'departemen_user' => $departemen_user,
            'kpi' => $kpi_departemen,
        ]);
        // return $id;
    }

    public function kpi_detail_team($kpi_departemen_id)
    {
        $kpi_teams = $this->kpi_team->with('departemen_user')
                                    ->where('kpi_departemen_id',$kpi_departemen_id)
                                    ->where('status','y')
                                    ->get();
        if ($kpi_teams->isEmpty()) {
            return [
                'success' => false,
                'message_content' => 'Team Tidak Ditemukan'
            ];
        }
        foreach ($kpi_teams as $key => $kpi_team) {
            // dd($kpi_team->departemen_user->user->id);
            if (empty($kpi_team->departemen_user->user)) {
                $kpi_culture_verifikasi = null;
            }else{
                $kpi_culture_verifikasi = $this->kpi_culture_verifikasi->where('user_id',$kpi_team->departemen_user->user->id)->first();
            }
            $data[] = [
                'id' => $kpi_team->id,
                'team' => $kpi_team->departemen_user->team,
                'departemen_user_id' => $kpi_team->departemen_user_id,
                'kpi_departemen_id' => $kpi_team->kpi_departemen_id,
                'jabatan' => $kpi_team->jabatan,
                'is_verifikasi' => $kpi_team->is_verifikasi,
                'is_verifikasi_culture' => !$kpi_culture_verifikasi ? null : $kpi_culture_verifikasi->status,
                'status' => $kpi_team->status,
                'created_at' => $kpi_team->created_at,
                'updated_at' => $kpi_team->updated_at,
                'deleted_at' => $kpi_team->deleted_at,
            ];
        }
        return [
            'success' => true,
            'data' => $data
        ];
    }

    public function kpi_detail_team_update(Request $request)
    {
        $kpi_teams = $this->kpi_team->where('kpi_departemen_id',$request->edit_kpi_departemen_id)->get();
        foreach ($kpi_teams as $key => $kpi_team) {
            $kpi_team->update([
                'status' => $request['status_active'.$key]
            ]);
        }
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil!',
            'message_content' => 'Status Karyawan Berhasil diupdate'
        ]);
        // return $kpi_teams;
    }

    public function kpi_departemen_detail_simpan(Request $request)
    {
        $kpi_teams = $this->kpi_team->where('kpi_departemen_id',$request->kpi_departemen_id)->get();
        foreach ($kpi_teams as $key => $kpi_team) {
            $departemen_user = $this->departemen_user->find($kpi_team->departemen_user_id);
            $data[] = [
                'id' => $kpi_team->id,
                'departemen_user_id' => $kpi_team->departemen_user_id,
            ];

            $kpi_culture_verifikasi = $this->kpi_culture_verifikasi->where('user_id',$departemen_user->user->id)->first();
            if (empty($kpi_culture_verifikasi)) {
                $this->kpi_culture_verifikasi->create([
                    'user_id' => $departemen_user->user->id,
                    'status' => $request['edit_culture_verifikasi_status_'.$key]
                ]);
            }else{
                $kpi_culture_verifikasi->update([
                    'status' => $request['edit_culture_verifikasi_status_'.$key]
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Data Berhasil Disimpan'
        ]);
        // return $data;
        // $kpi_team = $this->kpi_team->create([
        //     'departemen_user_id' => $request->departemen_user_id,
        //     'kpi_departemen_id' => $request->kpi_departemen_id,
        //     'jabatan' => 'Staff'
        // ]);
        // return response()->json([
        //     'success' => true,
        //     'message_title' => 'Berhasil',
        //     'message_content' => 'Data Berhasil Disimpan'
        // ]);
        // return response()->json([
        //     'status' => 'ok'
        // ]);
    }
    
    public function buat_kpi($departemen_id,$date)
    {
        // if ($date != Carbon::now()->addMonth()->format('d-m-Y')) {
        //     return redirect()->back();
        // }
        if ($date != Carbon::now()->format('d-m-Y')) {
            return redirect()->back();
        }
        // if ($date != Carbon::create($this->date)->format('d-m-Y')) {
        //     return redirect()->back();
        // }
        $data['date'] = $date;
        $data['departemen_id'] = $departemen_id;
        $data['kpi_bobots'] = $this->kpi_bobot->all();
        $date_live = Carbon::today()->format('d-m-Y');
        $data['periode'] = Carbon::create($date)->subMonth();

        $data['kpi_teams'] = $this->kpi_team->where('kpi_departemen_id',$departemen_id)
                                            ->where('status','y')
                                            // ->whereMonth('periode',$data['periode']->format('m'))
                                            // ->whereYear('periode',$data['periode']->format('Y'))
                                            ->get();
        
        $data['kpi_cultures'] = $this->kpi_culture->get();
        
        return view('kpi.input_date_kpi',$data);
    }

    public function buat_kpi_team($departemen_id,$date,$team_id)
    {
        if ($date != Carbon::now()->format('d-m-Y')) {
            return redirect()->back();
        }
        $data['date'] = $date;
        $data['departemen_id'] = $departemen_id;
        $data['kpi_bobots'] = $this->kpi_bobot->all();
        $data['periode'] = Carbon::create($date)->subMonth();
        $data['kpi_teams'] = $this->kpi_team->where('id',$team_id)
                                            ->where('kpi_departemen_id',$departemen_id)
                                            ->where('status','y')
                                            ->get();
        $data['kpi_cultures'] = $this->kpi_culture->get();
        return view('kpi.input_date_kpi',$data);
    }

    public function input_date_kpi_simpan(Request $request,$departemen_id,$date)
    {
        $no_id = 0;
        foreach ($request->kpi_team_id as $key => $value) {
            $kpis = $this->kpi->where('kpi_team_id',$value)->where('periode',Carbon::create($date)->subMonth()->format('Y-m-d'))->first();
            $kpi = $this->kpi->create([
                'kpi_team_id' => $value,
                'periode' => $request['periode'][$key],
                'mengetahui' => $request['mengetahui'][$key],
                'penilai' => $request['penilai'][$key],
                'yang_dinilai' => $request['yang_dinilai'][$key],
            ]);

            foreach ($request['detail_'.$key] as $key_1 => $value1) {

                if ($request['pencapaian_'.$key][$key_1] > 85) {
                    $nilai = 'A';
                }elseif($request['pencapaian_'.$key][$key_1] >= 76){
                    $nilai = 'B';
                }elseif($request['pencapaian_'.$key][$key_1] >= 66){
                    $nilai = 'C';
                }elseif($request['pencapaian_'.$key][$key_1] >= 50){
                    $nilai = 'D';
                }else{
                    $nilai = 'E';
                }

                if ($nilai == 'A') {
                    $skor = ($request['bobot_'.$key][$key_1] * 4)/100;
                }elseif($nilai == 'B'){
                    $skor = ($request['bobot_'.$key][$key_1] * 3)/100;
                }elseif($nilai == 'C'){
                    $skor = ($request['bobot_'.$key][$key_1] * 2)/100;
                }elseif($nilai == 'D'){
                    $skor = ($request['bobot_'.$key][$key_1] * 1)/100;
                }else{
                    $skor = 0;
                }
                
                $data['results_2'][] = [
                    'kpi_id' => $key+1,
                    'indikator' => $request['indikator_'.$key][$key_1],
                    'target_nilai' => $request['target_nilai_'.$key][$key_1],
                    'target_keterangan' => $request['target_keterangan_'.$key][$key_1],
                    'realisasi_nilai' => $request['realisasi_nilai_'.$key][$key_1],
                    'realisasi_keterangan' => $request['realisasi_keterangan_'.$key][$key_1],
                    'bobot' => $request['bobot_'.$key][$key_1],
                    'pencapaian' => $request['pencapaian_'.$key][$key_1],
                    'nilai' => $nilai,
                    'skor' => $skor,
                    'keterangan' => $request['keterangan_'.$key][$key_1],
                ];

                $kpi_detail = $this->kpi_detail->create([
                    // 'id' => $norut_kpi_detail++,
                    'kpi_id' => $kpi->id,
                    'indikator' => $request['indikator_'.$key][$key_1],
                    'target_nilai' => $request['target_nilai_'.$key][$key_1],
                    'target_keterangan' => $request['target_keterangan_'.$key][$key_1],
                    'realisasi_nilai' => $request['realisasi_nilai_'.$key][$key_1],
                    'realisasi_keterangan' => $request['realisasi_keterangan_'.$key][$key_1],
                    'bobot' => $request['bobot_'.$key][$key_1],
                    'pencapaian' => number_format($request['pencapaian_'.$key][$key_1],0,',','.').'%',
                    // 'pencapaian' => number_format($total_pencapaian,0,',','.').'%',
                    'nilai' => $nilai,
                    'skor' => $skor,
                    'keterangan' => $request['keterangan_'.$key][$key_1],
                ]);
            }

            foreach ($request['detail_culture_'.$key] as $key_2 => $value2) {
                \DB::table('kpi_detail_culture')->insert([
                    'kpi_id' => $kpi->id,
                    'culture' => $request['kpi_culture_'.$key][$key_2],
                    'indikator' => $request['indikator_kpi_culture_'.$key][$key_2],
                    // 'skala' => $request['skala_kpi_culture_'.$key][$key_1],
                    // 'bobot' => $request['bobot_kpi_culture_'.$key][$key_1],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            foreach ($request['kpi_total_nilai_nama_kpi_'.$key] as $key_3 => $value3) {
                \App\Models\KpiTotalNilai::create([
                    'kpi_id' => $kpi->id,
                    'nama_kpi' => $value3,
                ]);
            }
        }

        return redirect()->route('kpi');

    }

    public function detail_kpi($kpi_team_id,$periode)
    {
        // $data['kpi'] = $this->kpi->find($id);
        // if (empty($data['kpi'])) {
        //     return redirect()->back()->with('error','Data Tidak Ditemukan');
        // }
        // $data['departemen_id'] = $departemen_id;
        // $data['kpi_bobots'] = $this->kpi_bobot->all();
        
        // return view('kpi.detail_kpi',$data);

        $data['kpis'] = $this->kpi->where('kpi_team_id',$kpi_team_id)
                                ->where('periode','LIKE','%'.$periode.'%')
                                ->get();
        if ($data['kpis']->isEmpty()) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }

        // $data['departemen_id'] = $departemen_id;
        $data['kpi_bobots'] = $this->kpi_bobot->all();
        return view('kpi.detail_kpi_array',$data);
    }

    public function detail_validasi($id,$departemen_id)
    {
        $data['kpi'] = $this->kpi->find($id);
        if (empty($data['kpi'])) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }
        $data['kpi_details'] = $this->kpi_detail->where('kpi_id',$id)->get();
        $data['kpi_cultures'] = $this->kpi_detail_culture->with('user')->where('kpi_id',$id)->get();
        // dd($data);
        $data['kpi_culture_verifikasi'] = \DB::table('kpi_culture_verifikasi')
                                            ->where('user_id', auth()->user()->id)
                                            ->where('status','y')
                                            ->first();
        $data['kpi_total_nilais'] = $this->kpi_total_nilai->where('kpi_id',$id)->get();

        $data['departemen_id'] = $departemen_id;
        $data['kpi_bobots'] = $this->kpi_bobot->all();
        return view('kpi.validasi',$data);
    }

    public function validasi_simpan(Request $request,$id,$departemen_id)
    {
        // dd($request->all());
        $kpi = $this->kpi->find($id);
        if (empty($kpi)) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }

        if ($request->status_mengetahui != "") {
            if ($request->status_mengetahui == 'y') {
                $status_mengetahui = 'y';
                $status_date_mengetahui_verifikasi = Carbon::now();
                $acc_status_mengetahui = $status_mengetahui.'|'.$status_date_mengetahui_verifikasi;
            }elseif($request->status_mengetahui == 'n'){
                $status_mengetahui = 'n';
                $status_date_mengetahui_verifikasi = Carbon::now();
                $acc_status_mengetahui = $status_mengetahui.'|'.$status_date_mengetahui_verifikasi;
            }else{
                $acc_status_mengetahui = null;
            }
        }else{
            if ($kpi->status_mengetahui == null) {
                $status_mengetahui = null;
                $status_date_mengetahui_verifikasi = null;
                $acc_status_mengetahui = null;
            }else{
                $explode_status_mengetahui = explode("|",$kpi->status_mengetahui);
                $status_mengetahui = $explode_status_mengetahui[0];
                $status_date_mengetahui_verifikasi = $explode_status_mengetahui[1];
                $acc_status_mengetahui = $status_mengetahui.'|'.$status_date_mengetahui_verifikasi;
            }
        }

        if ($request->status_penilai) {
            if ($request->status_penilai == 'y') {
                $status_penilai = 'y';
                $status_date_penilai_verifikasi = Carbon::now();
                $acc_status_penilai = $status_penilai.'|'.$status_date_penilai_verifikasi;
            }elseif($request->status_penilai == 'n'){
                $status_penilai = 'n';
                $status_date_penilai_verifikasi = Carbon::now();
                $acc_status_penilai = $status_penilai.'|'.$status_date_penilai_verifikasi;
            }
        }else{
            if ($kpi->status_penilai == null) {
                $status_penilai = null;
                $status_date_penilai_verifikasi = null;
                $acc_status_penilai = null;
            }else{
                $explode_status_penilai = explode("|",$kpi->status_penilai);
                $status_penilai = $explode_status_penilai[0];
                $status_date_penilai_verifikasi = $explode_status_penilai[1];
                $acc_status_penilai = $status_penilai.'|'.$status_date_penilai_verifikasi;
            }
        }

        if (empty($request->remaks)) {
            $remaks = '-';
        }else{
            $remaks = $request->remaks;
        }

        // $data['details'][] = [
        //     'status_mengetahui' => $acc_status_mengetahui,
        //     'status_penilai' => $acc_status_penilai,
        //     'remaks' => $remaks
        // ];

        $kpi->update([
            'nilai' => $request->hasil_akhir,
            'status_nilai' => $request->status_nilai,
            'status_mengetahui' => $acc_status_mengetahui,
            'status_penilai' => $acc_status_penilai,
            // 'status' => $status_mengetahui.'|'.$status_date_mengetahui_verifikasi.'|'.$status_penilai.'|'.$status_date_penilai_verifikasi,
            'remaks' => $remaks
        ]);

        foreach ($request->id_kpi_total_nilai as $key_kpi_total_nilai => $kpi_total_nilai_nama_kpi) {
            if ($key_kpi_total_nilai % 2 == 0) {
                $nilai = $request->total_skor_kpi_performance;
            }else{
                $nilai = $request->total_skor_akhir_kpi_culture;
            }
            $total_nilai_kpi = ($request['kpi_total_nilai_bobot'][$key_kpi_total_nilai]/100)*$nilai;
            $data['kpi_total_nilai'][] = [
                'bobot' => $request['kpi_total_nilai_bobot'][$key_kpi_total_nilai],
                'nilai' => $nilai,
                'total_nilai' => number_format($total_nilai_kpi,0,',','.'),
                'skor_nilai' => number_format($total_nilai_kpi,0,',','.'),
                'keterangan' => $request['kpi_total_nilai_keterangan'][$key_kpi_total_nilai],
            ];
            \App\Models\KpiTotalNilai::where('id',$kpi_total_nilai_nama_kpi)->update([
                'bobot' => $request['kpi_total_nilai_bobot'][$key_kpi_total_nilai],
                'nilai' => $nilai,
                'total_nilai' => number_format($total_nilai_kpi,0,',','.'),
                'skor_nilai' => number_format($total_nilai_kpi,0,',','.'),
                'keterangan' => $request['kpi_total_nilai_keterangan'][$key_kpi_total_nilai],
            ]);
        }

        foreach ($request->kpi_culture_id as $key_culture => $kpi_culture_verifikasi) {
            // \DB::table('kpi_detail_culture')->where('id',$kpi_culture_verifikasi)->update([
            //     'skala' => $request['kpi_culture_skala'][$key_culture],
            //     'bobot' => $request['kpi_culture_bobot'][$key_culture],
            //     'user_id' => auth()->user()->id,
            //     'updated_at' => Carbon::now()
            // ]);

            $kpi_detail_culture = $this->kpi_detail_culture->where('id',$kpi_culture_verifikasi)->first();
            if (!empty($kpi_detail_culture->user_id)) {
                $kpi_detail_culture->update([
                    'skala' => $request['kpi_culture_skala'][$key_culture],
                    'bobot' => $request['kpi_culture_bobot'][$key_culture],
                    'updated_at' => Carbon::now()
                ]);
            }else{
                $kpi_detail_culture->update([
                    'skala' => $request['kpi_culture_skala'][$key_culture],
                    'bobot' => $request['kpi_culture_bobot'][$key_culture],
                    'user_id' => auth()->user()->id,
                    'updated_at' => Carbon::now()
                ]);
            }
            // $kpi_detail_culture = \DB::table('kpi_detail_culture')->where('id',$kpi_culture_verifikasi)->first();
            // if (!empty($kpi_detail_culture->user_id)) {
            //     $kpi_detail_culture->update([
            //         'skala' => $request['kpi_culture_skala'][$key_culture],
            //         'bobot' => $request['kpi_culture_bobot'][$key_culture],
            //         'updated_at' => Carbon::now()
            //     ]);
            // }else{
            //     $kpi_detail_culture->update([
            //         'skala' => $request['kpi_culture_skala'][$key_culture],
            //         'bobot' => $request['kpi_culture_bobot'][$key_culture],
            //         'user_id' => auth()->user()->id,
            //         'updated_at' => Carbon::now()
            //     ]);
            // }
        }

        return redirect()->route('kpi');
        // return redirect()->route('kpi_detail_kpi',['id' => $id, 'departemen_id' => $departemen_id]);

    }

    public function kpi_print($id, $departemen_id, $date)
    {

        $format_date = Carbon::create($date)->subMonth();
        $data['kpis'] = $this->kpi->whereRelation('kpi_team','kpi_departemen_id',$departemen_id)
                                ->where('id',$id)
                                // ->whereYear('periode',$format_date->format('Y'))
                                // ->whereMonth('periode',$format_date->format('m'))
                                ->get();
                                // dd($id);
        $data['kpi_bobots'] = $this->kpi_bobot->all();
        return view('kpi.kpi_print',$data);
    }

    public function kpi_testing()
    {
        $data_kpi = $this->kpi->get()->shuffle();
        foreach ($data_kpi as $key => $kpi) {
            $datakpi[] = $kpi;
        }
        return $datakpi;
    }
}
