@extends('layouts.absensi.master')
@section('title')
    Presensi
@endsection
@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dataTable mb-0">
                        <thead>
                            <tr>
                                <th class="text-center bg-warning bg-gradient">Nama</th>
                                @foreach ($weeks as $week)
                                <th class="text-center bg-warning bg-gradient">{{ \Carbon\Carbon::create($week)->isoFormat('LL') }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($biodata_karyawans as $biodata_karyawan)
                            <tr>
                                <td>
                                    <div class="card">
                                        <div class="card-body">
                                            <div>NIK  : {{ $biodata_karyawan->nik }}</div>
                                            <div>Nama : {{ $biodata_karyawan->nama }}</div>
                                            {{-- {{ $biodata_karyawan->nik.' - '.$biodata_karyawan->nama }} --}}
                                        </div>
                                    </div>
                                </td>
                                @foreach ($weeks as $week)
                                @php
                                    $fin_pros = \App\Models\FinPro::where('pin',$biodata_karyawan->pin)
                                                                    ->where('scan_date','LIKE','%'.$week.'%')
                                                                    ->get();
                                @endphp
                                <td style="vertical-align: middle" class="text-center">
                                    @foreach ($fin_pros as $fin_pro)
                                        @if (\Carbon\Carbon::create($fin_pro->scan_date)->format('H:i') <= "11:59")
                                        <div class="card radius-10 bg-success bg-gradient">
                                            <div class="card-body">
                                                <div class="text-white">Jam Masuk</div>
                                                <div class="text-white" style="font-weight: bold">{{ \Carbon\Carbon::create($fin_pro->scan_date)->format('H:i') }}</div>
                                            </div>
                                        </div>
                                        {{-- <div class="badge bg-success" style="font-size: 10pt">{{ \Carbon\Carbon::create($fin_pro->scan_date)->format('H:i') }}</div> --}}
                                        @else
                                        <div class="card radius-10 bg-success bg-gradient">
                                            <div class="card-body">
                                                <div class="text-white">Jam Pulang</div>
                                                <div class="text-white" style="font-weight: bold">{{ \Carbon\Carbon::create($fin_pro->scan_date)->format('H:i') }}</div>
                                            </div>
                                        </div>
                                        {{-- <div class="badge bg-success" style="font-size: 10pt">{{ \Carbon\Carbon::create($fin_pro->scan_date)->format('H:i') }}</div> --}}
                                        @endif
                                    @endforeach
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
