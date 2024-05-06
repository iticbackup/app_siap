@extends('layouts.absensi.master')
<?php $asset = asset('public/absensi/'); ?>
@section('css')
    <link rel="stylesheet" href="{{ $asset }}/assets/plugins/notifications/css/lobibox.min.css" />
    <style>

    </style>
@endsection
@section('title')
    Dashboard Absensi
@endsection
@section('content')
    <div class="page-content">
        @include('absensi.home.modal_detail_absen_masuk')
        @include('absensi.home.modal_detail_absen_keluar')

        @include('absensi.home.modal_jam_non_absen_masuk')
        @include('absensi.home.modal_jam_non_absen_keluar')
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('warning'))
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('info'))
            <div class="alert alert-info alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center" style="margin-bottom: 1%">
                        <div class="col">
                            <h4 class="card-title">Daftar Hadir Karyawan</h4>
                            <div id="time">
                            </div>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('absensi.search_name') }}" method="get">
                                <div class="input-group">
                                    <div class="mb-3">
                                        <label for="">Cari NIK / Karyawan</label>
                                        <input type="search" name="cari" class="form-control" value="{{ old('cari') }}"
                                            placeholder="Search..." id="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control" id="">
                                    </div>
                                    <div class="mb-3">
                                        <br>
                                        <button class="btn btn-outline-primary" type="submit"><i
                                                class="bx bxs-search bx-sm bx-tada"></i> Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">NIK</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Departemen / Unit</th>
                                    <th class="text-center">Posisi</th>
                                    <th class="text-center">Jam Masuk</th>
                                    <th class="text-center">Jam Pulang</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                @foreach ($biodata_karyawans as $key => $biodata_karyawan)
                                @php
                                    $date_live = \Carbon\Carbon::now()->format('Y-m-d');
                                    $mesin_jam_masuk = $fin_pro->where('scan_date', 'LIKE', '%'.$date_live.'%')
                                                                        ->whereTime('scan_date','<=','11:59:59')
                                                                        ->where('pin', $biodata_karyawan->pin)
                                                                        ->orderBy('scan_date','asc')
                                                                        ->first();
                                    if (empty($mesin_jam_masuk)) {
                                        $presensi_info_masuk = $presensi_info->where('scan_date', 'LIKE', '%' . $date_live . '%')
                                                                                ->where('pin', $biodata_karyawan->pin)
                                                                                ->whereTime('scan_date','<=','11:59:59')
                                                                                ->first();
                                        if (empty($presensi_info_masuk)) {
                                            $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)"><i class="bx bxs-plus-circle bx-sm bx-tada text-success"></i></a>';
                                        }else{
                                            if ($presensi_info_masuk->status == 4) {
                                                $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: red">Sakit</a>';
                                            } elseif ($presensi_info_masuk->status == 7) {
                                                $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: purple">Absen</a>';
                                            } elseif ($presensi_info_masuk->status == 13) {
                                                $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: orange">Cuti</a>';
                                            } else {
                                                $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`'.$presensi_info_masuk->att_rec.'`)">'.$presensi_info_masuk->scan_date.'</a>';
                                            }
                                        }
                                    }else{
                                        $absen_masuk = $presensi_info->with('presensi_status')
                                                                    ->where('scan_date', 'LIKE', '%' . $date_live . '%')
                                                                    ->where('pin', $biodata_karyawan->pin)
                                                                    ->whereTime('scan_date','<=','11:59:59')
                                                                    ->first();
                                        if (empty($absen_masuk)) {
                                            $date_jam_masuk = \Carbon\Carbon::create($mesin_jam_masuk->scan_date)->format('H:i');
                                            $jam_masuk = '<a type="button" onclick="detail_absensi_jam_masuk(`' . $mesin_jam_masuk->scan_date . '`,`' . $mesin_jam_masuk->pin . '`,`' . $mesin_jam_masuk->inoutmode . '`)" style="color: blue">' . $date_jam_masuk . '</a>';
                                        } else {
                                            $date_jam_masuk = \Carbon\Carbon::create($mesin_jam_masuk->scan_date)->format('H:i');
                                            $jam_masuk = '<a type="button" onclick="detail_absensi_jam_masuk(`' . $mesin_jam_masuk->scan_date . '`,`' . $mesin_jam_masuk->pin . '`,`' . $mesin_jam_masuk->inoutmode . '`)" style="color: blue">' . $date_jam_masuk . ' (' . $absen_masuk->presensi_status->status_info . ')</a>';
                                        }
                                    }

                                    $mesin_jam_pulang = $fin_pro->where('scan_date', 'LIKE', '%'.$date_live.'%')
                                                                ->whereTime('scan_date','>=','12:00:00')
                                                                ->where('pin', $biodata_karyawan->pin)
                                                                ->orderBy('scan_date','desc')
                                                                ->first();

                                    if (empty($mesin_jam_pulang)) {
                                        $presensi_info_2 = $fin_pro->where('scan_date', 'LIKE', '%' . $date_live . '%')
                                                                    ->where('pin', $biodata_karyawan->pin)
                                                                    ->whereTime('scan_date','>=','12:00:00')
                                                                    ->orderBy('scan_date','desc')
                                                                    ->first();
                                        if (empty($presensi_info_2)) {
                                            $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)"><i class="bx bxs-plus-circle bx-sm bx-tada text-success"></i></a>';
                                        } else {
                                            if ($presensi_info_2->status == 4) {
                                                $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: red">Sakit</a>';
                                            } elseif ($presensi_info_2->status == 7) {
                                                $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: purple">Absen</a>';
                                                // $jam_keluar = 'Absen';
                                            } elseif ($presensi_info_2->status == 13) {
                                                $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $date_live . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: orange">Cuti</a>';
                                                // $jam_keluar = 'Cuti';
                                            } else {
                                                $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`'.$date_live.'`,`'.$biodata_karyawan->pin.'`,`'. 0 .'`)">'.$presensi_info_2->scan_date.'</a>';
                                            }
                                        }
                                    }else{
                                        $absen_keluar = $presensi_info->with('presensi_status')
                                                                        ->where('scan_date', 'LIKE', '%' . $date_live . '%')
                                                                        ->where('pin', $biodata_karyawan->pin)
                                                                        ->whereTime('scan_date','>=','12:00:00')
                                                                        ->orderBy('scan_date','desc')
                                                                        ->first();
                                        if (empty($absen_keluar)) {
                                            $date_jam_keluar = \Carbon\Carbon::create($mesin_jam_pulang->scan_date)->format('H:i');
                                            $jam_keluar = '<a type="button" onclick="detail_absensi_jam_keluar(`' . $mesin_jam_pulang->scan_date . '`,`' . $mesin_jam_pulang->pin . '`,`' . $mesin_jam_pulang->inoutmode . '`)" style="color: blue">' . $date_jam_keluar . '</a>';
                                        } else {
                                            $date_jam_keluar = \Carbon\Carbon::create($mesin_jam_pulang->scan_date)->format('H:i');
                                            $jam_keluar = '<a type="button" onclick="detail_absensi_jam_keluar(`' . $mesin_jam_pulang->scan_date . '`,`' . $mesin_jam_pulang->pin . '`,`' . $mesin_jam_pulang->inoutmode . '`)" style="color: red">' . $date_jam_keluar . ' (' . $absen_keluar->presensi_status->status_info . ')</a>';
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{ $biodata_karyawan->nik }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $biodata_karyawan->nama }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $biodata_karyawan->departemen->nama_departemen >= 1 ? $biodata_karyawan->departemen->nama_unit : $biodata_karyawan->departemen->nama_departemen }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $biodata_karyawan->posisi->nama_posisi }}</td>
                                    <td class="text-center" style="vertical-align: middle">{!! $jam_masuk !!}</td>
                                    <td class="text-center" style="vertical-align: middle">{!! $jam_keluar !!}</td>
                                </tr>
                                @endforeach
                            </tbody> --}}
                            <tbody id="biodata_karyawan"></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7"><b>Note:</b> Presensi ini hanya digunakan untuk absen hari ini.</td>
                                </tr>
                            </tfoot>
                        </table>
                        {{-- {{ $biodata_karyawans->links('vendor.pagination.template1.default') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ $asset }}/assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="{{ $asset }}/assets/plugins/notifications/js/notifications.min.js"></script>
    <script src="{{ $asset }}/assets/plugins/notifications/js/notification-custom-script.js"></script>
    <script src="{{ $asset }}/assets/plugins/highcharts/js/highcharts.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var timeDisplay = document.getElementById("time");


        function refreshTime() {
            var dateString = new Date().toLocaleString("id-ID", {
                timeZone: "Asia/Jakarta"
            });
            var formattedString = dateString.replace(", ", " - ");
            timeDisplay.innerHTML = formattedString;
        }
        setInterval(refreshTime, 1000);

        function biodata_karyawan()
        {
            $.ajax({
                type: 'GET',
                url: "{{ route('absensi.home') }}",
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function(){
                    // $('.modalLoading').modal('show');
                    document.getElementById('biodata_karyawan').innerHTML="<tr><td class='text-center' colspan='6'>Loading...</td></tr>";
                },
                success: (result) => {
                    console.table(result.data);
                    var data = result.data;
                    var txt_data = "";
                    data.forEach(fungsi_data);

                    function fungsi_data(value,index)
                    {
                        txt_data = txt_data+"<tr>";
                        txt_data = txt_data+"   <td class='text-center' style='vertical-align: center;'>"+value.nik+"</td>";
                        txt_data = txt_data+"   <td>"+value.nama+"</td>";
                        txt_data = txt_data+"   <td class='text-center'>"+value.departemen+"</td>";
                        txt_data = txt_data+"   <td class='text-center'>"+value.posisi+"</td>";
                        txt_data = txt_data+"   <td class='text-center'>"+value.jam_masuk+"</td>";
                        txt_data = txt_data+"   <td class='text-center'>"+value.jam_pulang+"</td>";
                        txt_data = txt_data+"</tr>";
                    }
                    document.getElementById('biodata_karyawan').innerHTML = txt_data;
                },
                error: function(request, status, error) {

                }
            });
        }

        function detail_absensi_jam_masuk(scan_date, pin, inoutmode) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/absensi_masuk') }}" + '/' + scan_date + '/' + pin + '/' + inoutmode,
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
                        $('#detail_masuk_inoutmode').val(result.data.inoutmode);
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

        function detail_absensi_jam_keluar(scan_date, pin, inoutmode) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/absensi_keluar') }}" + '/' + scan_date + '/' + pin + '/' + inoutmode,
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
                        $('#detail_keluar_inoutmode').val(result.data.inoutmode);
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
                    } else {
                    }
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

        function detail_non_absen_jam_masuk(date_live, pin, inoutmode) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/jam_masuk') }}" + '/' + date_live + '/' + pin + '/' + inoutmode,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        $('#pin_non_absen_masuk').val(result.data.pin);
                        $('#inoutmode_non_absen_masuk').val(result.inoutmode);
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

        function detail_non_absen_jam_keluar(date_live, pin, inoutmode) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/jam_pulang') }}" + '/' + date_live + '/' + pin + '/' + inoutmode,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        $('#pin_non_absen_keluar').val(result.data.pin);
                        $('#inoutmode_non_absen_keluar').val(result.inoutmode);
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

        function detail_edit_non_absensi_jam_masuk(att_rec) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/jam_masuk/edit') }}" + '/' + att_rec,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        $('#edit_att_rec_non_absen').val(result.att_rec);
                        document.getElementById('edit_jam_masuk_nik').innerHTML = result.karyawan.nik;
                        document.getElementById('edit_jam_masuk_nama_karyawan').innerHTML = result.karyawan.nama
                        $('#edit_non_absen_masuk_jam_masuk_tanggal').val(result.date);
                        $('#edit_non_absen_masuk_jam_masuk_waktu').val(result.time);
                        $('#edit_non_absen_masuk_jam_masuk_status').val(result.status);
                        $('#edit_penyesuaian_masuk_jam_masuk_jam_non_absen').val(result
                            .penyesuaian_jam_masuk_jam);
                        $('#edit_penyesuaian_masuk_jam_masuk_menit_non_absen').val(result
                            .penyesuaian_jam_masuk_menit);
                        $('#edit_penyesuaian_istirahat_jam_masuk_jam_non_absen').val(result
                            .penyesuaian_istirahat_jam_masuk_jam);
                        $('#edit_penyesuaian_istirahat_jam_masuk_menit_non_absen').val(result
                            .penyesuaian_istirahat_jam_masuk_menit);
                        $('#edit_penyesuaian_pulang_jam_masuk_jam_non_absen').val(result
                            .penyesuaian_pulang_jam_masuk_jam);
                        $('#edit_penyesuaian_pulang_jam_masuk_menit_non_absen').val(result
                            .penyesuaian_pulang_jam_menit_menit);
                        $('#edit_jam_masuk_keterangan_non_absen').val(result.keterangan);
                        $('.modalEditJamMasukNonAbsen').modal('show');
                    } else {
                    }
                },
                error: function(request, status, error) {

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
                beforeSend: function() {
                },
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
                        $('.modalJamMasukNonAbsen').modal('hide');
                    } else {
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-x-circle',
                            msg: result.message_content
                        });
                    }
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
                beforeSend: function() {
                },
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
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-x-circle',
                            msg: result.message_content
                        });
                    }
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
                beforeSend: function() {
                },
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
                        $('.modalDetailAbsenMasuk').modal('hide');
                    } else {
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-x-circle',
                            msg: result.message_content
                        });
                    }
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
                beforeSend: function() {
                },
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
                        $('.modalDetailAbsenKeluar').modal('hide');
                    } else {
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-x-circle',
                            msg: result.message_content
                        });
                    }
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
        });

        $(document).ready(function(){
            biodata_karyawan();
        })
    </script>
@endsection
