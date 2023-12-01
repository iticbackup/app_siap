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
                <div class="card-body">
                    <div class="alert alert-outline-primary" style="width: 100%" role="alert">
                        <strong>Informasi!</strong> Tanggal pengumpulan KPI terakhir tanggal <b>{{ $due_date }}</b>
                    </div>
                    <div class="mb-3">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.forms-advanced.js') }}"></script>
@endsection
