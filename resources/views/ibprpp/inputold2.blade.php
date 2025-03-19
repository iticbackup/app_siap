@extends('layouts.apps.master')
@section('title')
    IBPRPP Periode {{ $periode . ' - ' . $departemen->departemen }}
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
                    <div class="card">
                        <div class="card-header bg-dark">
                            <h5 class="card-title text-white">Risiko</h5>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="repeater-penilaian">
                                    <div data-repeater-list="penilaian">
                                        <div class="card" data-repeater-item="">
                                            <div class="card-header bg-primary">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h5 class="card-title text-white">Penilaian Risiko, Pengendalian,
                                                            PIC / Wewenang & Regulasi
                                                            Terkait</h5>
                                                    </div>
                                                    {{-- <div class="col-auto">
                                                        <button type="button" class="btn btn-success"
                                                            data-repeater-create=""><i class="fas fa-plus"></i></button>
                                                        <button type="button" class="btn btn-danger"
                                                            data-repeater-delete=""><span
                                                                class="far fa-trash-alt"></span></button>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="card-body">

                                                <div class="repeater-penilaian-risiko">
                                                    <div data-repeater-list="penilaian_risiko">
                                                        <div data-repeater-item="">
                                                            <div class="card">
                                                                <div class="card-header bg-dark">
                                                                    <div class="row align-items-center">
                                                                        <div class="col">
                                                                            <h5 class="card-title text-white">+ Penilaian Risiko
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <button type="button" class="btn btn-success"
                                                                                data-repeater-create><i
                                                                                    class="fas fa-plus"></i></button>
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-repeater-delete><span
                                                                                    class="far fa-trash-alt"></span></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="mb-3">
                                                                        <label for="" class="mb-2">Potensi
                                                                            Bahaya</label>
                                                                        <input type="text" name="potensi_bahaya"
                                                                            class="form-control" placeholder="Potensi Bahaya">
                                                                    </div>
                                                                    <hr>
                                                                    <div class="repeater-penilaian-risiko-potensi-bahaya">
                                                                        <div data-repeater-list="penilaian_risiko_potensi_bahaya">
                                                                            <div data-repeater-item="">
                                                                                <div class="mb-3">
                                                                                    <label for="" class="mb-2">Risiko
                                                                                        Bahaya</label>
                                                                                    <input type="text" name="risiko_bahaya"
                                                                                        class="form-control" placeholder="Risiko Bahaya">
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-4">
                                                                                        <div class="mb-3">
                                                                                            <label for="" class="mb-2">Jml
                                                                                                Kejadian Dalam
                                                                                                1
                                                                                                Periode Penilaian</label>
                                                                                            <input type="number" name="jumlah_kejadian"
                                                                                                class="form-control"
                                                                                                placeholder="Jumlah Kejadian">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <div class="mb-3">
                                                                                            <label for="" class="mb-2">Frekuensi
                                                                                                (Probability)</label>
                                                                                            <input type="number" name="frekuensi"
                                                                                                class="form-control"
                                                                                                placeholder="Frekuensi (Probability)">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <div class="mb-3">
                                                                                            <label for="" class="mb-2">Keparahan
                                                                                                (Severity)</label>
                                                                                            <input type="number" name="keparahan"
                                                                                                class="form-control"
                                                                                                placeholder="Keparahan (Severity)">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <button type="button" class="btn btn-danger" data-repeater-delete>
                                                                                    <span class="far fa-trash-alt"></span>
                                                                                </button>
                                                                                <hr>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button" class="btn btn-success"
                                                                                data-repeater-create><i
                                                                                    class="fas fa-plus"></i> Add
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="repeater-penilaian-pengendalian">
                                                    <div data-repeater-list="penilaian_pengendalian">
                                                        <div data-repeater-item="">
                                                            <div class="card">
                                                                <div class="card-header bg-dark">
                                                                    <div class="row align-items-center">
                                                                        <div class="col">
                                                                            <h5 class="card-title text-white">+ Pengendalian</h5>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <button type="button" class="btn btn-success"
                                                                                data-repeater-create=""><i class="fas fa-plus"></i></button>
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-repeater-delete=""><span
                                                                                    class="far fa-trash-alt"></span></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="mb-3">
                                                                        <label for="" class="mb-2">Upaya
                                                                            Pengendalian</label>
                                                                        <input type="text" name="pengendalian_upaya"
                                                                            class="form-control" placeholder="Upaya Pengendalian">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="" class="mb-2">Penilaian Pengendalian
                                                                            Berdasarkan
                                                                            Frekuensi Kejadian</label>
                                                                        <input type="text" name="pengendalian_penilaian"
                                                                            class="form-control" placeholder="Penilaian Pengendalian">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="repeater-penilaian-pic-wewenang">
                                                    <div data-repeater-list="pic_wewenang">
                                                        <div data-repeater-item="">
                                                            <div class="card">
                                                                <div class="card-header bg-dark">
                                                                    <div class="row align-items-center">
                                                                        <div class="col">
                                                                            <h5 class="card-title text-white">+ PIC / Wewenang</h5>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <button type="button" class="btn btn-success"
                                                                                data-repeater-create=""><i class="fas fa-plus"></i></button>
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-repeater-delete=""><span
                                                                                    class="far fa-trash-alt"></span></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <textarea name="pic_wewenang" class="form-control" cols="30" rows="5" placeholder="PIC / Wewenang"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="repeater-penilaian-regulasi">
                                                    <div data-repeater-list="regulasi">
                                                        <div data-repeater-item="">
                                                            <div class="card">
                                                                <div class="card-header bg-dark">
                                                                    <div class="row align-items-center">
                                                                        <div class="col">
                                                                            <h5 class="card-title text-white">+ Regulasi Terkait</h5>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <button type="button" class="btn btn-success"
                                                                                data-repeater-create=""><i class="fas fa-plus"></i></button>
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-repeater-delete=""><span
                                                                                    class="far fa-trash-alt"></span></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <textarea name="regulasi_terkait" class="form-control" cols="30" rows="5"
                                                                        placeholder="Regulasi Terkait"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            {{-- <div class="card-footer">
                                                <span data-repeater-delete="" class="btn btn-outline-danger">
                                                    <span class="far fa-trash-alt me-1"></span> Delete
                                                </span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('public/assets/js/pages/ckeditor.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    {{-- <script src="{{ asset('public/assets/js/pages/jquery.form-repeater.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            'use strict';

            $('.repeater-penilaian').repeater({
                repeaters: [
                    {
                        // (Required)
                        // Specify the jQuery selector for this nested repeater
                        selector: '.repeater-penilaian-risiko',
                        show: function() {
                            $(this).slideDown();
                        },
                    },
                    {
                        // (Required)
                        // Specify the jQuery selector for this nested repeater
                        selector: '.repeater-penilaian-risiko-potensi-bahaya',
                        show: function() {
                            $(this).slideDown();
                        },
                    },
                    {
                        selector: '.repeater-penilaian-pengendalian',
                        show: function() {
                            $(this).slideDown();
                        },
                    },
                    {
                        selector: '.repeater-penilaian-pic-wewenang',
                        show: function() {
                            $(this).slideDown();
                        },
                    },
                    {
                        selector: '.repeater-penilaian-regulasi',
                        show: function() {
                            $(this).slideDown();
                        },
                    },
                ],
                show: function() {
                    $(this).slideDown();
                },
                hide: function(remove) {
                    if (confirm('Are you sure you want to remove this item?')) {
                        $(this).slideUp(remove);
                    }
                }
            });

            // $('.repeater-penilaian-risiko').repeater({
            //     show: function() {
            //         $(this).slideDown();
            //     },
            //     hide: function(remove) {
            //         if (confirm('Are you sure you want to remove this item?')) {
            //             $(this).slideUp(remove);
            //         }
            //     }
            // });

            // $('.repeater-default').repeater();

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
    </script>
@endsection
