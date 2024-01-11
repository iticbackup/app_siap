<style>
    html {
        font-family: Arial, Helvetica, sans-serif
    }

    /* table,
    td,
    th {
        border: 1px solid;
    } */

    /* table {
        width: 100%;
        border-collapse: collapse;
    } */
</style>
<title>Rekap Absensi Karyawan - ({{ $biodata_karyawan->nik }}) {{ $biodata_karyawan->nama }} Periode {{ \Carbon\Carbon::create($_GET['cetak_tahun'], $_GET['cetak_bulan'])->isoFormat('MMMM YYYY') }}</title>
<table style="width: 100%;border-collapse: collapse;">
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
            <th style="border: 1px solid;">Tanggal</th>
            <th style="border: 1px solid;">Jam Masuk</th>
            <th style="border: 1px solid;">Jam Pulang</th>
            <th style="border: 1px solid;">Status</th>
            <th style="border: 1px solid;">Total Jam</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($weeks as $week)
            @php
                $presensi_info_masuk = \App\Models\PresensiInfo::where('pin', $biodata_karyawan->pin)
                    ->where('scan_date', 'LIKE', '%' . $week . '%')
                    ->orderBy('scan_date', 'asc')
                    ->first();
                if (empty($presensi_info_masuk)) {
                    $status = '-';
                    $fin_pro_masuk = \App\Models\FinPro::where('scan_date', 'LIKE', '%' . $week . '%')
                        ->where('pin', $biodata_karyawan->pin)
                        ->whereTime('scan_date', '<=', '11:59')
                        ->orderBy('scan_date', 'desc')
                        ->first();
                    if (empty($fin_pro_masuk)) {
                        $jam_masuk = '-';
                    } else {
                        $jam_masuk = \Carbon\Carbon::create($fin_pro_masuk->scan_date)->format('H:i');
                    }
                } else {
                    if ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                        $status = $presensi_info_masuk->presensi_status->status_info;
                    }
                }

                $presensi_info_pulang = \App\Models\PresensiInfo::where('pin', $biodata_karyawan->pin)
                    ->where('scan_date', 'LIKE', '%' . $week . '%')
                    ->orderBy('scan_date', 'desc')
                    ->first();
                if (empty($presensi_info_pulang)) {
                    $status = '-';
                    $fin_pro_pulang = \App\Models\FinPro::where('scan_date', 'LIKE', '%' . $week . '%')
                        ->where('pin', $biodata_karyawan->pin)
                        ->whereTime('scan_date', '>=', '12:00')
                        ->orderBy('scan_date', 'desc')
                        ->first();
                    if (empty($fin_pro_pulang)) {
                        $jam_pulang = '-';
                    } else {
                        $jam_pulang = \Carbon\Carbon::create($fin_pro_pulang->scan_date)->format('H:i');
                    }
                } else {
                    if ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                        $status = $presensi_info_masuk->presensi_status->status_info;
                    }
                }

                $awal = strtotime($jam_masuk);
                $akhir = strtotime($jam_pulang);

                $diff  = $akhir - $awal;

                $jam   = floor($diff / (60 * 60));
                $menit = $diff - ( $jam * (60 * 60) );
                $detik = $diff % 60;

                $selisih_jam = ($jam).':'.floor($menit/60);

                if ($awal == 0  && $akhir == 0) {
                    $total_jam = 0;
                }elseif($awal > 0 && $akhir == 0){
                    $total_jam = 0;
                }else{
                    $total_jam = $selisih_jam;
                }
            @endphp
            <tr>
                <td style="border: 1px solid; text-align: center">{{ \Carbon\Carbon::create($week)->isoFormat('LL') }}</td>
                <td style="border: 1px solid; text-align: center">{{ $jam_masuk }}</td>
                <td style="border: 1px solid; text-align: center">{{ $jam_pulang }}</td>
                <td style="border: 1px solid; text-align: center">{{ $status }}</td>
                <td style="border: 1px solid; text-align: center">{{ $total_jam }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
