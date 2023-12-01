@extends('layouts.apps.master')
@section('title')
    {{ $rekap_pelatihan->tema }}
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
            Tambah Peserta Pelatihan / Seminar - @yield('title')
        @endslot
        @slot('title')
            Tambah Peserta Pelatihan / Seminar - @yield('title')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form id="form-update" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Start Date</label>
                                            <input type="datetime-local" value="{{ $start_date }}"
                                                class="form-control start_date" placeholder="Start Date" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">End Date</label>
                                            <input type="datetime-local" value="{{ $end_date }}"
                                                class="form-control end_date" placeholder="End Date" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tema Seminar</label>
                                            <input type="text" value="{{ $rekap_pelatihan->tema }}" class="form-control"
                                                placeholder="Tema Seminar / Pelatihan" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Penyelenggara</label>
                                            <input type="text" value="{{ $rekap_pelatihan->penyelenggara }}"
                                                class="form-control" placeholder="Penyelenggara" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Pelatihan / Seminar</label>
                                            <input type="text" value="{{ $rekap_pelatihan->jenis }}"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Total Peserta Hari Ini</label>
                                        <input type="text" name="total_peserta"
                                            value="{{ $rekap_pelatihan->total_peserta }}"
                                            class="form-control total_peserta">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Jumlah Hari Pelatihan</label>
                                        <input type="text" name="jml_hari" value="{{ $rekap_pelatihan->jml_hari }}"
                                            class="form-control jml_hari" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Jumlah Jam Pelatihan 1 Hari</label>
                                        <input type="text" name="jml_jam_dlm_hari"
                                            value="{{ $rekap_pelatihan->jml_jam_dlm_hari }}"
                                            class="form-control jml_jam_dlm_hari" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Total Hari Pelatihan * Jam</label>
                                        <input type="text" name="total_hari" class="form-control total_hari" readonly>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Tambah Peserta</label><br>
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
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Data Peserta:</h5>
                                <table id="datatables" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Nama Peserta</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                                {{-- @php
                                    dd($rekap_pelatihan_seminar_pesertas);
                                @endphp --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('rekap_pelatihan.rekap_pelatihan') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.datatable.init.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/timepicker/bootstrap-material-datetimepicker.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}">
    </script>
    <script src="{{ URL::asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>

    <script>
        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('rekap_pelatihan.rekap_pelatihan_edit',['id' => $rekap_pelatihan->id]) }}",
            columns: [
                {
                    data: 'peserta',
                    name: 'peserta'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        $(document).ready(function() {
            $(".tambah_peserta").select2({
                tags: true
            });
            const jumlah_hari_pelatihan = $('.jml_hari').val();
            const jumlah_jam_dlm_hari = $('.jml_jam_dlm_hari').val();
            const hasil_jumlah = jumlah_hari_pelatihan * jumlah_jam_dlm_hari;
            $('.total_hari').val(hasil_jumlah);

            const jml_hari = $('.jml_hari').val();
            const jml_jam_dlm_hari = $('.jml_jam_dlm_hari').val();
            const hitung_total_pelatihan_kali_jam = jml_hari * jml_jam_dlm_hari;

        })

        // $('.jml_jam_dlm_hari').change(function() {
        //     const jml_hari = $('.jml_hari').val();
        //     const jml_jam_dlm_hari = $('.jml_jam_dlm_hari').val();
        //     const hasil = jml_hari * jml_jam_dlm_hari;
        //     $('.total_hari').val(hasil);
        // })

        // $('.status').change(function() {
        //     const jml_jam_dlm_hari = document.getElementsByClassName("jml_jam_dlm_hari");
        //     if ($('.status').val() == 'Plan') {
        //         jml_jam_dlm_hari[0].readOnly = true;
        //         $('.jml_jam_dlm_hari').val(0);
        //     } else {
        //         jml_jam_dlm_hari[0].readOnly = false;
        //         $('.jml_jam_dlm_hari').val(null);
        //     }
        // })

        // $('.jml_jam_dlm_hari').change(function() {
        //     const jml_hari = $('.jml_hari').val();
        //     const jml_jam_dlm_hari = $('.jml_jam_dlm_hari').val();
        //     const hitung_total_pelatihan_kali_jam = jml_hari * jml_jam_dlm_hari;
        //     $('.total_hari').val(hitung_total_pelatihan_kali_jam);
        // })

        // $('.total_peserta').change(function() {
        //     const total_pelatihan_kali_jam = $('.total_hari').val();
        //     const total_peserta = $('.total_peserta').val();
        //     const hitung_total_jam_peserta = total_pelatihan_kali_jam * total_peserta;
        //     $('.total_jam_peserta').val(hitung_total_jam_peserta);
        // })

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('rekap_pelatihan.rekap_pelatihan_tambah_peserta_update',$rekap_pelatihan->id) }}",
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
                            // $('.modalLoading').modal('hide');
                            window.location.href = "{{ route('rekap_pelatihan.rekap_pelatihan') }}";
                        }, 1000);
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

        function hapus_peserta(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('rekap_pelatihan/') }}"+'/'+'{{ $rekap_pelatihan->id }}'+'/'+id+'/'+'delete',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        table.ajax.reload();
                    } else {
                        iziToast.error({
                            title: result.message_title,
                            message: result.message_content
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
        }
    </script>
@endsection
