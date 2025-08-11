@extends('layouts.absensi.new.master')
@section('title')
    Dashboard Absensi
@endsection
@section('content')
    @include('absensi.home.modal_detail_absen_masuk')
    @include('absensi.home.modal_detail_absen_keluar')

    @include('absensi.home.modal_jam_non_absen_masuk')
    @include('absensi.home.modal_jam_non_absen_keluar')

    @include('absensi.home.modal_jam_edit_non_absen_masuk')

    <div class="page-title-container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h1 class="mb-0 pb-0 display-4" id="title">Dashboard</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="Dashboards.Default.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="Dashboards.html">Dashboards</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    @php
        $total_masuk = $fin_pro->whereDate('scan_date',date('Y-m-d'))->count();
        $sakit = $presensi_info->whereDate('scan_date',date('Y-m-d'))->where('status',4)->count();
        $izin = $presensi_info->whereDate('scan_date',date('Y-m-d'))->whereIn('status',[5,6])->count();
        $alpa = $presensi_info->whereDate('scan_date',date('Y-m-d'))->where('status',7)->count();
    @endphp
    <div class="row">
        <div class="col-12 col-xl-5">
            <h2 class="small-title">Status Kehadiran Hari Ini &nbsp; {{ \Carbon\Carbon::now()->isoFormat('LLLL') }}</h2>
            <div class="row gx-2">
                <div class="col-sm-6 col-md-3">
                    <div class="card sh-19">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <i data-acorn-icon="alarm" class="text-primary mb-3"></i>
                            <p class="heading mb-1">Total Masuk</p>
                            <p class="text-muted mb-0">{{ $total_masuk }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card sh-19">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <i data-acorn-icon="alarm" class="text-primary mb-3"></i>
                            <p class="heading mb-1">Sakit</p>
                            <p class="text-muted mb-0">{{ $sakit }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card sh-19">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <i data-acorn-icon="alarm" class="text-primary mb-3"></i>
                            <p class="heading mb-1">Izin</p>
                            <p class="text-muted mb-0">{{ $izin }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card sh-19">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <i data-acorn-icon="alarm" class="text-primary mb-3"></i>
                            <p class="heading mb-1">Alpha</p>
                            <p class="text-muted mb-0">{{ $alpa }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h5 class="text-primary">Peringkat Absensi Keseluruhan Per Tahun {{ date('Y') }}</h5>
                <div class="row gx-2">
                    @forelse ($peringkat_absensis as $key => $peringkat_absensi)
                        <div class="col-md-4 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center text-primary" style="font-weight: bold">Peringkat {{ $key+1 }}</div>
                                    <div class="text-center">{{ $peringkat_absensi->biodata_karyawan->nama }}</div>
                                    <div class="text-center">Total Absen : <span class="text-primary">{{ $peringkat_absensi->total_absensi }}</span></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        
                    @endforelse
                </div>
            </div>
            {{-- <div class="card mt-2">
                <div class="card-body">
                    <h5>Peringkat Absensi Per Tahun {{ date('Y') }}</h5>
                    <table class="table table-striped">
                        <thead></thead>
                    </table>
                </div>
            </div> --}}
        </div>
        <div class="col-12 col-xl-7 mb-5">
            <div class="d-flex justify-content-between">
                <h2 class="small-title">Data Absensi</h2>
            </div>
            <fieldset>
                <div class="mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('absensi.search_name') }}" method="get">
                                <legend style="font-size: 12pt">Filter:</legend>
                                <div class="row gx-3 gy-2 align-items-center">
                                    <div class="col-sm-3">
                                        <label class="visually-hidden">NIK / Nama Karyawan</label>
                                        <input type="text" name="nik_nama" class="form-control"
                                            placeholder="NIK / Nama Karyawan"
                                            value="{{ !empty(request('nik_nama')) ? request('nik_nama') : null }}">
                                    </div>
                                    <div class="col-sm-3">
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
                                    <div class="col-sm-3">
                                        <label class="visually-hidden">Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control"
                                            value="{{ !empty(request('tanggal')) ? request('tanggal') : null }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="scroll-out">
                <div class="scroll-by-count" data-count="6">
                    <div class="card mb-2" data-title="Product Card" data-intro="Here is a product card with buttons!"
                        data-step="2">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">NIK</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Departemen</th>
                                        <th class="text-center">Posisi</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Jam Masuk</th>
                                        <th class="text-center">Jam Pulang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biodata_karyawans as $key => $biodata_karyawan)
                                        {{-- @dd($biodata_karyawan->fin_pro_new(date('Y-m-d'))) --}}
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle">
                                                {{ $biodata_karyawan->nik }}</td>
                                            <td class="text-center" style="vertical-align: middle">
                                                {{ $biodata_karyawan->nama }}</td>
                                            <td class="text-center" style="vertical-align: middle">
                                                {{ $biodata_karyawan->nama_departemen }}</td>
                                            <td class="text-center" style="vertical-align: middle">
                                                {{ $biodata_karyawan->nama_posisi }}</td>
                                            @php
                                                $date_live = request('tanggal') ? request('tanggal') : date('Y-m-d');
                                                $mesin_absensi = $fin_pro
                                                    ->select(
                                                        \DB::raw('DATE(scan_date) AS tanggal'),
                                                        'pin AS pin',
                                                        \DB::raw(
                                                            "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i:%s') <= '11:59:59' THEN DATE_FORMAT(scan_date,'%H:%i:%s') ELSE NULL END) AS jam_masuk",
                                                        ),
                                                        \DB::raw(
                                                            "MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i:%s') >= '12:00:00' THEN DATE_FORMAT(scan_date,'%H:%i:%s') ELSE NULL END) AS jam_pulang",
                                                        ),
                                                    )
                                                    ->where('pin', $biodata_karyawan->pin)
                                                    // ->where('scan_date', 'LIKE', '%' . $date_live . '%')
                                                    ->whereDate('scan_date', $date_live)
                                                    // ->whereTime('scan_date', '<=', '11:59:59')
                                                    ->groupBy(\DB::raw('DATE(scan_date)'), 'pin')
                                                    ->orderBy(\DB::raw('DATE(scan_date)'))
                                                    ->first();

                                                // dd($mesin_absensi);

                                                if (empty($mesin_absensi->jam_masuk)) {
                                                    $presensi_info_masuk = $presensi_info
                                                        ->where('scan_date', 'LIKE', '%' . $date_live . '%')
                                                        ->where('pin', $biodata_karyawan->pin)
                                                        ->whereTime('scan_date', '<=', '11:59:59')
                                                        ->first();
                                                    if (empty($presensi_info_masuk)) {
                                                        $jam_masuk =
                                                            '<a type="button" onclick="detail_non_absen_jam_masuk(`' .
                                                            $date_live .
                                                            '`,`' .
                                                            $biodata_karyawan->pin .
                                                            '`,`' .
                                                            // 0 .
                                                            '`)"><i data-acorn-icon="plus" class="text-success"></i></a>';
                                                        // $jam_masuk = '-';
                                                    } else {
                                                        if ($presensi_info_masuk->status == 4) {
                                                            $jam_masuk =
                                                                '<a type="button" onclick="detail_non_absen_jam_masuk(`' .
                                                                $date_live .
                                                                '`,`' .
                                                                $biodata_karyawan->pin .
                                                                '`,`' .
                                                                // 0 .
                                                                '`)" style="color: red">Sakit</a>';
                                                        } elseif ($presensi_info_masuk->status == 7) {
                                                            $jam_masuk =
                                                                '<a type="button" onclick="detail_non_absen_jam_masuk(`' .
                                                                $date_live .
                                                                '`,`' .
                                                                $biodata_karyawan->pin .
                                                                '`,`' .
                                                                // 0 .
                                                                '`)" style="color: purple">Absen</a>';
                                                        } elseif ($presensi_info_masuk->status == 13) {
                                                            $jam_masuk =
                                                                '<a type="button" onclick="detail_non_absen_jam_masuk(`' .
                                                                $date_live .
                                                                '`,`' .
                                                                $biodata_karyawan->pin .
                                                                '`,`' .
                                                                // 0 .
                                                                '`)" style="color: orange">Cuti</a>';
                                                        } else {
                                                            $jam_masuk =
                                                                '<a type="button" class="text-info" onclick="detail_edit_non_absensi_jam_masuk(`' .
                                                                $date_live .
                                                                '`,`' .
                                                                $biodata_karyawan->pin .
                                                                '`,`' .
                                                                '`)">' .
                                                                \Carbon\Carbon::create(
                                                                    $presensi_info_masuk->scan_date,
                                                                )->format('H:i') .
                                                                '</a>';
                                                        }
                                                    }
                                                } else {
                                                    $jam_masuk =
                                                        '<a type="button" onclick="detail_absensi_jam_masuk(`' .
                                                        $mesin_absensi->tanggal .
                                                        ' ' .
                                                        $mesin_absensi->jam_masuk .
                                                        '`,`' .
                                                        $mesin_absensi->pin .
                                                        '`)" class="text-success">' .
                                                        \Carbon\Carbon::create($mesin_absensi->jam_masuk)->format(
                                                            'H:i',
                                                        ) .
                                                        '</a>';
                                                }

                                                if (empty($mesin_absensi->jam_pulang)) {
                                                    $presensi_info_pulang = $presensi_info
                                                        ->where('scan_date', 'LIKE', '%' . $date_live . '%')
                                                        ->where('pin', $biodata_karyawan->pin)
                                                        ->whereTime('scan_date', '>=', '12:00:00')
                                                        ->first();
                                                    if (empty($presensi_info_pulang)) {
                                                        $jam_pulang =
                                                            '<a type="button" onclick="detail_non_absen_jam_keluar(`' .
                                                            $date_live .
                                                            '`,`' .
                                                            $biodata_karyawan->pin .
                                                            '`,`' .
                                                            // 0 .
                                                            '`)"><i data-acorn-icon="plus" class="text-success"></i></a>';
                                                    } else {
                                                        if ($presensi_info_pulang->status == 4) {
                                                            $jam_pulang =
                                                                '<a type="button" onclick="detail_non_absen_jam_keluar(`' .
                                                                $mesin_absensi->tanggal .
                                                                ' ' .
                                                                $mesin_absensi->jam_pulang .
                                                                '`,`' .
                                                                $biodata_karyawan->pin .
                                                                '`,`' .
                                                                // 0 .
                                                                '`)" style="color: red">Sakit</a>';
                                                        } elseif ($presensi_info_pulang->status == 7) {
                                                            $jam_pulang =
                                                                '<a type="button" onclick="detail_non_absen_jam_keluar(`' .
                                                                $mesin_absensi->tanggal .
                                                                ' ' .
                                                                $mesin_absensi->jam_pulang .
                                                                '`,`' .
                                                                $biodata_karyawan->pin .
                                                                '`,`' .
                                                                // 0 .
                                                                '`)" style="color: purple">Absen</a>';
                                                        } elseif ($presensi_info_pulang->status == 13) {
                                                            $jam_pulang =
                                                                '<a type="button" onclick="detail_non_absen_jam_keluar(`' .
                                                                $mesin_absensi->tanggal .
                                                                ' ' .
                                                                $mesin_absensi->jam_pulang .
                                                                '`,`' .
                                                                $biodata_karyawan->pin .
                                                                '`,`' .
                                                                // 0 .
                                                                '`)" style="color: orange">Cuti</a>';
                                                        } else {
                                                            $jam_pulang =
                                                                '<a type="button" onclick="detail_non_absen_jam_keluar(`' .
                                                                $mesin_absensi->tanggal .
                                                                ' ' .
                                                                $mesin_absensi->jam_pulang .
                                                                '`,`' .
                                                                $biodata_karyawan->pin .
                                                                '`,`' .
                                                                // 0 .
                                                                '`)">' .
                                                                $presensi_info_pulang->scan_date .
                                                                '</a>';
                                                        }
                                                    }
                                                } else {
                                                    // $jam_pulang = $mesin_absensi->jam_pulang;
                                                    $jam_pulang =
                                                        '<a type="button" onclick="detail_absensi_jam_keluar(`' .
                                                        $mesin_absensi->tanggal .
                                                        ' ' .
                                                        $mesin_absensi->jam_pulang .
                                                        '`,`' .
                                                        $mesin_absensi->pin .
                                                        '`)" style="color: blue">' .
                                                        \Carbon\Carbon::create($mesin_absensi->jam_pulang)->format(
                                                            'H:i',
                                                        ) .
                                                        '</a>';
                                                }

                                                if (!empty(request('tanggal'))) {
                                                    $tanggal = \Carbon\Carbon::create(request('tanggal'))->isoFormat(
                                                        'DD MMMM YYYY',
                                                    );
                                                } else {
                                                    $tanggal = \Carbon\Carbon::now()->isoFormat('DD MMMM YYYY');
                                                }
                                            @endphp
                                            <td class="text-center">{{ $tanggal }}</td>
                                            <td class="text-center" style="vertical-align: middle">{!! $jam_masuk !!}
                                            </td>
                                            <td class="text-center" style="vertical-align: middle">{!! $jam_pulang !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $biodata_karyawans->links('vendor.pagination.paginationAcorn') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function detail_absensi_jam_masuk(scan_date, pin) {
            $.ajax({
                type: 'GET',
                // url: "{{ url('absensi/absensi_masuk') }}" + '/' + scan_date + '/' + pin + '/' + inoutmode,
                url: "{{ url('absensi/absensi_masuk') }}" + '/' + scan_date + '/' + pin,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        // alert('test');
                        document.getElementById('detail_masuk_nik').innerHTML = result.biodata_karyawan.nik;
                        document.getElementById('detail_masuk_nama_karyawan').innerHTML = result
                            .biodata_karyawan.nama;
                        document.getElementById('detail_masuk_tanggal_masuk').innerHTML = result.data.scan_date;
                        $('#detail_masuk_pin').val(result.data.pin);
                        // $('#detail_masuk_inoutmode').val(result.data.inoutmode);
                        $('#detail_masuk_tanggal_masuk').val(result.data.scan_date);
                        $('#detail_masuk_jam_masuk_status').val(result.data.status);
                        $('#detail_masuk_keterangan_jam_masuk').val(result.data.keterangan);

                        $('#detail_masuk_penyesuaian_masuk_jam_masuk_jam').val(result.data
                            .penyesuaian_masuk_jam);
                        $('#detail_masuk_penyesuaian_masuk_jam_masuk_menit').val(result.data
                            .penyesuaian_masuk_menit);
                        $('#detail_masuk_penyesuaian_istirahat_jam_masuk_jam').val(result.data
                            .penyesuaian_istirahat_jam);
                        $('#detail_masuk_penyesuaian_istirahat_jam_masuk_menit').val(result.data
                            .penyesuaian_istirahat_menit);
                        $('#detail_masuk_penyesuaian_pulang_jam_masuk_jam').val(result.data
                            .penyesuaian_pulang_jam);
                        $('#detail_masuk_penyesuaian_pulang_jam_masuk_menit').val(result.data
                            .penyesuaian_pulang_menit);
                        // document.getElementById('detail_masuk_tanggal_masuk').innerHTML = result.data.scan_date;
                        $('.modalDetailAbsenMasuk').modal('show');
                    } else {
                        document.getElementById('detail_masuk_nik').innerHTML = result.biodata_karyawan.nik;
                        document.getElementById('detail_masuk_nama_karyawan').innerHTML = result
                            .biodata_karyawan.nama;
                        document.getElementById('detail_masuk_tanggal_masuk').innerHTML = result.data.scan_date;
                        $('#detail_masuk_pin').val(result.data.pin);
                        $('#detail_masuk_tanggal_masuk').val(result.data.scan_date);
                        $('.modalDetailAbsenMasuk').modal('show');
                    }
                },
                error: function(request, status, error) {

                }
            });
        }

        function detail_absensi_jam_keluar(scan_date, pin) {
            $.ajax({
                type: 'GET',
                // url: "{{ url('absensi/absensi_keluar') }}" + '/' + scan_date + '/' + pin + '/' + inoutmode,
                url: "{{ url('absensi/absensi_keluar') }}" + '/' + scan_date + '/' + pin,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        // alert('success');
                        document.getElementById('detail_keluar_nik').innerHTML = result.biodata_karyawan.nik;
                        document.getElementById('detail_keluar_nama_karyawan').innerHTML = result
                            .biodata_karyawan.nama;
                        document.getElementById('detail_keluar_tanggal_keluar').innerHTML = result.data
                            .scan_date;
                        $('#detail_keluar_pin').val(result.data.pin);
                        // $('#detail_keluar_inoutmode').val(result.data.inoutmode);
                        $('#detail_keluar_tanggal_keluar').val(result.data.scan_date);
                        $('#detail_keluar_jam_keluar_status').val(result.data.status);
                        $('#detail_keluar_keterangan_jam_keluar').val(result.data.keterangan);

                        $('#detail_keluar_penyesuaian_masuk_jam_keluar_jam').val(result.data
                            .penyesuaian_masuk_jam);
                        $('#detail_keluar_penyesuaian_masuk_jam_keluar_menit').val(result.data
                            .penyesuaian_masuk_menit);
                        $('#detail_keluar_penyesuaian_istirahat_jam_keluar_jam').val(result.data
                            .penyesuaian_istirahat_jam);
                        $('#detail_keluar_penyesuaian_istirahat_jam_keluar_menit').val(result.data
                            .penyesuaian_istirahat_menit);
                        $('#detail_keluar_penyesuaian_pulang_jam_keluar_jam').val(result.data
                            .penyesuaian_pulang_jam);
                        $('#detail_keluar_penyesuaian_pulang_jam_keluar_menit').val(result.data
                            .penyesuaian_pulang_menit);
                        $('.modalDetailAbsenKeluar').modal('show');
                    } else {}
                },
                error: function(request, status, error) {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: error
                    });
                }
            });
        }

        function detail_non_absen_jam_masuk(date_live, pin) {
            $.ajax({
                type: 'GET',
                // url: "{{ url('absensi/jam_masuk') }}" + '/' + date_live + '/' + pin + '/' + inoutmode,
                url: "{{ url('absensi/jam_masuk') }}" + '/' + date_live + '/' + pin,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        $('#pin_non_absen_masuk').val(result.data.pin);
                        // $('#inoutmode_non_absen_masuk').val(result.inoutmode);
                        document.getElementById('jam_masuk_nik').innerHTML = result.data.nik
                        document.getElementById('jam_masuk_nama_karyawan').innerHTML = result.data.nama
                        $('#non_absen_masuk_jam_masuk_tanggal').val(result.tanggal);
                        $('#jam_non_masuk').val(result.jam);
                        $('#menit_non_masuk').val(result.menit);
                        $('#detik_non_masuk').val(result.detik);
                        $('#status_non_absen_masuk').val(result.status);
                        $('#penyesuaian_masuk_jam_masuk_jam_non_absen').val(result.penyesuaian_masuk_jam);
                        $('#penyesuaian_masuk_jam_masuk_menit_non_absen').val(result.penyesuaian_masuk_menit);
                        $('#penyesuaian_istirahat_jam_masuk_jam_non_absen').val(result
                            .penyesuaian_istirahat_jam);
                        $('#penyesuaian_istirahat_jam_masuk_menit_non_absen').val(result
                            .penyesuaian_istirahat_menit);
                        $('#penyesuaian_pulang_jam_masuk_jam_non_absen').val(result.penyesuaian_pulang_jam);
                        $('#penyesuaian_pulang_jam_masuk_menit_non_absen').val(result.penyesuaian_pulang_menit);
                        $('#jam_masuk_keterangan_non_absen').val(result.keterangan);
                        $('.modalJamMasukNonAbsen').modal('show');
                    } else {}
                },
                error: function(request, status, error) {

                }
            });
        }

        function detail_non_absen_jam_keluar(date_live, pin) {
            $.ajax({
                type: 'GET',
                // url: "{{ url('absensi/jam_pulang') }}" + '/' + date_live + '/' + pin + '/' + inoutmode,
                url: "{{ url('absensi/jam_pulang') }}" + '/' + date_live + '/' + pin,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        $('#pin_non_absen_keluar').val(result.data.pin);
                        // $('#inoutmode_non_absen_keluar').val(result.inoutmode);
                        document.getElementById('jam_keluar_nik').innerHTML = result.data.nik
                        document.getElementById('jam_keluar_nama_karyawan').innerHTML = result.data.nama
                        $('#non_absen_keluar_jam_keluar_tanggal').val(result.tanggal);
                        $('#jam_non_keluar').val(result.jam);
                        $('#menit_non_keluar').val(result.menit);
                        $('#detik_non_keluar').val(result.detik);
                        $('#status_non_absen_keluar').val(result.status);
                        $('#penyesuaian_masuk_jam_keluar_jam_non_absen').val(result.penyesuaian_masuk_jam);
                        $('#penyesuaian_masuk_jam_keluar_menit_non_absen').val(result.penyesuaian_masuk_menit);
                        $('#penyesuaian_istirahat_jam_keluar_jam_non_absen').val(result
                            .penyesuaian_istirahat_jam);
                        $('#penyesuaian_istirahat_jam_keluar_menit_non_absen').val(result
                            .penyesuaian_istirahat_menit);
                        $('#penyesuaian_pulang_jam_keluar_jam_non_absen').val(result.penyesuaian_pulang_jam);
                        $('#penyesuaian_pulang_jam_keluar_menit_non_absen').val(result
                            .penyesuaian_pulang_menit);
                        $('#jam_keluar_keterangan_non_absen').val(result.keterangan);
                        $('.modalJamPulangNonAbsen').modal('show');
                    } else {}
                },
                error: function(request, status, error) {

                }
            });
        }

        function detail_edit_non_absensi_jam_masuk(date_live, pin) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/jam_masuk/') }}" + '/' + date_live + '/' + pin,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        // $('#edit_att_rec_non_absen').val(result.att_rec);
                        document.getElementById('edit_jam_masuk_nik').innerHTML = result.data.nik;
                        document.getElementById('edit_jam_masuk_nama_karyawan').innerHTML = result.data.nama
                        $('#edit_pin_non_absen_masuk').val(result.data.pin);
                        $('#edit_non_absen_masuk_jam_masuk_tanggal').val(result.tanggal);
                        $('#edit_non_absen_masuk_jam_masuk_waktu').val(result.jam + ':' + result.menit + ':' +
                            result.detik);
                        $('#edit_non_absen_masuk_jam_masuk_status').val(result.status);
                        $('#edit_penyesuaian_masuk_jam_masuk_jam_non_absen').val(result
                            .penyesuaian_masuk_jam);
                        $('#edit_penyesuaian_masuk_jam_masuk_menit_non_absen').val(result
                            .penyesuaian_masuk_menit);
                        $('#edit_penyesuaian_istirahat_jam_masuk_jam_non_absen').val(result
                            .penyesuaian_istirahat_jam);
                        $('#edit_penyesuaian_istirahat_jam_masuk_menit_non_absen').val(result
                            .penyesuaian_istirahat_menit);
                        $('#edit_penyesuaian_pulang_jam_masuk_jam_non_absen').val(result
                            .penyesuaian_pulang_jam);
                        $('#edit_penyesuaian_pulang_jam_masuk_menit_non_absen').val(result
                            .penyesuaian_pulang_menit);
                        $('#edit_jam_masuk_keterangan_non_absen').val(result.keterangan);
                        $('.modalEditJamMasukNonAbsen').modal('show');
                    } else {
                        jQuery.notify({
                            title: 'Error!',
                            message: result.message_title
                        }, {
                            type: 'danger',
                            showProgressbar: true
                        });
                    }
                },
                error: function(request, status, error) {
                    jQuery.notify({
                        title: 'Error!',
                        message: error
                    }, {
                        type: 'danger',
                        showProgressbar: true
                    });
                }
            });
        }

        $('#form-simpan-jam-masuk-non-absen').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('absensi.input_modal_nofinger_jam_masuk_simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {},
                success: (result) => {
                    if (result.success != false) {
                        jQuery.notify({
                            title: 'Berhasil!',
                            message: result.message_content
                        }, {
                            type: 'success',
                            showProgressbar: true
                        });

                        setTimeout(() => {
                            location.reload();
                            $('.modalJamMasukNonAbsen').modal('hide');
                        }, 5000);
                    } else {
                        jQuery.notify({
                            title: 'Gagal!',
                            message: result.message_content
                        }, {
                            type: 'danger',
                            showProgressbar: true
                        });
                    }
                },
                error: function(request, status, error) {
                    jQuery.notify({
                        title: 'Error!',
                        message: error
                    }, {
                        type: 'danger',
                        showProgressbar: true
                    });
                }
            });
        });

        $('#form-edit-jam-masuk-non-absen').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('absensi.input_modal_nofinger_jam_masuk_update') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {},
                success: (result) => {
                    if (result.success != false) {
                        jQuery.notify({
                            title: 'Berhasil!',
                            message: result.message_content
                        }, {
                            type: 'success',
                            showProgressbar: true
                        });

                        setTimeout(() => {
                            location.reload();
                            $('.modalJamMasukNonAbsen').modal('hide');
                        }, 5000);
                    } else {
                        jQuery.notify({
                            title: 'Gagal!',
                            message: result.message_content
                        }, {
                            type: 'danger',
                            showProgressbar: true
                        });
                    }
                },
                error: function(request, status, error) {
                    jQuery.notify({
                        title: 'Error!',
                        message: error
                    }, {
                        type: 'danger',
                        showProgressbar: true
                    });
                }
            });
        });

        $('#form-simpan-jam-keluar-non-absen').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('absensi.input_modal_nofinger_jam_pulang_simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {},
                success: (result) => {
                    if (result.success != false) {
                        Lobibox.notify('success', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-check-circle',
                            msg: result.message_content
                        });
                        location.reload();
                        $('.modalJamPulangNonAbsen').modal('hide');
                    } else {
                        // Lobibox.notify('error', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-x-circle',
                        //     msg: result.message_content
                        // });
                        jQuery.notify({
                            title: 'Gagal!',
                            message: result.message_content
                        }, {
                            type: 'danger',
                            showProgressbar: true
                        });
                    }
                },
                error: function(request, status, error) {
                    // Lobibox.notify('error', {
                    //     pauseDelayOnHover: true,
                    //     continueDelayOnInactiveTab: false,
                    //     position: 'top right',
                    //     icon: 'bx bx-x-circle',
                    //     msg: error
                    // });
                    jQuery.notify({
                        title: 'Error!',
                        message: error
                    }, {
                        type: 'danger',
                        showProgressbar: true
                    });
                }
            });
        });

        $('#form-simpan-jam-masuk-detail_masuk').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('absensi.detail_jam_masuk_simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {},
                success: (result) => {
                    if (result.success != false) {
                        // Lobibox.notify('success', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-check-circle',
                        //     msg: result.message_content
                        // });

                        location.reload();
                        $('.modalDetailAbsenMasuk').modal('hide');
                    } else {
                        // Lobibox.notify('error', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-x-circle',
                        //     msg: result.message_content
                        // });
                        jQuery.notify({
                            title: 'Gagal!',
                            message: result.message_content
                        }, {
                            type: 'danger',
                            showProgressbar: true
                        });
                    }
                },
                error: function(request, status, error) {
                    // Lobibox.notify('error', {
                    //     pauseDelayOnHover: true,
                    //     continueDelayOnInactiveTab: false,
                    //     position: 'top right',
                    //     icon: 'bx bx-x-circle',
                    //     msg: error
                    // });
                    jQuery.notify({
                        title: 'Error!',
                        message: error
                    }, {
                        type: 'danger',
                        showProgressbar: true
                    });
                }
            });
        });

        $('#form-simpan-jam-keluar-detail_keluar').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('absensi.detail_jam_keluar_simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {},
                success: (result) => {
                    if (result.success != false) {
                        // Lobibox.notify('success', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-check-circle',
                        //     msg: result.message_content
                        // });
                        location.reload();
                        $('.modalDetailAbsenKeluar').modal('hide');
                    } else {
                        jQuery.notify({
                            title: 'Gagal!',
                            message: result.message_content
                        }, {
                            type: 'danger',
                            showProgressbar: true
                        });
                    }
                },
                error: function(request, status, error) {
                    jQuery.notify({
                        title: 'Error!',
                        message: error
                    }, {
                        type: 'danger',
                        showProgressbar: true
                    });
                }
            });
        });
    </script>
@endsection
