<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BiodataKaryawan;
use App\Models\HrgaBiodataKaryawan;

use \Carbon\Carbon;

class RealTimeController extends Controller
{
    function __construct(
        BiodataKaryawan $biodata_karyawan,
        HrgaBiodataKaryawan $hrga_biodata_karyawan
    ){
        $this->biodata_karyawan = $biodata_karyawan;
        $this->hrga_biodata_karyawan = $hrga_biodata_karyawan;
    }

    public function karyawanKontrak()
    {
        $data['karyawanKontraks'] = $this->hrga_biodata_karyawan->select([
                                                    'hrga_biodata_karyawan_new.id as id',
                                                    'hrga_biodata_karyawan_new.nik as nik',
                                                    'biodata_karyawan.nama as nama',
                                                    'hrga_biodata_karyawan_new.departemen_dept as departemen_dept',
                                                    'hrga_status_kerja.pk as pekerja',
                                                    'hrga_status_kerja.ke as ke',
                                                    'hrga_status_kerja.tgl_mulai as tgl_mulai',
                                                ])
                                                ->leftJoin('itic_emp_new.biodata_karyawan','biodata_karyawan.nik','hrga_biodata_karyawan_new.nik')
                                                ->leftJoin('hrga_status_kerja','hrga_status_kerja.hrga_biodata_karyawan_id','hrga_biodata_karyawan_new.id')
                                                ->where('hrga_status_kerja.pk','!=','Tetap')
                                                ->orderBy('hrga_status_kerja.id','desc')
                                                // ->whereYear('hrga_status_kerja.tgl_mulai','>=',Carbon::now()->subYears()->format('Y'))
                                                ->where('hrga_status_kerja.tgl_mulai','LIKE','%'.Carbon::now()->subYears()->format('Y-m').'%')
                                                ->whereIn('hrga_biodata_karyawan_new.status_karyawan',['Y','K'])
                                                // ->where('hrga_status_kerja.tgl_mulai','>=',Carbon::now()->format('Y-m-d'))
                                                // ->limit(1)
                                                ->get();

                                                // return Carbon::now()->subDay(9)->format('Y-m-d');
                                                // return $data;
                                                // dd($data);
        return view('realtime.listKaryawanKontrak',$data);
    }
}
