@extends('layouts.apps.master')
@section('title')
    Activity Log
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
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
                        <div class="col-auto">
                            <button class="btn btn-outline-primary" onclick="reload()"><i class="fas fa-undo"></i> Reload
                                Data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{ $shetabitVisits->links('pagination::bootstrap-4') }}
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">Method</th>
                                <th class="text-center" style="width: 15%">Url</th>
                                <th class="text-center" style="width: 15%">Referer</th>
                                <th class="text-center" style="width: 15%">Agen</th>
                                <th class="text-center" style="width: 15%">Teknologi</th>
                                <th class="text-center" style="width: 10%">IP</th>
                                <th class="text-center" style="width: 15%">User</th>
                                <th class="text-center" style="width: 15%">Tanggal Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shetabitVisits as $shetabitVisit)
                                <tr>
                                    <td class="text-center">
                                        @switch($shetabitVisit->method)
                                            @case('GET')
                                                <span class="badge bg-success">{{ $shetabitVisit->method }}</span>
                                                @break
                                            @case('POST')
                                                <span class="badge bg-info">{{ $shetabitVisit->method }}</span>
                                                @break
                                            @case('DELETE')
                                                <span class="badge bg-danger">{{ $shetabitVisit->method }}</span>
                                                @break
                                            @default
                                                
                                        @endswitch
                                    </td>
                                    <td style="width: 15%; word-break: break-all">{{ $shetabitVisit->url }}</td>
                                    <td style="width: 15%; word-break: break-all">{{ $shetabitVisit->referer }}</td>
                                    <td style="width: 15%; word-break: break-all">{{ $shetabitVisit->useragent }}</td>
                                    <td style="width: 15%; word-break: break-all">
                                        <ul>
                                            <li>Device : {{ $shetabitVisit->device }}</li>
                                            <li>Platform : {{ $shetabitVisit->platform }}</li>
                                            <li>Browser : {{ $shetabitVisit->browser }}</li>
                                        </ul>
                                    </td>
                                    <td class="text-center" style="width: 10%; word-break: break-all">{{ $shetabitVisit->ip }}</td>
                                    <td class="text-center" style="width: 15%; word-break: break-all">{{ $shetabitVisit->user->name }}</td>
                                    <td class="text-center" style="width: 15%; word-break: break-all">{{ $shetabitVisit->created_at->isoFormat('LLLL') }}</td>
                                </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
                    {{ $shetabitVisits->links('pagination::bootstrap-4') }}
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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // var table = $('#datatables').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "{{ route('activity_log') }}",
        //     columns: [
        //         {
        //             data: 'method',
        //             name: 'method'
        //         },
        //         {
        //             data: 'url',
        //             name: 'url'
        //         },
        //         {
        //             data: 'referer',
        //             name: 'referer'
        //         },
        //         {
        //             data: 'useragent',
        //             name: 'useragent'
        //         },
        //         {
        //             data: 'visitor_id',
        //             name: 'visitor_id'
        //         },
        //         {
        //             data: 'created_at',
        //             name: 'created_at'
        //         },
        //         {
        //             data: 'updated_at',
        //             name: 'updated_at'
        //         },
        //     ],
        //     // columnDefs: [
        //     //     // { className: 'text-right', targets: [7, 10, 11, 14, 16] },
        //     //     { className: 'text-center', targets: [0,2,3,4,5] },
        //     // ],
        //     // order: [[5, 'desc']]
        // });

        // function reload() {
        //     table.ajax.reload(null, false);
        // };
    </script>
@endsection
