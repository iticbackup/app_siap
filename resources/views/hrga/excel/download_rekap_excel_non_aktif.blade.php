<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
    }
    table,
    td,
    th {
        /* border: 1px solid black; */
        text-align: left;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 15px;
    }
</style>
<body>
    <h3 style="text-transform: uppercase">DATABASE KARYAWAN</h3>
    <h5 style="font-weight: bold">PT Indonesian Tobacco Tbk.</h5>
    {{-- <br> --}}
    <h5 style="font-weight: bold">Per Tanggal: {{ \Carbon\Carbon::create($tanggal)->isoFormat('LL') }}</h5>
    {{-- <br> --}}
    {{-- <div></div> --}}
    <table>
        <thead>
            {{-- <tr>
                <td colspan="5" style="border-color: #fff">
                    <h3 style="text-transform: uppercase">Database Karyawan</h3>
                    <span style="font-weight: bold">PT Indonesian Tobacco Tbk.</span>
                    <div></div>
                    <span>Per Tanggal: {{ $tanggal }}</span>
                    <div></div>
                </td>
            </tr> --}}
            {{-- <tr>
                <th colspan="3" style="text-transform: uppercase">Database Karyawan</th>
            </tr>
            <tr>
                <th colspan="3" style="font-weight: bold">PT Indonesian Tobacco Tbk.</th>
            </tr>
            <tr>
                <th colspan="3">Per Tanggal: {{ $tanggal }}</th>
            </tr> --}}
            <tr>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; width: 50px; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">NO</th>
                {{-- <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; width: 50px; height: 50px; word-wrap: break-word; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7; color: red">NO. URUT LEVEL</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; width: 50px; height: 50px; word-wrap: break-word; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7; color: #002060">NO. URUT DEPT</th> --}}
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">NIK</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">NAMA</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">NOMOR TELEPON</th>
                <th colspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">NKK. BPJS</th>
                <th colspan="3" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">PAYROLL</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">NPWP</th>
                <th colspan="3" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">DEPARTEMEN</th>
                <th colspan="3" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">STATUS KERJA</th>
                <th colspan="4" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">MASUK KERJA</th>
                <th colspan="3" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">MASA KERJA</th>
                <th colspan="3" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">TEMPAT/TGL LAHIR</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">UMUR</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">L/P</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">STATUS KLG</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">GOL. DARAH</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">PEND.</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">SIM KNDR</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">E-MAIL</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">ALAMAT</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">RIWAYAT TRAINING</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">RIWAYAT KONSELING</th>
                <th rowspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">KUNCI LOKER</th>
            </tr>
            <tr>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; word-wrap: break-word; width: 120px; font-weight: bold; background-color: #e6b8b7">KETENAGAKERJAAN</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; word-wrap: break-word; width: 120px; font-weight: bold; background-color: #e6b8b7">KESEHATAN</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; word-wrap: break-word; width: 120px; font-weight: bold; background-color: #e6b8b7">NO. REKENING BANK MANDIRI</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; word-wrap: break-word; width: 120px; font-weight: bold; background-color: #e6b8b7">NO. REKENING BANK WOORI</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; word-wrap: break-word; width: 120px; font-weight: bold; background-color: #e6b8b7">NO. REKENING BANK BCA</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">DEPT.</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">BAGIAN</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">LEVEL</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">PK</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">KE</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">TGL. MULAI</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">TGL</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">BLN</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">TH</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">TANGGAL MASUK</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">TAHUN</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">BULAN</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">HARI</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">TEMPAT</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">TGL./ BLN</th>
                <th style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">TH</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($hrga_biodata_karyawans as $key => $hrga_biodata_karyawan)
                <tr>
                    <td>{{ $key+1 }}</td>
                </tr>
            @endforeach --}}
            @php
                $no = 1;
                $start_year = \Carbon\Carbon::create($tanggal)->startOfYear()->format('Y-m');
                $end_year = \Carbon\Carbon::create($tanggal)->endOfYear()->format('Y-m');
            @endphp

            @for ($i = $start_year; $i <= $end_year; $i++)
            @php
                // $karyawan_resign = \App\Models\HrgaKaryawanResign::whereYear('tanggal_resign','2023')
                //                                                 ->whereMonth('tanggal_resign','11')
                //                                                 ->first();
                $karyawan_resign = \App\Models\HrgaKaryawanResign::whereYear('tanggal_resign',\Carbon\Carbon::create($i)->format('Y'))
                                                                ->whereMonth('tanggal_resign',\Carbon\Carbon::create($i)->format('m'))
                                                                ->get();
                // dd($karyawan_resign);
                // if (!empty($karyawan_resign)) {
                //     $no_urut_level = $karyawan_resign->hrga_biodata_karyawan->no_urut_level;
                // }else{
                //     $no_urut_level = null;
                // }
            @endphp
                <tr>
                    <td colspan="5" style="text-transform: uppercase; background-color: #8ECDDD; font-weight: bold; border: 1px solid black;">{{ \Carbon\Carbon::create($i)->isoFormat('MMMM YYYY') }}</td>
                </tr>
                @foreach ($karyawan_resign as $kr)
                @php
                    $status_kerja = \App\Models\HrgaStatusKerja::select('pk','ke','tgl_mulai')->where('hrga_biodata_karyawan_id',$kr->id)->orderBy('id','desc')->first();
                    if (empty($status_kerja)) {
                        $data_status_kerja_pk = '-';
                        $data_status_kerja_ke = '-';
                        $data_status_kerja_tgl_mulai = '-';
                    }else{
                        $data_status_kerja_pk = $status_kerja->pk;
                        $data_status_kerja_ke = $status_kerja->ke;
                        $data_status_kerja_tgl_mulai = \Carbon\Carbon::create($status_kerja->tgl_mulai)->format('d/m/Y');
                    }

                    if (empty($kr->hrga_biodata_karyawan->no_bpjs_ketenagakerjaan)) {
                        $bpjs_ketenagakerjaan = "-";
                    }else{
                        // $bpjs_ketenagakerjaan = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_bpjs_ketenagakerjaan);
                        $bpjs_ketenagakerjaan = $kr->hrga_biodata_karyawan->no_bpjs_ketenagakerjaan;
                    }

                    if (empty($kr->hrga_biodata_karyawan->no_bpjs_kesehatan)) {
                        $bpjs_kesehatan = "-";
                    }else{
                        // $bpjs_kesehatan = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_bpjs_kesehatan);
                        $bpjs_kesehatan = $kr->hrga_biodata_karyawan->no_bpjs_kesehatan;
                    }

                    if (empty($kr->hrga_biodata_karyawan->no_rekening_mandiri)) {
                        $mandiri = "-";
                    }else{
                        // $mandiri = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_rekening_mandiri);
                        $mandiri = $kr->hrga_biodata_karyawan->no_rekening_mandiri;
                    }

                    if (empty($kr->hrga_biodata_karyawan->no_rekening_bws)) {
                        $bws = "-";
                    }else{
                        // $bws = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_rekening_bws);
                        $bws = $kr->hrga_biodata_karyawan->no_rekening_bws;
                    }

                    if (empty($kr->hrga_biodata_karyawan->no_rekening_bca)) {
                        $bca = "-";
                    }else{
                        // $bws = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_rekening_bws);
                        $bca = $kr->hrga_biodata_karyawan->no_rekening_bca;
                    }
                @endphp
                <tr>
                    <td style="text-align: center; font-weight: bold; border: 1px solid black; vertical-align: top;">{{ $no }}</td>
                    {{-- <td style="text-align: center; font-weight: bold; border: 1px solid black; vertical-align: top; color:red">{{ $kr->hrga_biodata_karyawan->no_urut_level }}</td>
                    <td style="text-align: center; font-weight: bold; border: 1px solid black; vertical-align: top; color:#002060">{{ $kr->hrga_biodata_karyawan->no_urut_departemen }}</td> --}}
                    <td style="text-align: center; font-weight: bold; border: 1px solid black; vertical-align: top; {{ $data_status_kerja_pk == 'Kontrak' ? 'color:red; font-weight: bold;' : null }}">{{ $kr->hrga_biodata_karyawan->nik }}</td>
                    <td style="text-align: left; font-weight: bold; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->biodata_karyawan->nama }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->no_telepon }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $bpjs_ketenagakerjaan }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $bpjs_kesehatan }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $mandiri }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $bws }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $bca }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->no_npwp }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->departemen_dept }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->departemen_bagian }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->departemen_level }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top; {{ $data_status_kerja_pk == 'Kontrak' ? 'color:red; font-weight: bold;' : null }}">{{ $data_status_kerja_pk }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $data_status_kerja_ke }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $data_status_kerja_tgl_mulai }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($kr->hrga_biodata_karyawan->biodata_karyawan->tanggal_masuk)->format('d') }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($kr->hrga_biodata_karyawan->biodata_karyawan->tanggal_masuk)->format('m') }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($kr->hrga_biodata_karyawan->biodata_karyawan->tanggal_masuk)->format('Y') }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($kr->hrga_biodata_karyawan->biodata_karyawan->tanggal_masuk)->format('d/m/Y') }}</td>
                    @php
                        $awal = new DateTime($kr->hrga_biodata_karyawan->biodata_karyawan->tanggal_masuk);
                        $akhir = new DateTime();
                        $diff = $awal->diff($akhir);
                        $masa_kerja_tahun = $diff->y;
                        $masa_kerja_bulan = $diff->m;
                        $masa_kerja_hari = $diff->d;
                    @endphp
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $masa_kerja_tahun }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $masa_kerja_bulan }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $masa_kerja_hari }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->tempat_lahir }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($kr->hrga_biodata_karyawan->tanggal_lahir)->format('d-M') }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($kr->hrga_biodata_karyawan->tanggal_lahir)->format('Y') }}</td>
                    @php
                        $now = \Carbon\Carbon::now();
                        $b_day = \Carbon\Carbon::create($kr->hrga_biodata_karyawan->tanggal_lahir);
                        $age = $b_day->diffInYears($now);
                    @endphp
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $age }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->jenis_kelamin == 'Laki - Laki' ? 'L' : 'P' }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->status_keluarga }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->golongan_darah }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->pendidikan }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->sim_kendaraan }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->email }}</td>
                    <td style="text-align: left; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->alamat }}</td>
                    <td style="text-align: left; border: 1px solid black; vertical-align: top">
                        <ul>
                            @foreach ($kr->hrga_biodata_karyawan->riwayat_training as $rt)
                            <li>- {{ $rt->riwayat_training }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="text-align: left; border: 1px solid black; vertical-align: top">
                        <ul>
                            @foreach ($kr->hrga_biodata_karyawan->riwayat_konseling as $rw)
                            <li>- {{ $rw->riwayat_konseling }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $kr->hrga_biodata_karyawan->kunci_loker }}</td>
                </tr>
                @php
                    $no++;
                @endphp
                @endforeach
                {{-- @if (!empty($karyawan_resign))

                @php
                    $status_kerja = \App\Models\HrgaStatusKerja::select('pk','ke','tgl_mulai')->where('hrga_biodata_karyawan_id',$karyawan_resign->id)->orderBy('id','desc')->first();
                    // dd($status_kerja);
                    if (empty($status_kerja)) {
                        $data_status_kerja_pk = '-';
                        $data_status_kerja_ke = '-';
                        $data_status_kerja_tgl_mulai = '-';
                    }else{
                        $data_status_kerja_pk = $status_kerja->pk;
                        $data_status_kerja_ke = $status_kerja->ke;
                        $data_status_kerja_tgl_mulai = \Carbon\Carbon::create($status_kerja->tgl_mulai)->format('d/m/Y');
                    }

                    if (empty($karyawan_resign->hrga_biodata_karyawan->no_bpjs_ketenagakerjaan)) {
                        $bpjs_ketenagakerjaan = "-";
                    }else{
                        // $bpjs_ketenagakerjaan = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_bpjs_ketenagakerjaan);
                        $bpjs_ketenagakerjaan = $karyawan_resign->hrga_biodata_karyawan->no_bpjs_ketenagakerjaan;
                    }

                    if (empty($karyawan_resign->hrga_biodata_karyawan->no_bpjs_kesehatan)) {
                        $bpjs_kesehatan = "-";
                    }else{
                        // $bpjs_kesehatan = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_bpjs_kesehatan);
                        $bpjs_kesehatan = $karyawan_resign->hrga_biodata_karyawan->no_bpjs_kesehatan;
                    }

                    if (empty($karyawan_resign->hrga_biodata_karyawan->no_rekening_mandiri)) {
                        $mandiri = "-";
                    }else{
                        // $mandiri = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_rekening_mandiri);
                        $mandiri = $karyawan_resign->hrga_biodata_karyawan->no_rekening_mandiri;
                    }

                    if (empty($karyawan_resign->hrga_biodata_karyawan->no_rekening_bws)) {
                        $bws = "-";
                    }else{
                        // $bws = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_rekening_bws);
                        $bws = $karyawan_resign->hrga_biodata_karyawan->no_rekening_bws;
                    }
                @endphp
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->no_urut_level }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->no_urut_departemen }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->nik }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->biodata_karyawan->nama }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->no_telepon }}</td>
                    <td>{{ $bpjs_ketenagakerjaan }}</td>
                    <td>{{ $bpjs_kesehatan }}</td>
                    <td>{{ $mandiri }}</td>
                    <td>{{ $bws }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->no_npwp }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->departemen_dept }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->departemen_bagian }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->departemen_level }}</td>
                    <td>{{ $data_status_kerja_pk }}</td>
                    <td>{{ $data_status_kerja_ke }}</td>
                    <td>{{ $data_status_kerja_tgl_mulai }}</td>
                    <td>{{ \Carbon\Carbon::create($karyawan_resign->hrga_biodata_karyawan->log_posisi->tanggal)->format('d') }}</td>
                    <td>{{ \Carbon\Carbon::create($karyawan_resign->hrga_biodata_karyawan->log_posisi->tanggal)->format('m') }}</td>
                    <td>{{ \Carbon\Carbon::create($karyawan_resign->hrga_biodata_karyawan->log_posisi->tanggal)->format('Y') }}</td>
                    <td>{{ \Carbon\Carbon::create($karyawan_resign->hrga_biodata_karyawan->log_posisi->tanggal)->format('d/m/Y') }}</td>
                    @php
                        $awal = new DateTime($karyawan_resign->hrga_biodata_karyawan->log_posisi->tanggal);
                        $akhir = new DateTime();
                        $diff = $awal->diff($akhir);
                        $masa_kerja_tahun = $diff->y;
                        $masa_kerja_bulan = $diff->m;
                        $masa_kerja_hari = $diff->d;
                    @endphp
                    <td>{{ $masa_kerja_tahun }}</td>
                    <td>{{ $masa_kerja_bulan }}</td>
                    <td>{{ $masa_kerja_hari }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->tempat_lahir }}</td>
                    <td>{{ \Carbon\Carbon::create($karyawan_resign->hrga_biodata_karyawan->tanggal_lahir)->format('d-M') }}</td>
                    <td>{{ \Carbon\Carbon::create($karyawan_resign->hrga_biodata_karyawan->tanggal_lahir)->format('Y') }}</td>
                    @php
                        $now = \Carbon\Carbon::now();
                        $b_day = \Carbon\Carbon::create($karyawan_resign->hrga_biodata_karyawan->tanggal_lahir);
                        $age = $b_day->diffInYears($now);
                    @endphp
                    <td>{{ $age }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->jenis_kelamin == 'Laki - Laki' ? 'L' : 'P' }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->status_keluarga }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->golongan_darah }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->pendidikan }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->email }}</td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->alamat }}</td>
                    <td>
                        <ul>
                            @foreach ($karyawan_resign->hrga_biodata_karyawan->riwayat_training as $rt)
                            <li>{{ $rt->riwayat_training }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                            @foreach ($karyawan_resign->hrga_biodata_karyawan->riwayat_konseling as $rw)
                            <li>{{ $rw->riwayat_konseling }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $karyawan_resign->hrga_biodata_karyawan->kunci_loker }}</td>
                </tr>

                @endif --}}

            @endfor
        </tbody>
    </table>
</body>