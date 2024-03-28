@extends('layouts.apps.master')
@section('title')
    Detail KPI
@endsection
@section('css')
    <style>
        .stamp {
            position: relative;
            display: inline-block;
            color: rgb(255, 0, 0);
            padding: 15px;
            background-color: white;
            box-shadow: inset 0px 0px 0px 5px rgb(255, 0, 0);
        }

        .stamp:after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-image: url(<?php echo asset('public/stamp/5O74VI6.jpg'); ?>);
            mix-blend-mode: lighten;
        }
    </style>
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
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($kpis as $key => $kpi)
                @php
                    if (empty($kpi->status_mengetahui) || empty($kpi->status_penilai)) {
                        $color = '#387ADF';
                        $icon = 'fa fa-edit';
                        $status = 'Process';
                    }else{
                        $explode_status_mengetahui = explode('|',$kpi->status_mengetahui);
                        $explode_status_penilai = explode('|',$kpi->status_penilai);

                        if ($explode_status_mengetahui[0] == 'n' && $explode_status_penilai[0] == 'n') {
                            $color = '#B80000';
                            $icon = 'fa fa-times';
                            $status = 'Rejected';
                        }elseif($explode_status_mengetahui[0] == 'y' && $explode_status_penilai[0] == 'n'){
                            $color = '#B80000';
                            $icon = 'fa fa-times';
                            $status = 'Rejected';
                        }elseif($explode_status_mengetahui[0] == 'n' && $explode_status_penilai[0] == 'y'){
                            $color = '#B80000';
                            $icon = 'fa fa-times';
                            $status = 'Rejected';
                        }elseif($explode_status_mengetahui[0] == 'y' && $explode_status_penilai[0] == 'y'){
                            $color = '#36AE7C';
                            $icon = 'fa fa-check';
                            $status = 'Approved';
                        }
                    }
                @endphp
                <div class="accordion-item">
                    <h5 class="accordion-header m-0" id="flush-heading{{ $key }}">
                        <button class="accordion-button collapsed fw-semibold" style="background-color: {{ $color }}; color: white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $key }}"
                            aria-expanded="false" aria-controls="flush-collapse{{ $key }}">
                            <i class="{{ $icon }}"></i> &nbsp; {{ $kpi->periode }} - {{ $status }}
                        </button>
                    </h5>
                    <div id="flush-collapse{{ $key }}" class="accordion-collapse collapse {{ $status == 'Process' || $status == 'Approved'  ? 'show' : null }}"
                        aria-labelledby="flush-heading{{ $key }}"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            {{-- <h5>Nama : {{ $kpi->kpi_team->departemen_user->team }}</h5> --}}
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <table style="width: 30%">
                                            <tr>
                                                <td>Nama Karyawan</td>
                                                <td>:</td>
                                                <td style="font-weight: bold">{{ $kpi->kpi_team->departemen_user->team }}</td>
                                            </tr>
                                            <tr>
                                                <td>Departemen</td>
                                                <td>:</td>
                                                <td style="font-weight: bold">{{ $kpi->kpi_team->kpi_departemen->departemen }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jabatan</td>
                                                <td>:</td>
                                                <td style="font-weight: bold">{{ $kpi->kpi_team->jabatan }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Induk Karyawan</td>
                                                <td>:</td>
                                                <td style="font-weight: bold">{{ $kpi->kpi_team->departemen_user->nik }}</td>
                                            </tr>
                                            <tr>
                                                <td>Periode Penilaian</td>
                                                <td>:</td>
                                                <td style="font-weight: bold">{{ \Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="mb-3">
                                        <div class="card">
                                            <div class="card-header bg-dark">
                                                <div class="text-center text-white" style="font-weight: bold">KPI PERFORMANCE
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-center" rowspan="2" style="width: 2%; font-weight: bold;">No</td>
                                                            <td class="text-center" rowspan="2" style="width: 500px; font-weight: bold;">Indikator</td>
                                                            <td class="text-center" colspan="2" style="font-weight: bold;">Target</td>
                                                            <td class="text-center" colspan="2" style="font-weight: bold;">Realisasi</td>
                                                            <td class="text-center" rowspan="2" style="width: 100px; font-weight: bold;">(%) Pencapaian</td>
                                                            <td class="text-center" rowspan="2" style="width: 5%; font-weight: bold;">Bobot</td>
                                                            <td class="text-center" rowspan="2" style="font-weight: bold;">Nilai</td>
                                                            <td class="text-center" rowspan="2" style="font-weight: bold;">Skor</td>
                                                            <td class="text-center" rowspan="2" style="font-weight: bold;">Keterangan</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center" style="width: 5%; font-weight: bold;">Nilai</td>
                                                            <td class="text-center" style="width: 150px; font-weight: bold;">Ket./Satuan</td>
                                                            <td class="text-center" style="width: 5%; font-weight: bold;">Nilai</td>
                                                            <td class="text-center" style="width: 150px; font-weight: bold;">Ket./Satuan</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $total_nilai_kpi = [];
                                                            $total_nilai_pencapaian = [];
                                                        @endphp
                                                        @foreach ($kpi->kpi_detail as $key_2 => $kpi_detail)
                                                        @php
                                                            array_push($total_nilai_kpi,$kpi_detail->skor);
                                                            array_push($total_nilai_pencapaian,$kpi_detail->pencapaian);
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">{{ $key_2+1 }}</td>
                                                            <td>{{ $kpi_detail->indikator }}</td>
                                                            <td class="text-center">{{ $kpi_detail->target_nilai }}</td>
                                                            <td>{{ $kpi_detail->target_keterangan }}</td>
                                                            <td class="text-center">{{ $kpi_detail->realisasi_nilai }}</td>
                                                            <td>{{ $kpi_detail->realisasi_keterangan }}</td>
                                                            <td class="text-center">{{ $kpi_detail->pencapaian }}</td>
                                                            <td class="text-center">{{ $kpi_detail->bobot }}%</td>
                                                            <td class="text-center">{{ $kpi_detail->nilai }}</td>
                                                            <td class="text-center">{{ $kpi_detail->pencapaian }}</td>
                                                            <td class="text-center">{{ $kpi_detail->keterangan }}</td>
                                                        </tr>
                                                    @endforeach
                                                        <tr>
                                                            <td colspan="6" style="text-align: right; font-weight: bold; background-color: #DBE7C9">NILAI</td>
                                                            <td class="text-center" style="font-weight: bold; background-color: #DBE7C9">{{ array_sum($total_nilai_pencapaian)/count($total_nilai_pencapaian) }}</td>
                                                            <td colspan="2" style="background-color: #DBE7C9"></td>
                                                            <td class="text-center" style="font-weight: bold; background-color: #DBE7C9">{{ array_sum($total_nilai_pencapaian)/count($total_nilai_pencapaian) }}</td>
                                                            <td style="background-color: #DBE7C9"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header bg-dark">
                                                    <div class="text-center text-white" style="font-weight: bold">KPI CULTURE</div>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-bordered dt-responsive nowrap"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <td class="text-center" style="font-weight: bold">No</td>
                                                                <td class="text-center" style="font-weight: bold">Culture</td>
                                                                <td class="text-center" style="font-weight: bold">Indikator</td>
                                                                <td class="text-center" style="font-weight: bold">Skala</td>
                                                                <td class="text-center" style="font-weight: bold">Bobot</td>
                                                                <td class="text-center" style="font-weight: bold">%</td>
                                                                <td class="text-center" style="font-weight: bold">Nilai</td>
                                                                <td class="text-center" style="font-weight: bold">Skor Akhir</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $total_nilai_culture = [];
                                                                $kpi_cultures = \App\Models\KpiDetailCulture::with('user')
                                                                                                            ->where('kpi_id', $kpi->id)
                                                                                                            ->get();
                                                                $kpi_culture_verifikasi = \DB::table('kpi_culture_verifikasi')
                                                                                        ->where('user_id', auth()->user()->id)
                                                                                        ->where('status','y')
                                                                                        ->first();
                                                            @endphp
                                                            @foreach ($kpi_cultures as $key_culture => $kpi_culture)
                                                                @php
                                                                    $persentase = (100/4)*$kpi_culture->skala;
                                                                    array_push($total_nilai_culture,$persentase);
                                                                @endphp
                                                                <tr>
                                                                    <td class="text-center" style="width: 5%">{{ $key_culture+1 }}</td>
                                                                    <td class="text-center" style="width: 10%">{{ $kpi_culture->culture }}</td>
                                                                    <td class="text-center" style="width: 25%">{{ $kpi_culture->indikator }}</td>
                                                                    <td class="text-center" style="width: 20%">{!! $kpi_culture->skala == null ? '<span class="badge bg-info">Waiting</span>' : $kpi_culture->skala !!}</td>
                                                                    <td class="text-center" style="width: 20%">{!! $kpi_culture->bobot == null ? '<span class="badge bg-info">Waiting</span>' : $kpi_culture->bobot !!}</td>
                                                                    <td class="text-center">{{ $persentase }}</td>
                                                                    <td class="text-center">
                                                                        @if ($persentase==100)
                                                                            A
                                                                        @elseif($persentase==75)
                                                                            B
                                                                        @elseif($persentase==50)
                                                                            C
                                                                        @elseif($persentase==25)
                                                                            D
                                                                        @else
                                                                            E
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ number_format($persentase,2,',','.') }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            @php
                                                                $hasil_total_nilai_culture = array_sum($total_nilai_culture)/count($kpi_cultures);
                                                            @endphp
                                                            <tr>
                                                                <td colspan="5" style="background-color: #DBE7C9; font-weight: bold; text-align: right">NILAI</td>
                                                                <td style="background-color: #DBE7C9; font-weight: bold; text-align: center">{{ $hasil_total_nilai_culture }}</td>
                                                                <td style="background-color: #DBE7C9; font-weight: bold; text-align: center"></td>
                                                                <td style="background-color: #DBE7C9; font-weight: bold; text-align: center">
                                                                    {{ number_format($hasil_total_nilai_culture,0,'.',',') }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header bg-dark">
                                                    <div class="text-center text-white" style="font-weight: bold">TOTAL NILAI KPI</div>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-bordered dt-responsive nowrap"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <td class="text-center" style="font-weight: bold">KPI</td>
                                                                <td class="text-center" style="font-weight: bold">BOBOT (%)</td>
                                                                <td class="text-center" style="font-weight: bold">NILAI</td>
                                                                <td class="text-center" style="font-weight: bold">TOTAL NILAI</td>
                                                                <td class="text-center" style="font-weight: bold">SKOR NILAI</td>
                                                                <td class="text-center" style="font-weight: bold">KETERANGAN NILAI</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $grand_total_nilai_kpi = [];
                                                                $kpi_total_nilais = \App\Models\KpiTotalNilai::where('kpi_id',$kpi->id)->get();
                                                                $kpi_culture_verifikasi = \DB::table('kpi_culture_verifikasi')
                                                                        ->where('user_id', auth()->user()->id)
                                                                        ->where('status','y')
                                                                        ->first();
                                                            @endphp
                                                            @foreach ($kpi_total_nilais as $key_kpi_total_nilai => $kpi_total_nilai)
                                                            @php
                                                                array_push($grand_total_nilai_kpi,$kpi_total_nilai->total_nilai);
                                                            @endphp
                                                            <tr>
                                                                <td class="text-center">{{ $kpi_total_nilai->nama_kpi }}</td>
                                                                <td class="text-center">{{ $kpi_total_nilai->bobot }}</td>
                                                                <td class="text-center">
                                                                    @if (empty($kpi_total_nilai->nilai))
                                                                    <span class="badge bg-info">Input Otomatis</span>
                                                                    @else
                                                                    {{ $kpi_total_nilai->nilai }}
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    @if (empty($kpi_total_nilai->total_nilai))
                                                                    <span class="badge bg-info">Input Otomatis</span>
                                                                    @else
                                                                    {{ $kpi_total_nilai->total_nilai }}
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    @if (empty($kpi_total_nilai->skor_nilai))
                                                                    <span class="badge bg-info">Input Otomatis</span>
                                                                    @else
                                                                    {{ $kpi_total_nilai->skor_nilai }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {{ $kpi_total_nilai->keterangan }}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="3" style="background-color: #DBE7C9; font-weight: bold; text-align: right">GRAND TOTAL</td>
                                                                <td style="background-color: #DBE7C9; font-weight: bold; text-align: center">{{ array_sum($grand_total_nilai_kpi) }}</td>
                                                                <td style="background-color: #DBE7C9; font-weight: bold; text-align: center">{{ array_sum($grand_total_nilai_kpi) }}</td>
                                                                <td style="background-color: #DBE7C9; font-weight: bold; text-align: center"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-bordered dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" colspan="2">Bobot Nilai</th>
                                                        <th class="text-center">Keterangan</th>
                                                        <th class="text-center">Skala</th>
                                                        <th class="text-center">Prosentase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($kpi_bobots as $kpi_bobot)
                                                        <tr>
                                                            <td class="text-center">{{ $kpi_bobot->bobot_huruf }}</td>
                                                            <td class="text-center">{{ $kpi_bobot->bobot_nilai }}</td>
                                                            <td class="text-center">{{ $kpi_bobot->keterangan }}</td>
                                                            <td class="text-center">{{ $kpi_bobot->skala }}</td>
                                                            <td class="text-center">{{ $kpi_bobot->prosentase }}</td>
                                                        </tr>
                                                    @empty
                                                        
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    
                                                </div>
                                                <div class="col-auto">
                                                    <table class="table table-bordered dt-responsive nowrap"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <tr>
                                                            <th class="text-center">Total Nilai</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center" style="font-size: 48pt">{{ number_format(array_sum($grand_total_nilai_kpi),0,',','.') }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">
                                                                @if (number_format(array_sum($grand_total_nilai_kpi), 2, ',', '.') >= '0' &&
                                                                        number_format(array_sum($grand_total_nilai_kpi), 2, ',', '.') <= '59')
                                                                    BURUK
                                                                @elseif(number_format(array_sum($grand_total_nilai_kpi), 2, ',', '.') >= '60' &&
                                                                        number_format(array_sum($grand_total_nilai_kpi), 2, ',', '.') <= '75')
                                                                    KURANG
                                                                @elseif(number_format(array_sum($grand_total_nilai_kpi), 2, ',', '.') >= '76' &&
                                                                        number_format(array_sum($grand_total_nilai_kpi), 2, ',', '.') <= '85')
                                                                    CUKUP
                                                                @elseif(number_format(array_sum($grand_total_nilai_kpi), 2, ',', '.') >= '86' &&
                                                                        number_format(array_sum($grand_total_nilai_kpi), 2, ',', '.') <= '95')
                                                                    BAIK
                                                                @elseif(number_format(array_sum($grand_total_nilai_kpi), 2, ',', '.') >= '96' &&
                                                                        number_format(array_sum($grand_total_nilai_kpi), 2, ',', '.') <= '100')
                                                                    BAIK SEKALI
                                                                @endif
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for=""><b>Catatan :</b></label>
                                        <p>{{ $kpi->remaks == null ? '-' : $kpi->remaks }}</p>
                                    </div>
                                    @php
                                        $mengetahui = [
                                            'identifier' => 'Signature: '.$kpi->mengetahui."\n".
                                                            'Departemen: '.'Direktur'."\n".
                                                            // 'Penilaian Departemen: '.$kpi->kpi_team->departemen_user->departemen->departemen."\n".
                                                            // 'Penilaian Jabatan: '.$kpi->kpi_team->jabatan."\n".
                                                            'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')."\n".
                                                            'Tanggal Dibuat: '.\Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL')
                                        ];
                                        $penilai = [
                                            'identifier' => 'Signature: '.$kpi->penilai."\n".
                                                            'Penilaian Departemen: '.$kpi->kpi_team->kpi_departemen->departemen."\n".
                                                            // 'Penilaian Departemen: '.$kpi->kpi_team->departemen_user->departemen->departemen."\n".
                                                            // 'Penilaian Jabatan: '.$kpi->kpi_team->jabatan."\n".
                                                            'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')."\n".
                                                            'Tanggal Dibuat: '.\Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL')
                                        ];
                                        $dinilai = [
                                            'identifier' => 'Signature: '.$kpi->yang_dinilai."\n". 
                                                            'Penilaian Departemen: '.$kpi->kpi_team->kpi_departemen->departemen."\n".
                                                            // 'Penilaian Departemen: '.$kpi->kpi_team->kpi_departemen->departemen."\n".
                                                            // 'Penilaian Jabatan: '.$kpi->kpi_team->jabatan."\n".
                                                            'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')."\n".
                                                            'Tanggal Dibuat: '.\Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL')
                                        ];
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <table class="table table-bordered dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <td class="text-center" colspan="3">Validasi</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center" style="width: 30%">Mengetahui</td>
                                                        <td class="text-center" style="width: 30%">Penilai</td>
                                                        <td class="text-center" style="width: 30%">Yang Dinilai</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center" style="height: 100px">
                                                            @if (empty($kpi->status_mengetahui))
                                                                <span class="badge badge-outline-warning">Waiting Verification</span>
                                                            @else
                                                                @php
                                                                    $explode_status_mengetahui = explode("|",$kpi->status_mengetahui);
                                                                @endphp
                                                                @if($explode_status_mengetahui[0] == null)
                                                                <span class="badge badge-outline-warning">Waiting Verification</span>
                                                                @elseif ($explode_status_mengetahui[0] == 'y')
                                                                {!! DNS2D::getBarcodeSVG($mengetahui['identifier'], 'QRCODE', 2, 2) !!}
                                                                @elseif($explode_status_mengetahui[0] == 'n')
                                                                <div class="stamp">REJECTED</div>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="height: 100px">
                                                            @if(empty($kpi->status_penilai))
                                                                <span class="badge badge-outline-warning">Waiting Verification</span>
                                                            @else
                                                                @php
                                                                    $explode_status_penilai = explode("|",$kpi->status_penilai);
                                                                @endphp
                                                                @if ($explode_status_penilai[0] == null)
                                                                <span class="badge badge-outline-warning">Waiting Verification</span>
                                                                @elseif($explode_status_penilai[0] == 'y')
                                                                {!! DNS2D::getBarcodeSVG($penilai['identifier'], 'QRCODE', 2, 2) !!}
                                                                @elseif($explode_status_penilai[0] == 'n')
                                                                    <div class="stamp">REJECTED</div>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="height: 100px">
                                                            {!! $kpi->yang_dinilai == null ? '-' : DNS2D::getBarcodeSVG($dinilai['identifier'], 'QRCODE', 2, 2) !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">{{ $kpi->mengetahui }}</td>
                                                        <td class="text-center">
                                                            {{ $kpi->penilai }}
                                                        </td>
                                                        <td class="text-center">{{ $kpi->yang_dinilai }}</td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('kpi') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                                    @php
                                        $explode_status_mengetahui = explode('|',$kpi->status_mengetahui);
                                        $explode_status_penilai = explode('|',$kpi->status_penilai);
                                    @endphp
                                    @if (empty($kpi->status_mengetahui) && empty($kpi->status_penilai))
                                    <a href="{{ route('kpi_detail_validasi',['id' => $kpi->id, 'departemen_id' => $kpi->kpi_team->kpi_departemen->id]) }}" class="btn btn-primary"><i class="fas fa-check"></i> Go Verification</a> 
                                    @elseif(!empty($kpi->status_mengetahui) && empty($kpi->status_penilai))
                                    <a href="{{ route('kpi_detail_validasi',['id' => $kpi->id, 'departemen_id' => $kpi->kpi_team->kpi_departemen->id]) }}" class="btn btn-primary"><i class="fas fa-check"></i> Go Verification</a> 
                                    @elseif(empty($kpi->status_mengetahui) && !empty($kpi->status_penilai))
                                    <a href="{{ route('kpi_detail_validasi',['id' => $kpi->id, 'departemen_id' => $kpi->kpi_team->kpi_departemen->id]) }}" class="btn btn-primary"><i class="fas fa-check"></i> Go Verification</a> 
                                    @endif

                                    @if ($explode_status_mengetahui[0]=='y' && $explode_status_penilai[0]=='y')
                                    <a href="{{ route('kpi_print',['id' => $kpi->id, 'departemen_id' => $kpi->kpi_team->kpi_departemen->id, 'date' => $kpi->periode]) }}" class="btn" style="background-color: #1B3C73; color: white"><i class="fas fa-print"></i> Print</a>
                                    @endif
                                    {{-- <a href="{{ route('kpi') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                                    @if (empty($kpi->status_mengetahui) && empty($kpi->status_penilai))
                                    <a href="{{ route('kpi_detail_validasi',['id' => $kpi->id, 'departemen_id' => $departemen_id]) }}" class="btn btn-primary"><i class="fas fa-check"></i> Go Verification</a> 
                                    @elseif(!empty($kpi->status_mengetahui) && empty($kpi->status_penilai))
                                    <a href="{{ route('kpi_detail_validasi',['id' => $kpi->id, 'departemen_id' => $departemen_id]) }}" class="btn btn-primary"><i class="fas fa-check"></i> Go Verification</a> 
                                    @elseif(empty($kpi->status_mengetahui) && !empty($kpi->status_penilai))
                                    <a href="{{ route('kpi_detail_validasi',['id' => $kpi->id, 'departemen_id' => $departemen_id]) }}" class="btn btn-primary"><i class="fas fa-check"></i> Go Verification</a> 
                                    @else
                                    @php
                                        $explode_status_mengetahui = explode('|',$kpi->status_mengetahui);
                                        $explode_status_penilai = explode('|',$kpi->status_penilai);
                                    @endphp
                                        @if ($explode_status_mengetahui[0]=='y' && $explode_status_penilai[0]=='y')
                                        <a href="{{ route('kpi_print',['id' => $kpi->id, 'departemen_id' => $departemen_id, 'date' => $kpi->periode]) }}" class="btn" target="_blank" style="background-color: #1B3C73; color: white"><i class="mdi mdi-printer"></i> Print Dokumen</a>
                                        @endif
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
