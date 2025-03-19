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

    .text-center{
        text-align: center
    }

    .text-capital{
        text-transform: uppercase
    }
</style>
<table>
    <thead>
        <tr>
            <td rowspan="4" class="text-center">PT Indonesian Tobacco Tbk.</td>
            <td colspan="13" rowspan="2" class="text-center">FORMULIR</td>
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
            <td colspan="13" rowspan="2" class="text-center">IBPRPP (Identifikasi Bahaya, Penilaian Risiko dan Penetapan Pengendalian)</td>
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
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Jenis Aktivitas <br> (Rutin/Non Rutin/Darurat)</th>
            <th class="text-capital" style="font-size: 8pt" colspan="2" rowspan="2">Potensi Bahaya</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Risiko Bahaya</th>
            <th class="text-capital" style="font-size: 8pt" colspan="3">Penilaian Risiko</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Nilai Risiko</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Penetapan Pengendalian</th>
            <th class="text-capital" style="font-size: 8pt" colspan="2">Pengendalian</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">PIC/<br>Wewenang</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Regulasi Terkait</th>
        </tr>
        <tr>
            <th class="text-capital" style="font-size: 8pt">Jumlah <br> Kejadian <br> Dalam 1 <br> Periode <br> Penilaian</th>
            <th class="text-capital" style="font-size: 8pt">Frekuensi <br> <em>(Probability)</em></th>
            <th class="text-capital" style="font-size: 8pt">Keparahan <br> <em>(Severity)</em></th>
            <th class="text-capital" style="font-size: 8pt">Upaya</th>
            <th class="text-capital" style="font-size: 8pt">Penilaian <br> Pengendalian <br> Berdasarkan <br> Frekuensi <br> Kejadian</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ibprpp_category_areas as $ibprpp_category_area)
            <tr>
                <td style="font-size: 10pt" colspan="13">{{ $ibprpp_category_area->category_area }}</td>
            </tr>
            @php
                $ibprpp_departemen = \App\Models\IBPRPPDepartemen::select('departemen')->where('id',$departemen_id)->first();
            @endphp
            <tr>
                <td style="font-size: 10pt" colspan="13">{{ $ibprpp_departemen->departemen }}</td>
            </tr>
            @php
                $ibprpps = \App\Models\IBPRPP::where('ibprpp_departemen_id',$departemen_id)
                                            ->where('ibprpp_periode_id',$periode->id)
                                            ->get();
            @endphp
            @foreach ($ibprpps as $key => $ibprpp)
                @php
                    $rowspan_potensi_bahaya = [];
                @endphp
                @foreach (json_decode($ibprpp->penilaian_risiko_pengendalian) as $key_item => $item)
                @php
                    $rowspan_potensi_bahaya = $key_item+1;
                @endphp
                @endforeach
                <tr>
                    <td style="font-size: 10pt" rowspan="{{ $rowspan_potensi_bahaya+1 }}">{{ $key+1 }}</td>
                    <td style="font-size: 10pt" rowspan="{{ $rowspan_potensi_bahaya+1 }}">{{ $ibprpp->aktivitas_pekerja }}</td>
                    <td style="font-size: 10pt" rowspan="{{ $rowspan_potensi_bahaya+1 }}">{{ $ibprpp->jenis_aktivitas }}</td>
                </tr>
                @foreach (json_decode($ibprpp->penilaian_risiko_pengendalian) as $key_item => $item)
                <tr>
                    <td style="font-size: 10pt">{{ $key_item+1 }}</td>
                    <td style="font-size: 10pt">{{ $item->potensi_bahaya }}</td>
                    <td style="font-size: 10pt">{{ $item->risiko_bahaya }}</td>
                </tr>
                @endforeach
            @endforeach
            {{-- @php
                $ibprpp = \App\Models\IBPRPP::where('ibprpp_departemen_id',$departemen_id)
                                            ->where('ibprpp_periode_id',$periode->id)
                                            ->get();
            @endphp
            <tr>
                <td colspan="14">{{ $ibprpp->ibprpp_departemen->departemen }}</td>
            </tr> --}}
        @endforeach
    </tbody>
</table>