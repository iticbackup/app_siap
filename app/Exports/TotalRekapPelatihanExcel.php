<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\RekapPelatihanSeminar;
use \Carbon\Carbon;

class TotalRekapPelatihanExcel implements 
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
        // $data['rekap_pelatihans'] = RekapPelatihanSeminar::where('periode',$this->periode)->get();
        // $data['periode'] = $this->periode;
        $data['start_month'] = Carbon::now()->startOfYear()->format('m');
        $data['end_month'] = Carbon::now()->endOfYear()->format('m');
        $data['periode'] = $this->periode;
        return view('rekap_pelatihan.excel_rekap_periode',$data);
    }
}
