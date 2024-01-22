@extends('layouts.apps.master')
@section('title')
    Buat KPI
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
                <div class="card-header bg-dark">
                    <h4 class="card-title text-white text-center" style="font-size: 14pt">Formulir Key Performance Indicator
                    </h4>
                </div>
                <form action="{{ route('kpi.input_date_kpi_simpan', $date) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="alert alert-outline-primary" style="width: 100%" role="alert">
                            <strong>Informasi!</strong> Tanggal pengumpulan KPI terakhir tanggal
                            <b>{{ \Carbon\Carbon::create($date)->isoFormat('dddd, DD MMMM YYYY') }}</b>
                        </div>
                        @foreach ($kpi_teams as $key_1 => $kpi_team)
                            @php
                                $kpi_indikators = \App\Models\KpiIndikator::where('kpi_team_id', $kpi_team->id)->get();
                                $mengetahui = \App\Models\DepartemenUser::select('team')
                                    ->where('team', 'Andre Martinus')
                                    ->first();
                                $penilais = \App\Models\KpiTeam::where('kpi_departemen_id', $kpi_team->kpi_departemen_id)->get();
                            @endphp
                            <div class="mb-3">
                                <table style="width: 30%">
                                    <tr>
                                        <td>Nama Karyawan</td>
                                        <td>:</td>
                                        <td>
                                            <input type="hidden" name="kpi_team_id[]" value="{{ $kpi_team->id }}"
                                                id="">
                                            <input type="text" name="yang_dinilai[]" class="form-control"
                                                value="{{ $kpi_team->departemen_user->team }}" readonly id="">
                                            {{-- <select name="" id="" class="form-control">
                                        <option value="">-- Pilih Karyawan --</option>
                                    </select> --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $kpi_team->jabatan }}"
                                                readonly id="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Induk Karyawan</td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" value="{{ $kpi_team->departemen_user->nik }}"
                                                class="form-control" id="" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Periode Penilaian</td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" value="{{ $periode->isoFormat('MMMM YYYY') }}" readonly
                                                class="form-control">
                                            <input type="hidden" name="periode[]" value="{{ $periode->format('Y-m-d') }}"
                                                readonly class="form-control">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mb-3">
                                <div class="card">
                                    <div class="card-header bg-dark">
                                        <div class="text-center text-white" style="font-weight: bold">KPI PERFORMANCE</div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <td class="text-center" rowspan="2" style="width: 2%">No</td>
                                                    <td class="text-center" rowspan="2" style="width: 500px">Indikator
                                                    </td>
                                                    <td class="text-center" colspan="2">Target</td>
                                                    <td class="text-center" colspan="2">Realisasi</td>
                                                    <td class="text-center" rowspan="2" style="width: 100px">(%)
                                                        Pencapaian</td>
                                                    <td class="text-center" rowspan="2" style="width: 5%">Bobot</td>
                                                    {{-- <td class="text-center" rowspan="2">Nilai</td>
                                            <td class="text-center" rowspan="2">Skor</td> --}}
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
                                                @forelse ($kpi_indikators as $key_2 => $kpi_indikator)
                                                    <input type="hidden" name="detail_{{ $key_1 }}[]"
                                                        value="{{ $key_2 + 1 }}" id="">
                                                    <tr>
                                                        <td class="text-center">{{ $key_2 + 1 }}</td>
                                                        <td>
                                                            {{-- {{ $kpi_indikator->indikator }} --}}
                                                            <textarea name="indikator_{{ $key_1 }}[]" class="form-control" id="" cols="20" rows="5"
                                                                readonly>{{ $kpi_indikator->indikator }}</textarea>
                                                        </td>
                                                        <td><input type="text" name="target_nilai_{{ $key_1 }}[]"
                                                                class="form-control text-center" placeholder="Nilai"
                                                                id=""></td>
                                                        <td>
                                                            <textarea name="target_keterangan_{{ $key_1 }}[]" class="form-control" id="" cols="2"
                                                                rows="3"></textarea>
                                                        </td>
                                                        <td><input type="text"
                                                                name="realisasi_nilai_{{ $key_1 }}[]"
                                                                class="form-control text-center" placeholder="Nilai"
                                                                id=""></td>
                                                        <td>
                                                            <textarea name="realisasi_keterangan_{{ $key_1 }}[]" class="form-control" id="" cols="2"
                                                                rows="3"></textarea>
                                                        </td>
                                                        <td><input type="text" name="pencapaian_{{ $key_1 }}[]"
                                                                class="form-control text-center" placeholder="Pencapaian"
                                                                id=""></td>
                                                        <td class="text-center">
                                                            {{ $kpi_indikator->bobot }}%
                                                            <input type="hidden" name="bobot_{{ $key_1 }}[]"
                                                                value="{{ $kpi_indikator->bobot }}" id="">
                                                        </td>
                                                        {{-- <td></td>
                                                <td></td> --}}
                                                        <td>
                                                            <textarea name="keterangan_{{ $key_1 }}[]" class="form-control" id="" cols="2"
                                                                rows="3"></textarea>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="11" class="text-center">Data Belum Tersedia</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
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
                                                    <td class="text-center" style="width: 25%">Indikator</td>
                                                    <td class="text-center" style="width: 20%">Skala</td>
                                                    <td class="text-center" style="width: 20%">Bobot</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kpi_cultures as $key_culture => $kpi_culture)
                                                    <input type="hidden" name="detail_culture_{{ $key_1 }}[]"
                                                        value="{{ $key_culture + 1 }}">
                                                    <tr>
                                                        <td class="text-center">{{ $key_culture + 1 }}</td>
                                                        <td class="text-center">
                                                            {{ $kpi_culture->culture }}
                                                            <input type="hidden"
                                                                name="kpi_culture_{{ $key_1 }}[]"
                                                                value="{{ $kpi_culture->culture }}" id="">
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $kpi_culture->indikator }}
                                                            <input type="hidden"
                                                                name="indikator_kpi_culture_{{ $key_1 }}[]"
                                                                value="{{ $kpi_culture->indikator }}" id="">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="skala_kpi_culture_{{ $key_culture }}[]"
                                                                class="form-control text-center" readonly
                                                                placeholder="Skala" id="">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="bobot_kpi_culture_{{ $key_culture }}[]"
                                                                class="form-control text-center" readonly
                                                                placeholder="Bobot (%)" id="">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-dark">
                                            <div class="text-center text-white" style="font-weight: bold">TOTAL NILAI KPI
                                            </div>
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
                                                    {{-- @php
                                                        $kpi_detail_total_nilais = \DB::table('kpi_detail_total_nilai')
                                                            ->where('status', 'y')
                                                            ->get();
                                                    @endphp
                                                    @foreach ($kpi_detail_total_nilais as $key_kpi_detail_total_nilai => $kpi_detail_total_nilai)
                                                        <tr>
                                                            <td><input type="text"
                                                                    name="kpi_total_nilai_nama_kpi_{{ $key_1 }}[]"
                                                                    class="form-control text-center"
                                                                    value="{{ $kpi_detail_total_nilai->nama_kpi }}"
                                                                    readonly id=""></td>
                                                            <td class="text-center"><input type="text"
                                                                    name="kpi_total_nilai_bobot[]"
                                                                    class="form-control text-center" readonly
                                                                    placeholder="Bobot" id=""></td>
                                                            <td class="text-center"><span class="badge bg-info">Input
                                                                    Otomatis</span></td>
                                                            <td class="text-center"><span class="badge bg-info">Input
                                                                    Otomatis</span></td>
                                                            <td class="text-center"><span class="badge bg-info">Input
                                                                    Otomatis</span></td>
                                                            <td>
                                                                <textarea name="kpi_total_nilai_keterangan[]" readonly class="form-control" id="" cols="30"
                                                                    rows="2"></textarea>
                                                            </td>
                                                        </tr>
                                                    @endforeach --}}
                                                    <tr>
                                                        <td>
                                                            <input type="text"
                                                                name="kpi_total_nilai_nama_kpi_{{ $key_1 }}[]"
                                                                class="form-control text-center" value="KPI PERFORMANCE"
                                                                readonly id="">
                                                        </td>
                                                        <td class="text-center"><input type="text"
                                                                name="kpi_total_nilai_bobot[]"
                                                                class="form-control text-center" readonly
                                                                placeholder="Bobot" id=""></td>
                                                        <td class="text-center"><span class="badge bg-info">Input
                                                                Otomatis</span></td>
                                                        <td class="text-center"><span class="badge bg-info">Input
                                                                Otomatis</span></td>
                                                        <td class="text-center"><span class="badge bg-info">Input
                                                                Otomatis</span></td>
                                                        <td>
                                                            <textarea name="kpi_total_nilai_keterangan[]" readonly class="form-control" id="" cols="30"
                                                                rows="2"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text"
                                                                name="kpi_total_nilai_nama_kpi_{{ $key_1 }}[]"
                                                                class="form-control text-center" value="KPI CULTURE"
                                                                readonly id="">
                                                        </td>
                                                        <td class="text-center"><input type="text"
                                                                name="kpi_total_nilai_bobot[]"
                                                                class="form-control text-center" readonly
                                                                placeholder="Bobot" id=""></td>
                                                        <td class="text-center"><span class="badge bg-info">Input
                                                                Otomatis</span></td>
                                                        <td class="text-center"><span class="badge bg-info">Input
                                                                Otomatis</span></td>
                                                        <td class="text-center"><span class="badge bg-info">Input
                                                                Otomatis</span></td>
                                                        <td>
                                                            <textarea name="kpi_total_nilai_keterangan[]" readonly class="form-control" id="" cols="30"
                                                                rows="2"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
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
                            </div>
                            {{-- <div class="mb-3">
                        <label for="">Catatan :</label>
                        <textarea name="remaks[]" class="form-control" id="" cols="30" rows="5"></textarea>
                    </div> --}}
                            @php
                                $dinilai = [
                                    'identifier' => 'Signature: ' . $kpi_team->departemen_user->team . "\n" . 'Penilaian Departemen: ' . $kpi_team->kpi_departemen->departemen . "\n" . 'Penilaian Jabatan: ' . $kpi_team->jabatan . "\n" . 'Periode Penilaian: ' . \Carbon\Carbon::create($periode)->isoFormat('MMMM YYYY') . "\n",
                                    // 'Penilaian Departemen: '.$kpi->kpi_team->kpi_departemen->departemen."\n".
                                    // 'Penilaian Jabatan: '.$kpi->kpi_team->jabatan."\n".
                                    // 'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')."\n".
                                    // 'Tanggal Dibuat: '.\Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL')
                                ];
                            @endphp
                            <div class="mb-3">
                                <table class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 50%;">
                                    <thead>
                                        <tr>
                                            <td class="text-center" colspan="3">Validasi</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Mengetahui</td>
                                            <td class="text-center">Penilai</td>
                                            <td class="text-center">Yang Dinilai</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" style="height: 100px"></td>
                                            <td class="text-center" style="height: 100px"></td>
                                            <td class="text-center" style="height: 100px">{!! DNS2D::getBarcodeSVG($dinilai['identifier'], 'QRCODE', 2, 2) !!}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                {{ $mengetahui->team }}
                                                <input type="hidden" name="mengetahui[]"
                                                    value="{{ $mengetahui->team }}" id="">
                                                {{-- <select name="mengetahui[]" class="form-control" id="">
                                            <option value="">-- Pilih Mengetahui --</option>
                                            <option value="{{ $mengetahui->team }}">{{ $mengetahui->team }}</option>
                                        </select> --}}
                                            </td>
                                            <td class="text-center">
                                                <select name="penilai[]" class="form-control" id="" required>
                                                    <option value="">-- Pilih Penilai --</option>
                                                    {{-- <option value="{{ $mengetahui->team }}">{{ $mengetahui->team }}</option> --}}
                                                    @if ($kpi_team->jabatan == 'Supervisor')
                                                        <option value="{{ $mengetahui->team }}">{{ $mengetahui->team }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $mengetahui->team }}">{{ $mengetahui->team }}
                                                        </option>
                                                        @foreach ($penilais as $penilai)
                                                            @if ($penilai->jabatan != 'Staff')
                                                                <option value="{{ $penilai->departemen_user->team }}">
                                                                    {{ $penilai->departemen_user->team }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-center">{{ $kpi_team->departemen_user->team }}</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <hr style="border-top: 3px dashed rgb(0, 17, 255);">
                        @endforeach
                        {{-- <div class="mb-3">
                        <table style="width: 100%">
                            <tr>
                                <td>Nama Karyawan</td>
                                <td>:</td>
                                <td>
                                    <select name="" id="" class="form-control">
                                        <option value="">-- Pilih Karyawan --</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>
                                    <select name="" id="" class="form-control">
                                        <option value="">-- Pilih Jabatan --</option>
                                        <option value="Staff">Staff</option>
                                        <option value="Operator">Operator</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor Induk Karyawan</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="" class="form-control" id="" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Periode Penilaian</td>
                                <td>:</td>
                                <td>

                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="mb-3">
                        <table class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <td class="text-center" rowspan="2">No</td>
                                    <td class="text-center" rowspan="2" style="width: 250px">Indikator</td>
                                    <td class="text-center" colspan="2">Target</td>
                                    <td class="text-center" colspan="2">Realisasi</td>
                                    <td class="text-center" rowspan="2" style="width: 100px">(%) Pencapaian</td>
                                    <td class="text-center" rowspan="2">Bobot</td>
                                    <td class="text-center" rowspan="2">Nilai</td>
                                    <td class="text-center" rowspan="2">Skor</td>
                                    <td class="text-center" rowspan="2">Keterangan</td>
                                </tr>
                                <tr>
                                    <td class="text-center">Nilai</td>
                                    <td class="text-center">Ket./Satuan</td>
                                    <td class="text-center">Nilai</td>
                                    <td class="text-center">Ket./Satuan</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-6">
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
                    </div>
                    <div class="mb-3">
                        <label for="">Catatan :</label>
                        <textarea name="" class="form-control" id="" cols="30" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <table class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 30%;">
                            <thead>
                                <tr>
                                    <td class="text-center" colspan="3">Validasi</td>
                                </tr>
                                <tr>
                                    <td class="text-center">Mengetahui</td>
                                    <td class="text-center">Penilai</td>
                                    <td class="text-center">Yang Dinilai</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="height: 100px"></td>
                                    <td class="text-center" style="height: 100px"></td>
                                    <td class="text-center" style="height: 100px"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">Andre Martinus</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                            </thead>
                        </table>
                    </div> --}}
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('kpi') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.forms-advanced.js') }}"></script>
@endsection
