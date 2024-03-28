<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\BiodataKaryawan;
use App\Models\FinPro;
use App\Models\PresensiInfo;
use \Carbon\Carbon;

class AbsensiDownloadExcel implements 
FromView,
ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct(
        $nik,
        $cetak_bulan,
        $cetak_tahun,
        $fin_pro,
        $presensi_info,
        $biodata_karyawan,
        $itic_departemen
        // BiodataKaryawan $biodata_karyawan
        // FinPro $fin_pro,
        // PresensiInfo $presensi_info,
    ){
        $this->nik = $nik;
        $this->cetak_bulan = $cetak_bulan;
        $this->cetak_tahun = $cetak_tahun;
        $this->fin_pro = $fin_pro;
        $this->presensi_info = $presensi_info;
        $this->biodata_karyawan = $biodata_karyawan;
        $this->itic_departemen = $itic_departemen;
        // $this->presensi_info = $presensi_info;
        // $this->fin_pro = $fin_pro;
        // $this->presensi_info = $presensi_info;
    }

    public function view(): View
    {
        $data['biodata_karyawan'] = $this->biodata_karyawan->where('nik',$this->nik)->first();
        $cek_status_kerja = $this->itic_departemen->where('id_departemen', $data['biodata_karyawan']->satuan_kerja)->first();
        
        $start_month_now = Carbon::create($this->cetak_tahun,$this->cetak_bulan)->startOfMonth()->format('Y-m-d');
        $end_month_now = Carbon::create($this->cetak_tahun,$this->cetak_bulan)->endOfMonth()->format('Y-m-d');
        // // dd($end_month_now);
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

        $data['fin_pro'] = $this->fin_pro;
        $data['presensi_info'] = $this->presensi_info;
        $data['cetak_tahun'] = $this->cetak_tahun;
        $data['cetak_bulan'] = $this->cetak_bulan;
        return view('absensi.presensi.download_absensi_excel',$data);
        // return view('absensi.presensi.download_absensi_excel');
    }
}
