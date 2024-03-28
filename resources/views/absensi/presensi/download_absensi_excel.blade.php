{{-- <table style="width: 100%;border-collapse: collapse;">
    <tr>
        <th style="width: 25%; padding-bottom: 1%; border: 1px solid;">
            <img src="{{ public_path('itic/icon_itic.png') }}" width="50">
            <div style="font-size: 9pt">PT Indonesian Tobacco Tbk.</div>
        </th>
        <th style="text-transform: uppercase; font-size: 14pt; border: 1px solid;">Rekap Absensi Karyawan</th>
    </tr>
</table>
<div style="margin-top: 1.5%; margin-bottom: 1.5%">
    <table>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $biodata_karyawan->nik }}</td>
        </tr>
        <tr>
            <td>Nama Karyawan</td>
            <td>:</td>
            <td>{{ $biodata_karyawan->nama }}</td>
        </tr>
        <tr>
            <td>Departemen</td>
            <td>:</td>
            <td>{{ $satuan_kerja }}</td>
        </tr>
        <tr>
            <td>Periode</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::create($_GET['cetak_tahun'], $_GET['cetak_bulan'])->isoFormat('MMMM YYYY') }}</td>
        </tr>
    </table>
</div>
<table style="width: 100%;border-collapse: collapse;">
    <thead>
        <tr>
            <th style="border: 1px solid; width: 30%">Tanggal</th>
            <th style="border: 1px solid;">Jam Masuk</th>
            <th style="border: 1px solid; width: 15%">Status</th>
            <th style="border: 1px solid;">Jam Pulang</th>
            <th style="border: 1px solid; width: 15%">Status</th>
            <th style="border: 1px solid;">Total Jam</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($weeks as $week)
        @php
            $fin_pro_masuk = $fin_pro->where('pin',$biodata_karyawan->pin)
                                    ->whereDate('scan_date',$week)
                                    ->whereTime('scan_date','<=','11:59')
                                    ->orderBy('scan_date','desc')
                                    // ->limit($no)
                                    ->first();
            if (empty($fin_pro_masuk)) {
                $presensi_info_masuk = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                    ->whereDate('scan_date',$week)
                                                    ->whereTime('scan_date','<=','11:59')
                                                    ->orderBy('scan_date','desc')
                                                    ->first();
                if (empty($presensi_info_masuk)) {
                    $jam_masuk = '-';
                    $status_masuk = '-';
                }else{
                    if ($presensi_info_masuk->status == 3) {
                        $jam_masuk = \Carbon\Carbon::create($presensi_info_masuk->scan_date)->format('H:i');
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif($presensi_info_masuk->status == 5 || $presensi_info_masuk->status == 6){
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif($presensi_info_masuk->status == 13){
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }
                }
            }else{
                $presensi_info_masuk = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                    ->whereDate('scan_date',$week)
                                                    ->whereTime('scan_date','<=','11:59')
                                                    ->orderBy('scan_date','desc')
                                                    ->first();
                if (empty($presensi_info_masuk)) {
                    $jam_masuk = \Carbon\Carbon::create($fin_pro_masuk->scan_date)->format('H:i');
                    $status_masuk = '-';
                }else{
                    if ($presensi_info_masuk->status == 3) {
                        $jam_masuk = \Carbon\Carbon::create($presensi_info_masuk->scan_date)->format('H:i');
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif($presensi_info_masuk->status == 5 || $presensi_info_masuk->status == 6){
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif($presensi_info_masuk->status == 13){
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }
                }
            }

            $fin_pro_pulang = $fin_pro->where('pin',$biodata_karyawan->pin)
                                    ->whereDate('scan_date',$week)
                                    ->whereTime('scan_date','>=','12:00')
                                    ->orderBy('scan_date','desc')
                                    // ->limit($no)
                                    ->first();

            if (empty($fin_pro_pulang)) {
                $presensi_info_pulang = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                    ->whereDate('scan_date',$week)
                                                    ->whereTime('scan_date','>=','12:00')
                                                    ->orderBy('scan_date','desc')
                                                    ->first();
                if (empty($presensi_info_pulang)) {
                    $jam_pulang = '-';
                    $status_pulang = '-';
                }else{
                    if ($presensi_info_pulang->status == 3) {
                        $jam_pulang = \Carbon\Carbon::create($presensi_info_pulang->scan_date)->format('H:i');
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif ($presensi_info_masuk->status == 4 || $presensi_info_pulang->status == 10) {
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif($presensi_info_pulang->status == 5 || $presensi_info_pulang->status == 6){
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif($presensi_info_pulang->status == 13){
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }
                }
            }else{
                $presensi_info_pulang = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                        ->whereDate('scan_date',$week)
                                                        ->whereTime('scan_date','>=','12:00')
                                                        ->orderBy('scan_date','desc')
                                                        ->first();
                if (empty($presensi_info_pulang)) {
                    $jam_pulang = \Carbon\Carbon::create($fin_pro_pulang->scan_date)->format('H:i');
                    $status_pulang = '-';
                }else{
                    if ($presensi_info_pulang->status == 3) {
                        $jam_pulang = \Carbon\Carbon::create($presensi_info_pulang->scan_date)->format('H:i');
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif ($presensi_info_masuk->status == 4 || $presensi_info_pulang->status == 10) {
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif($presensi_info_pulang->status == 5 || $presensi_info_pulang->status == 6){
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif($presensi_info_pulang->status == 13){
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }
                }
            }

            $awal = strtotime($jam_masuk);
            $akhir = strtotime($jam_pulang);

            $diff = $akhir - $awal;

            $jam = floor($diff / (60 * 60));
            $menit = $diff - $jam * (60 * 60);
            $detik = $diff % 60;

            if (
                $week == \Carbon\Carbon::create($week)->endOfWeek(\Carbon\Carbon::SATURDAY)->format('Y-m-d') ||
                $week == \Carbon\Carbon::create($week)->endOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d')
            ){
                $selisih_jam = $jam . ':' . floor($menit / 60);
            }else{
                $selisih_jam = $jam-1 . ':' . floor($menit / 60);
            }

            if ($awal == 0 && $akhir == 0) {
                $total_jam = 0;
            } elseif ($awal > 0 && $akhir == 0) {
                $total_jam = 0;
            } else {
                $total_jam = $selisih_jam;
            }

            $no ++;
        @endphp
            <tr>
                <td style="border: 1px solid; text-align: center">{{ \Carbon\Carbon::create($week)->isoFormat('dddd, DD MMMM YYYY') }}</td>
                <td style="border: 1px solid; text-align: center"></td>
                <td style="border: 1px solid; text-align: center"></td>
                <td style="border: 1px solid; text-align: center"></td>
                <td style="border: 1px solid; text-align: center"></td>
                <td style="border: 1px solid; text-align: center"></td>
            </tr>
        @endforeach
    </tbody>
</table> --}}

<table>
    <tr>
        <th colspan="6" style="text-align: center; font-size: 18pt; font-weight: bold">Rekap Absensi Karyawan</th>
    </tr>
</table>
<table style="border-collapse: collapse;">
    <tr>
        <td style="border: 1px; border-color: black">NIK</td>
        <td style="text-align: center">:</td>
        <td colspan="4" style="text-align: left">{{ $biodata_karyawan->nik }}</td>
    </tr>
    <tr>
        <td>Nama Karyawan</td>
        <td style="text-align: center">:</td>
        <td colspan="4" style="text-align: left">{{ $biodata_karyawan->nama }}</td>
    </tr>
    <tr>
        <td>Departemen</td>
        <td style="text-align: center">:</td>
        <td colspan="4" style="text-align: left">{{ $satuan_kerja }}</td>
    </tr>
    <tr>
        <td>Periode</td>
        <td style="text-align: center">:</td>
        <td colspan="4" style="text-align: left">{{ \Carbon\Carbon::create($cetak_tahun, $cetak_bulan)->isoFormat('MMMM YYYY') }}</td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th style="border: 1px solid; text-align: center">Tanggal</th>
            <th style="border: 1px solid; text-align: center">Jam Masuk</th>
            <th style="border: 1px solid; text-align: center">Status</th>
            <th style="border: 1px solid; text-align: center">Jam Pulang</th>
            <th style="border: 1px solid; text-align: center">Status</th>
            <th style="border: 1px solid; text-align: center">Total Jam</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($weeks as $week)
        @php
            $fin_pro_masuk = $fin_pro->where('pin',$biodata_karyawan->pin)
                                    ->whereDate('scan_date',$week)
                                    ->whereTime('scan_date','<=','11:59')
                                    ->orderBy('scan_date','desc')
                                    // ->limit($no)
                                    ->first();
            if (empty($fin_pro_masuk)) {
                $presensi_info_masuk = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                    ->whereDate('scan_date',$week)
                                                    ->whereTime('scan_date','<=','11:59')
                                                    ->orderBy('scan_date','desc')
                                                    ->first();
                if (empty($presensi_info_masuk)) {
                    $jam_masuk = '-';
                    $status_masuk = '-';
                }else{
                    if ($presensi_info_masuk->status == 3) {
                        $jam_masuk = \Carbon\Carbon::create($presensi_info_masuk->scan_date)->format('H:i');
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif($presensi_info_masuk->status == 5 || $presensi_info_masuk->status == 6){
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif($presensi_info_masuk->status == 13){
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif($presensi_info_masuk->status == 14){
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }
                }
            }else{
                $presensi_info_masuk = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                    ->whereDate('scan_date',$week)
                                                    ->whereTime('scan_date','<=','11:59')
                                                    ->orderBy('scan_date','desc')
                                                    ->first();
                if (empty($presensi_info_masuk)) {
                    $jam_masuk = \Carbon\Carbon::create($fin_pro_masuk->scan_date)->format('H:i');
                    $status_masuk = '-';
                }else{
                    if ($presensi_info_masuk->status == 3) {
                        $jam_masuk = \Carbon\Carbon::create($presensi_info_masuk->scan_date)->format('H:i');
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif($presensi_info_masuk->status == 5 || $presensi_info_masuk->status == 6){
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif($presensi_info_masuk->status == 13){
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }elseif($presensi_info_masuk->status == 14){
                        $jam_masuk = '-';
                        $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                    }
                }
            }

            $fin_pro_pulang = $fin_pro->where('pin',$biodata_karyawan->pin)
                                    ->whereDate('scan_date',$week)
                                    ->whereTime('scan_date','>=','12:00')
                                    ->orderBy('scan_date','desc')
                                    // ->limit($no)
                                    ->first();

            if (empty($fin_pro_pulang)) {
                $presensi_info_pulang = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                    ->whereDate('scan_date',$week)
                                                    ->whereTime('scan_date','>=','12:00')
                                                    ->orderBy('scan_date','desc')
                                                    ->first();
                if (empty($presensi_info_pulang)) {
                    $jam_pulang = '-';
                    $status_pulang = '-';
                }else{
                    if ($presensi_info_pulang->status == 3) {
                        $jam_pulang = \Carbon\Carbon::create($presensi_info_pulang->scan_date)->format('H:i');
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif ($presensi_info_masuk->status == 4 || $presensi_info_pulang->status == 10) {
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif($presensi_info_pulang->status == 5 || $presensi_info_pulang->status == 6){
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif($presensi_info_pulang->status == 13){
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif($presensi_info_pulang->status == 14){
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }
                }
            }else{
                $presensi_info_pulang = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                        ->whereDate('scan_date',$week)
                                                        ->whereTime('scan_date','>=','12:00')
                                                        ->orderBy('scan_date','desc')
                                                        ->first();
                if (empty($presensi_info_pulang)) {
                    $jam_pulang = \Carbon\Carbon::create($fin_pro_pulang->scan_date)->format('H:i');
                    $status_pulang = '-';
                }else{
                    if ($presensi_info_pulang->status == 3) {
                        $jam_pulang = \Carbon\Carbon::create($presensi_info_pulang->scan_date)->format('H:i');
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif ($presensi_info_masuk->status == 4 || $presensi_info_pulang->status == 10) {
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif($presensi_info_pulang->status == 5 || $presensi_info_pulang->status == 6){
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif($presensi_info_pulang->status == 13){
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }elseif($presensi_info_pulang->status == 14){
                        $jam_pulang = '-';
                        $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                    }
                }
            }

            $awal = strtotime($jam_masuk);
            $akhir = strtotime($jam_pulang);

            $diff = $akhir - $awal;

            $jam = floor($diff / (60 * 60));
            $menit = $diff - $jam * (60 * 60);
            $detik = $diff % 60;

            if (
                $week == \Carbon\Carbon::create($week)->endOfWeek(\Carbon\Carbon::SATURDAY)->format('Y-m-d') ||
                $week == \Carbon\Carbon::create($week)->endOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d')
            ){
                $selisih_jam = $jam . ':' . floor($menit / 60);
            }else{
                $selisih_jam = $jam-1 . ':' . floor($menit / 60);
            }

            if ($awal == 0 && $akhir == 0) {
                $total_jam = 0;
            } elseif ($awal > 0 && $akhir == 0) {
                $total_jam = 0;
            } else {
                $total_jam = $selisih_jam;
            }

            $no ++;
        @endphp
            <tr>
                <td style="border: 1px solid; text-align: center">{{ \Carbon\Carbon::create($week)->isoFormat('dddd, DD MMMM YYYY') }}</td>
                <td style="border: 1px solid; text-align: center">{{ $jam_masuk }}</td>
                <td style="border: 1px solid; text-align: center">{!! $status_masuk !!}</td>
                <td style="border: 1px solid; text-align: center">{{ $jam_pulang }}</td>
                <td style="border: 1px solid; text-align: center">{!! $status_pulang !!}</td>
                <td style="border: 1px solid; text-align: center">{{ $total_jam }}</td>
            </tr>
        @endforeach
    </tbody>
</table>