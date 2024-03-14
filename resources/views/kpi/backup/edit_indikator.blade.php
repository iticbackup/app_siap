@extends('layouts.apps.master')
@section('title')
    Edit KPI Indikator Team
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
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('kpi.kpi_indikator_update',['departemen_user_id' => $kpi_team->departemen_user_id, 'id' => $kpi_indikator->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <table style="width: 20%">
                            <tr>
                                <td>NIK</td>
                                <td>:</td>
                                <td>{{ $kpi_team->departemen_user->nik }}</td>
                            </tr>
                            <tr>
                                <td>Nama Karyawan</td>
                                <td>:</td>
                                <td>{{ $kpi_team->departemen_user->team }}</td>
                            </tr>
                            <tr>
                                <td>Departemen</td>
                                <td>:</td>
                                <td>{{ $kpi_team->kpi_departemen->departemen }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mb-3">
                        <label for="">Indikator :</label>
                        <textarea name="indikator" class="form-control" id="" cols="30" rows="3" required>{{ $kpi_indikator->indikator }}</textarea>
                    </div>
                    <div class="col-md-1">
                        <div class="mb-3">
                            <label for="">Bobot :</label>
                            <input type="text" name="bobot" class="form-control" placeholder="Bobot (%)" value="{{ $kpi_indikator->bobot }}" id="">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('kpi.kpi_indikator_buat', $kpi_team->departemen_user_id) }}" class="btn btn-secondary">Back</a>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
