<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    .mb-3 {
        margin-bottom: 1%;
    }

    .text-center{
        text-align: center;
    }

    label {
        font-weight: bold;
    }

    .table td, th {
        border: 1px solid;
        vertical-align: middle;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
</style>
<title>List Sertifikasi Mesin Produksi</title>
<h1 style="font-size: 14pt; text-align: center">List Sertifikasi Mesin Produksi</h1>
@foreach ($mesin_produksis as $key => $mesin_produksi)
<div style="page-break-after: always">
    <table style="margin-bottom: 2%;">
        <tr>
            <td>
                <label>Nama Sertifikat</label>
            </td>
            <td>
                <div>:</div>
            </td>
            <td>
                <div>{{ $mesin_produksi->jenis_mesin }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <label>No. Sertifikat</label>
            </td>
            <td>
                <div>:</div>
            </td>
            <td>
                <div>{{ $mesin_produksi->no_sertifikat }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <label>Tanggal Sertifikat Pertama</label>
            </td>
            <td>
                <div>:</div>
            </td>
            <td>
                <div>{{ \Carbon\Carbon::create($mesin_produksi->tgl_sertifikat_pertama)->isoFormat('DD MMMM YYYY') }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <label>Periode Resertifikasi</label>
            </td>
            <td>
                <div>:</div>
            </td>
            <td>
                <div>{{ $mesin_produksi->periode_resertifikasi }} Tahun</div>
            </td>
        </tr>
    </table>
    <hr>
    @if (!$mesin_produksi->sertifikasi_mesin_produksi_list->isEmpty())
        <div class="mb-3" style="font-weight: bold">Riwayat Sertifikasi</div>
        <table class="table" style="margin-bottom: 2%">
            <thead>
                <tr>
                    <th class="text-center">
                        <div>Tgl. Pemeriksa Uji</div>
                    </th>
                    <th class="text-center">
                        <div>Tgl. Terbit Sertifikat</div>
                    </th>
                    <th class="text-center">
                        <div>No. SuKet Terakhir</div>
                    </th>
                    <th class="text-center">
                        <div>Tgl. Resertifikasi Selanjutnya</div>
                    </th>
                    <th class="text-center">
                        <div>Keterangan</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mesin_produksi->sertifikasi_mesin_produksi_list as $sertifikasi_mesin_produksi_list)
                    <tr>
                        <td class="text-center">
                            <div>{{ \Carbon\Carbon::create($sertifikasi_mesin_produksi_list->tgl_periksa_uji)->isoFormat('DD MMMM YYYY') }}</div>
                        </td>
                        <td class="text-center">
                            <div>{{ \Carbon\Carbon::create($sertifikasi_mesin_produksi_list->tgl_terbit_sertifikat)->isoFormat('DD MMMM YYYY') }}</div>
                        </td>
                        <td class="text-center">
                            <div>{{ $sertifikasi_mesin_produksi_list->no_sertifikat_terakhir }}</div>
                        </td>
                        <td class="text-center">
                            <div>{{ \Carbon\Carbon::create($sertifikasi_mesin_produksi_list->tgl_resertifikat_selanjutnya)->isoFormat('DD MMMM YYYY') }}</div>
                        </td>
                        <td class="text-center">
                            <div>{{ $sertifikasi_mesin_produksi_list->keterangan }}</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endforeach
