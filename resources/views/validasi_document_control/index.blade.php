@extends('layouts.apps.master')
@section('title')
    List Validasi Dokumen Kontrol
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
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

    @include('validasi_document_control.validasiRepresentative.modalBuat')
    @include('validasi_document_control.validasiRepresentative.modalEdit')
    
    @include('validasi_document_control.validasiDocumentControl.modalBuat')
    @include('validasi_document_control.validasiDocumentControl.modalEdit')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Validasi Representative</h4>
                        </div>
                        <div class="col-auto">
                            {{-- <a class="btn btn-outline-primary" href="#"><i class="fa fa-plus"></i> Create New Permission</a> --}}
                            <button class="btn btn-primary" onclick="buatRepresentative()"><i class="fas fa-plus"></i> Buat Baru</button>
                            <button class="btn btn-primary" onclick="reloadRepresentative()"><i class="fas fa-undo-alt"></i> Reload</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables" class="display table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Validasi Document Control</h4>
                        </div>
                        <div class="col-auto">
                            {{-- <a class="btn btn-outline-primary" href="#"><i class="fa fa-plus"></i> Create New Permission</a> --}}
                            <button class="btn btn-primary" onclick="buatDocumentControl()"><i class="fas fa-plus"></i> Buat Baru</button>
                            <button class="btn btn-primary" onclick="reloadDocumentControl()"><i class="fas fa-undo-alt"></i> Reload</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables2" class="display table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
            ajax: "{{ route('validasiRepresentative.index') }}",
            columns: [
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama_validasi',
                    name: 'nama_validasi'
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
                // {
                //     className: 'text-center',
                //     targets: [0, 1, 3, 4, 5, 6]
                // },
            ],
            order: [
                // [0, 'desc']
            ]
        });

        function reloadRepresentative() {
            table.ajax.reload(null, false);
        }

        function buatRepresentative(){
            $('.modalBuatRepresentative').modal('show');
        }

        $('#form-simpan').submit(function(e) {
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
                    url: "{{ route('validasiRepresentative.simpan') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if (result.success != false) {
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalBuatRepresentative').modal('hide');
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

        function editRepresentative(id)
        {
            $.ajax({
                type:'GET',
                url: "{{ url('validasi_document_control/representative/') }}"+'/'+id,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if(result.success == true){
                        $('#edit_id').val(result.data.id);
                        $('#edit_team').val(result.data.team);
                        $('#edit_status').val(result.data.status);
                        $('.modalEditRepresentative').modal('show');
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

        $('#form-update').submit(function(e) {
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
                    url: "{{ route('validasiRepresentative.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if (result.success != false) {
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalEditRepresentative').modal('hide');
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

        $('body').on('click', '#deleteRepresentative', function() {
            var id = $(this).data('id');
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
                    type: 'DELETE',
                    url: "{{ url('validasi_document_control/representative/') }}"+'/'+id+'/delete',
                    data: {
                        'id':id,
                        '_token' : '{{ csrf_token() }}'
                    },
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if (result.success != false) {
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
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

        var table2 = $('#datatables2').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('validasiDocumentControl.index') }}",
            columns: [
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama_validasi',
                    name: 'nama_validasi'
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
                // {
                //     className: 'text-center',
                //     targets: [0, 1, 3, 4, 5, 6]
                // },
            ],
            order: [
                // [0, 'desc']
            ]
        });

        function buatDocumentControl(){
            $('.modalBuatDocumentControl').modal('show');
        }

        function reloadDocumentControl() {
            table2.ajax.reload(null, false);
        }

        $('#form-simpan-document-control').submit(function(e) {
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
                    url: "{{ route('validasiDocumentControl.simpan') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if (result.success != false) {
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalBuatDocumentControl').modal('hide');
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

        function editDocumentControl(id)
        {
            $.ajax({
                type:'GET',
                url: "{{ url('validasi_document_control/document_control/') }}"+'/'+id,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if(result.success == true){
                        $('#edit_id_document_control').val(result.data.id);
                        $('#edit_team_document_control').val(result.data.team);
                        $('#edit_status_document_control').val(result.data.status);
                        $('.modalEditDocumentControl').modal('show');
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

        $('#form-update-document-control').submit(function(e) {
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
                    url: "{{ route('validasiDocumentControl.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if (result.success != false) {
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalEditDocumentControl').modal('hide');
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
    </script>
@endsection