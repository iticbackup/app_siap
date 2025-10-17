@extends('layouts.apps.master')
@section('title')
    Verifikasi Dokumen ISO {{ $dc->dc_title }}
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="" class="fw-bold">No. Dokumen</label>
                                <div>{{ $dc->dc_nomor_dokumen }}</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold">Nama Dokumen</label>
                                <div>{{ $dc->dc_title }}</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold">Tanggal Terbit</label>
                                <div>{{ \Carbon\Carbon::create($dc->dc_tanggal_terbit)->isoFormat('DD MMMM YYYY') }}</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold">Revisi</label>
                                <div>{{ $dc->dc_nomor_revisi }}</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold">Validasi Disetujui</label>
                                <div>
                                    @if (empty($dc->dc_disetujui))
                                        <span class="badge bg-warning">Menunggu Validasi</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold">Validasi Diperiksa</label>
                                <div>
                                    @if (empty($dc->dc_diperiksa))
                                        <span class="badge bg-warning">Menunggu Validasi</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold">Validasi Dibuat</label>
                                <div>{{ explode('|',$dc->dc_dibuat)[0].' - '.explode('|',$dc->dc_dibuat)[1] }}</div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <iframe
                                src="{{ asset(
                                    'public/berkas/' .
                                        $dc->dc_category_departemen->departemen->departemen .
                                        '/' .
                                        $dc->dc_category_departemen->dc_category->dc_category .
                                        '/' .
                                        $dc->dc_files,
                                ) }}" width="100%" height="720px"
                                frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('dc.dataValidasi') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
