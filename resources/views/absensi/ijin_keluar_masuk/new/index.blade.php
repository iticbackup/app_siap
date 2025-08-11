@extends('layouts.absensi.new.master')
@section('title')
    Absensi - Ijin Keluar Masuk / Ijin Jam Kerja
@endsection
@section('css')
    {{-- <style>
        tr:nth-child(odd) {
            background-color: #f4f9ff;
        }

        tr:nth-child(even) {
            background-color: #ffffff;
        }
    </style> --}}
@endsection
@section('content')
    @include('absensi.ijin_keluar_masuk.new.modalBuat')
    @include('absensi.ijin_keluar_masuk.new.modalEdit')
    <div class="page-title-container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h1 class="mb-0 pb-0 display-4" id="title">Ijin Keluar Masuk / Ijin Jam Kerja</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="{{ route('absensi.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ijin_keluar_masuk') }}">Ijin Keluar Masuk / Ijin Jam
                                Kerja</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <button onclick="buat()" class="btn btn-primary">Buat Baru</button>
                </div>
                <div class="col-auto">
                    <form action="{{ route('ijin_keluar_masuk.search') }}" method="get">
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
                            {{-- <div class="mb-3">
                                <label for="">Posisi Jabatan</label>
                                <select name="cari_posisi" class="form-control" id="">
                                    <option value="">-- Pilih Jabatan --</option>
                                    <option value="all" {{ !empty(request('cari_posisi')) ? 'selected' : null }}>Semua Posisi</option>
                                    <option value="4" {{ !empty(request('cari_posisi')) ? 'selected' : null }}>Staff - Direktur</option>
                                    <option value="5" {{ !empty(request('cari_posisi')) ? 'selected' : null }}>Operator</option>
                                </select>
                            </div> --}}
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
                        <th class="text-center">Jam Keluar</th>
                        <th class="text-center">Jam Datang</th>
                        <th class="text-center">Durasi</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ijin_keluar_masuks as $ijin_keluar_masuk)
                        @php
                            $cek_status_kerja = \App\Models\IticDepartemen::where(
                                'id',
                                $ijin_keluar_masuk->biodata_karyawan->id_departemen,
                            )->first();
                            if (empty($cek_status_kerja)) {
                                $satuan_kerja = '-';
                            } else {
                                $satuan_kerja = $cek_status_kerja->nama_departemen;
                            }

                            $cek_posisi = \App\Models\EmpPosisi::where(
                                'id',
                                $ijin_keluar_masuk->biodata_karyawan->id_posisi,
                            )->first();
                            if (empty($cek_posisi)) {
                                $posisi = '-';
                            } else {
                                $posisi = $cek_posisi->nama_posisi;
                            }

                            $awal = strtotime($ijin_keluar_masuk->jam_keluar);
                            $akhir = strtotime($ijin_keluar_masuk->jam_datang);

                            $diff = $akhir - $awal;
                            $total_jam = ($akhir - $awal) / 60;

                            $jam = floor($diff / (60 * 60));
                            $menit = $diff - $jam * (60 * 60);
                            $detik = $diff % 60;

                        @endphp
                        <tr>
                            <td style="vertical-align: middle">
                                <div class="d-flex align-items-center flex-column">
                                    <div class="d-flex align-items-center flex-column">
                                        <img class="profile"
                                            src="{{ asset('public/berkas/HRGA/data_karyawan/' . $ijin_keluar_masuk->biodata_karyawan->foto_karyawan) }}"
                                            style="border-radius: 50%; width: 60px; height: 60px; object-fit: cover;">
                                        <div>{{ $ijin_keluar_masuk->biodata_karyawan->nik }}</div>
                                        <div>{{ $ijin_keluar_masuk->biodata_karyawan->nama }}</div>
                                        <div>{{ $satuan_kerja . ' - ' . $posisi }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center" style="vertical-align: middle">
                                {{ \Carbon\Carbon::create($ijin_keluar_masuk->tanggal_ijin)->isoFormat('DD MMMM YYYY') }}
                            </td>
                            <td class="text-center" style="vertical-align: middle">
                                {{ \Carbon\Carbon::create($ijin_keluar_masuk->jam_keluar)->format('H:i') }}
                            </td>
                            <td class="text-center" style="vertical-align: middle">
                                {{ \Carbon\Carbon::create($ijin_keluar_masuk->jam_datang)->format('H:i') }}
                            </td>
                            <td class="text-center" style="vertical-align: middle">
                                {{ $total_jam }} Menit
                            </td>
                            <td class="text-center" style="vertical-align: middle">
                                <div class="btn-group">
                                    <button onclick="edit(`{{ $ijin_keluar_masuk->id_ijin }}`)" class="btn btn-warning"
                                        onclick="edit(`{{ $ijin_keluar_masuk->id_ijin }}`)"><i class="bx bx-edit"></i>
                                        Edit</button>
                                    <button onclick="hapus(`{{ $ijin_keluar_masuk->id_ijin }}`)" class="btn btn-danger"
                                        onclick="hapus(`{{ $ijin_keluar_masuk->id_ijin }}`)"><i class="bx bx-trash"></i>
                                        Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data Tidak Ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $ijin_keluar_masuks->links('vendor.pagination.paginationAcorn') }}
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
            $('.modalBuatIjinKerja').modal('show');
        }

        $('#btn-search').on('click', function() {
            $('#result').html('');
            var searchField = $('.nama_karyawan').val();
            var expression = new RegExp(searchField, "i");
            $.getJSON('{{ route('hrga.data_karyawan') }}', function(data) {
                $.each(data, function(key, value) {
                    // if (value.nama.search(expression) != -1 || value.location.search(expression) != -1)
                    // {
                    // $('#result').append('<li class="list-group-item link-class"><img src="'+value.image+'" height="40" width="40" class="img-thumbnail" /> '+value.name+' | <span class="text-muted">'+value.location+'</span></li>');
                    // }
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

        function edit(id_ijin) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/ijin_keluar_masuk') }}" + '/' + id_ijin,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        $('#id_ijin').val(result.data.id_ijin);
                        $('#nik').val(result.data.nik);
                        $('#tanggal_ijin').val(result.data.tanggal_ijin);

                        var jam_keluar = result.data.jam_keluar;
                        var jam_datang = result.data.jam_datang;
                        var jam_istirahat = result.data.jam_istirahat;

                        const array_jam_keluar = jam_keluar.split(":");
                        const array_jam_datang = jam_datang.split(":");
                        const array_jam_istirahat = jam_istirahat.split(":");

                        $('#jam_keluar_jam').val(array_jam_keluar[0]);
                        $('#jam_keluar_menit').val(array_jam_keluar[1]);
                        $('#jam_datang_jam').val(array_jam_datang[0]);
                        $('#jam_datang_menit').val(array_jam_datang[1]);
                        $('#jam_istirahat_jam').val(array_jam_istirahat[0]);
                        $('#jam_istirahat_menit').val(array_jam_istirahat[1]);

                        $('#keperluan').val(result.data.keperluan);

                        $('.modalEditIjinKerja').modal('show');
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

        function hapus(id_ijin) {
            $.ajax({
                type: 'GET',
                url: "{{ url('absensi/ijin_keluar_masuk') }}" + "/" + id_ijin + "/" + "delete",
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
                        // table.ajax.reload(null, false);
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
        }

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('ijin_keluar_masuk.simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
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
                        // table.ajax.reload(null, false);
                        jQuery.notify({
                            title: 'Berhasil!',
                            message: result.message_content
                        }, {
                            type: 'success',
                            showProgressbar: true
                        });
                        location.reload();
                        $('.modalBuatIjinKerja').modal('hide');
                    } else {
                        var error = result.error;
                        var error_txt = "";
                        error.forEach(fungsi_error);

                        function fungsi_error(value, index) {
                            error_txt += value + '<br>';
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

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('ijin_keluar_masuk.update') }}",
                data: formData,
                contentType: false,
                processData: false,
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
                        // table.ajax.reload(null, false);
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
                        $('.modalEditIjinKerja').modal('hide');
                    } else {
                        var error = result.error;
                        var error_txt = "";
                        error.forEach(fungsi_error);

                        function fungsi_error(value, index) {
                            error_txt += value + '<br>';
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
    </script>
@endsection
