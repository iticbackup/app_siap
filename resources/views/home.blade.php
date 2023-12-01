{{-- @extends('layouts.app') --}}
@extends('layouts.apps.master')

@section('title')
    Dashboard
@endsection

@section('css')
    {{-- <link rel="stylesheet" href="https://mannatthemes.com/dastone/plugins/fullcalendar/packages/core/main.css" type="text/css">
<link rel="stylesheet" href="https://mannatthemes.com/dastone/plugins/fullcalendar/packages/daygrid/main.css" type="text/css">
<link rel="stylesheet" href="https://mannatthemes.com/dastone/plugins/fullcalendar/packages/bootstrap/main.css" type="text/css">
<link rel="stylesheet" href="https://mannatthemes.com/dastone/plugins/fullcalendar/packages/timegrid/main.css" type="text/css">
<link rel="stylesheet" href="https://mannatthemes.com/dastone/plugins/fullcalendar/packages/list/main.css" type="text/css">
<link rel="stylesheet" href="https://mannatthemes.com/dastone/plugins/lightpick/lightpick.css" type="text/css"> --}}

    <link href="{{ URL::asset('public/assets/plugins/fullcalendar/packages/core/main.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('public/assets/plugins/fullcalendar/packages/daygrid/main.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('public/assets/plugins/fullcalendar/packages/bootstrap/main.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('public/assets/plugins/fullcalendar/packages/timegrid/main.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('public/assets/plugins/fullcalendar/packages/list/main.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('public/assets/plugins/lightpick/lightpick.css') }}" rel="stylesheet" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dastone
        @endslot
        @slot('li_3')
            @yield('title')
        @endslot
        @slot('title')
            @yield('title')
        @endslot
    @endcomponent
    {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}
    <div class="row">
        {{-- <div class="col-lg-3">

        </div>
        <div class="col-lg-9">

        </div> --}}
        <div class="col-lg-6">
            @forelse ($reminders as $reminder)
                @php
                    $explode_tanggal = explode(',', $reminder->tanggal);
                    $datelive = \Carbon\Carbon::now()
                        // ->addDay(3)
                        ->format('Y-m-d H:i');
                    
                    if (\Carbon\Carbon::create($explode_tanggal[0])->format('Y-m-d') == \Carbon\Carbon::create($explode_tanggal[1])->format('Y-m-d')) {
                        $date = \Carbon\Carbon::create($explode_tanggal[1])->isoFormat('LL');
                        $pukul = \Carbon\Carbon::create($explode_tanggal[0])->format('H:i') . ' - ' . \Carbon\Carbon::create($explode_tanggal[1])->format('H:i');
                    } else {
                        $date = \Carbon\Carbon::create($explode_tanggal[0])->format('d') . ' - ' . \Carbon\Carbon::create($explode_tanggal[1])->isoFormat('LL');
                        $pukul = \Carbon\Carbon::create($explode_tanggal[0])->format('H:i') . ' - ' . \Carbon\Carbon::create($explode_tanggal[1])->format('H:i');
                    }
                    // $start_date = $explode_tanggal[0];
                    // $end_date = $explode_tanggal[1];
                @endphp
                @if (strtotime($datelive) < strtotime($explode_tanggal[0]))
                    <div class="alert custom-alert custom-alert-primary icon-custom-alert shadow-sm fade show d-flex justify-content-between calendar-cta"
                        role="alert">
                        <div class="media">
                            <i
                                class="mdi mdi-calendar-text-outline alert-icon text-primary align-self-center font-30 me-3"></i>
                            <div class="media-body align-self-center">
                                <h5 class="mb-1 fw-bold mt-0">Reminder: {{ $reminder->tema }}</h5>
                                {{-- <div class="mb-1">
                                    <span>{{ $reminder->tema }}</span>
                                </div> --}}
                                <span>Tanggal: {{ $date }} Pukul: {{ $pukul }}</span>
                            </div>
                        </div>
                        <button type="button" class="btn-close align-self-center" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @elseif(strtotime($datelive) >= strtotime($explode_tanggal[0]) && strtotime($datelive) <= strtotime($explode_tanggal[1]))
                    <div class="alert custom-alert custom-alert-warning icon-custom-alert shadow-sm fade show d-flex justify-content-between"
                        role="alert">
                        <div class="media">
                            <i class="mdi mdi-progress-clock alert-icon text-warning align-self-center font-30 me-3"></i>
                            <div class="media-body align-self-center">
                                <h5 class="mb-1 fw-bold mt-0">On Progress: {{ $reminder->tema }}</h5>
                                {{-- <div class="mb-1">
                                    <span><b>{{ $reminder->tema }}</b></span>
                                </div> --}}
                                <span>Tanggal: {{ $date }} Pukul: {{ $pukul }}</span>
                            </div>
                        </div>
                        <button type="button" class="btn-close align-self-center" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
            @empty
            @endforelse
            
            @if (auth()->user()->nik == 1207514 || auth()->user()->nik == 1711952 || auth()->user()->nik == 0000000)
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Total Rekap Pelatihan / Seminar Periode {{ date('Y') }}</div>
                </div>
                <div class="card-body">
                    <div id="ana_dash_1" class="apex-charts"></div>
                </div>
            </div>
            @endif

            {{-- @foreach ($file_manager_perubahan_datas as $file_manager_perubahan_data)
            @if ($file_manager_perubahan_data->is_open == 'y')
            <div class="alert custom-alert custom-alert-primary icon-custom-alert shadow-sm fade show d-flex justify-content-between"
                role="alert">
                <div class="media">
                    <i class="mdi mdi-pencil-outline alert-icon text-primary align-self-center font-30 me-3"></i>
                    <div class="media-body align-self-center">
                        <h5 class="mb-1 fw-bold mt-0">Perubahan Dokumen {{ $file_manager_perubahan_data->kode_formulir.' - '.$file_manager_perubahan_data->departemen->departemen }}</h5>
                    </div>
                </div>
                <button type="button" class="btn-close align-self-center" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
            @endif
            @endforeach --}}

            {{-- <div class="row">
                @if (!$file_manager_perubahan_datas->isEmpty())
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h5>Status Perubahan Dokumen</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav-border nav nav-pills" role="tablist">
                                @foreach ($file_manager_perubahan_datas as $key_tab => $file_manager_perubahan_data_tab)
                                <li class="nav-item">
                                    <a class="nav-link {{ $key_tab+1 == 1 ? 'active' : null }} font-weight-semibold pt-0" data-bs-toggle="tab" href="#Project{{ $key_tab+1 }}_Tab" role="tab">{{ $file_manager_perubahan_data_tab->kode_formulir }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body pt-0">
                            <div class="tab-content">
                                @foreach ($file_manager_perubahan_datas as $key => $file_manager_perubahan_data)
                                <div class="tab-pane {{ $key+1 == 1 ? 'active' : null }}" id="Project{{ $key+1 }}_Tab" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="media mb-3">
                                                <img src="{{ URL::asset('public/assets/images/widgets/project2.jpg') }}" alt="" class="thumb-lg rounded-circle">
                                                <div class="media-body align-self-center text-truncate ms-3">
                                                    <h4 class="m-0 font-weight-semibold text-dark font-16">{{ $file_manager_perubahan_data->kode_formulir }}</h4>
                                                    <p class="text-muted mb-0 font-13"><span class="text-dark">Departemen : </span>{{ $file_manager_perubahan_data->departemen->departemen }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-lg-right">
                                            <h6 class="font-weight-semibold m-0">Tanggal Dibuat : <span class="text-muted font-weight-normal"> {{ $file_manager_perubahan_data->created_at->isoFormat('LLLL') }}</span></h6>
                                            <h6 class="font-weight-semibold  mb-0 mt-2">Tanggal Perubahan : <span class="text-muted font-weight-normal"> {{ $file_manager_perubahan_data->updated_at->isoFormat('LLLL') }}</span></h6>
                                        </div>
                                    </div>

                                    <div class="holder">
                                        <ul class="steppedprogress pt-1">
                                            @if ($file_manager_perubahan_data->is_open == 'y')
                                            <li class="complete continuous"><span>Planing</span></li>
                                            <li class="complete"><span>Waiting Verifikasi</span></li>
                                            <li class="complete"><span>Approved / Rejected</span></li>
                                            @elseif($file_manager_perubahan_data->is_open == 'n')
                                                @if (empty($file_manager_perubahan_data->status))
                                                <li class="complete"><span>Planing</span></li>
                                                <li class="complete continuous"><span>Waiting Verifikasi</span></li>
                                                <li class="complete"><span>Approved / Rejected</span></li>
                                                @else
                                                @php
                                                    $explode_status = explode('|',$file_manager_perubahan_data->status);
                                                @endphp

                                                @if ($explode_status[0] == 'y' && $explode_status[2] == 'y')
                                                    <li class="complete"><span>Planing</span></li>
                                                    <li class="complete"><span>Waiting Verifikasi</span></li>
                                                    <li class="complete finish success"><span>Approved</span></li>
                                                @elseif($explode_status[0] == 'n' && $explode_status[2] == null)
                                                    <li class="complete"><span>Planing</span></li>
                                                    <li class="complete"><span>Waiting Verifikasi</span></li>
                                                    <li class="complete finish danger"><span>Rejected Document Control</span></li>
                                                @elseif($explode_status[0] == 'y' && $explode_status[2] == 'n')
                                                    <li class="complete"><span>Planing</span></li>
                                                    <li class="complete"><span>Waiting Verifikasi</span></li>
                                                    <li class="complete finish danger"><span>Rejected Management Representative</span></li>
                                                @endif

                                                @endif
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="task-box">
                                        <div class="task-priority-icon"><i class="fas fa-circle text-success"></i></div>
                                        <p class="text-muted mb-1">{{ $file_manager_perubahan_data->remaks }}</p>
                                        @if ($file_manager_perubahan_data->is_open == 'y')
                                        <p class="text-muted text-end mb-1">0% Complete</p>
                                        <div class="progress mb-3" style="height: 4px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        @elseif($file_manager_perubahan_data->is_open == 'n')
                                            @if (empty($file_manager_perubahan_data->status))
                                            <p class="text-muted text-end mb-1">25% Complete</p>
                                            <div class="progress mb-3" style="height: 4px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            @else
                                                @php
                                                    $explode_status = explode('|',$file_manager_perubahan_data->status);
                                                @endphp
                                                @if ($explode_status[0] == 'y' && $explode_status[2] == 'y')
                                                <p class="text-muted text-end mb-1">100% Complete</p>
                                                <div class="progress mb-3" style="height: 4px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                @elseif($explode_status[0] == 'y' && $explode_status[2] == null)
                                                <p class="text-muted text-end mb-1">75% Complete</p>
                                                <div class="progress mb-3" style="height: 4px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                @elseif($explode_status[0] == 'n' && $explode_status[2] == null)
                                                <p class="text-muted text-end mb-1">100% Complete</p>
                                                <div class="progress mb-3" style="height: 4px;">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                @elseif($explode_status[0] == 'y' && $explode_status[2] == 'n')
                                                <p class="text-muted text-end mb-1">100% Complete</p>
                                                <div class="progress mb-3" style="height: 4px;">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div> --}}

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h5>Status Perubahan Dokumen</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav-border nav nav-pills" role="tablist">
                                @foreach ($departemens as $key_tab => $departemen)
                                <li class="nav-item">
                                    <a class="nav-link {{ $key_tab+1 == 1 ? 'active' : null }} font-weight-semibold pt-0" data-bs-toggle="tab" href="#Project{{ $key_tab+1 }}_Tab" role="tab">{{ $departemen->departemen }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body pt-0">
                            <div class="tab-content">
                                @foreach ($departemens as $key => $departemen)
                                @php
                                    $file_manager_perubahan_datas = \App\Models\FileManagerPerubahanData::where('departemen_id',$departemen->id)
                                                                                                        ->whereYear('tanggal_formulir',$year)
                                                                                                        ->whereMonth('tanggal_formulir',$month)
                                                                                                        ->orderBy('created_at','desc')
                                                                                                        ->get();
                                @endphp
                                <div class="tab-pane {{ $key+1 == 1 ? 'active' : null }}" id="Project{{ $key+1 }}_Tab" role="tabpanel">
                                    @foreach ($file_manager_perubahan_datas as $key_file_perubahan => $file_manager_perubahan_data)
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="media mb-3">
                                                    <img src="{{ URL::asset('public/assets/images/widgets/project2.jpg') }}" alt="" class="thumb-lg rounded-circle">
                                                    <div class="media-body align-self-center text-truncate ms-3">
                                                        <h4 class="m-0 font-weight-semibold text-dark font-16">{{ $file_manager_perubahan_data->kode_formulir }}</h4>
                                                        <p class="text-muted mb-0 font-13"><span class="text-dark">Departemen : </span>{{ $file_manager_perubahan_data->departemen->departemen }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-lg-right">
                                                <h6 class="font-weight-semibold m-0">Tanggal Dibuat : <span class="text-muted font-weight-normal"> {{ $file_manager_perubahan_data->created_at->isoFormat('LLLL') }}</span></h6>
                                                <h6 class="font-weight-semibold  mb-0 mt-2">Tanggal Perubahan : <span class="text-muted font-weight-normal"> {{ $file_manager_perubahan_data->updated_at->isoFormat('LLLL') }}</span></h6>
                                            </div>
                                        </div>
    
                                        <div class="holder">
                                            <ul class="steppedprogress pt-1">
                                                @if ($file_manager_perubahan_data->is_open == 'y')
                                                <li class="complete continuous"><span>Planing</span></li>
                                                <li class="complete"><span>Waiting Verifikasi</span></li>
                                                <li class="complete"><span>Approved / Rejected</span></li>
                                                @elseif($file_manager_perubahan_data->is_open == 'n')
                                                    @if (empty($file_manager_perubahan_data->status))
                                                    <li class="complete"><span>Planing</span></li>
                                                    <li class="complete continuous"><span>Waiting Verifikasi</span></li>
                                                    <li class="complete"><span>Approved / Rejected</span></li>
                                                    @else
                                                    @php
                                                        $explode_status = explode('|',$file_manager_perubahan_data->status);
                                                    @endphp
    
                                                    @if ($explode_status[0] == 'y' && $explode_status[2] == 'y')
                                                        <li class="complete"><span>Planing</span></li>
                                                        <li class="complete"><span>Waiting Verifikasi</span></li>
                                                        <li class="complete finish success"><span>Approved</span></li>
                                                    @elseif ($explode_status[0] == 'y' && $explode_status[2] == null)
                                                        <li class="complete"><span>Planing</span></li>
                                                        <li class="complete continuous"><span>Waiting Verifikasi</span></li>
                                                        <li class="complete"><span>Approved</span></li>
                                                    @elseif($explode_status[0] == 'n' && $explode_status[2] == null)
                                                        <li class="complete"><span>Planing</span></li>
                                                        <li class="complete"><span>Waiting Verifikasi</span></li>
                                                        <li class="complete finish danger"><span>Rejected Document Control</span></li>
                                                    @elseif($explode_status[0] == 'y' && $explode_status[2] == 'n')
                                                        <li class="complete"><span>Planing</span></li>
                                                        <li class="complete"><span>Waiting Verifikasi</span></li>
                                                        <li class="complete finish danger"><span>Rejected Management Representative</span></li>
                                                    @endif
    
                                                    @endif
                                                @endif
                                            </ul>
                                        </div>

                                        <div class="task-box">
                                            <div class="task-priority-icon"><i class="fas fa-circle text-success"></i></div>
                                            <p class="text-muted mb-1">{{ $file_manager_perubahan_data->remaks }}</p>
                                            @if ($file_manager_perubahan_data->is_open == 'y')
                                            <p class="text-muted text-end mb-1">0% Complete</p>
                                            <div class="progress mb-3" style="height: 4px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            @elseif($file_manager_perubahan_data->is_open == 'n')
                                                @if (empty($file_manager_perubahan_data->status))
                                                <p class="text-muted text-end mb-1">25% Complete</p>
                                                <div class="progress mb-3" style="height: 4px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                @else
                                                    @php
                                                        $explode_status = explode('|',$file_manager_perubahan_data->status);
                                                    @endphp
                                                    @if ($explode_status[0] == 'y' && $explode_status[2] == 'y')
                                                    <p class="text-muted text-end mb-1">100% Complete</p>
                                                    <div class="progress mb-3" style="height: 4px;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    @elseif($explode_status[0] == 'y' && $explode_status[2] == null)
                                                    <p class="text-muted text-end mb-1">75% Complete</p>
                                                    <div class="progress mb-3" style="height: 4px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    @elseif($explode_status[0] == 'n' && $explode_status[2] == null)
                                                    <p class="text-muted text-end mb-1">100% Complete</p>
                                                    <div class="progress mb-3" style="height: 4px;">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    @elseif($explode_status[0] == 'y' && $explode_status[2] == 'n')
                                                    <p class="text-muted text-end mb-1">100% Complete</p>
                                                    <div class="progress mb-3" style="height: 4px;">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div id='calendar'></div>
                    <div style='clear:both'></div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
@section('script')
    {{-- <script src="https://mannatthemes.com/dastone/plugins/fullcalendar/packages/core/main.js"></script>
    <script src="https://mannatthemes.com/dastone/plugins/fullcalendar/packages/daygrid/main.js"></script>
    <script src="https://mannatthemes.com/dastone/plugins/fullcalendar/packages/timegrid/main.js"></script>
    <script src="https://mannatthemes.com/dastone/plugins/fullcalendar/packages/interaction/main.js"></script>
    <script src="https://mannatthemes.com/dastone/plugins/fullcalendar/packages/list/main.js"></script>
    <script src="https://mannatthemes.com/dastone/plugins/lightpick/lightpick.js"></script>
    <script src="https://mannatthemes.com/dastone/default/assets/pages/jquery.calendar.js"></script> --}}

    <script src="{{ URL::asset('public/assets/plugins/fullcalendar/packages/core/main.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/fullcalendar/packages/daygrid/main.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/fullcalendar/packages/timegrid/main.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/fullcalendar/packages/interaction/main.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/fullcalendar/packages/list/main.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/lightpick/lightpick.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/apex-charts/apexcharts.min.js') }}"></script>

    {{-- <script src="{{ URL::asset('public/assets/js/pages/jquery.calendar.js') }}"></script> --}}
    <script>
        // $(document).ready(function(){
        //     const memory = navigator.deviceMemory;
        //     // const memory = navigator.hardwareConcurrency;
        //     console.log(`${memory} GB`);
        // });

        // @if (auth()->user()->nik == 1207514 || auth()->user()->nik == 1711952 || auth()->user()->nik == 0000000)

        // document.addEventListener('DOMContentLoaded', function() {
        //     var calendarEl = document.getElementById('calendar');

        //     var calendar = new FullCalendar.Calendar(calendarEl, {
        //         plugins: ['interaction', 'dayGrid', 'timeGrid'],
        //         timeZone: 'local',
        //         locale: 'id',
        //         header: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'dayGridMonth,timeGridWeek,timeGridDay'
        //         },
        //         // defaultDate: '2020-06-12',
        //         defaultDate: Date.now(),
        //         navLinks: false, // can click day/week names to navigate views
        //         selectable: false,
        //         selectMirror: false,
        //         select: function(arg) {
        //             var title = prompt('Event Title:');
        //             if (title) {
        //                 calendar.addEvent({
        //                     title: title,
        //                     start: arg.start,
        //                     end: arg.end,
        //                     allDay: arg.allDay
        //                 })
        //             }
        //             calendar.unselect()
        //         },
        //         editable: false,
        //         eventLimit: true, // allow "more" link when too many events
        //         events: @json($calendars),
        //         // events: [
        //         //     {
        //         //         title: 'Business Lunch',
        //         //         start: '2023-10-03T13:00:00',
        //         //         constraint: 'businessHours',
        //         //         className: 'bg-soft-warning',
        //         //     },
        //         //     {
        //         //         title: 'Meeting',
        //         //         start: '2023-10-03T13:00:00',
        //         //         constraint: 'availableForMeeting', // defined below
        //         //         className: 'bg-soft-purple',
        //         //         textColor: 'white'
        //         //     },
        //         //     {
        //         //         title: 'Conference',
        //         //         start: '2020-06-27',
        //         //         end: '2020-06-29',
        //         //         className: 'bg-soft-primary',
        //         //     },


        //         //     // areas where "Meeting" must be dropped
        //         //     {
        //         //         groupId: 'availableForMeeting',
        //         //         start: '2020-06-11T10:00:00',
        //         //         end: '2020-06-11T16:00:00',
        //         //         title: 'Repeating Event',
        //         //         className: 'bg-soft-purple',
        //         //     },
        //         //     {
        //         //         groupId: 'availableForMeeting',
        //         //         start: '2020-06-15T10:00:00',
        //         //         end: '2020-06-15T16:00:00',
        //         //         title: 'holiday',
        //         //         className: 'bg-soft-success',
        //         //     },

        //         //     // red areas where no events can be dropped

        //         //     {
        //         //         start: '2020-06-06',
        //         //         end: '2020-06-08',
        //         //         overlap: false,
        //         //         title: 'New Event',
        //         //         className: 'bg-soft-pink',
        //         //     }
        //         // ],

                
        //         // eventClick: function(arg) {
        //         //     if (confirm('delete event?')) {
        //         //         arg.event.remove()
        //         //     }
        //         // }
        //     });

        //     calendar.render();
        // });

        // @endif

        @if (auth()->user()->nik == 1207514 || auth()->user()->nik == 1711952 || auth()->user()->nik == 0000000)
            var options = {
                chart: {
                    height: 320,
                    type: 'area',
                    stacked: true,
                    toolbar: {
                        show: false,
                        autoSelected: 'zoom'
                    },
                },
                colors: ['#2af44f', '#2a77f4'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: [1.5, 1.5],
                    dashArray: [0, 4],
                    lineCap: 'round',
                },
                grid: {
                    padding: {
                        left: 0,
                        right: 0
                    },
                    strokeDashArray: 3,
                },
                markers: {
                    size: 0,
                    hover: {
                        size: 0
                    }
                },
                series: [
                    {
                        name: 'Total Rekap Pelatihan Selesai',
                        data: @json($total_hasil_rekap_done)
                        // data: [0, 60, 20, 90, 45, 110, 55, 130, 44, 110, 75, 120]
                    },
                ],

                xaxis: {
                    type: 'month',
                    categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    axisBorder: {
                        show: true,
                    },
                    axisTicks: {
                        show: true,
                    },
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.3,
                        stops: [0, 90, 100]
                    }
                },

                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                },
            }

            var chart = new ApexCharts(
                document.querySelector("#ana_dash_1"),
                options
            );

            chart.render();
        @endif


        // light_datepick
        // new Lightpick({
        //     field: document.getElementById('light_datepick'),
        //     inline: true,
        // });
    </script>
@endsection
