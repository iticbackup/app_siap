@extends('layouts.absensi.master')
@section('css')
    <style>
        
    </style>
@endsection
@section('title')
    Presensi
@endsection
@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center" style="margin-bottom: 1%">
                    <div class="col">
                        <h4 class="card-title">Presensi Karyawan</h4>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('presensi.search') }}" method="get">
                            <div class="input-group">
                                <div class="mb-3">
                                    <label for="">Cari NIK / Karyawan</label>
                                    <input type="search" name="cari" class="form-control"
                                        value="{{ old('cari') }}" placeholder="Search..." id="">
                                </div>
                                <div class="mb-3">
                                    <label for="">Mulai Bulan</label>
                                    <input type="date" name="cari_tanggal_awal" class="form-control"
                                        value="{{ old('cari_tanggal') }}" id="">
                                </div>
                                <div class="mb-3">
                                    <label for="">Sampai Bulan</label>
                                    <input type="date" name="cari_tanggal_akhir" class="form-control"
                                        value="{{ old('cari_tanggal') }}" id="">
                                </div>
                                <div class="mb-3">
                                    <br>
                                    <button class="btn btn-outline-primary" type="submit"><i
                                            class="bx bxs-search bx-sm bx-tada"></i> Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dataTable mb-0">
                        <thead>
                            <tr>
                                <th class="text-center bg-warning bg-gradient">Action</th>
                                <th class="text-center bg-warning bg-gradient">Nama</th>
                                @foreach ($weeks as $week)
                                <th class="text-center bg-warning bg-gradient">{{ \Carbon\Carbon::create($week)->isoFormat('LL') }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($biodata_karyawans as $biodata_karyawan)
                            @php
                                // $cek_status_kerja = \App\Models\IticDepartemen::where('id_departemen', $biodata_karyawan->satuan_kerja)->first();
                                // if (empty($cek_status_kerja)) {
                                //     $satuan_kerja = '-';
                                // } else {
                                //     if ($cek_status_kerja->nama_departemen >= 1) {
                                //         $satuan_kerja = $cek_status_kerja->nama_unit;
                                //     } else {
                                //         $satuan_kerja = $cek_status_kerja->nama_departemen;
                                //     }
                                // }

                                // $cek_posisi = \App\Models\EmpPosisi::where('id_posisi', $biodata_karyawan->id_posisi)->first();
                                // if (empty($cek_posisi)) {
                                //     $posisi = '-';
                                // } else {
                                //     $posisi = $cek_posisi->nama_posisi;
                                // }
                            @endphp
                            <tr>
                                <td class="text-center" style="vertical-align: middle">
                                    <div class="btn-group">
                                        <a href="{{ route('presensi.detail',['nik' => $biodata_karyawan->nik]) }}" class="btn btn-primary" target="_blank"><i class="bx bx-bullseye"></i> Detail Absensi</a>
                                    </div>
                                </td>
                                <td style="vertical-align: middle">
                                    <div class="card">
                                        <div class="card-body">
                                            <div><b>NIK  :</b> {{ $biodata_karyawan->nik }}</div>
                                            <div><b>Nama :</b> {{ $biodata_karyawan->nama }}</div>
                                            <div><b>Departemen :</b> {{ $biodata_karyawan->departemen->nama_departemen >= 1 ? $biodata_karyawan->departemen->nama_unit : $biodata_karyawan->departemen->nama_departemen }}</div>
                                            <div><b>Posisi :</b> {{ $biodata_karyawan->posisi->nama_posisi }}</div>
                                            {{-- {{ $biodata_karyawan->nik.' - '.$biodata_karyawan->nama }} --}}
                                        </div>
                                    </div>
                                </td>
                                @php
                                    // $no = 1;
                                @endphp
                                @foreach ($weeks as $key_week => $week)
                                    @php
                                        $fin_pro_dates = $fin_pro->where('pin',$biodata_karyawan->pin)
                                                                ->where('scan_date','LIKE','%'.$week.'%')
                                                                ->where(function($query){
                                                                    $query->whereTime('scan_date','<=','11:59')
                                                                        ->orWhereTime('scan_date','>=','12:00');
                                                                })
                                                                // ->whereTime('scan_date','<=','11:59')
                                                                // ->orWhereTime('scan_date','>=','12:00')
                                                                ->orderBy('scan_date','asc')
                                                                ->take(2)
                                                                ->get();
                                                                // dd($fin_pro_date);

                                    // $no++;
                                    @endphp
                                    <td class="text-center" style="vertical-align: middle">
                                        @foreach ($fin_pro_dates as $fin_pro_date)
                                        @php
                                            if (\Carbon\Carbon::create($fin_pro_date->scan_date)->format('H:i') <= '11:59') {
                                                $jam_kerja = '<div class="card radius-10 bg-success bg-gradient">'.
                                                                '<div class="card-body">'.
                                                                    '<div class="text-white">Jam Masuk</div>'.
                                                                    '<div class="text-white" style="font-weight: bold">'.\Carbon\Carbon::create($fin_pro_date->scan_date)->format('H:i').'</div>'.
                                                                '</div>'.
                                                            '</div>';
                                            }elseif(\Carbon\Carbon::create($fin_pro_date->scan_date)->format('H:i') >= '12:00'){
                                                $jam_kerja = '<div class="card radius-10 bg-success bg-gradient">'.
                                                                '<div class="card-body">'.
                                                                    '<div class="text-white">Jam Pulang</div>'.
                                                                    '<div class="text-white" style="font-weight: bold">'.\Carbon\Carbon::create($fin_pro_date->scan_date)->format('H:i').'</div>'.
                                                                '</div>'.
                                                            '</div>';
                                            }

                                        @endphp
                                            <div>{!! $jam_kerja !!}</div>
                                        @endforeach

                                        @php
                                            if ($fin_pro_dates->isEmpty()) {
                                                $masuk_jam_kerja = null;
                                                $pulang_jam_kerja = null;
                                            }else{
                                                if (empty($fin_pro_dates[0])) {
                                                    $masuk_jam_kerja = 0;
                                                }else{
                                                    $masuk_jam_kerja = \Carbon\Carbon::create($fin_pro_dates[0]['scan_date'])->format('H:i');
                                                }

                                                if (empty($fin_pro_dates[1])) {
                                                    $pulang_jam_kerja = 0;
                                                }else{
                                                    $pulang_jam_kerja = \Carbon\Carbon::create($fin_pro_dates[1]['scan_date'])->format('H:i');
                                                }
                                            }

                                            $awal = strtotime($masuk_jam_kerja);
                                            $akhir = strtotime($pulang_jam_kerja);

                                            $diff = $akhir - $awal;

                                            $jam = floor($diff / (60 * 60));
                                            $menit = $diff - $jam * (60 * 60);
                                            $detik = $diff % 60;

                                            if (
                                                $week == \Carbon\Carbon::create($week)->endOfWeek(\Carbon\Carbon::SATURDAY)->format('Y-m-d') ||
                                                $week == \Carbon\Carbon::create($week)->endOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d')
                                            ) {
                                                $selisih_jam = $jam . ':' . floor($menit / 60);
                                            }else{
                                                $selisih_jam = $jam-1 . ':' . floor($menit / 60);
                                            }

                                            if ($awal == 0 && $akhir == 0) {
                                                $total_jam = 0;
                                            } elseif ($awal > 0 && $akhir == 0) {
                                                $total_jam = 0;
                                            } else {
                                                $total_jam = $selisih_jam;
                                            }
                                        @endphp
                                        @if ($masuk_jam_kerja != null && $pulang_jam_kerja != null)
                                        <div class="card radius-10 bg-primary bg-gradient">
                                            <div class="card-body">
                                                <div class="text-white">Total Jam Kerja</div>
                                                <div class="text-white" style="font-weight: bold">{{ $total_jam }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        {{-- <div>{{ $masuk_jam_kerja }}</div>
                                        <div>{{ $pulang_jam_kerja }}</div> --}}
                                    </td>
                                    {{-- <td class="text-center" style="vertical-align: middle">
                                        <div>{!! $jam_masuk !!}</div>
                                        <div>{!! $jam_pulang !!}</div>
                                        @if ($cek_jam_masuk != null && $cek_jam_pulang != null)
                                        <div>
                                            <div class="card radius-10 bg-primary bg-gradient">
                                                <div class="card-body">
                                                    <div class="text-white">Total Jam Kerja</div>
                                                    <div class="text-white" style="font-weight: bold">{{ $total_jam }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </td> --}}
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $biodata_karyawans->links('vendor.pagination.template1.default') }}
            </div>
        </div>
    </div>
@endsection
