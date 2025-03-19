<style>
    * {
        font-family: Arial, Helvetica, sans-serif
    }

    table,
    td,
    th {
        border: 1px solid;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .text-center {
        text-align: center
    }

    .text-capital {
        text-transform: uppercase
    }
</style>
<table>
    <thead>
        <tr>
            <td rowspan="4" class="text-center">PT Indonesian Tobacco Tbk.</td>
            <td colspan="14" rowspan="2" class="text-center">FORMULIR</td>
            <td>No. Dokumen</td>
            <td>:</td>
            <td>IT/QHSE/FR/01-01</td>
        </tr>
        <tr>
            <td>Revisi</td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td colspan="14" rowspan="2" class="text-center">IBPRPP (Identifikasi Bahaya, Penilaian Risiko dan
                Penetapan Pengendalian)</td>
            <td>Halaman</td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>28/02/2025</td>
        </tr>
    </thead>
    {{-- <tbody>
        <tr style="border: 0px">
            <td colspan="2">Periode</td>
            <td colspan="15">{{ $ibprpp->ibprpp_periode->periode }}</td>
        </tr>
    </tbody> --}}
</table>
<div style="margin-top: 1%; margin-bottom: 1%">Periode : {{ $periode->periode }}</div>
<table>
    <thead>
        <tr>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">No</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Aktivitas Pekerjaan</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Jenis Aktivitas <br> (Rutin/Non
                Rutin/Darurat)</th>
            <th class="text-capital" style="font-size: 8pt" colspan="2" rowspan="2">Potensi Bahaya</th>
            <th class="text-capital" style="font-size: 8pt" colspan="2" rowspan="2">Risiko Bahaya</th>
            <th class="text-capital" style="font-size: 8pt" colspan="3">Penilaian Risiko</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Nilai Risiko</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Penetapan Pengendalian</th>
            <th class="text-capital" style="font-size: 8pt">Pengendalian</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">PIC/<br>Wewenang</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Regulasi Terkait</th>
        </tr>
        <tr>
            <th class="text-capital" style="font-size: 8pt">Jumlah <br> Kejadian <br> Dalam 1 <br> Periode <br>
                Penilaian</th>
            <th class="text-capital" style="font-size: 8pt">Frekuensi <br> <em>(Probability)</em></th>
            <th class="text-capital" style="font-size: 8pt">Keparahan <br> <em>(Severity)</em></th>
            <th class="text-capital" style="font-size: 8pt; width: 25%">Upaya & Penilaian <br> Pengendalian <br> Berdasarkan <br>
                Frekuensi <br> Kejadian</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ibprpp_category_areas as $ibprpp_category_area)
            <tr>
                <td style="font-size: 10pt" colspan="15">{{ $ibprpp_category_area->category_area }}</td>
            </tr>
            @php
                $ibprpps = \App\Models\IBPRPP::where('ibprpp_periode_id', $periode->id)
                    ->where('ibprpp_departemen_id', $departemen_id)
                    ->get();
            @endphp
            @foreach ($ibprpps as $key_ibprpp => $ibprpp)
                @if ($key_ibprpp == 0)
                    <tr>
                        <td style="font-size: 10pt" colspan="15">{{ $ibprpp->ibprpp_departemen->departemen }}</td>
                    </tr>
                @endif
                @php
                    $totalRowPotensiBahaya = [];
                    foreach (json_decode($ibprpp->body) as $key => $item) {
                        $totalRowPotensiBahaya = count($item->risiko_bahaya) + 4;
                    }
                @endphp
                <tr>
                    <td style="font-size: 10pt; vertical-align: top" rowspan="{{ $totalRowPotensiBahaya + 2 }}">{{ $key_ibprpp + 1 }}</td>
                    <td style="font-size: 10pt; vertical-align: top" rowspan="{{ $totalRowPotensiBahaya + 2 }}">
                        {{ $ibprpp->aktivitas_pekerja }}</td>
                    <td style="font-size: 10pt; vertical-align: top" rowspan="{{ $totalRowPotensiBahaya + 2 }}">{{ $ibprpp->jenis_aktivitas }}
                    </td>
                </tr>
                @foreach (json_decode($ibprpp->body) as $key => $item)
                    @php
                        $totalRowRisikoBahaya = count($item->risiko_bahaya) + 1;
                    @endphp
                    <tr>
                        <td style="font-size: 10pt; vertical-align: top" rowspan="{{ $totalRowRisikoBahaya }}">{{ $key + 1 }}</td>
                        <td style="font-size: 10pt; vertical-align: top" rowspan="{{ $totalRowRisikoBahaya }}">{{ $item->potensi_bahaya }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <td>123</td>
                        <td>123</td>
                    </tr> --}}
                    @foreach ($item->risiko_bahaya as $key_risiko_bahaya => $risiko_bahaya)
                        @if ($risiko_bahaya->frekuensi == 1 && $risiko_bahaya->keparahan == 1)
                            @php
                                $bgColor = '#A9D08E';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 1 && $risiko_bahaya->keparahan == 2)
                            @php
                                $bgColor = '#A9D08E';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 1 && $risiko_bahaya->keparahan == 3)
                            @php
                                $bgColor = 'yellow';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 1 && $risiko_bahaya->keparahan == 4)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 1 && $risiko_bahaya->keparahan == 5)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                            {{-- frekuensi 2 --}}
                        @elseif ($risiko_bahaya->frekuensi == 2 && $risiko_bahaya->keparahan == 1)
                            @php
                                $bgColor = '#A9D08E';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 2 && $risiko_bahaya->keparahan == 2)
                            @php
                                $bgColor = '#A9D08E';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 2 && $risiko_bahaya->keparahan == 3)
                            @php
                                $bgColor = 'yellow';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 2 && $risiko_bahaya->keparahan == 4)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 2 && $risiko_bahaya->keparahan == 5)
                            @php
                                $bgColor = '#F4B084';
                            @endphp

                            {{-- frekuensi 3 --}}
                        @elseif ($risiko_bahaya->frekuensi == 3 && $risiko_bahaya->keparahan == 1)
                            @php
                                $bgColor = '#A9D08E';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 3 && $risiko_bahaya->keparahan == 2)
                            @php
                                $bgColor = 'yellow';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 3 && $risiko_bahaya->keparahan == 3)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 3 && $risiko_bahaya->keparahan == 4)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 3 && $risiko_bahaya->keparahan == 5)
                            @php
                                $bgColor = '#F4B084';
                            @endphp

                            {{-- frekuensi 4 --}}
                        @elseif ($risiko_bahaya->frekuensi == 4 && $risiko_bahaya->keparahan == 1)
                            @php
                                $bgColor = 'yellow';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 4 && $risiko_bahaya->keparahan == 2)
                            @php
                                $bgColor = 'yellow';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 4 && $risiko_bahaya->keparahan == 3)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 4 && $risiko_bahaya->keparahan == 4)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 4 && $risiko_bahaya->keparahan == 5)
                            @php
                                $bgColor = 'red';
                            @endphp

                            {{-- frekuensi 5 --}}
                        @elseif ($risiko_bahaya->frekuensi == 5 && $risiko_bahaya->keparahan == 1)
                            @php
                                $bgColor = 'yellow';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 5 && $risiko_bahaya->keparahan == 2)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 5 && $risiko_bahaya->keparahan == 3)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 5 && $risiko_bahaya->keparahan == 4)
                            @php
                                $bgColor = 'red';
                            @endphp
                        @elseif ($risiko_bahaya->frekuensi == 5 && $risiko_bahaya->keparahan == 5)
                            @php
                                $bgColor = 'red';
                            @endphp

                            {{-- dampak 1 --}}
                        @elseif ($risiko_bahaya->keparahan == 1 && $risiko_bahaya->frekuensi == 1)
                            @php
                                $bgColor = '#A9D08E';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 1 && $risiko_bahaya->frekuensi == 2)
                            @php
                                $bgColor = '#A9D08E';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 1 && $risiko_bahaya->frekuensi == 3)
                            @php
                                $bgColor = '#A9D08E';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 1 && $risiko_bahaya->frekuensi == 4)
                            @php
                                $bgColor = 'yellow';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 1 && $risiko_bahaya->frekuensi == 5)
                            @php
                                $bgColor = 'yellow';
                            @endphp

                            {{-- dampak 2 --}}
                        @elseif ($risiko_bahaya->keparahan == 2 && $risiko_bahaya->frekuensi == 1)
                            @php
                                $bgColor = '#A9D08E';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 2 && $risiko_bahaya->frekuensi == 2)
                            @php
                                $bgColor = '#A9D08E';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 2 && $risiko_bahaya->frekuensi == 3)
                            @php
                                $bgColor = 'yellow';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 2 && $risiko_bahaya->frekuensi == 4)
                            @php
                                $bgColor = 'yellow';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 2 && $risiko_bahaya->frekuensi == 5)
                            @php
                                $bgColor = '#F4B084';
                            @endphp

                            {{-- dampak 3 --}}
                        @elseif ($risiko_bahaya->keparahan == 3 && $risiko_bahaya->frekuensi == 1)
                            @php
                                $bgColor = 'yellow';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 3 && $risiko_bahaya->frekuensi == 2)
                            @php
                                $bgColor = 'yellow';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 3 && $risiko_bahaya->frekuensi == 3)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 3 && $risiko_bahaya->frekuensi == 4)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 3 && $risiko_bahaya->frekuensi == 5)
                            @php
                                $bgColor = '#F4B084';
                            @endphp

                            {{-- dampak 4 --}}
                        @elseif ($risiko_bahaya->keparahan == 4 && $risiko_bahaya->frekuensi == 1)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 4 && $risiko_bahaya->frekuensi == 2)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 4 && $risiko_bahaya->frekuensi == 3)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 4 && $risiko_bahaya->frekuensi == 4)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 4 && $risiko_bahaya->frekuensi == 5)
                            @php
                                $bgColor = 'red';
                            @endphp

                            {{-- dampak 5 --}}
                        @elseif ($risiko_bahaya->keparahan == 4 && $risiko_bahaya->frekuensi == 1)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 4 && $risiko_bahaya->frekuensi == 2)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 4 && $risiko_bahaya->frekuensi == 3)
                            @php
                                $bgColor = '#F4B084';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 4 && $risiko_bahaya->frekuensi == 4)
                            @php
                                $bgColor = 'red';
                            @endphp
                        @elseif ($risiko_bahaya->keparahan == 4 && $risiko_bahaya->frekuensi == 5)
                            @php
                                $bgColor = 'red';
                            @endphp
                        @endif
                        <tr>
                            <td style="font-size: 10pt; vertical-align: top">{{ $key_risiko_bahaya + 1 }}</td>
                            <td style="font-size: 10pt; vertical-align: top">{{ $risiko_bahaya->risiko_bahaya }}</td>
                            <td class="text-center" style="font-size: 10pt; vertical-align: top">{{ $risiko_bahaya->jumlah_kejadian }}</td>
                            <td class="text-center" style="font-size: 10pt; vertical-align: top">{{ $risiko_bahaya->frekuensi }}</td>
                            <td class="text-center" style="font-size: 10pt; vertical-align: top">{{ $risiko_bahaya->keparahan }}</td>
                            <td class="text-center" style="font-size: 10pt; vertical-align: top">{{ $risiko_bahaya->frekuensi * $risiko_bahaya->keparahan }}
                            </td>
                            <td class="text-center" style="font-size: 10pt; vertical-align: top; background-color: {{ $bgColor }}">{{ $risiko_bahaya->penetapan_pengendalian }}</td>
                            <td>
                                <div style="font-size: 10pt; font-weight: bold">Upaya & Penilaian
                                    Pengendalian Berdasarkan Frekuensi Kejadian :</div>
                                <ul>
                                    @foreach ($item->upaya_pengendalian as $upaya_pengendalian)
                                        <li>
                                            <div style="font-size: 10pt;">{!! $upaya_pengendalian->upaya_pengendalian . ' - <b>' . $upaya_pengendalian->penilaian_pengendalian . '</b>' !!}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td style="vertical-align: top; font-size: 10pt">{{ $item->pic_wewenang }}
                            </td>
                            <td style="vertical-align: top; font-size: 10pt">
                                {{ $item->regulasi_terkait }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>
