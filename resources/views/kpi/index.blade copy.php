@extends('layouts.apps.master')
@section('title')
    Key Performance Indikator (KPI)
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Laporan KPI</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @foreach ($departemens as $key => $departemen)
                            <div class="accordion-item">
                                <h5 class="accordion-header m-0" id="flush-heading{{ $key }}">
                                    <button class="accordion-button collapsed fw-semibold" style="background-color: #891652; color: white" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $key }}"
                                        aria-expanded="false" aria-controls="flush-collapse{{ $key }}">
                                        <i class="fa fa-briefcase"></i> &nbsp; {{ $departemen->departemen }}
                                    </button>
                                </h5>
                                <div id="flush-collapse{{ $key }}" class="accordion-collapse collapse"
                                    aria-labelledby="flush-heading{{ $key }}"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        @php
                                            $start_date = \Carbon\Carbon::now()->startOfYear()->format('Y-m');
                                            $end_date = \Carbon\Carbon::now()->format('Y-m');
                                        @endphp
                                        @for ($i = $start_date; $i <= $end_date; $i++)
                                        @php
                                            $date_now = \Carbon\Carbon::today()->format('d-m-Y');
                                            $start_month = \Carbon\Carbon::create($i . '-' . '01')->format('d-m-Y');
                                            $finish_month = \Carbon\Carbon::create($i . '-' . '10')->format('d-m-Y');
                                            $convert_date_now = strtotime($date_now);
                                            $convert_start_month = strtotime($start_month);
                                            $convert_finish_month = strtotime($finish_month);
                                        @endphp
                                            @if ($convert_finish_month >= $convert_date_now)
                                            {{-- <td colspan="5">Tanggal Pengumpulan : {{ $start_month . ' s/d ' . $finish_month }}</td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i> Buat KPI</a>
                                            </td> --}}
                                            <div>Batas Tanggal Pengumpulan Terakhir : <span class="badge bg-primary">{{ $start_month . ' s/d ' . $finish_month }}</span></div>
                                            <div class="mt-2 mb-2">
                                                <a href="{{ route('kpi_buat_kpi',['departemen_id' => $departemen->id, 'date' => $date]) }}" class="btn btn-primary btn-md"><i class="fas fa-plus"></i> Buat KPI</a>
                                            </div>
                                            @endif
                                        @endfor
                                        @foreach ($departemen->kpi_team as $kpi_team)
                                            @if ($kpi_team->status == 'y')
                                            @php
                                                $kpis = \App\Models\Kpi::where('kpi_team_id',$kpi_team->id)->get();
                                            @endphp
                                            <h5>Nama : {{ $kpi_team->departemen_user->team }}</h5>
                                            <table class="table table-striped table-bordered table-responsive kpi">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"
                                                            style="background-color: #0B60B0; color: white;">No
                                                        </th>
                                                        <th class="text-center"
                                                            style="background-color: #0B60B0; color: white">Periode
                                                        </th>
                                                        <th class="text-center"
                                                            style="background-color: #0B60B0; color: white">Tanggal Submit
                                                        </th>
                                                        <th class="text-center"
                                                            style="background-color: #0B60B0; color: white">Jabatan
                                                        </th>
                                                        <th class="text-center"
                                                            style="background-color: #0B60B0; color: white">Skor
                                                        </th>
                                                        <th class="text-center"
                                                            style="background-color: #0B60B0; color: white">Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($kpis as $key_kpi => $kpi)
                                                    {{-- @php
                                                        $start_date = \Carbon\Carbon::now()->startOfYear()->format('Y-m');
                                                        $end_date = \Carbon\Carbon::now()->format('Y-m');
                                                    @endphp --}}
                                                    @php
                                                        if ($kpi->nilai > 95) {
                                                            $color_progress = 'success';
                                                        }elseif($kpi->nilai > 85 && $kpi->nilai <= 95) {
                                                            $color_progress = 'success';
                                                        }elseif($kpi->nilai > 75 && $kpi->nilai <= 85) {
                                                            $color_progress = 'success';
                                                        }elseif($kpi->nilai > 60 && $kpi->nilai <= 75) {
                                                            $color_progress = 'warning';
                                                        }elseif($kpi->nilai < 60) {
                                                            $color_progress = 'danger';
                                                        }

                                                        if (!$kpi->nilai) {
                                                            $nilai = 0;
                                                        }else{
                                                            $nilai = $kpi->nilai;
                                                        }
                                                    @endphp
                                                        <tr>
                                                            <td class="text-center">{{ $key_kpi+1 }}</td>
                                                            <td class="text-center">{{ \Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY') }}</td>
                                                            <td class="text-center"><span class="badge bg-primary">{{ \Carbon\Carbon::create($kpi->created_at)->isoFormat('DD MMMM YYYY H:mm:ss') }}</span></td>
                                                            <td class="text-center">{{ $kpi->kpi_team->jabatan }}</td>
                                                            <td class="text-center">
                                                                {{-- {!! !$kpi->nilai ? '<span class="badge bg-warning">Sedang diverifikasi</span>' : $kpi->nilai !!} --}}
                                                                @if (!$kpi->nilai)
                                                                <span class="badge bg-warning">Sedang diverifikasi</span>
                                                                @else
                                                                <div class="progress" style="height: 20px;">
                                                                    <div class="progress-bar bg-{{ $color_progress }} progress-bar-striped" role="progressbar" style="width: {{ $nilai }}%" aria-valuenow="{{ $nilai }}" aria-valuemin="0" aria-valuemax="100">{{ $nilai }}%</div>
                                                                </div>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="btn-group">
                                                                    <a href="{{ route('kpi_detail_kpi',['id' => $kpi->id, 'departemen_id' => $departemen->id]) }}" class="btn btn-sm" style="background-color: #337357; color: white"><i class="fas fa-eye"></i> Lihat KPI</a>
                                                                    <a href="{{ route('kpi_print',['id' => $kpi->id, 'departemen_id' => $departemen->id, 'date' => $kpi->periode]) }}" class="btn btn-sm" style="background-color: #1B3C73; color: white"><i class="fas fa-print"></i> Print</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        {{-- @for ($i = $start_date; $i <= $end_date; $i++)
                                                        @php
                                                            $date_now = \Carbon\Carbon::today()->format('d-m-Y');
                                                            $start_month = \Carbon\Carbon::create($i . '-' . '01')->format('d-m-Y');
                                                            $finish_month = \Carbon\Carbon::create($i . '-' . '10')->format('d-m-Y');
                                                            $convert_date_now = strtotime($date_now);
                                                            $convert_start_month = strtotime($start_month);
                                                            $convert_finish_month = strtotime($finish_month);
                                                        @endphp
                                                        <tr>
                                                            @if ($convert_finish_month >= $convert_date_now)
                                                            <td colspan="5">Tanggal Pengumpulan : {{ $start_month . ' s/d ' . $finish_month }}</td>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i> Buat KPI</a>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                        @endfor --}}
                                                    @empty
                                                        {{-- @for ($i = $start_date; $i <= $end_date; $i++)
                                                        @php
                                                            $date_now = \Carbon\Carbon::today()->format('d-m-Y');
                                                            $start_month = \Carbon\Carbon::create($i . '-' . '01')->format('d-m-Y');
                                                            $finish_month = \Carbon\Carbon::create($i . '-' . '10')->format('d-m-Y');
                                                            $convert_date_now = strtotime($date_now);
                                                            $convert_start_month = strtotime($start_month);
                                                            $convert_finish_month = strtotime($finish_month);
                                                        @endphp
                                                        <tr>
                                                            @if ($convert_finish_month >= $convert_date_now)
                                                            <td colspan="5">Tanggal Pengumpulan : {{ $start_month . ' s/d ' . $finish_month }}</td>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i> Buat KPI</a>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                        @endfor --}}
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            <hr>
                                            @endif
                                        @endforeach
                                        {{-- <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="background-color: #0B60B0; color: white">Periode</th>
                                                <th class="text-center" style="background-color: #0B60B0; color: white">Nama Team</th>
                                                <th class="text-center" style="background-color: #0B60B0; color: white">Jabatan</th>
                                                <th class="text-center" style="background-color: #0B60B0; color: white">Skor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
        $('.kpi').DataTable();
    </script>
@endsection