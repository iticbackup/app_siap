@extends('layouts.absensi.new.master')
@section('title')
    Absensi - Ijin / Terlambat
@endsection
@section('content')
    <div class="page-title-container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h1 class="mb-0 pb-0 display-4" id="title">Absensi - Ijin / Terlambat</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="{{ route('absensi.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ijin_terlambat') }}">Absensi - Ijin / Terlambat</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    @include('absensi.ijin_terlambat.new.modalBuat')
    @include('absensi.ijin_terlambat.new.modalEdit')

    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <button onclick="buat()" class="btn btn-primary">Buat Baru</button>
                </div>
                <div class="col-auto">
                    <form action="{{ route('ijin_terlambat.search') }}" method="get">
                        <div class="input-group">
                            <div class="mb-3">
                                <label for="">Cari NIK / Karyawan</label>
                                <input type="search" name="cari" class="form-control"
                                    value="{{ !empty(request('cari')) ? request('cari') : null }}" placeholder="Search..."
                                    id="">
                            </div>
                            <div class="mb-3">
                                <label for="">Mulai Tanggal</label>
                                <input type="date" name="cari_tanggal_awal" class="form-control"
                                    value="{{ !empty(request('cari_tanggal_awal')) ? request('cari_tanggal_awal') : null }}"
                                    id="">
                            </div>
                            <div class="mb-3">
                                <label for="">Sampai Tanggal</label>
                                <input type="date" name="cari_tanggal_akhir" class="form-control"
                                    value="{{ !empty(request('cari_tanggal_akhir')) ? request('cari_tanggal_akhir') : null }}"
                                    id="">
                            </div>
                            <div class="mb-3">
                                <br>
                                <button class="btn btn-primary" type="submit"><i class="bx bxs-search bx-sm bx-tada"></i>
                                    Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 15%">Karyawan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Jam Datang</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ijin_terlambats as $ijin_terlambat)
                    @php
                        $cek_status_kerja = \App\Models\IticDepartemen::where('id', $ijin_terlambat->biodata_karyawan->id_departemen)->first();
                        if (empty($cek_status_kerja)) {
                            $satuan_kerja = '-';
                        } else {
                            $satuan_kerja = $cek_status_kerja->nama_departemen;
                        }

                        $cek_posisi = \App\Models\EmpPosisi::where('id', $ijin_terlambat->biodata_karyawan->id_posisi)->first();
                        if (empty($cek_posisi)) {
                            $posisi = '-';
                        } else {
                            $posisi = $cek_posisi->nama_posisi;
                        }
                    @endphp
                    <tr>
                        <td style="vertical-align: middle">
                            <div class="d-flex align-items-center flex-column">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="profile"
                                        src="{{ asset('public/berkas/HRGA/data_karyawan/' . $ijin_terlambat->biodata_karyawan->foto_karyawan) }}"
                                        style="border-radius: 50%; width: 60px; height: 60px; object-fit: cover;">
                                    <div>{{ $ijin_terlambat->biodata_karyawan->nik }}</div>
                                    <div>{{ $ijin_terlambat->biodata_karyawan->nama }}</div>
                                    <div>{{ $satuan_kerja . ' - ' . $posisi }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center" style="vertical-align: middle">
                            {{ \Carbon\Carbon::create($ijin_terlambat->scan_date)->isoFormat('LL') }}
                        </td>
                        <td class="text-center" style="vertical-align: middle">
                            @if (!empty($ijin_terlambat->presensi_status->status_info))
                                {{ $ijin_terlambat->presensi_status->status_info }}
                            @else
                            -
                            @endif
                        </td>
                        <td class="text-center" style="vertical-align: middle">
                            @if (
                                $ijin_terlambat->presensi_status->status_id == 4 ||
                                $ijin_terlambat->presensi_status->status_id == 13
                            )
                                -
                            @else
                            {{ \Carbon\Carbon::create($ijin_terlambat->scan_date)->format('H:i') }}
                            @endif
                        </td>
                        <td class="text-center" style="vertical-align: middle">
                            <div class="btn-group">
                                <button onclick="edit(`{{ $ijin_terlambat->att_rec }}`)"
                                    class="btn btn-warning"><i
                                        class="bx bx-edit"></i> Edit</button>
                                <button onclick="hapus(`{{ $ijin_terlambat->att_rec }}`)"
                                    class="btn btn-danger"><i
                                        class="bx bx-trash"></i> Delete</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="5">Data Belum Tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $ijin_terlambats->links('vendor.pagination.paginationAcorn') }}
        </div>
    </div>
@endsection
@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function buat() {
            $('.modalBuatIjinTerlambat').modal('show');
        }

        $('#btn-search').on('click', function() {
            $('#result').html('');
            var searchField = $('.nama_karyawan').val();
            var expression = new RegExp(searchField, "i");
            $.getJSON('{{ route('hrga.data_karyawan') }}', function(data) {
                $.each(data, function(key, value) {
                    if (value.nama.search(expression) != -1) {
                        $('#result').append('<li class="list-group-item link-class">' +
                            value.nama + ' | ' + value.nik + '</li>');
                    };
                });
            });
        })

        $('#result').on('click', 'li', function() {
            var click_text = $(this).text().split('|');
            $('.nama_karyawan').val($.trim(click_text[0]));
            $('.nik').val($.trim(click_text[1]));
            // alert(click_text[1])
            $("#result").html('');
        });

        function edit(att_rec) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/ijin_terlambat') }}" + '/' + att_rec,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        $('#edit_att_rec').val(result.data.att_rec);
                        $('#edit_nik').val(result.data.biodata_karyawan.nik);
                        $('#edit_nama_karyawan').val(result.data.biodata_karyawan.nama);
                        var scan_date = result.data.scan_date;
                        const array_scan_date = scan_date.split(" ");

                        var waktu = array_scan_date[1];
                        const array_waktu = waktu.split(":");
                        $('#edit_tanggal').val(array_scan_date[0]);
                        $('#edit_waktu_datang_jam').val(array_waktu[0]);
                        $('#edit_waktu_datang_menit').val(array_waktu[1]);
                        $('#edit_status').val(result.data.status);

                        var keterangan = result.data.keterangan;
                        const array_keterangan = keterangan.split("@");

                        const array_jam_masuk = array_keterangan[1].split(":");
                        const array_jam_istirahat = array_keterangan[2].split(":");
                        const array_jam_pulang = array_keterangan[3].split(":");

                        $('#edit_jam_masuk_jam').val(array_jam_masuk[0]);
                        $('#edit_jam_masuk_menit').val(array_jam_masuk[1]);
                        $('#edit_jam_istirahat_jam').val(array_jam_istirahat[0]);
                        $('#edit_jam_istirahat_menit').val(array_jam_istirahat[1]);
                        $('#edit_jam_pulang_jam').val(array_jam_pulang[0]);
                        $('#edit_jam_pulang_menit').val(array_jam_pulang[1]);
                        $('#edit_keterangan').val(array_keterangan[0]);
                        $('.modalEditIjinTerlambat').modal('show');
                    } else {
                        jQuery.notify({
                            title: 'Gagal!',
                            message: result.message_content
                        }, {
                            type: 'danger',
                            showProgressbar: true
                        });
                    }
                },
                error: function(request, status, error) {
                    jQuery.notify({
                        title: 'Error!',
                        message: error
                    }, {
                        type: 'danger',
                        showProgressbar: true
                    });
                }
            });
        }

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('ijin_terlambat.simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                },
                success: (result) => {
                    if (result.success != false) {
                        // Lobibox.notify('success', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-check-circle',
                        //     msg: result.message_content
                        // });
                        jQuery.notify({
                            title: 'Berhasil!',
                            message: result.message_content
                        }, {
                            type: 'success',
                            showProgressbar: true
                        });
                        location.reload();
                        $('.modalBuatIjinTerlambat').modal('hide');
                    } else {
                        var error = result.error;
                        var error_txt = "";
                        error.forEach(fungsi_error);
                        function fungsi_error(value, index){
                            error_txt += value+'<br>';
                        }
                        // Lobibox.notify('error', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-x-circle',
                        //     msg: error_txt
                        // });
                        jQuery.notify({
                            title: 'Gagal!',
                            message: error_txt
                        }, {
                            type: 'danger',
                            showProgressbar: true
                        });
                    }
                },
                error: function(request, status, error) {
                    // Lobibox.notify('error', {
                    //     pauseDelayOnHover: true,
                    //     continueDelayOnInactiveTab: false,
                    //     position: 'top right',
                    //     icon: 'bx bx-x-circle',
                    //     msg: error
                    // });
                    jQuery.notify({
                        title: 'Error!',
                        message: error
                    }, {
                        type: 'danger',
                        showProgressbar: true
                    });
                }
            });
        });

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('ijin_terlambat.update') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                },
                success: (result) => {
                    if (result.success != false) {
                        // Lobibox.notify('success', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-check-circle',
                        //     msg: result.message_content
                        // });
                        jQuery.notify({
                            title: 'Berhasil!',
                            message: result.message_content
                        }, {
                            type: 'success',
                            showProgressbar: true
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                        // setTimeout(location.reload(), 5000);
                        $('.modalEditIjinTerlambat').modal('hide');
                    } else {
                        var error = result.error;
                        var error_txt = "";
                        error.forEach(fungsi_error);
                        function fungsi_error(value, index){
                            error_txt += value+'<br>';
                        }
                        // Lobibox.notify('error', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-x-circle',
                        //     msg: error_txt
                        // });
                        jQuery.notify({
                            title: 'Gagal!',
                            message: error_txt
                        }, {
                            type: 'danger',
                            showProgressbar: true
                        });
                        
                    }
                },
                error: function(request, status, error) {
                    jQuery.notify({
                        title: 'Error!',
                        message: error
                    }, {
                        type: 'danger',
                        showProgressbar: true
                    });
                }
            });
        });

        function hapus(att_rec) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/ijin_terlambat') }}" + "/" + att_rec + "/" + "delete",
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
                },
                success: (result) => {
                    if (result.success != false) {
                        // alert(result.message_content);
                        // Lobibox.notify('success', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-check-circle',
                        //     msg: result.message_content
                        // });
                        jQuery.notify({
                            title: 'Berhasil!',
                            message: result.message_content
                        }, {
                            type: 'success',
                            showProgressbar: true
                        });
                        // table.ajax.reload(null, false);
                        location.reload();
                    } else {
                        // Lobibox.notify('error', {
                        //     pauseDelayOnHover: true,
                        //     continueDelayOnInactiveTab: false,
                        //     position: 'top right',
                        //     icon: 'bx bx-x-circle',
                        //     msg: result.message_content
                        // });
                        jQuery.notify({
                            title: 'Gagal!',
                            message: result.message_content
                        }, {
                            type: 'danger',
                            showProgressbar: true
                        });
                    }
                },
                error: function(request, status, error) {
                    // Lobibox.notify('error', {
                    //     pauseDelayOnHover: true,
                    //     continueDelayOnInactiveTab: false,
                    //     position: 'top right',
                    //     icon: 'bx bx-x-circle',
                    //     msg: error
                    // });
                    jQuery.notify({
                        title: 'Gagal!',
                        message: error_txt
                    }, {
                        type: 'danger',
                        showProgressbar: true
                    });
                }
            });
        }
    </script>
@endsection