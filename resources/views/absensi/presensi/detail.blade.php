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
                                </div>
                            </form>
                        </td>
                    </tr>
                </table>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                    {{-- <div class="col">
                        <div class="card radius-10 bg-success bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white">Kehadiran</p>
                                        <h4 class="my-1 text-white">{{ $kehadiran }}</h4>
                                    </div>
                                    <div class="text-white ms-auto font-35"><i class="bx bx-file-blank"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col">
                        <div class="card radius-10 bg-info bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-dark">Sakit</p>
                                        <h4 class="my-1 text-dark">8.4K</h4>
                                    </div>
                                    <div class="text-dark ms-auto font-35"><i class="bx bxs-group"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10 bg-warning bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-dark">Ijin</p>
                                        <h4 class="text-dark my-1">24.5K</h4>
                                    </div>
                                    <div class="text-dark ms-auto font-35"><i class="bx bx-user-pin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10 bg-danger bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white">Alpa</p>
                                        <h4 class="my-1 text-white">$89,245</h4>
                                    </div>
                                    <div class="text-white ms-auto font-35"><i class="bx bx-user-x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Jam Masuk</th>
                            <th class="text-center">Jam Pulang</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Total Jam</th>
                            <th class="text-center">Ijin Jam Kerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($weeks as $key => $week)
                            @php
                                $presensi_info_masuk = \App\Models\PresensiInfo::where('pin', $biodata_karyawan->pin)
                                    ->where('scan_date', 'LIKE', '%' . $week . '%')
                                    ->orderBy('scan_date', 'asc')
                                    ->first();
                                if (empty($presensi_info_masuk)) {
                                    $status = '-';
                                    // $sakit = 0;
                                    $fin_pro_masuk = \App\Models\FinPro::where('scan_date', 'LIKE', '%' . $week . '%')
                                        ->where('pin', $biodata_karyawan->pin)
                                        ->whereTime('scan_date', '<=', '11:59')
                                        ->orderBy('scan_date', 'desc')
                                        ->first();
                                    if (empty($fin_pro_masuk)) {
                                        $jam_masuk = '-';
                                    } else {
                                        $jam_masuk = \Carbon\Carbon::create($fin_pro_masuk->scan_date)->format('H:i');
                                    }
                                } else {
                                    if ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                                        $status = $presensi_info_masuk->presensi_status->status_info;
                                        // $sakit = $presensi_info_masuk->count();
                                    }
                                }

                                $presensi_info_pulang = \App\Models\PresensiInfo::where('pin', $biodata_karyawan->pin)
                                    ->where('scan_date', 'LIKE', '%' . $week . '%')
                                    ->orderBy('scan_date', 'desc')
                                    ->first();
                                if (empty($presensi_info_pulang)) {
                                    $status = '-';
                                    $fin_pro_pulang = \App\Models\FinPro::where('scan_date', 'LIKE', '%' . $week . '%')
                                        ->where('pin', $biodata_karyawan->pin)
                                        ->whereTime('scan_date', '>=', '12:00')
                                        ->orderBy('scan_date', 'desc')
                                        ->first();
                                    if (empty($fin_pro_pulang)) {
                                        $jam_pulang = '-';
                                    } else {
                                        $jam_pulang = \Carbon\Carbon::create($fin_pro_pulang->scan_date)->format('H:i');
                                    }
                                } else {
                                    if ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                                        $status = $presensi_info_masuk->presensi_status->status_info;
                                    }
                                }

                                $awal = strtotime($jam_masuk);
                                $akhir = strtotime($jam_pulang);

                                $diff = $akhir - $awal;

                                $jam = floor($diff / (60 * 60));
                                $menit = $diff - $jam * (60 * 60);
                                $detik = $diff % 60;

                                $selisih_jam = $jam . ':' . floor($menit / 60);

                                if ($awal == 0 && $akhir == 0) {
                                    $total_jam = 0;
                                } elseif ($awal > 0 && $akhir == 0) {
                                    $total_jam = 0;
                                } else {
                                    $total_jam = $selisih_jam;
                                }
                            @endphp
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::create($week)->isoFormat('dddd, DD MMMM YYYY') }}</td>
                                <td class="text-center"><a class="text-primary">{{ $jam_masuk }}</a></td>
                                <td class="text-center"><a class="text-primary">{{ $jam_pulang }}</a></td>
                                <td class="text-center">{{ $status }}</td>
                                <td class="text-center">{{ $total_jam }}</td>
                            </tr>
                        @endforeach --}}
                        @php
                            $no = 1;
                        @endphp
                        @for ($i = $start_month_now; $i <= $end_month_now; $i++)
                        @php
                            $presensi_info_masuk = \App\Models\PresensiInfo::where('pin', $biodata_karyawan->pin)
                                                                            ->where('scan_date', 'LIKE', '%' . $i . '%')
                                                                            ->orderBy('scan_date', 'asc')
                                                                            ->first();
                            if (empty($presensi_info_masuk)) {
                                $status = '-';
                                $fin_pro_masuk = \App\Models\FinPro::where('scan_date', 'LIKE', '%' . $i . '%')
                                                                    ->where('pin', $biodata_karyawan->pin)
                                                                    ->whereTime('scan_date', '<=', '11:59')
                                                                    ->orderBy('scan_date', 'desc')
                                                                    ->first();
                                if (empty($fin_pro_masuk)) {
                                    $jam_masuk = '-';
                                } else {
                                    $jam_masuk = \Carbon\Carbon::create($fin_pro_masuk->scan_date)->format('H:i');
                                }
                            }else {
                                if ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                                    $status = $presensi_info_masuk->presensi_status->status_info;
                                }
                            }

                            $presensi_info_pulang = \App\Models\PresensiInfo::where('pin', $biodata_karyawan->pin)
                                                                            ->where('scan_date', 'LIKE', '%' . $i . '%')
                                                                            ->orderBy('scan_date', 'desc')
                                                                            ->first();
                            if (empty($presensi_info_pulang)) {
                                $status = '-';
                                $fin_pro_pulang = \App\Models\FinPro::where('scan_date', 'LIKE', '%' . $i . '%')
                                                                    ->where('pin', $biodata_karyawan->pin)
                                                                    ->whereTime('scan_date', '>=', '12:00')
                                                                    ->orderBy('scan_date', 'desc')
                                                                    ->first();
                                if (empty($fin_pro_pulang)) {
                                    $jam_pulang = '-';
                                } else {
                                    $jam_pulang = \Carbon\Carbon::create($fin_pro_pulang->scan_date)->format('H:i');
                                }
                            } else {
                                if ($presensi_info_masuk->status == 4 || $presensi_info_masuk->status == 10) {
                                    $status = $presensi_info_masuk->presensi_status->status_info;
                                }
                            }

                            $awal = strtotime($jam_masuk);
                            $akhir = strtotime($jam_pulang);

                            $diff = $akhir - $awal;

                            $jam = floor($diff / (60 * 60));
                            $menit = $diff - $jam * (60 * 60);
                            $detik = $diff % 60;

                            $selisih_jam = $jam . ':' . floor($menit / 60);

                            if ($awal == 0 && $akhir == 0) {
                                $total_jam = 0;
                            } elseif ($awal > 0 && $akhir == 0) {
                                $total_jam = 0;
                            } else {
                                $total_jam = $selisih_jam;
                            }
                        @endphp
                            <tr>
                                <td class="text-center" style="vertical-align: middle">{{ $no }}</td>
                                <td class="text-center" style="vertical-align: middle">{{ \Carbon\Carbon::create($i)->isoFormat('dddd, DD MMMM YYYY') }}</td>
                                <td class="text-center" style="vertical-align: middle"><a class="text-primary" href="javascript:void()">{{ $jam_masuk }}</a></td>
                                <td class="text-center" style="vertical-align: middle"><a class="text-primary" href="javascript:void()">{{ $jam_pulang }}</a></td>
                                <td class="text-center" style="vertical-align: middle">{{ $status }}</td>
                                <td class="text-center" style="vertical-align: middle">{{ $total_jam }}</td>
                                <td class="text-center" style="vertical-align: middle"><button class="btn" style="color: green" onclick="edit_ijin_jam_kerja(`{{ $biodata_karyawan->nik }}`,`{{ $i }}`)"><i class="bx bxs-calendar-plus"></i></button></td>
                            </tr>
                            @php
                                $no++;
                            @endphp
                        @endfor
                    </tbody>
                </table>
                {{-- <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%" class="text-center">No</th>
                            <th class="text-center">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($weeks as $key => $week)
                        @php
                            $presensi_info_masuk = \App\Models\PresensiInfo::where('pin',$biodata_karyawan->pin)
                                                                    ->where('scan_date','LIKE','%'.$week.'%')
                                                                    ->orderBy('scan_date','asc')
                                                                    ->first();
                            if (empty($presensi_info_masuk)) {
                                $fin_pro_masuk = \App\Models\FinPro::where('scan_date', 'LIKE', '%' . $week . '%')
                                                                ->where('pin', $biodata_karyawan->pin)
                                                                ->orderBy('scan_date','asc')
                                                                ->first();
                                if (empty($fin_pro_masuk)) {
                                    $jam_masuk = '-';
                                }else{
                                    $jam_masuk = \Carbon\Carbon::create($fin_pro_masuk->scan_date)->format('H:i');
                                }
                            }else{
                                $jam_masuk = \Carbon\Carbon::create($presensi_info_masuk->scan_date)->format('H:i');
                            }
                        @endphp
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center">Tanggal : {{ \Carbon\Carbon::create($week)->isoFormat('dddd, DD MMMM YYYY') }}</div>
                                        <div class="text-center">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="badge" style="color:black; font-weight: 500; font-size: 10pt">
                                                        Jam Masuk : {{ $jam_masuk }}
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div>Status : </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="badge" style="color:black; font-weight: 500; font-size: 10pt">
                                                        Jam Pulang :
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table> --}}
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

        function edit_ijin_jam_kerja(nik,tanggal) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/presensi') }}" +'/'+'detail'+ '/' + nik + '/' + tanggal,
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
                        }else {
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
                url: "{{ route('presensi.detail_ijin_jam_kerja_simpan',['nik' => $biodata_karyawan->nik]) }}",
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
                        function fungsi_error(value, index){
                            error_txt += value+'<br>';
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
