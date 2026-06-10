@extends('layouts.absensi.new.master')
@section('title')
    Presensi Karyawan
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('public/absensi/new/') }}/css/vendor/bootstrap-datepicker3.standalone.min.css" />
@endsection
@section('content')
    <div class="page-title-container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h1 class="mb-0 pb-0 display-4" id="title">Presensi Karyawan</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="{{ route('absensi.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('presensi.index') }}">Presensi Karyawan
                                Kerja</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('presensi.search') }}" method="get">
                <legend style="font-size: 12pt">Filter:</legend>
                <div class="row gx-3 gy-2 align-items-center">
                    <div class="col-sm-2">
                        <label class="visually-hidden">NIK / Nama Karyawan</label>
                        <input type="text" name="nik_nama" class="form-control" placeholder="NIK / Nama Karyawan"
                            value="{{ !empty(request('nik_nama')) ? request('nik_nama') : null }}">
                    </div>
                    <div class="col-sm-2">
                        <label class="visually-hidden">Departemen</label>
                        <select name="departemen" class="form-select" id="">
                            <option value="">-- Pilih Departemen --</option>
                            @foreach ($departemens as $departemen)
                                <option value="{{ $departemen->id }}"
                                    {{ !empty(request('departemen') == $departemen->id) ? 'selected' : null }}>
                                    {{ $departemen->nama_departemen }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label class="visually-hidden">Tanggal</label>
                        {{-- <input type="date" name="tanggal" class="form-control"
                            value="{{ !empty(request('tanggal')) ? request('tanggal') : null }}"> --}}
                        <div class="input-daterange input-group" id="datePickerRange">
                            <input type="text" class="form-control" name="cari_tanggal_awal" placeholder="Mulai Tanggal"
                                value="{{ !empty(request('cari_tanggal_awal')) ? request('cari_tanggal_awal') : null }}" />
                            <span class="mx-2"></span>
                            <input type="text" class="form-control" name="cari_tanggal_akhir"
                                placeholder="Berakhir Tanggal"
                                value="{{ !empty(request('cari_tanggal_akhir')) ? request('cari_tanggal_akhir') : null }}" />
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Presensi Karyawan</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Karyawan</th>
                            @foreach ($weeks as $week)
                                @php
                                    $tanggal = \Carbon\Carbon::create($week);
                                @endphp
                                <td class="text-center">
                                    @if ($week == \Carbon\Carbon::create($week)->endOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d'))
                                        <div style="font-size: 8pt; color: red">{{ $tanggal->format('d') }}</div>
                                        <div style="font-size: 10pt; font-weight: bold; color: red">
                                            {{ $tanggal->isoFormat('MMM') }}</div>
                                        <div style="font-size: 8pt; color: red">{{ $tanggal->format('Y') }}</div>
                                    @else
                                        <div class="badge {{ $week == date('Y-m-d') ? 'bg-primary' : 'bg-quaternary' }}">
                                            <div style="font-size: 8pt;">{{ $tanggal->format('d') }}</div>
                                            <div style="font-size: 10pt; font-weight: bold;">
                                                {{ $tanggal->isoFormat('MMM') }}</div>
                                            <div style="font-size: 8pt">{{ $tanggal->format('Y') }}</div>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($biodata_karyawans as $biodata_karyawan)
                            @if (!empty($biodata_karyawan->nik))
                                <tr>
                                    <td style="font-size: 10pt">
                                        <a
                                            href="{{ route('presensi.detail', ['nik' => $biodata_karyawan->nik]) }}">{{ $biodata_karyawan->nik . ' - ' . $biodata_karyawan->nama }}</a>
                                    </td>
                                    @foreach ($weeks as $key_week => $week)
                                        @php
                                            $mesin_absensi = $fin_pro
                                                ->select(
                                                    \DB::raw('DATE(scan_date) AS tanggal'),
                                                    'pin as pin',
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
                                                    ->leftJoin(
                                                        'att_status',
                                                        'att_status.status_id',
                                                        '=',
                                                        'att_presensi_info.status',
                                                    )
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
                                                            \Carbon\Carbon::create(
                                                                $presensiKaryawan->scan_date,
                                                            )->format('H:i') .
                                                            '</div>';
                                                        $jam_pulang = '-';
                                                        $status_masuk = $presensiKaryawan->status_masuk;
                                                        $status_pulang = '-';
                                                    } elseif (
                                                        $presensiKaryawan->status == 4 ||
                                                        $presensiKaryawan->status == 10
                                                    ) {
                                                        $jam_masuk = '-';
                                                        $jam_pulang = '-';
                                                        $status_masuk = $presensiKaryawan->status_masuk;
                                                        $status_pulang = $presensiKaryawan->status_pulang;
                                                    } elseif (
                                                        $presensiKaryawan->status == 5 ||
                                                        $presensiKaryawan->status == 6
                                                    ) {
                                                        $jam_masuk = '-';
                                                        $jam_pulang = '-';
                                                        $status_masuk = $presensiKaryawan->status_masuk;
                                                        $status_pulang = $presensiKaryawan->status_pulang;
                                                    } elseif (
                                                        $presensiKaryawan->status == 8 ||
                                                        $presensiKaryawan->status == 9 ||
                                                        $presensiKaryawan->status == 10 ||
                                                        $presensiKaryawan->status == 12
                                                    ) {
                                                        $jam_masuk = '-';
                                                        $jam_pulang = '-';
                                                        $status_masuk = '-';
                                                        $status_pulang = $presensiKaryawan->status_pulang;
                                                    } elseif ($presensiKaryawan->status == 13) {
                                                        $jam_masuk = 'Cuti';
                                                        $jam_pulang = 'Cuti';
                                                        $status_masuk = $presensiKaryawan->status_masuk;
                                                        $status_pulang = $presensiKaryawan->status_pulang;
                                                    } elseif ($presensiKaryawan->status == 14) {
                                                        $jam_masuk = '-';
                                                        $jam_pulang = '-';
                                                        $status_masuk = $presensiKaryawan->status_masuk;
                                                        $status_pulang =
                                                            '<div style="color: red">' .
                                                            $presensiKaryawan->status_pulang .
                                                            '</div>';
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
                                                    ->leftJoin(
                                                        'att_status',
                                                        'att_status.status_id',
                                                        '=',
                                                        'att_presensi_info.status',
                                                    )
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
                                                            \Carbon\Carbon::create(
                                                                $presensiKaryawan->scan_date,
                                                            )->format('H:i') .
                                                            '</div>';
                                                        $jam_pulang = '-';
                                                        $status_masuk =
                                                            '<div style="color: red">' .
                                                            $presensiKaryawan->status_masuk .
                                                            '</div>';
                                                        $status_pulang = '-';
                                                    } elseif (
                                                        $presensiKaryawan->status == 4 ||
                                                        $presensiKaryawan->status == 10
                                                    ) {
                                                        $jam_masuk = '-';
                                                        $jam_pulang = '-';
                                                        $status_masuk = $presensiKaryawan->status_masuk;
                                                        $status_pulang = $presensiKaryawan->status_pulang;
                                                    } elseif (
                                                        $presensiKaryawan->status == 5 ||
                                                        $presensiKaryawan->status == 6
                                                    ) {
                                                        $jam_masuk = '-';
                                                        $jam_pulang = '-';
                                                        $status_masuk = $presensiKaryawan->status_masuk;
                                                        $status_pulang = $presensiKaryawan->status_pulang;
                                                    } elseif (
                                                        $presensiKaryawan->status == 8 ||
                                                        $presensiKaryawan->status == 9 ||
                                                        $presensiKaryawan->status == 10 ||
                                                        $presensiKaryawan->status == 12
                                                    ) {
                                                        $jam_masuk = '-';
                                                        $jam_pulang = '-';
                                                        $status_masuk = '-';
                                                        $status_pulang = $presensiKaryawan->status_pulang;
                                                    } elseif ($presensiKaryawan->status == 13) {
                                                        $jam_masuk = 'Cuti';
                                                        $jam_pulang = 'Cuti';
                                                        $status_masuk = $presensiKaryawan->status_masuk;
                                                        $status_pulang = '-';
                                                    } elseif ($presensiKaryawan->status == 14) {
                                                        $jam_masuk = '-';
                                                        $jam_pulang = '-';
                                                        $status_masuk = $presensiKaryawan->status_masuk;
                                                        $status_pulang =
                                                            '<div style="color: red">' .
                                                            $presensiKaryawan->status_pulang .
                                                            '</div>';
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
                                            }

                                            $awal = strtotime($jam_masuk);
                                            $akhir = strtotime($jam_pulang);

                                            $diff = $akhir - $awal;

                                            $jam = floor($diff / (60 * 60));
                                            $menit = $diff - $jam * (60 * 60);
                                            $detik = $diff % 60;

                                            if (
                                                $week ==
                                                    \Carbon\Carbon::create($week)
                                                        ->endOfWeek(\Carbon\Carbon::SATURDAY)
                                                        ->format('Y-m-d') ||
                                                $week ==
                                                    \Carbon\Carbon::create($week)
                                                        ->endOfWeek(\Carbon\Carbon::SUNDAY)
                                                        ->format('Y-m-d')
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
                                                $total_jam = 0;
                                            } elseif ($awal > 0 && $akhir == 0) {
                                                $total_jam = 0;
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
                                        <td class="text-center" style="font-size: 12pt">
                                            <div
                                                class="badge {{ empty($jam_masuk) || $jam_masuk == '-' ? 'bg-dark' : 'bg-success' }}">
                                                M: {{ $jam_masuk }}</div>
                                            <div
                                                class="badge {{ empty($jam_pulang) || $jam_pulang == '-' ? 'bg-dark' : 'bg-success' }}">
                                                P: {{ $jam_pulang }}</div>
                                            @if ($jam_masuk != null && $jam_pulang != null)
                                                <div class="badge bg-primary">T: {{ $total_jam }} Jam</div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                {{ $biodata_karyawans->links('vendor.pagination.paginationAcorn') }}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/absensi/new/') }}/js/vendor/datepicker/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/js/vendor/datepicker/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/js/forms/controls.datepicker.js"></script>
@endsection
