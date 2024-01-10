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
                                <th class="text-center">Nama</th>
                                @foreach ($weeks as $week)
                                <th class="text-center">{{ \Carbon\Carbon::create($week)->isoFormat('LL') }}</th>
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
                                <td>
                                    @foreach ($fin_pros as $fin_pro)
                                        <div>1</div>
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
