<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
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

    th,td {
        height: 35px;
    }
</style>
<div style="text-align: center; font-weight: bold; font-size: 14pt">
    <div>DATA KARYAWAN</div>
    <div style="text-decoration: underline">PT Indonesian Tobacco Tbk.</div>
</div>
<h3 style="text-decoration: underline">Data Pribadi</h3>
{{-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents( asset('public/berkas/HRGA/data_karyawan/'.$data_karyawan->foto_karyawan) )) }}"> --}}
<img src="{!! asset('public/berkas/HRGA/data_karyawan/'.$data_karyawan->foto_karyawan) !!}" width="150">
<table style="margin-top: 2.5%">
    <tr>
        <td style="width: 35%">NIK</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->nik }}</td>
    </tr>
    <tr>
        <td style="width: 35%">Nama Karyawan</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->biodata_karyawan->nama }}</td>
    </tr>
    <tr>
        <td style="width: 35%">Tempat, Tanggal Lahir</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->tempat_lahir . ', ' . \Carbon\Carbon::create($data_karyawan->tanggal_lahir)->isoFormat('DD MMMM YYYY') }}
        </td>
    </tr>
    <tr>
        <td style="width: 35%">Jenis Kelamin</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->jenis_kelamin }}</td>
    </tr>
    <tr>
        <td style="width: 35%">Alamat</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>
            <p>{{ $data_karyawan->alamat }}</p>
        </td>
    </tr>
    <tr>
        <td style="width: 35%">Email</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->email }}</td>
    </tr>
    <tr>
        <td style="width: 35%">Status Keluarga</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->status_keluarga }}</td>
    </tr>
    <tr>
        <td style="width: 35%">Golongan Darah</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->golongan_darah }}</td>
    </tr>
    <tr>
        <td style="width: 35%">Pendidikan</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->pendidikan }}</td>
    </tr>
    {{-- <tr>
        <td style="width: 35%">NPWP</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->no_npwp }}</td>
    </tr>
    <tr>
        <td style="width: 35%">BPJS Kesehatan</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->no_bpjs_kesehatan }}</td>
    </tr>
    <tr>
        <td style="width: 35%">BPJS Ketenagakerjaan</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->no_bpjs_ketenagakerjaan }}</td>
    </tr>
    <tr>
        <td style="width: 35%">Rekening Mandiri</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->no_rekening_mandiri }}</td>
    </tr>
    <tr>
        <td style="width: 35%">Rekening Bank Woori Saudara</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->no_rekening_bws }}</td>
    </tr> --}}
</table>

<h3 style="text-decoration: underline">Departemen</h3>
<table>
    <tr>
        <td style="width: 35%">Departemen</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->departemen_dept }}</td>
    </tr>
    <tr>
        <td style="width: 35%">Bagian</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->departemen_bagian }}</td>
    </tr>
    <tr>
        <td style="width: 35%">Level</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $data_karyawan->departemen_level }}</td>
    </tr>
</table>

<h3 style="text-decoration: underline">Masuk Kerja</h3>
<table>
    <tr>
        <td style="width: 35%">Tanggal Masuk</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ \Carbon\Carbon::create($data_karyawan->biodata_karyawan->tanggal_masuk)->isoFormat('DD MMMM YYYY') }}</td>
    </tr>
    <tr>
        <td style="width: 35%">Masa Kerja</td>
        <td style="width: 5%; text-align: center">:</td>
        <td>{{ $masa_kerja }}</td>
    </tr>
</table>

<div style="page-break-before: always">
    <h3 style="text-decoration: underline">Status Kerja</h3>
    <table>
        <tr>
            <th style="width: 33%">PK</th>
            <th style="width: 33%">Ke</th>
            <th style="width: 33%">Tanggal Mulai</th>
        </tr>
        @if ($data_karyawan->status_kerja->isEmpty())
            <tr>
                <td colspan="3" style="text-align: center">Data Belum Tersedia</td>
            </tr>
        @else
            @foreach ($data_karyawan->status_kerja as $status_kerja)
                <tr>
                    <td style="text-align: center">{{ $status_kerja->pk }}</td>
                    <td style="text-align: center">{{ $status_kerja->ke }}</td>
                    <td style="text-align: center">{{ \Carbon\Carbon::create($status_kerja->tgl_mulai)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        @endif
    </table>
</div>

<h3 style="text-decoration: underline">Riwayat Konseling & Lainnya</h3>
<table>
    <tr>
        <th style="width: 10%">No</th>
        <th style="width: 90%">Data Riwayat</th>
    </tr>
    @if ($data_karyawan->riwayat_konseling->isEmpty())
        <tr>
            <td colspan="2" style="text-align: center">Data Belum Tersedia</td>
        </tr>
    @else
        @foreach ($data_karyawan->riwayat_konseling as $key => $riwayat_konseling)
            <tr>
                <td style="text-align: center">{{ $key+1 }}</td>
                <td>{{ $riwayat_konseling->riwayat_konseling }}</td>
            </tr>
        @endforeach
    @endif
</table>

<h3 style="text-decoration: underline">Riwayat Training</h3>
<table>
    <tr>
        <th style="width: 10%">No</th>
        <th style="width: 90%">Data Riwayat Training</th>
    </tr>
    @if ($data_karyawan->riwayat_training->isEmpty())
        <tr>
            <td colspan="2" style="text-align: center">Data Belum Tersedia</td>
        </tr>
    @else
        @foreach ($data_karyawan->riwayat_training as $key => $riwayat_training)
            <tr>
                <td style="text-align: center">{{ $key+1 }}</td>
                <td>{{ $riwayat_training->riwayat_training }}</td>
            </tr>
        @endforeach
    @endif
</table>