@extends('layouts.absensi.master')
@section('css')
@endsection
@section('title')
    Detail Presensi - {{ $biodata_karyawan->nik . ' ' . $biodata_karyawan->nama }}
@endsection
@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center" style="margin-bottom: 1%">
                    <div class="col">
                        <h4 class="card-title">Presensi ({{ $biodata_karyawan->nama . ' - ' . $biodata_karyawan->nik }})</h4>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Jam Masuk</th>
                            <th class="text-center">Jam Pulang</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($weeks as $key => $week)
                            @php
                                // $presensi_info_masuk = \App\Models\PresensiInfo::where('pin', $biodata_karyawan->pin)
                                //             ->where('scan_date', 'LIKE', '%' . $week . '%')
                                //             ->orderBy('scan_date', 'asc')
                                //             ->first();
                                // if (empty($presensi_info_masuk)) {
                                //     $fin_pro_masuk = \App\Models\FinPro::where('scan_date', 'LIKE', '%' . $week . '%')
                                //         ->where('pin', $biodata_karyawan->pin)
                                //         ->orderBy('scan_date', 'asc')
                                //         ->first();
                                //     if (empty($fin_pro_masuk)) {
                                //         $jam_masuk = '-';
                                //     } else {
                                //         $jam_masuk = \Carbon\Carbon::create($fin_pro_masuk->scan_date)->format('H:i');
                                //     }
                                // } else {
                                //     $jam_masuk = \Carbon\Carbon::create($presensi_info_masuk->scan_date)->format('H:i');
                                // }

                                $presensi_info = \App\Models\PresensiInfo::where('pin', $biodata_karyawan->pin)
                                                                                ->where('scan_date', 'LIKE', '%' . $week . '%')
                                                                                ->orderBy('scan_date', 'asc')
                                                                                ->get();
                                if ($presensi_info->isEmpty()) {
                                    $fin_pro_masuk = \App\Models\FinPro::where('scan_date', 'LIKE', '%' . $week . '%')
                                                                        ->where('pin', $biodata_karyawan->pin)
                                                                        ->orderBy('scan_date', 'asc')
                                                                        ->first();
                                    if (empty($fin_pro_masuk)) {
                                        $jam_masuk = '-';
                                    }else {
                                        if (\Carbon\Carbon::create($fin_pro_masuk->scan_date)->format('H:i') <= "11:59") {
                                            $jam_masuk = \Carbon\Carbon::create($fin_pro_masuk->scan_date)->format('H:i');
                                        }
                                    }

                                    $fin_pro_pulang = \App\Models\FinPro::where('scan_date', 'LIKE', '%' . $week . '%')
                                                                        ->where('pin', $biodata_karyawan->pin)
                                                                        ->orderBy('scan_date', 'desc')
                                                                        ->first();
                                    if (empty($fin_pro_pulang)) {
                                        $jam_pulang = '-';
                                    }else {
                                        if (\Carbon\Carbon::create($fin_pro_pulang->scan_date)->format('H:i') >= "12:00") {
                                            $jam_pulang = \Carbon\Carbon::create($fin_pro_pulang->scan_date)->format('H:i');
                                        }
                                    }
                                }else{
                                    $jam_masuk = $presensi_info[0]['scan_date'];
                                    $jam_pulang = $presensi_info[1]['scan_date'];
                                }
                            @endphp
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::create($week)->isoFormat('dddd, DD MMMM YYYY') }}
                                <td class="text-center">{{ $jam_masuk }}</td>
                                <td class="text-center">{{ $jam_pulang }}</td>
                                <td></td>
                                {{-- <td class="text-center">{{ $jam_masuk }}</td> --}}
                            </tr>
                        @endforeach
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
@endsection
