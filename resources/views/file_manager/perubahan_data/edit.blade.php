@extends('layouts.apps.master')
@section('title')
    Edit Perubahan Dokumen
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
                    <h4 class="card-title text-white text-center" style="font-size: 14pt">Edit Formulir Perubahan Dokumen</h4>
                </div>
                <form action="{{ route('perubahan_data.update', ['id' => $file_manager_perubahan_data->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Tanggal Formulir Dibuat</label>
                                <input type="date" name="tanggal_formulir" class="form-control"
                                    value="{{ $file_manager_perubahan_data->tanggal_formulir }}" id="">
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
                                    <form
                                        action="{{ route('perubahan_data.update', ['id' => $file_manager_perubahan_data->id]) }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <h5>Detail Formulir</h5>
                                            <div class="repeater-custom-show-hide-new">
                                                <div data-repeater-list="detail_formulir">
                                                    @foreach ($file_manager_perubahan_data_details as $file_manager_perubahan_data_detail)
                                                        @php
                                                            $explode_no_dokumen = explode('.', $file_manager_perubahan_data_detail->no_dokumen);
                                                        @endphp
                                                        <div data-repeater-item="{{ $file_manager_perubahan_data_detail->id }}">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">No. Dokumen</label>
                                                                        {{-- <input type="text" name="id_file_perubahan_data"
                                                                            class="id_file_perubahan_data"
                                                                            value="{{ $file_manager_perubahan_data->id }}"
                                                                            id="">
                                                                        <input type="text"
                                                                            name="id_file_perubahan_data_detail"
                                                                            class="id_file_perubahan_data_detail"
                                                                            value="{{ $file_manager_perubahan_data_detail->id }}"
                                                                            id=""> --}}
                                                                        <input type="text"
                                                                            name="id_file_perubahan_data_detail"
                                                                            class="id_file_perubahan_data_detail"
                                                                            value="{{ $file_manager_perubahan_data_detail->id }}"
                                                                            id="">
                                                                        <input type="text" name="no_dokumen"
                                                                            class="form-control no_dokumen"
                                                                            placeholder="No. Dokumen"
                                                                            value="{{ implode('/', $explode_no_dokumen) }}"
                                                                            id="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Halaman</label>
                                                                        <input type="text" name="halaman"
                                                                            class="form-control" placeholder="Halaman"
                                                                            value="{{ $file_manager_perubahan_data_detail->halaman }}"
                                                                            id="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Revisi</label>
                                                                        <input type="text" name="revisi"
                                                                            class="form-control" placeholder="Revisi"
                                                                            value="{{ $file_manager_perubahan_data_detail->revisi }}"
                                                                            id="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Uraian Perubahan</label>
                                                                        <span></span>
                                                                        <textarea name="uraian_perubahan" class="form-control" id="" cols="30" rows="5">{{ $file_manager_perubahan_data_detail->uraian_perubahan }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Upload File</label>
                                                                        <input type="file" name="files"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="mb-3">
                                                                        <span data-repeater-delete=""
                                                                            {{-- onchange="{{ '`' . $file_manager_perubahan_data->id . '`' }}" --}}
                                                                            class="btn btn-outline-danger">
                                                                            <span class="far fa-trash-alt me-1"></span>
                                                                            Delete
                                                                        </span>
                                                                        {{-- <button 
                                                                            type="button" 
                                                                            class="btn btn-danger" 
                                                                            onclick="delete_perubahan_data_detail(`{{ $file_manager_perubahan_data->id }}`,`{{ $file_manager_perubahan_data_detail->id }}`)"><span class="far fa-trash-alt me-1"></span> Delete
                                                                        </button> --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <span data-repeater-create="" class="btn btn-outline-primary">
                                                    <span class="fas fa-plus"></span> Add
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <a href="{{ route('perubahan_data') }}" class="btn btn-secondary"><i
                                                    class="fa fa-arrow-left"></i> Back</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.form-repeater.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.repeater-custom-show-hide-new').repeater({
                isFirstItemUndeletable: false,
                show: function() {
                    $(this).slideDown();

                },
                hide: function(remove) {
                    if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                        // $(this).slideUp(remove);
                        // $.ajax({
                        //     type: 'GET',
                        //     url: "{{ url('perubahan_data/') }}"+'/'+$('.id_file_perubahan_data').val()+ '/' + $('.id_file_perubahan_data_detail').val()+'/'+'delete',
                        //     contentType: "application/json;  charset=utf-8",
                        //     cache: false,
                        //     success: (result) => {
                        //         if (result.success == true) {
                        //             $(this).slideUp(remove);
                        //         } else {

                        //         }
                        //     },
                        //     error: function(request, status, error) {

                        //     }
                        // });
                        $(this).slideUp(remove);
                        // alert(remove);
                    }
                }
            });
        })

        function delete_perubahan_data_detail(id, id2) {
            // alert(id2);
            // show: function() {
            //     $(this).slideDown();
            // },
            // hide: function(remove) {
            //     if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
            //         $(this).slideUp(remove);
            //     }
            // }
            $('.repeater-custom-show-hide-new').repeater({
                show: function() {
                    $(this).slideDown();
                },
                hide: function(remove) {
                    if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                        $(this).slideUp(remove);
                    }
                }
            });
        }
    </script>
@endsection
