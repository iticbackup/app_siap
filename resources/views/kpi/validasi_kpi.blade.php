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
            <div class="card">
                <form
                    action="{{ route('kpi.input_date_kpi_validasi_simpan', ['date' => $date, 'id_departemen' => $id_departemen]) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @foreach ($kpis as $key_1 => $kpi)
                            @php
                                // $kpi_supervisor = \App\Models\KpiTeam::where('kpi_departemen_id',$kpi->kpi_team->kpi_departemen->id)->where('jabatan','Supervisor')->first();
                                // dd($kpi_supervisor);
                                // $mengetahui = \App\Models\DepartemenUser::select('nik','team')->where('team','Andre Martinus')->first();
                                $explode_status = explode('|', $kpi->status);
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
                                        <td style="font-weight: bold">
                                            {{ \Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY') }}</td>
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
                                                    <td class="text-center" rowspan="2" style="width: 2%">No</td>
                                                    <td class="text-center" rowspan="2" style="width: 500px">Indikator</td>
                                                    <td class="text-center" colspan="2">Target</td>
                                                    <td class="text-center" colspan="2">Realisasi</td>
                                                    <td class="text-center" rowspan="2" style="width: 100px">(%) Pencapaian</td>
                                                    <td class="text-center" rowspan="2" style="width: 5%">Bobot</td>
                                                    <td class="text-center" rowspan="2">Nilai</td>
                                                    <td class="text-center" rowspan="2">Skor Akhir</td>
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
                                                    $total_nilai_pencapaian = [];
                                                    $kpi_details = \App\Models\KpiDetail::where('kpi_id', $kpi->id)->get();
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
                                                        array_push($total_nilai_kpi, $kpi_detail->skor);
                                                        array_push($total_nilai_pencapaian,$kpi_detail->pencapaian);
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $key_2 + 1 }}</td>
                                                        <td>{{ $kpi_detail->indikator }}</td>
                                                        <td class="text-center">{{ $kpi_detail->target_nilai }}</td>
                                                        <td class="text-center">{{ $kpi_detail->target_keterangan }}</td>
                                                        <td class="text-center">{{ $kpi_detail->realisasi_nilai }}</td>
                                                        <td class="text-center">{{ $kpi_detail->realisasi_keterangan }}</td>
                                                        <td class="text-center">{{ $kpi_detail->pencapaian }}</td>
                                                        <td class="text-center">{{ $kpi_detail->bobot }}%</td>
                                                        <td class="text-center">{{ $kpi_detail->nilai }}</td>
                                                        <td class="text-center">{{ array_sum($total_nilai_pencapaian)/count($total_nilai_pencapaian) }}</td>
                                                        <td class="text-center">{{ $kpi_detail->keterangan }}</td>
                                                    </tr>
                                                @endforeach
                                                    <tr>
                                                        <td colspan="6" style="text-align: right; font-weight: bold; background-color: #DBE7C9">NILAI</td>
                                                        <td class="text-center" style="font-weight: bold; background-color: #DBE7C9">
                                                            {{ array_sum($total_nilai_pencapaian)/count($total_nilai_pencapaian) }}
                                                            <input type="hidden" name="total_nilai_kpi_performance[]" value="{{ array_sum($total_nilai_pencapaian)/count($total_nilai_pencapaian) }}" id="">
                                                        </td>
                                                        <td colspan="2" style="background-color: #DBE7C9"></td>
                                                        <td class="text-center" style="font-weight: bold; background-color: #DBE7C9">
                                                            {{ array_sum($total_nilai_pencapaian)/count($total_nilai_pencapaian) }}
                                                            <input type="hidden" name="total_skor_kpi_performance[]" value="{{ array_sum($total_nilai_pencapaian)/count($total_nilai_pencapaian) }}" id="">
                                                        </td>
                                                        <td style="background-color: #DBE7C9"></td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- <form id="form-kpi-culture"
                                        action="{{ route('kpi.culture.verifikasi', ['kpi_id' => $kpi->id]) }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="text" name="kpi_detail_id" value="{{ $kpi->id }}">
                                    </form> --}}
                                    <div class="card">
                                        <div class="card-header bg-dark">
                                            <div class="text-center text-white" style="font-weight: bold">KPI CULTURE</div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <td class="text-center" style="width: 5%">No</td>
                                                        <td class="text-center" style="width: 10%">Culture</td>
                                                        <td class="text-center" style="width: 50%">Indikator</td>
                                                        <td class="text-center" style="width: 10%">Skala</td>
                                                        <td class="text-center" style="width: 10%">Bobot</td>
                                                        <td class="text-center" style="width: 5%">%</td>
                                                        <td class="text-center" style="width: 5%">Nilai</td>
                                                        <td class="text-center" style="width: 10%">Skor Akhir</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $total_nilai_culture = [];
                                                        // $kpi_cultures = \DB::table('kpi_detail_culture')
                                                        //     ->where('kpi_id', $kpi->id)
                                                        //     ->get();
                                                        $kpi_cultures = \App\Models\KpiDetailCulture::with('user')->where('kpi_id', $kpi->id)
                                                                                                    ->get();
                                                                                                    // dd($kpi_cultures);
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
                                                            <td class="text-center">
                                                                {{ $key_culture + 1 }}
                                                                <input type="hidden" name="kpi_culture_id[]" value="{{ $kpi_culture->id }}">
                                                            </td>
                                                            <td class="text-center">{{ $kpi_culture->culture }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $kpi_culture->indikator }}</td>
                                                            <td class="text-center" style="vertical-align: middle">
                                                                @if (!empty($kpi_culture_verifikasi))
                                                                    <input type="text" name="kpi_culture_skala[]"
                                                                        class="form-control text-center"
                                                                        placeholder="Nilai Skala" autocomplete="off" value="{{ $kpi_culture->skala }}" id=""
                                                                        {{-- {{ $kpi_culture->user_id != auth()->user()->id ? 'readonly' : null }} --}}
                                                                        >
                                                                        @if (!empty($kpi_culture->user_id))
                                                                        <a href="javascript:void()" data-bs-toggle="tooltip" data-bs-placement="top" title="Telah diinput oleh {{ $kpi_culture->user->name }}"><i class="far fa-question-circle"></i></a>
                                                                        @endif
                                                                @else
                                                                {{ $kpi_culture->skala }}
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if (!empty($kpi_culture_verifikasi))
                                                                    <input type="text" name="kpi_culture_bobot[]"
                                                                        class="form-control text-center"
                                                                        placeholder="Nilai Bobot" autocomplete="off" value="{{ $kpi_culture->bobot }}" id=""
                                                                        {{-- {{ $kpi_culture->user_id != auth()->user()->id ? 'readonly' : null }} --}}
                                                                        >
                                                                        @if (!empty($kpi_culture->user_id))
                                                                        <a href="javascript:void()" data-bs-toggle="tooltip" data-bs-placement="top" title="Telah diinput oleh {{ $kpi_culture->user->name }}"><i class="far fa-question-circle"></i></a>
                                                                        @endif
                                                                @else
                                                                {{ $kpi_culture->bobot }}
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $persentase }}
                                                            </td>
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
                                                        // dd($total_nilai_culture);
                                                            $hasil_total_nilai_culture = array_sum($total_nilai_culture)/count($kpi_cultures);
                                                        @endphp
                                                        <tr>
                                                            <td colspan="5" style="background-color: #DBE7C9; font-weight: bold; text-align: right">NILAI</td>
                                                            <td style="background-color: #DBE7C9; font-weight: bold; text-align: center">{{ $hasil_total_nilai_culture }}</td>
                                                            <td style="background-color: #DBE7C9; font-weight: bold; text-align: center"></td>
                                                            <td style="background-color: #DBE7C9; font-weight: bold; text-align: center">
                                                                {{ number_format($hasil_total_nilai_culture,0,'.',',') }}
                                                                <input type="hidden" name="total_skor_akhir_kpi_culture[]" value="{{ number_format($hasil_total_nilai_culture,0,'.',',') }}" id="">
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
                                                    <td class="text-center">KPI</td>
                                                    <td class="text-center">BOBOT (%)</td>
                                                    <td class="text-center">NILAI</td>
                                                    <td class="text-center">TOTAL NILAI</td>
                                                    <td class="text-center">SKOR NILAI</td>
                                                    <td class="text-center">KETERANGAN NILAI</td>
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
                                                    <td>
                                                        <input type="hidden" name="id_kpi_total_nilai[]" value="{{ $kpi_total_nilai->id }}">
                                                        <input type="text" name="kpi_total_nilai_nama_kpi[]" class="form-control" value="{{ $kpi_total_nilai->nama_kpi }}" readonly id="">
                                                    </td>
                                                    <td class="text-center">
                                                        @if (!empty($kpi_culture_verifikasi))
                                                        <input type="text" name="kpi_total_nilai_bobot[]" class="form-control text-center" value="{{ $kpi_total_nilai->bobot }}" autocomplete="off" placeholder="Bobot" id="">
                                                        @else
                                                        {{ $kpi_total_nilai->bobot }}
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if (empty($kpi_total_nilai->nilai))
                                                        <span class="badge bg-info">Input Otomatis</span>
                                                        @else
                                                        {{-- @if ($key_kpi_total_nilai%2 == 0)
                                                        {{ array_sum($total_nilai_pencapaian)/count($total_nilai_pencapaian) }}
                                                        @else
                                                        {{ $hasil_total_nilai_culture }}
                                                        @endif --}}
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
                                                        @if (!empty($kpi_culture_verifikasi))
                                                        <textarea name="kpi_total_nilai_keterangan[]" class="form-control" id="" cols="30" rows="2">{{ $kpi_total_nilai->keterangan }}</textarea>
                                                        @else
                                                        {{ $kpi_total_nilai->keterangan }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="3" style="background-color: #DBE7C9; font-weight: bold; text-align: right">GRAND TOTAL</td>
                                                    <td style="background-color: #DBE7C9; font-weight: bold; text-align: center">{{ array_sum($grand_total_nilai_kpi) }}</td>
                                                    <td style="background-color: #DBE7C9; font-weight: bold; text-align: center">{{ array_sum($grand_total_nilai_kpi) }}</td>
                                                    <td style="background-color: #DBE7C9; font-weight: bold; text-align: center"></td>
                                                </tr>
                                                {{-- <tr>
                                                    <td>
                                                        <input type="text" name="kpi_total_nilai_nama_kpi[]" class="form-control" value="KPI PERFORMANCE" readonly id="">
                                                    </td>
                                                    <td class="text-center"><input type="text" name="kpi_total_nilai_bobot[]" class="form-control text-center" placeholder="Bobot" id=""></td>
                                                    <td class="text-center"><span class="badge bg-info">Input Otomatis</span></td>
                                                    <td class="text-center"><span class="badge bg-info">Input Otomatis</span></td>
                                                    <td class="text-center"><span class="badge bg-info">Input Otomatis</span></td>
                                                    <td>
                                                        <textarea name="kpi_total_nilai_keterangan[]" class="form-control" id="" cols="30" rows="2"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="kpi_total_nilai_nama_kpi[]" class="form-control" value="KPI CULTURE" readonly id="">
                                                    </td>
                                                    <td class="text-center"><input type="text" name="kpi_total_nilai_bobot[]" class="form-control text-center" placeholder="Bobot" id=""></td>
                                                    <td class="text-center"><span class="badge bg-info">Input Otomatis</span></td>
                                                    <td class="text-center"><span class="badge bg-info">Input Otomatis</span></td>
                                                    <td class="text-center"><span class="badge bg-info">Input Otomatis</span></td>
                                                    <td>
                                                        <textarea name="kpi_total_nilai_keterangan[]" class="form-control" id="" cols="30" rows="2"></textarea>
                                                    </td>
                                                </tr> --}}
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
                                                    <th class="text-center" style="font-size: 48pt">
                                                        {{ number_format(array_sum($grand_total_nilai_kpi), 0, ',', '.') }}</th>
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
                                    'identifier' =>
                                        'Signature: ' .
                                        $kpi->mengetahui .
                                        "\n" .
                                        'Departemen: ' .
                                        'Direktur' .
                                        "\n" .
                                        // 'Penilaian Jabatan: '.'Direktur'."\n".
                                        'Periode Penilaian: ' .
                                        \Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY') .
                                        "\n" .
                                        'Tanggal Dibuat: ' .
                                        \Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL'),
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
                                    'identifier' =>
                                        'Signature: ' .
                                        $kpi->penilai .
                                        "\n" .
                                        'Penilaian Departemen: ' .
                                        $kpi->kpi_team->kpi_departemen->departemen .
                                        "\n" .
                                        // 'Penilaian Jabatan: '.$kpi_supervisor->jabatan."\n".
                                        'Periode Penilaian: ' .
                                        \Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY') .
                                        "\n" .
                                        'Tanggal Dibuat: ' .
                                        \Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL'),
                                ];
                                $dinilai = [
                                    'identifier' =>
                                        'Signature: ' .
                                        $kpi->yang_dinilai .
                                        "\n" .
                                        'Penilaian Departemen: ' .
                                        $kpi->kpi_team->kpi_departemen->departemen .
                                        "\n" .
                                        // 'Penilaian Jabatan: '.$kpi->kpi_team->jabatan."\n".
                                        'Periode Penilaian: ' .
                                        \Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY') .
                                        "\n" .
                                        'Tanggal Dibuat: ' .
                                        \Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL'),
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
                                                            <select name="status_mengetahui_{{ $key_1 }}"
                                                                class="form-control" id="">
                                                                <option value="">-- Pilih Validasi --</option>
                                                                <option value="y">Disetujui</option>
                                                                <option value="n">Ditolak</option>
                                                            </select>
                                                        @else
                                                            @php
                                                                $explode_status_mengetahui = explode('|', $kpi->status_mengetahui);
                                                            @endphp
                                                            @if ($explode_status_mengetahui[0] == null)
                                                                <select name="status_mengetahui_{{ $key_1 }}"
                                                                    class="form-control" id="">
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
                                                                $explode_status_mengetahui = explode('|', $kpi->status_mengetahui);
                                                            @endphp
                                                            @if ($explode_status_mengetahui[0] == null)
                                                                <span class="badge badge-outline-warning">Waiting
                                                                    Verification</span>
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
                                                            <select name="status_penilai_{{ $key_1 }}"
                                                                class="form-control" id="">
                                                                <option value="">-- Pilih Validasi --</option>
                                                                <option value="y">Disetujui</option>
                                                                <option value="n">Ditolak</option>
                                                            </select>
                                                        @else
                                                            @php
                                                                $explode_status_penilai = explode('|', $kpi->status_penilai);
                                                            @endphp
                                                            @if ($explode_status_penilai[0] == null)
                                                                <select name="status_penilai_{{ $key_1 }}"
                                                                    class="form-control" id="">
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
                                                                $explode_status_penilai = explode('|', $kpi->status_penilai);
                                                            @endphp
                                                            @if ($explode_status_penilai[0] == null)
                                                                <span class="badge badge-outline-warning">Waiting
                                                                    Verification</span>
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
                        <a href="{{ route('kpi.input_date_kpi_detail', ['date' => $date, 'id_departemen' => $id_departemen]) }}"
                            class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{ asset('public/assets/plugins/tippy/tippy.all.min.js') }}"></script>
@endsection