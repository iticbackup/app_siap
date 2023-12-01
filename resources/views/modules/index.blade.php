@extends('layouts.apps.master')
@section('title')
    Modules
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
    <link href="{{ URL::asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css">
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

    @include('modules.modalBuatUpload')
    @include('modules.modalEditUpload')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
                            {{-- <a class="btn btn-outline-primary" href="#"><i class="fa fa-plus"></i> Create New Permission</a> --}}
                            <button class="btn btn-outline-primary" onclick="buat()"><i class="fas fa-plus"></i> Create New</button>
                            <button class="btn btn-outline-primary" onclick="reload()"><i class="fas fa-undo-alt"></i> Reload</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables" class="display table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Action</th>
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
    <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.form-upload.init.js') }}"></script>
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
            ajax: "{{ route('b_module') }}",
            columns: [
                {
                    data: 'title',
                    name: 'title'
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

        function reload() {
            table.ajax.reload();
        }

        function buat() {
            $('.modalBuatUpload').modal('show');
        }

        function edit(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('b_modules/') }}" + '/' + id,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function(xhr) {
                },
                success: (result) => {
                    if (result.success == true) {
                        $('#edit_id').val(result.data.id);
                        $('#edit_title').val(result.data.title);
                        $('.modalEditUpload').modal('show');
                    } else {

                    }
                },
                error: function(request, status, error) {

                }
            });
        }

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('b_module.simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (result) => {
                    if (result.success != false) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        this.reset();
                        table.ajax.reload();
                        $('.modalBuatUpload').modal('hide');
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

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('b_module.update') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (result) => {
                    if (result.success != false) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        this.reset();
                        table.ajax.reload();
                        $('.modalEditUpload').modal('hide');
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

        function hapus_file(id) {
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '$success',
                cancelButtonColor: '$danger',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if (result.value) {
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('b_modules/') }}" + '/' + id + '/' + 'delete',
                        contentType: "application/json;  charset=utf-8",
                        cache: false,
                        beforeSend: function(xhr) {
                            // document.getElementById('data-body').innerHTML = "<tr>" +
                            //     "<td colspan='2' class='text-center'>" +
                            //     "<div class='spinner-border spinner-border-custom-2 text-primary' role='status'></div>" +
                            //     "</td>" +
                            //     "</tr>";
                        },
                        success: (result) => {
                            if (result.success == true) {
                                iziToast.success({
                                    title: result.message_title,
                                    message: result.message_content
                                });
                                table.ajax.reload();
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
                }
            })
        }
    </script>
@endsection