@extends('layouts.absensi.master')
<?php $asset = asset('public/absensi/'); ?>
@section('css')
    <link rel="stylesheet" href="{{ $asset }}/assets/plugins/notifications/css/lobibox.min.css" />
    <link href="{{ $asset }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lobipanel/1.0.6/css/lobipanel.css" integrity="sha512-Ll5C6X686xv2Mb9RS2l9ojDcX6GUTaN1y9i8fujwr8bxkPB/3ldxgnFO2KpeEWof070O++saS31PBcrrF73DxA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
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
            <div class="row row-cols-1 row-cols-lg-3">
                <div class="col-12 col-lg-12">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div id="chart13"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    {{-- <div>
                    <h5 class="card-title">Daftar Hadir Karyawan</h5>
                </div> --}}
                    <div class="row align-items-center" style="margin-bottom: 1%">
                        <div class="col">
                            <h4 class="card-title">Daftar Hadir Karyawan - Time <span id="time"></span></h4>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('absensi.search_name') }}" method="get">
                                <div class="input-group">
                                    <div class="mb-3">
                                        <label for="">Cari NIK / Karyawan</label>
                                        <input type="search" name="cari" class="form-control" value="{{ $_GET['cari'] }}"
                                            placeholder="Search..." id="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control" value="{{ $_GET['tanggal'] }}" id="">
                                    </div>
                                    <div class="mb-3">
                                        <br>
                                        <button class="btn btn-outline-primary" type="submit"><i
                                                class="bx bxs-search bx-sm bx-tada"></i> Cari</button>
                                    </div>
                                </div>
                            </form>
                            {{-- <button class="btn btn-outline-primary" onclick="reload()"><i
                                    class="bx bxs-refresh bx-sm bx-tada"></i> Reload Data</button> --}}
                        </div>
                    </div>
                    <div class="table-responsive">
                        {{-- <table id="datatables" class="table table-striped table-bordered dataTable mb-0"> --}}
                        <table class="table table-striped table-bordered dataTable mb-0">
                            <thead>
                                <tr>
                                    {{-- <th class="text-center">No</th> --}}
                                    <th class="text-center">NIK</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Departemen / Unit</th>
                                    <th class="text-center">Posisi</th>
                                    <th class="text-center">Jam Masuk</th>
                                    <th class="text-center">Jam Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($biodata_karyawans as $key => $biodata_karyawan)
                                @php
                                    $cek_status_kerja = \App\Models\IticDepartemen::where('id_departemen', $biodata_karyawan->satuan_kerja)->first();
                                    if (empty($cek_status_kerja)) {
                                        $satuan_kerja = '-';
                                    } else {
                                        if ($cek_status_kerja->nama_departemen >= 1) {
                                            $satuan_kerja = $cek_status_kerja->nama_unit;
                                        } else {
                                            $satuan_kerja = $cek_status_kerja->nama_departemen;
                                        }
                                    }

                                    $cek_posisi = \App\Models\EmpPosisi::where('id_posisi', $biodata_karyawan->id_posisi)->first();
                                    if (empty($cek_posisi)) {
                                        $posisi = '-';
                                    } else {
                                        $posisi = $cek_posisi->nama_posisi;
                                    }

                                    $date_live = \Carbon\Carbon::now()->format('Y-m-d');
                                    $mesin_jam_masuk = \App\Models\FinPro::where('scan_date', 'LIKE', '%'.$_GET['tanggal'].'%')
                                                                        ->whereTime('scan_date','<=','11:59:59')
                                                                        ->where('pin', $biodata_karyawan->pin)
                                                                        ->orderBy('scan_date','desc')
                                                                        ->first();

                                    if (empty($mesin_jam_masuk)) {
                                        $presensi_info_masuk = \App\Models\PresensiInfo::where('scan_date', 'LIKE', '%' . $_GET['tanggal'] . '%')
                                                                                ->where('pin', $biodata_karyawan->pin)
                                                                                ->whereTime('scan_date','<=','11:59:59')
                                                                                ->first();
                                        if (empty($presensi_info_masuk)) {
                                            $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $_GET['tanggal'] . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)"><i class="bx bxs-plus-circle bx-sm bx-tada text-success"></i></a>';
                                        }else{
                                            if ($presensi_info_masuk->status == 4) {
                                                $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $_GET['tanggal'] . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: red">Sakit</a>';
                                            } elseif ($presensi_info_masuk->status == 7) {
                                                $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $_GET['tanggal'] . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: purple">Absen</a>';
                                            } elseif ($presensi_info_masuk->status == 13) {
                                                $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`' . $_GET['tanggal'] . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: orange">Cuti</a>';
                                            } else {
                                                $jam_masuk = '<a type="button" onclick="detail_non_absen_jam_masuk(`'.$presensi_info_masuk->att_rec.'`)">'.$presensi_info_masuk->scan_date.'</a>';
                                            }
                                        }
                                    }else{
                                        $absen_masuk = \App\Models\PresensiInfo::with('presensi_status')
                                                                                ->where('scan_date', 'LIKE', '%' . $_GET['tanggal'] . '%')
                                                                                ->where('pin', $biodata_karyawan->pin)
                                                                                ->whereTime('scan_date','<=','11:59:59')
                                                                                // ->where('inoutmode', $inoutmode)
                                                                                ->first();
                                        if (empty($absen_masuk)) {
                                            $date_jam_masuk = \Carbon\Carbon::create($mesin_jam_masuk->scan_date)->format('H:i');
                                            $jam_masuk = '<a type="button" onclick="detail_absensi_jam_masuk(`' . $mesin_jam_masuk->scan_date . '`,`' . $mesin_jam_masuk->pin . '`,`' . $mesin_jam_masuk->inoutmode . '`)" style="color: blue">' . $date_jam_masuk . '</a>';
                                        } else {
                                            $date_jam_masuk = \Carbon\Carbon::create($mesin_jam_masuk->scan_date)->format('H:i');
                                            $jam_masuk = '<a type="button" onclick="detail_absensi_jam_masuk(`' . $mesin_jam_masuk->scan_date . '`,`' . $mesin_jam_masuk->pin . '`,`' . $mesin_jam_masuk->inoutmode . '`)" style="color: blue">' . $date_jam_masuk . ' (' . $absen_masuk->presensi_status->status_info . ')</a>';
                                        }
                                    }

                                    $mesin_jam_pulang = \App\Models\FinPro::where('scan_date', 'LIKE', '%'.$_GET['tanggal'].'%')
                                                                        ->whereTime('scan_date','>=','12:00:00')
                                                                        ->where('pin', $biodata_karyawan->pin)
                                                                        ->orderBy('scan_date','desc')
                                                                        ->first();

                                    if (empty($mesin_jam_pulang)) {
                                        $presensi_info_2 = \App\Models\PresensiInfo::where('scan_date', 'LIKE', '%' . $_GET['tanggal'] . '%')
                                                                                ->where('pin', $biodata_karyawan->pin)
                                                                                ->whereTime('scan_date','>=','12:00:00')
                                                                                ->orderBy('scan_date','desc')
                                                                                ->first();
                                        if (empty($presensi_info_2)) {
                                            $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $_GET['tanggal'] . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)"><i class="bx bxs-plus-circle bx-sm bx-tada text-success"></i></a>';
                                        } else {
                                            if ($presensi_info_2->status == 4) {
                                                $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $_GET['tanggal'] . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: red">Sakit</a>';
                                            } elseif ($presensi_info_2->status == 7) {
                                                $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $_GET['tanggal'] . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: purple">Absen</a>';
                                                // $jam_keluar = 'Absen';
                                            } elseif ($presensi_info_2->status == 13) {
                                                $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`' . $_GET['tanggal'] . '`,`' . $biodata_karyawan->pin . '`,`' . 0 . '`)" style="color: orange">Cuti</a>';
                                                // $jam_keluar = 'Cuti';
                                            } else {
                                                $jam_keluar = '<a type="button" onclick="detail_non_absen_jam_keluar(`'. $_GET['tanggal'] .'`,`'.$biodata_karyawan->pin.'`,`'. 0 .'`)">'.$presensi_info_2->scan_date.'</a>';
                                            }
                                        }
                                    }else{
                                        $absen_keluar = \App\Models\PresensiInfo::with('presensi_status')
                                                                                ->where('scan_date', 'LIKE', '%' . $_GET['tanggal'] . '%')
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
                                    <td class="text-center" style="vertical-align: middle">{{ $satuan_kerja }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $posisi }}</td>
                                    <td class="text-center" style="vertical-align: middle">{!! $jam_masuk !!}</td>
                                    <td class="text-center" style="vertical-align: middle">{!! $jam_keluar !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7"><b>Note:</b> Presensi ini hanya digunakan untuk absen hari ini.</td>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $biodata_karyawans->links('vendor.pagination.template1.default') }}
                    </div>
                    {{-- {{ $karyawans->links() }} --}}
                    {{-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>	<a href="javascript:;" class="btn btn-primary">Go somewhere</a> --}}
                </div>
            </div>
        </div>
        {{-- <div class="row row-cols-1 row-cols-lg-3">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="mb-0">Sessions</p>
                            <h4 class="font-weight-bold">32,842 <small class="text-success font-13">(+40%)</small></h4>
                            <p class="text-success mb-0 font-13">Analytics for last week</p>
                        </div>
                        <div class="widgets-icons bg-gradient-cosmic text-white"><i class='bx bx-refresh'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="mb-0">Users</p>
                            <h4 class="font-weight-bold">16,352 <small class="text-success font-13">(+22%)</small></h4>
                            <p class="text-secondary mb-0 font-13">Analytics for last week</p>
                        </div>
                        <div class="widgets-icons bg-gradient-burning text-white"><i class='bx bx-group'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="mb-0">Time on Site</p>
                            <h4 class="font-weight-bold">34m 14s <small class="text-success font-13">(+55%)</small></h4>
                            <p class="text-secondary mb-0 font-13">Analytics for last week</p>
                        </div>
                        <div class="widgets-icons bg-gradient-lush text-white"><i class='bx bx-time'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="mb-0">Goal Completions</p>
                            <h4 class="font-weight-bold">1,94,2335</h4>
                            <p class="text-secondary mb-0 font-13">Analytics for last month</p>
                        </div>
                        <div class="widgets-icons bg-gradient-kyoto text-white"><i class='bx bxs-cube'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="mb-0">Bounce Rate</p>
                            <h4 class="font-weight-bold">58% <small class="text-danger font-13">(-16%)</small></h4>
                            <p class="text-secondary mb-0 font-13">Analytics for last week</p>
                        </div>
                        <div class="widgets-icons bg-gradient-blues text-white"><i class='bx bx-line-chart'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="mb-0">New Sessions</p>
                            <h4 class="font-weight-bold">96% <small class="text-danger font-13">(+54%)</small></h4>
                            <p class="text-secondary mb-0 font-13">Analytics for last week</p>
                        </div>
                        <div class="widgets-icons bg-gradient-moonlit text-white"><i class='bx bx-bar-chart'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card radius-10">
                <div class="card-body">
                    <div id="chart1"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card radius-10">
                <div class="card-body">
                    <div id="chart2"></div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
    <div class="row">
        <div class="col-12 col-lg-8 d-lg-flex align-items-lg-stretch">
            <div class="card radius-10 w-100">
                <div class="card-header border-bottom-0 bg-transparent">
                    <div class="d-lg-flex align-items-center">
                        <div class="">
                            <h5 class="mb-1">Website Audience Overview</h5>
                            <p class="text-secondary mb-2 mb-lg-0 font-14">There are plenty of free web proxy sites that you can use</p>
                        </div>
                        <div class="ms-lg-auto">
                            <div class="btn-group-round">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-white">Day</button>
                                    <button type="button" class="btn btn-white">Week</button>
                                    <button type="button" class="btn btn-white">Month</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart3"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 d-lg-flex align-items-lg-stretch">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">Traffic Sources</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Source</th>
                                    <th>Visitors</th>
                                    <th>Bounce Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>(direct)</td>
                                    <td>56</td>
                                    <td>10%</td>
                                </tr>
                                <tr>
                                    <td>google</td>
                                    <td>29</td>
                                    <td>12%</td>
                                </tr>
                                <tr>
                                    <td>linkedin.com</td>
                                    <td>68</td>
                                    <td>33%</td>
                                </tr>
                                <tr>
                                    <td>bing</td>
                                    <td>14</td>
                                    <td>24%</td>
                                </tr>
                                <tr>
                                    <td>facebook.com</td>
                                    <td>87</td>
                                    <td>22%</td>
                                </tr>
                                <tr>
                                    <td>other</td>
                                    <td>98</td>
                                    <td>27%</td>
                                </tr>
                                <tr>
                                    <td>linkedin.com</td>
                                    <td>68</td>
                                    <td>33%</td>
                                </tr>
                                <tr>
                                    <td>bing</td>
                                    <td>14</td>
                                    <td>24%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
    <div class="row row-cols-1 row-cols-lg-3">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div id="chart4"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div id="chart5"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div id="chart6"></div>
                </div>
            </div>
        </div>
    </div> --}}
    </div>
@endsection
@section('script')
    <script src="{{ $asset }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ $asset }}/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lobipanel/1.0.6/js/lobipanel.min.js" integrity="sha512-87ZExUcqiYtb95dZZDnehfTeEhUUsvmm5BILx99vEjFXjdn0hJtZo//oFwp8l7AV0F01Md817fVCl1ahn3QSNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="{{ $asset }}/assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="{{ $asset }}/assets/plugins/notifications/js/notifications.min.js"></script>
    <script src="{{ $asset }}/assets/plugins/notifications/js/notification-custom-script.js"></script>
    <script src="{{ $asset }}/assets/plugins/highcharts/js/highcharts.js"></script>
    {{-- <script src="{{ $asset }}/assets/plugins/highcharts/js/exporting.js"></script> --}}
    {{-- <script src="{{ $asset }}/assets/plugins/highcharts/js/variable-pie.js"></script> --}}
    {{-- <script src="{{ $asset }}/assets/plugins/highcharts/js/export-data.js"></script> --}}
    {{-- <script src="{{ $asset }}/assets/plugins/highcharts/js/accessibility.js"></script> --}}
    {{-- <script src="{{ $asset }}/assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script> --}}
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

        // var table = $('#datatables').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "{{ route('absensi.home') }}",
        //     columns: [{
        //             data: 'nik',
        //             name: 'nik'
        //         },
        //         {
        //             data: 'nama',
        //             name: 'nama'
        //         },
        //         {
        //             data: 'departemen',
        //             name: 'departemen'
        //         },
        //         {
        //             data: 'posisi',
        //             name: 'posisi'
        //         },
        //         {
        //             data: 'jam_masuk',
        //             name: 'jam_masuk'
        //         },
        //         {
        //             data: 'jam_pulang',
        //             name: 'jam_pulang'
        //         },
        //         {
        //             data: 'total_jam',
        //             name: 'total_jam'
        //         },
        //         // {
        //         //     data: 'penyelenggara',
        //         //     name: 'penyelenggara'
        //         // },
        //         // {
        //         //     data: 'jenis',
        //         //     name: 'jenis'
        //         // },
        //         // {
        //         //     data: 'status',
        //         //     name: 'status'
        //         // },
        //         // {
        //         //     data: 'created_at',
        //         //     name: 'created_at'
        //         // },
        //         // {
        //         //     data: 'action',
        //         //     name: 'action',
        //         //     orderable: false,
        //         //     searchable: false
        //         // },
        //     ],
        //     columnDefs: [
        //         // { className: 'text-right', targets: [7, 10, 11, 14, 16] },
        //         {
        //             className: 'text-center',
        //             targets: [0, 2, 3, 4, 5, 6]
        //         },
        //     ],
        //     order: [
        //         [2, 'asc']
        //     ]
        // });

        function reload() {
            // table.ajax.reload(null, false);
            // Lobibox.notify('success', {
            //     pauseDelayOnHover: true,
            //     continueDelayOnInactiveTab: false,
            //     position: 'top right',
            //     icon: 'bx bx-check-circle',
            //     msg: 'Lorem ipsum dolor sit amet hears farmer indemnity inherent.'
            // });
        };

        function detail_absensi_jam_masuk(scan_date, pin, inoutmode) {
            // alert(date_live+' '+pin);
            // $('.modalBuatJamMasuk').modal('show');
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
                        // Lobibox.notify('error', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-x-circle',
                        //     msg: result.message_content
                        // });
                        document.getElementById('detail_masuk_nik').innerHTML = result.biodata_karyawan.nik;
                        document.getElementById('detail_masuk_nama_karyawan').innerHTML = result
                            .biodata_karyawan.nama;
                        document.getElementById('detail_masuk_tanggal_masuk').innerHTML = result.data.scan_date;
                        $('#detail_masuk_pin').val(result.data.pin);
                        $('#detail_masuk_tanggal_masuk').val(result.data.scan_date);
                        // document.getElementById('detail_masuk_tanggal_masuk').innerHTML = result.data.scan_date;
                        $('.modalDetailAbsenMasuk').modal('show');
                    }
                },
                error: function(request, status, error) {

                }
            });
        }

        function detail_absensi_jam_keluar(scan_date, pin, inoutmode) {
            // alert(date_live+' '+pin);
            // $('.modalBuatJamMasuk').modal('show');
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
                        // // document.getElementById('detail_masuk_tanggal_masuk').innerHTML = result.data.scan_date;
                        $('.modalDetailAbsenKeluar').modal('show');
                    } else {
                        // Lobibox.notify('error', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-x-circle',
                        //     msg: result.message_content
                        // });
                        // document.getElementById('detail_masuk_nik').innerHTML = result.biodata_karyawan.nik;
                        // document.getElementById('detail_masuk_nama_karyawan').innerHTML = result.biodata_karyawan.nama;
                        // document.getElementById('detail_masuk_tanggal_masuk').innerHTML = result.data.scan_date;
                        // $('#detail_masuk_pin').val(result.data.pin);
                        // $('#detail_masuk_tanggal_masuk').val(result.data.scan_date);
                        // // document.getElementById('detail_masuk_tanggal_masuk').innerHTML = result.data.scan_date;
                        // $('.modalDetailAbsenMasuk').modal('show');
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
            // alert(date_live+' '+pin);
            // $('.modalBuatJamMasuk').modal('show');
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/jam_masuk') }}" + '/' + date_live + '/' + pin + '/' + inoutmode,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        // alert('success');
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
            // alert(date_live+' '+pin);
            // $('.modalBuatJamMasuk').modal('show');
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/jam_pulang') }}" + '/' + date_live + '/' + pin + '/' + inoutmode,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        // alert('success');
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
                        // alert('success');
                        $('#edit_att_rec_non_absen').val(result.att_rec);
                        // $('#edit_pin_non_absen_masuk').val(result.karyawan.pin);
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
                        // alert('not success');
                        // document.getElementById('jam_masuk_nik').innerHTML = result.data.nik
                        // $('.modalBuatJamMasukNonAbsen').modal('show');
                    }
                },
                error: function(request, status, error) {

                }
            });
            // $('.modalEditJamMasukNonAbsen').modal('show');
        }

        $('#form-simpan-jam-masuk-non-absen').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('absensi.input_modal_nofinger_jam_masuk_simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
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
                        // table.ajax.reload(null, false);
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
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('absensi.input_modal_nofinger_jam_pulang_simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
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
                        // table.ajax.reload(null, false);
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
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('absensi.detail_jam_masuk_simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
                },
                success: (result) => {
                    if (result.success != false) {
                        // alert(result.message_content);
                        Lobibox.notify('success', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-check-circle',
                            msg: result.message_content
                        });
                        // table.ajax.reload(null, false);
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
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('absensi.detail_jam_keluar_simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
                },
                success: (result) => {
                    if (result.success != false) {
                        // alert(result.message_content);
                        Lobibox.notify('success', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-check-circle',
                            msg: result.message_content
                        });
                        // table.ajax.reload(null, false);
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
    </script>
    <script>
        Highcharts.chart('chart13', {
            chart: {
                zoomType: 'xy',
                styledMode: true
            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Progress Absensi Periode ' + new Date().getFullYear()
            },
            xAxis: [{
                categories: @json($periode),
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Total Absensi',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Total Absensi',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 120,
                verticalAlign: 'top',
                y: 100,
                floating: true,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor ||
                    'rgba(255,255,255,0.25)'
            },
            series: [{
                name: 'Total Absensi',
                type: 'column',
                yAxis: 1,
                data: @json($hasil),

            }]
        });
    </script>
    {{-- <script src="{{ $asset }}/assets/plugins/highcharts/js/highcharts.js"></script>
<script src="{{ $asset }}/assets/plugins/highcharts/js/highcharts-more.js"></script>
<script src="{{ $asset }}/assets/plugins/highcharts/js/variable-pie.js"></script>
<script src="{{ $asset }}/assets/plugins/highcharts/js/solid-gauge.js"></script>
<script src="{{ $asset }}/assets/plugins/highcharts/js/highcharts-3d.js"></script>
<script src="{{ $asset }}/assets/plugins/highcharts/js/cylinder.js"></script>
<script src="{{ $asset }}/assets/plugins/highcharts/js/funnel3d.js"></script>
<script src="{{ $asset }}/assets/plugins/highcharts/js/exporting.js"></script>
<script src="{{ $asset }}/assets/plugins/highcharts/js/export-data.js"></script>
<script src="{{ $asset }}/assets/plugins/highcharts/js/accessibility.js"></script>
<script src="{{ $asset }}/assets/js/index4.js"></script> --}}
@endsection
