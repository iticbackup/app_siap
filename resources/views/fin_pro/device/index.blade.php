@extends('layouts.apps.master')
@section('title')
    Device Mesin Fingerprint
@endsection
@section('css')
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

    @include('fin_pro.device.modalBuat')
    @include('fin_pro.device.modalDetail')
    @include('fin_pro.device.modalEdit')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
                            {{-- <a class="btn btn-outline-primary" href="#"><i class="fa fa-plus"></i> Create New Permission</a> --}}
                            @can('fingerprint-create')
                            <button class="btn btn-outline-primary" onclick="buat()" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter"><i class="fas fa-plus"></i> Create New Data</button>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">Device Name</th>
                                <th class="text-center">IP Address</th>
                                <th class="text-center">Device ID</th>
                                <th class="text-center">Port</th>
                                <th class="text-center">Serial Number</th>
                                <th class="text-center">Activation Code</th>
                                <th class="text-center">Last Download</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($device_fin_pros as $key => $device_fin_pro)
                                <tr>
                                    <td class="text-center">{{ $device_fin_pro->device_name }}</td>
                                    <td class="text-center">{{ $device_fin_pro->ip_address }}</td>
                                    <td class="text-center">{{ $device_fin_pro->dev_id }}</td>
                                    <td class="text-center">{{ $device_fin_pro->ethernet_port }}</td>
                                    <td class="text-center">{{ $device_fin_pro->sn }}</td>
                                    <td class="text-center">{{ $device_fin_pro->activation_code }}</td>
                                    <td class="text-center">{{ $device_fin_pro->last_download }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success" onclick="detail(`{{ $device_fin_pro->dev_id }}`)">Detail</button>
                                        <button type="button" class="btn btn-warning" onclick="edit(`{{ $device_fin_pro->dev_id }}`)">Edit</button>
                                        <button type="button" class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
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

        var table = $('#datatables').DataTable(
            {
                order: [[2,'asc']]
            }
        );

        function buat(){
            $('.modalBuat').modal('show');
        }

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type:'POST',
                url: "{{ route('fin_pro.device_simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (result) => {
                    if(result.success != false){
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        this.reset();
                        $('.modalBuat').hide();
                        setTimeout(() => {
                            window.location.href="{{ route('fin_pro.device') }}";
                        }, 3000);
                    }else{
                        iziToast.error({
                            title: result.success,
                            message: result.error
                        });
                    }
                },
                error: function (request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        });

        function detail(dev_id) {
            $.ajax({
                type:'GET',
                url: "{{ url('mesin_finger/device/') }}"+'/'+dev_id+'',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if(result.success == true){
                        document.getElementById('detail_device_name').innerHTML = result.data.device_name;
                        document.getElementById('detail_device').innerHTML = result.data.fin_pro_device_type.type;
                        document.getElementById('detail_device_sn').innerHTML = result.data.sn;
                        document.getElementById('detail_device_activation_code').innerHTML = result.data.activation_code;
                        document.getElementById('detail_device_ip_address').innerHTML = result.data.ip_address;
                        document.getElementById('detail_device_comm_type').innerHTML = result.data.comm_type;
                        document.getElementById('detail_device_layar').innerHTML = result.data.layar == 0 ? 'TFT' : 'Black & White';
                        document.getElementById('detail_device_ethernet_port').innerHTML = result.data.ethernet_port;
                        $('.modalDetail').modal('show');
                    }else{

                    }
                },
                error: function (request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        function edit(dev_id) {
            $.ajax({
                type:'GET',
                url: "{{ url('mesin_finger/device/') }}"+'/'+dev_id+'',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if(result.success == true){
                        $('#edit_id').val(result.data.device_name);
                        $('#edit_dev_id').val(result.data.dev_id);
                        $('#edit_device_name').val(result.data.device_name);
                        $('#edit_sn').val(result.data.sn);
                        $('#edit_activation_code').val(result.data.activation_code);
                        $('#edit_ip_address').val(result.data.ip_address);
                        $('#edit_comm_type').val(result.data.comm_type);
                        $('#edit_layar').val(result.data.layar);
                        $('#edit_ethernet_port').val(result.data.ethernet_port);
                        $('.modalEdit').modal('show');
                    }else{

                    }
                },
                error: function (request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type:'POST',
                url: "{{ route('fin_pro.device_update') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (result) => {
                    if(result.success != false){
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });
                        this.reset();
                        $('.modalEdit').hide();
                        setTimeout(() => {
                            window.location.href="{{ route('fin_pro.device') }}";
                        }, 3000);
                    }else{
                        iziToast.error({
                            title: result.success,
                            message: result.error
                        });
                    }
                },
                error: function (request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        });
    </script>
@endsection
