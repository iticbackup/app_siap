@extends('layouts.apps.master')
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('title')
    Buat Data Karyawan Baru
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
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="card-title text-white">@yield('title')</div>
                </div>
                <form id="form-simpan" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">NIK</label>
                                <input type="text" name="nik" class="form-control" placeholder="NIK" id="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="">Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama" id="">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mb-3">
                                <label for="">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir"
                                    id="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir"
                                    id="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control" id="">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki - Laki">Laki - Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">No. NPWP</label>
                                <input type="text" name="no_npwp" class="form-control" placeholder="No. NPWP"
                                    id="">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="">Alamat</label>
                        <textarea name="alamat" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">Posisi</label>
                                <select name="posisi" class="form-control" id="">
                                    <option value="">-- Pilih Posisi --</option>
                                    @foreach ($posisis as $posisi)
                                        <option value="{{ $posisi->id_posisi }}">{{ $posisi->nama_posisi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">Jabatan</label>
                                <select name="jabatan" class="form-control" id="">
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id_jabatan }}">{{ $jabatan->nama_jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">Departemen</label>
                                <select name="departemen" class="form-control" id="">
                                    <option value="">-- Pilih Departemen --</option>
                                    @foreach ($departemens as $departemen)
                                        <option value="{{ $departemen->id_departemen }}">
                                            {{ $departemen->nama_departemen >= 2 ? $departemen->nama_unit : $departemen->nama_departemen }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">No. Rekening Mandiri</label>
                                <input type="text" name="no_rekening_mandiri" class="form-control"
                                    placeholder="No. Rekening Mandiri" id="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">No. Rekening BWS</label>
                                <input type="text" name="no_rekening_bws" class="form-control"
                                    placeholder="No. Rekening BWS" id="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">Status Keluarga</label>
                                <input type="text" name="status_klg" class="form-control"
                                    placeholder="Status Keluarga" id="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">PIN</label>
                                <input type="text" name="pin" class="form-control" placeholder="PIN"
                                    value="{{ $pin + 1 }}" readonly id="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">Kewarganegaraan</label>
                                <input type="text" name="kewarganegaraan" class="form-control"
                                    placeholder="Kewarganegaraan" id="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">Agama</label>
                                <select name="agama" class="form-control" id="">
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Khatolik">Khatolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('hrga.biodata_karyawan') }}" class="btn btn-secondary">Back</a>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.sweet-alert.init.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            Swal.fire({
                title: 'Apakah sudah yakin?',
                // text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '$success',
                cancelButtonColor: '$danger',
                confirmButtonText: 'Yes'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('hrga.biodata_karyawan.buat_karyawan_baru.simpan') }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Proses...',
                                text: 'Data sedang diproses',
                                imageHeight: 80,
                                animation: false,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            })
                        },
                        success: (result) => {
                            if (result.success == true) {
                                Swal.fire(
                                    result.message_title,
                                    result.message_content,
                                    'success'
                                );
                                location.reload();
                                // location.href('{{ route('hrga.biodata_karyawan') }}')
                            } else {
                                var error = result.error;
                                var txt_error = ""
                                error.forEach(fun_error);

                                function fun_error(value, index) {
                                    txt_error += value;
                                }

                                Swal.fire(
                                    'Gagal!',
                                    txt_error,
                                    'error'
                                )
                            }
                        },
                        error: function(request, status, error) {
                            Swal.fire(
                                'Error',
                                error,
                                'error'
                            );
                        }
                    });
                }
            })
        });
    </script>
@endsection
