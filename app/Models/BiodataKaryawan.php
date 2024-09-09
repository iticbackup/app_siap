<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class BiodataKaryawan extends Model
{
    use HasFactory;
    protected $connection= 'emp';
    protected $primaryKey = 'nik';
    public $table = 'biodata_karyawan';
    public $timestamps = false;
    public $incrementing = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'nik',
        'nama',
        'alamat',
        'id_posisi',
        'id_jabatan',
        'satuan_kerja',
        'rekening',
        'credit',
        'jenis_kelamin',
        'status_klg',
        'npwp',
        'pin',
        'status_karyawan',
        'tempat_lahir',
        'tgl_lahir',
        'kewarganegaraan',
        'agama',
        'status_kontrak',
        'tanggal_resign',
    ];

    // public function satuan_kerjas()
    // {
    //     return $this->belongsTo(\App\Models\IticDepartemen::class, '7');
    // }
    public function hrga_biodata_karyawan()
    {
        return $this->belongsTo(\App\Models\HrgaBiodataKaryawan::class, 'nik','nik');
    }

    public function hrga_biodata_karyawanss()
    {
        return $this->belongsTo(\App\Models\HrgaBiodataKaryawan::class, 'nik','nik');
    }

    public function log_posisi()
    {
        return $this->belongsTo(\App\Models\LogPosisi::class, 'nik','nik');
    }

    public function departemen()
    {
        return $this->belongsTo(\App\Models\IticDepartemen::class, 'satuan_kerja','id_departemen');
    }

    public function posisi()
    {
        return $this->belongsTo(\App\Models\EmpPosisi::class, 'id_posisi','id_posisi');
    }

    public function jabatan()
    {
        return $this->belongsTo(\App\Models\EmpJabatan::class, 'id_jabatan','id_jabatan');
    }

    public function get_fin_pro($date)
    {
        return $this->hasMany(\App\Models\FinPro::class, 'pin','pin')
                    // ->select(
                    //     'scan_date as tanggal',
                    //     ''
                    // )
                    ->where('scan_date','LIKE','%'.$date.'%')
                    // ->WhereTime('scan_date','<=','11:59')
                    // ->orWhereTime('scan_date','>=','12:00')
                    ->orderBy('scan_date','asc')
                    ->get();
    }

    public function fin_pro($date)
    {
        return $this->belongsTo(\App\Models\FinPro::class, 'pin','pin')
                    ->where('scan_date','LIKE','%'.$date.'%')
                    ->first();
    }
}
