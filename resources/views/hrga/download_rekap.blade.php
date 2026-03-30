<style>
    *{
        font-family: Arial, Helvetica, sans-serif;
    }
    table,
    td,
    th {
        border: 1px solid;
        padding: 10px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }
</style>
<table>
    <thead>
        <tr>
            <th style="width: 5%">No</th>
            <th style="width: 10%">NIK</th>
            <th style="width: 20%">Nama Karyawan</th>
            <th style="width: 20%">Departemen</th>
            <th style="width: 20%">Bagian</th>
            <th style="width: 25%">Foto</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($biodata_karyawans as $key => $biodata_karyawan)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $biodata_karyawan->nik }}</td>
                <td>{{ empty($biodata_karyawan->biodata_karyawan->nama) ? '-' : $biodata_karyawan->biodata_karyawan->nama }}</td>
                <td>{{ $biodata_karyawan->departemen_dept }}</td>
                <td>{{ $biodata_karyawan->departemen_bagian }}</td>
                <td style="text-align: center">
                    <img src="{{ asset('public/berkas/HRGA/data_karyawan/'.$biodata_karyawan->foto_karyawan) }}" 
                    style="
                    object-fit: none;
                    width: 25%;
                    height: 10%;
                    " alt="" srcset="">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
