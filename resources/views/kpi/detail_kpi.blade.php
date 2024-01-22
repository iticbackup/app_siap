@extends('layouts.apps.master')
@section('title')
    Detail KPI Indikator Team
@endsection
@section('css')
    <style>
        .stamp {
            position: relative;
            display: inline-block;
            color: rgb(255, 0, 0);
            padding: 15px;
            background-color: white;
            box-shadow:inset 0px 0px 0px 5px rgb(255, 0, 0);
        }

        .stamp:after{
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
            <div class="card">
                <div class="card-body">
                    @foreach ($kpis as $key_1 => $kpi)
                    @php
                        // $kpi_team = \App\Models\Kpi::find($kpi->id);
                        // $kpi_supervisor = \App\Models\KpiTeam::where('id',$kpi->id)->where('jabatan','Supervisor')->first();
                    @endphp
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
                                                // $kpi_details = \App\Models\KpiDetail::where('kpi_id',$kpi->id)->get();
                                            @endphp
                                            {{-- @foreach ($kpi_indikators as $key_2 => $kpi_indikator)
                                                <tr>
                                                    <td class="text-center">{{ $key_2+1 }}</td>
                                                    <td>{{ $kpi_indikator->indikator }}</td>
                                                    <td>{{ $kpi_indikator->target_nilai }}</td>
                                                </tr>
                                            @endforeach --}}
                                            @foreach ($kpi->kpi_detail as $key_2 => $kpi_detail)
                                                {{-- $nilai_kpi_team = []; --}}
                                                @php
                                                    array_push($total_nilai_kpi,$kpi_detail->skor);
                                                    array_push($total_nilai_pencapaian,$kpi_detail->pencapaian);
                                                    // $explode_skor = explode('%',$kpi_detail->pencapaian);
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
                                                    {{-- <td class="text-center">{{ $kpi_detail->skor }}</td> --}}
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
                                                    <td class="text-center">No</td>
                                                    <td class="text-center">Culture</td>
                                                    <td class="text-center">Indikator</td>
                                                    <td class="text-center">Skala</td>
                                                    <td class="text-center">Bobot</td>
                                                    <td class="text-center">%</td>
                                                    <td class="text-center">Nilai</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $kpi_cultures = \DB::table('kpi_detail_culture')->where('kpi_id',$kpi->id)->get();
                                                @endphp
                                                @foreach ($kpi_cultures as $key_culture => $kpi_culture)
                                                    <tr>
                                                        <td class="text-center" style="width: 5%">{{ $key_culture+1 }}</td>
                                                        <td class="text-center" style="width: 10%">{{ $kpi_culture->culture }}</td>
                                                        <td class="text-center" style="width: 25%">{{ $kpi_culture->indikator }}</td>
                                                        <td class="text-center" style="width: 20%">{!! $kpi_culture->skala == null ? '<span class="badge bg-info">Waiting</span>' : $kpi_culture->skala !!}</td>
                                                        <td class="text-center" style="width: 20%">{!! $kpi_culture->bobot == null ? '<span class="badge bg-info">Waiting</span>' : $kpi_culture->bobot !!}</td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                @endforeach
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
                                                <th class="text-center" style="font-size: 48pt">{{ number_format(array_sum($total_nilai_kpi),2,',','.') }}</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">
                                                    @if (number_format(array_sum($total_nilai_kpi),2,',','.') < '2,00')
                                                        BURUK
                                                    @elseif(number_format(array_sum($total_nilai_kpi),2,',','.') >= '2,00' && number_format(array_sum($total_nilai_kpi),2,',','.') <= '2,50')
                                                        KURANG
                                                    @elseif(number_format(array_sum($total_nilai_kpi),2,',','.') >= '2,51' && number_format(array_sum($total_nilai_kpi),2,',','.') <= '3,00')
                                                        CUKUP
                                                    @elseif(number_format(array_sum($total_nilai_kpi),2,',','.') >= '3,01' && number_format(array_sum($total_nilai_kpi),2,',','.') <= '3,50')
                                                        BAIK
                                                    @elseif(number_format(array_sum($total_nilai_kpi),2,',','.') >= '3,51' && number_format(array_sum($total_nilai_kpi),2,',','.') <= '4,00')
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
                            // if ($kpi->kpi_team->jabatan == 'Supervisor') {
                            //     $mengetahui = [
                            //         'identifier' => 'NIK: '.'1910125'."\n". 
                            //                         'Nama: '.'Andre Martinus'."\n".
                            //                         'Jabatan: '.'Direktur'."\n".
                            //                         'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')
                            //     ];
                            //     $penilai = [
                            //         'identifier' => 'NIK: '.'1910125'."\n". 
                            //                         'Nama: '.'Andre Martinus'."\n".
                            //                         'Jabatan: '.'Direktur'."\n".
                            //                         'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')
                            //     ];
                            //     $dinilai = [
                            //         'identifier' => 'NIK: '.$kpi->kpi_team->departemen_user->nik."\n". 
                            //                         'Nama: '.$kpi->kpi_team->departemen_user->team."\n".
                            //                         'Jabatan: '.$kpi->kpi_team->jabatan."\n".
                            //                         'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')
                            //     ];
                            // }
                            // else{
                            //     $mengetahui = [
                            //         'identifier' => 'NIK: '.'1910125'."\n". 
                            //                         'Nama: '.'Andre Martinus'."\n".
                            //                         'Jabatan: '.'Direktur'."\n".
                            //                         'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')
                            //     ];
                            //     $penilai = [
                            //         'identifier' => 'NIK: '.$kpi->kpi_team->departemen_user->nik."\n". 
                            //                         'Nama: '.$kpi->kpi_team->departemen_user->team."\n".
                            //                         'Jabatan: '.$kpi->kpi_team->jabatan."\n".
                            //                         'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')
                            //     ];
                            //     $dinilai = [
                            //         'identifier' => 'NIK: '.$kpi->kpi_team->departemen_user->nik."\n". 
                            //                         'Nama: '.$kpi->kpi_team->departemen_user->team."\n".
                            //                         'Jabatan: '.$kpi->kpi_team->jabatan."\n".
                            //                         'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')
                            //     ];
                            // }
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
                            // $dinilai = [
                            //     'identifier' => 'NIK: '.$kpi->kpi_team->departemen_user->nik."\n". 
                            //                     'Nama: '.$kpi->kpi_team->departemen_user->team."\n".
                            //                     'Jabatan: '.$kpi->kpi_team->jabatan."\n".
                            //                     'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')
                            // ]
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
                                                {{-- {!! $kpi->mengetahui == null ? '-' : DNS2D::getBarcodeSVG($mengetahui['identifier'], 'QRCODE', 2, 2) !!} --}}
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
                                                {{-- {!! $kpi->penilai == null ? '-' : DNS2D::getBarcodeSVG($penilai['identifier'], 'QRCODE', 2, 2) !!} --}}
                                            </td>
                                            <td class="text-center" style="height: 100px">
                                                {!! $kpi->yang_dinilai == null ? '-' : DNS2D::getBarcodeSVG($dinilai['identifier'], 'QRCODE', 2, 2) !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">{{ $kpi->mengetahui }}</td>
                                            <td class="text-center">
                                                {{-- @if ($kpi->kpi_team->jabatan == 'Supervisor')
                                                    {{ $kpi->kpi_team->departemen_user->team }}
                                                @else
                                                @endif --}}
                                                {{ $kpi->penilai }}
                                            </td>
                                            <td class="text-center">{{ $kpi->yang_dinilai }}</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        
                        <hr style="border-top: 3px dashed rgb(0, 17, 255);">

                    @endforeach
                </div>
                <div class="card-footer">
                    <a href="{{ route('kpi') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                    <a href="{{ route('kpi.input_date_kpi_validasi',['date' => $date, 'id_departemen' => $id_departemen]) }}" class="btn btn-primary"><i class="fas fa-check"></i> Go Verification</a>
                    <a href="{{ route('kpi.kpi_print',['date' => $date, 'id_departemen' => $id_departemen]) }}" class="btn btn-info" target="_blank"><i class="mdi mdi-printer"></i> Print</a>
                </div>
            </div>
        </div>
    </div>
@endsection
