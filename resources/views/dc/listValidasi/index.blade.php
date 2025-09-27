@extends('layouts.apps.master')
@section('title')
    List Validasi
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css">
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

    @include('dc.listValidasi.disetujui.modalBuat')
    @include('dc.listValidasi.disetujui.modalEdit')

    @include('dc.listValidasi.diperiksa.modalBuat')
    @include('dc.listValidasi.diperiksa.modalEdit')

    @include('dc.listValidasi.dibuat.modalBuat')
    @include('dc.listValidasi.dibuat.modalEdit')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">List Validasi Disetujui</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" onclick="buatDisetujui()" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter"><i class="fas fa-plus"></i> Buat Baru</button>
                            <button class="btn btn-info" onclick="refreshDisetujui()" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter"><i class="fas fa-history"></i> Refresh</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">Nama Validasi</th>
                                <th class="text-center">Departemen</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">List Validasi Diperiksa</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" onclick="buatDiperiksa()" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter"><i class="fas fa-plus"></i> Buat Baru</button>
                            <button class="btn btn-info" onclick="refreshDiperiksa()" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter"><i class="fas fa-history"></i> Refresh</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable2" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">Nama Validasi</th>
                                <th class="text-center">Departemen</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">List Validasi Dibuat</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" onclick="buatDibuat()" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter"><i class="fas fa-plus"></i> Buat Baru</button>
                            <button class="btn btn-info" onclick="refreshDibuat()" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter"><i class="fas fa-history"></i> Refresh</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable3" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">Nama Validasi</th>
                                <th class="text-center">Departemen</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
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

        var table = $('#datatable1').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dc.listValidasi') }}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'departemen_id',
                    name: 'departemen_id'
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
            columnDefs: [{
                className: 'text-center',
                targets: '_all'
            }]
        });

        var table2 = $('#datatable2').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dc.listValidasiDiperiksa') }}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'departemen_id',
                    name: 'departemen_id'
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
            columnDefs: [{
                className: 'text-center',
                targets: '_all'
            }]
        });

        var table3 = $('#datatable3').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dc.listValidasiDibuat') }}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'departemen_id',
                    name: 'departemen_id'
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
            columnDefs: [{
                className: 'text-center',
                targets: '_all'
            }]
        });

        function buatDisetujui() {
            $('.modalBuatDisetujui').modal('show');
        }

        function refreshDisetujui() {
            table.ajax.reload(null, false);
        }

        function editDisetujui(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('document_control/list_validasi/') }}" + '/' + id + '',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: () => {
                    table.ajax.reload(null, false);
                },
                success: (result) => {
                    if (result.success == true) {
                        $('#edit_id_validasi_disetujui').val(result.data.id);
                        $('#edit_name_validasi_disetujui').val(result.data.name);
                        $('#edit_departemen_id_validasi_disetujui').val(result.data.departemen_id);
                        $('#edit_status_validasi_disetujui').val(result.data.status);
                        $('.modalEditDisetujui').modal('show');
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

        function deleteDisetujui(id) {
            let token = $("meta[name='csrf-token']").attr("content");
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data ini tidak bisa dikembalikan ketika dihapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.value == true) {
                    $.ajax({
                        url: "{{ url('document_control/list_validasi/') }}" + '/' + id + '/delete',
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message_title}`,
                                text: response.message_content,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            table.ajax.reload(null, false);
                        }
                    });
                }
            });
        }

        function buatDiperiksa() {
            $('.modalBuatDiperiksa').modal('show');
        }

        function refreshDiperiksa() {
            table2.ajax.reload(null, false);
        }

        function editDiperiksa(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('document_control/list_validasi_diperiksa/') }}" + '/' + id,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: () => {
                    table2.ajax.reload(null, false);
                },
                success: (result) => {
                    if (result.success == true) {
                        // $('#edit_id').val(result.data.id);
                        $('#edit_id_validasi_diperiksa').val(result.data.id);
                        $('#edit_name_validasi_diperiksa').val(result.data.name);
                        $('#edit_departemen_id_validasi_diperiksa').val(result.data.departemen_id);
                        $('#edit_status_validasi_diperiksa').val(result.data.status);
                        // $('#edit_status').val(result.data.status);
                        $('.modalEditDiperiksa').modal('show');
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

        function deleteDiperiksa(id) {
            let token = $("meta[name='csrf-token']").attr("content");
            // console.log('test');
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data ini tidak bisa dikembalikan ketika dihapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                console.log(result.value);
                if (result.value == true) {
                    $.ajax({
                        url: "{{ url('document_control/list_validasi_diperiksa/') }}" + '/' + id + '/delete',
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message_title}`,
                                text: response.message_content,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            table2.ajax.reload(null, false);
                        }
                    });
                }
            });
        }

        function buatDibuat() {
            $('.modalBuatDibuat').modal('show');
        }

        function refreshDibuat() {
            table3.ajax.reload(null, false);
        }

        function editDibuat(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('document_control/list_validasi_dibuat/') }}" + '/' + id,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: () => {
                    table3.ajax.reload(null, false);
                },
                success: (result) => {
                    if (result.success == true) {
                        // $('#edit_id').val(result.data.id);
                        $('#edit_id_validasi_dibuat').val(result.data.id);
                        $('#edit_name_validasi_dibuat').val(result.data.name);
                        $('#edit_departemen_id_validasi_dibuat').val(result.data.departemen_id);
                        $('#edit_status_validasi_dibuat').val(result.data.status);
                        // $('#edit_status').val(result.data.status);
                        $('.modalEditDibuat').modal('show');
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

        function deleteDibuat(id) {
            let token = $("meta[name='csrf-token']").attr("content");
            // console.log('test');
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data ini tidak bisa dikembalikan ketika dihapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                // console.log(result.value);
                if (result.value == true) {
                    $.ajax({
                        url: "{{ url('document_control/list_validasi_dibuat/') }}" + '/' + id + '/delete',
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message_title}`,
                                text: response.message_content,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            table3.ajax.reload(null, false);
                        }
                    });
                }
            });
        }

        $('#form-simpan-disetujui').submit(function(e) {
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
                $.ajax({
                    type: 'POST',
                    url: "{{ route('dc.listValidasiDisetujui.simpan') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if (result.success != false) {
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalBuatDisetujui').modal('hide');
                            table.ajax.reload(null, false);
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
            })
        });

        $('#form-edit-disetujui').submit(function(e) {
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
                $.ajax({
                    type: 'POST',
                    url: "{{ route('dc.listValidasiDisetujui.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if (result.success != false) {
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalEditDisetujui').modal('hide');
                            table.ajax.reload(null, false);
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
            })
        });

        $('#form-simpan-diperiksa').submit(function(e) {
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
                $.ajax({
                    type: 'POST',
                    url: "{{ route('dc.listValidasiDiperiksa.simpan') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if (result.success != false) {
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalBuatDiperiksa').modal('hide');
                            table2.ajax.reload(null, false);
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
            })
        });

        $('#form-edit-diperiksa').submit(function(e) {
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
                $.ajax({
                    type: 'POST',
                    url: "{{ route('dc.listValidasiDiperiksa.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if (result.success != false) {
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalEditDiperiksa').modal('hide');
                            table2.ajax.reload(null, false);
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
            })
        });

        $('#form-simpan-dibuat').submit(function(e) {
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
                $.ajax({
                    type: 'POST',
                    url: "{{ route('dc.listValidasiDibuat.simpan') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if (result.success != false) {
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalBuatDibuat').modal('hide');
                            table3.ajax.reload(null, false);
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
            })
        });

        $('#form-edit-dibuat').submit(function(e) {
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
                $.ajax({
                    type: 'POST',
                    url: "{{ route('dc.listValidasiDibuat.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if (result.success != false) {
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalEditDibuat').modal('hide');
                            table3.ajax.reload(null, false);
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
            })
        });
    </script>
@endsection
