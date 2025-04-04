@extends('layouts.absensi.master')
<?php $asset = asset('public/absensi/'); ?>
@section('css')
<link rel="stylesheet" href="{{ $asset }}/assets/plugins/notifications/css/lobibox.min.css">
@endsection
@section('title')
    Absensi - Ijin / Terlambat
@endsection

@section('content')
    @include('absensi.ijin_terlambat.modalBuat')
    @include('absensi.ijin_terlambat.modalEdit')
    <div class="page-content">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center" style="margin-bottom: 1%">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                            <button onclick="buat()" class="btn btn-primary"><i class="bx bx-plus bx-sm bx-tada"></i>
                                Tambah</button>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('ijin_terlambat.search') }}" method="get">
                                <div class="input-group">
                                    <div class="mb-3">
                                        <label for="">Cari NIK / Karyawan</label>
                                        <input type="search" name="cari" class="form-control"
                                            value="{{ old('cari') }}" placeholder="Search..." id="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Mulai Bulan</label>
                                        <input type="date" name="cari_tanggal_awal" class="form-control"
                                            value="{{ old('cari_tanggal') }}" id="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Sampai Bulan</label>
                                        <input type="date" name="cari_tanggal_akhir" class="form-control"
                                            value="{{ old('cari_tanggal') }}" id="">
                                    </div>
                                    <div class="mb-3">
                                        <br>
                                        <button class="btn btn-outline-primary" type="submit"><i
                                                class="bx bxs-search bx-sm bx-tada"></i> Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="datatables" class="table table-striped table-bordered dataTable mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama</th>
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
                                            // if ($cek_status_kerja->nama_departemen >= 1) {
                                            //     $satuan_kerja = $cek_status_kerja->nama_unit;
                                            // } else {
                                            //     $satuan_kerja = $cek_status_kerja->nama_departemen;
                                            // }
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
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>{{ $ijin_terlambat->biodata_karyawan->nik . ' - ' . $ijin_terlambat->biodata_karyawan->nama }}
                                                    </h6>
                                                    <hr>
                                                    <div><b>Departemen:</b> {{ $satuan_kerja }}</div>
                                                    <div><b>Posisi:</b> {{ $posisi }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <div class="card">
                                                <div class="card-body">
                                                    {{ \Carbon\Carbon::create($ijin_terlambat->scan_date)->isoFormat('LL') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <div class="card">
                                                <div class="card-body">
                                                    @if (!empty($ijin_terlambat->presensi_status->status_info))
                                                        {{ $ijin_terlambat->presensi_status->status_info }}
                                                    @else
                                                    -
                                                    @endif
                                                    {{-- {{ $ijin_terlambat->presensi_status->status_info }} --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <div class="card">
                                                <div class="card-body">
                                                    {{ \Carbon\Carbon::create($ijin_terlambat->scan_date)->format('H:i') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <div class="btn-group">
                                                <button onclick="edit(`{{ $ijin_terlambat->att_rec }}`)"
                                                    class="btn btn-warning"
                                                    onclick="edit(`{{ $ijin_terlambat->att_rec }}`)"><i
                                                        class="bx bx-edit"></i> Edit</button>
                                                <button onclick="hapus(`{{ $ijin_terlambat->att_rec }}`)"
                                                    class="btn btn-danger"
                                                    onclick="hapus(`{{ $ijin_terlambat->att_rec }}`)"><i
                                                        class="bx bx-trash"></i> Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="4">Data Belum Tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            {{-- <tbody>
                            @forelse ($ijin_keluar_masuks as $ijin_keluar_masuk)
                            @php
                                $cek_status_kerja = \App\Models\IticDepartemen::where('id_departemen',$ijin_keluar_masuk->biodata_karyawan->satuan_kerja)->first();
                                if (empty($cek_status_kerja)) {
                                    $satuan_kerja = '-';
                                }else{
                                    if ($cek_status_kerja->nama_departemen >= 1) {
                                        $satuan_kerja = $cek_status_kerja->nama_unit;
                                    }else{
                                        $satuan_kerja = $cek_status_kerja->nama_departemen;
                                    }
                                }

                                $cek_posisi = \App\Models\EmpPosisi::where('id_posisi',$ijin_keluar_masuk->biodata_karyawan->id_posisi)->first();
                                if (empty($cek_posisi)) {
                                    $posisi = '-';
                                }else{
                                    $posisi = $cek_posisi->nama_posisi;
                                }

                                $awal = strtotime($ijin_keluar_masuk->jam_keluar);
                                $akhir = strtotime($ijin_keluar_masuk->jam_datang);
                                $total_jam = ($akhir-$awal)/60;
                            @endphp
                                <tr>
                                    <td style="vertical-align: middle">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6>{{ $ijin_keluar_masuk->biodata_karyawan->nik.' - '.$ijin_keluar_masuk->biodata_karyawan->nama }}</h6>
                                                <hr>
                                                <div><b>Departemen:</b> {{ $satuan_kerja }}</div>
                                                <div><b>Posisi:</b> {{ $posisi }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle" class="text-center">
                                        <div class="card">
                                            <div class="card-body">
                                                {{ $ijin_keluar_masuk->tanggal_ijin }}
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle" class="text-center">
                                        <div class="card">
                                            <div class="card-body">
                                                {{ $ijin_keluar_masuk->jam_keluar }}
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle" class="text-center">
                                        <div class="card">
                                            <div class="card-body">
                                                {{ $ijin_keluar_masuk->jam_datang }}
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle" class="text-center">
                                        <div class="card">
                                            <div class="card-body">
                                                {{ $total_jam }} Menit
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle" class="text-center">
                                        <div class="btn-group">
                                            <button onclick="edit(`{{ $ijin_keluar_masuk->id_ijin }}`)" class="btn btn-warning" onclick="edit(`{{ $ijin_keluar_masuk->id_ijin }}`)"><i class="bx bx-edit"></i> Edit</button>
                                            <button onclick="hapus(`{{ $ijin_keluar_masuk->id_ijin }}`)" class="btn btn-danger" onclick="hapus(`{{ $ijin_keluar_masuk->id_ijin }}`)"><i class="bx bx-trash"></i> Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="6">Data Belum Tersedia</td>
                            </tr>
                            @endforelse
                        </tbody> --}}
                        </table>
                        {{ $ijin_terlambats->links('vendor.pagination.template1.default') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ $asset }}/assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="{{ $asset }}/assets/plugins/notifications/js/notifications.min.js"></script>
    <script src="{{ $asset }}/assets/plugins/notifications/js/notification-custom-script.js"></script>
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
                        // $('#id_ijin').val(result.data.id_ijin);
                        // $('#nik').val(result.data.nik);
                        // $('#tanggal_ijin').val(result.data.tanggal_ijin);

                        // var jam_keluar = result.data.jam_keluar;
                        // var jam_datang = result.data.jam_datang;
                        // var jam_istirahat = result.data.jam_istirahat;

                        // const array_jam_keluar = jam_keluar.split(":");
                        // const array_jam_datang = jam_datang.split(":");
                        // const array_jam_istirahat = jam_istirahat.split(":");

                        // $('#jam_keluar_jam').val(array_jam_keluar[0]);
                        // $('#jam_keluar_menit').val(array_jam_keluar[1]);
                        // $('#jam_datang_jam').val(array_jam_datang[0]);
                        // $('#jam_datang_menit').val(array_jam_datang[1]);
                        // $('#jam_istirahat_jam').val(array_jam_istirahat[0]);
                        // $('#jam_istirahat_menit').val(array_jam_istirahat[1]);

                        // $('#keperluan').val(result.data.keperluan);
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
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-x-circle',
                            msg: result.message_content
                        });
                    }
                },
                error: function(request, status, error) {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: error
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
                        Lobibox.notify('success', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-check-circle',
                            msg: result.message_content
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
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-x-circle',
                            msg: error_txt
                        });
                    }
                },
                error: function(request, status, error) {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: error
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
                        Lobibox.notify('success', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-check-circle',
                            msg: result.message_content
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
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-x-circle',
                            msg: error_txt
                        });
                    }
                },
                error: function(request, status, error) {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: error
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
                        Lobibox.notify('success', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-check-circle',
                            msg: result.message_content
                        });
                        // table.ajax.reload(null, false);
                        location.reload();
                    } else {
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-x-circle',
                            msg: result.message_content
                        });
                    }
                },
                error: function(request, status, error) {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: error
                    });
                }
            });
        }
    </script>
@endsection
