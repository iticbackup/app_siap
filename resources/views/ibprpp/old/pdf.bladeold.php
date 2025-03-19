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
            <td colspan="14" rowspan="2" class="text-center">IBPRPP (Identifikasi Bahaya, Penilaian Risiko dan Penetapan Pengendalian)</td>
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
            <th class="text-capital" style="font-size: 8pt" colspan="2" rowspan="2">Risiko Bahaya</th>
            <th class="text-capital" style="font-size: 8pt" colspan="3">Penilaian Risiko</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Nilai Risiko</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Penetapan Pengendalian</th>
            <th class="text-capital" style="font-size: 8pt" colspan="3">Pengendalian</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">PIC/<br>Wewenang</th>
            <th class="text-capital" style="font-size: 8pt" rowspan="2">Regulasi Terkait</th>
        </tr>
        <tr>
            <th class="text-capital" style="font-size: 8pt">Jumlah <br> Kejadian <br> Dalam 1 <br> Periode <br> Penilaian</th>
            <th class="text-capital" style="font-size: 8pt">Frekuensi <br> <em>(Probability)</em></th>
            <th class="text-capital" style="font-size: 8pt">Keparahan <br> <em>(Severity)</em></th>
            <th class="text-capital" style="font-size: 8pt" colspan="2">Upaya</th>
            <th class="text-capital" style="font-size: 8pt">Penilaian <br> Pengendalian <br> Berdasarkan <br> Frekuensi <br> Kejadian</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="font-size: 10pt; vertical-align: top" rowspan="5">1</td>
            <td style="font-size: 10pt; vertical-align: top" rowspan="5">Aktivitas office harian</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top" rowspan="5">Rutin</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top" rowspan="4">1</td>
            <td style="font-size: 10pt; vertical-align: top" rowspan="4">Paparan radiasi cahaya komputer</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top" rowspan="4">1</td>
            <td style="font-size: 10pt; vertical-align: top" rowspan="4">Iritasi mata dan gangguan penglihatan</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top" rowspan="4">1</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top" rowspan="4">1</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top" rowspan="4">1</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top" rowspan="4">1</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top" rowspan="4">1</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top">1</td>
            <td style="font-size: 10pt; vertical-align: top">Melakukan relaksasi mata dengan melihat atas,kanan dan kiri</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top">Efektif</td>
            <td style="font-size: 10pt; vertical-align: top" rowspan="4">K3 Officer/ PIC Departemen Finance & Accounting (F&A)</td>
            <td style="font-size: 10pt; vertical-align: top" rowspan="4">
                - Permenaker No. 03/MEN/1982 tentang Pelayanan Kesehatan Kerja <br>
                - Permenaker No. 02/MEN/1980 tentang Pemeriksaan Kesehatan Tenaga Kerja Dalam Penyelenggaraan Keselamatan Kerja
            </td>
        </tr>
        <tr>
            <td class="text-center" style="font-size: 10pt; vertical-align: top">2</td>
            <td style="font-size: 10pt; vertical-align: top">Mengatur jarak layar komputer dengan pandangan mata</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top">Efektif</td>
        </tr>
        <tr>
            <td class="text-center" style="font-size: 10pt; vertical-align: top">3</td>
            <td style="font-size: 10pt; vertical-align: top">Mengatur jarak layar komputer dengan pandangan mata</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top">Efektif</td>
        </tr>
        <tr>
            <td class="text-center" style="font-size: 10pt; vertical-align: top">4</td>
            <td style="font-size: 10pt; vertical-align: top">Mengatur jarak layar komputer dengan pandangan mata</td>
            <td class="text-center" style="font-size: 10pt; vertical-align: top">Efektif</td>
        </tr>
        <tr>
            <td style="font-size: 10pt">2</td>
            <td style="font-size: 10pt">Ergonomi terganggu</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">Timbulnya penyakit akibat kerja yang berhubungan dengan faktor ergonomi tubuh</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">Melakukan relaksasi atau peregangan tubuh</td>
            <td style="font-size: 10pt">Efektif</td>
            <td style="font-size: 10pt">K3 Officer/ PIC Departemen Finance & Accounting (F&A)</td>
            <td style="font-size: 10pt">
                - Permenaker No. 03/MEN/1982 tentang Pelayanan Kesehatan Kerja <br>
                - Permenaker No. 02/MEN/1980 tentang Pemeriksaan Kesehatan Tenaga Kerja Dalam Penyelenggaraan Keselamatan Kerja
            </td>
        </tr>
        {{-- <tr>
            <td style="font-size: 10pt">2</td>
            <td style="font-size: 10pt">Ergonomi terganggu</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">Timbulnya penyakit akibat kerja yang berhubungan dengan faktor ergonomi tubuh</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">1</td>
            <td style="font-size: 10pt">1</td>
        </tr> --}}
    </tbody>
    {{-- <tbody>
        <tr>
            <td style="font-size: 10pt" colspan="15">Area Office</td>
        </tr>
        <tr>
            <td style="font-size: 10pt" colspan="15">Finance & Accounting (FA)</td>
        </tr>
        <tr>
            <td style="font-size: 10pt" rowspan="4">1</td>
            <td style="font-size: 10pt" rowspan="4">Aktivitas office harian</td>
            <td style="font-size: 10pt" rowspan="4">Rutin</td>
            <td style="font-size: 10pt" rowspan="4">1</td>
            <td style="font-size: 10pt" rowspan="4">Paparan radiasi cahaya komputer</td>
            <td style="font-size: 10pt" rowspan="4">1</td>
            <td style="font-size: 10pt" rowspan="4">Iritasi mata dan gangguan penglihatan</td>
            <td rowspan="4">0</td>
            <td rowspan="4">1</td>
            <td rowspan="4">1</td>
            <td rowspan="4">1</td>
            <td rowspan="4">4</td>
        </tr>
        <tr>
            <td>1</td>
            <td>1</td>
        </tr>
    </tbody> --}}
</table>