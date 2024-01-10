<?php

namespace App\Http\Controllers\Absensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BiodataKaryawan;
use \Carbon\Carbon;

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
                                                    ->paginate(20);
        // dd($data);
        return view('absensi.presensi.index',$data);
    }
}
