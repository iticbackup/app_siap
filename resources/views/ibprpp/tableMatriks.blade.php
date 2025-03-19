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
<head>
    <title>Tabel Matriks Risiko</title>
</head>
<h2 style="text-align: center; text-decoration: underline">Matriks Risiko</h2>
<div style="margin-bottom: 1%">
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
<div style="margin-bottom: 1%">
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
<div style="margin-bottom: 1%">
    <div style="font-weight: bold">Table 1.3</div>
    <div>Matriks Risiko - AS/NZS 4360 Standard</div>
    <table class="table table-bordered dt-responsive nowrap"
        style="border-collapse: collapse; border-spacing: 0; width: 50%;">
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
    <ul>
        <li><b>E (Extreme)</b> : Perlu tinjauan manajemen terhadap bahaya dan risikonya</li>
        <li><b>H (High)</b> : Pembatasan area/ perencanaan sistem manajemen keselamatan</li>
        <li><b>M (Moderate)</b> : Membuat modifikasi kecil terhadap lokasi/ proses</li>
        <li><b>L (Low)</b> : Membuat aturan/ prosedur/ rambu/ petunjuk K3</li>
    </ul>
</div>
<div>
    <div style="font-weight: bold">Table 1.4</div>
    <div>Upaya Pengendalian</div>
    <table class="table table-bordered dt-responsive nowrap"
        style="border-collapse: collapse; border-spacing: 0; width: 60%;">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%">Tingkat</th>
                <th class="text-center" style="width: 10%">Jenis</th>
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