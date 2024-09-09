@extends('layouts.apps.master')
@section('title')
    Buat Sertifikasi Mesin Produksi
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form id="form-simpan" method="post" enctype="multipart/form-data">
                    @csrf
                    <table class="table">
                        <tr>
                            <td>Jenis Mesin</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="jenis_mesin" class="form-control" placeholder="Jenis Mesin">
                            </td>
                        </tr>
                        <tr>
                            <td>No. Sertifikat</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="no_sertifikat" class="form-control"
                                    placeholder="No. Sertifikat">
                            </td>
                        </tr>
                        <tr>
                            <td>Tgl Sertifikat Pertama</td>
                            <td>:</td>
                            <td>
                                <input type="date" name="tgl_sertifikat_pertama" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>Periode Resertifikasi</td>
                            <td>:</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" name="periode_resertifikasi" class="form-control">
                                    <label class="input-group-text">Tahun</label>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-secondary"
                            onclick="window.location.href='{{ url()->previous() }}'">Back</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script>
        // t("#sa-auto-close").click(function() {
        //     var t;
        //     Swal.fire({
        //         title: "Auto close alert!",
        //         html: "I will close in <strong></strong> seconds.",
        //         timer: 2e3,
        //         onBeforeOpen: function() {
        //             Swal.showLoading(), t = setInterval(function() {
        //                 Swal.getContent().querySelector("strong").textContent = Swal
        //                     .getTimerLeft()
        //             }, 100)
        //         },
        //         onClose: function() {
        //             clearInterval(t)
        //         }
        //     }).then(function(t) {
        //         t.dismiss === Swal.DismissReason.timer && console.log("I was closed by the timer")
        //     })
        // });

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('hrga.sertifikasi.mesin_produksi.simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    Swal.fire({
                        title: "Silahkan Tunggu!",
                        html: "Data Sedang Diproses",
                        onBeforeOpen: function() {
                            Swal.showLoading(), t = setInterval(function() {
                                Swal.getContent().querySelector("strong").textContent = Swal
                                    .getTimerLeft()
                            }, 100)
                        },
                        onClose: function() {
                            clearInterval(t)
                        }
                    }).then(function(t) {
                        t.dismiss === Swal.DismissReason.timer && console.log("I was closed by the timer")
                    })
                },
                success: (result) => {
                    if (result.success != false) {
                        // iziToast.success({
                        //     title: result.message_title,
                        //     message: result.message_content
                        // });
                        Swal.fire({
                            icon: "success",
                            title: result.message_title,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            window.location.href="{{ route('hrga.sertifikasi.mesin_produksi') }}"
                        }, 1500);
                    } else {
                        // iziToast.error({
                        //     title: result.success,
                        //     message: result.error
                        // });
                        Swal.fire({
                            icon: "error",
                            title: result.message_title,
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
