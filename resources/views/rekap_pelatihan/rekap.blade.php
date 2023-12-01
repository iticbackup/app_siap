@extends('layouts.apps.master')
@section('title')
    Rekap Pelatihan & Seminar
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @yield('title')
        @endslot
        @slot('title')
            @yield('title')
        @endslot
    @endcomponent

    @include('rekap_pelatihan.modalExcelPeriode')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Total Rekap Pelatihan & Seminar Periode {!! date('Y') !!}</h4>
                        </div>
                        {{-- <div class="col-auto">
                            <div class="dropdown">
                                <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    This Year<i class="las la-angle-down ms-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Today</a>
                                    <a class="dropdown-item" href="#">Last Week</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">This Year</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <div id="ana_dash_1" class="apex-charts"></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success" onclick="excelPeriode()"><i class="far fa-file-excel"></i>
                                Download Excel Rekap All</button>
                            <a class="btn btn-outline-primary" href="{{ route('rekap_pelatihan.create') }}"><i
                                    class="fa fa-plus"></i> Create New Data</a>
                            {{-- <button class="btn btn-outline-primary" onclick="buat()" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter"><i class="fas fa-plus"></i> Create New Data</button> --}}
                            <button class="btn btn-outline-primary" onclick="reload()"><i class="fas fa-undo"></i> Reload
                                Data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Tema Seminar</th>
                                <th class="text-center">Penyelenggara</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tanggal Dibuat</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer">
                    <div><b>Note:</b> Jadwal Pelatihan diverifikasi secara otomatis oleh sistem dan tidak bisa melakukan
                        perubahan data secara manual.</div>
                </div>
            </div>
        </div>
    </div>

    @include('rekap_pelatihan.uploadfile_offcanvas')
    @include('rekap_pelatihan.detail_offcanvas')
    @include('rekap_pelatihan.update_offcanvas')
@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.datatable.init.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.form-repeater.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/jquery.core.js') }}"></script>

    <script src="{{ URL::asset('public/assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
    {{-- <script src="{{ URL::asset('public/assets/js/pages/jquery.analytics_dashboard.init.js') }}"></script> --}}

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('rekap_pelatihan.rekap_pelatihan') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'tema',
                    name: 'tema'
                },
                {
                    data: 'penyelenggara',
                    name: 'penyelenggara'
                },
                {
                    data: 'jenis',
                    name: 'jenis'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            columnDefs: [
                // { className: 'text-right', targets: [7, 10, 11, 14, 16] },
                {
                    className: 'text-center',
                    targets: [0, 1, 3, 4, 5, 6]
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

        function reload() {
            table.ajax.reload(null, false);
        };

        function excelPeriode() {
            $('.modalExcelPeriode').modal('show');
        }

        function show_canvas(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('rekap_pelatihan/') }}" + '/' + id + '',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        document.getElementById('offcanvasstartLabel').innerHTML = 'Tema : ' + result.data
                            .tema + ' ' + result.data.status;
                        document.getElementById('detail_tanggal').innerHTML = result.data.tanggal;
                        document.getElementById('detail_time').innerHTML = 'Pukul ' + result.data.time;
                        document.getElementById('detail_penyelenggara').innerHTML = result.data.penyelenggara;
                        document.getElementById('detail_kategori_pelatihan').innerHTML = result.data.jenis;
                        document.getElementById('detail_jml_hari').innerHTML = result.data.jml_hari + ' Hari';
                        document.getElementById('detail_jml_jam_hari').innerHTML = result.data
                            .jml_jam_dlm_hari + ' Jam';
                        document.getElementById('detail_total_jml_hari_jam').innerHTML = result.data.jml_hari *
                            result.data.jml_jam_dlm_hari + ' Jam';
                        document.getElementById('detail_total_peserta').innerHTML = result.data.total_peserta +
                            ' Peserta';
                        document.getElementById('detail_total_peserta_jam').innerHTML = result.data
                            .total_peserta * result.data.jml_hari * result.data.jml_jam_dlm_hari + ' Jam';
                        document.getElementById('detail_peserta').innerHTML = result.data.peserta;

                        if (result.data.file_sertifikat == null) {
                            document.getElementById('detail_file_sertifikat').innerHTML =
                                '<span class="text-danger">File Sertifikat Belum Diupload</span>';
                        } else {
                            document.getElementById('detail_file_sertifikat').innerHTML = '<a href=' + result
                                .data.file_sertifikat +
                                ' class="btn btn-primary" target="_blank"><i class="fa fa-download"></i> ' +
                                'Download File Sertifikat' + '</a>';
                        }

                        if (result.data.file_absensi == null) {
                            document.getElementById('detail_file_absensi').innerHTML =
                                '<span class="text-danger">File Absensi Belum Diupload</span>';
                        } else {
                            document.getElementById('detail_file_absensi').innerHTML = '<a href=' + result.data
                                .file_absensi +
                                ' class="btn btn-primary" target="_blank"><i class="fa fa-download"></i> ' +
                                'Download File Absensi' + '</a>';
                        }

                        var myOffcanvas = document.getElementById('offcanvasstart');
                        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
                        bsOffcanvas.show();
                    } else {

                    }
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        };

        function upload_file(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('rekap_pelatihan/') }}" + '/' + id + '',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        document.getElementById('offcanvasuploadLabel').innerHTML = 'Tema : ' + result.data
                            .tema + ' ' + result.data.status;
                        $('#upload_id').val(result.data.id);
                        document.getElementById('upload_tanggal').innerHTML = result.data.tanggal;
                        document.getElementById('upload_time').innerHTML = 'Pukul ' + result.data.time;
                        document.getElementById('upload_penyelenggara').innerHTML = result.data.penyelenggara;
                        document.getElementById('upload_kategori_pelatihan').innerHTML = result.data.jenis;
                        document.getElementById('upload_jml_hari').innerHTML = result.data.jml_hari + ' Hari';
                        document.getElementById('upload_jml_jam_hari').innerHTML = result.data
                            .jml_jam_dlm_hari + ' Jam';
                        document.getElementById('upload_total_jml_hari_jam').innerHTML = result.data.jml_hari *
                            result.data.jml_jam_dlm_hari + ' Jam';
                        document.getElementById('upload_total_peserta').innerHTML = result.data.total_peserta +
                            ' Peserta';
                        document.getElementById('upload_total_peserta_jam').innerHTML = result.data
                            .total_peserta * result.data.jml_hari * result.data.jml_jam_dlm_hari + ' Jam';
                        document.getElementById('upload_peserta').innerHTML = result.data.peserta;

                        if (result.data.file_sertifikat == null) {
                            // document.getElementById('upload_file_sertifikat').innerHTML = '<input type="file" name="upload_file_sertifikat" class="form-control" onChange="javascript:this.form.submit();" id="uploads_file_sertifikat">';
                            document.getElementById('upload_file_sertifikat').innerHTML =
                                '<div class="input-group">' +
                                '<input type="file" name="upload_file_sertifikat" class="form-control" id="uploads_file_sertifikat">' +
                                '<button class="btn btn-primary" type="submit"><i class="fa fa-upload"></i> Upload</button>'
                            '</div>';
                        } else {
                            document.getElementById('upload_file_sertifikat').innerHTML = '<a href=' + result
                                .data.file_sertifikat +
                                ' class="btn btn-primary" target="_blank"><i class="fa fa-download"></i> ' +
                                'Download File Sertifikat' + '</a>';
                        }

                        if (result.data.file_absensi == null) {
                            // document.getElementById('upload_file_absensi').innerHTML = '<input type="file" name="upload_file_absensi" class="form-control" id="uploads_file_absensi">';
                            document.getElementById('upload_file_absensi').innerHTML =
                                '<div class="input-group">' +
                                '<input type="file" name="upload_file_absensi" class="form-control" id="uploads_file_absensi">' +
                                '<button class="btn btn-primary" type="submit"><i class="fa fa-upload"></i> Upload</button>'
                            '</div>';
                        } else {
                            document.getElementById('upload_file_absensi').innerHTML = result.data.file_absensi;
                        }

                        var myOffcanvas = document.getElementById('offcanvasUpload');
                        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
                        bsOffcanvas.show();
                    } else {

                    }
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        // $('#uploads_file_sertifikat').change(function(){
        //     // $('#upload_file').submit();
        //     alert('test');
        // });

        // document.getElementById("uploads_file_sertifikat").onchange = function() {
        //     // submitting the form
        //     document.getElementById("upload_file").submit();
        // };

        $('#upload_files').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('rekap_pelatihan.upload_file') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
                    document.getElementById('upload_file_sertifikat').innerHTML =
                        '<div class="spinner-border text-primary" role="status">' +
                        '<span class="sr-only">Loading...</span>' + '</div>';
                    document.getElementById('upload_file_absensi').innerHTML =
                        '<div class="spinner-border text-primary" role="status">' +
                        '<span class="sr-only">Loading...</span>' + '</div>';
                },
                success: (result) => {
                    if (result.success != false) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        table.ajax.reload();
                        $.ajax({
                            type: 'GET',
                            url: "{{ url('rekap_pelatihan/') }}" + '/' + result.id + '',
                            contentType: "application/json;  charset=utf-8",
                            cache: false,
                            success: (result) => {
                                if (result.success == true) {
                                    if (result.data.file_sertifikat == null) {
                                        setTimeout(() => {
                                            document.getElementById(
                                                    'upload_file_sertifikat').style
                                                .display = "none";
                                        }, 1000);
                                        document.getElementById('upload_file_sertifikat')
                                            .innerHTML = '<div class="input-group">' +
                                            '<input type="file" name="upload_file_sertifikat" class="form-control" id="uploads_file_sertifikat">' +
                                            '<button class="btn btn-primary" type="submit"><i class="fa fa-upload"></i> Upload</button>'
                                        '</div>';
                                    } else {
                                        document.getElementById('upload_file_sertifikat')
                                            .innerHTML = '<a href=' + result.data
                                            .file_sertifikat +
                                            ' class="btn btn-primary" target="_blank"><i class="fa fa-download"></i> ' +
                                            'Download File Sertifikat' + '</a>';
                                    }

                                    if (result.data.file_absensi == null) {
                                        document.getElementById('upload_file_absensi')
                                            .innerHTML = '<div class="input-group">' +
                                            '<input type="file" name="upload_file_absensi" class="form-control" id="uploads_file_absensi">' +
                                            '<button class="btn btn-primary" type="submit"><i class="fa fa-upload"></i> Upload</button>'
                                        '</div>';
                                    } else {
                                        document.getElementById('upload_file_absensi')
                                            .innerHTML = '<a href=' + result.data
                                            .file_absensi +
                                            ' class="btn btn-primary" target="_blank"><i class="fa fa-download"></i> ' +
                                            'Download File Absensi' + '</a>';
                                    }

                                } else {

                                }
                            },
                            error: function(request, status, error) {
                                iziToast.error({
                                    title: 'Error',
                                    message: error,
                                });
                            }
                        });
                    } else {
                        iziToast.error({
                            title: result.success,
                            message: result.error
                        });
                    }
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
            // alert('test');
        });

        function update_canvas(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('rekap_pelatihan/') }}" + '/' + id + '',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        document.getElementById('offcanvasRightLabel').innerHTML = 'Tema : ' + result.data
                            .tema + ' ' + result.data.status;
                        $('#update_id').val(result.data.id);
                        document.getElementById('update_tanggal').innerHTML = result.data.tanggal;
                        document.getElementById('update_time').innerHTML = 'Pukul ' + result.data.time;
                        document.getElementById('update_penyelenggara').innerHTML = result.data.penyelenggara;
                        document.getElementById('update_kategori_pelatihan').innerHTML = result.data.jenis;
                        document.getElementById('update_jml_hari').innerHTML = result.data.jml_hari + ' Hari';
                        $('#text_update_jml_hari').val(result.data.jml_hari);
                        document.getElementById('update_total_jml_hari_jam').innerHTML = result.data.jml_hari *
                            result.data.jml_jam_dlm_hari + ' Jam';
                        $('#text_update_total_jml_hari_jam').val(result.data.jml_jam_dlm_hari);
                        document.getElementById('update_total_peserta').innerHTML = result.data.total_peserta +
                            ' Peserta';
                        $('#text_update_total_peserta').val(result.data.total_peserta);
                        document.getElementById('update_total_peserta_jam').innerHTML = 0;
                        var myOffcanvas = document.getElementById('offcanvasRight');
                        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
                        bsOffcanvas.show();
                    } else {

                    }
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        };

        function hitung() {
            const jml_jam_hari = $('#update_jml_jam_hari').val();
            const hitung_pelatihan_kali_jam = $('#text_update_jml_hari').val() * $('#update_jml_jam_hari').val();

            document.getElementById('update_total_jml_hari_jam').innerHTML =
                '<div class="spinner-border text-primary" role="status">' + '<span class="sr-only">Loading...</span>' +
                '</div>';
            document.getElementById('update_total_peserta_jam').innerHTML =
                '<div class="spinner-border text-primary" role="status">' + '<span class="sr-only">Loading...</span>' +
                '</div>';

            setTimeout(() => {
                document.getElementById('update_total_jml_hari_jam').innerHTML = hitung_pelatihan_kali_jam + ' Jam';
                $('#text_update_total_jml_hari_jam').val(hitung_pelatihan_kali_jam);
                const hitung_total_peserta_kali_jam = hitung_pelatihan_kali_jam * $('#text_update_total_peserta')
                    .val();
                document.getElementById('update_total_peserta_jam').innerHTML = hitung_total_peserta_kali_jam +
                    ' Jam';
                // $('.modalLoading').modal('hide');
                // window.location.href = "{{ route('rekap_pelatihan.rekap_pelatihan') }}";
            }, 3000);
        };

        $('#canvas_right_update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('rekap_pelatihan.canvas_right_update') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
                },
                success: (result) => {
                    if (result.success != false) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });

                        var myOffcanvas = document.getElementById('offcanvasRight');
                        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
                        bsOffcanvas.hide();

                        table.ajax.reload(null, false);
                        // setTimeout(() => {
                        //     $('.modalLoading').modal('hide');
                        //     window.location.href = "{{ route('rekap_pelatihan.rekap_pelatihan') }}";
                        // }, 3000);
                    } else {
                        iziToast.error({
                            title: result.success,
                            message: result.error
                        });
                    }
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        });

        function hapus(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('rekap_pelatihan/') }}" + '/' + id + '/delete',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        table.ajax.reload(null, false);
                    } else {

                    }
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        $('#search_rekap_all').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('rekap_pelatihan.search_excel_rekap_pelatihan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
                    document.getElementById('view_download').innerHTML = "<div class='spinner-border spinner-border-custom-2 text-primary' role='status'></div>";
                },
                success: (result) => {
                    //     ' <a href="#" class="btn btn-primary btn-xs">Download All Rekap</a>'+
                    //     ' <a href="#" class="btn btn-primary btn-xs">Download Rekap All Departemen</a>'+
                    //     ' <a href="#" class="btn btn-primary btn-xs">Download Total Pelatihan</a>'
                    //     ;
                    document.getElementById('view_download').innerHTML =
                        '<table class="table mb-0 table-centered">' +
                        '<tr>' +
                        '<td class="text-center" colspan="3" style="font-weight: bold; font-size: 12pt">' +
                        result.title + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td class="text-center">' + '<a href=' + result.link_rekap +
                        ' class="btn btn-primary"><i class="fa fa-download"></i> Download Rekap Pelatihan</a>' +
                        '</td>' +
                        '<td class="text-center">' + '<a href=' + result.link_rekap_all_dep +
                        ' class="btn btn-primary"><i class="fa fa-download"></i> Download Rekap All Departemen</a>' +
                        '</td>' +
                        '<td class="text-center">' + '<a href=' + result.link_rekap_periode +
                        ' class="btn btn-primary"><i class="fa fa-download"></i> Download Rekap Total Pelatihan / Seminar</a>' +
                        '</td>' +
                        // '<td class="text-center">'+'<a href='+result.link_rekap_all_pelatihan+' class="btn btn-primary"><i class="fa fa-download"></i> Download Total Pelatihan</a>'+'</td>'+
                        '</tr>' +
                        '</table>';
                    // alert(result);
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        });

        var options = {
            chart: {
                height: 320,
                type: 'area',
                stacked: true,
                toolbar: {
                    show: false,
                    autoSelected: 'zoom'
                },
            },
            colors: ['#2af44f', '#2a77f4'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: [1.5, 1.5],
                dashArray: [0, 4],
                lineCap: 'round',
            },
            grid: {
                padding: {
                    left: 0,
                    right: 0
                },
                strokeDashArray: 3,
            },
            markers: {
                size: 0,
                hover: {
                    size: 0
                }
            },
            series: [
                {
                    name: 'Total Rekap Pelatihan Selesai',
                    data: @json($total_hasil_rekap_done)
                    // data: [0, 60, 20, 90, 45, 110, 55, 130, 44, 110, 75, 120]
                }, 
                {
                    name: 'Total Rekap Pelatihan Planning',
                    data: @json($total_hasil_rekap_plan)
                    // data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 2]
                },
            ],

            xaxis: {
                type: 'month',
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                axisBorder: {
                    show: true,
                },
                axisTicks: {
                    show: true,
                },
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                }
            },

            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right'
            },
        }

        var chart = new ApexCharts(
            document.querySelector("#ana_dash_1"),
            options
        );

        chart.render();
    </script>
@endsection
