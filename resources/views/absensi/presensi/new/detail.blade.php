@extends('layouts.absensi.new.master')
@section('title')
    Presensi - {{ $biodata_karyawan->nama }}
@endsection
@section('content')
    @include('absensi.presensi.new.modalPrint')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Presensi Karyawan</h5>
            <hr>
            <table class="table" style="width: 50%">
                <tr>
                    <th>NIK</th>
                    <th>:</th>
                    <td>{{ $biodata_karyawan->nik }}</td>
                </tr>
                <tr>
                    <th>Nama Karyawan</th>
                    <th>:</th>
                    <td>{{ $biodata_karyawan->nama }}</td>
                </tr>
                <tr>
                    <th>Departemen</th>
                    <th>:</th>
                    <td>{{ $satuan_kerja }}</td>
                </tr>
                <tr>
                    <th>Opsional Waktu</th>
                    <th>:</th>
                    <td>
                        <form action="{{ route('presensi.search_detail', ['nik' => $biodata_karyawan->nik]) }}"
                            method="get">
                            <div class="input-group">
                                <select name="bulan" class="form-control" id="">
                                    <option value="">-- Bulan --</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ !empty(request('bulan') == $i) ? 'selected' : null }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <select name="tahun" class="form-control" id="">
                                    <option value="">-- Tahun --</option>
                                    @for ($i = 2015; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{ !empty(request('tahun') == $i) ? 'selected' : null }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <button type="submit" class="btn btn-success"><i data-acorn-icon="search" class="icon" data-acorn-size="18"></i>
                                    Search</button>
                                <button type="button" onclick="cetak(`{{ $biodata_karyawan->nik }}`)"
                                    class="btn btn-primary"><i data-acorn-icon="print" class="icon" data-acorn-size="18"></i>
                                    Print</button>
                                <button type="button" onclick="cetakExcel(`{{ $biodata_karyawan->nik }}`)" class="btn"
                                    style="background-color: #007F73; color: white"><i data-acorn-icon="file-text" class="icon" data-acorn-size="18"></i>
                                    Download Excel</button>
                            </div>
                        </form>
                    </td>
                </tr>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Jam Masuk</th>
                        <th class="text-center" style="width: 10%">Status</th>
                        <th class="text-center">Jam Pulang</th>
                        <th class="text-center" style="width: 10%">Status</th>
                        <th class="text-center">Total Jam</th>
                        {{-- <th class="text-center">Ijin Jam Kerja</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($weeks as $week)
                    @php
                        $mesin_absensi = $fin_pro->select(
                                                    \DB::raw('DATE(scan_date) AS tanggal'),
                                                    'pin',
                                                    \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_masuk"),
                                                    \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_pulang")
                                                )
                                                ->where('pin', $biodata_karyawan->pin)
                                                // Menggunakan whereDate() adalah cara yang lebih baik dan aman daripada LIKE untuk memfilter tanggal
                                                ->whereDate('scan_date', $week)
                                                ->groupBy(\DB::raw('DATE(scan_date)'), 'pin')
                                                ->orderBy(\DB::raw('DATE(scan_date)'))
                                                ->first();

                        if (empty($mesin_absensi)) {
                            $jam_masuk = '-';
                            $jam_pulang = '-';

                            $presensiKaryawan = $presensi_info->select(
                                                                // \DB::raw('DATE(scan_date) AS tanggal'),
                                                                'scan_date as scan_date',
                                                                'att_presensi_info.pin as pin',
                                                                'att_presensi_info.status as status',
                                                                \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN att_status.status_info ELSE NULL END) AS status_masuk"),
                                                                \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_masuk"),
                                                                \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN att_status.status_info ELSE NULL END) AS status_pulang"),
                                                                \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_pulang")
                                                            )
                                                            ->leftJoin('att_status','att_status.status_id','=','att_presensi_info.status')
                                                            ->where('pin', $biodata_karyawan->pin)
                                                            // Menggunakan whereDate() adalah cara yang lebih baik dan aman daripada LIKE untuk memfilter tanggal
                                                            ->whereDate('scan_date', $week)
                                                            // ->whereTime('scan_date', '<=', '11:59')
                                                            // ->groupBy(\DB::raw('DATE(scan_date)'), 'pin', 'status')
                                                            ->groupBy(\DB::raw('scan_date'), 'pin', 'status')
                                                            ->orderBy(\DB::raw('DATE(scan_date)'))
                                                            ->first();

                                                            // dd($presensiKaryawan);
                                        
                            if (empty($presensiKaryawan)) {
                                $jam_masuk = '-';
                                $jam_pulang = '-';
                                $status_masuk = '-';
                                $status_pulang = '-';
                            }else{
                                if ($presensiKaryawan->status == 3) {
                                    $jam_masuk = '<div style="color: red">'.\Carbon\Carbon::create($presensiKaryawan->scan_date)->format('H:i').'</div>';
                                    $jam_pulang = '-';
                                    $status_masuk = $presensiKaryawan->status_masuk;
                                    $status_pulang = '-';
                                }elseif ($presensiKaryawan->status == 4 || $presensiKaryawan->status == 10) {
                                    $jam_masuk = '-';
                                    $jam_pulang = '-';
                                    $status_masuk = $presensiKaryawan->status_masuk;
                                    $status_pulang = '-';
                                }elseif($presensiKaryawan->status == 5 || $presensiKaryawan->status == 6){
                                    $jam_masuk = '-';
                                    $jam_pulang = '-';
                                    $status_masuk = $presensiKaryawan->status_masuk;
                                    $status_pulang = $presensiKaryawan->status_pulang;
                                }elseif($presensiKaryawan->status == 8 || $presensiKaryawan->status == 9 || $presensiKaryawan->status == 10 || $presensiKaryawan->status == 12){
                                    $jam_masuk = '-';
                                    $jam_pulang = '-';
                                    $status_masuk = '-';
                                    $status_pulang = $presensiKaryawan->status_pulang;
                                }elseif($presensiKaryawan->status == 13){
                                    $jam_masuk = '-';
                                    $jam_pulang = '-';
                                    $status_masuk = $presensiKaryawan->status_masuk;
                                    $status_pulang = '-';
                                }elseif($presensiKaryawan->status == 14){
                                    $jam_masuk = '-';
                                    $jam_pulang = '-';
                                    $status_masuk = $presensiKaryawan->status_masuk;
                                    $status_pulang = '<div style="color: red">'.$presensiKaryawan->status_pulang.'</div>';
                                }
                            }
                        }else{
                            $presensiKaryawan = $presensi_info->select(
                                                                // \DB::raw('DATE(scan_date) AS tanggal'),
                                                                'scan_date as scan_date',
                                                                'att_presensi_info.pin as pin',
                                                                'att_presensi_info.status as status',
                                                                \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN att_status.status_info ELSE NULL END) AS status_masuk"),
                                                                \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_masuk"),
                                                                \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN att_status.status_info ELSE NULL END) AS status_pulang"),
                                                                \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_pulang")
                                                            )
                                                            ->leftJoin('att_status','att_status.status_id','=','att_presensi_info.status')
                                                            ->where('pin', $biodata_karyawan->pin)
                                                            // Menggunakan whereDate() adalah cara yang lebih baik dan aman daripada LIKE untuk memfilter tanggal
                                                            ->whereDate('scan_date', $week)
                                                            // ->whereTime('scan_date', '<=', '11:59')
                                                            // ->groupBy(\DB::raw('DATE(scan_date)'), 'pin', 'status')
                                                            ->groupBy(\DB::raw('scan_date'), 'pin', 'status')
                                                            ->orderBy(\DB::raw('DATE(scan_date)'))
                                                            ->first();

                            if (empty($presensiKaryawan)) {
                                $jam_masuk = '-';
                                $jam_pulang = '-';
                                $status_masuk = '-';
                                $status_pulang = '-';
                            }else{
                                if ($presensiKaryawan->status == 3) {
                                    $jam_masuk = '<div style="color: red">'.\Carbon\Carbon::create($presensiKaryawan->scan_date)->format('H:i').'</div>';
                                    $jam_pulang = '-';
                                    $status_masuk = '<div style="color: red">'.$presensiKaryawan->status_masuk.'</div>';
                                    $status_pulang = '-';
                                }elseif ($presensiKaryawan->status == 4 || $presensiKaryawan->status == 10) {
                                    $jam_masuk = '-';
                                    $jam_pulang = '-';
                                    $status_masuk = $presensiKaryawan->status_masuk;
                                    $status_pulang = '-';
                                }elseif($presensiKaryawan->status == 5 || $presensiKaryawan->status == 6){
                                    $jam_masuk = '-';
                                    $jam_pulang = '-';
                                    $status_masuk = $presensiKaryawan->status_masuk;
                                    $status_pulang = $presensiKaryawan->status_pulang;
                                }elseif($presensiKaryawan->status == 8 || $presensiKaryawan->status == 9 || $presensiKaryawan->status == 10 || $presensiKaryawan->status == 12){
                                    $jam_masuk = '-';
                                    $jam_pulang = '-';
                                    $status_masuk = '-';
                                    $status_pulang = $presensiKaryawan->status_pulang;
                                }elseif($presensiKaryawan->status == 13){
                                    $jam_masuk = '-';
                                    $jam_pulang = '-';
                                    $status_masuk = $presensiKaryawan->status_masuk;
                                    $status_pulang = '-';
                                }elseif($presensiKaryawan->status == 14){
                                    $jam_masuk = '-';
                                    $jam_pulang = '-';
                                    $status_masuk = $presensiKaryawan->status_masuk;
                                    $status_pulang = '<div style="color: red">'.$presensiKaryawan->status_pulang.'</div>';
                                }
                            }

                            // if (empty($mesin_absensi->jam_masuk)) {
                            //     $jam_masuk = '-';
                            // }else{
                            //     $jam_masuk = $mesin_absensi->jam_masuk;
                            // }

                            // if (empty($mesin_absensi->jam_pulang)) {
                            //     $jam_pulang = '-';
                            // }else{
                            //     $jam_pulang = $mesin_absensi->jam_pulang;
                            // }
                        }

                        if (empty($mesin_absensi->jam_masuk)) {
                            $jam_masuk = '-';
                        }else{
                            $jam_masuk = $mesin_absensi->jam_masuk;
                        }

                        if (empty($mesin_absensi->jam_pulang)) {
                            $jam_pulang = '-';
                        }else{
                            $jam_pulang = $mesin_absensi->jam_pulang;
                        }

                        $awal = strtotime($jam_masuk);
                        $akhir = strtotime($jam_pulang);

                        $diff = $akhir - $awal;

                        $jam = floor($diff / (60 * 60));
                        $menit = $diff - $jam * (60 * 60);
                        $detik = $diff % 60;

                        if (
                            $week == \Carbon\Carbon::create($week)->endOfWeek(\Carbon\Carbon::SATURDAY)->format('Y-m-d') ||
                            $week == \Carbon\Carbon::create($week)->endOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d')
                        ) {
                            if (floor($menit / 60) <= 9) {
                                $selisih_jam = $jam . ':' . '0'.floor($menit / 60);
                            }else{
                                $selisih_jam = $jam . ':' . floor($menit / 60);
                            }
                        }else{
                            if (floor($menit / 60) <= 9) {
                                $selisih_jam = $jam-1 . ':' . '0'.floor($menit / 60);
                            }else{
                                $selisih_jam = $jam-1 . ':' . floor($menit / 60);
                            }
                        }

                        if ($awal == 0 && $akhir == 0) {
                            $total_jam = 0;
                        } elseif ($awal > 0 && $akhir == 0) {
                            $total_jam = 0;
                        } else {
                            if (empty($jam_masuk) || $jam_masuk == '-') {
                                $total_jam = '-';
                            }elseif (empty($jam_pulang) || $jam_pulang == '-') {
                                $total_jam = '-';
                            }else{
                                $total_jam = $selisih_jam;
                            }
                        }

                        $no++;
                    @endphp
                    <tr>
                        <td class="text-center" style="vertical-align: middle">{{ $no }}</td>
                        <td class="text-center {{ $week == \Carbon\Carbon::create($week)->endOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d') ? 'text-danger' : null }}" style="vertical-align: middle">{{ \Carbon\Carbon::create($week)->isoFormat('dddd, DD MMMM YYYY') }}</td>
                        <td class="text-center" style="vertical-align: middle">{!! $jam_masuk !!}</td>
                        <td class="text-center" style="vertical-align: middle">{!! $status_masuk !!}</td>
                        <td class="text-center" style="vertical-align: middle">{!! $jam_pulang !!}</td>
                        <td class="text-center" style="vertical-align: middle">{!! $status_pulang !!}</td>
                        <td class="text-center" style="vertical-align: middle">{{ $total_jam }}</td>
                        {{-- <td></td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function cetak(nik) {
            $('.modalPrint').modal('show');
        }
    </script>
@endsection