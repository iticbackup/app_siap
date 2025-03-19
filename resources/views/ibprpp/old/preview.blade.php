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
                <div class="card-header bg-dark">
                    <h5 class="card-title text-center text-white">IBPRPP</h5>
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
                        <div class="card-header bg-dark">
                            <h5 class="card-title text-white">Aktivitas & Jenis Pekerja</h5>
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
                        <div class="card-header bg-dark">
                            <h5 class="card-title text-white">Penilaian Risiko & Pengendalian</h5>
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
                                            <br> Kejadian
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($ibprpp->penilaian_risiko_pengendalian) as $key => $item)
                                        @php
                                            $rowspan = [];
                                        @endphp
                                        @foreach ($item->pengendalian as $key_pengendalian => $pengendalian)
                                            @php
                                                $rowspan = $key_pengendalian + 1;
                                            @endphp
                                        @endforeach
                                        {{-- @dd($rowspan); --}}
                                        <tr>
                                            <td style="vertical-align: top" rowspan="{{ $rowspan + 1 }}">
                                                {{ $item->potensi_bahaya }}</td>
                                            <td style="vertical-align: top" rowspan="{{ $rowspan + 1 }}">
                                                {{ $item->risiko_bahaya }}</td>
                                            <td style="vertical-align: top" class="text-center"
                                                rowspan="{{ $rowspan + 1 }}">
                                                {{ $item->jumlah_kejadian }}</td>
                                            <td style="vertical-align: top" class="text-center"
                                                rowspan="{{ $rowspan + 1 }}">{{ $item->frekuensi }}
                                            </td>
                                            <td style="vertical-align: top" class="text-center"
                                                rowspan="{{ $rowspan + 1 }}">{{ $item->keparahan }}
                                            </td>
                                            <td style="vertical-align: top" class="text-center"
                                                rowspan="{{ $rowspan + 1 }}">
                                                {{ $item->frekuensi * $item->keparahan }}</td>
                                            {{-- frekuensi 1 --}}
                                            @if ($item->frekuensi == 1 && $item->keparahan == 1)
                                                @php
                                                    $bgColor = '#A9D08E';
                                                @endphp
                                            @elseif ($item->frekuensi == 1 && $item->keparahan == 2)
                                                @php
                                                    $bgColor = '#A9D08E';
                                                @endphp
                                            @elseif ($item->frekuensi == 1 && $item->keparahan == 3)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp
                                            @elseif ($item->frekuensi == 1 && $item->keparahan == 4)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->frekuensi == 1 && $item->keparahan == 5)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                                {{-- frekuensi 2 --}}
                                            @elseif ($item->frekuensi == 2 && $item->keparahan == 1)
                                                @php
                                                    $bgColor = '#A9D08E';
                                                @endphp
                                            @elseif ($item->frekuensi == 2 && $item->keparahan == 2)
                                                @php
                                                    $bgColor = '#A9D08E';
                                                @endphp
                                            @elseif ($item->frekuensi == 2 && $item->keparahan == 3)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp
                                            @elseif ($item->frekuensi == 2 && $item->keparahan == 4)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->frekuensi == 2 && $item->keparahan == 5)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp

                                                {{-- frekuensi 3 --}}
                                            @elseif ($item->frekuensi == 3 && $item->keparahan == 1)
                                                @php
                                                    $bgColor = '#A9D08E';
                                                @endphp
                                            @elseif ($item->frekuensi == 3 && $item->keparahan == 2)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp
                                            @elseif ($item->frekuensi == 3 && $item->keparahan == 3)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->frekuensi == 3 && $item->keparahan == 4)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->frekuensi == 3 && $item->keparahan == 5)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp

                                                {{-- frekuensi 4 --}}
                                            @elseif ($item->frekuensi == 4 && $item->keparahan == 1)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp
                                            @elseif ($item->frekuensi == 4 && $item->keparahan == 2)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp
                                            @elseif ($item->frekuensi == 4 && $item->keparahan == 3)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->frekuensi == 4 && $item->keparahan == 4)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->frekuensi == 4 && $item->keparahan == 5)
                                                @php
                                                    $bgColor = 'red';
                                                @endphp

                                                {{-- frekuensi 5 --}}
                                            @elseif ($item->frekuensi == 5 && $item->keparahan == 1)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp
                                            @elseif ($item->frekuensi == 5 && $item->keparahan == 2)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->frekuensi == 5 && $item->keparahan == 3)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->frekuensi == 5 && $item->keparahan == 4)
                                                @php
                                                    $bgColor = 'red';
                                                @endphp
                                            @elseif ($item->frekuensi == 5 && $item->keparahan == 5)
                                                @php
                                                    $bgColor = 'red';
                                                @endphp

                                                {{-- dampak 1 --}}
                                            @elseif ($item->keparahan == 1 && $item->frekuensi == 1)
                                                @php
                                                    $bgColor = '#A9D08E';
                                                @endphp
                                            @elseif ($item->keparahan == 1 && $item->frekuensi == 2)
                                                @php
                                                    $bgColor = '#A9D08E';
                                                @endphp
                                            @elseif ($item->keparahan == 1 && $item->frekuensi == 3)
                                                @php
                                                    $bgColor = '#A9D08E';
                                                @endphp
                                            @elseif ($item->keparahan == 1 && $item->frekuensi == 4)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp
                                            @elseif ($item->keparahan == 1 && $item->frekuensi == 5)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp

                                                {{-- dampak 2 --}}
                                            @elseif ($item->keparahan == 2 && $item->frekuensi == 1)
                                                @php
                                                    $bgColor = '#A9D08E';
                                                @endphp
                                            @elseif ($item->keparahan == 2 && $item->frekuensi == 2)
                                                @php
                                                    $bgColor = '#A9D08E';
                                                @endphp
                                            @elseif ($item->keparahan == 2 && $item->frekuensi == 3)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp
                                            @elseif ($item->keparahan == 2 && $item->frekuensi == 4)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp
                                            @elseif ($item->keparahan == 2 && $item->frekuensi == 5)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp

                                                {{-- dampak 3 --}}
                                            @elseif ($item->keparahan == 3 && $item->frekuensi == 1)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp
                                            @elseif ($item->keparahan == 3 && $item->frekuensi == 2)
                                                @php
                                                    $bgColor = 'yellow';
                                                @endphp
                                            @elseif ($item->keparahan == 3 && $item->frekuensi == 3)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->keparahan == 3 && $item->frekuensi == 4)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->keparahan == 3 && $item->frekuensi == 5)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp

                                                {{-- dampak 4 --}}
                                            @elseif ($item->keparahan == 4 && $item->frekuensi == 1)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->keparahan == 4 && $item->frekuensi == 2)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->keparahan == 4 && $item->frekuensi == 3)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->keparahan == 4 && $item->frekuensi == 4)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->keparahan == 4 && $item->frekuensi == 5)
                                                @php
                                                    $bgColor = 'red';
                                                @endphp

                                                {{-- dampak 5 --}}
                                            @elseif ($item->keparahan == 4 && $item->frekuensi == 1)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->keparahan == 4 && $item->frekuensi == 2)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->keparahan == 4 && $item->frekuensi == 3)
                                                @php
                                                    $bgColor = '#F4B084';
                                                @endphp
                                            @elseif ($item->keparahan == 4 && $item->frekuensi == 4)
                                                @php
                                                    $bgColor = 'red';
                                                @endphp
                                            @elseif ($item->keparahan == 4 && $item->frekuensi == 5)
                                                @php
                                                    $bgColor = 'red';
                                                @endphp
                                            @endif
                                            <td style="vertical-align: top; background-color: {{ $bgColor }}"
                                                class="text-center" rowspan="{{ $rowspan + 1 }}">
                                                {{ $item->penetapan_pengendalian }}
                                            </td>
                                            {{-- <td style="vertical-align: top">
                                                @foreach ($item->pengendalian as $key_pengendalian => $pengendalian)
                                                <p>{{ $pengendalian->upaya_pengendalian }}</p>
                                                <hr>
                                                @endforeach
                                            </td>
                                            <td style="vertical-align: top">
                                                @foreach ($item->pengendalian as $key_pengendalian => $pengendalian)
                                                <p>{{ $pengendalian->penilaian_pengendalian }}</p>
                                                <hr>
                                                @endforeach
                                            </td> --}}
                                            {{-- <td style="vertical-align: top">{{ $item->pic_wewenang }}</td>
                                            <td style="vertical-align: top">{{ $item->regulasi_terkait }}</td> --}}
                                        </tr>
                                        @foreach ($item->pengendalian as $key_pengendalian => $pengendalian)
                                            <tr>
                                                <td style="vertical-align: top">{{ $pengendalian->upaya_pengendalian }}
                                                </td>
                                                <td class="text-center" style="vertical-align: top">
                                                    {{ $pengendalian->penilaian_pengendalian }}</td>
                                                @if ($key_pengendalian == 0)
                                                    <td rowspan="{{ $rowspan + 1 }}" style="vertical-align: top">
                                                        {{ $item->pic_wewenang }}</td>
                                                    <td rowspan="{{ $rowspan + 1 }}" style="vertical-align: top">
                                                        {{ $item->regulasi_terkait }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <a href="#" class="btn btn-warning"><i class="mdi mdi-pencil-outline"></i> Edit</a>
                    <button type="button" class="btn btn-danger"><i class="mdi mdi-trash-can-outline"></i> Hapus</button>
                </div>
                <div class="card-footer">
                    <a href="{{ route('qhse.ibprpp.departemen_download_pdf',['periode' => $ibprpp->ibprpp_periode->periode, 'departemen_id' => $ibprpp->ibprpp_departemen_id]) }}" class="btn btn-primary"><i class="mdi mdi-file-pdf"></i> Download PDF</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Matriks Risiko</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <div style="font-weight: bold">Table 1.1</div>
                                <div>Skala "Kemungkinan Terjadi (Probability)" - AS/NZS 4360 Standard</div>
                                <table class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Tingkat</th>
                                            <th class="text-center">Deskripsi</th>
                                            <th class="text-center" colspan="2">Keterangan</th>
                                            <th class="text-center">Penilaian Pengendalian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>Rare</td>
                                            <td>Sangat jarang terjadi (hampir tidak pernah)</td>
                                            <td>0 - 1 kasus dalam 1 tahun</td>
                                            <td>Efektif</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td>Unlikely</td>
                                            <td>Jarang terjadi</td>
                                            <td>2 - 3 kasus dalam 1 tahun</td>
                                            <td rowspan="4">Tidak Efektif/ Perlu Peninjauan dan Perbaikan</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td>Possible</td>
                                            <td>Dapat terjadi sesekali</td>
                                            <td>4 - 5 kasus dalam 1 tahun</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td>Likely</td>
                                            <td>Sering terjadi</td>
                                            <td>6 - 7 kasus dalam 1 tahun</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td>Almost Certain</td>
                                            <td>Sangat sering terjadi (dapat terjadi setiap saat)</td>
                                            <td>>7 kasus dalam 1 tahun</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <div style="font-weight: bold">Table 1.2</div>
                                <div>Skala "Keparahan (Severity)" - AS/NZS 4360 Standard</div>
                                <table class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Tingkat</th>
                                            <th class="text-center">Deskripsi</th>
                                            <th class="text-center" colspan="2">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>Insignificant</td>
                                            <td>Tidak terjadi cidera; kerugian finansial sedikit</td>
                                            <td>Kerugian finansial < Rp.1.000.000,- </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td>Minor</td>
                                            <td>Cidera ringan; kerugian finansial sedikit</td>
                                            <td>Kerugian finansial < Rp.2.000.000,- </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td>Moderate</td>
                                            <td>Cidera sedang; perlu penanganan medis</td>
                                            <td>Kerugian finansial < Rp.3.000.000,- </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td>Major</td>
                                            <td>Cidera berat > 1 orang; kerugian finansial besar; gangguan produksi</td>
                                            <td>Kerugian finansial > Rp.3.000.000,- </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td>Catastrophic</td>
                                            <td>Fatal > 1 orang; kerugian finansial sangat besar dan berdampak sangat luas;
                                                terhentinya seluruh kegiatan</td>
                                            <td>Kerugian finansial > Rp.10.000.000,- </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div style="font-weight: bold">Table 1.3</div>
                                <div>Matriks Risiko - AS/NZS 4360 Standard</div>
                                <table class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2" style="width: 20%">Frekuensi Risiko
                                            </th>
                                            <th class="text-center" colspan="5">Dampak Risiko</th>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">2</td>
                                            <td class="text-center">3</td>
                                            <td class="text-center">4</td>
                                            <td class="text-center">5</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td class="text-center" style="background-color: yellow">M</td>
                                            <td class="text-center" style="background-color: #F4B084">H</td>
                                            <td class="text-center" style="background-color: #F4B084">H</td>
                                            <td class="text-center" style="background-color: red">E</td>
                                            <td class="text-center" style="background-color: red">E</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td class="text-center" style="background-color: yellow">M</td>
                                            <td class="text-center" style="background-color: yellow">M</td>
                                            <td class="text-center" style="background-color: #F4B084">H</td>
                                            <td class="text-center" style="background-color: #F4B084">H</td>
                                            <td class="text-center" style="background-color: red">E</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td class="text-center" style="background-color: #A9D08E">L</td>
                                            <td class="text-center" style="background-color: yellow">M</td>
                                            <td class="text-center" style="background-color: #F4B084">H</td>
                                            <td class="text-center" style="background-color: #F4B084">H</td>
                                            <td class="text-center" style="background-color: #F4B084">H</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td class="text-center" style="background-color: #A9D08E">L</td>
                                            <td class="text-center" style="background-color: #A9D08E">L</td>
                                            <td class="text-center" style="background-color: yellow">M</td>
                                            <td class="text-center" style="background-color: #F4B084">H</td>
                                            <td class="text-center" style="background-color: #F4B084">H</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center" style="background-color: #A9D08E">L</td>
                                            <td class="text-center" style="background-color: #A9D08E">L</td>
                                            <td class="text-center" style="background-color: yellow">M</td>
                                            <td class="text-center" style="background-color: #F4B084">H</td>
                                            <td class="text-center" style="background-color: #F4B084">H</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <div style="font-weight: bold">Table 1.4</div>
                                <div>Upaya Pengendalian</div>
                                <table class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 10%">Tingkat</th>
                                            <th class="text-center" style="width: 20%">Jenis</th>
                                            <th class="text-center" style="width: 20%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Eliminasi</td>
                                            <td>Menghilangkan bahaya</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td class="text-center">Substitusi</td>
                                            <td>Mengganti sumber/ alat/ mesin/ bahan/ material/ aktivitas/ area yang lebih
                                                aman</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td class="text-center">Perancangan</td>
                                            <td>Perancangan/ perencanaan/ modifikasi
                                                instalasi sumber sumber/ alat/ mesin/ bahan/ material/ aktivitas/ area yang
                                                lebih aman</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td class="text-center">Administrasi</td>
                                            <td>Penerapan prosedur/ aturan kerja, pelatihan
                                                dan pengendalian visual di tempat kerja</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td class="text-center">APD</td>
                                            <td>Penyediaan Alat Pelindung Diri bagi tenaga
                                                kerja dengan paparan bahaya/ risiko tinggi</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
