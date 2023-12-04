@extends('layouts.apps.master')
@section('title')
    Rekap Pelatihan Karyawan
@endsection

@section('css')
    <link href="{{ URL::asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css">
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

    @include('hrga.rekap_pelatihan.modalRekap')

    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                            <button class="btn btn-purple" onclick="reload()"><i class="fas fa-undo"></i></button>
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
                                <th class="text-center">Status Pelatihan</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
    <script src="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.sweet-alert.init.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('hrga.rekap_pelatihan') }}",
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
                    data: 'status',
                    name: 'status'
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
                    targets: [0, 1, 3, 4]
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

        function reload() {
            table.ajax.reload(null, false);
        };

        function perbarui(id)
        {
            $.ajax({
                type: 'GET',
                url: "{{ url('hrga/rekap_pelatihan/') }}"+'/'+id+'/detail',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function() {
                },
                success: (result) => {
                    document.getElementById('detail_nama_pelatihan').innerHTML = result.tema;
                    document.getElementById('detail_jenis').innerHTML = result.jenis;
                    document.getElementById('detail_kategori_pelatihan').innerHTML = result.kategori_pelatihan;
                    document.getElementById('detail_penyelenggara').innerHTML = result.penyelenggara;
                    document.getElementById('detail_total_peserta').innerHTML = result.total_peserta;

                    var data_peserta = result.data_peserta;
                    var txt_data_peserta = "";
                    var no = 1;
                    data_peserta.forEach(list_peserta);

                    function list_peserta(value, index) {
                        txt_data_peserta += "<tr>";
                        txt_data_peserta +=     "<td class='text-center'>"+no+"</td>";
                        txt_data_peserta +=     "<td class='text-center'>"+value.peserta+"</td>";
                        txt_data_peserta +=     "<td class='text-center'>"+value.to+"</td>";
                        txt_data_peserta +=     "<td class='text-center'>"+value.peserta+
                                                "<input type='hidden' name='id_hrga_biodata_karyawan[]' value="+value.id_biodata_karyawan+" readonly>"+
                                                "<textarea name='riwayat_training[]' hidden readonly>"+value.riwayat_training+"</textarea>"+
                                                "</td>";
                        txt_data_peserta += "</tr>";
                        no++;
                    }

                    document.getElementById('result_data_peserta').innerHTML = txt_data_peserta;

                    $('.modalRekap').modal('show');
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        $('#form-rekap-pelatihan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            Swal.fire({
                title: 'Apakah sudah yakin?',
                // text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '$success',
                cancelButtonColor: '$danger',
                confirmButtonText: 'Yes'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('hrga.rekap_pelatihan_detail_simpan') }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Proses...',
                                text: 'Data sedang diproses',
                                imageHeight: 80,
                                animation: false,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            })
                        },
                        success: (result) => {
                            if (result.success == true) {
                                Swal.fire(
                                    result.message_title,
                                    result.message_content,
                                    'success'
                                );
                                table.ajax.reload(null, false);

                                $('.modalRekap').modal('hide');
                            }else{
                                var error = result.error;
                                var txt_error = ""
                                error.forEach(fun_error);

                                function fun_error(value, index) {
                                    txt_error += value;
                                }

                                Swal.fire(
                                    'Gagal!',
                                    txt_error,
                                    'error'
                                )
                            }
                        },
                        error: function(request, status, error) {
                            Swal.fire(
                                'Error',
                                error,
                                'error'
                            );
                        }
                    });
                }
            })

            
            // alert('test');
        });
    </script>
@endsection