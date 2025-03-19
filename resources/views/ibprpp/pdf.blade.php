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

    /* @page {
        size: A3;
    } */

    @media print {
        @page {
            size: landscape
        }

        html,
        body {
            width: 420mm;
            height: 297mm;
            /* margin: 20px; */
            /* margin-top: 20px;
            margin-right: 20px; */
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            zoom: 98%;
            background: initial;
        }
    }
</style>
<!DOCTYPE html>
<html lang="en">

<body>
    <table>
        <thead>
            <tr>
                <td rowspan="4" class="text-center" style="font-size: 10pt; padding-top: 0.5%; padding-bottom: 0.5%">
                    <div>
                        <img src="{{ asset('public/logo/logo_itic.png') }}" width="50">
                    </div>
                    <div style="font-weight: bold">PT Indonesian Tobacco Tbk.</div>
                </td>
                <td colspan="14" rowspan="2" class="text-center" style="font-size: 10pt; font-weight: bold">FORMULIR</td>
                <td style="font-size: 10pt; font-weight: bold">No. Dokumen</td>
                <td style="font-size: 10pt; font-weight: bold">:</td>
                <td style="font-size: 10pt; font-weight: bold">IT/QHSE/FR/01-01</td>
            </tr>
            <tr>
                <td style="font-size: 10pt; font-weight: bold">Revisi</td>
                <td style="font-size: 10pt; font-weight: bold">:</td>
                <td style="font-size: 10pt; font-weight: bold">-</td>
            </tr>
            <tr>
                <td colspan="14" rowspan="2" class="text-center" style="font-size: 10pt; font-weight: bold">IBPRPP (Identifikasi
                    Bahaya,
                    Penilaian Risiko dan
                    Penetapan Pengendalian)</td>
                <td style="font-size: 10pt; font-weight: bold">Halaman</td>
                <td style="font-size: 10pt; font-weight: bold">:</td>
                <td style="font-size: 10pt; font-weight: bold">-</td>
            </tr>
            <tr>
                <td style="font-size: 10pt; font-weight: bold">Tanggal</td>
                <td style="font-size: 10pt; font-weight: bold">:</td>
                <td style="font-size: 10pt; font-weight: bold">28/02/2025</td>
            </tr>
        </thead>
        {{-- <tbody>
            <tr style="border: 0px">
                <td colspan="2">Periode</td>
                <td colspan="15">{{ $ibprpp->ibprpp_periode->periode }}</td>
            </tr>
        </tbody> --}}
    </table>
    <div style="margin-top: 1%; margin-bottom: 1%; font-size: 10pt; font-weight: bold">Periode : {{ $periode->periode }}</div>
    <table>
        <thead>
            <tr>
                <th class="text-capital" style="font-size: 10pt" rowspan="2">No</th>
                <th class="text-capital" style="font-size: 10pt" rowspan="2">Potensi Bahaya</th>
                {{-- <th class="text-capital" style="font-size: 10pt" rowspan="2">Potensi Bahaya</th> --}}
                <th class="text-capital" style="font-size: 10pt" colspan="2" rowspan="2">Risiko Bahaya</th>
                {{-- <th class="text-capital" style="font-size: 10pt" rowspan="2">Risiko Bahaya</th> --}}
                <th class="text-capital" style="font-size: 10pt" colspan="3">Penilaian Risiko</th>
                <th class="text-capital" style="font-size: 10pt" rowspan="2">Nilai Risiko</th>
                <th class="text-capital" style="font-size: 10pt" rowspan="2">Penetapan Pengendalian</th>
                <th class="text-capital" style="font-size: 10pt">Pengendalian</th>
                <th class="text-capital" style="font-size: 10pt; width: 10%" rowspan="2">PIC/<br>Wewenang</th>
                <th class="text-capital" style="font-size: 10pt; width: 10%" rowspan="2">Regulasi Terkait</th>
            </tr>
            <tr>
                <th class="text-capital" style="font-size: 10pt; width: 5%">Jumlah <br> Kejadian <br> Dalam 1 <br> Periode <br>
                    Penilaian</th>
                <th class="text-capital" style="font-size: 10pt; width: 5%">Frekuensi <br> <em>(Probability)</em></th>
                <th class="text-capital" style="font-size: 10pt; width: 5%">Keparahan <br> <em>(Severity)</em></th>
                <th class="text-capital" style="font-size: 10pt; width: 25%">Upaya & Penilaian Pengendalian <br>
                    Berdasarkan
                    Frekuensi Kejadian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ibprpp_category_areas as $ibprpp_category_area)
                <tr>
                    <td style="font-size: 10pt; background-color: #FFF2C2; font-weight: bold" colspan="12">{{ $ibprpp_category_area->category_area }}</td>
                </tr>
                @php
                    $ibprpp_departemen = \App\Models\IBPRPPDepartemen::select('departemen')
                        ->where('id', $departemen_id)
                        ->first();
                @endphp
                <tr>
                    <td style="font-size: 10pt; background-color: #FFF2C2; font-weight: bold" colspan="12">{{ $ibprpp_departemen->departemen }}</td>
                </tr>
                @php
                    $ibprpps = \App\Models\IBPRPP::where('ibprpp_category_area_id', $ibprpp_category_area->id)
                        ->where('ibprpp_departemen_id', $departemen_id)
                        ->where('ibprpp_periode_id', $periode->id)
                        ->get();
                    // dd($ibprpps);
                @endphp
                @foreach ($ibprpps as $key_ibprpp => $ibprpp)
                    @php
                        $no_ibprpp = $key_ibprpp + 1;
                    @endphp
                    <tr>
                        <td style="font-size: 10pt; background-color: #FFF2C2" colspan="12">
                            <table style="border: 0;">
                                <tr>
                                    <td style="border: 0; width: 2%; font-size: 10pt" class="text-center">
                                        {{ $no_ibprpp }}.</td>
                                    <td style="border: 0; text-align: left">
                                        <div style="font-size: 10pt"><b>Aktivitas Pekerjaan :</b>
                                            {{ $ibprpp->aktivitas_pekerja }}</div>
                                        <div style="font-size: 10pt"><b>Jenis Aktivitas :</b>
                                            {{ $ibprpp->jenis_aktivitas }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @foreach (json_decode($ibprpp->body) as $key => $item)
                        @php
                            $totalRowPotensiBahaya = count($item->risiko_bahaya) + 1;
                            $totalRowUpaya = count($item->upaya_pengendalian) + 1;
                        @endphp
                        <tr>
                            <td class="text-center" style="vertical-align: top; font-size: 10pt"
                                rowspan="{{ $totalRowPotensiBahaya }}">
                                {{ $key + 1 }}
                            </td>
                            <td style="vertical-align: top; font-size: 10pt" rowspan="{{ $totalRowPotensiBahaya }}">
                                {{ $item->potensi_bahaya }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <td></td>
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
                                <td class="text-center" style="vertical-align: top; font-size: 10pt; width: 2%">{{ $key_risiko_bahaya + 1 }}</td>
                                <td style="vertical-align: top; font-size: 10pt;">
                                    {{ $risiko_bahaya->risiko_bahaya }}</td>
                                <td style="vertical-align: top; font-size: 10pt;" class="text-center">
                                    {{ $risiko_bahaya->jumlah_kejadian }}</td>
                                <td style="vertical-align: top; font-size: 10pt;" class="text-center">
                                    {{ $risiko_bahaya->frekuensi }}</td>
                                <td style="vertical-align: top; font-size: 10pt;" class="text-center">
                                    {{ $risiko_bahaya->keparahan }}</td>
                                <td style="vertical-align: top; font-size: 10pt; background-color: {{ $bgColor }}"
                                    class="text-center">
                                    {{ $risiko_bahaya->frekuensi * $risiko_bahaya->keparahan }}
                                </td>
                                <td style="vertical-align: top; font-size: 10pt;" class="text-center">
                                    {{ $risiko_bahaya->penetapan_pengendalian }}</td>
                                <td style="vertical-align: top; font-size: 10pt;">
                                    <div style="font-weight: bold">Upaya & Penilaian
                                        Pengendalian Berdasarkan Frekuensi Kejadian :</div>
                                    <ul>
                                        @foreach ($item->upaya_pengendalian as $upaya_pengendalian)
                                            <li>
                                                <div>{!! $upaya_pengendalian->upaya_pengendalian . ' - <b>' . $upaya_pengendalian->penilaian_pengendalian . '</b>' !!}</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td style="vertical-align: top; font-size: 10pt;">{{ $item->pic_wewenang }}
                                </td>
                                <td style="vertical-align: top; font-size: 10pt;">
                                    {{ $item->regulasi_terkait }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
