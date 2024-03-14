@extends('layouts.apps.master')
@section('title')
    Departemen
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
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

    @include('kpi.departemen.modalBuatTeam')
    @include('kpi.departemen.modalDetailTeam')
    @include('kpi.departemen.modalEditTeam')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-outline-primary" href="#"><i class="fa fa-plus"></i> Create New Data</a>
                            <button class="btn btn-outline-primary" onclick="reload()"><i class="fas fa-undo"></i> Reload
                                Data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">Departemen</th>
                                <th class="text-center">Action</th>
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
            ajax: "{{ route('kpi.kpi_departemen') }}",
            columns: [
                {
                    data: 'departemen',
                    name: 'departemen'
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
                // {
                //     className: 'text-center',
                //     targets: [0, 1, 3, 4, 5, 6]
                // },
            ],
            order: [
                // [0, 'desc']
            ]
        });

        function buat_team(id) {
            // $('.modalBuatTeam').modal('show');
            $.ajax({
                type: 'GET',
                url: "{{ url('kpi/departemen/detail/') }}" + '/' + id,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    document.getElementById('title_kpi_team').innerHTML = 'Buat Team '+result.kpi.departemen;
                    // $('.departemen_user_id').append("<option value=''>-- Select Team --</option>");

                    const departemen_user = result.departemen_user;
                    var txt_departemen_user = "";
                    departemen_user.forEach(data_departemen_user);

                    function data_departemen_user(value,index) {
                        txt_departemen_user += '<option value='+value.id+'>'+value.team+'</option>'
                    }
                    $('#kpi_departemen_id').val(id);
                    document.getElementById('departemen_user_id').innerHTML = txt_departemen_user;
                    $('.modalBuatTeam').modal('show');
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        function detail_team(id) {
            // $('.modalBuatTeam').modal('show');
            // alert(id);
            $.ajax({
                type: 'GET',
                url: "{{ url('kpi/departemen/') }}" + '/' + id + '/team',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    // alert(result);
                    document.getElementById('detail_title_kpi_team').innerHTML = 'Detail Team';
                    $('#kpi_departemen_ids').val(id);

                    const kpi_team = result.data;
                    var txt_kpi_team = "";
                    kpi_team.forEach(detail_kpi_team);
                    var no = 1;
                    function detail_kpi_team(value,index) {
                        // txt_kpi_team += '<div class="mb-3">'+
                        //                     '<div>'+'Nama Team'+'</div>'+
                        //                     '<div>'+'<input type="text" class="form-control" readonly value="'+value.departemen_user.team+'">'+'</div>'+
                        //                 '</div>';
                        if (value.is_verifikasi == "Y") {
                            // if (value.is_verifikasi_culture == "y") {
                            //     var selected = 'selected';
                            // }else{
                            //     var selected = null;
                            // }
                            if (value.is_verifikasi_culture == "y"){
                                txt_kpi_team += '<tr>'+
                                                    '<td class="text-center">'+(index+1)+'</td>'+
                                                    '<td>'+value.team+'</td>'+
                                                    '<td>'+
                                                        '<select name="edit_status_'+index+'" class="form-control">'+
                                                            '<option value="Y" selected>'+'Ya'+'</option>'+
                                                            '<option value="N">'+'Tidak'+'</option>'+
                                                        '</select>'+
                                                    '</td>'+
                                                    '<td>'+
                                                        '<select name="edit_culture_verifikasi_status_'+index+'" class="form-control">'+
                                                            '<option value="">'+'-- Pilih Culture Validasi --'+'</option>'+
                                                            '<option value="y" selected>'+'Ya'+'</option>'+
                                                            '<option value="n">'+'Tidak'+'</option>'+
                                                        '</select>'+
                                                    '</td>'+
                                                '</tr>';
                            }else{
                                txt_kpi_team += '<tr>'+
                                                    '<td class="text-center">'+(index+1)+'</td>'+
                                                    '<td>'+value.team+'</td>'+
                                                    '<td>'+
                                                        '<select name="edit_status_'+index+'" class="form-control">'+
                                                            '<option value="Y">'+'Ya'+'</option>'+
                                                            '<option value="N">'+'Tidak'+'</option>'+
                                                        '</select>'+
                                                    '</td>'+
                                                    '<td>'+
                                                        '<select name="edit_culture_verifikasi_status_'+index+'" class="form-control">'+
                                                            '<option value="">'+'-- Pilih Culture Validasi --'+'</option>'+
                                                            '<option value="y">'+'Ya'+'</option>'+
                                                            '<option value="n" selected>'+'Tidak'+'</option>'+
                                                        '</select>'+
                                                    '</td>'+
                                                '</tr>';
                            }
                        } else {
                            if (value.is_verifikasi_culture == "y"){
                                txt_kpi_team += '<tr>'+
                                                    '<td class="text-center">'+(index+1)+'</td>'+
                                                    '<td>'+value.team+'</td>'+
                                                    '<td>'+
                                                        '<select name="edit_status_'+index+'" class="form-control">'+
                                                            '<option value="Y">'+'Ya'+'</option>'+
                                                            '<option value="N" selected>'+'Tidak'+'</option>'+
                                                        '</select>'+
                                                    '</td>'+
                                                    '<td>'+
                                                        '<select name="edit_culture_verifikasi_status_'+index+'" class="form-control">'+
                                                            '<option value="">'+'-- Pilih Culture Validasi --'+'</option>'+
                                                            '<option value="y" selected>'+'Ya'+'</option>'+
                                                            '<option value="n">'+'Tidak'+'</option>'+
                                                        '</select>'+
                                                    '</td>'+
                                                '</tr>';
                            }else{
                                txt_kpi_team += '<tr>'+
                                                    '<td class="text-center">'+(index+1)+'</td>'+
                                                    '<td>'+value.team+'</td>'+
                                                    '<td>'+
                                                        '<select name="edit_status_'+index+'" class="form-control">'+
                                                            '<option value="Y">'+'Ya'+'</option>'+
                                                            '<option value="N" selected>'+'Tidak'+'</option>'+
                                                        '</select>'+
                                                    '</td>'+
                                                    '<td>'+
                                                        '<select name="edit_culture_verifikasi_status_'+index+'" class="form-control">'+
                                                            '<option value="">'+'-- Pilih Culture Validasi --'+'</option>'+
                                                            '<option value="y">'+'Ya'+'</option>'+
                                                            '<option value="n" selected>'+'Tidak'+'</option>'+
                                                        '</select>'+
                                                    '</td>'+
                                                '</tr>';
                            }
                        }
                        no++;
                    }
                    
                    document.getElementById('detail_team_kpi').innerHTML = txt_kpi_team;
                    $('.modalDetailTeam').modal('show');
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        function edit_team(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('kpi/departemen/') }}" + '/' + id + '/team',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    document.getElementById('edit_title_kpi_team').innerHTML = 'Edit Team';
                    $('#edit_kpi_departemen_ids').val(id);
                    const kpi_team = result.data;
                    var txt_kpi_team = "";
                    kpi_team.forEach(detail_kpi_team);

                    function detail_kpi_team(value,index) {
                        if (value.is_verifikasi == "Y") {
                            var status_verifikasi = "Ya";
                        }else{
                            var status_verifikasi = "Tidak";
                        }

                        if (value.status == 'y') {
                            txt_kpi_team += '<tr>'+
                                                '<td class="text-center">'+(index+1)+'</td>'+
                                                '<td class="text-center">'+value.team+'</td>'+
                                                '<td class="text-center">'+value.jabatan+'</td>'+
                                                '<td class="text-center">'+status_verifikasi+'</td>'+
                                                '<td class="text-center">'+
                                                    '<select name="status_active'+index+'" class="form-control">'+
                                                        '<option value="">'+'-- Pilih Status --'+'</option>'+
                                                        '<option value="y" selected>'+'Aktif'+'</option>'+
                                                        '<option value="n">'+'Tidak Aktif'+'</option>'+
                                                    '</select>'+
                                                '</td>'+
                                            '</tr>';
                        } else {
                            txt_kpi_team += '<tr>'+
                                                '<td class="text-center">'+(index+1)+'</td>'+
                                                '<td class="text-center">'+value.team+'</td>'+
                                                '<td class="text-center">'+value.jabatan+'</td>'+
                                                '<td class="text-center">'+status_verifikasi+'</td>'+
                                                '<td class="text-center">'+
                                                    '<select name="status_active'+index+'" class="form-control">'+
                                                        '<option value="">'+'-- Pilih Status --'+'</option>'+
                                                        '<option value="y">'+'Aktif'+'</option>'+
                                                        '<option value="n" selected>'+'Tidak Aktif'+'</option>'+
                                                    '</select>'+
                                                '</td>'+
                                            '</tr>';
                        }
                    }
                    document.getElementById('edit_team_kpi').innerHTML = txt_kpi_team;
                    $('.modalEditTeam').modal('show');
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            })
        }

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('kpi.kpi_departemen_detail_simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (result) => {
                    if (result.success != false) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        table.ajax.reload();
                        $('#modalDetailTeam').modal('hide');
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
            // alert('test');
        });

        $('#form-team-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('kpi.kpi_detail_team_update') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (result) => {
                    // console.log(result);
                    if (result.success != false) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        table.ajax.reload();
                        $('#modalEditTeam').modal('hide');
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
            // alert('test');
        });
    </script>
@endsection
