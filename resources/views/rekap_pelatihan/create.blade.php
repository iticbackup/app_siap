@extends('layouts.apps.master')
@section('title')
    Buat Rekap Pelatihan & Seminar
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ URL::asset('public/assets/plugins/huebee/huebee.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ URL::asset('public/assets/plugins/timepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            margin-top: 7px;
            background-color: #1A5D1A;
            /* border: 1px solid #e3ebf6; */
            /* color: #fff; */
        }
    </style>
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
                <form id="form-simpan" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body bootstrap-select-1">
                        <label class="form-label">Tanggal</label>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="">Start Date</label>
                                    <input type="datetime-local" name="start_date" class="form-control start_date"
                                        placeholder="Start Date">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="">End Date</label>
                                    <input type="datetime-local" name="end_date" class="form-control end_date"
                                        placeholder="End Date">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="">Apakah Pelatihan dilaksanakan selama 2 hari?</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input check_date_yes" type="radio" name="check_date" value="yes" id="inlineRadio1">
                                        <label class="form-check-label" for="inlineRadio1">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input check_date_no" type="radio" name="check_date" value="no" id="inlineRadio2">
                                        <label class="form-check-label" for="inlineRadio2">Tidak</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Tema Seminar</label>
                                    <input type="text" name="tema" class="form-control"
                                        placeholder="Tema Seminar / Pelatihan">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Penyelenggara</label>
                                    <input type="text" name="penyelenggara" class="form-control"
                                        placeholder="Penyelenggara">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Pelatihan / Seminar</label>
                                    <select name="jenis" class="form-control" id="">
                                        <option value="">-- Pilih Jenis Pelatihan --</option>
                                        @foreach ($rekap_kategoris as $rk)
                                            <option value="{{ $rk->kategori }}">{{ $rk->kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Kategori Pelatihan / Seminar</label>
                                    <select name="kategori_pelatihan" class="form-control" id="">
                                        <option value="">-- Pilih Kategori Pelatihan --</option>
                                        <option value="Internal">Internal</option>
                                        <option value="Eksternal">Eksternal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control status" id="">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Plan">Rencana</option>
                                        <option value="Done">Selesai</option>
                                    </select>
                                    {{-- <input type="text" name="total_peserta" class="form-control"> --}}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jumlah Hari Pelatihan</label>
                                <input type="text" name="jml_hari" class="form-control jml_hari">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jumlah Jam Pelatihan 1 Hari</label>
                                <input type="text" name="jml_jam_dlm_hari" class="form-control jml_jam_dlm_hari">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Total Hari Pelatihan * Jam</label>
                                <input type="text" name="total_hari" class="form-control total_hari" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Total Jumlah Peserta</label>
                                    <input type="text" name="total_peserta" class="form-control total_peserta">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Peserta</label><br>
                                    <select name="peserta[]" class="select2 mb-3 select2-multiple tambah_peserta" style="width: 100%" id=""
                                        multiple="multiple" data-placeholder="Choose">
                                        @foreach ($departemens as $departemen)
                                            @php
                                                $departemen_users = \App\Models\DepartemenUser::where('departemen_id', $departemen->id)->get();
                                            @endphp
                                            <optgroup label="{{ $departemen->departemen }}">
                                                @foreach ($departemen_users as $departemen_user)
                                                    <option value="{{ $departemen_user->team }}">{{ $departemen_user->team }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <input type="text" name="total_peserta" class="form-control"> --}}
                                {{-- <div class="repeater-default">
                                <div data-repeater-list="peserta">
                                    <div data-repeater-item="">
                                        <div class="form-group row d-flex align-items-end">
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <select name="departemen" class="form-control departemen" id="">
                                                        <option value="">-- Pilih Departemen --</option>
                                                        @foreach ($departemens as $departemen)
                                                            <option value="{{ $departemen->id }}">{{ $departemen->departemen }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" class="btn btn-outline-primary"><i class="fas fa-search"></i> Cari Peserta</button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <select class="form-control peserta" id="">
                                                    <option value="">-- Pilih Nama Peserta --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0 row">
                                    <div class="col-sm-12">
                                        <span data-repeater-create="" class="btn btn-outline-primary">
                                            <span class="fas fa-plus"></span> Add
                                        </span>
                                    </div>
                                </div>
                            </div> --}}
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Total Jam Peserta</label>
                                    <input type="text" class="form-control total_jam_peserta" readonly>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('rekap_pelatihan.rekap_pelatihan') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/plugins/timepicker/bootstrap-material-datetimepicker.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}">
    </script>
    <script src="{{ URL::asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.forms-advanced.js') }}"></script>
    {{-- <script src="{{ URL::asset('public/assets/plugins/huebee/huebee.pkgd.min.js') }}"></script> --}}
    <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $(".tambah_peserta").select2({
                tags: true
            });
            const jumlah_hari_pelatihan = $('.jml_hari').val();
            const jumlah_jam_dlm_hari = $('.jml_jam_dlm_hari').val();
            $('.total_hari').val(jumlah_hari_pelatihan * jumlah_jam_dlm_hari);
        })
        // $('.end_date').change(function(){
            // alert($('.check_date'));
        $('.check_date_yes').on('click',function(){
            // alert($('.check_date_yes').val());
            $('.jml_hari').val(2);
        })
        $('.check_date_no').on('click',function(){
            // alert($('.check_date_no').val());
            const start_date = new Date($('.start_date').val());
            const end_date = new Date($('.end_date').val());
            const one_day = 1000 * 60 * 60 * 24;
            const differenceMs = Math.abs(end_date.getTime() - start_date.getTime());
            const hasil_hari = Math.round(differenceMs / one_day) + 1;

            $('.jml_hari').val(hasil_hari);
        })
        // $('.check_date').change(function(){
        //     if ($('.check_date').val() == 'yes') {
        //         $('.jml_hari').val(2);
        //     }else{
        //         const start_date = new Date($('.start_date').val());
        //         const end_date = new Date($('.end_date').val());
        //         const one_day = 1000 * 60 * 60 * 24;
        //         const differenceMs = Math.abs(end_date.getTime() - start_date.getTime());
        //         const hasil_hari = Math.round(differenceMs / one_day) + 1;

        //         $('.jml_hari').val(hasil_hari);
        //     }
        // })
        // $('.end_date').change(function() {
        //     const start_date = new Date($('.start_date').val());
        //     const end_date = new Date($('.end_date').val());
        //     const one_day = 1000 * 60 * 60 * 24;
        //     const differenceMs = Math.abs(end_date.getTime() - start_date.getTime());
        //     const hasil_hari = Math.round(differenceMs / one_day) + 1;

        //     $('.jml_hari').val(hasil_hari);

        //     // var end_day = end_date.getDay();
        //     // var ans = (end_day === 7 || end_day === 0);
        //     // if (ans) {
        //     //     alert(Math.round(differenceMs / one_day));
        //     // }else{
        //     //     alert(Math.round(differenceMs / one_day)+1);
        //     // }
        //     // var day = start_date.getDay();
        //     // var ans = (day === 7 || day === 0);

        //     // if (ans) {
        //     //     ans = "Today is Weekend.";
        //     // } else {
        //     //     ans = "Today is not Weekend.";
        //     // }
        //     // console.log(ans);
        //     // alert(differenceMs);
        //     // console.log(differenceMs);
        //     // alert($('.start_date').val());
        // })

        $('.jml_jam_dlm_hari').change(function() {
            const jml_hari = $('.jml_hari').val();
            const jml_jam_dlm_hari = $('.jml_jam_dlm_hari').val();
            const hasil = jml_hari * jml_jam_dlm_hari;
            $('.total_hari').val(hasil);
        })

        $('.status').change(function() {
            const jml_jam_dlm_hari = document.getElementsByClassName("jml_jam_dlm_hari");
            if ($('.status').val() == 'Plan') {
                jml_jam_dlm_hari[0].readOnly = true;
                $('.jml_jam_dlm_hari').val(0);
            } else {
                jml_jam_dlm_hari[0].readOnly = false;
                $('.jml_jam_dlm_hari').val(null);
            }
        })

        $('.jml_jam_dlm_hari').change(function() {
            const jml_hari = $('.jml_hari').val();
            const jml_jam_dlm_hari = $('.jml_jam_dlm_hari').val();
            const hitung_total_pelatihan_kali_jam = jml_hari * jml_jam_dlm_hari;
            $('.total_hari').val(hitung_total_pelatihan_kali_jam);
        })

        $('.total_peserta').change(function() {
            const total_pelatihan_kali_jam = $('.total_hari').val();
            const total_peserta = $('.total_peserta').val();
            const hitung_total_jam_peserta = total_pelatihan_kali_jam * total_peserta;
            $('.total_jam_peserta').val(hitung_total_jam_peserta);
        })
    </script>
    <script>
        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('rekap_pelatihan.simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
                },
                success: (result) => {
                    if (result.success != false) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        setTimeout(() => {
                            $('.modalLoading').modal('hide');
                            window.location.href =
                                "{{ route('rekap_pelatihan.rekap_pelatihan') }}";
                        }, 3000);
                    } else {
                        iziToast.error({
                            title: result.success,
                            message: result.error
                        });
                    }
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        });
    </script>
@endsection
