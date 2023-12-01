@extends('layouts.apps.master')
@section('title')
    Data Karyawan Non Aktif
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css">
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

    @include('hrga.non_aktif.modalDetail')

    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title text-white">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-purple" onclick="reload()"><i class="fas fa-undo"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('hrga.biodata_karyawan.aktif') }}" class="btn btn-primary"><i class="mdi mdi-file-table-outline"></i> Database Aktif</a>
                        <a href="{{ route('hrga.biodata_karyawan.non_aktif') }}" class="btn btn-primary"><i class="mdi mdi-file-table-outline"></i> Database Non Aktif</a>
                    </div>
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10%">#</th>
                                <th class="text-center" style="width: 10%">Foto</th>
                                <th class="text-center" style="width: 10%">NIK</th>
                                <th class="text-center">Nama Karyawan</th>
                                <th class="text-center" style="width: 10%">No. Telpon</th>
                                <th class="text-center" style="width: 10%">Status Kerja</th>
                                <th class="text-center" style="width: 10%">Tanggal Resign</th>
                                <th class="text-center" style="width: 20%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/plugins/select2/select2.min.js') }}"></script>
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
    <script src="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.sweet-alert.init.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('hrga.biodata_karyawan.non_aktif') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'foto_karyawan',
                    name: 'foto_karyawan'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama_karyawan',
                    name: 'nama_karyawan'
                },
                {
                    data: 'no_telepon',
                    name: 'no_telepon'
                },
                {
                    data: 'status_kerja',
                    name: 'status_kerja'
                },
                {
                    data: 'status_karyawan_resign',
                    name: 'status_karyawan_resign'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            columnDefs: [
                // { className: 'text-right', targets: [7, 10, 11, 14, 16] },
                {
                    className: 'text-center',
                    targets: [0,1,2,4,5,6,7]
                },
            ],
        });

        function reload(){
            table.ajax.reload();
        }

        function detail(nik) {
            $.ajax({
                type: 'GET',
                url: "{{ url('hrga/biodata_karyawan/') }}"+'/'+nik+'/detail',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function() {
                },
                success: (result) => {
                    // console.table(result.data);
                    $('.detail_nik').val(result.data.nik);
                    document.getElementById('detail_nik').innerHTML = result.data.nik;
                    document.getElementById('detail_nama_karyawan').innerHTML = result.data.nama_karyawan;
                    document.getElementById('detail_tempat_tanggal_lahir').innerHTML = result.data.tempat_tanggal_lahir;
                    document.getElementById('detail_jenis_kelamin').innerHTML = result.data.jenis_kelamin;
                    document.getElementById('detail_alamat').innerHTML = result.data.alamat;
                    document.getElementById('detail_email').innerHTML = result.data.email;
                    document.getElementById('detail_status_keluarga').innerHTML = result.data.status_keluarga;
                    document.getElementById('detail_golongan_darah').innerHTML = result.data.golongan_darah;
                    document.getElementById('detail_pendidikan').innerHTML = result.data.pendidikan;
                    document.getElementById('detail_no_npwp').innerHTML = result.data.no_npwp;
                    document.getElementById('detail_no_bpjs_ketenagakerjaan').innerHTML = result.data.no_bpjs_ketenagakerjaan;
                    document.getElementById('detail_no_bpjs_kesehatan').innerHTML = result.data.no_bpjs_kesehatan;
                    document.getElementById('detail_no_rekening_mandiri').innerHTML = result.data.no_rekening_mandiri;
                    document.getElementById('detail_no_rekening_bws').innerHTML = result.data.no_rekening_bws;
                    document.getElementById('detail_foto_karyawan').innerHTML = '<img src='+result.data.foto_karyawan+' width="350" style="width: 350px; height: 550px; object-fit: cover;">';
                    
                    document.getElementById('detail_departemen_dept').innerHTML = result.data.departemen_dept;
                    document.getElementById('detail_departemen_bagian').innerHTML = result.data.departemen_bagian;
                    document.getElementById('detail_departemen_level').innerHTML = result.data.departemen_level;
                    
                    document.getElementById('detail_masuk_kerja_tgl_masuk').innerHTML = result.data.tanggal_masuk;
                    document.getElementById('detail_masuk_kerja_masa_kerja').innerHTML = result.data.masa_kerja;

                    if (result.data.status_kerja == null) {
                        document.getElementById('detail_status_kerja').innerHTML = '<tr><td colspan="3" class="text-center">Data Belum Tersedia</td></tr>'
                    }else{
                        var detail_status_kerja = result.data.status_kerja;
                        var txt_status_kerja = "";
                        detail_status_kerja.forEach(dt_status_kerja);

                        function dt_status_kerja(value, index)
                        {
                            txt_status_kerja += '<tr>';
                                if (value.pk == 'Kontrak') {
                                    txt_status_kerja += '<td class="text-center text-danger">'+value.pk+'</td>';
                                } else {
                                    txt_status_kerja += '<td class="text-center">'+value.pk+'</td>';
                                }
                            txt_status_kerja += '<td class="text-center">'+value.ke+'</td>';
                            txt_status_kerja += '<td class="text-center">'+value.tgl_mulai+'</td>';
                            txt_status_kerja += '</tr>';
                        }

                        document.getElementById('detail_status_kerja').innerHTML = txt_status_kerja;
                    }

                    if (result.data.riwayat_konseling == null) {
                        document.getElementById('detail_riwayat_konseling').innerHTML = '<tr><td colspan="2" class="text-center">Data Belum Tersedia</td></tr>'
                    }else{
                        var detail_riwayat_konseling = result.data.riwayat_konseling;
                        var txt_riwayat_konseling = "";
                        detail_riwayat_konseling.forEach(dt_riwayat_konseling);

                        function dt_riwayat_konseling(value, index) {
                            txt_riwayat_konseling += '<tr>';
                            txt_riwayat_konseling += '<td class="text-center">'+value.no+'</td>';
                            txt_riwayat_konseling += '<td class="text-center">'+value.data+'</td>';
                            txt_riwayat_konseling += '</tr>';
                        }
                        
                        document.getElementById('detail_riwayat_konseling').innerHTML = txt_riwayat_konseling;
                    }
                    
                    if (result.data.riwayat_training == null) {
                        document.getElementById('detail_riwayat_training').innerHTML = '<tr><td colspan="2" class="text-center">Data Belum Tersedia</td></tr>'
                    }else{
                        var detail_riwayat_training = result.data.riwayat_training;
                        var txt_riwayat_training = "";
                        detail_riwayat_training.forEach(dt_riwayat_training);

                        function dt_riwayat_training(value, index) {
                            txt_riwayat_training += '<tr>';
                            txt_riwayat_training += '<td class="text-center">'+value.no+'</td>';
                            txt_riwayat_training += '<td class="text-center">'+value.data+'</td>';
                            txt_riwayat_training += '</tr>';
                        }
                        
                        document.getElementById('detail_riwayat_training').innerHTML = txt_riwayat_konseling;
                    }

                    // document.getElementById('button_action').innerHTML = '<button type="button" class="btn btn-md" style="background-color: #005B41; color: white" onclick="buat_kontrak(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Kontrak</button>'+
                    //                                                     '<button type="button" class="btn btn-md" style="background-color: #508D69; color: white" onclick="buat_riwayat_konseling(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Riwayat Konseling</button>'+
                    //                                                     '<button type="button" class="btn btn-md" style="background-color: #363062; color: white" onclick="buat_riwayat_training(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Riwayat Training</button>';
                    
                    $('.modalDetailDataKaryawan').modal('show');
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
