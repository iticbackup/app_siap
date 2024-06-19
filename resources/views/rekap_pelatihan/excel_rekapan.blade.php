<table>
    <thead>
        <tr>
            <td colspan="12" style="text-align: center; font-weight: bold; height: 50px; vertical-align: middle">Rekap Seminar dan Pelatihan PT Indonesian Tobacco Tbk. <br> Periode Tahun {{ $periode }}</td>
        </tr>
        <tr>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; text-align: center">No</th>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; text-align: center">Tanggal</th>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; text-align: center">Tema Pelatihan / Seminar</th>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; text-align: center">Penyelenggara</th>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; text-align: center">Jenis</th>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; width: 100px; text-align: center">Jumlah Hari Pelatihan</th>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; width: 100px; text-align: center">Jumlah Jam Pelatihan Dalam 1 Hari</th>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; width: 100px; text-align: center">Jumlah Hari Pelatihan * Jam</th>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; text-align: center">Total Peserta</th>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; text-align: center">Peserta</th>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; width: 100px; text-align: center">Total Peserta * Jam</th>
            <th style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; text-align: center">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rekap_pelatihans as $key => $rekap_pelatihan)
        @php

            $explode_tanggal = explode(',',$rekap_pelatihan->tanggal);
            
            if ($rekap_pelatihan->check_date == 'yes') {
                $tanggal = \Carbon\Carbon::create($explode_tanggal[0])->format('d').','.\Carbon\Carbon::create($explode_tanggal[1])->isoFormat('LL');
            }else{
                if (\Carbon\Carbon::create($explode_tanggal[0])->format('Y-m-d') == \Carbon\Carbon::create($explode_tanggal[1])->format('Y-m-d')) {
                    $tanggal = \Carbon\Carbon::create($explode_tanggal[1])->isoFormat('LL');
                }else{
                    $tanggal = \Carbon\Carbon::create($explode_tanggal[0])->format('d').' - '.\Carbon\Carbon::create($explode_tanggal[1])->isoFormat('LL');
                }
            }

            $hitung_jml_hari_kali_jam = $rekap_pelatihan->jml_hari*$rekap_pelatihan->jml_jam_dlm_hari;

            $rekap_pelatihan_pesertas = \App\Models\RekapPelatihanSeminarPeserta::where('rekap_pelatihan_seminar_id',$rekap_pelatihan->id)->get();
            // dd($rekap_pelatihan_pesertas);
            $hitung_total_peserta_kali_jam = $hitung_jml_hari_kali_jam*$rekap_pelatihan->total_peserta;
        @endphp
            <tr>
                <td style="vertical-align: top; border: 1px solid black; text-align: center">{{ $key+1 }}</td>
                <td style="vertical-align: top; border: 1px solid black; text-align: center">{{ $tanggal }}</td>
                <td style="vertical-align: top; border: 1px solid black;">{{ $rekap_pelatihan->tema }}</td>
                <td style="vertical-align: top; border: 1px solid black; text-align: center">{{ $rekap_pelatihan->penyelenggara }}</td>
                <td style="vertical-align: top; border: 1px solid black; text-align: center">{{ $rekap_pelatihan->jenis }}</td>
                <td style="vertical-align: top; border: 1px solid black; text-align: center">{{ $rekap_pelatihan->jml_hari }}</td>
                <td style="vertical-align: top; border: 1px solid black; text-align: center">{{ $rekap_pelatihan->jml_jam_dlm_hari }}</td>
                <td style="vertical-align: top; border: 1px solid black; text-align: center">{{ $hitung_jml_hari_kali_jam }}</td>
                <td style="vertical-align: top; border: 1px solid black; text-align: center">{{ $rekap_pelatihan->total_peserta }}</td>
                <td style="vertical-align: top; border: 1px solid black;">
                    {{-- <ul>
                    </ul> --}}
                    @foreach ($rekap_pelatihan_pesertas as $rekap_pelatihan_peserta)
                        <div>- {{ $rekap_pelatihan_peserta->peserta }} - {{ $rekap_pelatihan_peserta->departemen->departemen }}</div><br>
                    @endforeach
                </td>
                <td style="vertical-align: top; border: 1px solid black; text-align: center">{{ $hitung_total_peserta_kali_jam }}</td>
                <td style="vertical-align: top; border: 1px solid black;">{{ $rekap_pelatihan->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>