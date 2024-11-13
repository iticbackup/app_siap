@extends('layouts.apps.master')
@section('title')
    Data Karyawan
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

    @include('hrga.modalBuat')
    @include('hrga.modalBuatDataResign')
    @include('hrga.modalEdit')
    @include('hrga.modalDetail')
    @include('hrga.modalBuatKontrak')
    @include('hrga.modalBuatRiwayatKonseling')
    @include('hrga.modalBuatRiwayatTraining')
    @include('hrga.modalExcelPeriode')

    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4 text-center">
                                <img src="{{ asset('public/berkas/HRGA/data_karyawan/office-worker.png') }}" class="img-fluid rounded-start" width="120">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title">Total Karyawan Laki - Laki</h4>
                                    <div style="font-size:14pt; font-weight: bold">{{ $total_karyawan_laki_laki . ' Karyawan' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4 text-center">
                                <img src="{{ asset('public/berkas/HRGA/data_karyawan/social.png') }}" class="img-fluid rounded-start" width="120">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title">Total Karyawan Perempuan</h4>
                                    <div style="font-size:14pt; font-weight: bold">{{ $total_karyawan_perempuan . ' Karyawan' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title text-white">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('hrga.rekap_pelatihan') }}" class="btn" style="background-color: #EEF296; color: black"><i class="fas fa-file"></i> Rekap Pelatihan</a>
                            <button class="btn" style="background-color: #1AACAC; color: white" onclick="downloadDataKaryawan()"><i class="fas fa-download"></i> Download Rekap Excel</button>
                            <button class="btn" style="background-color: #F31559; color: white" onclick="buatDataResign()"><i class="fas fa-plus"></i> Buat
                                Data Resign</button>
                            {{-- <button class="btn btn-primary" onclick="buatDataKaryawan()"><i class="fas fa-plus"></i> Buat
                                Data Karyawan</button> --}}
                            <button class="btn btn-purple" onclick="reload()"><i class="fas fa-undo"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('hrga.biodata_karyawan.aktif') }}" class="btn btn-primary" target="_blank"><i class="mdi mdi-file-table-outline"></i> Database Aktif</a>
                        <a href="{{ route('hrga.biodata_karyawan.non_aktif') }}" class="btn btn-primary" target="_blank"><i class="mdi mdi-file-table-outline"></i> Database Non Aktif</a>
                    </div>
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                {{-- <th class="text-center" style="width: 10%">#</th> --}}
                                <th class="text-center" style="width: 10%">Foto</th>
                                <th class="text-center" style="width: 10%">NIK</th>
                                <th class="text-center">Nama Karyawan</th>
                                <th class="text-center" style="width: 10%">Departemen</th>
                                <th class="text-center" style="width: 10%">No. Telpon</th>
                                <th class="text-center" style="width: 10%">Status Kerja</th>
                                <th class="text-center" style="width: 10%">Status Karyawan</th>
                                <th class="text-center" style="width: 20%">Action</th>
                                {{-- <th class="text-center">Nama Karyawan</th>
                                <th class="text-center" style="width: 10%">No. Telpon</th>
                                <th class="text-center" style="width: 10%">Status Kerja</th>
                                <th class="text-center" style="width: 10%">Status Karyawan | Tanggal Resign</th>
                                <th class="text-center" style="width: 20%">Action</th> --}}
                            </tr>
                        </thead>
                    </table>
                </div>
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
    <script src="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.sweet-alert.init.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.form-repeater.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('hrga.biodata_karyawan') }}",
            columns: [
                // {
                //     data: 'id',
                //     name: 'id'
                // },
                {
                    data: 'foto_karyawan',
                    name: 'foto_karyawan'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'id_departemen',
                    name: 'id_departemen'
                },
                {
                    data: 'no_telp',
                    name: 'no_telp'
                },
                {
                    data: 'status_karyawan',
                    name: 'status_karyawan'
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
                    targets: [0,1,3,4,5,6,7]
                },
            ],
        });

        $(document).ready(function() {
            var fileTag = document.getElementById("filetag"),
                preview = document.getElementById("preview_image");

            fileTag.addEventListener("change", function() {
                changeImage(this);
            });

            function changeImage(input) {
                var reader;

                if (input.files && input.files[0]) {
                    reader = new FileReader();

                    reader.onload = function(e) {
                        preview.setAttribute('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            var editFileTag = document.getElementById("edit_filetag"),
                edit_preview = document.getElementById("edit_preview_image");

            editFileTag.addEventListener("change", function() {
                editChangeImage(this);
            });

            function editChangeImage(input) {
                var edit_reader;

                if (input.files && input.files[0]) {
                    edit_reader = new FileReader();

                    edit_reader.onload = function(e) {
                        edit_preview.setAttribute('src', e.target.result);
                    }

                    edit_reader.readAsDataURL(input.files[0]);
                }
            }
            // $.ajaxSetup({
            //     cache: false
            // });
            // $('.nama_karyawan').change(function(){
            //     $('#result').html('');
            //     // $('#state').val('');
            //     var searchField = $('.nama_karyawan').val();
            //     var expression = new RegExp(searchField, "i");
            //     $.getJSON('{{ route('hrga.data_karyawan') }}', function(data) {
            //         $.each(data, function(key, value){
            //             // if (value.nama.search(expression) != -1 || value.location.search(expression) != -1)
            //             // {
            //             // $('#result').append('<li class="list-group-item link-class"><img src="'+value.image+'" height="40" width="40" class="img-thumbnail" /> '+value.name+' | <span class="text-muted">'+value.location+'</span></li>');
            //             // }
            //             if (value.nama.search(expression) != -1) {
            //                 $('#result').append('<li class="list-group-item link-class">'+value.nama+'</li>');
            //             };
            //         });
            //     });
            // });

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

            $('#resign-btn-search').on('click', function() {
                $('#resign_result').html('');
                var searchField = $('.resign_nama_karyawan').val();
                var expression = new RegExp(searchField, "i");
                $.getJSON('{{ route('hrga.data_karyawan') }}', function(data) {
                    $.each(data, function(key, value) {
                        // if (value.nama.search(expression) != -1 || value.location.search(expression) != -1)
                        // {
                        // $('#result').append('<li class="list-group-item link-class"><img src="'+value.image+'" height="40" width="40" class="img-thumbnail" /> '+value.name+' | <span class="text-muted">'+value.location+'</span></li>');
                        // }
                        if (value.nama.search(expression) != -1) {
                            $('#resign_result').append('<li class="list-group-item link-class">' +
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

                $.ajax({
                    type: 'GET',
                    url: "{{ url('hrga/biodata_karyawan/search/') }}" + '/' + $.trim(click_text[
                        1]),
                    contentType: "application/json;  charset=utf-8",
                    cache: false,
                    beforeSend: function() {
                        $('#mb_tempat_lahir').val('Loading...');
                        $('#mb_tanggal_lahir').val('Loading...');
                        $('#mb_npwp').val('Loading...');
                        $('#mb_alamat').val('Loading...');
                    },
                    success: (result) => {
                        // alert(result.nik);
                        $('#mb_tempat_lahir').val(result.tempat_lahir);
                        $('#mb_tanggal_lahir').val(result.tgl_lahir);
                        if (result.jenis_kelamin == 'L') {
                            $('#mb_jenis_kelamin').val('Laki - Laki');
                        } else {
                            $('#mb_jenis_kelamin').val('Perempuan');
                        }

                        if (result.npwp == "" || result.npwp == null) {
                            $('#mb_npwp').val(0);
                        } else {
                            $('#mb_npwp').val(result.npwp);
                        }

                        $('#mb_alamat').val(result.alamat);
                        $('#mb_status_klg').val(result.status_klg);

                    },
                    error: function(request, status, error) {
                        iziToast.error({
                            title: 'Error',
                            message: error,
                        });
                    }
                });
            });

            $('#resign_result').on('click', 'li', function() {
                var click_text = $(this).text().split('|');
                $("#resign_result").html('');

                $.ajax({
                    type: 'GET',
                    url: "{{ url('hrga/biodata_karyawan/search/') }}" + '/' + $.trim(click_text[
                        1]),
                    contentType: "application/json;  charset=utf-8",
                    cache: false,
                    beforeSend: function() {
                    },
                    success: (result) => {
                        // alert(result.nik);
                        // $('#mb_tempat_lahir').val(result.tempat_lahir);
                        // $('#mb_tanggal_lahir').val(result.tgl_lahir);
                        // if (result.jenis_kelamin == 'L') {
                        //     $('#mb_jenis_kelamin').val('Laki - Laki');
                        // } else {
                        //     $('#mb_jenis_kelamin').val('Perempuan');
                        // }

                        // if (result.npwp == "" || result.npwp == null) {
                        //     $('#mb_npwp').val(0);
                        // } else {
                        //     $('#mb_npwp').val(result.npwp);
                        // }

                        // $('#mb_alamat').val(result.alamat);
                        // $('#mb_status_klg').val(result.status_klg);
                        var date_tanggal_masuk = new Date(result.tanggal_masuk);
                        var resign_table = '';
                            resign_table += '<table class="table">';
                            resign_table +=     '<tbody>';
                            resign_table +=         '<tr>';
                            resign_table +=             '<th>'+'NIK'+'</th>';
                            resign_table +=             '<th>'+':'+'</th>';
                            resign_table +=             '<td>'+result.nik+'<input type="hidden" name="resign_nik" value='+result.nik+'>'+'</td>';
                            resign_table +=         '</tr>';
                            resign_table +=         '<tr>';
                            resign_table +=             '<th>'+'Nama Karyawan'+'</th>';
                            resign_table +=             '<th>'+':'+'</th>';
                            resign_table +=             '<td>'+result.nama+'</td>';
                            resign_table +=         '</tr>';
                            resign_table +=         '<tr>';
                            resign_table +=             '<th>'+'Tanggal Masuk'+'</th>';
                            resign_table +=             '<th>'+':'+'</th>';
                            resign_table +=             '<td>'+("0"+date_tanggal_masuk.getDate()).slice(-2)+'-'+("0"+(date_tanggal_masuk.getMonth()+1)).slice(-2)+'-'+date_tanggal_masuk.getFullYear()+'</td>';
                            resign_table +=         '</tr>';
                            resign_table +=         '<tr>';
                            resign_table +=             '<th>'+'Tanggal Resign'+'</th>';
                            resign_table +=             '<th>'+':'+'</th>';
                            resign_table +=             '<td>'+'<input type="date" name="resign_tanggal_resign" class="form-control" placeholder="Tanggal Resign">'+'</td>';
                            resign_table +=         '</tr>';
                            resign_table +=     '</tbody>';
                            resign_table += '</table>';
                        document.getElementById('resign-table').innerHTML = resign_table;
                    },
                    error: function(request, status, error) {
                        iziToast.error({
                            title: 'Error',
                            message: error,
                        });
                    }
                });
            })
        });


        function buatDataKaryawan() {
            $('.modalBuatDataKaryawan').modal('show');
        }

        function reload(){
            table.ajax.reload(null, false);
        }

        function buatDataResign() {
            $('.modalBuatDataResign').modal('show');
        }

        function downloadDataKaryawan()
        {
            $('.modalExcelPeriode').modal('show');
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
                    document.getElementById('detail_email').innerHTML = !result.data.email ? '<span class="text-danger">Belum Lengkap</span>' : result.data.email;
                    document.getElementById('detail_no_telepon').innerHTML = !result.data.no_telepon ? '<span class="text-danger">Belum Lengkap</span>' : result.data.no_telepon;
                    document.getElementById('detail_status_keluarga').innerHTML = result.data.status_keluarga;
                    document.getElementById('detail_golongan_darah').innerHTML = !result.data.golongan_darah ? '<span class="text-danger">Belum Lengkap</span>' : result.data.golongan_darah;
                    document.getElementById('detail_pendidikan').innerHTML = !result.data.pendidikan ? '<span class="text-danger">Belum Lengkap</span>' : result.data.pendidikan;
                    document.getElementById('detail_no_npwp').innerHTML = result.data.no_npwp == 0 ? '-' : result.data.no_npwp;
                    document.getElementById('detail_no_bpjs_ketenagakerjaan').innerHTML = !result.data.no_bpjs_ketenagakerjaan ? '<span class="text-danger">Belum Lengkap</span>' : result.data.no_bpjs_ketenagakerjaan;
                    document.getElementById('detail_no_bpjs_kesehatan').innerHTML = !result.data.no_bpjs_kesehatan ? '<span class="text-danger">Belum Lengkap</span>' : result.data.no_bpjs_kesehatan;
                    document.getElementById('detail_no_rekening_mandiri').innerHTML = result.data.no_rekening_mandiri == 0 ? '-' : result.data.no_rekening_mandiri == '-' ? '<span class="text-danger">Belum Lengkap</span>' : result.data.no_rekening_mandiri;
                    document.getElementById('detail_no_rekening_bws').innerHTML = result.data.no_rekening_bws == 0 ? '-' : result.data.no_rekening_bws == '-' ? '<span class="text-danger">Belum Lengkap</span>' : result.data.no_rekening_bws;
                    document.getElementById('detail_no_rekening_bca').innerHTML = result.data.no_rekening_bca == 0 ? '-' : result.data.no_rekening_bca == null ? '<span class="text-danger">Belum Lengkap</span>' : result.data.no_rekening_bca;
                    document.getElementById('detail_foto_karyawan').innerHTML = '<img src='+result.data.foto_karyawan+' width="350" style="width: 350px; height: 550px; object-fit: cover;">';
                    
                    document.getElementById('detail_sim_kendaraan').innerHTML = result.data.sim_kendaraan == null ? '<span class="text-danger">Belum Lengkap</span>' : result.data.sim_kendaraan;
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
                            txt_riwayat_training += '<td class="text-left">'+value.data+'</td>';
                            txt_riwayat_training += '</tr>';
                        }
                        
                        document.getElementById('detail_riwayat_training').innerHTML = txt_riwayat_training;
                    }

                    document.getElementById('title_button_action').innerHTML = '<div class="row align-items-center">'+
                                                                                    '<div class="col">'+
                                                                                        '<h4 class="modal-title text-white">Detail Data Karyawan</h4>'+
                                                                                    '</div>'+
                                                                                    '<div class="col-auto btn-group">'+
                                                                                        '<button type="button" class="btn btn-md" style="background-color: #005B41; color: white" onclick="buat_kontrak(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Kontrak</button>'+
                                                                                        '<button type="button" class="btn btn-md" style="background-color: #508D69; color: white" onclick="buat_riwayat_konseling(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Riwayat Konseling</button>'+
                                                                                        '<button type="button" class="btn btn-md" style="background-color: #363062; color: white" onclick="buat_riwayat_training(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Riwayat Training</button>'+
                                                                                    '</div>'+
                                                                                '</div>'+
                                                                                '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    document.getElementById('button_action').innerHTML = '<button type="button" class="btn btn-md" style="background-color: #005B41; color: white" onclick="buat_kontrak(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Kontrak</button>'+
                                                                        '<button type="button" class="btn btn-md" style="background-color: #508D69; color: white" onclick="buat_riwayat_konseling(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Riwayat Konseling</button>'+
                                                                        '<button type="button" class="btn btn-md" style="background-color: #363062; color: white" onclick="buat_riwayat_training(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Riwayat Training</button>';
                    
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

        function download_data_karyawan(nik) {
            $.ajax({
                type: 'GET',
                url: "{{ url('hrga/biodata_karyawan/') }}"+'/'+nik+'/cetak',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function() {
                },
                success: (result) => {
                    window.location.href="{{ url('hrga/biodata_karyawan/') }}"+'/'+nik+'/cetak';
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        function edit(nik) {
            $.ajax({
                type: 'GET',
                url: "{{ url('hrga/biodata_karyawan/') }}"+'/'+nik+'/detail',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function() {
                },
                success: (result) => {
                    $('#edit_nik_karyawan').val(result.data.nik);
                    $('#edit_nama_karyawan').val(result.data.nama_karyawan);
                    $('#edit_mb_tempat_lahir').val(result.data.tempat_lahir);
                    $('#edit_mb_tanggal_lahir').val(result.data.tanggal_lahir);
                    $('#edit_mb_jenis_kelamin').val(result.data.jenis_kelamin);
                    $('#edit_email').val(result.data.email);
                    $('#edit_mb_npwp').val(result.data.no_npwp);
                    $('#edit_mb_alamat').val(result.data.alamat);
                    $('#edit_no_urut_level').val(result.data.no_urut_level);
                    $('#edit_no_urut_departemen').val(result.data.no_urut_departemen);
                    $('#edit_no_telepon').val(result.data.no_telepon);
                    $('#edit_no_bpjs_ketenagakerjaan').val(result.data.no_bpjs_ketenagakerjaan);
                    $('#edit_no_bpjs_kesehatan').val(result.data.no_bpjs_kesehatan);
                    $('#edit_no_rekening_mandiri').val(result.data.no_rekening_mandiri);
                    $('#edit_no_rekening_bws').val(result.data.no_rekening_bws);
                    $('#edit_no_rekening_bca').val(result.data.no_rekening_bca);
                    $('#edit_sim_kendaraan').val(result.data.sim_kendaraan);
                    $('#edit_departemen_dept').val(result.data.departemen_dept);
                    $('#edit_departemen_bagian').val(result.data.departemen_bagian);
                    $('#edit_departemen_level').val(result.data.departemen_level);
                    $('#edit_mb_status_klg').val(result.data.status_keluarga);
                    $('#edit_golongan_darah').val(result.data.golongan_darah);
                    $('#edit_pendidikan').val(result.data.pendidikan);
                    $('#edit_kunci_loker').val(result.data.kunci_loker);
                    $('#edit_status_karyawan').val(result.data.status_karyawan);
                    // document.getElementById('button_action').innerHTML = '<button type="button" class="btn btn-md" style="background-color: #005B41; color: white" onclick="buat_kontrak(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Kontrak</button>'+
                    //                                                     '<button type="button" class="btn btn-md" style="background-color: #508D69; color: white" onclick="buat_riwayat_konseling(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Riwayat Konseling</button>'+
                    //                                                     '<button type="button" class="btn btn-md" style="background-color: #363062; color: white" onclick="buat_riwayat_training(`'+result.data.nik+'`)"><i class="mdi mdi-plus"></i> Buat Riwayat Training</button>';
                    
                    $('.modalEditDataKaryawan').modal('show');
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        function buat_kontrak(nik)
        {
            $.ajax({
                type: 'GET',
                url: "{{ url('hrga/biodata_karyawan/') }}"+'/'+nik+'/detail',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function() {
                    $('.modalDetailDataKaryawan').modal('hide');
                },
                success: (result) => {
                    $('#kontrak_id').val(result.data.id);
                    $('#detail_nik_kontrak').val(result.data.nik);
                    document.getElementById('detail_kontrak_nik').innerHTML = result.data.nik;
                    document.getElementById('detail_kontrak_nama_karyawan').innerHTML = result.data.nama_karyawan;

                    if (result.data.status_kerja == null) {
                        document.getElementById('detail_kontrak_datatables').innerHTML = '<td colspan="3">Data Belum Tersedia</td>';
                    } else {
                        var detail_status_kontrak = result.data.status_kerja;
                        var txt_status_kontrak = "";
    
                        detail_status_kontrak.forEach(dt_status_kontrak);
    
                        function dt_status_kontrak(value, index) {
                            txt_status_kontrak += '<tr>';
                                if (value.pk == 'Kontrak') {
                                    txt_status_kontrak += '<td class="text-center text-danger">'+value.pk+'</td>';
                                }else{
                                    txt_status_kontrak += '<td class="text-center">'+value.pk+'</td>';
                                }
                            txt_status_kontrak += '<td class="text-center">'+value.ke+'</td>';
                            txt_status_kontrak += '<td class="text-center">'+value.tgl_mulai+'</td>';
                            txt_status_kontrak += '</tr>';
                        }
    
                        document.getElementById('detail_kontrak_datatables').innerHTML = txt_status_kontrak;
                    }

                    document.getElementById('button_kontrak_kerja').innerHTML = '<button type="submit" class="btn btn-primary">Submit</button>'+
                                                                                '<button type="button" class="btn btn-secondary" onclick="detail(`'+result.data.nik+'`)" data-bs-dismiss="modal">Back</button>';

                    $('.modalBuatKontrakKaryawan').modal('show');
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        function buat_riwayat_konseling(nik)
        {
            $.ajax({
                type: 'GET',
                url: "{{ url('hrga/biodata_karyawan/') }}"+'/'+nik+'/detail',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function() {
                    $('.modalDetailDataKaryawan').modal('hide');
                },
                success: (result) => {
                    $('#riwayat_konseling_id').val(result.data.id);
                    $('#detail_nik_riwayat_konseling').val(result.data.nik);
                    document.getElementById('detail_riwayat_konseling_nik').innerHTML = result.data.nik;
                    document.getElementById('detail_riwayat_konseling_nama_karyawan').innerHTML = result.data.nama_karyawan;

                    if (result.data.riwayat_konseling == null) {
                        document.getElementById('detail_riwayat_konseling_datatables').innerHTML = '<tr><td colspan="2" class="text-center">Data Belum Tersedia</td></tr>';
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
    
                        document.getElementById('detail_riwayat_konseling_datatables').innerHTML = txt_riwayat_konseling;
                    }

                    document.getElementById('button_riwayat_konseling').innerHTML = '<button type="submit" class="btn btn-primary">Submit</button>'+
                                                                                    '<button type="button" class="btn btn-secondary" onclick="detail(`'+result.data.nik+'`)" data-bs-dismiss="modal">Back</button>';
                    $('.modalBuatRiwayatKonseling').modal('show');
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        function buat_riwayat_training(nik)
        {
            $.ajax({
                type: 'GET',
                url: "{{ url('hrga/biodata_karyawan/') }}"+'/'+nik+'/detail',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function() {
                    $('.modalDetailDataKaryawan').modal('hide');
                },
                success: (result) => {
                    $('#riwayat_training_id').val(result.data.id);
                    $('#detail_nik_riwayat_training').val(result.data.nik);
                    document.getElementById('detail_riwayat_training_nik').innerHTML = result.data.nik;
                    document.getElementById('detail_riwayat_training_nama_karyawan').innerHTML = result.data.nama_karyawan;
                    document.getElementById("riwayat_training_simpan").reset();
                    // if (result.data.riwayat_konseling == null) {
                    //     document.getElementById('detail_riwayat_konseling_datatables').innerHTML = '<tr><td colspan="2" class="text-center">Data Belum Tersedia</td></tr>';
                    // }else{
                    //     var detail_riwayat_konseling = result.data.riwayat_konseling;
                    //     var txt_riwayat_konseling = "";
    
                    //     detail_riwayat_konseling.forEach(dt_riwayat_konseling);
    
                    //     function dt_riwayat_konseling(value, index) {
                    //         txt_riwayat_konseling += '<tr>';
                    //         txt_riwayat_konseling += '<td class="text-center">'+value.no+'</td>';
                    //         txt_riwayat_konseling += '<td class="text-center">'+value.data+'</td>';
                    //         txt_riwayat_konseling += '</tr>';
                    //     }
    
                    //     document.getElementById('detail_riwayat_konseling_datatables').innerHTML = txt_riwayat_konseling;
                    // }

                    // if (result.data.riwayat_training == null) {
                    //     $.ajax({
                    //         type: 'GET',
                    //         url: "{{ url('hrga/biodata_karyawan/') }}"+'/'+result.data.nama_karyawan+'/cek_rekap_training',
                    //         contentType: "application/json;  charset=utf-8",
                    //         cache: false,
                    //         beforeSend: function() {
                    //         },
                    //         success: (result) => {
                    //             // console.table(result);
                    //             if (result.data == null) {
                    //                 document.getElementById('detail_riwayat_training_datatables').innerHTML = '<tr><td colspan="2" class="text-center">Data Belum Tersedia</td></tr>';
                    //             }else{
                    //                 var detail_riwayat_training = result.data;
                    //                 var txt_riwayat_training = "";
        
                    //                 detail_riwayat_training.forEach(dt_riwayat_training);
                    //                 function dt_riwayat_training(value, index) {
                    //                     txt_riwayat_training += '<tr>';
                    //                     txt_riwayat_training += '<td class="text-center">'+value.no+'</td>';
                    //                     // txt_riwayat_training += '<td class="text-left">'+'<input type="text" name="" value='+value.nama_pelatihan+'>'+'</td>';
                    //                     txt_riwayat_training += '<td class="text-left">'+'<textarea name="riwayat_training[]" class="form-control" readonly>'+value.nama_pelatihan+'</textarea>'+'</td>';
                    //                     txt_riwayat_training += '</tr>';
                    //                 }
                    //                 document.getElementById('detail_riwayat_training_datatables').innerHTML = txt_riwayat_training;
                    //             }
                    //         },
                    //         error: function(request, status, error) {
                    //             iziToast.error({
                    //                 title: 'Error',
                    //                 message: error,
                    //             });
                    //         }
                    //     });
                    // }else{
                    //     var detail_riwayat_training = result.data.riwayat_training;
                    //     var txt_riwayat_training = "";
    
                    //     detail_riwayat_training.forEach(dt_riwayat_training);
    
                    //     function dt_riwayat_training(value, index) {
                    //         txt_riwayat_training += '<tr>';
                    //         txt_riwayat_training += '<td class="text-center">'+value.no+'</td>';
                    //         txt_riwayat_training += '<td class="text-left">'+value.data+'</td>';
                    //         txt_riwayat_training += '</tr>';
                    //     }
    
                    //     document.getElementById('detail_riwayat_training_datatables').innerHTML = txt_riwayat_training;
                    // }
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('hrga/biodata_karyawan/') }}"+'/'+result.data.nama_karyawan+'/cek_rekap_training',
                        contentType: "application/json;  charset=utf-8",
                        cache: false,
                        beforeSend: function() {
                        },
                        success: (result) => {
                            // console.table(result);
                            if (result.data == null) {
                                document.getElementById('detail_riwayat_training_datatables').innerHTML = '<tr><td colspan="2" class="text-center">Data Belum Tersedia</td></tr>';
                            }else{
                                var detail_riwayat_training = result.data;
                                var txt_riwayat_training = "";
    
                                detail_riwayat_training.forEach(dt_riwayat_training);
                                function dt_riwayat_training(value, index) {
                                    // console.table(value.nama_pelatihan.hrga_rekap_pelatihan_karyawan);
                                    txt_riwayat_training += '<tr>';
                                    txt_riwayat_training += '<td class="text-center">'+value.no+'</td>';
                                    // txt_riwayat_training += '<td class="text-left">'+'<input type="text" name="" value='+value.nama_pelatihan+'>'+'</td>';
                                    txt_riwayat_training += '<td class="text-left">'+'<textarea name="riwayat_training[]" class="form-control" readonly>'+value.nama_pelatihan+'</textarea>'+'</td>';
                                    txt_riwayat_training += '</tr>';
                                }
                                document.getElementById('detail_riwayat_training_datatables').innerHTML = txt_riwayat_training;
                            }
                        },
                        error: function(request, status, error) {
                            iziToast.error({
                                title: 'Error',
                                message: error,
                            });
                        }
                    });
                    document.getElementById('button_riwayat_training').innerHTML = '<button type="submit" class="btn btn-primary">Update Training</button>'+
                                                                                    '<button type="button" class="btn btn-secondary" onclick="detail(`'+result.data.nik+'`)" data-bs-dismiss="modal">Back</button>';
                    $('.modalBuatRiwayatTraining').modal('show');
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

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
                        url: "{{ route('hrga.biodata_karyawan.simpan') }}",
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
                                document.getElementById("form-simpan").reset();
                                table.ajax.reload(null, false);

                                $('.modalBuatDataKaryawan').modal('hide');
                            }else{
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

            
            // alert('test');
        });

        $('#form-update').submit(function(e) {
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
                        url: "{{ route('hrga.biodata_karyawan.update') }}",
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
                                
                                table.ajax.reload(null, false);

                                $('.modalEditDataKaryawan').modal('hide');
                            }else{
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

            
            // alert('test');
        });

        $('#form-resign-simpan').submit(function(e) {
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
                        url: "{{ route('hrga.biodata_karyawan.resign_simpan') }}",
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
                                document.getElementById("form-resign-simpan").reset();
                                table.ajax.reload(null, false);

                                $('.modalBuatDataResign').modal('hide');
                            }else{
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

            
            // alert('test');
        });

        $('#kontrak_kerja_simpan').submit(function(e) {
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
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                    // e.preventDefault();
                    // let formData = new FormData(this);
                    // $('#image-input-error').text('');
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('hrga.biodata_karyawan.kontrak_kerja_simpan') }}",
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
                                
                            }else{
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

            
            // alert('test');
        });

        $('#riwayat_konseling_simpan').submit(function(e) {
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
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                    // e.preventDefault();
                    // let formData = new FormData(this);
                    // $('#image-input-error').text('');
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('hrga.biodata_karyawan.riwayat_konseling_simpan') }}",
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
                                
                            }else{
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

            
            // alert('test');
        });
        
        $('#riwayat_training_simpan').submit(function(e) {
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
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                    // e.preventDefault();
                    // let formData = new FormData(this);
                    // $('#image-input-error').text('');
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('hrga.biodata_karyawan.riwayat_training_simpan') }}",
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
                                document.getElementById("riwayat_training_simpan").reset();
                            }else{
                                Swal.fire(
                                    result.message_title,
                                    result.message_content,
                                    'warning'
                                );
                                // var error = result.error;
                                // var txt_error = ""
                                // error.forEach(fun_error);

                                // function fun_error(value, index) {
                                //     txt_error += value;
                                // }

                                // Swal.fire(
                                //     'Gagal!',
                                //     txt_error,
                                //     'error'
                                // )
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

            
            // alert('test');
        });

        $('#search_rekap_all').submit(function(e) {
            e.preventDefault();
            // let formData = new FormData(this);
            // console.log($('#search_date_download').val());
            document.getElementById('view_download').innerHTML = '<a href="{{ url("hrga/biodata_karyawan/download_rekap_excel/") }}'+'/'+$('#search_date_download').val()+'" class="btn btn-primary" target="_blank"><i class="fas fa-download"></i> Download Rekap</a>'
        })

        // $(document).ready(function(){
        //     alert($('.nama_karyawan').val());
        // });
        // $('.nama_karyawan').change(function(){
        //     $.ajaxSetup({ cache: false });
        //     alert($('.nama_karyawan').val());
        // })
    </script>
@endsection
