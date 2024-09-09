@extends('layouts.apps.master')
@section('title')
    List ReSertifikasi - {{ $mesin_produksi->jenis_mesin }}
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
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
    @include('sertifikasi.mesin_produksi.list.modalBuat')
    @include('sertifikasi.mesin_produksi.list.modalEdit')
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="mb-1" style="font-weight: bold">Jenis Mesin</label>
                            <p>{{ $mesin_produksi->jenis_mesin }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="mb-1" style="font-weight: bold">No. Sertifikat</label>
                            <p>{{ $mesin_produksi->no_sertifikat }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="mb-1" style="font-weight: bold">Tanggal Sertifikat Pertama</label>
                            <p>{{ $mesin_produksi->tgl_sertifikat_pertama }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="mb-1" style="font-weight: bold">Periode Resertifikasi</label>
                            <p>{{ $mesin_produksi->periode_resertifikasi }} Tahun</p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <button class="btn btn-secondary"
                            onclick="window.location.href='{{ route('hrga.sertifikasi.mesin_produksi') }}'"><i
                                class="fas fa-arrow-left"></i> Back</button>
                        <button class="btn btn-primary" onclick="buat()"><i class="fas fa-plus"></i> Buat Baru</button>
                        <button class="btn btn-primary" onclick="reload()"><i class="fas fa-undo"></i> Refresh</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Tanggal Periksa Uji</th>
                                <th>Tanggal Terbit Sertifikat</th>
                                <th>No. Sertifikat Terakhir</th>
                                <th>Tanggal Resertifikasi Selanjutnya</th>
                                <th>Keterangan</th>
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
            ajax: "{{ route('hrga.sertifikasi.mesin_produksi.list_mesin', ['id' => $mesin_produksi->id]) }}",
            columns: [{
                    data: 'tgl_periksa_uji',
                    name: 'tgl_periksa_uji'
                },
                {
                    data: 'tgl_terbit_sertifikat',
                    name: 'tgl_terbit_sertifikat'
                },
                {
                    data: 'no_sertifikat_terakhir',
                    name: 'no_sertifikat_terakhir'
                },
                {
                    data: 'tgl_resertifikasi_selanjutnya',
                    name: 'tgl_resertifikasi_selanjutnya'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            'columnDefs': [{
                "targets": [0, 1, 2, 3, 4],
                "className": "text-center",
            }, ],
            order: [
                [0, 'desc']
            ]
        });

        function reload() {
            table.ajax.reload();
        }

        function buat() {
            $('.modalBuat').modal('show');
        }

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('hrga.sertifikasi.mesin_produksi.list_simpan', ['id' => $mesin_produksi->id]) }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    Swal.fire({
                        title: "Silahkan Tunggu!",
                        html: "Data Sedang Diproses",
                        onBeforeOpen: function() {
                            Swal.showLoading(), t = setInterval(function() {
                                Swal.getContent().querySelector("strong")
                                    .textContent = Swal
                                    .getTimerLeft()
                            }, 100)
                        },
                        onClose: function() {
                            clearInterval(t)
                        }
                    }).then(function(t) {
                        t.dismiss === Swal.DismissReason.timer && console.log(
                            "I was closed by the timer")
                    })
                },
                success: (result) => {
                    if (result.success != false) {
                        Swal.fire({
                            icon: "success",
                            title: result.message_title,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.reset();
                        $('.modalBuat').modal('hide');
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: result.error
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

        function edit(id, mesin_list_id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('hrga/sertifikasi/mesin_produksi/') }}" + '/' + id + '/' + 'list' + '/' +
                    mesin_list_id,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        $('#edit_id').val(result.data.id);
                        $('#edit_tgl_periksa_uji').val(result.data.tgl_periksa_uji);
                        $('#edit_tgl_terbit_sertifikat').val(result.data.tgl_terbit_sertifikat);
                        $('#edit_no_sertifikat_terakhir').val(result.data.no_sertifikat_terakhir);
                        $('#edit_keterangan').val(result.data.keterangan);
                        $('.modalEdit').modal('show');
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

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda tidak dapat mengembalikannya!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "$success",
                cancelButtonColor: "$danger",
                confirmButtonText: "Yes, Update it!"
            }).then(function(t) {
                // t.value && Swal.fire("Deleted!", "Your file has been deleted.", "success")
                t.value && $.ajax({
                    type: 'POST',
                    url: "{{ route('hrga.sertifikasi.mesin_produksi.update_list', ['id' => $mesin_produksi->id]) }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: "Silahkan Tunggu!",
                            html: "Data Sedang Diproses",
                            onBeforeOpen: function() {
                                Swal.showLoading(), t = setInterval(function() {
                                    Swal.getContent().querySelector(
                                            "strong")
                                        .textContent = Swal
                                        .getTimerLeft()
                                }, 100)
                            },
                            onClose: function() {
                                clearInterval(t)
                            }
                        }).then(function(t) {
                            t.dismiss === Swal.DismissReason.timer && console.log(
                                "I was closed by the timer")
                        })
                    },
                    success: (result) => {
                        if (result.success != false) {
                            Swal.fire({
                                icon: "success",
                                title: result.message_title,
                                text: result.message_content,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('.modalEdit').modal('hide');
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: result.error
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
            })
            // e.preventDefault();
            // let formData = new FormData(this);
            // $('#image-input-error').text('');
            // $.ajax({
            //     type: 'POST',
            //     url: "{{ route('hrga.sertifikasi.mesin_produksi.update_list', ['id' => $mesin_produksi->id]) }}",
            //     data: formData,
            //     contentType: false,
            //     processData: false,
            //     beforeSend: function() {
            //         Swal.fire({
            //             title: "Silahkan Tunggu!",
            //             html: "Data Sedang Diproses",
            //             onBeforeOpen: function() {
            //                 Swal.showLoading(), t = setInterval(function() {
            //                     Swal.getContent().querySelector("strong")
            //                         .textContent = Swal
            //                         .getTimerLeft()
            //                 }, 100)
            //             },
            //             onClose: function() {
            //                 clearInterval(t)
            //             }
            //         }).then(function(t) {
            //             t.dismiss === Swal.DismissReason.timer && console.log(
            //                 "I was closed by the timer")
            //         })
            //     },
            //     success: (result) => {
            //         if (result.success != false) {
            //             Swal.fire({
            //                 icon: "success",
            //                 title: result.message_title,
            //                 text: result.message_content,
            //                 showConfirmButton: false,
            //                 timer: 1500
            //             });
            //             this.reset();
            //             $('.modalEdit').modal('hide');
            //             table.ajax.reload(null, false);
            //         } else {
            //             Swal.fire({
            //                 icon: "error",
            //                 title: "Gagal!",
            //                 text: result.error
            //             });
            //         }
            //     },
            //     error: function(request, status, error) {
            //         iziToast.error({
            //             title: 'Error',
            //             message: error,
            //         });
            //     }
            // });
        });

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
                    url: "{{ url('hrga/sertifikasi/mesin_produksi/') }}" + '/' + id + '/' + 'list' + '/' +
                        mesin_list_id + '/delete',
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
    </script>
@endsection
