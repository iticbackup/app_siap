<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\RekapPelatihanSeminar;
use App\Models\Departemen;

class RekapPelatihanAllDepExcel implements 
FromView,
ShouldAutoSize
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     //
    // }
    use Exportable;

    public function  __construct($periode) {
        $this->periode = $periode;
    }

    public function view(): View
    {
        $data['rekap_pelatihans'] = RekapPelatihanSeminar::where('periode',$this->periode)->get();
        $data['periode'] = $this->periode;
        $data['departemens'] = Departemen::all();
        return view('rekap_pelatihan.excel_rekapan_all_dep',$data);
    }
}
