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
<title>Rekap Absensi Karyawan - ({{ $biodata_karyawan->nik }}) {{ $biodata_karyawan->nama }} Periode
    {{ \Carbon\Carbon::create($_GET['cetak_tahun'], $_GET['cetak_bulan'])->isoFormat('MMMM YYYY') }}</title>
<table style="width: 100%;border-collapse: collapse;">
    <tr>
        <th style="width: 25%; padding-bottom: 1%; border: 1px solid;">
            <img src="{{ public_path('itic/icon_itic.png') }}" width="30">
            <div style="font-size: 8pt">PT Indonesian Tobacco Tbk.</div>
        </th>
        <th style="text-transform: uppercase; font-size: 10pt; border: 1px solid;">
            <div>Laporan Absensi Karyawan</div>
            <div>Periode
                {{ \Carbon\Carbon::create($_GET['cetak_tahun'], $_GET['cetak_bulan'])->isoFormat('MMMM YYYY') }}</div>
        </th>
    </tr>
</table>
<table style="margin-top: 0.5%; margin-bottom: 0.5%; font-size: 9pt">
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
</table>
<table style="width: 100%; font-size: 8pt; border-collapse: collapse;">
    <tr>
        <td rowspan="2" style="width: 5%;border: 1px solid; text-align: center; font-weight: bold">No</td>
        <td rowspan="2" style="width: 15%; border: 1px solid; text-align: center; font-weight: bold">Tanggal</td>
        <td colspan="2" style="width: 15%; border: 1px solid; text-align: center; font-weight: bold">Masuk</td>
        <td colspan="2" style="width: 15%; border: 1px solid; text-align: center; font-weight: bold">Pulang</td>
        <td rowspan="2" style="width: 15%; border: 1px solid; text-align: center; font-weight: bold">Total Jam</td>
    </tr>
    <tr>
        <td style="border: 1px solid; text-align: center; font-weight: bold">Waktu</td>
        <td style="border: 1px solid; text-align: center; font-weight: bold">Keterangan</td>
        <td style="border: 1px solid; text-align: center; font-weight: bold">Waktu</td>
        <td style="border: 1px solid; text-align: center; font-weight: bold">Keterangan</td>
    </tr>
    @php
        $no = 1;
    @endphp

    @foreach ($weeks as $week)
        @php
            $mesin_absensi = $fin_pro
                ->select(
                    \DB::raw('DATE(scan_date) AS tanggal'),
                    'pin',
                    \DB::raw(
                        "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_masuk",
                    ),
                    \DB::raw(
                        "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_pulang",
                    ),
                )
                ->where('pin', $biodata_karyawan->pin)
                // Menggunakan whereDate() adalah cara yang lebih baik dan aman daripada LIKE untuk memfilter tanggal
                ->whereDate('scan_date', $week)
                ->groupBy(\DB::raw('DATE(scan_date)'), 'pin')
                ->orderBy(\DB::raw('DATE(scan_date)'))
                ->first();

            if (empty($mesin_absensi)) {
                $jam_masuk = '-';
                $jam_pulang = '-';

                $presensiKaryawan = $presensi_info
                    ->select(
                        // \DB::raw('DATE(scan_date) AS tanggal'),
                        'scan_date as scan_date',
                        'att_presensi_info.pin as pin',
                        'att_presensi_info.status as status',
                        \DB::raw(
                            "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN att_status.status_info ELSE NULL END) AS status_masuk",
                        ),
                        \DB::raw(
                            "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_masuk",
                        ),
                        \DB::raw(
                            "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN att_status.status_info ELSE NULL END) AS status_pulang",
                        ),
                        \DB::raw(
                            "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_pulang",
                        ),
                    )
                    ->leftJoin('att_status', 'att_status.status_id', '=', 'att_presensi_info.status')
                    ->where('pin', $biodata_karyawan->pin)
                    // Menggunakan whereDate() adalah cara yang lebih baik dan aman daripada LIKE untuk memfilter tanggal
                    ->whereDate('scan_date', $week)
                    // ->whereTime('scan_date', '<=', '11:59')
                    // ->groupBy(\DB::raw('DATE(scan_date)'), 'pin', 'status')
                    ->groupBy(\DB::raw('scan_date'), 'pin', 'status')
                    ->orderBy(\DB::raw('DATE(scan_date)'))
                    ->first();

                // dd($presensiKaryawan);

                if (empty($presensiKaryawan)) {
                    $jam_masuk = '-';
                    $jam_pulang = '-';
                    $status_masuk = '-';
                    $status_pulang = '-';
                } else {
                    if ($presensiKaryawan->status == 3) {
                        $jam_masuk =
                            '<div style="color: red">' .
                            \Carbon\Carbon::create($presensiKaryawan->scan_date)->format('H:i') .
                            '</div>';
                        $jam_pulang = '-';
                        $status_masuk = $presensiKaryawan->status_masuk;
                        $status_pulang = '-';
                    } elseif ($presensiKaryawan->status == 4 || $presensiKaryawan->status == 10) {
                        $jam_masuk = '-';
                        $jam_pulang = '-';
                        $status_masuk = $presensiKaryawan->status_masuk;
                        $status_pulang = $presensiKaryawan->status_pulang;
                    } elseif ($presensiKaryawan->status == 5 || $presensiKaryawan->status == 6) {
                        $jam_masuk = '-';
                        $jam_pulang = '-';
                        $status_masuk = $presensiKaryawan->status_masuk;
                        $status_pulang = $presensiKaryawan->status_pulang;
                    }elseif($presensiKaryawan->status == 8 || $presensiKaryawan->status == 9 || $presensiKaryawan->status == 10 || $presensiKaryawan->status == 12){
                        $jam_masuk = '-';
                        $jam_pulang = '-';
                        $status_masuk = '-';
                        $status_pulang = $presensiKaryawan->status_pulang;
                    } elseif ($presensiKaryawan->status == 13) {
                        $jam_masuk = '-';
                        $jam_pulang = '-';
                        $status_masuk = $presensiKaryawan->status_masuk;
                        $status_pulang = '-';
                    } elseif ($presensiKaryawan->status == 14) {
                        $jam_masuk = '-';
                        $jam_pulang = '-';
                        $status_masuk = $presensiKaryawan->status_masuk;
                        $status_pulang = '<div style="color: red">' . $presensiKaryawan->status_pulang . '</div>';
                    }
                }
            } else {
                $presensiKaryawan = $presensi_info
                    ->select(
                        // \DB::raw('DATE(scan_date) AS tanggal'),
                        'scan_date as scan_date',
                        'att_presensi_info.pin as pin',
                        'att_presensi_info.status as status',
                        \DB::raw(
                            "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN att_status.status_info ELSE NULL END) AS status_masuk",
                        ),
                        \DB::raw(
                            "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_masuk",
                        ),
                        \DB::raw(
                            "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN att_status.status_info ELSE NULL END) AS status_pulang",
                        ),
                        \DB::raw(
                            "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_pulang",
                        ),
                    )
                    ->leftJoin('att_status', 'att_status.status_id', '=', 'att_presensi_info.status')
                    ->where('pin', $biodata_karyawan->pin)
                    // Menggunakan whereDate() adalah cara yang lebih baik dan aman daripada LIKE untuk memfilter tanggal
                    ->whereDate('scan_date', $week)
                    // ->whereTime('scan_date', '<=', '11:59')
                    // ->groupBy(\DB::raw('DATE(scan_date)'), 'pin', 'status')
                    ->groupBy(\DB::raw('scan_date'), 'pin', 'status')
                    ->orderBy(\DB::raw('DATE(scan_date)'))
                    ->first();

                if (empty($presensiKaryawan)) {
                    $jam_masuk = '-';
                    $jam_pulang = '-';
                    $status_masuk = '-';
                    $status_pulang = '-';
                } else {
                    if ($presensiKaryawan->status == 3) {
                        $jam_masuk =
                            '<div style="color: red">' .
                            \Carbon\Carbon::create($presensiKaryawan->scan_date)->format('H:i') .
                            '</div>';
                        $jam_pulang = '-';
                        $status_masuk = '<div style="color: red">' . $presensiKaryawan->status_masuk . '</div>';
                        $status_pulang = '-';
                    } elseif ($presensiKaryawan->status == 4 || $presensiKaryawan->status == 10) {
                        $jam_masuk = '-';
                        $jam_pulang = '-';
                        $status_masuk = $presensiKaryawan->status_masuk;
                        $status_pulang = $presensiKaryawan->status_pulang;
                    } elseif ($presensiKaryawan->status == 5 || $presensiKaryawan->status == 6) {
                        $jam_masuk = '-';
                        $jam_pulang = '-';
                        $status_masuk = $presensiKaryawan->status_masuk;
                        $status_pulang = $presensiKaryawan->status_pulang;
                    }elseif($presensiKaryawan->status == 8 || $presensiKaryawan->status == 9 || $presensiKaryawan->status == 10 || $presensiKaryawan->status == 12){
                        $jam_masuk = '-';
                        $jam_pulang = '-';
                        $status_masuk = '-';
                        $status_pulang = $presensiKaryawan->status_pulang;
                    } elseif ($presensiKaryawan->status == 13) {
                        $jam_masuk = '-';
                        $jam_pulang = '-';
                        $status_masuk = $presensiKaryawan->status_masuk;
                        $status_pulang = '-';
                    } elseif ($presensiKaryawan->status == 14) {
                        $jam_masuk = '-';
                        $jam_pulang = '-';
                        $status_masuk = $presensiKaryawan->status_masuk;
                        $status_pulang = '<div style="color: red">' . $presensiKaryawan->status_pulang . '</div>';
                    }
                }

            }

            if (empty($mesin_absensi->jam_masuk)) {
                $jam_masuk = '-';
            } else {
                $jam_masuk = $mesin_absensi->jam_masuk;
            }

            if (empty($mesin_absensi->jam_pulang)) {
                $jam_pulang = '-';
            } else {
                $jam_pulang = $mesin_absensi->jam_pulang;
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
            ) {
                if (floor($menit / 60) <= 9) {
                    $selisih_jam = $jam . ':' . '0' . floor($menit / 60);
                } else {
                    $selisih_jam = $jam . ':' . floor($menit / 60);
                }
            } else {
                if (floor($menit / 60) <= 9) {
                    $selisih_jam = $jam - 1 . ':' . '0' . floor($menit / 60);
                } else {
                    $selisih_jam = $jam - 1 . ':' . floor($menit / 60);
                }
            }

            if ($awal == 0 && $akhir == 0) {
                $total_jam = '-';
            } elseif ($awal > 0 && $akhir == 0) {
                $total_jam = '-';
            } else {
                if (empty($jam_masuk) || $jam_masuk == '-') {
                    $total_jam = '-';
                } elseif (empty($jam_pulang) || $jam_pulang == '-') {
                    $total_jam = '-';
                } else {
                    $total_jam = $selisih_jam;
                }
            }
        @endphp
        <tr>
            <td style="border: 1px solid; text-align: center">{{ $no }}</td>
            <td style="border: 1px solid; text-align: center">
                {{ \Carbon\Carbon::create($week)->isoFormat('DD MMMM YYYY') }}</td>
            <td style="border: 1px solid; text-align: center">{!! $jam_masuk !!}</td>
            <td style="border: 1px solid; text-align: center">{!! $status_masuk !!}</td>
            <td style="border: 1px solid; text-align: center">{!! $jam_pulang !!}</td>
            <td style="border: 1px solid; text-align: center">{!! $status_pulang !!}</td>
            <td style="border: 1px solid; text-align: center">{!! $total_jam !!}</td>
        </tr>
        @php
            $no++;
        @endphp
    @endforeach
</table>
