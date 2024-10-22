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
                <th colspan="2" style="text-transform: uppercase; text-align: center; border: 1px solid black; vertical-align: middle; height: 50px; text-transform: uppercase; font-weight: bold; background-color: #e6b8b7">PAYROLL</th>
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
            @endphp
            @foreach ($departemens as $departemen)
            @php
                                                                        // dd($hrga_biodata_karyawans)
                $group_jabatan = \App\Models\HrgaBiodataKaryawan::select('departemen_level')->where('departemen_dept',$departemen->departemen_dept)->groupBy('departemen_level')->get();
                
            @endphp
                <tr>
                    <td colspan="5" style="text-transform: uppercase; background-color: #8ECDDD; font-weight: bold; border: 1px solid black;">{{ $departemen->departemen_dept }}</td>
                </tr>
                @foreach ($group_jabatan as $gj)
                @php
                    $hrga_biodata_karyawans = \App\Models\HrgaBiodataKaryawan::select([
                                                                            'hrga_biodata_karyawan.id as id',
                                                                            'hrga_biodata_karyawan.nik as nik',
                                                                            'hrga_biodata_karyawan.no_urut_level as no_urut_level',
                                                                            'hrga_biodata_karyawan.no_urut_departemen as no_urut_departemen',
                                                                            'hrga_biodata_karyawan.no_telepon as no_telepon',
                                                                            'hrga_biodata_karyawan.no_bpjs_ketenagakerjaan as no_bpjs_ketenagakerjaan',
                                                                            'hrga_biodata_karyawan.no_bpjs_kesehatan as no_bpjs_kesehatan',
                                                                            'hrga_biodata_karyawan.no_rekening_mandiri as no_rekening_mandiri',
                                                                            'hrga_biodata_karyawan.no_rekening_bws as no_rekening_bws',
                                                                            'hrga_biodata_karyawan.no_npwp as no_npwp',
                                                                            'hrga_biodata_karyawan.departemen_dept as departemen_dept',
                                                                            'hrga_biodata_karyawan.departemen_bagian as departemen_bagian',
                                                                            'hrga_biodata_karyawan.departemen_level as departemen_level',
                                                                            'hrga_biodata_karyawan.tempat_lahir as tempat_lahir',
                                                                            'hrga_biodata_karyawan.tanggal_lahir as tanggal_lahir',
                                                                            'hrga_biodata_karyawan.jenis_kelamin as jenis_kelamin',
                                                                            'hrga_biodata_karyawan.status_keluarga as status_keluarga',
                                                                            'hrga_biodata_karyawan.golongan_darah as golongan_darah',
                                                                            'hrga_biodata_karyawan.pendidikan as pendidikan',
                                                                            'hrga_biodata_karyawan.email as email',
                                                                            'hrga_biodata_karyawan.alamat as alamat',
                                                                            'hrga_biodata_karyawan.kunci_loker as kunci_loker',
                                                                            'biodata_karyawan.tanggal_masuk as tanggal_masuk',
                                                                        ])
                                                                        ->join('itic_emp_new.biodata_karyawan','biodata_karyawan.nik','hrga_biodata_karyawan.nik')
                                                                        // ->rightjoin('hrga_karyawan_resign','hrga_karyawan_resign.hrga_biodata_karyawan_id','!=','hrga_biodata_karyawan.id')
                                                                        // ->where('hrga_karyawan_resign.hrga_biodata_karyawan_id','!=','hrga_biodata_karyawan.id')
                                                                        // ->where(function($query) use($tanggal){
                                                                        //     $query->where('hrga_karyawan_resign.tanggal_resign','<=',\Carbon\Carbon::create($tanggal)->format('Y-m-d'))
                                                                        //         // ->where('hrga_karyawan_resign.hrga_biodata_karyawan_id','!=','hrga_biodata_karyawan.id')
                                                                        //         ;
                                                                        // })

                                                                        ->where('itic_emp_new.biodata_karyawan.tanggal_masuk','<=',\Carbon\Carbon::create($tanggal)->format('Y-m-d'))

                                                                        // ->where(function($query) use ($tanggal){
                                                                        //     $query->whereDate('hrga_biodata_karyawan.tanggal_resign','>=',\Carbon\Carbon::create($tanggal)->format('d'))
                                                                        //     ->whereMonth('hrga_biodata_karyawan.tanggal_resign','>=',\Carbon\Carbon::create($tanggal)->format('m'))
                                                                        //     ->whereYear('hrga_biodata_karyawan.tanggal_resign','>=',\Carbon\Carbon::create($tanggal)->format('Y'))
                                                                        //     ;
                                                                        // })

                                                                        // ->where(function($query) use ($tanggal){
                                                                        //     $query->where('itic_emp.log_posisi.tanggal','<=',\Carbon\Carbon::create($tanggal)->format('Y-m-d'));
                                                                        // })

                                                                        // ->where(function($query) use ($tanggal){
                                                                        //     $query->where('hrga_biodata_karyawan.tanggal_resign','>=',\Carbon\Carbon::create($tanggal)->format('Y-m-d'))
                                                                        //         ->orWhere('hrga_biodata_karyawan.tanggal_resign', '!=', null)
                                                                        //         ;
                                                                        // })

                                                                        // ->where('hrga_biodata_karyawan.tanggal_resign','>=',\Carbon\Carbon::create($tanggal)->format('Y-m-d'))
                                                                        // ->orwhere('hrga_biodata_karyawan.tanggal_resign', null)
                                                                        // ->where('hrga_karyawan_resign.tanggal_resign','>=',\Carbon\Carbon::create($tanggal)->format('Y-m-d'))
                                                                        // ->where('hrga_karyawan_resign.tanggal_resign','>=',\Carbon\Carbon::create($tanggal)->format('Y-m-d'))
                                                                        ->where('hrga_biodata_karyawan.status_karyawan','Y')
                                                                        ->where('hrga_biodata_karyawan.departemen_dept',$departemen->departemen_dept)
                                                                        ->where('hrga_biodata_karyawan.departemen_level',$gj->departemen_level)
                                                                        ->orderBy('id','asc')
                                                                        ->get();
                @endphp
                @if ($gj->departemen_level == 'Staff' || $gj->departemen_level == 'Direktur')
                <tr>
                    <td colspan="5" style="text-transform: capitalize; background-color: #FCD5B4; font-weight: bold; border: 1px solid black;">{{ $gj->departemen_level }}</td>
                </tr>
                @else
                <tr>
                    <td colspan="5" style="text-transform: capitalize; background-color: #FCD5B4; font-weight: bold; border: 1px solid black;">{{ 'Operator '.$gj->departemen_level }}</td>
                </tr>
                @endif
                @foreach ($hrga_biodata_karyawans as $key => $hrga_biodata_karyawan)
                @php
                    $status_kerja = \App\Models\HrgaStatusKerja::select('pk','ke','tgl_mulai')->where('hrga_biodata_karyawan_id',$hrga_biodata_karyawan->id)->orderBy('id','desc')->first();
                    if (empty($status_kerja)) {
                        $data_status_kerja_pk = '-';
                        $data_status_kerja_ke = '-';
                        $data_status_kerja_tgl_mulai = '-';
                    }else{
                        $data_status_kerja_pk = $status_kerja->pk;
                        $data_status_kerja_ke = $status_kerja->ke;
                        $data_status_kerja_tgl_mulai = \Carbon\Carbon::create($status_kerja->tgl_mulai)->format('d/m/Y');
                    }

                    if (empty($hrga_biodata_karyawan->no_bpjs_ketenagakerjaan)) {
                        $bpjs_ketenagakerjaan = "-";
                    }else{
                        // $bpjs_ketenagakerjaan = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_bpjs_ketenagakerjaan);
                        $bpjs_ketenagakerjaan = $hrga_biodata_karyawan->no_bpjs_ketenagakerjaan;
                    }

                    if (empty($hrga_biodata_karyawan->no_bpjs_kesehatan)) {
                        $bpjs_kesehatan = "-";
                    }else{
                        // $bpjs_kesehatan = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_bpjs_kesehatan);
                        $bpjs_kesehatan = $hrga_biodata_karyawan->no_bpjs_kesehatan;
                    }

                    if (empty($hrga_biodata_karyawan->no_rekening_mandiri)) {
                        $mandiri = "-";
                    }else{
                        // $mandiri = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_rekening_mandiri);
                        $mandiri = $hrga_biodata_karyawan->no_rekening_mandiri;
                    }

                    if (empty($hrga_biodata_karyawan->no_rekening_bws)) {
                        $bws = "-";
                    }else{
                        // $bws = sprintf("%'.09d\n", $hrga_biodata_karyawan->no_rekening_bws);
                        $bws = $hrga_biodata_karyawan->no_rekening_bws;
                    }

                    // $group_departeme_level_bagians = \App\Models\HrgaBiodataKaryawan::select('departemen_level')->where('departemen_level',$hrga_biodata_karyawan->departemen_level)->groupBy('departemen_level')->get();
                @endphp
                <tr>
                    <td style="text-align: center; font-weight: bold; border: 1px solid black; vertical-align: top;">{{ $no }}</td>
                    {{-- <td style="text-align: center; font-weight: bold; border: 1px solid black; vertical-align: top; color:red">{{ $hrga_biodata_karyawan->no_urut_level }}</td>
                    <td style="text-align: center; font-weight: bold; border: 1px solid black; vertical-align: top; color:#002060">{{ $hrga_biodata_karyawan->no_urut_departemen }}</td> --}}
                    <td style="text-align: center; font-weight: bold; border: 1px solid black; vertical-align: top;">{{ $hrga_biodata_karyawan->nik }}</td>
                    <td style="text-align: left; font-weight: bold; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->biodata_karyawan->nama }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->no_telepon }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $bpjs_ketenagakerjaan }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $bpjs_kesehatan }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $mandiri }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $bws }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->no_npwp }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->departemen_dept }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->departemen_bagian }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->departemen_level }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $data_status_kerja_pk }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $data_status_kerja_ke }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $data_status_kerja_tgl_mulai }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($hrga_biodata_karyawan->tanggal_masuk)->format('d') }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($hrga_biodata_karyawan->tanggal_masuk)->format('m') }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($hrga_biodata_karyawan->tanggal_masuk)->format('Y') }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($hrga_biodata_karyawan->tanggal_masuk)->format('d/m/Y') }}</td>
                    @php
                        $awal = new DateTime($hrga_biodata_karyawan->tanggal_masuk);
                        $akhir = new DateTime();
                        $diff = $awal->diff($akhir);
                        $masa_kerja_tahun = $diff->y;
                        $masa_kerja_bulan = $diff->m;
                        $masa_kerja_hari = $diff->d;
                    @endphp
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $masa_kerja_tahun }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $masa_kerja_bulan }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $masa_kerja_hari }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->tempat_lahir }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($hrga_biodata_karyawan->tanggal_lahir)->format('d-M') }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ \Carbon\Carbon::create($hrga_biodata_karyawan->tanggal_lahir)->format('Y') }}</td>
                    @php
                        $now = \Carbon\Carbon::now();
                        $b_day = \Carbon\Carbon::create($hrga_biodata_karyawan->tanggal_lahir);
                        $age = $b_day->diffInYears($now);
                    @endphp
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $age }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->jenis_kelamin == 'Laki - Laki' ? 'L' : 'P' }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->status_keluarga }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->golongan_darah }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->pendidikan }}</td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->email }}</td>
                    <td style="text-align: left; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->alamat }}</td>
                    <td style="text-align: left; border: 1px solid black; vertical-align: top">
                        <ol>
                            @foreach ($hrga_biodata_karyawan->riwayat_training as $rt)
                            <li>- {{ $rt->riwayat_training }}</li>
                            @endforeach
                        </ol>
                    </td>
                    <td style="text-align: left; border: 1px solid black; vertical-align: top">
                        <ol>
                            @foreach ($hrga_biodata_karyawan->riwayat_konseling as $rw)
                            <li>- {{ $rw->riwayat_konseling }}</li>
                            @endforeach
                        </ol>
                    </td>
                    <td style="text-align: center; border: 1px solid black; vertical-align: top">{{ $hrga_biodata_karyawan->kunci_loker }}</td>
                </tr>
                @php
                    $no++;
                @endphp
                @endforeach
                
                @endforeach
                
            @endforeach
        </tbody>
    </table>
</body>