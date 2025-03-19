@extends('layouts.apps.master')
@section('title')
    IBPRPP
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
                    <h5 class="card-title text-center">IBPRPP</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 30%;">
                        <tr>
                            <th>Periode</th>
                            <th>:</th>
                            <td>{{ $ibprpp->ibprpp_periode->periode }}</td>
                        </tr>
                        <tr>
                            <th>Departemen</th>
                            <th>:</th>
                            <td>{{ $ibprpp->ibprpp_departemen->departemen }}</td>
                        </tr>
                        <tr>
                            <th>Kategori Area</th>
                            <th>:</th>
                            <td>{{ $ibprpp->ibprpp_category_area->category_area }}</td>
                        </tr>
                    </table>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Aktivitas & Jenis Pekerja</h5>
                        </div>
                        <div class="card-body">
                            {{-- <div class="mb-3">
                                <label for="">Aktivitas Pekerja</label>
                                <p>{{ $ibprpp->aktivitas_pekerja }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="">Jenis Aktivitas</label>
                                <p>-</p>
                            </div> --}}
                            <table class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 50%;">
                                <tr>
                                    <th>Aktivitas Pekerja</th>
                                    <th>:</th>
                                    <td>{{ $ibprpp->aktivitas_pekerja }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Aktivitas</th>
                                    <th>:</th>
                                    <td>{{ $ibprpp->jenis_aktivitas }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Penilaian Risiko & Pengendalian</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center" rowspan="2" style="width: 10%">Potensi Bahaya</th>
                                        <th class="text-center" rowspan="2" style="width: 10%">Risiko Bahaya</th>
                                        <th class="text-center" colspan="3">Penilaian Risiko</th>
                                        <th class="text-center" rowspan="2">Nilai Risiko</th>
                                        <th class="text-center" rowspan="2">Penetapan <br> Pengendalian</th>
                                        <th class="text-center" colspan="2">Pengendalian</th>
                                        <th class="text-center" rowspan="2" style="width: 10%">PIC / <br> Wewenang</th>
                                        <th class="text-center" rowspan="2" style="width: 10%">Regulasi Terkait</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Jumlah <br> Kejadian <br> Dalam 1 <br> Periode <br>
                                            Penilaian</th>
                                        <th class="text-center">Frekuensi <br> <em>(Probability)</em></th>
                                        <th class="text-center">Keparahan <br> <em>(Severity)</em></th>
                                        <th class="text-center" style="width: 15%;">Upaya</th>
                                        <th class="text-center">Penilaian <br> Pengendalian <br> Berdasarkan <br> Frekuensi
                                            <br> Kejadian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td rowspan="4">Paparan radiasi cahaya komputer</td>
                                        <td rowspan="4">Iritasi mata dan gangguan penglihatan</td>
                                        <td rowspan="4">0</td>
                                        <td rowspan="4">1</td>
                                        <td rowspan="4">1</td>
                                        <td rowspan="4">1</td>
                                        <td rowspan="4">0</td>
                                    </tr>
                                    <tr>
                                        <td>Melakukan relaksasi mata dengan melihat atas,kanan dan kiri</td>
                                        <td>Efektif</td>
                                    </tr>
                                    <tr>
                                        <td>Melakukan relaksasi mata dengan melihat atas,kanan dan kiri</td>
                                        <td>Efektif</td>
                                    </tr>
                                    <tr>
                                        <td>Melakukan relaksasi mata dengan melihat atas,kanan dan kiri</td>
                                        <td>Efektif</td>
                                    </tr>
                                    <tr>
                                        <td>Melakukan relaksasi mata dengan melihat atas,kanan dan kiri</td>
                                        <td>Efektif</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
