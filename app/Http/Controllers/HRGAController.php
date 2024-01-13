<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\LogPosisi;
use App\Models\BiodataKaryawan;
use App\Models\HrgaBiodataKaryawan;
use App\Models\HrgaStatusKerja;
use App\Models\HrgaRiwayatKonselingKaryawan;
use App\Models\HrgaRiwayatTraining;
use App\Models\HrgaKaryawanResign;

use App\Models\EmpJabatan;
use App\Models\EmpPosisi;
use App\Models\IticDepartemen;

use App\Models\RekapPelatihanSeminar;
use App\Models\RekapPelatihanSeminarPeserta;
use App\Models\RekapPelatihanSeminarKategori;
use App\Models\Departemen;
use App\Models\DepartemenUser;

use App\Exports\RekapDataKaryawanAktifExcel;
use App\Exports\RekapDataKaryawanNonAktifExcel;
use App\Exports\SheetRekapDataKaryawanExcel;
// use Intervention\Image\ImageManagerStatic as Image;
use \Carbon\Carbon;
use DB;
use DateTime;
use File;
use Validator;
use DataTables;
use Excel;

class HRGAController extends Controller
{
    function __construct(
        BiodataKaryawan $biodata_karyawan,
        HrgaBiodataKaryawan $hrga_biodata_karyawan,
        HrgaStatusKerja $hrga_status_kerja,
        HrgaRiwayatKonselingKaryawan $hrga_riwayat_konseling,
        HrgaRiwayatTraining $hrga_riwayat_training,
        HrgaKaryawanResign $hrga_karyawan_resign,
        RekapPelatihanSeminar $rekap_pelatihan,
        RekapPelatihanSeminarPeserta $rekap_pelatihan_seminar_peserta,
        EmpJabatan $emp_jabatan,
        EmpPosisi $emp_posisi,
        IticDepartemen $itic_departemen,
        LogPosisi $log_posisi
    ){
        $this->biodata_karyawan = $biodata_karyawan;
        $this->hrga_biodata_karyawan = $hrga_biodata_karyawan;
        $this->hrga_status_kerja = $hrga_status_kerja;
        $this->hrga_riwayat_konseling = $hrga_riwayat_konseling;
        $this->hrga_riwayat_training = $hrga_riwayat_training;
        $this->hrga_karyawan_resign = $hrga_karyawan_resign;
        $this->rekap_pelatihan = $rekap_pelatihan;
        $this->rekap_pelatihan_seminar_peserta = $rekap_pelatihan_seminar_peserta;
        $this->emp_jabatan = $emp_jabatan;
        $this->emp_posisi = $emp_posisi;
        $this->itic_departemen = $itic_departemen;
        $this->log_posisi = $log_posisi;
        $this->day = 0;
    }

    public function index_biodata_karyawan(Request $request)
    {
        // $data = $this->hrga_biodata_karyawan->select([
        //                                         'hrga_biodata_karyawan.id as id',
        //                                         'hrga_biodata_karyawan.nik as nik',
        //                                         'biodata_karyawan.nama as nama',
        //                                         'hrga_biodata_karyawan.no_npwp as no_npwp',
        //                                         'hrga_biodata_karyawan.no_telepon as no_telepon',
        //                                         'hrga_biodata_karyawan.no_bpjs_ketenagakerjaan as no_bpjs_ketenagakerjaan',
        //                                         'hrga_biodata_karyawan.no_bpjs_kesehatan as no_bpjs_kesehatan',
        //                                         'hrga_biodata_karyawan.no_rekening_mandiri as no_rekening_mandiri',
        //                                         'hrga_biodata_karyawan.no_rekening_bws as no_rekening_bws',
        //                                         'hrga_biodata_karyawan.departemen_dept as departemen_dept',
        //                                         'hrga_biodata_karyawan.departemen_bagian as departemen_bagian',
        //                                         'hrga_biodata_karyawan.departemen_level as departemen_level',
        //                                         'hrga_biodata_karyawan.tempat_lahir as tempat_lahir',
        //                                         'hrga_biodata_karyawan.tanggal_lahir as tanggal_lahir',
        //                                         'hrga_biodata_karyawan.alamat as alamat',
        //                                         'hrga_biodata_karyawan.jenis_kelamin as jenis_kelamin',
        //                                         'hrga_biodata_karyawan.status_keluarga as status_keluarga',
        //                                         'hrga_biodata_karyawan.golongan_darah as golongan_darah',
        //                                         'hrga_biodata_karyawan.pendidikan as pendidikan',
        //                                         'hrga_biodata_karyawan.email as email',
        //                                         'hrga_biodata_karyawan.kunci_loker as kunci_loker',
        //                                         'hrga_biodata_karyawan.foto_karyawan as foto_karyawan',
        //                                         'hrga_biodata_karyawan.tanggal_resign as tanggal_resign',
        //                                     ])
        //                                     ->leftJoin('itic_emp.biodata_karyawan as biodata_karyawan','biodata_karyawan.nik','hrga_biodata_karyawan.nik')
        //                                     ->where('biodata_karyawan.status_karyawan','!=','R')
        //                                     ->get();
        // return $data;
        if ($request->ajax()) {
            // $data = $this->hrga_biodata_karyawan->get();
            $data = $this->hrga_biodata_karyawan->select([
                                                    'hrga_biodata_karyawan.id as id',
                                                    'hrga_biodata_karyawan.nik as nik',
                                                    'biodata_karyawan.nama as nama',
                                                    'hrga_biodata_karyawan.no_npwp as no_npwp',
                                                    'hrga_biodata_karyawan.no_telepon as no_telepon',
                                                    'hrga_biodata_karyawan.no_bpjs_ketenagakerjaan as no_bpjs_ketenagakerjaan',
                                                    'hrga_biodata_karyawan.no_bpjs_kesehatan as no_bpjs_kesehatan',
                                                    'hrga_biodata_karyawan.no_rekening_mandiri as no_rekening_mandiri',
                                                    'hrga_biodata_karyawan.no_rekening_bws as no_rekening_bws',
                                                    'hrga_biodata_karyawan.departemen_dept as departemen_dept',
                                                    'hrga_biodata_karyawan.departemen_bagian as departemen_bagian',
                                                    'hrga_biodata_karyawan.departemen_level as departemen_level',
                                                    'hrga_biodata_karyawan.tempat_lahir as tempat_lahir',
                                                    'hrga_biodata_karyawan.tanggal_lahir as tanggal_lahir',
                                                    'hrga_biodata_karyawan.alamat as alamat',
                                                    'hrga_biodata_karyawan.jenis_kelamin as jenis_kelamin',
                                                    'hrga_biodata_karyawan.status_keluarga as status_keluarga',
                                                    'hrga_biodata_karyawan.golongan_darah as golongan_darah',
                                                    'hrga_biodata_karyawan.pendidikan as pendidikan',
                                                    'hrga_biodata_karyawan.email as email',
                                                    'hrga_biodata_karyawan.kunci_loker as kunci_loker',
                                                    'hrga_biodata_karyawan.foto_karyawan as foto_karyawan',
                                                    'hrga_biodata_karyawan.tanggal_resign as tanggal_resign',
                                                    'biodata_karyawan.status_karyawan as status_karyawan',
                                                ])
                                                ->leftJoin('itic_emp.biodata_karyawan as biodata_karyawan','biodata_karyawan.nik','hrga_biodata_karyawan.nik')
                                                // ->where('biodata_karyawan.status_karyawan','!=','R')
                                                ->get();
            return DataTables::of($data)
                                ->addIndexColumn()
                                ->addColumn('foto_karyawan', function($row){
                                    // return '<img src='.asset('public/berkas/HRGA/data_karyawan/'.$row->foto_karyawan).'>';
                                    if (empty($row->foto_karyawan)) {
                                        if ($row->jenis_kelamin == 'Laki - Laki') {
                                            return '<img src='.asset('public/berkas/HRGA/data_karyawan/office-worker-man.png').' style="width: 100px; height: 137px; object-fit: cover;">';
                                        }else{
                                            return '<img src='.asset('public/berkas/HRGA/data_karyawan/businesswoman.png').' style="width: 100px; height: 137px; object-fit: cover;">';
                                        }
                                    }else{
                                        return '<img src='.asset('public/berkas/HRGA/data_karyawan/'.$row->foto_karyawan).' style="width: 100px; height: 137px; object-fit: cover;">';
                                    }
                                })
                                ->addColumn('nama_karyawan', function($row){
                                    if (empty($row->nama)) {
                                        $nama = "-";
                                    }else{
                                        $nama = $row->nama;
                                    }
                                    return $nama;
                                })
                                ->addColumn('status_kerja', function($row){
                                    $status_kontrak_karyawan = $this->hrga_status_kerja->select('pk')->where('hrga_biodata_karyawan_id', $row->id)->orderBy('id','desc')->first();
                                    if (empty($status_kontrak_karyawan)) {
                                        return $status_kontrak = '-';
                                    }else{
                                        return $status_kontrak = $status_kontrak_karyawan->pk;
                                    }
                                })
                                ->addColumn('status_karyawan_resign', function($row){
                                    if ($row->status_karyawan == 'K') {
                                        return '<span class="badge bg-warning">Kontrak</span>';
                                    }elseif($row->status_karyawan == 'R'){
                                        return '<span class="badge bg-danger">Resign</span>';
                                    }else{
                                        return '<span class="badge bg-success">Aktif</span>';
                                    }
                                    // $karyawan_resign = $this->hrga_karyawan_resign->where('hrga_biodata_karyawan_id',$row->id)->first();
                                    // if (empty($karyawan_resign)) {
                                    //     return '<span class="badge bg-success">Aktif</span>';
                                    // }else{
                                    //     return '<span class="badge bg-danger">Non Aktif</span>'.'<span class="badge bg-dark">'.Carbon::create($karyawan_resign->tanggal_resign)->format('d-m-Y').'</span>';
                                    // }
                                })
                                ->addColumn('action', function($row){
                                    $btn = '<div class="button-items">';
                                    $btn .= '<button class="btn btn-primary" onclick="detail(`'.$row->nik.'`)">'.'<i class="fas fa-eye"></i> '.'Detail'.'</button>';
                                    $btn .= '<button class="btn btn-warning" onclick="edit(`'.$row->nik.'`)">'.'<i class="fas fa-edit"></i> '.'Edit'.'</button>';
                                    $btn .= '</div>';

                                    return $btn;
                                })
                                ->rawColumns(['action','status_karyawan_resign','foto_karyawan'])
                                ->make(true);
            // return DataTables::of($data)
            //                 ->addIndexColumn()
            //                 ->addColumn('foto_karyawan', function($row){
            //                     // return '<img src='.asset('public/berkas/HRGA/data_karyawan/'.$row->foto_karyawan).'>';
            //                     if (empty($row->foto_karyawan)) {
            //                         if ($row->jenis_kelamin == 'Laki - Laki') {
            //                             return '<img src='.asset('public/berkas/HRGA/data_karyawan/office-worker-man.png').' style="width: 100px; height: 137px; object-fit: cover;">';
            //                         }else{
            //                             return '<img src='.asset('public/berkas/HRGA/data_karyawan/businesswoman.png').' style="width: 100px; height: 137px; object-fit: cover;">';
            //                         }
            //                     }else{
            //                         return '<img src='.asset('public/berkas/HRGA/data_karyawan/'.$row->foto_karyawan).' style="width: 100px; height: 137px; object-fit: cover;">';
            //                     }
            //                 })
            //                 ->addColumn('nama_karyawan', function($row){
            //                     if (empty($row->biodata_karyawan->nama)) {
            //                         $nama = "-";
            //                     }else{
            //                         $nama = $row->biodata_karyawan->nama;
            //                     }
            //                     return $nama;
            //                 })
            //                 ->addColumn('status_kerja', function($row){
            //                     $status_kontrak_karyawan = $this->hrga_status_kerja->select('pk')->where('hrga_biodata_karyawan_id', $row->id)->orderBy('id','desc')->first();
            //                     if (empty($status_kontrak_karyawan)) {
            //                         return $status_kontrak = '-';
            //                     }else{
            //                         return $status_kontrak = $status_kontrak_karyawan->pk;
            //                     }
            //                 })
            //                 ->addColumn('status_karyawan_resign', function($row){
            //                     // return $row->biodata_karyawan->nama;
            //                     $karyawan_resign = $this->hrga_karyawan_resign->where('hrga_biodata_karyawan_id',$row->id)->first();
            //                     // return $karyawan_resign->tanggal_resign;

            //                     if (empty($karyawan_resign)) {
            //                         return '<span class="badge bg-success">Aktif</span>';
            //                     }else{
            //                         return '<span class="badge bg-danger">Non Aktif</span>'.'<span class="badge bg-dark">'.Carbon::create($karyawan_resign->tanggal_resign)->format('d-m-Y').'</span>';
            //                     }

            //                     // if (empty($row->status_karyawan_resign)) {
            //                     //     return 'Aktif';
            //                     // }else{
            //                     //     return $row->status_karyawan_resign;
            //                     // }
            //                 })
            //                 ->addColumn('action', function($row){
            //                     $btn = '<div class="button-items">';
            //                     $btn .= '<button class="btn btn-primary" onclick="detail(`'.$row->nik.'`)">'.'<i class="fas fa-eye"></i> '.'Detail'.'</button>';
            //                     $btn .= '<button class="btn btn-warning" onclick="edit(`'.$row->nik.'`)">'.'<i class="fas fa-edit"></i> '.'Edit'.'</button>';
            //                     $btn .= '</div>';

            //                     return $btn;
            //                 })
            //                 ->rawColumns(['action','foto_karyawan','status_karyawan_resign'])
            //                 ->make(true);
        }
        return view('hrga.index_biodata_karyawan');
    }

    public function index_biodata_karyawan_aktif(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->hrga_biodata_karyawan->select([
                                                    'hrga_biodata_karyawan.id as id',
                                                    'hrga_biodata_karyawan.nik as nik',
                                                    // 'hrga_biodata_karyawan.no_urut_level as no_urut_level',
                                                    // 'hrga_biodata_karyawan.no_urut_departemen as no_urut_departemen',
                                                    'hrga_biodata_karyawan.no_telepon as no_telepon',
                                                    'hrga_biodata_karyawan.no_bpjs_ketenagakerjaan as no_bpjs_ketenagakerjaan',
                                                    'hrga_biodata_karyawan.no_bpjs_kesehatan as no_bpjs_kesehatan',
                                                    'hrga_biodata_karyawan.no_rekening_mandiri as no_rekening_mandiri',
                                                    'hrga_biodata_karyawan.no_rekening_bws as no_rekening_bws',
                                                    'hrga_biodata_karyawan.no_npwp as no_npwp',
                                                    'hrga_biodata_karyawan.departemen_dept as departemen_dept',
                                                    'hrga_biodata_karyawan.departemen_bagian as departemen_bagian',
                                                    'hrga_biodata_karyawan.departemen_level as departemen_level',
                                                    'hrga_biodata_karyawan.tempat_lahir as tempat_lahir',
                                                    'hrga_biodata_karyawan.tanggal_lahir as tanggal_lahir',
                                                    'hrga_biodata_karyawan.jenis_kelamin as jenis_kelamin',
                                                    'hrga_biodata_karyawan.status_keluarga as status_keluarga',
                                                    'hrga_biodata_karyawan.golongan_darah as golongan_darah',
                                                    'hrga_biodata_karyawan.pendidikan as pendidikan',
                                                    'hrga_biodata_karyawan.email as email',
                                                    'hrga_biodata_karyawan.alamat as alamat',
                                                    'hrga_biodata_karyawan.kunci_loker as kunci_loker',
                                                ])
                                                // ->join('hrga_karyawan_resign','hrga_karyawan_resign.hrga_biodata_karyawan_id','!=','hrga_biodata_karyawan.id')
                                                ->where('hrga_biodata_karyawan.status_karyawan','Y')
                                                ->get();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('foto_karyawan', function($row){
                                // return '<img src='.asset('public/berkas/HRGA/data_karyawan/'.$row->foto_karyawan).'>';
                                if (empty($row->foto_karyawan)) {
                                    if ($row->jenis_kelamin == 'Laki - Laki') {
                                        return '<img src='.asset('public/berkas/HRGA/data_karyawan/office-worker-man.png').' style="width: 100px; height: 137px; object-fit: cover;">';
                                    }else{
                                        return '<img src='.asset('public/berkas/HRGA/data_karyawan/businesswoman.png').' style="width: 100px; height: 137px; object-fit: cover;">';
                                    }
                                }else{
                                    return '<img src='.asset('public/berkas/HRGA/data_karyawan/'.$row->foto_karyawan).' style="width: 100px; height: 137px; object-fit: cover;">';
                                }
                            })
                            ->addColumn('nama_karyawan', function($row){
                                // return $row->biodata_karyawan->nama;
                                if (empty($row->biodata_karyawan->nama)) {
                                    $nama = "-";
                                }else{
                                    $nama = $row->biodata_karyawan->nama;
                                }
                                return $nama;
                            })
                            ->addColumn('status_kerja', function($row){
                                $status_kontrak_karyawan = $this->hrga_status_kerja->select('pk')->where('hrga_biodata_karyawan_id', $row->id)->orderBy('id','desc')->first();
                                if (empty($status_kontrak_karyawan)) {
                                    return $status_kontrak = '-';
                                }else{
                                    return $status_kontrak = $status_kontrak_karyawan->pk;
                                }
                            })
                            ->addColumn('status_karyawan_resign', function($row){
                                // return $row->biodata_karyawan->nama;
                                $karyawan_resign = $this->hrga_karyawan_resign->where('hrga_biodata_karyawan_id',$row->id)->first();
                                // return $karyawan_resign->tanggal_resign;

                                if (empty($karyawan_resign)) {
                                    return '<span class="badge bg-success">Aktif</span>';
                                }else{
                                    return '<span class="badge bg-danger">Non Aktif</span>'.'<span class="badge bg-dark">'.Carbon::create($karyawan_resign->tanggal_resign)->format('d-m-Y').'</span>';
                                }

                                // if (empty($row->status_karyawan_resign)) {
                                //     return 'Aktif';
                                // }else{
                                //     return $row->status_karyawan_resign;
                                // }
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="button-items">';
                                $btn .= '<button class="btn btn-primary" onclick="detail(`'.$row->nik.'`)">'.'<i class="fas fa-eye"></i> '.'Detail'.'</button>';
                                $btn .= '<button class="btn btn-warning" onclick="edit(`'.$row->nik.'`)">'.'<i class="fas fa-edit"></i> '.'Edit'.'</button>';
                                $btn .= '</div>';

                                return $btn;
                            })
                            ->rawColumns(['action','foto_karyawan','status_karyawan_resign'])
                            ->make(true);
        }

        return view('hrga.aktif.index_biodata_karyawan');
    }

    public function index_biodata_karyawan_non_aktif(Request $request)
    {
        // $data = $this->biodata_karyawan->leftJoin('hrga_biodata_karyawan','hrga_biodata_karyawan.nik','biodata_karyawan.nik')
        //                                 // ->where('status_karyawan','R')
        //                                 ->get();
        // return $data;
        if ($request->ajax()) {
            $data = $this->hrga_karyawan_resign->with('hrga_biodata_karyawan')->get();
            // $data = $this->biodata_karyawan->leftJoin('hrga_biodata_karyawan','hrga_biodata_karyawan.nik','biodata_karyawan.nik')
            //                                 ->where('status_karyawan','R')
            //                                 ->get();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('foto_karyawan', function($row){
                                // return '<img src='.asset('public/berkas/HRGA/data_karyawan/'.$row->hrga_biodata_karyawan->foto_karyawan).'>';
                                if (empty($row->hrga_biodata_karyawan->foto_karyawan)) {
                                    if ($row->hrga_biodata_karyawan->jenis_kelamin == 'Laki - Laki') {
                                        return '<img src='.asset('public/berkas/HRGA/data_karyawan/office-worker-man.png').' style="width: 100px; height: 137px; object-fit: cover;">';
                                    }else{
                                        return '<img src='.asset('public/berkas/HRGA/data_karyawan/businesswoman.png').' style="width: 100px; height: 137px; object-fit: cover;">';
                                    }
                                }else{
                                    return '<img src='.asset('public/berkas/HRGA/data_karyawan/'.$row->hrga_biodata_karyawan->biodata_karyawan->foto_karyawan).' style="width: 100px; height: 137px; object-fit: cover;">';
                                }
                            })
                            ->addColumn('nik', function($row){
                                return $row->hrga_biodata_karyawan->nik;
                                // return $row->nik;
                            })
                            ->addColumn('no_telepon', function($row){
                                // return $row->biodata_karyawan->nama;
                                return $row->hrga_biodata_karyawan->no_telepon;
                            })
                            ->addColumn('nama_karyawan', function($row){
                                return $row->hrga_biodata_karyawan->biodata_karyawan->nama;
                                // return $row->nama;
                            })
                            ->addColumn('status_kerja', function($row){
                                $status_kontrak_karyawan = $this->hrga_status_kerja->select('pk')->where('hrga_biodata_karyawan_id', $row->id)->orderBy('id','desc')->first();
                                if (empty($status_kontrak_karyawan)) {
                                    return $status_kontrak = '-';
                                }else{
                                    return $status_kontrak = $status_kontrak_karyawan->pk;
                                }
                            })
                            ->addColumn('status_karyawan_resign', function($row){
                                $karyawan_resign = $this->hrga_karyawan_resign->where('hrga_biodata_karyawan_id',$row->id)->first();
                                if (empty($karyawan_resign)) {
                                    return '<span class="badge bg-success">Aktif</span>';
                                }else{
                                    return '<span class="badge bg-danger">Non Aktif</span>'.'<span class="badge bg-dark">'.Carbon::create($karyawan_resign->tanggal_resign)->format('d-m-Y').'</span>';
                                }
                                return '<span class="badge bg-danger">Non Aktif</span>'.'<span class="badge bg-dark">'.Carbon::create($row->tanggal_resign)->format('d-m-Y').'</span>';
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="button-items">';
                                $btn .= '<button class="btn btn-primary" onclick="detail(`'.$row->hrga_biodata_karyawan->nik.'`)">'.'<i class="fas fa-eye"></i> '.'Detail'.'</button>';
                                $btn .= '</div>';

                                return $btn;
                            })
                            ->rawColumns([
                                'action',
                                'foto_karyawan',
                                'status_karyawan_resign'
                            ])
                            ->make(true);
            // return DataTables::of($data)
            //                 ->addIndexColumn()
            //                 // ->addColumn('foto_karyawan', function($row){
            //                 //     return '<img src='.asset('public/berkas/HRGA/data_karyawan/'.$row->foto_karyawan).'>';
            //                 //     if (empty($row->foto_karyawan)) {
            //                 //         if ($row->jenis_kelamin == 'Laki - Laki') {
            //                 //             return '<img src='.asset('public/berkas/HRGA/data_karyawan/office-worker-man.png').' style="width: 100px; height: 137px; object-fit: cover;">';
            //                 //         }else{
            //                 //             return '<img src='.asset('public/berkas/HRGA/data_karyawan/businesswoman.png').' style="width: 100px; height: 137px; object-fit: cover;">';
            //                 //         }
            //                 //     }else{
            //                 //         return '<img src='.asset('public/berkas/HRGA/data_karyawan/'.$row->foto_karyawan).' style="width: 100px; height: 137px; object-fit: cover;">';
            //                 //     }
            //                 // })
            //                 ->addColumn('action', function($row){
            //                     // $btn = '<div class="button-items">';
            //                     // $btn .= '<button class="btn btn-primary" onclick="detail(`'.$row->nik.'`)">'.'<i class="fas fa-eye"></i> '.'Detail'.'</button>';
            //                     // $btn .= '</div>';

            //                     // return $btn;
            //                 })
            //                 ->rawColumns([
            //                     'action',
            //                     // 'foto_karyawan'
            //                 ])
            //                 ->make(true);
        }

        return view('hrga.non_aktif.index_biodata_karyawan');
    }

    public function data_karyawan()
    {
        $biodata_karyawan = $this->biodata_karyawan->get();
        return $biodata_karyawan;
    }

    public function get_search_data_karyawan($nik)
    {
        $biodata_karyawan = $this->biodata_karyawan->with('log_posisi')->where('nik',$nik)->first();
        return $biodata_karyawan;
    }

    public function buat_karyawan_baru()
    {
        $data['pin'] = $this->biodata_karyawan->max('pin');
        $data['posisis'] = $this->emp_posisi->get();
        $data['jabatans'] = $this->emp_jabatan->get();
        $data['departemens'] = $this->itic_departemen->get();
        // dd($data);
        return view('hrga.buat_karyawan_baru',$data);
    }

    public function buat_karyawan_baru_simpan(Request $request)
    {
        $rules = [
            'nik' => 'required|unique:emp.biodata_karyawan',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_npwp' => 'required',
            'alamat' => 'required',
            'posisi' => 'required',
            'jabatan' => 'required',
            'departemen' => 'required',
            'no_rekening_mandiri' => 'required',
            'no_rekening_bws' => 'required',
            'status_klg' => 'required',
            'kewarganegaraan' => 'required',
            'agama' => 'required',
        ];

        $messages = [
            'nik.unique'  => 'NIK Karyawan sudah ada.',
            'nik.required'  => 'NIK wajib diisi.',
            'nama.required'  => 'Nama Karyawan Baru wajib diisi.',
            'tempat_lahir.required'  => 'Tempat Lahir wajib diisi.',
            'tanggal_lahir.required'  => 'Tanggal Lahir wajib diisi.',
            'jenis_kelamin.required'  => 'Jenis Kelamin wajib diisi.',
            'no_npwp.required'  => 'NPWP wajib diisi.',
            'alamat.required'  => 'Alamat wajib diisi.',
            'posisi.required'  => 'Posisi wajib diisi.',
            'jabatan.required'  => 'Jabatan wajib diisi.',
            'departemen.required'  => 'Departemen wajib diisi.',
            'no_rekening_mandiri.required'  => 'No. Rekening Mandiri wajib diisi.',
            'no_rekening_bws.required'  => 'No. Rekening BWS wajib diisi.',
            'status_klg.required'  => 'Status Keluarga wajib diisi.',
            'kewarganegaraan.required'  => 'Kewarganegaraan wajib diisi.',
            'agama.required'  => 'Agama wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            $input['nik'] = $request->nik;
            $input['nama'] = $request->nama;
            $input['tempat_lahir'] = $request->tempat_lahir;
            $input['tgl_lahir'] = $request->tanggal_lahir;
            $input['jenis_kelamin'] = $request->jenis_kelamin == 'Laki - Laki' ? 'L' : 'P';
            $input['npwp'] = $request->no_npwp;
            $input['alamat'] = $request->alamat;
            $input['id_posisi'] = $request->posisi;
            $input['id_jabatan'] = $request->jabatan;
            $input['satuan_kerja'] = $request->departemen;
            $input['status_klg'] = $request->status_klg;
            $input['kewarganegaraan'] = $request->kewarganegaraan;
            $input['agama'] = $request->agama;
            $input['pin'] = $request->pin;
            $input['status_karyawan'] = 'K';
            $input['rekening'] = $request->no_rekening_mandiri;
            $input['credit'] = 0;
            $input['status_kontrak'] = 0;

            $biodata_karyawan = $this->biodata_karyawan->create($input);
            if ($biodata_karyawan) {
                $this->log_posisi->create([
                    'nik' => $input['nik'],
                    'id_posisi' => $input['id_posisi'],
                    'id_jabatan' => $input['id_jabatan'],
                    'satuan_kerja' => $input['satuan_kerja'],
                    'tanggal' => $request->tanggal_masuk
                ]);
                $no_id = $this->hrga_biodata_karyawan->max('id');
                $this->hrga_biodata_karyawan->create([
                    'id' => $no_id+1,
                    'nik' => $input['nik'],
                    'no_npwp' => $input['npwp'],
                    'no_rekening_mandiri' => $request->no_rekening_mandiri,
                    'no_rekening_bws' => $request->no_rekening_bws,
                    'tempat_lahir' => $input['tempat_lahir'],
                    'tanggal_lahir' => $input['tgl_lahir'],
                    'alamat' => $input['agama'],
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'status_keluarga' => $input['status_klg'],
                ]);

                $message_title="Berhasil !";
                $message_content= $request->nik." ".$request->nama." Berhasil Dibuat";
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

    public function simpan(Request $request)
    {

        // dd($request->all());

        $rules = [
            'nik' => 'required|unique:hrga_biodata_karyawan',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            // 'email' => 'required',
            // 'no_urut_level' => 'required',
            // 'no_urut_departemen' => 'required',
            'no_bpjs_ketenagakerjaan' => 'required',
            'no_bpjs_kesehatan' => 'required',
            'no_rekening_mandiri' => 'required',
            'no_rekening_bws' => 'required',
            'departemen_dept' => 'required',
            'departemen_bagian' => 'required',
            'departemen_level' => 'required',
            'status_keluarga' => 'required',
            'golongan_darah' => 'required',
            'pendidikan' => 'required',
            'kunci_loker' => 'required',
            'status_karyawan' => 'required',
            // 'foto_karyawan' => 'required',
        ];

        $messages = [
            'nik.unique'  => 'NIK Karyawan sudah ada.',
            'nik.required'  => 'NIK wajib diisi.',
            'tempat_lahir.required'  => 'Tempat Lahir wajib diisi.',
            'tanggal_lahir.required'  => 'Tanggal Lahir wajib diisi.',
            'jenis_kelamin.required'  => 'Jenis Kelamin wajib diisi.',
            // 'email.required'  => 'Email wajib diisi.',
            // 'no_urut_level.required'  => 'No. Urut Level wajib diisi.',
            // 'no_urut_departemen.required'  => 'No. Urut Departemen wajib diisi.',
            'no_bpjs_ketenagakerjaan.required'  => 'No. Bpjs Ketenagakerjaan wajib diisi.',
            'no_bpjs_kesehatan.required'  => 'No. Bpjs Kesehatan wajib diisi.',
            'no_rekening_mandiri.required'  => 'No. Rekening Mandiri wajib diisi.',
            'no_rekening_bws.required'  => 'No. Rekening BWS wajib diisi.',
            'departemen_dept.required'  => 'Departemen wajib diisi.',
            'departemen_bagian.required'  => 'Departemen Bagian wajib diisi.',
            'departemen_level.required'  => 'Departemen Level wajib diisi.',
            'status_keluarga.required'  => 'Status Keluarga wajib diisi.',
            'golongan_darah.required'  => 'Status Keluarga wajib diisi.',
            'pendidikan.required'  => 'Pendidikan wajib diisi.',
            'kunci_loker.required'  => 'Kunci Loker wajib diisi.',
            'status_karyawan.required'  => 'Status Karyawan wajib diisi.',
            // 'foto_karyawan.required'  => 'Upload Foto wajib diisi.',
            // 'foto_karyawan.size'  => 'File Upload Foto maksimal 2 MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $no_id = $this->hrga_biodata_karyawan->max('id');
            $input['id'] = $no_id+1;
            $input['nik'] = $request->nik;
            $input['tempat_lahir'] = $request->tempat_lahir;
            $input['tanggal_lahir'] = $request->tanggal_lahir;
            $input['jenis_kelamin'] = $request->jenis_kelamin;
            $input['alamat'] = $request->alamat;
            $input['no_npwp'] = $request->no_npwp;
            $input['no_telepon'] = $request->no_telepon;
            $input['email'] = $request->email;
            // $input['no_urut_level'] = $request->no_urut_level;
            // $input['no_urut_departemen'] = $request->no_urut_departemen;
            $input['no_bpjs_ketenagakerjaan'] = $request->no_bpjs_ketenagakerjaan;
            $input['no_bpjs_kesehatan'] = $request->no_bpjs_kesehatan;
            $input['no_rekening_mandiri'] = $request->no_rekening_mandiri;
            $input['no_rekening_bws'] = $request->no_rekening_bws;
            $input['departemen_dept'] = strtoupper($request->departemen_dept);
            $input['departemen_bagian'] = $request->departemen_bagian;
            $input['departemen_level'] = $request->departemen_level;
            $input['status_keluarga'] = $request->status_keluarga;
            $input['golongan_darah'] = $request->golongan_darah;
            $input['pendidikan'] = $request->pendidikan;
            $input['kunci_loker'] = $request->kunci_loker;
            $input['status_karyawan'] = $request->status_karyawan;

            $path_file = public_path('berkas/HRGA/data_karyawan');
            
            if(!File::isDirectory($path_file)){
                File::makeDirectory($path_file, 0777, true, true);
            }

            if ($request->file('foto_karyawan')) {
                $file = $request->file('foto_karyawan');
                $fileName = $request->nik.'_'.Str::slug($request->nama_karyawan).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('berkas/HRGA/data_karyawan'), $fileName);
                $input['foto_karyawan'] = $fileName;
            }

            // $file = $request->file('foto_karyawan');
            // $img = \Image::make($file->path());
            // $img = $img->encode('webp', 75);
            // $input['foto_karyawan'] = $request->nik.'_'.$request->nama_karyawan.'.webp';
            // $img->save(public_path('berkas/HRGA/data_karyawan/').$input['foto_karyawan']);

            // $image = $request->file('foto_karyawan');
            // $img = \Image::make($image->path());
            // $img = $img->encode('webp', 75);
            // $input['foto_karyawan'] = time().'.webp';
            // $img->save(public_path('berkas/HRGA/Data Karyawan/').$input['foto_karyawan']);

            $save_biodata_karyawan = $this->hrga_biodata_karyawan->create($input);

            if($save_biodata_karyawan){
                if (empty($request->input_kontrak)) {
                    $no_hrga_status_kerja = $this->hrga_status_kerja->max('id');
                    foreach ($request->input_kontrak as $key => $value) {
                        $this->hrga_status_kerja->create([
                            'id' => $no_hrga_status_kerja+1,
                            'hrga_biodata_karyawan_id' => $input['id'],
                            'pk' => $value[0],
                            'ke' => $value[1],
                            'tgl_mulai' => $value[2]
                        ]);
                    }
                }
                $message_title="Berhasil !";
                $message_content= $request->nik." ".$request->nama_karyawan." Berhasil Dibuat";
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

    public function detail($nik)
    {
        $biodata_karyawan = $this->hrga_biodata_karyawan->where('nik',$nik)->first();
        // $status_kerjas = $this->$hrga_status_kerja->where('hrga_biodata_karyawan_id',$biodata_karyawan->id)->get();
        
        if ($biodata_karyawan->status_kerja->isEmpty()) {
            $data_status_kerja = null;
        }else{
            foreach ($biodata_karyawan->status_kerja as $key => $status_kerja) {
                $data_status_kerja[] = [
                    'pk' => $status_kerja->pk,
                    'ke' => $status_kerja->ke,
                    'tgl_mulai' => Carbon::create($status_kerja->tgl_mulai)->format('d-m-Y'),
                ];
            }
        }

        if ($biodata_karyawan->riwayat_konseling->isEmpty()) {
            $data_riwayat_konseling = null;
        }else{
            foreach ($biodata_karyawan->riwayat_konseling as $key => $riwayat_konseling) {
                $data_riwayat_konseling[] = [
                    'no' => $key+1,
                    'data' => $riwayat_konseling->riwayat_konseling,
                ];
            }
        }

        if ($biodata_karyawan->riwayat_training->isEmpty()) {
            $data_riwayat_training = null;
        }else{
            foreach ($biodata_karyawan->riwayat_training as $key => $riwayat_training) {
                $data_riwayat_training[] = [
                    'no' => $key+1,
                    'data' => $riwayat_training->riwayat_training,
                ];
            }
        }

        if (empty($biodata_karyawan->log_posisi)) {
            $masa_kerja = '-';
            $tanggal_masuk = '-';
        }else{
            // Masa Kerja
            $awal = new DateTime($biodata_karyawan->log_posisi->tanggal);
            $akhir = new DateTime();
            $diff = $awal->diff($akhir);
            $masa_kerja = $diff->y.' Tahun '.$diff->m.' Bulan '.$diff->d.' Hari';
            $tanggal_masuk = Carbon::create($biodata_karyawan->log_posisi->tanggal)->format('d-m-Y');
        }

        if (empty($biodata_karyawan->foto_karyawan)) {
            if ($biodata_karyawan->jenis_kelamin == 'Laki - Laki') {
                $foto_karyawan = asset('public/berkas/HRGA/data_karyawan/office-worker-man.png');
            }else{
                $foto_karyawan = asset('public/berkas/HRGA/data_karyawan/businesswoman.png');
            }
        }else{
            $foto_karyawan = asset('public/berkas/HRGA/data_karyawan/'.$biodata_karyawan->foto_karyawan);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $biodata_karyawan->id,
                'nik' => $biodata_karyawan->nik,
                'nama_karyawan' => $biodata_karyawan->biodata_karyawan->nama,
                'tempat_lahir' => $biodata_karyawan->tempat_lahir,
                'tanggal_lahir' => $biodata_karyawan->tanggal_lahir,
                'tempat_tanggal_lahir' => $biodata_karyawan->tempat_lahir.', '.Carbon::create($biodata_karyawan->tanggal_lahir)->isoFormat('LL'),
                'jenis_kelamin' => $biodata_karyawan->jenis_kelamin,
                'alamat' => $biodata_karyawan->alamat,
                'email' => $biodata_karyawan->email,
                'no_urut_level' => $biodata_karyawan->no_urut_level,
                'no_urut_departemen' => $biodata_karyawan->no_urut_departemen,
                'no_telepon' => $biodata_karyawan->no_telepon,
                'status_keluarga' => $biodata_karyawan->status_keluarga,
                'golongan_darah' => $biodata_karyawan->golongan_darah,
                'pendidikan' => $biodata_karyawan->pendidikan,
                'no_npwp' => $biodata_karyawan->no_npwp,
                'no_bpjs_ketenagakerjaan' => $biodata_karyawan->no_bpjs_ketenagakerjaan,
                'no_bpjs_kesehatan' => $biodata_karyawan->no_bpjs_kesehatan,
                'no_rekening_mandiri' => $biodata_karyawan->no_rekening_mandiri,
                'no_rekening_bws' => $biodata_karyawan->no_rekening_bws,
                'departemen_dept' => $biodata_karyawan->departemen_dept,
                'departemen_bagian' => $biodata_karyawan->departemen_bagian,
                'departemen_level' => $biodata_karyawan->departemen_level,
                'kunci_loker' => $biodata_karyawan->kunci_loker,
                'status_karyawan' => $biodata_karyawan->status_karyawan,
                'foto_karyawan' => $foto_karyawan,
                'tanggal_masuk' => $tanggal_masuk,
                'masa_kerja' => $masa_kerja,
                'status_kerja' => $data_status_kerja,
                'riwayat_konseling' => $data_riwayat_konseling,
                'riwayat_training' => $data_riwayat_training,
                // 'status_kerja' => $biodata_karyawan->status_kerja
            ]
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'edit_nik' => 'required',
            'edit_tempat_lahir' => 'required',
            'edit_tanggal_lahir' => 'required',
            'edit_jenis_kelamin' => 'required',
            'edit_email' => 'required',
            // 'edit_no_urut_level' => 'required',
            // 'edit_no_urut_departemen' => 'required',
            'edit_no_bpjs_ketenagakerjaan' => 'required',
            'edit_no_bpjs_kesehatan' => 'required',
            'edit_no_rekening_mandiri' => 'required',
            'edit_no_rekening_bws' => 'required',
            'edit_departemen_dept' => 'required',
            'edit_departemen_bagian' => 'required',
            'edit_departemen_level' => 'required',
            'edit_status_keluarga' => 'required',
            'edit_golongan_darah' => 'required',
            'edit_pendidikan' => 'required',
            'edit_kunci_loker' => 'required',
            'edit_status_karyawan' => 'required',
            // 'foto_karyawan' => 'required',
        ];

        $messages = [
            'edit_nik.required'  => 'NIK wajib diisi.',
            'edit_tempat_lahir.required'  => 'Tempat Lahir wajib diisi.',
            'edit_tanggal_lahir.required'  => 'Tanggal Lahir wajib diisi.',
            'edit_jenis_kelamin.required'  => 'Jenis Kelamin wajib diisi.',
            'edit_email.required'  => 'Email wajib diisi.',
            // 'edit_no_urut_level.required'  => 'No. Urut Level wajib diisi.',
            // 'edit_no_urut_departemen.required'  => 'No. Urut Departemen wajib diisi.',
            'edit_no_bpjs_ketenagakerjaan.required'  => 'No. Bpjs Ketenagakerjaan wajib diisi.',
            'edit_no_bpjs_kesehatan.required'  => 'No. Bpjs Kesehatan wajib diisi.',
            'edit_no_rekening_mandiri.required'  => 'No. Rekening Mandiri wajib diisi.',
            'edit_no_rekening_bws.required'  => 'No. Rekening BWS wajib diisi.',
            'edit_departemen_dept.required'  => 'Departemen wajib diisi.',
            'edit_departemen_bagian.required'  => 'Departemen Bagian wajib diisi.',
            'edit_departemen_level.required'  => 'Departemen Level wajib diisi.',
            'edit_status_keluarga.required'  => 'Status Keluarga wajib diisi.',
            'edit_golongan_darah.required'  => 'Status Keluarga wajib diisi.',
            'edit_pendidikan.required'  => 'Pendidikan wajib diisi.',
            'edit_kunci_loker.required'  => 'Kunci Loker wajib diisi.',
            'edit_status_karyawan.required'  => 'Status Karyawan wajib diisi.',
            // 'foto_karyawan.required'  => 'Upload Foto wajib diisi.',
            // 'foto_karyawan.size'  => 'File Upload Foto maksimal 2 MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $biodata_karyawan = $this->hrga_biodata_karyawan->where('nik',$request->edit_nik)->first();
            $input['tempat_lahir'] = $request->edit_tempat_lahir;
            $input['tanggal_lahir'] = $request->edit_tanggal_lahir;
            $input['jenis_kelamin'] = $request->edit_jenis_kelamin;
            $input['alamat'] = $request->edit_alamat;
            $input['no_npwp'] = $request->edit_no_npwp;
            $input['no_telepon'] = $request->edit_no_telepon;
            $input['email'] = $request->edit_email;
            // $input['no_urut_level'] = $request->edit_no_urut_level;
            // $input['no_urut_departemen'] = $request->edit_no_urut_departemen;
            $input['no_bpjs_ketenagakerjaan'] = $request->edit_no_bpjs_ketenagakerjaan;
            $input['no_bpjs_kesehatan'] = $request->edit_no_bpjs_kesehatan;
            $input['no_rekening_mandiri'] = $request->edit_no_rekening_mandiri;
            $input['no_rekening_bws'] = $request->edit_no_rekening_bws;
            $input['departemen_dept'] = $request->edit_departemen_dept;
            $input['departemen_bagian'] = $request->edit_departemen_bagian;
            $input['departemen_level'] = $request->edit_departemen_level;
            $input['status_keluarga'] = $request->edit_status_keluarga;
            $input['golongan_darah'] = $request->edit_golongan_darah;
            $input['pendidikan'] = $request->edit_pendidikan;
            $input['kunci_loker'] = $request->edit_kunci_loker;
            $input['status_karyawan'] = $request->edit_status_karyawan;

            if ($request->file('edit_foto_karyawan')) {
                if (File::exists('berkas/HRGA/data_karyawan/'.$biodata_karyawan->foto_karyawan)) {
                    File::delete(public_path('berkas/HRGA/data_karyawan/'.$biodata_karyawan->foto_karyawan));
                }

                $file = $request->file('edit_foto_karyawan');
                $fileName = $request->edit_nik.'_'.Str::slug($request->edit_nama_karyawan).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('berkas/HRGA/data_karyawan'), $fileName);
                $input['foto_karyawan'] = $fileName;
            }

            $biodata_karyawan->update($input);

            if($biodata_karyawan){
                $message_title="Berhasil !";
                $message_content= $request->edit_nik." ".$request->edit_nama_karyawan." Berhasil Diupdate";
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

    public function detail_kontrak_kerja(Request $request, $nik)
    {
        $data = $this->hrga_biodata_karyawan->where('nik',$nik)
                                            ->first();
        
        foreach ($data->status_kerja as $key => $value) {
            $data_status_kerja[] = [
                'id' => $value->id,
                'pk' => $value->pk,
                'ke' => $value->ke,
                'tgl_mulai' => $value->tgl_mulai,
            ];
        }
        return response()->json([
            'success' => true,
            'data' => $data_status_kerja
        ]);
    }

    public function kontrak_kerja_simpan(Request $request)
    {
        $rules = [
            'kontrak_kerja_pk' => 'required',
            'kontrak_kerja_ke' => 'required',
            'kontrak_kerja_tanggal_mulai' => 'required',
        ];

        $messages = [
            'kontrak_kerja_pk.required'  => 'PK wajib diisi.',
            'kontrak_kerja_ke.required'  => 'Ke wajib diisi.',
            'kontrak_kerja_tanggal_mulai.required'  => 'Tanggal Mulai wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $no = $this->hrga_status_kerja->count();
            $input['id'] = $no+1;
            $input['hrga_biodata_karyawan_id'] = $request->kontrak_id;
            $input['pk'] = $request->kontrak_kerja_pk;
            $input['ke'] = $request->kontrak_kerja_ke;
            $input['tgl_mulai'] = $request->kontrak_kerja_tanggal_mulai;

            $kontrak_kerja = $this->hrga_status_kerja->create($input);

            if($kontrak_kerja){
                $message_title="Berhasil !";
                $message_content= "Kontrak Karyawan Berhasil Dibuat";
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

    public function riwayat_konseling_simpan(Request $request)
    {
        $rules = [
            'nama_riwayat_konseling' => 'required',
        ];

        $messages = [
            'nama_riwayat_konseling.required'  => 'Riwayat Konseling wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $no = $this->hrga_riwayat_konseling->count();
            $input['id'] = $no+1;
            $input['hrga_biodata_karyawan_id'] = $request->riwayat_konseling_id;
            $input['riwayat_konseling'] = $request->nama_riwayat_konseling;

            $riwayat_konseling = $this->hrga_riwayat_konseling->create($input);

            if($riwayat_konseling){
                $message_title="Berhasil !";
                $message_content= "Riwayat Konseling Karyawan Berhasil Dibuat";
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

    public function cek_riwayat_training_karyawan($nama)
    {
        $riwayat_training_karyawans = $this->rekap_pelatihan_seminar_peserta->with('hrga_rekap_pelatihan_karyawan')->where('peserta',$nama)->get();
        if ($riwayat_training_karyawans->isEmpty()) {
            $data = null;
        }else{
            foreach ($riwayat_training_karyawans as $key => $riwayat_training_karyawan) {
                $explode_tanggal = explode(',',$riwayat_training_karyawan->hrga_rekap_pelatihan_karyawan->tanggal);
                $data[] = [
                    'no' => $key+1,
                    'nama_pelatihan' => $riwayat_training_karyawan->hrga_rekap_pelatihan_karyawan->tema.'|'.Carbon::create($explode_tanggal[0])->format('d-m-Y H:i')
                ];
            }
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function riwayat_training_simpan(Request $request)
    {
        $no = $this->hrga_riwayat_training->count();
        
        if (empty($request->nama_riwayat_training)) {
            foreach ($request->riwayat_training as $key => $value) {
                // $data[] = [
                //     'id' => $no+$key+1,
                //     'hrga_biodata_karyawan_id' => $request->riwayat_training_id,
                //     'riwayat_training' => $value
                // ];
                // if ($value != null) {
                //     $riwayat_training_simpan = $this->hrga_riwayat_training->updateOrCreate(
                //         [
                //             'hrga_biodata_karyawan_id' => $request->riwayat_training_id,
                //         ],
                //         [
                //             'id' => $no+$key+1,
                //             'riwayat_training' => $value
                //         ]
                //     );
                // }

                // $riwayat_training_simpan = $this->hrga_riwayat_training->updateOrCreate(
                //     [
                //         'hrga_biodata_karyawan_id' => $request->riwayat_training_id,
                //         'riwayat_training' => $value
                //     ],
                //     [
                //         'id' => $no+$key+1,
                //         // 'riwayat_training' => $value
                //     ]
                // );

                $riwayat_training_simpan = $this->hrga_riwayat_training->firstOrCreate(
                    [
                        'hrga_biodata_karyawan_id' => $request->riwayat_training_id,
                        'riwayat_training' => $value
                    ],[
                        'id' => $no+$key+1,
                        'hrga_biodata_karyawan_id' => $request->riwayat_training_id,
                        'riwayat_training' => $value
                    ]
                );
                // $cek_riwayat_training = $this->hrga_riwayat_training->where('hrga_biodata_karyawan_id',$request->riwayat_training_id)
                //                             ->where('riwayat_training',$value)
                //                             ->first();
                // if (empty($cek_riwayat_training)) {
                //     $riwayat_training_simpan = $this->hrga_riwayat_training->create(
                //         [
                //             'id' => $no+$key+1,
                //             'hrga_biodata_karyawan_id' => $request->riwayat_training_id,
                //             'riwayat_training' => $value
                //         ]
                //     );
                // }else{
                //     $message_title="Warning !";
                //     $message_content= "Riwayat Training Sudah Dibuat";
                //     $message_type="warning";
                //     $message_succes = false;

                //     $array_message = array(
                //         'success' => $message_succes,
                //         'message_title' => $message_title,
                //         'message_content' => $message_content,
                //         'message_type' => $message_type,
                //     );

                //     return response()->json($array_message);
                // }
            }
        }else{
            $riwayat_training_simpan = $this->hrga_riwayat_training->create([
                'id' => $no+1,
                'hrga_biodata_karyawan_id' => $request->riwayat_training_id,
                'riwayat_training' => $request->nama_riwayat_training
            ]);
        }

        if ($riwayat_training_simpan) {
            $message_title="Berhasil !";
            $message_content= "Riwayat Training Berhasil Dibuat";
            $message_type="success";
            $message_succes = true;

            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
            );

            return response()->json($array_message);
        }

        return response()->json([
            'success' => false,
            'message_title' => 'Gagal',
            'message_content' => 'Riwayat Training Tidak Berhasil Disimpan'
        ]);

        // return $data;
    }

    public function resign_simpan(Request $request)
    {
        $rules = [
            'resign_tanggal_resign' => 'required'
        ];

        $messages = [
            'resign_tanggal_resign.required' => 'Tanggal Resign wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $biodata_karyawan = $this->hrga_biodata_karyawan->where('nik',$request->resign_nik)->first();
            
            if (empty($biodata_karyawan)) {
                return response()->json([
                    'success' => false,
                    'message_title' => 'Gagal',
                    'message_content' => 'Data Karyawan Tidak Ditemukan'
                ]);
            }
    
            $no = $this->hrga_karyawan_resign->max('id');
            $input['id'] = $no+1;
            $input['hrga_biodata_karyawan_id'] = $biodata_karyawan->id;
            $input['tanggal_resign'] = $request->resign_tanggal_resign;
            $biodata_karyawan->update([
                'status_karyawan' => 'T'
            ]);
            $karyawan_resign = $this->hrga_karyawan_resign->create($input);
    
            if($karyawan_resign){
                $message_title="Berhasil !";
                $message_content= $biodata_karyawan->nik." Berhasil Dibuat";
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

    public function download_rekap_excel($tanggal)
    {
        // $data['hrga_biodata_karyawans'] = $this->hrga_biodata_karyawan->all();
        // dd(LogPosisi::where('nik','2103484')->first());
        
        $data['tanggal'] = Carbon::create($tanggal)->format('d-m-Y');
        // Database Aktif
        // $data['departemens'] = $this->hrga_biodata_karyawan->select('departemen_dept')
        //                             // ->whereHas('log_posisi', function($query) use($tanggal) {
        //                             //     return $query->where('log_posisi.tanggal',$tanggal);
        //                             // })
        //                             ->leftJoin('itic_emp.log_posisi','itic_emp.log_posisi.nik','=','hrga_biodata_karyawan.nik')
        //                             // ->leftJoin('hrga_karyawan_resign','hrga_karyawan_resign.hrga_biodata_karyawan_id','=','hrga_biodata_karyawan.id')
        //                             ->where('itic_emp.log_posisi.tanggal','<=',$tanggal)
        //                             // ->where('hrga_karyawan_resign.tanggal_resign','<=',$tanggal)
        //                             // ->where('hrga_karyawan_resign.hrga_biodata_karyawan_id','=','hrga_biodata_karyawan.id')
        //                             // ->where('itic_emp.log_posisi.nik','hrga_biodata_karyawan.nik')
        //                             // ->where('hrga_biodata_karyawan.status_karyawan','Y')
        //                             ->groupBy('hrga_biodata_karyawan.departemen_dept')
        //                             ->orderBy('hrga_biodata_karyawan.departemen_dept','asc')
        //                             ->get();
        // dd($data);
        // return view('hrga.excel.download_rekap_excel',$data);
        // return Excel::download(new RekapDataKaryawanAktifExcel($tanggal), 'Rekap Data Karyawan PT Indonesian Tobacco Tbk Periode '.$tanggal.'.xlsx');
        
        // $data['start_year'] = Carbon::create($tanggal)->startOfYear()->format('Y-m');
        // $data['end_year'] = Carbon::create($tanggal)->endOfYear()->format('Y-m');

        // $data['karyawan_resigns'] = $this->hrga_karyawan_resign->where('tanggal_resign','<=', $tanggal)
        //                                                         ->get();
        // dd($data);
        // dd(Carbon::create($tanggal)->startOfYear());
        // dd(Carbon::create($tanggal)->endOfYear());
        // dd(Carbon::now()->endOfYear());

        // dd($data);
        // return view('hrga.excel.download_rekap_excel_non_aktif',$data);
        return Excel::download(new SheetRekapDataKaryawanExcel($tanggal), 'Rekap Data Karyawan PT Indonesian Tobacco Tbk Periode '.$tanggal.'.xlsx');
        // return Excel::download(new RekapDataKaryawanNonAktifExcel($tanggal), 'Rekap Data Karyawan PT Indonesian Tobacco Tbk Periode '.$tanggal.'.xlsx');
    }

    public function rekap_pelatihan(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->rekap_pelatihan->all();
            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('tema', function($row){
                                $datelive = Carbon::now()->addDay($this->day)->format('Y-m-d H:i');
                                $explode_tanggal = explode(',',$row->tanggal);
                                // $explode_tanggal_2 = explode('#',$row->tanggal);
                                if (strtotime($datelive) < strtotime($explode_tanggal[0])) {
                                    return substr($row->tema,0,50);
                                }
                                elseif (strtotime($datelive) >= strtotime($explode_tanggal[0]) && strtotime($datelive) <= strtotime($explode_tanggal[1])) {
                                    // return '<span class="badge bg-warning"><i class="mdi mdi-file-table-outline"></i> '.'ON PROCESS'.'</span>';
                                    return substr($row->tema,0,50);
                                }else{
                                    if ($row->status != 'Done') {
                                        return substr($row->tema,0,50).'<a href="javascript:void()" onclick="update_canvas(`'.$row->id.'`)" class="btn btn-link"><i class="dripicons-warning"></i> Perbarui Total Jam Pelatihan</a>';
                                    }else{
                                        return substr($row->tema,0,50);
                                    }
                                }
                            })
                            ->addColumn('tanggal', function($row){
                                $explode_tanggal = explode(',',$row->tanggal);
                                if ($row->check_date == 'yes') {
                                    return Carbon::create($explode_tanggal[0])->format('d').' , '.Carbon::create($explode_tanggal[1])->isoFormat('LL');
                                }else{
                                    if (Carbon::create($explode_tanggal[0])->format('Y-m-d') == Carbon::create($explode_tanggal[1])->format('Y-m-d')) {
                                        return Carbon::create($explode_tanggal[1])->isoFormat('LL');
                                    }else{
                                        return Carbon::create($explode_tanggal[0])->format('d').' - '.Carbon::create($explode_tanggal[1])->isoFormat('LL');
                                    }
                                }
                            })
                            ->addColumn('status', function($row){
                                $datelive = Carbon::now()->addDay($this->day)->format('Y-m-d H:i');
                                $explode_tanggal = explode(',',$row->tanggal);
                                if (strtotime($datelive) < strtotime($explode_tanggal[0])) {
                                    return '<span class="badge bg-primary"><i class="mdi mdi-file-table-outline"></i> '.'PLAN'.'</span>';
                                }
                                elseif (strtotime($datelive) >= strtotime($explode_tanggal[0]) && strtotime($datelive) <= strtotime($explode_tanggal[1])) {
                                    return '<span class="badge bg-warning"><i class="mdi mdi-file-table-outline"></i> '.'ON PROCESS'.'</span>';
                                }else{
                                    return '<span class="badge bg-success"><i class="mdi mdi-check-box-outline"></i> '.'SELESAI'.'</span>';
                                }
                            })
                            ->addColumn('status_rekap', function($row){
                                
                            })
                            ->addColumn('action', function($row){
                                $btn = '<div class="btn-group">';
                                $btn.= '<button type="button" onclick="perbarui(`'.$row->id.'`)" class="btn btn-primary btn-icon">
                                            <i class="fa fa-upload"></i> Perbarui Pelatihan Karyawan
                                        </button>';
                                $btn.= '</div>';
                                return $btn;
                            })
                            ->rawColumns(['action','status'])
                            ->make(true);
        }
        return view('hrga.rekap_pelatihan.index');
    }

    public function rekap_pelatihan_detail($id)
    {
        $rekap_pelatihan = $this->rekap_pelatihan->find($id);
        if (empty($rekap_pelatihan)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data tidak ditemukan'
            ]);
        }

        $rekap_pelatihan_seminar_peserta = $this->rekap_pelatihan_seminar_peserta->where('rekap_pelatihan_seminar_id',$rekap_pelatihan->id)
                                                                                ->where('peserta','!=','Shirley Suwantinna')
                                                                                ->get();
        // dd($rekap_pelatihan_seminar_peserta);
        foreach ($rekap_pelatihan_seminar_peserta as $key => $rpsp) {
            $nik_karyawan = $this->biodata_karyawan->select('nik','nama')->where('nama',$rpsp->peserta)
                                                    ->where('status_karyawan','!=','R')
                                                    ->first();
            $hrga_biodata_karyawan = $this->hrga_biodata_karyawan->select('id','nik')->where('nik',$nik_karyawan->nik)->first();
            $hrga_riwayat_training = $this->hrga_riwayat_training->where('hrga_biodata_karyawan_id',$hrga_biodata_karyawan->id)
                                                                ->where('riwayat_training',$rpsp->rekap_pelatihan_seminar_detail->tema)
                                                                ->first();
            if (empty($hrga_riwayat_training)) {
                $to = "<i class='mdi mdi-arrow-right-bold-circle-outline'></i>";
            }else{
                $to = "<i class='mdi mdi-check-circle-outline' style='color: green'></i>";
            }

            $data_peserta[] = [
                'id' => $rpsp->id,
                'rekap_pelatihan_seminar_id' => $rpsp->rekap_pelatihan_seminar_id,
                'id_biodata_karyawan' => $hrga_biodata_karyawan->id,
                'riwayat_training' => $rpsp->rekap_pelatihan_seminar_detail->tema,
                'peserta' => $rpsp->peserta,
                'to' => $to
            ];
        }

        return [
            'id' => $rekap_pelatihan->id,
            'tema' => $rekap_pelatihan->tema,
            'kategori_pelatihan' => $rekap_pelatihan->kategori_pelatihan,
            'penyelenggara' => $rekap_pelatihan->penyelenggara,
            'jenis' => $rekap_pelatihan->jenis,
            'jml_hari' => $rekap_pelatihan->jml_hari,
            'jml_jam_dlm_hari' => $rekap_pelatihan->jml_jam_dlm_hari,
            'total_peserta' => $rekap_pelatihan->total_peserta,
            'periode' => $rekap_pelatihan->periode,
            'data_peserta' => $data_peserta
        ];
    }

    public function rekap_pelatihan_detail_simpan(Request $request)
    {
        $id_hrga_riwayat_training = $this->hrga_riwayat_training->max('id');
        foreach ($request->id_hrga_biodata_karyawan as $key => $value) {
            // $data[] = [
            //     'id' => $id_hrga_riwayat_training+$key+1,
            //     'hrga_biodata_karyawan_id' => $value,
            //     'riwayat_training' => $request->riwayat_training[$key]
            // ];
            $this->hrga_riwayat_training->firstOrCreate(
                [
                    'hrga_biodata_karyawan_id' => $value,
                    'riwayat_training' => $request->riwayat_training[$key]
                ],
                [
                    'id' => $id_hrga_riwayat_training+$key+1,
                    'hrga_biodata_karyawan_id' => $value,
                    'riwayat_training' => $request->riwayat_training[$key]
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Rekap Pelatihan / Seminar Karyawan Berhasil Diperbarui',
            'message_type' => 'success'
        ]);
        // dd($data);
        // dd($request->all());
    }
}
