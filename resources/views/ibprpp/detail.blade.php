@extends('layouts.apps.master')
@section('title')
    IBPRPP Periode {{ $periode }}
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

    <div class="row">
        @foreach ($departemens as $departemen)
        <div class="col-md-2">
            <a href="{{ route('qhse.ibprpp.departemen_preview',['periode' => $periode, 'departemen_id' => $departemen->id]) }}" class="card">
                <div class="text-center">
                    <img src="{{ asset('public/asset_qhse/compliance.png') }}" class="card-img-top bg-light-alt mt-4" style="width: 50%">
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center" style="font-size: 10pt; font-weight: bold">{{ $departemen->departemen }}</h5>
                </div>
            </a>
        </div>
        @endforeach
    </div>
@endsection
