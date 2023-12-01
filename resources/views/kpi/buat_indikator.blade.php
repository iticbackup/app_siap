@extends('layouts.apps.master')
@section('title')
    KPI Indikator Team
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
                <form action="{{ route('kpi.kpi_indikator_simpan',['departemen_user_id' => $kpi_team->departemen_user_id]) }}" method="post" enctype="multipart/form-data">
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
                            <textarea name="indikator" class="form-control" id="" cols="30" rows="3" required></textarea>
                        </div>
                        <div class="col-md-1">
                            <div class="mb-3">
                                <label for="">Bobot :</label>
                                <input type="text" name="bobot" class="form-control" placeholder="Bobot (%)" id="">
                            </div>
                        </div>
                        <div class="mb-3">
                            <table class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center" style="width: 50%">Detail Indikator</th>
                                        <th class="text-center">Bobot</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kpi_indikators as $key => $kpi_indikator)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $kpi_indikator->indikator }}</td>
                                            <td class="text-center">{{ $kpi_indikator->bobot }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('kpi.kpi_indikator_edit',['departemen_user_id' => $kpi_team->departemen_user_id, 'id' => $kpi_indikator->id]) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('kpi.kpi_indikator_delete',['departemen_user_id' => $kpi_team->departemen_user_id, 'id' => $kpi_indikator->id]) }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Data Belum Tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('kpi.kpi_indikator') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
