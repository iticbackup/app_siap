@extends('layouts.apps.master')
@section('title')
    DC Kategori
@endsection
@section('css')
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

    @include('dc.category.modalBuat')
    @include('dc.category.modalEdit')

    @include('components.alert')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
                            {{-- <a class="btn btn-outline-primary" href="#"><i class="fa fa-plus"></i> Create New Permission</a> --}}
                            <button class="btn btn-primary" onclick="buat()" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter"><i class="fas fa-plus"></i> Buat Baru</button>
                            <button class="btn btn-primary" onclick="reload()"><i class="fas fa-undo"></i> Reload
                                Data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Kategori</th>
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
    <script src="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.sweet-alert.init.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.datatable.init.js') }}"></script>
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
            ajax: "{{ route('dc.category') }}",
            columns: [
                {
                    data: 'dc_category',
                    name: 'dc_category'
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

        function reload() {
            table.ajax.reload();
        }

        function buat() {
            $('.modalBuat').modal('show');
        }

        function edit(id) {
            $.ajax({
                type:'GET',
                url: "{{ url('document_control/category/') }}"+'/'+id+'',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if(result.success == true){
                        $('#edit_id').val(result.data.id);
                        $('#edit_dc_category').val(result.data.dc_category);
                        $('#edit_status').val(result.data.status);
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
                    type:'POST',
                    url: "{{ route('dc.category.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if(result.success != false){
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalBuat').modal('hide');
                            table.ajax.reload();
                        }else{
                            iziToast.error({
                                title: result.success,
                                message: result.error
                            });
                        }
                    },
                    error: function (request, status, error) {
                        iziToast.error({
                            title: 'Error',
                            message: error,
                        });
                    }
                });
            })
        });

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
                    type:'POST',
                    url: "{{ route('dc.category.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (result) => {
                        if(result.success != false){
                            iziToast.success({
                                title: result.message_title,
                                message: result.message_content
                            });
                            $('.modalEdit').modal('hide');
                            table.ajax.reload();
                        }else{
                            iziToast.error({
                                title: result.success,
                                message: result.error
                            });
                        }
                    },
                    error: function (request, status, error) {
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