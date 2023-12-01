@extends('layouts.apps.master')
@section('title')
    Manage Departemen
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
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
    
    @include('departemen.modalBuat')
    @include('departemen.modalEdit')
    {{-- @include('departemen.modalInputTeam') --}}

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
                            <button class="btn btn-outline-primary" onclick="buat()" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter"><i class="fas fa-plus"></i> Create New Data</button>
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
                                <th>Departemen</th>
                                <th>Team</th>
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('departemen') }}",
            columns: [
                {
                    data: 'departemen',
                    name: 'departemen'
                },
                {
                    data: 'team',
                    name: 'team'
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

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type:'POST',
                url: "{{ route('departemen.simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (result) => {
                    if(result.success != false){
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        this.reset();
                        // $('.modalBuat').hide();
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
        });

        function edit(id) {
            $.ajax({
                type:'GET',
                url: "{{ url('departemen/') }}"+'/'+id+'',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if(result.success == true){
                        $('#edit_id').val(result.data.id);
                        $('#edit_departemen').val(result.data.departemen);
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

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type:'POST',
                url: "{{ route('departemen.update') }}",
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
        });

        function hapus(id) {
            $.ajax({
                type:'GET',
                url: "{{ url('departemen/') }}"+'/'+id+'/delete',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if(result.success == true){
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
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
        }

        // function input_team(id) {
        //     $.ajax({
        //         type:'GET',
        //         url: "{{ url('departemen/') }}"+'/'+id,
        //         contentType: "application/json;  charset=utf-8",
        //         cache: false,
        //         success: (result) => {
        //             if(result.success == true){
        //                 iziToast.success({
        //                     // title: result.message_title,
        //                     // message: result.message_content
        //                 });
        //                 $('.modalInputTeam').modal('toggle');
        //                 // table.ajax.reload();
        //             }else{
        //                 iziToast.error({
        //                     title: result.success,
        //                     message: result.error
        //                 });
        //             }
        //         },
        //         error: function (request, status, error) {
        //             iziToast.error({
        //                 title: 'Error',
        //                 message: error,
        //             });
        //         }
        //     });
        // }
    </script>
@endsection