<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use App\Models\HrgaBiodataKaryawan;
use App\Models\BiodataKaryawan;
use \Carbon\Carbon;

class RekapDataKaryawanAktifExcel implements 
FromView,
ShouldAutoSize,
WithTitle,
WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    
    public function __construct(
        $tanggal
    ){
        $this->tanggal = $tanggal;
    }

    // public function collection()
    // {
    //     //
    // }

    public function title(): string
    {
        // $sheet = array('DATABASE AKTIF','DATABASE NON AKTIF');
        // return $sheet;
        return 'DATABASE AKTIF';
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    
    public function view(): View
    {
        $data['tanggal'] = Carbon::create($this->tanggal)->format('d-m-Y');
        // $data['departemens'] = HrgaBiodataKaryawan::select('departemen_dept')
        //                             // ->whereHas('log_posisi', function($query) use($tanggal) {
        //                             //     return $query->where('log_posisi.tanggal',$tanggal);
        //                             // })
        //                             ->leftJoin('itic_emp.log_posisi','itic_emp.log_posisi.nik','=','hrga_biodata_karyawan.nik')
        //                             ->where('itic_emp.log_posisi.tanggal','<=',$this->tanggal)
        //                             ->where('hrga_biodata_karyawan.status_karyawan','Y')
        //                             ->groupBy('hrga_biodata_karyawan.departemen_dept')
        //                             ->orderBy('hrga_biodata_karyawan.departemen_dept','asc')
        //                             ->get();
        $data['departemens'] = HrgaBiodataKaryawan::select([
                                        'hrga_biodata_karyawan_new.departemen_dept as departemen_dept'
                                    ])
                                    // ->whereHas('log_posisi', function($query) use($tanggal) {
                                    //     return $query->where('log_posisi.tanggal',$tanggal);
                                    // })
                                    ->leftJoin('itic_emp_new.biodata_karyawan','biodata_karyawan.nik','=','hrga_biodata_karyawan_new.nik')
                                    ->where('itic_emp_new.biodata_karyawan.tanggal_masuk','<=',$this->tanggal)
                                    ->whereIn('hrga_biodata_karyawan_new.status_karyawan',['Y','K'])
                                    ->groupBy('hrga_biodata_karyawan_new.departemen_dept')
                                    ->orderBy('hrga_biodata_karyawan_new.departemen_dept','asc')
                                    ->get();
        // return $data;
        return view('hrga.excel.download_rekap_excel',$data);
    }

    // public function sheets(): array
    // {
    //     // $sheets = [
    //     //     'DATABASE AKTIF','DATABASE NON AKTIF'
    //     // ];
    //     // return $sheets;
    //     $data = $this->view();
    //     return [
    //         view('hrga.excel.download_rekap_excel',$data)
    //     ];
    // }
}
