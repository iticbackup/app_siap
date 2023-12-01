<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SheetRekapDataKaryawanExcel implements WithMultipleSheets 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(
        $tanggal
    ){
        $this->tanggal = $tanggal;
    }

    public function sheets(): array
    {
        return [
            new RekapDataKaryawanAktifExcel($this->tanggal),
            new RekapDataKaryawanNonAktifExcel($this->tanggal),
        ];
    }
}
