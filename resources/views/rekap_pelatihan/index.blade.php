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
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success" onclick="excelPeriode()"><i class="far fa-file-excel"></i> Download Excel Rekap All</button>
                            @can('rekap-create')
                            <a class="btn btn-outline-primary" href="{{ route('rekap_pelatihan.create') }}"><i class="fa fa-plus"></i> Create New Data</a>
                            @endcan
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
                                <th class="text-center">Periode</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 2022; $i <= date('Y'); $i++)
                                <tr>
                                    <td>Tahun {{ $i }}</td>
                                    <td><a href="{{ route('rekap_pelatihan.rekap_pelatihan',['periode' => $i]) }}" class="btn btn-primary">Input Rekap</a></td>
                                </tr>
                            @endfor
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
    <script src="{{ URL::asset('public/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.form-repeater.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/jquery.core.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
    </script>
@endsection
