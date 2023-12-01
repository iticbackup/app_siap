@extends('layouts.apps.master')
@section('title')
    Validasi KPI Indikator Team
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
                <form action="{{ route('kpi.input_date_kpi_validasi_simpan',['date' => $date, 'id_departemen' => $id_departemen]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @foreach ($kpis as $key_1 => $kpi)
                    @php
                        // $kpi_supervisor = \App\Models\KpiTeam::where('kpi_departemen_id',$kpi->kpi_team->kpi_departemen->id)->where('jabatan','Supervisor')->first();
                        // dd($kpi_supervisor);
                        // $mengetahui = \App\Models\DepartemenUser::select('nik','team')->where('team','Andre Martinus')->first();
                        $explode_status = explode("|",$kpi->status);
                    @endphp
                    <input type="hidden" name="id_kpi" value="{{ $kpi->id }}" id="">
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
                            <table class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <td class="text-center" rowspan="2" style="width: 2%">No</td>
                                        <td class="text-center" rowspan="2" style="width: 500px">Indikator</td>
                                        <td class="text-center" colspan="2">Target</td>
                                        <td class="text-center" colspan="2">Realisasi</td>
                                        <td class="text-center" rowspan="2" style="width: 100px">(%) Pencapaian</td>
                                        <td class="text-center" rowspan="2" style="width: 5%">Bobot</td>
                                        <td class="text-center" rowspan="2">Nilai</td>
                                        <td class="text-center" rowspan="2">Skor</td>
                                        <td class="text-center" rowspan="2">Keterangan</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="width: 5%">Nilai</td>
                                        <td class="text-center" style="width: 150px">Ket./Satuan</td>
                                        <td class="text-center" style="width: 5%">Nilai</td>
                                        <td class="text-center" style="width: 150px">Ket./Satuan</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_nilai_kpi = [];
                                        $kpi_details = \App\Models\KpiDetail::where('kpi_id',$kpi->id)->get();
                                    @endphp
                                    {{-- @foreach ($kpi_indikators as $key_2 => $kpi_indikator)
                                        <tr>
                                            <td class="text-center">{{ $key_2+1 }}</td>
                                            <td>{{ $kpi_indikator->indikator }}</td>
                                            <td>{{ $kpi_indikator->target_nilai }}</td>
                                        </tr>
                                    @endforeach --}}
                                    @foreach ($kpi_details as $key_2 => $kpi_detail)
                                        {{-- $nilai_kpi_team = []; --}}
                                        @php
                                            array_push($total_nilai_kpi,$kpi_detail->skor);
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
                                            <td class="text-center">{{ $kpi_detail->skor }}</td>
                                            <td class="text-center">{{ $kpi_detail->keterangan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
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
                        @if ($kpi->mengetahui == auth()->user()->name)
                        @if (empty($kpi->status_mengetahui))
                        <div class="mb-3">
                            <label for=""><b>Catatan :</b></label>
                            {{-- <p>{{ $kpi->remaks == null ? '-' : $kpi->remaks }}</p> --}}
                            <textarea name="remaks[]" class="form-control" id="" cols="30" rows="5">{{ $kpi->remaks }}</textarea>
                        </div>
                        @endif
                        @endif
                        {{-- <div class="row">
                            <div class="col-md-3">
                                <label for=""><b>Status Validasi :</b></label>
                                <form action="" method="post">
                                    <select name="validasi_{{ $key_1 }}" class="form-control" id="">
                                        <option value="">-- Status Validasi --</option>
                                        <option value="y">Disetujui</option>
                                        <option value="n">Ditolak</option>
                                    </select>
                                </form>
                            </div>
                        </div> --}}
                        @php
                            $mengetahui = [
                                'identifier' => 'Signature: '.$kpi->mengetahui."\n".
                                                'Departemen: '.'Direktur'."\n".
                                                // 'Penilaian Jabatan: '.'Direktur'."\n".
                                                'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')."\n".
                                                'Tanggal Dibuat: '.\Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL')
                            ];
                            // if ($kpi_supervisor->jabatan != 'Supervisor') {
                            //     $penilai = [
                            //         'identifier' => 'Signature: '.$kpi->penilai."\n".
                            //                         'Penilaian Departemen: '.$kpi->kpi_team->departemen_user->departemen->departemen."\n".
                            //                         'Penilaian Jabatan: '.'Direktur'."\n".
                            //                         'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')."\n".
                            //                         'Tanggal Dibuat: '.\Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL')
                            //     ];
                            // }else{
                            // }
                            $penilai = [
                                'identifier' => 'Signature: '.$kpi->penilai."\n".
                                                'Penilaian Departemen: '.$kpi->kpi_team->kpi_departemen->departemen."\n".
                                                // 'Penilaian Jabatan: '.$kpi_supervisor->jabatan."\n".
                                                'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')."\n".
                                                'Tanggal Dibuat: '.\Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL')
                            ];
                            $dinilai = [
                                'identifier' => 'Signature: '.$kpi->yang_dinilai."\n". 
                                                'Penilaian Departemen: '.$kpi->kpi_team->kpi_departemen->departemen."\n".
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
                                                @if ($kpi->mengetahui == auth()->user()->name)
                                                    @if (empty($kpi->status_mengetahui))
                                                    <select name="status_mengetahui_{{ $key_1 }}" class="form-control" id="">
                                                        <option value="">-- Pilih Validasi --</option>
                                                        <option value="y">Disetujui</option>
                                                        <option value="n">Ditolak</option>
                                                    </select>
                                                    @else
                                                        @php
                                                            $explode_status_mengetahui = explode("|",$kpi->status_mengetahui);
                                                        @endphp
                                                        @if($explode_status_mengetahui[0] == null)
                                                        <select name="status_mengetahui_{{ $key_1 }}" class="form-control" id="">
                                                            <option value="">-- Pilih Validasi --</option>
                                                            <option value="y">Disetujui</option>
                                                            <option value="n">Ditolak</option>
                                                        </select>
                                                        @elseif ($explode_status_mengetahui[0] == 'y')
                                                            {!! DNS2D::getBarcodeSVG($mengetahui['identifier'], 'QRCODE', 2, 2) !!}
                                                        @elseif($explode_status_mengetahui[0] == 'n')
                                                            <div class="stamp">REJECTED</div>
                                                        @endif
                                                    @endif
                                                {{-- <input type="hidden" name="mengetahui_{{ $key_1 }}" value="{{ $mengetahui_kpi->team }}" id=""> --}}
                                                @else
                                                    @if (!empty($kpi->status_mengetahui))
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
                                                @endif
                                                {{-- @if (auth()->user()->nik == 1910125)
                                                <select name="status_mengetahui_{{ $key_1 }}" class="form-control" id="">
                                                    <option value="">-- Pilih Validasi --</option>
                                                    <option value="y">Disetujui</option>
                                                    <option value="n">Ditolak</option>
                                                </select>
                                                <input type="hidden" name="mengetahui_{{ $key_1 }}" value="{{ $mengetahui_kpi->team }}" id="">
                                                @endif --}}
                                            </td>
                                            <td class="text-center">
                                                @if ($kpi->penilai == auth()->user()->name)
                                                    @if (empty($kpi->status_penilai))
                                                        <select name="status_penilai_{{ $key_1 }}" class="form-control" id="">
                                                            <option value="">-- Pilih Validasi --</option>
                                                            <option value="y">Disetujui</option>
                                                            <option value="n">Ditolak</option>
                                                        </select>
                                                    @else
                                                        @php
                                                            $explode_status_penilai = explode("|",$kpi->status_penilai);
                                                        @endphp
                                                        @if ($explode_status_penilai[0] == null)
                                                        <select name="status_penilai_{{ $key_1 }}" class="form-control" id="">
                                                            <option value="">-- Pilih Validasi --</option>
                                                            <option value="y">Disetujui</option>
                                                            <option value="n">Ditolak</option>
                                                        </select>
                                                        @elseif ($explode_status_penilai[0] == 'y')
                                                            {!! DNS2D::getBarcodeSVG($penilai['identifier'], 'QRCODE', 2, 2) !!}
                                                        @elseif($explode_status_penilai[0] == 'n')
                                                            <div class="stamp">REJECTED</div>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if (!empty($kpi->status_penilai))
                                                        @php
                                                            $explode_status_penilai = explode("|",$kpi->status_penilai);
                                                        @endphp
                                                        @if($explode_status_penilai[0] == null)
                                                            <span class="badge badge-outline-warning">Waiting Verification</span>
                                                        @elseif ($explode_status_penilai[0] == 'y')
                                                            {!! DNS2D::getBarcodeSVG($penilai['identifier'], 'QRCODE', 2, 2) !!}
                                                        @elseif($explode_status_penilai[0] == 'n')
                                                            <div class="stamp">REJECTED</div>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            {{-- <td class="text-center" style="height: 100px">
                                                @if ($kpi->penilai == null)
                                                    @if ($kpi->kpi_team->jabatan != 'Supervisor')
                                                        <select name="status_penilai_{{ $key_1 }}" class="form-control" id="">
                                                            <option value="">-- Pilih Validasi --</option>
                                                            <option value="y">Disetujui</option>
                                                            <option value="n">Ditolak</option>
                                                        </select>
                                                        <input type="hidden" name="penilai_{{ $key_1 }}" value="{{ $kpi_supervisor->departemen_user->team }}" id="">
                                                    @else
                                                        <select name="status_penilai_{{ $key_1 }}" class="form-control" id="">
                                                            <option value="">-- Pilih Validasi --</option>
                                                            <option value="y">Disetujui</option>
                                                            <option value="n">Ditolak</option>
                                                        </select>
                                                        <input type="hidden" name="penilai_{{ $key_1 }}" value="{{ $mengetahui_kpi->team }}" id="">
                                                    @endif
                                                @else
                                                    @if ($explode_status[0] == 'y')
                                                        {!! DNS2D::getBarcodeSVG($penilai['identifier'], 'QRCODE', 2, 2) !!}
                                                    @else
                                                        <div class="stamp">REJECTED</div>
                                                    @endif
                                                @endif
                                            </td> --}}
                                            <td class="text-center" style="height: 100px">
                                                {!! $kpi->yang_dinilai == null ? '-' : DNS2D::getBarcodeSVG($dinilai['identifier'], 'QRCODE', 2, 2) !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                {{ $kpi->mengetahui }}
                                            </td>
                                            <td class="text-center">
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
                    <a href="{{ route('kpi.input_date_kpi_detail',['date' => $date, 'id_departemen' => $id_departemen]) }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
