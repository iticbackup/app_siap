@extends('layouts.apps.master')

@section('title')
    IBPRPP Periode {{ $periode . ' - ' . $departemen->departemen }}
@endsection

@section('css')
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
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
            <form id="form-simpan" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 30%;">
                            <tr>
                                <th>Periode</th>
                                <th>:</th>
                                <th>{{ $periode }}</th>
                            </tr>
                            <tr>
                                <th>Departemen</th>
                                <th>:</th>
                                <th>{{ $departemen->departemen }}</th>
                            </tr>
                            <tr>
                                <th>Kategori Area</th>
                                <th>:</th>
                                <th>
                                    <select name="ibprpp_category_area_id" class="form-control" id="">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($category_areas as $category_area)
                                            <option value="{{ $category_area->id }}">{{ $category_area->category_area }}
                                            </option>
                                        @endforeach
                                    </select>
                                </th>
                            </tr>
                        </table>
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h5 class="card-title text-white">Aktivitas & Jenis Pekerja</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="aktifitas_pekerja" class="mb-2">Aktifitas Pekerja</label>
                                        <input type="text" name="aktifitas_pekerja" class="form-control"
                                            placeholder="Aktifitas Pekerja">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="mb-2">Jenis Aktivitas</label>
                                        <select name="jenis_aktivitas" class="form-control">
                                            <option value="">-- Pilih Jenis Aktivitas --</option>
                                            <option value="Rutin">Rutin</option>
                                            <option value="Non Rutin">Non Rutin</option>
                                            <option value="Darurat">Darurat</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="repeater-penilaian-risiko-potensi-bahaya">
                            <div data-repeater-list="penilaian_risiko_potensi_bahaya">
                                <div data-repeater-item="">
                                    <div class="card">
                                        <div class="card-header bg-dark">
                                            <div class="col">
                                                <h5 class="card-title text-white">
                                                    Potensi Bahaya</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <tr>
                                                    <th>Potensi Bahaya</th>
                                                    <th class="text-center">:</th>
                                                    <td><input type="text" name="potensi_bahaya" class="form-control"
                                                            placeholder="Potensi Bahaya"></td>
                                                </tr>
                                            </table>
                                            <div class="repeater-risiko-bahaya">
                                                <div data-repeater-list="risiko_bahaya">
                                                    <div data-repeater-item="">
                                                        <div class="card">
                                                            <div class="card-header bg-dark">
                                                                <div class="col">
                                                                    <h5 class="card-title text-white">
                                                                        Risiko Bahaya</h5>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <table class="table table-bordered dt-responsive nowrap"
                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th class="text-center">Risiko Bahaya</th>
                                                                            <th class="text-center">Jumlah Kejadian
                                                                                Dalam <br> 1 Periode
                                                                                Penilaian</th>
                                                                            <th class="text-center">Frekuensi
                                                                                (Probability)</th>
                                                                            <th class="text-center">Keparahan
                                                                                (Severity)</th>
                                                                            <th class="text-center">Penetapan Pengendalian
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" name="risiko_bahaya"
                                                                                    class="form-control"
                                                                                    placeholder="Risiko Bahaya">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" name="jumlah_kejadian"
                                                                                    class="form-control text-center"
                                                                                    placeholder="Jumlah Kejadian">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" name="frekuensi"
                                                                                    class="form-control text-center"
                                                                                    placeholder="Frekuensi (Probability)">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" name="keparahan"
                                                                                    class="form-control text-center"
                                                                                    placeholder="Keparahan (Severity)">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text"
                                                                                    name="penetapan_pengendalian"
                                                                                    class="form-control text-center"
                                                                                    placeholder="Penetapan Pengendalian">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <div class="repeater-pengendalian-bahaya">
                                                                    {{-- <div data-repeater-list="pengendalian-bahaya"> --}}
                                                                    <div class="card">
                                                                        <div class="card-header bg-dark">
                                                                            <div class="row align-items-center">
                                                                                <div class="col">
                                                                                    <h5 class="card-title text-white">
                                                                                        Pengendalian Bahaya</h5>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <button type="button"
                                                                                        class="btn btn-primary"
                                                                                        data-repeater-create><i
                                                                                            class="fas fa-plus"></i>
                                                                                        Tambah
                                                                                        Pengendalian</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div data-repeater-list="pengendalian-bahaya">
                                                                            <div data-repeater-item="">
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-5">
                                                                                            <label for=""
                                                                                                class="mb-2">Upaya</label>
                                                                                            <textarea name="upaya_pengendalian" class="form-control" cols="30" rows="2"
                                                                                                placeholder="Upaya Pengendalian"></textarea>
                                                                                        </div>
                                                                                        <div class="col-md-5">
                                                                                            <label for=""
                                                                                                class="mb-2">Penilaian
                                                                                                Pengendalian <br>
                                                                                                Berdasarkan
                                                                                                Frekuensi Kejadian</label>
                                                                                            <input type="text"
                                                                                                name="penilaian_pengendalian"
                                                                                                class="form-control"
                                                                                                placeholder="Penilaian Pengendalian">
                                                                                        </div>
                                                                                        <div
                                                                                            class="col-md-2 row justify-content-center">
                                                                                            <button type="button"
                                                                                                class="btn btn-danger"
                                                                                                data-repeater-delete><span
                                                                                                    class="far fa-trash-alt"></span>
                                                                                                Hapus</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    {{-- </div> --}}
                                                                    </div>
                                                                    {{-- <button type="button"
                                                                        class="btn btn-primary"
                                                                        data-repeater-create><i
                                                                            class="fas fa-plus"></i>
                                                                        Tambah
                                                                        Pengendalian</button> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary" data-repeater-create><i class="fas fa-plus"></i>
                                                    Tambah Risiko Bahaya</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header bg-dark">
                                            <h5 class="card-title text-white">PIC / Wewenang
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <textarea name="pic_wewenang" class="form-control" cols="30" rows="5" placeholder="PIC / Wewenang"></textarea>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header bg-dark">
                                            <h5 class="card-title text-white">Regulasi Terkait
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <textarea name="regulasi_terkait" class="form-control" cols="30" rows="5"
                                                placeholder="Regulasi Terkait"></textarea>
                                        </div>
                                    </div>
                                    <hr style="border-top: 1px dashed blue;">
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" data-repeater-create><i class="fas fa-plus"></i>
                                Tambah Potensi Bahaya</button>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('public/assets/js/pages/ckeditor.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    {{-- <script src="{{ asset('public/assets/js/pages/jquery.form-repeater.js') }}"></script> --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            'use strict';

            $('.repeater-penilaian-risiko-potensi-bahaya').repeater({
                initEmpty: false,
                
                show: function() {
                    $(this).slideDown();
                    // $('.repeater-pengendalian-bahaya').repeater({
                    // });
                },
                hide: function(remove) {
                    if (confirm(
                            'Apakah Anda yakin ingin menghapus inputan Penilaian Risiko & Pengendalian?'
                        )) {
                        $(this).slideUp(remove);
                    }
                },
                repeaters: [
                    {
                        selector: '.repeater-risiko-bahaya',
                        // initEmpty: true,
                        // show: function() {
                        //     $(this).slideDown();
                        //     $('.repeater-pengendalian-bahaya').repeater({
                        //     });
                        // },
                        // selector: '.repeater-pengendalian-bahaya',
                        initEmpty: false,
                    },
                    // {
                    //     selector: '.repeater-pengendalian-bahaya',
                    //     initEmpty: false,
                    // },
                ],
                // selector: '.repeater-pengendalian-bahaya',
            });

            $('.repeater-custom-show-hide').repeater({
                show: function() {
                    $(this).slideDown();
                },
                hide: function(remove) {
                    if (confirm('Are you sure you want to remove this item?')) {
                        $(this).slideUp(remove);
                    }
                }
            });
        });

        document.addEventListener('keydown', (e) => {
            e = e || window.event;
            if (e.keyCode == 116) {
                // e.preventDefault();
                if (confirm('Apakah anda yakin untuk merefresh halaman ini?')) {
                    window.location.reload();
                }
                e.preventDefault();
            }
        });

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ route('qhse.ibprpp.departemen_simpan', ['periode' => $periode, 'departemen_id' => $departemen->id]) }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('#loadingscreen').modal('show');
                    $('#modalLoading').modal('show');
                },
                success: (result) => {
                    if (result.success != false) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content,
                            position: 'topRight',
                        });
                    } else {
                        // $('#loadingscreen').modal('hide');
                        $('#modalLoading').modal('hide');
                        iziToast.error({
                            title: result.success,
                            message: result.error,
                            position: 'topRight',
                        });
                    }
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                        position: 'topRight',
                    });
                    $('#modalLoading').modal('hide');
                }
            });

        });
    </script>
@endsection
