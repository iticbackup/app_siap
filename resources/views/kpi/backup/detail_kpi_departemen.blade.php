@extends('layouts.apps.master')
@section('title')
    KPI Departemen
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @yield('title')
        @endslot
        @slot('title')
            @yield('title')
        @endslot
    @endcomponent
    @if ($message = Session::get('error'))
        <div class="alert alert-danger border-0" role="alert">
            <strong>Gagal!</strong> {{ $message }}
        </div>
    @endif
    <div class="row">
        @foreach ($kpi_departemens as $kpi_departemen)
            <div class="col-md-2">
                <a href="{{ route('kpi.input_date_kpi_detail', ['date' => $date, 'id_departemen' => $kpi_departemen->id]) }}">
                    <div class="card">
                        <div class="text-center card-img-top bg-light-alt pt-3 pb-3">
                            <img src="{{ asset('public/assets/images/cv.png') }}" style="width: 100px">
                        </div>
                        {{-- <i class="text-center mdi mdi-file-search-outline card-img-top bg-light-alt" style="font-size: 24pt"></i> --}}
                        <div class="card-header">
                            <div class="card-title text-center">{{ $kpi_departemen->departemen }}</div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
