@extends('layouts.apps.master')
@section('title')
    Sertifikasi Mesin Produksi
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
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
    @include('sertifikasi.mesin_produksi.modalExcelPeriode')
    @include('sertifikasi.mesin_produksi.modalBuat')
    @include('sertifikasi.mesin_produksi.modalDetail')
    @include('sertifikasi.mesin_produksi.modalEdit')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
                            {{-- @can('role-create')
                                <button class="btn btn-outline-primary" onclick="buat()" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalCenter"><i class="fas fa-plus"></i> Create New Permission</button>
                                <button class="btn btn-outline-primary" onclick="reload()"><i class="fas fa-undo"></i> Reload
                                    Data</button>
                            @endcan --}}
                            {{-- <button class="btn btn-primary" onclick="window.location.href='{{ route('hrga.sertifikasi.mesin_produksi.create') }}'"><i class="fas fa-plus"></i> Buat Baru</button> --}}
                            <a href="{{ route('hrga.sertifikasi.mesin_produksi.download_pdf') }}" target="_blank" class="btn btn-danger"><i class="far fa-file-pdf"></i> Download PDF</a>
                            <button class="btn btn-primary" onclick="buat()"><i class="fas fa-plus"></i> Buat Baru</button>
                            <button class="btn btn-primary" onclick="reload()"><i class="fas fa-undo"></i> Refresh</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Jenis Mesin</th>
                                <th>No. Sertifikat</th>
                                <th>Tgl. Sertifikat Pertama</th>
                                <th>Status</th>
                                <th>Action</th>
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
    <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('hrga.sertifikasi.mesin_produksi') }}",
            columns: [
                {
                    data: 'jenis_mesin',
                    name: 'jenis_mesin'
                },
                {
                    data: 'no_sertifikat',
                    name: 'no_sertifikat'
                },
                {
                    data: 'tgl_sertifikat_pertama',
                    name: 'tgl_sertifikat_pertama'
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
            ]
        });

        function buat()
        {
            $('.modalBuat').modal('show');
        }

        function reload()
        {
            table.ajax.reload(null,false);
        }
        
        function download_excel()
        {
            $('.modalExcelPeriode').modal('show');
        }

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('hrga.sertifikasi.mesin_produksi.simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    Swal.fire({
                        title: "Silahkan Tunggu!",
                        html: "Data Sedang Diproses",
                        onBeforeOpen: function() {
                            Swal.showLoading(), t = setInterval(function() {
                                Swal.getContent().querySelector("strong").textContent = Swal
                                    .getTimerLeft()
                            }, 100)
                        },
                        onClose: function() {
                            clearInterval(t)
                        }
                    }).then(function(t) {
                        t.dismiss === Swal.DismissReason.timer && console.log("I was closed by the timer")
                    })
                },
                success: (result) => {
                    if (result.success != false) {
                        // iziToast.success({
                        //     title: result.message_title,
                        //     message: result.message_content
                        // });
                        Swal.fire({
                            icon: "success",
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.reset();
                        $('.modalBuat').modal('hide');
                        table.ajax.reload(null,false);
                    } else {
                        // iziToast.error({
                        //     title: result.success,
                        //     message: result.error
                        // });
                        Swal.fire({
                            icon: "error",
                            title: result.message_title,
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

        function detail(id)
        {
            $.ajax({
                type:'GET',
                url: "{{ url('hrga/sertifikasi/mesin_produksi/') }}"+'/'+id+'',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if(result.success == true){
                        document.getElementById('detail_jenis_mesin').innerHTML = result.data.jenis_mesin;
                        document.getElementById('detail_no_sertifikat').innerHTML = result.data.no_sertifikat;
                        document.getElementById('detail_tgl_sertifikat_pertama').innerHTML = result.data.tgl_sertifikat_pertama;
                        document.getElementById('detail_periode_resertifikasi').innerHTML = result.data.periode_resertifikasi+" Tahun";

                        var mesinList = result.data_list;
                        var txt = "";
                        mesinList.forEach(data_mesin_list);

                        function data_mesin_list(value,index)
                        {
                            txt = txt+"<tr>";
                            txt = txt+  "<td class='text-center'>"+value.tgl_periksa_uji+"</td>";
                            txt = txt+  "<td class='text-center'>"+value.tgl_terbit_sertifikat+"</td>";
                            txt = txt+  "<td class='text-center'>"+value.no_sertifikat_terakhir+"</td>";
                            txt = txt+  "<td class='text-center'>"+value.tgl_resertifikat_selanjutnya+"</td>";
                            txt = txt+"</tr>";
                        }

                        document.getElementById('detail_mesin_list').innerHTML = txt;

                        $('.modalDetail').modal('show');
                    }else{

                    }
                },
                error: function (request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        function edit(id)
        {
            $.ajax({
                type:'GET',
                url: "{{ url('hrga/sertifikasi/mesin_produksi/') }}"+'/'+id+'',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if(result.success == true){
                        $('#edit_id').val(result.data.id);
                        $('#edit_jenis_mesin').val(result.data.jenis_mesin);
                        $('#edit_no_sertifikat').val(result.data.no_sertifikat);
                        $('#edit_tgl_sertifikat_pertama').val(result.data.tgl_sertifikat_pertama);
                        $('#edit_periode_resertifikasi').val(result.data.periode_resertifikasi);
                        $('.modalEdit').modal('show');
                    }else{

                    }
                },
                error: function (request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        function hapus(id, mesin_list_id) {
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda tidak dapat mengembalikannya!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "$success",
                cancelButtonColor: "$danger",
                confirmButtonText: "Yes, delete it!"
            }).then(function(t) {
                t.value && $.ajax({
                    type: 'GET',
                    url: "{{ url('hrga/sertifikasi/mesin_produksi/') }}" + '/' + id + '/' + 'delete',
                    contentType: "application/json;  charset=utf-8",
                    cache: false,
                    success: (result) => {
                        if (result.success == true) {
                            Swal.fire({
                                icon: "success",
                                title: result.message_title,
                                text: result.message_content,
                                showConfirmButton: false,
                                timer: 1500
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
            })
        }

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('hrga.sertifikasi.mesin_produksi.update') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    Swal.fire({
                        title: "Silahkan Tunggu!",
                        html: "Data Sedang Diproses",
                        onBeforeOpen: function() {
                            Swal.showLoading(), t = setInterval(function() {
                                Swal.getContent().querySelector("strong").textContent = Swal
                                    .getTimerLeft()
                            }, 100)
                        },
                        onClose: function() {
                            clearInterval(t)
                        }
                    }).then(function(t) {
                        t.dismiss === Swal.DismissReason.timer && console.log("I was closed by the timer")
                    })
                },
                success: (result) => {
                    if (result.success != false) {
                        // iziToast.success({
                        //     title: result.message_title,
                        //     message: result.message_content
                        // });
                        Swal.fire({
                            icon: "success",
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.reset();
                        $('.modalEdit').modal('hide');
                        table.ajax.reload(null,false);
                    } else {
                        // iziToast.error({
                        //     title: result.success,
                        //     message: result.error
                        // });
                        Swal.fire({
                            icon: "error",
                            title: result.message_title,
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
    </script>
@endsection
