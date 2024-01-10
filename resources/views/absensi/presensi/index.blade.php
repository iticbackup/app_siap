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
                                $cek_status_kerja = \App\Models\IticDepartemen::where('id_departemen', $biodata_karyawan->satuan_kerja)->first();
                                if (empty($cek_status_kerja)) {
                                    $satuan_kerja = '-';
                                } else {
                                    if ($cek_status_kerja->nama_departemen >= 1) {
                                        $satuan_kerja = $cek_status_kerja->nama_unit;
                                    } else {
                                        $satuan_kerja = $cek_status_kerja->nama_departemen;
                                    }
                                }

                                $cek_posisi = \App\Models\EmpPosisi::where('id_posisi', $biodata_karyawan->id_posisi)->first();
                                if (empty($cek_posisi)) {
                                    $posisi = '-';
                                } else {
                                    $posisi = $cek_posisi->nama_posisi;
                                }
                            @endphp
                            <tr>
                                <td class="text-center" style="vertical-align: middle">
                                    <div class="btn-group">
                                        <a href="{{ route('presensi.detail',['nik' => $biodata_karyawan->nik]) }}" class="btn btn-primary" target="_blank"><i class="bx bx-bullseye"></i> Detail</a>
                                    </div>
                                </td>
                                <td style="vertical-align: middle">
                                    <div class="card">
                                        <div class="card-body">
                                            <div><b>NIK  :</b> {{ $biodata_karyawan->nik }}</div>
                                            <div><b>Nama :</b> {{ $biodata_karyawan->nama }}</div>
                                            <div><b>Departemen :</b> {{ $satuan_kerja }}</div>
                                            <div><b>Posisi :</b> {{ $posisi }}</div>
                                            {{-- {{ $biodata_karyawan->nik.' - '.$biodata_karyawan->nama }} --}}
                                        </div>
                                    </div>
                                </td>
                                @foreach ($weeks as $week)
                                {{-- @php
                                    $presensi_infos = \App\Models\PresensiInfo::where('pin',$biodata_karyawan->pin)
                                                                            ->where('scan_date','LIKE','%'.$week.'%')
                                                                            ->get();
                                @endphp
                                @foreach ($presensi_infos as $presensi_info)
                                    <div class="card radius-10 bg-success bg-gradient">
                                        <div class="card-body">
                                            <div class="text-white">Jam Masuk</div>
                                            <div class="text-white" style="font-weight: bold"></div>
                                        </div>
                                    </div>
                                @endforeach --}}
                                @php
                                $fin_pros = \App\Models\FinPro::where('pin',$biodata_karyawan->pin)
                                                                ->where('scan_date','LIKE','%'.$week.'%')
                                                                ->get();
                                @endphp
                                <td style="vertical-align: middle" class="text-center">
                                    @if ($fin_pros->isEmpty())
                                        {{-- @php
                                            $presensi_info = \App\Models\PresensiInfo::where('pin',$biodata_karyawan->pin)
                                                                            // ->where('scan_date','LIKE','%'.$week.'%')
                                                                            ->take(1)
                                                                            ->first();
                                        @endphp --}}
                                    @else
                                    @foreach ($fin_pros as $fin_pro)
                                        @if (\Carbon\Carbon::create($fin_pro->scan_date)->format('H:i') <= "11:59")
                                        <div class="card radius-10 bg-success bg-gradient">
                                            <div class="card-body">
                                                <div class="text-white">Jam Masuk</div>
                                                <div class="text-white" style="font-weight: bold">{{ \Carbon\Carbon::create($fin_pro->scan_date)->format('H:i') }}</div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="card radius-10 bg-success bg-gradient">
                                            <div class="card-body">
                                                <div class="text-white">Jam Pulang</div>
                                                <div class="text-white" style="font-weight: bold">{{ \Carbon\Carbon::create($fin_pro->scan_date)->format('H:i') }}</div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                    @endif
                                </td>
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
