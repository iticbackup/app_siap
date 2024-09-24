<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinProDevice extends Model
{
    use HasFactory;
    protected $connection= 'fin_pro';
    public $table = 'device';
    public $timestamps = false;

    public $fillable = [
        'sn',
        'activation_code',
        'device_name',
        'dev_id',
        'comm_type',
        'ip_address',
        'id_type',
        'dev_type',
        'comm_key',
        'ethernet_port',
        'layar',
        'alg_ver',
        'use_realtime',
        'group_realtime',
        'ATTLOGStamp',
        'OPERLOGStamp',
        'ATTPHOTOStamp',
        'id_server_use',
    ];

    public function fin_pro_device_type()
    {
        return $this->belongsTo(\App\Models\FinProDeviceType::class, 'id_type', 'id_type');
    }
}
