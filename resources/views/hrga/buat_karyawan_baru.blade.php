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
                                <div class="form-floating mb-3">
                                    <input type="text" id="nik" name="nik" class="form-control" placeholder="NIK">
                                    <label for="nik">NIK Karyawan</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="text" id="nama_karyawan" name="nama" class="form-control" placeholder="Nama">
                                    <label for="nama_karyawan">Nama Karyawan</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-floating mb-3">
                                    <input type="text" name="tempat_lahir" class="form-control"
                                    placeholder="Tempat Lahir" id="tempat_lahir">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                    placeholder="Tanggal Lahir" id="tanggal_lahir">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <select name="jenis_kelamin" class="form-control" id="jenis_kelamin">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki - Laki">Laki - Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="text" name="no_npwp" class="form-control" placeholder="No. NPWP"
                                    id="no_npwp">
                                    <label for="no_npwp">No. NPWP</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="alamat" placeholder="Alamat" id="alamat"></textarea>
                                    <label for="alamat">Alamat</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="text" name="kelurahan" class="form-control" placeholder="Kelurahan"
                                    id="kelurahan">
                                    <label for="kelurahan">Kelurahan</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan"
                                    id="kecamatan">
                                    <label for="kecamatan">Kecamatan</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="text" name="kab_kota" class="form-control" placeholder="Kab/Kota"
                                    id="kab_kota">
                                    <label for="kab_kota">Kab/Kota</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    {{-- <input type="text" name="provinsi" class="form-control" placeholder="Provinsi"
                                    id="provinsi"> --}}
                                    <select name="provinsi" class="form-control provinsi" id="provinsi">
                                    </select>
                                    <label for="provinsi">Provinsi</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <select name="posisi" class="form-control" id="posisi">
                                        <option value="">-- Pilih Posisi --</option>
                                        @foreach ($posisis as $posisi)
                                            <option value="{{ $posisi->id }}">{{ $posisi->nama_posisi }}</option>
                                        @endforeach
                                    </select>
                                    <label for="posisi">Posisi</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <select name="jabatan" class="form-control" id="jabatan">
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                        @endforeach
                                    </select>
                                    <label for="jabatan">Jabatan</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <div class="form-floating mb-3">
                                        <select name="departemen" class="form-control" id="departemen">
                                            <option value="">-- Pilih Departemen --</option>
                                            @foreach ($departemens as $departemen)
                                            <option value="{{ $departemen->id }}">{{ $departemen->nama_departemen }}</option>
                                            @endforeach
                                        </select>
                                        <label for="departemen">Departemen</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2" id="view_departemen_bagian">
                                <div class="form-floating mb-3">
                                    <select name="departemen_bagian" class="form-control" id="departemen_bagian">  
                                    </select>
                                    <label for="departemen_bagian">Departemen Bagian</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="text" name="no_rekening_mandiri" class="form-control"
                                    placeholder="No. Rekening Mandiri" id="rekening_mandiri">
                                    <label for="rekening_mandiri">No. Rekening Mandiri</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="text" name="no_rekening_bws" class="form-control"
                                    placeholder="No. Rekening BWS" id="rekening_bws">
                                    <label for="rekening_bws">No. Rekening BWS</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="text" name="no_rekening_bca" class="form-control"
                                    placeholder="No. Rekening BCA" id="rekening_bca">
                                    <label for="rekening_bca">No. Rekening BCA</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-floating mb-3">
                                    <input type="text" name="status_klg" class="form-control"
                                    placeholder="Status Keluarga" id="status_keluarga">
                                    <label for="status_keluarga">Status Keluarga</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-floating mb-3">
                                    <input type="text" name="pin" class="form-control" placeholder="PIN"
                                    value="{{ $pin + 1 }}" readonly id="pin">
                                    <label for="pin">PIN</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="text" name="kewarganegaraan" class="form-control"
                                    placeholder="Kewarganegaraan" id="kewarganegaraan">
                                    <label for="kewarganegaraan">Kewarganegaraan</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <select name="agama" class="form-control" id="agama">
                                        <option value="">-- Pilih Agama --</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Khatolik">Khatolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                    <label for="agama">Agama</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="date" name="tanggal_masuk" class="form-control" id="tanggal_masuk">
                                    <label for="tanggal_masuk">Tanggal Masuk</label>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"
        integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#departemen').on('click', function() {
            axios.post('{{ route("hrga.biodata_karyawan.get_departemen_bagian") }}', {
                    id: $(this).val()
                })
                .then(function(response) {
                    $('#departemen_bagian').empty();
                    if (!response.data) {
                        $('#departemen_bagian').append(new Option(null,null));
                    }else{
                        $.each(response.data, function(id, value) {
                            $('#departemen_bagian').append(new Option(value.nama_bagian, value.id));
                        })
                    }
                });
        });

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            Swal.fire({
                title: 'Apakah sudah yakin?',
                // text: "You won't be able to revert this!",
                type: 'warning',
                html: `
                    <table class="table" style="font-size: 10pt">
                        <tr>
                            <td style="text-align:left">NIK Karyawan</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#nik').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Nama Karyawan</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#nama_karyawan').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Tempat, Tanggal Lahir</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#tempat_lahir').val()+', '+$('#tanggal_lahir').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Jenis Kelamin</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#jenis_kelamin').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">No. NPWP</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#no_npwp').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Alamat</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#alamat').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Kelurahan</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#kelurahan').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Kecamatan</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#kecamatan').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Kab/Kota</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#kab_kota').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Provinsi</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#provinsi').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">No. Rekening Mandiri</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#rekening_mandiri').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">No. Rekening BWS</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#rekening_bws').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">No. Rekening BCA</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#rekening_bca').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Status Keluarga</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#status_keluarga').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">PIN</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#pin').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Kewarganegaraan</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#kewarganegaraan').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Agama</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#agama').val()}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Tanggal Masuk</td>
                            <td style="text-align:left">:</td>
                            <td style="text-align:left">${$('#tanggal_masuk').val()}</td>
                        </tr>
                    </table>
                `,
                showCancelButton: true,
                confirmButtonColor: '$success',
                cancelButtonColor: '$danger',
                scrollbarPadding: true,
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
                            // Swal.fire({
                            //     title: 'Proses...',
                            //     text: 'Data sedang diproses',
                            //     imageHeight: 80,
                            //     animation: false,
                            //     showConfirmButton: false,
                            //     allowOutsideClick: false,
                            //     allowEscapeKey: false
                            // })
                            $('#loadingscreen').modal('show');
                        },
                        success: (result) => {
                            if (result.success == true) {
                                Swal.fire(
                                    result.message_title,
                                    result.message_content,
                                    'success'
                                );
                                // location.reload();
                                setTimeout(() => {
                                    // $('.modalLoading').modal('hide');
                                    $('#loadingscreen').modal('hide');
                                    window.location.href =
                                        "{{ route('hrga.biodata_karyawan') }}";
                                }, 3000);
                                // location.href('{{ route('hrga.biodata_karyawan') }}')
                            } else {
                                $('#loadingscreen').modal('hide');
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

        function getProvinsi()
        {
            axios.post('https://alamat.thecloudalert.com/api/provinsi/get/')
                .then(function(response) {
                    // console.log(response.data.result)
                    $('.provinsi').empty();
                    if (!response.data.result) {
                        $('.provinsi').append(new Option(null,null));
                    }else{
                        $.each(response.data.result, function(id, value) {
                            $('.provinsi').append(new Option(value.text, value.text));
                        })
                    }
                });
        }

        $(document).ready(function(){
            getProvinsi()
        });
    </script>
@endsection
