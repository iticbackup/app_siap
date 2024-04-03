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
                                        @foreach ($departemen->kpi_team as $kpi_team)
                                        @if ($kpi_team->departemen_user->status == 'Y')
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
                                                @php
                                                // $start_date = \Carbon\Carbon::now()->startOfYear()->format('Y-m');
                                                // $end_date = \Carbon\Carbon::now()->format('Y-m');
                                                $start_date = \Carbon\Carbon::create(2024, 01)->format('Y-m');
                                                // $end_date = \Carbon\Carbon::create(2024, 05)->subMonth()->format('Y-m');
                                                $end_date = \Carbon\Carbon::now()->subMonth()->format('Y-m');
                                                $no = 1;
                                                @endphp
                                                @for ($i = $start_date; $i <= $end_date; $i++)
                                                    @php
                                                        $date_now = \Carbon\Carbon::today()->format('d-m-Y');
                                                        // $date_now = \Carbon\Carbon::create(2024, 04, 14)->format('d-m-Y');
                                                        $start_month = \Carbon\Carbon::create($i . '-' . '01')->format('d-m-Y');
                                                        $finish_month = \Carbon\Carbon::create($i . '-' . '15')->format('d-m-Y');
                                                        $convert_date_now = strtotime($date_now);
                                                        $convert_start_month = strtotime($start_month);
                                                        $convert_finish_month = strtotime($finish_month);
                                                        // dd($convert_finish_month);

                                                        $kpi = \App\Models\Kpi::where('kpi_team_id',$kpi_team->id)->where('periode','LIKE','%'.$i.'%')->orderBy('created_at','desc')->first();
                                                        if (!empty($kpi)) {
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
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $no }}</td>
                                                        <td class="text-center">{{ !$kpi ? \Carbon\Carbon::create($i)->isoFormat('MMMM YYYY') : \Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY') }}</td>
                                                        @if (!empty($kpi))
                                                            <td class="text-center">
                                                                {!! !$kpi ? '-' : '<span class="badge bg-primary">'.\Carbon\Carbon::create($kpi->created_at)->isoFormat('DD MMMM YYYY H:mm:ss').'</span>' !!}
                                                            </td>
                                                            <td class="text-center">{{ !$kpi ? '-' : $kpi->kpi_team->jabatan }}</td>
                                                            <td class="text-center">
                                                                @if (!$kpi)
                                                                    -
                                                                @elseif(!$kpi->nilai)
                                                                <span class="badge bg-warning">Sedang diverifikasi</span>
                                                                @else
                                                                    @php
                                                                        $explode_status_mengetahui = explode('|',$kpi->status_mengetahui);
                                                                        $explode_status_penilai = explode('|',$kpi->status_penilai);
                                                                    @endphp
                                                                    @if ($explode_status_mengetahui[0]=='n' && $explode_status_penilai[0]=='n')
                                                                    <div><span class="badge bg-danger"><i class="fas fa-times"></i> Rejected</span></div>
                                                                    @elseif($explode_status_mengetahui[0]=='y' && $explode_status_penilai[0]=='n')
                                                                    <div><span class="badge bg-danger"><i class="fas fa-times"></i> Rejected</span></div>
                                                                    @elseif($explode_status_mengetahui[0]=='n' && $explode_status_penilai[0]=='y')
                                                                    <div><span class="badge bg-danger"><i class="fas fa-times"></i> Rejected</span></div>
                                                                    @else
                                                                    <div class="progress" style="height: 20px;">
                                                                        <div class="progress-bar bg-{{ $color_progress }} progress-bar-striped" role="progressbar" style="width: {{ $nilai }}%" aria-valuenow="{{ $nilai }}" aria-valuemin="0" aria-valuemax="100">{{ $nilai }}%</div>
                                                                    </div>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if (!empty($kpi))
                                                                <div class="btn-group">
                                                                    <a href="{{ route('kpi_detail_kpi',['kpi_team_id' => $kpi_team->id, 'periode' => $i]) }}" class="btn btn-sm" style="background-color: #337357; color: white"><i class="fas fa-eye"></i> Lihat KPI</a>
                                                                    
                                                                    @php
                                                                        $explode_status_mengetahui = explode('|',$kpi->status_mengetahui);
                                                                        $explode_status_penilai = explode('|',$kpi->status_penilai);
                                                                    @endphp

                                                                    @if ($explode_status_mengetahui[0]=='n' && $explode_status_penilai[0]=='n')
                                                                    <a href="{{ route('kpi_buat_kpi_team',['departemen_id' => $departemen->id, 'date' => $date, 'team_id' => $kpi_team->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat KPI</a>
                                                                    @endif

                                                                    @if (empty($kpi->status_mengetahui) && empty($kpi->status_penilai))
                                                                    <a href="{{ route('kpi_detail_validasi',['id' => $kpi->id, 'departemen_id' => $departemen->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Go Verification</a> 
                                                                    @elseif(!empty($kpi->status_mengetahui) && empty($kpi->status_penilai))
                                                                    <a href="{{ route('kpi_detail_validasi',['id' => $kpi->id, 'departemen_id' => $departemen->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Go Verification</a> 
                                                                    @elseif(empty($kpi->status_mengetahui) && !empty($kpi->status_penilai))
                                                                    <a href="{{ route('kpi_detail_validasi',['id' => $kpi->id, 'departemen_id' => $departemen->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Go Verification</a> 
                                                                    @endif
                                                                    
                                                                    @if ($explode_status_mengetahui[0]=='y' && $explode_status_penilai[0]=='y')
                                                                    <a href="{{ route('kpi_print',['id' => $kpi->id, 'departemen_id' => $departemen->id, 'date' => $kpi->periode]) }}" class="btn btn-sm" style="background-color: #1B3C73; color: white"><i class="fas fa-print"></i> Print</a>
                                                                    @endif
                                                                </div>
                                                                @endif
                                                                {{-- <div class="btn-group">
                                                                    <a href="{{ route('kpi_detail_kpi',['kpi_team_id' => $kpi_team->id, 'periode' => $i]) }}" class="btn btn-sm" style="background-color: #337357; color: white"><i class="fas fa-eye"></i> Lihat KPI</a>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            @php
                                                                $valid_date_now = \Carbon\Carbon::create($date_now)->subMonth()->format('d-m-Y');
                                                                $convert_valid_date_now = strtotime($valid_date_now);
                                                            @endphp
                                                            @if ($convert_finish_month >= $convert_valid_date_now)
                                                                <td class="text-center" colspan="3"><i class="mdi mdi-calendar-text-outline text-primary"></i> Tanggal Pengumpulan KPI : <b>{{ \Carbon\Carbon::create($start_month)->addMonth()->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::create($finish_month)->addMonth()->format('d-m-Y') }}</b></td>
                                                                <td class="text-center"><a href="{{ route('kpi_buat_kpi',['departemen_id' => $departemen->id, 'date' => $date]) }}" class="btn btn-primary btn-md"><i class="fas fa-plus"></i> Buat KPI</a></td>
                                                            @else
                                                                <td class="text-center"><span class="badge bg-danger">Tidak Mengumpulkan</span></td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                            @endif
                                                        @endif
                                                        {{-- <td class="text-center">
                                                            {!! !$kpi ? '-' : '<span class="badge bg-primary">'.\Carbon\Carbon::create($kpi->created_at)->isoFormat('DD MMMM YYYY H:mm:ss').'</span>' !!}
                                                        </td>
                                                        <td class="text-center">{{ !$kpi ? '-' : $kpi->kpi_team->jabatan }}</td>
                                                        <td class="text-center">
                                                            @if (!$kpi)
                                                                -
                                                            @elseif(!$kpi->nilai)
                                                            <span class="badge bg-warning">Sedang diverifikasi</span>
                                                            @else
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar bg-{{ $color_progress }} progress-bar-striped" role="progressbar" style="width: {{ $nilai }}%" aria-valuenow="{{ $nilai }}" aria-valuemin="0" aria-valuemax="100">{{ $nilai }}%</div>
                                                            </div>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (!empty($kpi))
                                                            <div class="btn-group">
                                                                <a href="{{ route('kpi_detail_kpi',['id' => $kpi->id, 'departemen_id' => $departemen->id]) }}" class="btn btn-sm" style="background-color: #337357; color: white"><i class="fas fa-eye"></i> Lihat KPI</a>
                                                                <a href="{{ route('kpi_print',['id' => $kpi->id, 'departemen_id' => $departemen->id, 'date' => $kpi->periode]) }}" class="btn btn-sm" style="background-color: #1B3C73; color: white"><i class="fas fa-print"></i> Print</a>
                                                            </div>
                                                            @endif
                                                        </td> --}}
                                                    </tr>
                                                    @php
                                                        $no++;
                                                    @endphp
                                                @endfor
                                            </tbody>
                                        </table>
                                        <hr>
                                        @endif
                                        @endforeach
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