@extends('layouts.absensi.new.master')
@section('title')
    Dashboard Absensi
@endsection
@section('content')
    @include('absensi.home.modal_detail_absen_masuk')
    @include('absensi.home.modal_detail_absen_keluar')

    @include('absensi.home.modal_jam_non_absen_masuk')
    @include('absensi.home.modal_jam_non_absen_keluar')

    @include('absensi.home.modal_jam_edit_non_absen_masuk')

    <div class="page-title-container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h1 class="mb-0 pb-0 display-4" id="title">Dashboard</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="Dashboards.Default.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="Dashboards.html">Dashboards</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    @php
        $total_masuk = $fin_pro->whereDate('scan_date',date('Y-m-d'))->count();
        $sakit = $presensi_info->whereDate('scan_date',date('Y-m-d'))->where('status',4)->count();
        $izin = $presensi_info->whereDate('scan_date',date('Y-m-d'))->whereIn('status',[5,6])->count();
        $alpa = $presensi_info->whereDate('scan_date',date('Y-m-d'))->where('status',7)->count();
    @endphp
    <div class="row">
        <div class="col-12 col-xl-12">
            <h2 class="small-title">Status Kehadiran Hari Ini &nbsp; {{ \Carbon\Carbon::now()->isoFormat('LLLL') }}</h2>
            <div class="row gx-2">
                <div class="col-sm-6 col-md-3">
                    <div class="card sh-19">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <i data-acorn-icon="alarm" class="text-primary mb-3"></i>
                            <p class="heading mb-1">Total Masuk</p>
                            <p class="text-muted mb-0">{{ $total_masuk }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card sh-19">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <i data-acorn-icon="alarm" class="text-primary mb-3"></i>
                            <p class="heading mb-1">Sakit</p>
                            <p class="text-muted mb-0">{{ $sakit }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card sh-19">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <i data-acorn-icon="alarm" class="text-primary mb-3"></i>
                            <p class="heading mb-1">Izin</p>
                            <p class="text-muted mb-0">{{ $izin }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card sh-19">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <i data-acorn-icon="alarm" class="text-primary mb-3"></i>
                            <p class="heading mb-1">Alpha</p>
                            <p class="text-muted mb-0">{{ $alpa }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h5 class="text-primary">Peringkat Absensi Keseluruhan Per Tahun {{ date('Y') }}</h5>
                <div class="row gx-2">
                    @forelse ($peringkat_absensis as $key => $peringkat_absensi)
                        <div class="col-md-4 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center text-primary" style="font-weight: bold">Peringkat {{ $key+1 }}</div>
                                    <div class="text-center">{{ $peringkat_absensi->biodata_karyawan->nama }}</div>
                                    <div class="text-center">Total Absen : <span class="text-primary">{{ $peringkat_absensi->total_absensi }}</span></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endsection
