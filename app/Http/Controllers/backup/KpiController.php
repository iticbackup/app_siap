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
use App\Models\DepartemenUser;

use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use Validator;
use DataTables;
class KpiController extends Controller
{
    function __construct(
        Kpi $kpi,
        KpiDetail $kpi_detail,
        KpiDepartemen $kpi_departemen,
        KpiIndikator $kpi_indikator,
        KpiBobot $kpi_bobot,
        KpiTeam $kpi_team,
        KpiCulture $kpi_culture,
        DepartemenUser $departemen_user
    ){
        $this->kpi = $kpi;
        $this->kpi_detail = $kpi_detail;
        $this->kpi_departemen = $kpi_departemen;
        $this->kpi_indikator = $kpi_indikator;
        $this->kpi_bobot = $kpi_bobot;
        $this->kpi_team = $kpi_team;
        $this->kpi_culture = $kpi_culture;
        $this->departemen_user = $departemen_user;

        // Nik Direktur
        $this->mengetahui = '1910125';
    }

    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     if (auth()->user()->nik == '0000000') {
        //         $data = $this->kpi->all();
        //     }
        //     return DataTables::of($data)
        //                     ->addIndexColumn()
        //                     ->addColumn('action', function($row){
        //                     })
        //                     ->rawColumns(['action'])
        //                     ->make(true);
        // }
        
        // $data['live_date'] = Carbon::today()->format('Y-m');
        // $data['start_date'] = Carbon::create('2023-01')->format('Y-m');
        // $data['end_date'] = Carbon::create(Carbon::today()->format('Y-m'))->format('Y-m');

        $data['start_date'] = Carbon::now()->startOfYear()->format('Y-m');
        $data['end_date'] = Carbon::now()->endOfYear()->format('Y-m');

        // $data['live_date'] = Carbon::today()->format('Y-m');

        // for ($i=$data['tahun']; $i <= $data['live'] ; $i++) { 
        //     $data['sekarang'][] = $i;
        // }
        // dd($data);
        // $data['live_date'] = Carbon::today();
        // $startDate = Carbon::createFromFormat('Y-m', '2023-01');
        // $endDate = Carbon::createFromFormat('Y-m', Carbon::today()->format('Y-m'));
        // $dateRange = CarbonPeriod::create($startDate, $endDate);

        // dd($dateRange->toArray());
        return view('kpi.index',$data);
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
    }

    public function kpi_detail_team($kpi_departemen_id)
    {
        $kpi_team = $this->kpi_team->with('departemen_user')->where('kpi_departemen_id',$kpi_departemen_id)->get();
        if (empty($kpi_team)) {
            return [
                'success' => false,
                'message_content' => 'Team Tidak Ditemukan'
            ];
        }
        return [
            'success' => true,
            'data' => $kpi_team
        ];
    }

    public function kpi_departemen_detail_simpan(Request $request)
    {
        $kpi_team = $this->kpi_team->create([
            'departemen_user_id' => $request->departemen_user_id,
            'kpi_departemen_id' => $request->kpi_departemen_id,
            'jabatan' => 'Staff'
        ]);
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Data Berhasil Disimpan'
        ]);
    }

    public function kpi_indikator(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->nik == '0000000') {
                $data = $this->kpi_team->all();
            }else{
                $departemen_user = $this->departemen_user->where('nik',auth()->user()->nik)->first();
                $data_kpi_team = $this->kpi_team->where('departemen_user_id',$departemen_user->id)->first();
                $data = $this->kpi_team->where('kpi_departemen_id',$data_kpi_team->kpi_departemen_id)->get();
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
                                $btn.= '<a href='.route('kpi.kpi_indikator_buat',['departemen_user_id' => $row->departemen_user_id]).' class="btn btn-primary btn-icon">
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
            return redirect()->route('kpi.kpi_indikator_buat',$departemen_user_id);
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
            return redirect()->route('kpi.kpi_indikator_buat',$departemen_user_id);
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
        return redirect()->route('kpi.kpi_indikator_buat',$departemen_user_id);
    }

    public function input_detail_kpi_departemen($date)
    {
        $data['date'] = $date;
        // if (auth()->user()->nik != '000000' && auth()->user()->nik != '1910125') {
        //     $kpi_team = $this->kpi_team->whereRelation('departemen_user','nik',auth()->user()->nik)->first();
        //     $data['kpi_departemens'] = $this->kpi_departemen->where('id',$kpi_team->kpi_departemen_id)->get();
        // }else{
        //     $data['kpi_departemens'] = $this->kpi_departemen->all();
        // }
        $data['kpi_departemens'] = $this->kpi_departemen->all();
        return view('kpi.detail_kpi_departemen',$data);
    }

    public function input_date_kpi($date)
    {
        // $check_kpi = $this->kpi->where('periode',$date)->first();
        // dd($check_kpi);
        // if (empty($check_kpi)) {
        //     return redirect()->route('kpi');
        // }
        $data['date'] = $date;
        $data['kpi_bobots'] = $this->kpi_bobot->all();
        $date_live = Carbon::today()->format('d-m-Y');
        $data['periode'] = Carbon::create($date)->subMonth();

        $departemen_user = $this->departemen_user->select('id')->where('nik',auth()->user()->nik)->first();
        $data_kpi_team = $this->kpi_team->select('kpi_departemen_id')->where('departemen_user_id',$departemen_user->id)->first();
        $data['kpi_teams'] = $this->kpi_team->where('kpi_departemen_id',$data_kpi_team->kpi_departemen_id)
                                            // ->whereMonth('periode',$data['periode']->format('m'))
                                            // ->whereYear('periode',$data['periode']->format('Y'))
                                            ->get();
        $data['kpi_cultures'] = $this->kpi_culture->get();
        return view('kpi.input_date_kpi',$data);

    }

    public function buat_kpi()
    {
        $data['from_date'] = Carbon::now()->startOfMonth()->format('Y-m-d');
        $data['due_date'] = Carbon::createFromDate(date('Y'),date('m'),10)->addDays(31)->isoFormat('LL');
        
        // $data['from_date_str'] = strtotime($data['from_date']);
        // $data['due_date_str'] = strtotime($data['due_date']);

        // $data['time'] = ($data['due_date_str']-$data['from_date_str'])*100/60;
        
        // $data['year'] = Carbon::now()->format('Y');
        // dd($data);
        $data['kpi_bobots'] = $this->kpi_bobot->all();
        
        return view('kpi.buat_kpi',$data);
    }

    public function input_date_kpi_simpan(Request $request,$date)
    {
        // dd($request->all());
        $no_id = 0;
        foreach ($request->kpi_team_id as $key => $value) {
            // $date_format = Carbon::create($date)->format('Y-m-d');
            $kpis = $this->kpi->where('kpi_team_id',$value)->where('periode',Carbon::create($date)->subMonth()->format('Y-m-d'))->first();
            // dd($kpi);
            // dd(Carbon::create($date)->subMonth()->format('Y-m-d'));

            // dd($date_format);
            $kpi = $this->kpi->create([
                'kpi_team_id' => $value,
                'periode' => $request['periode'][$key],
                'mengetahui' => $request['mengetahui'][$key],
                'penilai' => $request['penilai'][$key],
                'yang_dinilai' => $request['yang_dinilai'][$key],
            ]);

            foreach ($request['detail_'.$key] as $key_1 => $value1) {
                // $pencapaian = (int)$request['realisasi_nilai_'.$key][$key_1]/(int)$request['target_nilai_'.$key][$key_1];
                // $pencapaian = divnum($request['realisasi_nilai_'.$key][$key_1],$request['target_nilai_'.$key][$key_1])*100;
                // if($pencapaian == 0){
                //     if ($request['realisasi_nilai_'.$key][$key_1] == null && $request['target_nilai_'.$key][$key_1] == null) {
                //         $total_pencapaian = 0;
                //     }elseif($request['realisasi_nilai_'.$key][$key_1] == $request['target_nilai_'.$key][$key_1]){
                //         $total_pencapaian = 100;
                //     }else{
                //         $total_pencapaian = $pencapaian;
                //     }
                // }else{
                //     $total_pencapaian = $pencapaian;
                // }

                // if ($total_pencapaian > 85) {
                //     $nilai = 'A';
                // }elseif($total_pencapaian >= 76){
                //     $nilai = 'B';
                // }elseif($total_pencapaian >= 66){
                //     $nilai = 'C';
                // }elseif($total_pencapaian >= 50){
                //     $nilai = 'D';
                // }else{
                //     $nilai = 'E';
                // }

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
                
                // $pencapaian = ($request['realisasi_nilai_'.$key][$key_1]/$request['target_nilai_'.$key][$key_1])*100;
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

                // $no_kpi_detail = $this->kpi_detail->count();
                // if ($no_kpi_detail == 0) {
                //     $norut_kpi_detail = 1;
                // }else{
                //     $norut_kpi_detail = $no_kpi_detail++;
                // }

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

            // if (empty($kpis)) {

            //     return redirect()->route('kpi.input_date_kpi_detail',['date' => $date, 'id_departemen' => $kpi->kpi_team->kpi_departemen_id]);
            // }else{
            //     return redirect()->back();
            // }
            
            // $kpi = $this->kpi->create([
            //     'kpi_team_id' => $value,
            //     'periode' => $request['periode'][$key],
            //     'mengetahui' => $request['mengetahui'][$key],
            //     'penilai' => $request['penilai'][$key],
            //     'yang_dinilai' => $request['yang_dinilai'][$key],
            // ]);

            // foreach ($request['detail_'.$key] as $key_1 => $value1) {
            //     // $pencapaian = (int)$request['realisasi_nilai_'.$key][$key_1]/(int)$request['target_nilai_'.$key][$key_1];
            //     // $pencapaian = divnum($request['realisasi_nilai_'.$key][$key_1],$request['target_nilai_'.$key][$key_1])*100;
            //     // if($pencapaian == 0){
            //     //     if ($request['realisasi_nilai_'.$key][$key_1] == null && $request['target_nilai_'.$key][$key_1] == null) {
            //     //         $total_pencapaian = 0;
            //     //     }elseif($request['realisasi_nilai_'.$key][$key_1] == $request['target_nilai_'.$key][$key_1]){
            //     //         $total_pencapaian = 100;
            //     //     }else{
            //     //         $total_pencapaian = $pencapaian;
            //     //     }
            //     // }else{
            //     //     $total_pencapaian = $pencapaian;
            //     // }

            //     // if ($total_pencapaian > 85) {
            //     //     $nilai = 'A';
            //     // }elseif($total_pencapaian >= 76){
            //     //     $nilai = 'B';
            //     // }elseif($total_pencapaian >= 66){
            //     //     $nilai = 'C';
            //     // }elseif($total_pencapaian >= 50){
            //     //     $nilai = 'D';
            //     // }else{
            //     //     $nilai = 'E';
            //     // }

            //     if ($request['pencapaian_'.$key][$key_1] > 85) {
            //         $nilai = 'A';
            //     }elseif($request['pencapaian_'.$key][$key_1] >= 76){
            //         $nilai = 'B';
            //     }elseif($request['pencapaian_'.$key][$key_1] >= 66){
            //         $nilai = 'C';
            //     }elseif($request['pencapaian_'.$key][$key_1] >= 50){
            //         $nilai = 'D';
            //     }else{
            //         $nilai = 'E';
            //     }

            //     if ($nilai == 'A') {
            //         $skor = ($request['bobot_'.$key][$key_1] * 4)/100;
            //     }elseif($nilai == 'B'){
            //         $skor = ($request['bobot_'.$key][$key_1] * 3)/100;
            //     }elseif($nilai == 'C'){
            //         $skor = ($request['bobot_'.$key][$key_1] * 2)/100;
            //     }elseif($nilai == 'D'){
            //         $skor = ($request['bobot_'.$key][$key_1] * 1)/100;
            //     }else{
            //         $skor = 0;
            //     }
                
            //     // $pencapaian = ($request['realisasi_nilai_'.$key][$key_1]/$request['target_nilai_'.$key][$key_1])*100;
            //     $data['results_2'][] = [
            //         'kpi_id' => $key+1,
            //         'indikator' => $request['indikator_'.$key][$key_1],
            //         'target_nilai' => $request['target_nilai_'.$key][$key_1],
            //         'target_keterangan' => $request['target_keterangan_'.$key][$key_1],
            //         'realisasi_nilai' => $request['realisasi_nilai_'.$key][$key_1],
            //         'realisasi_keterangan' => $request['realisasi_keterangan_'.$key][$key_1],
            //         'bobot' => $request['bobot_'.$key][$key_1],
            //         'pencapaian' => $request['pencapaian_'.$key][$key_1].'%',
            //         'nilai' => $nilai,
            //         'skor' => $skor,
            //         'keterangan' => $request['keterangan_'.$key][$key_1],
            //     ];

            //     // $no_kpi_detail = $this->kpi_detail->count();
            //     // if ($no_kpi_detail == 0) {
            //     //     $norut_kpi_detail = 1;
            //     // }else{
            //     //     $norut_kpi_detail = $no_kpi_detail++;
            //     // }

            //     $kpi_detail = $this->kpi_detail->create([
            //         // 'id' => $norut_kpi_detail++,
            //         'kpi_id' => $kpi->id,
            //         'indikator' => $request['indikator_'.$key][$key_1],
            //         'target_nilai' => $request['target_nilai_'.$key][$key_1],
            //         'target_keterangan' => $request['target_keterangan_'.$key][$key_1],
            //         'realisasi_nilai' => $request['realisasi_nilai_'.$key][$key_1],
            //         'realisasi_keterangan' => $request['realisasi_keterangan_'.$key][$key_1],
            //         'bobot' => $request['bobot_'.$key][$key_1],
            //         'pencapaian' => number_format($request['pencapaian_'.$key][$key_1],0,',','.').'%',
            //         // 'pencapaian' => number_format($total_pencapaian,0,',','.').'%',
            //         'nilai' => $nilai,
            //         'skor' => $skor,
            //         'keterangan' => $request['keterangan_'.$key][$key_1],
            //     ]);
            // }

            // $data['results'][] = [
            //     'id' => $key+1,
            //     'kpi_team_id' => $value,
            //     'periode' => $request['periode'][$key],
            //     'remaks' => $request['remaks'][$key],
            // ];

        }

        // dd($data);
    }

    public function input_date_kpi_detail($date,$id_departemen)
    {
        $format_date = Carbon::create($date)->subMonth();
        // $data['kpis'] = $this->kpi->whereMonth('created_at',$data['format_date'])
        //                         ->whereYear('created_at',$data['format_date'])
        //                         ->get();
        $data['kpis'] = $this->kpi->whereRelation('kpi_team','kpi_departemen_id',$id_departemen)
                                ->whereYear('periode',$format_date->format('Y'))
                                ->whereMonth('periode',$format_date->format('m'))
                                ->get();
        if ($data['kpis']->isEmpty()) {
            return redirect()->back()->with('error','KPI Indikator departemen belum tersedia, silahkan input terlebih dahulu!');
        }
        $data['kpi_bobots'] = $this->kpi_bobot->all();
        $data['date'] = $date;
        $data['id_departemen'] = $id_departemen;
        // dd($data);
        return view('kpi.detail_kpi',$data);
    }

    public function input_date_kpi_validasi($date,$id_departemen)
    {
        $format_date = Carbon::create($date)->subMonth();
        // $data['kpis'] = $this->kpi->whereMonth('created_at',$data['format_date'])
        //                         ->whereYear('created_at',$data['format_date'])
        //                         ->get();
        $data['kpis'] = $this->kpi->whereRelation('kpi_team','kpi_departemen_id',$id_departemen)
                                ->whereYear('periode',$format_date->format('Y'))
                                ->whereMonth('periode',$format_date->format('m'))
                                ->get();
        if (empty($data['kpis'])) {
            return redirect()->back();
        }
        $data['kpi_bobots'] = $this->kpi_bobot->all();
        $data['date'] = $date;
        $data['id_departemen'] = $id_departemen;
        $data['mengetahui_kpi'] = $this->departemen_user->where('nik',$this->mengetahui)->first();
        // dd($data);
        // dd($data);
        return view('kpi.validasi_kpi',$data);
    }

    public function input_date_kpi_validasi_simpan(Request $request, $date, $id_departemen)
    {
        // dd($request->all());
        $format_date = Carbon::create($date)->subMonth();
        $kpis = $this->kpi->whereRelation('kpi_team','kpi_departemen_id',$id_departemen)
                            ->whereYear('periode',$format_date->format('Y'))
                            ->whereMonth('periode',$format_date->format('m'))
                            ->get();
        // dd($kpis);
        foreach ($kpis as $key => $kpi) {

            if ($request['status_mengetahui_'.$key] != "") {
                if ($request['status_mengetahui_'.$key] == 'y') {
                    $status_mengetahui = 'y';
                    $status_date_mengetahui_verifikasi = Carbon::now();
                    $acc_status_mengetahui = $status_mengetahui.'|'.$status_date_mengetahui_verifikasi;
                }elseif($request['status_mengetahui_'.$key] == 'n'){
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

            if ($request['status_penilai_'.$key]) {
                if ($request['status_penilai_'.$key] == 'y') {
                    $status_penilai = 'y';
                    $status_date_penilai_verifikasi = Carbon::now();
                    $acc_status_penilai = $status_penilai.'|'.$status_date_penilai_verifikasi;
                }elseif($request['status_penilai_'.$key] == 'n'){
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

            if (empty($request['remaks'][$key])) {
                $remaks = null;
            }else{
                $remaks = $request['remaks'][$key];
            }

            $data['details'][] = [
                'status_mengetahui' => $acc_status_mengetahui,
                'status_penilai' => $acc_status_penilai,
                'remaks' => $remaks
            ];
            $kpi->update([
                'status_mengetahui' => $acc_status_mengetahui,
                'status_penilai' => $acc_status_penilai,
                // 'status' => $status_mengetahui.'|'.$status_date_mengetahui_verifikasi.'|'.$status_penilai.'|'.$status_date_penilai_verifikasi,
                'remaks' => $remaks
            ]);
            
            foreach ($request->id_kpi_total_nilai as $key_kpi_total_nilai => $kpi_total_nilai_nama_kpi) {
                if ($key_kpi_total_nilai % 2 == 0) {
                    $nilai = $request['total_skor_kpi_performance'][$key];
                }else{
                    $nilai = $request['total_skor_akhir_kpi_culture'][$key];
                }
                // $total_nilai_kpi = ($request['kpi_total_nilai_bobot'][$key_kpi_total_nilai]/100)*$request['total_skor_akhir_kpi_culture'][$key];
                $total_nilai_kpi = ($request['kpi_total_nilai_bobot'][$key_kpi_total_nilai]/100)*$nilai;
                // $skor_nilai_kpi = $request['total_skor_kpi_performance'][$key]*($request['kpi_total_nilai_bobot'][$key_kpi_total_nilai]/100);
                $data['kpi_total_nilai'][] = [
                    'bobot' => $request['kpi_total_nilai_bobot'][$key_kpi_total_nilai],
                    'nilai' => $nilai,
                    // 'nilai' => $request['total_skor_kpi_performance'][$key],
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
            // dd($data);
        }
        
        foreach ($request->kpi_culture_id as $key_culture => $kpi_culture_verifikasi) {
            \DB::table('kpi_detail_culture')->where('id',$kpi_culture_verifikasi)->update([
                'skala' => $request['kpi_culture_skala'][$key_culture],
                'bobot' => $request['kpi_culture_bobot'][$key_culture],
                'user_id' => auth()->user()->id,
                'updated_at' => Carbon::now()
            ]);
        }
        
        // dd($data);
        return redirect()->route('kpi.input_date_kpi_validasi',['date' => $date, 'id_departemen' => $id_departemen]);
    }

    public function kpi_print($date,$id_departemen)
    {
        $format_date = Carbon::create($date)->subMonth();
        $data['kpis'] = $this->kpi->whereRelation('kpi_team','kpi_departemen_id',$id_departemen)
                                ->whereYear('periode',$format_date->format('Y'))
                                ->whereMonth('periode',$format_date->format('m'))
                                ->get();
        $data['kpi_bobots'] = $this->kpi_bobot->all();
        return view('kpi.kpi_print',$data);
    }

    public function kpi_culture(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->kpi_culture->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                                // $btn = '<div class="btn-group">';
                                // $btn.= '<button onclick="buat_team('.$row->id.')" class="btn btn-success btn-icon">
                                //             <i class="fa fa-plus"></i> Input Team
                                //         </button>';
                                // $btn.= '</div>';
                                // return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }

        return view('kpi.culture.index');
    }

    public function kpi_culture_simpan(Request $request){
        $rules = [
            'culture' => 'required',
            'indikator' => 'required',
        ];

        $messages = [
            'culture.required'  => 'Culture wajib diisi.',
            'indikator.required'  => 'Indikator wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $norut = $this->kpi_culture->max('id');
            if(empty($norut)){
                $id = 1;
            }else{
                $id = $norut+1;
            }
            $input['id'] = $id;
            $input['culture'] = $request->culture;
            $input['indikator'] = $request->indikator;
            $kpi_culture = $this->kpi_culture->create($input);
            if($kpi_culture){
                $message_title="Berhasil !";
                $message_content="Kpi Culture Berhasil Dibuat";
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

    public function kpi_culture_verifikasi_update(Request $request, $kpi_id)
    {
        dd($request->all());
    }
}
