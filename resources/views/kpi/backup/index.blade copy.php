@extends('layouts.apps.master')
@section('title')
    Key Performance Indikator (KPI)
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    {{-- <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" /> --}}
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        {{-- <div class="col-auto">
                            <a class="btn btn-outline-primary" href="{{ route('kpi.buat_kpi') }}"><i class="fa fa-plus"></i> Create New Data</a>
                            <button class="btn btn-outline-primary" onclick="reload()"><i class="fas fa-undo"></i> Reload
                                Data</button>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">Tanggal Pengumpulan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                                {{-- <th class="text-center">Nama</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = $start_date; $i <= $end_date; $i++)
                            @php
                                $date_now = \Carbon\Carbon::today()->format('d-m-Y');
                                // $start_month = \Carbon\Carbon::create($i.'-'.'01')->subMonth()->format('d-m-Y');
                                $start_month = \Carbon\Carbon::create($i.'-'.'01')->format('d-m-Y');
                                $finish_month = \Carbon\Carbon::create($i.'-'.'10')->format('d-m-Y');
                                $convert_date_now = strtotime($date_now);
                                $convert_finish_month = strtotime($finish_month);
                                $explode_start_month = explode('-',$date_now);
                                $explode_finish = explode('-',$finish_month);
                            @endphp
                            <tr>
                                <td class="text-center"><span class="badge badge-outline-primary">{{ $start_month.' sd '.$finish_month }}</span></td>
                                <td class="text-center">
                                    @if ($explode_start_month[2].$explode_start_month[1].$explode_start_month[0] <= $explode_finish[2].$explode_finish[1].$explode_finish[0])
                                        <span class="badge bg-warning">Process</span>
                                    @else
                                        <span class="badge bg-success">Selesai</span>
                                    @endif
                                    {{-- {{ dd($explode_start_month[2].$explode_start_month[1].$explode_start_month[0].' - '.$explode_finish[2].$explode_finish[1].$explode_finish[0]) }} --}}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        {{-- @if (auth()->user()->nik != '1910125' && auth()->user()->nik != '0000000')
                                            @if ($convert_date_now <= $convert_finish_month)
                                            <a href="{{ route('kpi_date',['date' => $finish_month]) }}" class="btn btn-outline-info"><i class="fas fa-plus"></i> Input KPI</a>
                                            @endif
                                        @endif --}}
                                        @if ($explode_start_month[2].$explode_start_month[1].$explode_start_month[0] <= $explode_finish[2].$explode_finish[1].$explode_finish[0])
                                            @if (auth()->user()->nik != '000000' && auth()->user()->nik != '1910125')
                                            <a href="{{ route('kpi_date',['date' => $finish_month]) }}" class="btn btn-outline-info"><i class="fas fa-plus"></i> Input KPI</a>
                                            @endif
                                        @endif
                                        <a href="{{ route('kpi.input_detail_kpi_departemen',['date' => $finish_month]) }}" class="btn btn-outline-primary">KPI Departemen</a>
                                        {{-- <a href="{{ route('kpi.input_date_kpi_detail',['date' => $finish_month]) }}" class="btn btn-outline-primary"><i class="fas fa-eye"></i> Detail KPI</a> --}}
                                    </div>
                                </td>
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
    {{-- <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script> --}}

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // var table = $('#datatables').DataTable({
        //     columnDefs: [
        //         {
        //             className: 'text-center',
        //             targets: [0]
        //         },
        //     ],
        //     order: [
        //         [0, 'desc']
        //     ]
        // });

        // var table = $('#datatables').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "{{ route('kpi') }}",
        //     columns: [
        //         {
        //             data: 'created_at',
        //             name: 'created_at'
        //         },
        //         {
        //             data: 'nama',
        //             name: 'nama'
        //         },
        //         {
        //             data: 'jabatan',
        //             name: 'jabatan'
        //         },
        //         {
        //             data: 'action',
        //             name: 'action',
        //             orderable: false,
        //             searchable: false
        //         },
        //     ],
        //     columnDefs: [
        //         // { className: 'text-right', targets: [7, 10, 11, 14, 16] },
        //         // {
        //         //     className: 'text-center',
        //         //     targets: [0, 1, 3, 4, 5, 6]
        //         // },
        //     ],
        //     order: [
        //         // [0, 'desc']
        //     ]
        // });
    </script>
@endsection
