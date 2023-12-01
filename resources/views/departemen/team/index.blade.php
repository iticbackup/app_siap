@extends('layouts.apps.master')
@section('title')
    Team - {{ $departemen->departemen }}
@endsection
@section('css')
    <link href="{{ URL::asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/huebee/huebee.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/timepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
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
            @yield('title')
        @endslot
        @slot('title')
            @yield('title')
        @endslot
    @endcomponent

    <a href="{{ route('departemen') }}" class="btn btn-outline-primary mb-3"><i class="fa fa-arrow-left"></i> Back</a>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Input @yield('title')</h4>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
                <div class="card-body bootstrap-select-1">
                    <form id="form-simpan" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="col-md-3 my-1 form-label">Jabatan Staff ?</label>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="staff" id="inlineRadio1" value="y">
                                    <label class="form-check-label" for="inlineRadio1">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="staff" id="inlineRadio2" value="n">
                                    <label class="form-check-label" for="inlineRadio2">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Team</label>
                            {{-- @if ($departemen->departemen == 'Top Managemen' || $departemen->departemen == 'Klaten')
                            <input type="text" name="team[]" class="form-control">
                            @else
                            <select name="team[]" class="select2 mb-3 select2-multiple tambah_team" id="" multiple="multiple"
                                data-placeholder="Choose">
                                @foreach ($biodata_karyawans as $biodata_karyawan)
                                    <option value="{{ $biodata_karyawan->nama }}">{{ $biodata_karyawan->nama }}</option>
                                @endforeach
                            </select>
                            @endif --}}
                            <br>
                            {{-- <select name="team[]" class="select2 mb-3 select2-multiple tambah_team" style="width: 100%" id="" multiple="multiple"
                                data-placeholder="Choose">
                                @foreach ($biodata_karyawans as $biodata_karyawan)
                                    <option value="{{ $biodata_karyawan->nama }}">{{ $biodata_karyawan->nama }}</option>
                                @endforeach
                            </select> --}}
                            {{-- <input type="text" name="team" class="form-control"> --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text" name="nik" class="form-control nik" placeholder="NIK">
                                        <button type="button" class="btn btn-primary" onclick="search_nik()"><i class="fa fa-search"></i> Cari</button>
                                    </div>
                                    <div id="check_nik"></div>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="team[]" class="form-control team" id="check_team" placeholder="Nama">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Departemen</th>
                                <th>Team</th>
                                <th>Jabatan</th>
                                <th>Action</th>
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
    <script src="{{ URL::asset('public/assets/js/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/huebee/huebee.pkgd.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/timepicker/bootstrap-material-datetimepicker.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}">
    </script>

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
            ajax: "{{ route('departemen.detail_team', $departemen->id) }}",
            columns: [{
                    data: 'departemen_id',
                    name: 'departemen_id'
                },
                {
                    data: 'team',
                    name: 'team'
                },
                {
                    data: 'staff',
                    name: 'staff'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $(".tambah_team").select2({
            tags: true
        });

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('departemen.team_simpan', $departemen->id) }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (result) => {
                    if (result.success != false) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        this.reset();
                        // $('.modalBuat').hide();
                        table.ajax.reload(null, false);
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

        function search_nik() {
            let formData = new FormData();
            formData.append('nik',$('.nik').val());
            $.ajax({
                type:'POST',
                url: "{{ route('departemen.search_nik') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
                    document.getElementById('check_nik').style.display = "block";
                    document.getElementById('check_nik').innerHTML = '<div class="spinner-border text-primary" role="status">'+'<span class="sr-only">Loading...</span>'+'</div>';
                    const team = document.getElementsByClassName('team');
                    team.readOnly = true;
                    // document.getElementById('check_nik').innerHTML = null;
                },
                success: (result) => {
                    if(result.success == true){
                        setTimeout(() => {
                            $('.team').val(result.data.nama);
                            document.getElementById('check_nik').style.display = "none";
                        }, 1000);
                    }else{
                        setTimeout(() => {
                            document.getElementById('check_nik').style.display = "block";
                        }, 1000);
                        $('#check_team').val(null);
                        // document.getElementById('check_nik').innerHTML = "NIK Tidak Ditemukan";
                        document.getElementById('check_nik').innerHTML = '<div class="alert alert-danger border-0" role="alert">'+
                                                                            '<strong>NIK Tidak Ditemukan!</strong> Silahkan dicek kembali'+
                                                                        '</div>';
                    }
                },
                error: function (request, status, error) {
                    // iziToast.error({
                    //     title: 'Error',
                    //     message: error,
                    // });
                }
            });
        }
    </script>
@endsection
