@extends('layouts.apps.master')
@section('title')
    Buat Perubahan Dokumen
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    {{-- <link href="{{ URL::asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"> --}}
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
                <div class="card-header bg-dark">
                    <h4 class="card-title text-white text-center" style="font-size: 14pt">Formulir Perubahan Dokumen</h4>
                </div>
                <form action="{{ route('perubahan_data.simpan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Tanggal Formulir Dibuat</label>
                                <input type="date" name="tanggal_formulir" class="form-control" id="">
                            </div>
                            @if (auth()->user()->nik == '0000000')
                            <div class="col-md-2">
                                <label class="form-label">Departemen</label>
                                <select name="departemen_id" class="form-control" id="">
                                    <option value="">select</option>
                                    @foreach ($departemens as $departemen)
                                    <option value="{{ $departemen->id }}">{{ $departemen->departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-md-12">
                                <hr style="border-top: 1px dashed rgb(0, 17, 255);">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Detail Formulir</h5>
                                        <div class="repeater-default">
                                            <div data-repeater-list="detail_formulir">
                                                <div data-repeater-item="">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="mb-3">
                                                                <label class="form-label">No. Dokumen</label>
                                                                <input type="text" name="no_dokumen" class="form-control"
                                                                    placeholder="No. Dokumen" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="mb-3">
                                                                <label class="form-label">Halaman</label>
                                                                <input type="text" name="halaman" class="form-control"
                                                                    placeholder="Halaman" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="mb-3">
                                                                <label class="form-label">Revisi</label>
                                                                <input type="text" name="revisi" class="form-control"
                                                                    placeholder="Revisi" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="mb-3">
                                                                <label class="form-label">Kategori File</label>
                                                                <select name="kategori_file" class="form-control" id="">
                                                                    <option value="">-- Pilih Kategori --</option>
                                                                    <option value="PK">PK</option>
                                                                    <option value="SOP">SOP</option>
                                                                    <option value="IK">IK</option>
                                                                    <option value="ITI">ITI</option>
                                                                    <option value="FR">FR</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Uraian Perubahan</label>
                                                                <span></span>
                                                                {{-- <div id="summernote"></div> --}}
                                                                <textarea name="uraian_perubahan" class="form-control editor" id="" cols="30" rows="5"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-3">
                                                                <label class="form-label">Upload File</label>
                                                                <input type="file" name="files" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="mb-3">
                                                                <span data-repeater-delete=""
                                                                    class="btn btn-outline-danger">
                                                                    <span class="far fa-trash-alt me-1"></span> Delete
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span data-repeater-create="" class="btn btn-outline-primary">
                                                <span class="fas fa-plus"></span> Add
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('perubahan_data') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.form-repeater.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> --}}
    {{-- <script src="{{ URL::asset('public/assets/js/pages/ckeditor.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.form-upload.init.js') }}"></script> --}}
    <script>
        // ClassicEditor
        //     .create(document.querySelector('.editor'))
        //     .catch(error => {
        //         console.error(error);
        //     });
        // $('#summernote').summernote({
        //     toolbar:[

        //     // This is a Custom Button in a new Toolbar Area
        //     ['custom', ['examplePlugin']],

        //     // You can also add Interaction to an existing Toolbar Area
        //     ['style', ['style' ,'examplePlugin']]
        //     ]
        // });
    </script>
@endsection
