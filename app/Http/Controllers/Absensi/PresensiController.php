<?php

namespace App\Http\Controllers\Absensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BiodataKaryawan;
use App\Models\IticDepartemen;
use App\Models\FinPro;
use \Carbon\Carbon;
use PDF;

class PresensiController extends Controller
{
    public function index()
    {
        $start_month_now = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end_month_now = Carbon::now()->endOfMonth()->format('Y-m-d');
        // dd($end_month_now);
        for ($i=$start_month_now; $i <= $end_month_now; $i++) { 
            $data['weeks'][] = $i;
        }
        $data['biodata_karyawans'] = BiodataKaryawan::where(function($query) {
                                                        return $query->where('nik','!=','1000001')
                                                                    ->where('nik','!=','1000002')
                                                                    ->where('nik','!=','1000003');
                                                    })
                                                    // ->where('pin',1298)
                                                    ->where('status_karyawan','!=','R')
                                                    ->orderBy('satuan_kerja','asc')
                                                    // ->limit(200)
                                                    // ->get();
                                                    ->paginate(20);
        // dd($data);
        return view('absensi.presensi.index',$data);
    }

    public function detail($nik){
        // return $nik;
        $data['biodata_karyawan'] = BiodataKaryawan::where('nik',$nik)->first();
        if (empty($data['biodata_karyawan'])) {
            return redirect()->back();
        }
        $start_month_now = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end_month_now = Carbon::now()->endOfMonth()->format('Y-m-d');
        // dd($end_month_now);
        for ($i=$start_month_now; $i <= $end_month_now; $i++) { 
            $data['weeks'][] = $i;
        }

        $cek_status_kerja = IticDepartemen::where('id_departemen', $data['biodata_karyawan']->satuan_kerja)->first();
        if (empty($cek_status_kerja)) {
            $data['satuan_kerja'] = '-';
        } else {
            if ($cek_status_kerja->nama_departemen >= 1) {
                $data['satuan_kerja'] = $cek_status_kerja->nama_unit;
            } else {
                $data['satuan_kerja'] = $cek_status_kerja->nama_departemen;
            }
        }
        $data['kehadiran'] = FinPro::where('pin',$data['biodata_karyawan']->pin)
                                    ->where('scan_date','LIKE','%'.Carbon::now()->format('Y-m').'%')
                                    ->whereTime('scan_date','<=','11:59')
                                    ->count();
        return view('absensi.presensi.detail',$data);
    }

    public function search_detail(Request $request, $nik)
    {
        $data['biodata_karyawan'] = BiodataKaryawan::where('nik',$nik)->first();
        if (empty($data['biodata_karyawan'])) {
            return redirect()->back();
        }
        $start_month_now = Carbon::create($request->tahun,$request->bulan)->startOfMonth()->format('Y-m-d');
        $end_month_now = Carbon::create($request->tahun,$request->bulan)->endOfMonth()->format('Y-m-d');
        // dd($end_month_now);
        for ($i=$start_month_now; $i <= $end_month_now; $i++) { 
            $data['weeks'][] = $i;
        }

        $cek_status_kerja = IticDepartemen::where('id_departemen', $data['biodata_karyawan']->satuan_kerja)->first();
        if (empty($cek_status_kerja)) {
            $data['satuan_kerja'] = '-';
        } else {
            if ($cek_status_kerja->nama_departemen >= 1) {
                $data['satuan_kerja'] = $cek_status_kerja->nama_unit;
            } else {
                $data['satuan_kerja'] = $cek_status_kerja->nama_departemen;
            }
        }

        $data['kehadiran'] = FinPro::where('pin',$data['biodata_karyawan']->pin)
                                    ->where('scan_date','LIKE','%'.$request->tahun.'-'.$request->bulan.'%')
                                    ->whereTime('scan_date','<=','11:59')
                                    ->count();

        return view('absensi.presensi.detail',$data);
    }

    public function search(Request $request)
    {
        $start_month_now = Carbon::create($request->cari_tanggal_awal)->startOfMonth()->format('Y-m-d');
        $end_month_now = Carbon::create($request->cari_tanggal_akhir)->endOfMonth()->format('Y-m-d');
        for ($i=$start_month_now; $i <= $end_month_now; $i++) { 
            $data['weeks'][] = $i;
        }
        $data['biodata_karyawans'] = BiodataKaryawan::where(function($query) {
                                                        return $query->where('nik','!=','1000001')
                                                                    ->where('nik','!=','1000002')
                                                                    ->where('nik','!=','1000003');
                                                    })
                                                    ->where('nik','LIKE','%'.$request->cari.'%')
                                                    ->orWhere('nama','LIKE','%'.$request->cari.'%')
                                                    ->where('status_karyawan','!=','R')
                                                    ->orderBy('satuan_kerja','asc')
                                                    ->paginate(20);
        return view('absensi.presensi.index',$data);
    }

    public function detail_print(Request $request, $nik)
    {
        $data['biodata_karyawan'] = BiodataKaryawan::where('nik',$nik)->first();
        $cek_status_kerja = IticDepartemen::where('id_departemen', $data['biodata_karyawan']->satuan_kerja)->first();
        
        $start_month_now = Carbon::create($request->cetak_tahun,$request->cetak_bulan)->startOfMonth()->format('Y-m-d');
        $end_month_now = Carbon::create($request->cetak_tahun,$request->cetak_bulan)->endOfMonth()->format('Y-m-d');
        // dd($end_month_now);
        for ($i=$start_month_now; $i <= $end_month_now; $i++) { 
            $data['weeks'][] = $i;
        }

        if (empty($cek_status_kerja)) {
            $data['satuan_kerja'] = '-';
        } else {
            if ($cek_status_kerja->nama_departemen >= 1) {
                $data['satuan_kerja'] = $cek_status_kerja->nama_unit;
            } else {
                $data['satuan_kerja'] = $cek_status_kerja->nama_departemen;
            }
        }
        $pdf = PDF::loadView('absensi.presensi.cetak_absensi', $data);
        return $pdf->stream('Rekap Absensi Karyawan - ('.$data['biodata_karyawan']->nik.') '.$data['biodata_karyawan']->nama.' Periode '.Carbon::create($request->cetak_tahun, $request->cetak_bulan)->isoFormat('MMMM YYYY').'.pdf');
    }
}
