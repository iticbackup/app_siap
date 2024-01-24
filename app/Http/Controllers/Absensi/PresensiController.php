<?php

namespace App\Http\Controllers\Absensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BiodataKaryawan;
use App\Models\IticDepartemen;
use App\Models\FinPro;
use App\Models\IjinKeluarMasuk;
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
                                                    ->take(10)
                                                    // ->get();
                                                    ->paginate(10);
        // dd($data);
        return view('absensi.presensi.index',$data);
    }

    public function detail($nik){
        // return $nik;
        $data['biodata_karyawan'] = BiodataKaryawan::where('nik',$nik)->first();
        if (empty($data['biodata_karyawan'])) {
            return redirect()->back();
        }
        $data['start_month_now'] = Carbon::now()->startOfMonth()->format('Y-m-d');
        $data['end_month_now'] = Carbon::now()->endOfMonth()->format('Y-m-d');
        // dd($end_month_now);
        // for ($i=$start_month_now; $i <= $end_month_now; $i++) { 
        //     $data['weeks'][] = $i;
        // }

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
        // $data['kehadiran'] = FinPro::where('pin',$data['biodata_karyawan']->pin)
        //                             ->where('scan_date','LIKE','%'.Carbon::now()->format('Y-m').'%')
        //                             ->whereTime('scan_date','<=','11:59')
        //                             ->count();
        return view('absensi.presensi.detail',$data);
    }

    public function detail_ijin_jam_kerja($nik,$tanggal)
    {
        $ijin_keluar_masuk = IjinKeluarMasuk::where('nik',$nik)
                                            ->where('tanggal_ijin',$tanggal)
                                            ->first();
        if (empty($ijin_keluar_masuk)) {
            return [
                'success' => true,
                'status' => false,
                'nik' => $nik,
                'tanggal_ijin' => $tanggal,
                // 'message_content' => 'Data Ijin Keluar Masuk Tidak Ditemukan'
            ];
        }

        return [
            'success' => true,
            'status' => true,
            'data' => $ijin_keluar_masuk
        ];
    }

    public function detail_ijin_jam_kerja_simpan(Request $request,$nik)
    {
        $ijin_keluar_masuk = IjinKeluarMasuk::where('nik',$nik)
                                            ->where('tanggal_ijin',$request->edit_tanggal_ijin)
                                            ->first();
        if (empty($ijin_keluar_masuk)) {
            $ijin_keluar_masuk = IjinKeluarMasuk::create([
                'nik' => $request->edit_nik,
                'tanggal_ijin' => $request->edit_tanggal_ijin,
                'jam_keluar' => $request->edit_jam_keluar_jam.':'.$request->edit_jam_keluar_menit.':00',
                'jam_datang' => $request->edit_jam_datang_jam.':'.$request->edit_jam_datang_menit.':00',
                'jam_istirahat' => $request->edit_jam_istirahat_jam.':'.$request->edit_jam_istirahat_menit.':00',
                'keperluan' => $request->edit_keperluan,
                'nik_op' => auth()->user()->nik,
                'tanggal_input' => Carbon::now()
            ]);
        }
        
        $ijin_keluar_masuk->update([
            'jam_keluar' => $request->edit_jam_keluar_jam.':'.$request->edit_jam_keluar_menit.':00',
            'jam_datang' => $request->edit_jam_datang_jam.':'.$request->edit_jam_datang_menit.':00',
            'jam_istirahat' => $request->edit_jam_istirahat_jam.':'.$request->edit_jam_istirahat_menit.':00',
            'keperluan' => $request->edit_keperluan,
            'nik_op' => auth()->user()->nik,
        ]);
        
        return [
            'success' => true,
            'message_content' => 'Ijin Keluar Masuk / Ijin Kerja Berhasil Diubah'
        ];
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
                                                    // ->where('status_karyawan','!=','R')
                                                    // ->orderBy('satuan_kerja','asc')
                                                    ->paginate(20)->withQueryString();
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
