@extends('layouts.absensi.master')
<?php $asset = asset('public/absensi/'); ?>
@section('css')
    <link href="{{ $asset }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endsection
@section('title')
    Dashboard Absensi
@endsection
@section('content')
    <div class="page-content">
        @include('absensi.home.modal_jam_non_absen_masuk')
        @include('absensi.home.modal_jam_edit_non_absen_masuk')
        <div class="col">
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
                            <button class="btn btn-outline-primary" onclick="reload()"><i
                                    class="bx bxs-refresh bx-sm bx-tada"></i> Reload Data</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="datatables" class="table table-striped table-bordered dataTable mb-0">
                            <thead>
                                <tr>
                                    {{-- <th class="text-center">No</th> --}}
                                    <th class="text-center">NIK</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Departemen / Unit</th>
                                    <th class="text-center">Posisi</th>
                                    <th class="text-center">Jam Masuk</th>
                                    <th class="text-center">Jam Pulang</th>
                                    <th class="text-center">Total Jam</th>
                                    {{-- <th class="text-center">Action</th> --}}
                                    {{-- <th class="text-center">Departemen / Unit</th>
                                <th class="text-center">Posisi</th>
                                <th class="text-center">Jam Masuk</th>
                                <th class="text-center">Jam Pulang</th>
                                <th class="text-center">Total Jam</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($karyawans as $karyawan)
                            @php
                                $cek_satuan_kerja = \App\Models\IticDepartemen::where('id_departemen',$karyawan->satuan_kerja)->first();
                                if (empty($cek_satuan_kerja)) {
                                    $satuan_kerja = '-';
                                }else{
                                    $cek_satuan_kerja_2 = \App\Models\IticDepartemen::where('nama_departemen',$karyawan->satuan_kerja)->first();
                                    if (empty($cek_satuan_kerja_2)) {
                                        $satuan_kerja = $cek_satuan_kerja->nama_departemen;
                                    }else{
                                        $satuan_kerja = $cek_satuan_kerja_2->nama_unit;
                                    }
                                }
    
                                $cek_jabatan = \App\Models\EmpJabatan::where('id_jabatan',$karyawan->id_jabatan)->first();
                                if (empty($cek_jabatan)) {
                                    $jabatan = '-';
                                }else{
                                    $jabatan = $cek_jabatan->nama_jabatan;
                                }
                            @endphp
                                <tr>
                                    <td class="text-center">{{ $karyawan->nik }}</td>
                                    <td class="text-center">{{ $karyawan->nama }}</td>
                                    <td class="text-center">{{ $satuan_kerja }}</td>
                                    <td class="text-center">{{ $jabatan }}</td>
                                    <td class="text-center">{{ '' }}</td>
                                    <td class="text-center">{{ '' }}</td>
                                    <td class="text-center">{{ '' }}</td>
                                </tr>
                            @endforeach --}}
                            </tbody>
                        </table>
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
        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('absensi.home') }}",
            columns: [{
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'departemen',
                    name: 'departemen'
                },
                {
                    data: 'posisi',
                    name: 'posisi'
                },
                {
                    data: 'jam_masuk',
                    name: 'jam_masuk'
                },
                {
                    data: 'jam_pulang',
                    name: 'jam_pulang'
                },
                {
                    data: 'total_jam',
                    name: 'total_jam'
                },
                // {
                //     data: 'penyelenggara',
                //     name: 'penyelenggara'
                // },
                // {
                //     data: 'jenis',
                //     name: 'jenis'
                // },
                // {
                //     data: 'status',
                //     name: 'status'
                // },
                // {
                //     data: 'created_at',
                //     name: 'created_at'
                // },
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: false,
                //     searchable: false
                // },
            ],
            columnDefs: [
                // { className: 'text-right', targets: [7, 10, 11, 14, 16] },
                {
                    className: 'text-center',
                    targets: [0, 2, 3, 4, 5, 6]
                },
            ],
            order: [
                [2, 'asc']
            ]
        });

        function reload() {
            table.ajax.reload(null, false);
        };

        function detail_non_absen_jam_masuk(date_live,pin,inout){
            // alert(date_live+' '+pin);
            // $('.modalBuatJamMasuk').modal('show');
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/jam_masuk') }}"+'/'+date_live+'/'+pin+'/'+inout,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        // alert('success');
                        $('#pin_non_absen_masuk').val(result.data.pin);
                        document.getElementById('jam_masuk_nik').innerHTML = result.data.nik
                        document.getElementById('jam_masuk_nama_karyawan').innerHTML = result.data.nama
                        $('#non_absen_masuk_jam_masuk_tanggal').val(result.tanggal);
                        $('.modalBuatJamMasukNonAbsen').modal('show');
                    } else {
                        // alert('not success');
                        // document.getElementById('jam_masuk_nik').innerHTML = result.data.nik
                        // $('.modalBuatJamMasukNonAbsen').modal('show');
                    }
                },
                error: function(request, status, error) {

                }
            });
        }

        function detail_edit_non_absensi_jam_masuk(att_rec)
        {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/jam_masuk/edit') }}"+'/'+att_rec,
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
                        $('#edit_penyesuaian_masuk_jam_masuk_jam_non_absen').val(result.penyesuaian_jam_masuk_jam);
                        $('#edit_penyesuaian_masuk_jam_masuk_menit_non_absen').val(result.penyesuaian_jam_masuk_menit);
                        $('#edit_penyesuaian_istirahat_jam_masuk_jam_non_absen').val(result.penyesuaian_istirahat_jam_masuk_jam);
                        $('#edit_penyesuaian_istirahat_jam_masuk_menit_non_absen').val(result.penyesuaian_istirahat_jam_masuk_menit);
                        $('#edit_penyesuaian_pulang_jam_masuk_jam_non_absen').val(result.penyesuaian_pulang_jam_masuk_jam);
                        $('#edit_penyesuaian_pulang_jam_masuk_menit_non_absen').val(result.penyesuaian_pulang_jam_menit_menit);
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
                        alert('Berhasil Disimpan');
                        // iziToast.success({
                        //     title: result.message_title,
                        //     message: result.message_content
                        // });
                    } else {
                        alert('Gagal Disimpan');
                        // iziToast.error({
                        //     title: result.success,
                        //     message: result.error
                        // });
                    }
                },
                error: function(request, status, error) {
                    // iziToast.error({
                    //     title: 'Error',
                    //     message: error,
                    // });
                    alert(error);
                }
            });
        });

        $('#form-edit-jam-masuk-non-absen').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('absensi.input_modal_edit_nofinger_jam_masuk_update') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
                },
                success: (result) => {
                    if (result.success != false) {
                        alert(result.message_content);
                        // iziToast.success({
                        //     title: result.message_title,
                        //     message: result.message_content
                        // });
                    } else {
                        alert('Gagal Disimpan');
                        // iziToast.error({
                        //     title: result.success,
                        //     message: result.error
                        // });
                    }
                },
                error: function(request, status, error) {
                    // iziToast.error({
                    //     title: 'Error',
                    //     message: error,
                    // });
                    alert(error);
                }
            });
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
