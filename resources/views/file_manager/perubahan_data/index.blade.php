@extends('layouts.apps.master')
@section('title')
    Perubahan Dokumen
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
    @include('file_manager.perubahan_data.modalDownload')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
                            @can('perubahan_dokumen-download_all')
                            <button class="btn btn-success" onclick="download_all()"><i class="fas fa-download"></i> Download All Rekap Perubahan Dokumen</button>
                            @endcan
                            <a class="btn btn-outline-primary" href="{{ route('perubahan_data.buat_nomor_formulir') }}"><i class="fa fa-plus"></i> Buat
                                Perubahan Dokumen</a>
                            {{-- <button class="btn btn-outline-primary" onclick="buat()"><i class="fas fa-plus"></i> Buat
                                Perubahan Dokumen</button> --}}
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
                                <th>#</th>
                                <th>Kode Formulir</th>
                                <th>Departemen</th>
                                <th>Tanggal Formulir Dibuat</th>
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('perubahan_data') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'kode_formulir',
                    name: 'kode_formulir'
                },
                {
                    data: 'departemen_id',
                    name: 'departemen_id'
                },
                {
                    data: 'tanggal_formulir',
                    name: 'tanggal_formulir'
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
                { className: 'text-center', targets: [0,1,2,3,4] },
            ],
            order: [[0, 'desc']]
        });

        function reload() {
            table.ajax.reload();
        }

        function download_all() {
            // alert('test');
            $('.modalDownloadPeriode').modal('show');
        }
    </script>
@endsection
