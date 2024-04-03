@extends('layouts.absensi.master')
<?php $asset = asset('public/absensi/'); ?>
@section('css')
    <link rel="stylesheet" href="{{ $asset }}/assets/plugins/notifications/css/lobibox.min.css" />
@endsection
@section('title')
    Detail Presensi - {{ $biodata_karyawan->nik . ' ' . $biodata_karyawan->nama }}
@endsection
@section('content')
    <div class="page-content">
        @include('absensi.presensi.modalEditIjinKerja')
        @include('absensi.presensi.modalPrint')
        @include('absensi.presensi.modalPrintExcel')
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center" style="margin-bottom: 1%">
                    <div class="col">
                        <a href="{{ url()->previous() }}"><i class="bx bx-arrow-back"></i> Back</a>
                        <h4 class="card-title">Detail Presensi Karyawan</h4>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
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
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select name="tahun" class="form-control" id="">
                                        <option value="">-- Tahun --</option>
                                        @for ($i = 2012; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="btn btn-success"><i
                                            class="bx bxs-search bx-sm bx-tada"></i> Search</button>
                                    <button type="button" onclick="cetak(`{{ $biodata_karyawan->nik }}`)"
                                        class="btn btn-primary"><i class="bx bx-printer"></i>
                                        Print</button>
                                    <button type="button" onclick="cetakExcel(`{{ $biodata_karyawan->nik }}`)"
                                        class="btn" style="background-color: #007F73; color: white"><i class="bx bx-download"></i>
                                        Download Excel</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                </table>
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Jam Masuk</th>
                            <th class="text-center" style="width: 10%">Status</th>
                            <th class="text-center">Jam Pulang</th>
                            <th class="text-center" style="width: 10%">Status</th>
                            <th class="text-center">Total Jam</th>
                            <th class="text-center">Ijin Jam Kerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                            $get_presensi_info = [];
                        @endphp
                        @foreach ($weeks as $week)
                            @php
                                $fin_pro_masuk = $fin_pro->where('pin',$biodata_karyawan->pin)
                                                        ->whereDate('scan_date',$week)
                                                        ->whereTime('scan_date','<=','11:59')
                                                        ->orderBy('scan_date','desc')
                                                        ->first();
                                if (empty($fin_pro_masuk)) {
                                    $presensi_info_masuk = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                                        ->whereDate('scan_date',$week)
                                                                        ->whereTime('scan_date','<=','11:59')
                                                                        ->orderBy('scan_date','desc')
                                                                        ->first();
                                    if (empty($presensi_info_masuk)) {
                                        $jam_masuk = '-';
                                        $status_masuk = '-';
                                    }else{
                                        // $jam_masuk = \Carbon\Carbon::create($presensi_info_masuk->scan_date)->format('H:i');
                                        // $status_masuk = '-';
                                        if ($presensi_info_masuk->status == 3) {
                                            $jam_masuk = \Carbon\Carbon::create($presensi_info_masuk->scan_date)->format('H:i');
                                            $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                                        }elseif ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                                            $jam_masuk = '-';
                                            $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                                        }elseif($presensi_info_masuk->status == 5 || $presensi_info_masuk->status == 6){
                                            $jam_masuk = '-';
                                            $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                                        }elseif($presensi_info_masuk->status == 13){
                                            $jam_masuk = '-';
                                            $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                                        }elseif($presensi_info_masuk->status == 14){
                                            $jam_masuk = '-';
                                            $status_masuk = '<div style="color: red">'.$presensi_info_masuk->presensi_status->status_info.'</div>';
                                        }
                                    }
                                }else{
                                    $presensi_info_masuk = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                                                ->whereDate('scan_date',$week)
                                                                                ->whereTime('scan_date','<=','11:59')
                                                                                ->orderBy('scan_date','desc')
                                                                                ->first();
                                    if (empty($presensi_info_masuk)) {
                                        $jam_masuk = \Carbon\Carbon::create($fin_pro_masuk->scan_date)->format('H:i');
                                        $status_masuk = '-';
                                    }else{
                                        if ($presensi_info_masuk->status == 3) {
                                            $jam_masuk = \Carbon\Carbon::create($presensi_info_masuk->scan_date)->format('H:i');
                                            $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                                        }elseif ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                                            $jam_masuk = '-';
                                            $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                                        }elseif($presensi_info_masuk->status == 5 || $presensi_info_masuk->status == 6){
                                            $jam_masuk = '-';
                                            $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                                        }elseif($presensi_info_masuk->status == 13){
                                            $jam_masuk = '-';
                                            $status_masuk = $presensi_info_masuk->presensi_status->status_info;
                                        }elseif($presensi_info_masuk->status == 14){
                                            $jam_masuk = '-';
                                            $status_masuk = '<div style="color: red">'.$presensi_info_masuk->presensi_status->status_info.'</div>';
                                        }
                                    }
                                }

                                $fin_pro_pulang = $fin_pro->where('pin',$biodata_karyawan->pin)
                                                            ->whereDate('scan_date',$week)
                                                            ->whereTime('scan_date','>=','12:00')
                                                            ->orderBy('scan_date','desc')
                                                            // ->limit($no)
                                                            ->first();
                                if (empty($fin_pro_pulang)) {
                                    $presensi_info_pulang = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                                                ->whereDate('scan_date',$week)
                                                                                ->whereTime('scan_date','>=','12:00')
                                                                                ->orderBy('scan_date','desc')
                                                                                ->first();
                                    if (empty($presensi_info_pulang)) {
                                        $jam_pulang = '-';
                                        $status_pulang = '-';
                                    }else{
                                        // $jam_pulang = \Carbon\Carbon::create($presensi_info_pulang->scan_date)->format('H:i');
                                        // $status_pulang = '-';
                                        if ($presensi_info_pulang->status == 3) {
                                            $jam_pulang = \Carbon\Carbon::create($presensi_info_pulang->scan_date)->format('H:i');
                                            $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                                        }elseif ($presensi_info_masuk->status == 4 || $presensi_info_pulang->status == 10) {
                                            $jam_pulang = '-';
                                            $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                                        }elseif($presensi_info_pulang->status == 5 || $presensi_info_pulang->status == 6){
                                            $jam_pulang = '-';
                                            $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                                        }elseif($presensi_info_pulang->status == 13){
                                            $jam_pulang = '-';
                                            $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                                        }elseif($presensi_info_pulang->status == 14){
                                            $jam_pulang = '-';
                                            $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                                        }
                                    }
                                }else{
                                    $presensi_info_pulang = $presensi_info->where('pin', $biodata_karyawan->pin)
                                                                            ->whereDate('scan_date',$week)
                                                                            ->whereTime('scan_date','>=','12:00')
                                                                            ->orderBy('scan_date','desc')
                                                                            ->first();
                                    if (empty($presensi_info_pulang)) {
                                        $jam_pulang = \Carbon\Carbon::create($fin_pro_pulang->scan_date)->format('H:i');
                                        $status_pulang = '-';
                                    }else{
                                        if ($presensi_info_pulang->status == 3) {
                                            $jam_pulang = \Carbon\Carbon::create($presensi_info_pulang->scan_date)->format('H:i');
                                            $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                                        }elseif ($presensi_info_masuk->status == 4 || $presensi_info_pulang->status == 10) {
                                            $jam_pulang = '-';
                                            $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                                        }elseif($presensi_info_pulang->status == 5 || $presensi_info_pulang->status == 6){
                                            $jam_pulang = '-';
                                            $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                                        }elseif($presensi_info_pulang->status == 13){
                                            $jam_pulang = '-';
                                            $status_pulang = $presensi_info_pulang->presensi_status->status_info;
                                        }
                                    }
                                }

                                $awal = strtotime($jam_masuk);
                                $akhir = strtotime($jam_pulang);

                                $diff = $akhir - $awal;

                                $jam = floor($diff / (60 * 60));
                                $menit = $diff - $jam * (60 * 60);
                                $detik = $diff % 60;

                                if ($week == \Carbon\Carbon::create($week)->endOfWeek(\Carbon\Carbon::SATURDAY)->format('Y-m-d') || 
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
                                    // $selisih_jam = $jam-1 . ':' . floor($menit / 60);
                                }

                                if ($awal == 0 && $akhir == 0) {
                                    $total_jam = 0;
                                } elseif ($awal > 0 && $akhir == 0) {
                                    $total_jam = 0;
                                } else {
                                    $total_jam = $selisih_jam;
                                }

                                $no++;
                            @endphp
                            <tr>
                                <td class="text-center" style="vertical-align: middle">{{ $no }}</td>
                                <td class="text-center" style="vertical-align: middle">{{ \Carbon\Carbon::create($week)->isoFormat('dddd, DD MMMM YYYY') }}</td>
                                <td class="text-center" style="vertical-align: middle">{{ $jam_masuk }}</td>
                                <td class="text-center" style="vertical-align: middle">{!! $status_masuk !!}</td>
                                <td class="text-center" style="vertical-align: middle">{{ $jam_pulang }}</td>
                                <td class="text-center" style="vertical-align: middle">{!! $status_pulang !!}</td>
                                <td class="text-center" style="vertical-align: middle">{{ $total_jam }}</td>
                                <td class="text-center" style="vertical-align: middle"><button class="btn" style="color: green" onclick="edit_ijin_jam_kerja(`{{ $biodata_karyawan->nik }}`,`{{ $week }}`)"><i class="bx bxs-calendar-plus"></i></button></td>
                                {{-- <td class="text-center" style="vertical-align: middle">{{ $jam_masuk }}</td>
                                <td class="text-center" style="vertical-align: middle">{{ $status_masuk }}</td> --}}
                                
                                {{-- <td class="text-center" style="vertical-align: middle">{{ \Carbon\Carbon::create($week)->isoFormat('dddd, DD MMMM YYYY') }}</td> --}}
                                {{-- <td class="text-center" style="vertical-align: middle">{{ $presensi_info_masuk }}</td> --}}
                                {{-- <td class="text-center" style="vertical-align: middle"><a class="text-primary" href="javascript:void()">{{ $jam_masuk }}</a></td> --}}
                                {{-- <td class="text-center" style="vertical-align: middle">{{ $status_masuk }}</td> --}}
                                {{-- <td class="text-center" style="vertical-align: middle"><a class="text-primary" href="javascript:void()">{{ $jam_pulang }}</a></td>
                                <td class="text-center" style="vertical-align: middle">{{ $status_pulang }}</td>
                                <td class="text-center" style="vertical-align: middle">{{ $total_jam }}</td>
                                <td class="text-center" style="vertical-align: middle"><button class="btn" style="color: green" onclick="edit_ijin_jam_kerja(`{{ $biodata_karyawan->nik }}`,`{{ $week }}`)"><i class="bx bxs-calendar-plus"></i></button></td> --}}
                            </tr>
                        @endforeach
                        @php
                            // dd($get_presensi_info);
                        @endphp
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ $asset }}/assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="{{ $asset }}/assets/plugins/notifications/js/notifications.min.js"></script>
    <script src="{{ $asset }}/assets/plugins/notifications/js/notification-custom-script.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function cetak(nik) {
            $('.modalPrint').modal('show');
        }

        function cetakExcel(nik) {
            $('.modalPrintExcel').modal('show');
        }

        function edit_ijin_jam_kerja(nik, tanggal) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/presensi') }}" + '/' + 'detail' + '/' + nik + '/' + tanggal,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        // $('#id_ijin').val(result.data.id_ijin);
                        // $('#nik').val(result.data.nik);
                        if (result.status == false) {
                            $('#edit_nik').val(result.nik);
                            $('#edit_tanggal_ijin').val(result.tanggal_ijin);
                            $('.modalEditIjinKerja').modal('show');
                        } else {
                            var jam_keluar = result.data.jam_keluar;
                            var jam_datang = result.data.jam_datang;
                            var jam_istirahat = result.data.jam_istirahat;

                            const array_jam_keluar = jam_keluar.split(":");
                            const array_jam_datang = jam_datang.split(":");
                            const array_jam_istirahat = jam_istirahat.split(":");

                            $('#edit_tanggal_ijin').val(result.tanggal_ijin);
                            $('#edit_jam_keluar_jam').val(array_jam_keluar[0]);
                            $('#edit_jam_keluar_menit').val(array_jam_keluar[1]);
                            $('#edit_jam_datang_jam').val(array_jam_datang[0]);
                            $('#edit_jam_datang_menit').val(array_jam_datang[1]);
                            $('#edit_jam_istirahat_jam').val(array_jam_istirahat[0]);
                            $('#edit_jam_istirahat_menit').val(array_jam_istirahat[1]);

                            $('#edit_keperluan').val(result.data.keperluan);
                            $('.modalEditIjinKerja').modal('show');
                        }

                    } else {
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-x-circle',
                            msg: result.message_content
                        });
                    }
                },
                error: function(request, status, error) {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: error
                    });
                }
            });
            // $('.modalEditIjinKerja').modal('show');
        }

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('presensi.detail_ijin_jam_kerja_simpan', ['nik' => $biodata_karyawan->nik]) }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
                },
                success: (result) => {
                    if (result.success != false) {
                        // alert(result.message_content);
                        Lobibox.notify('success', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-check-circle',
                            msg: result.message_content
                        });
                        $('.modalEditIjinKerja').modal('hide');
                    } else {
                        var error = result.error;
                        var error_txt = "";
                        error.forEach(fungsi_error);

                        function fungsi_error(value, index) {
                            error_txt += value + '<br>';
                        }
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-x-circle',
                            msg: error_txt
                        });
                    }
                },
                error: function(request, status, error) {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: error
                    });
                }
            });
        });
    </script>
@endsection
