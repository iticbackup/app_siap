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

    <style>
        .btn-view {
            background-color: #74992e;
        }
    </style>
@endsection
@section('content')

    @include('fin_pro.device.modalBuat')
    @include('fin_pro.device.modalDetail')
    @include('fin_pro.device.modalEdit')

    <div class="row mt-4">
        <div class="col-md-12 mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">@yield('title')</h4>
                </div>
                <div class="col-auto">
                    @can('fingerprint-create')
                        <button class="btn btn-outline-primary" onclick="buat()" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter"><i class="fas fa-plus"></i> Create New Data</button>
                    @endcan
                </div>
            </div>
        </div>
        @foreach ($device_fin_pros as $key => $device_fin_pro)
            <div class="col-md-2">
                <div class="card">
                    <svg id="fi_18717283" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" class="card-img-top bg-light-alt">
                        <rect fill="#eff3f9" height="38" rx="2" width="38" x="5" y="5"></rect>
                        <circle cx="24" cy="24" fill="#cfe0f3" r="17"></circle>
                        <g fill="#08105e">
                            <path
                                d="m5 11c-.552 0-1-.448-1-1v-3c0-1.654 1.346-3 3-3h3c.552 0 1 .448 1 1s-.448 1-1 1h-3c-.551 0-1 .449-1 1v3c0 .552-.448 1-1 1z">
                            </path>
                            <path
                                d="m43 11c-.552 0-1-.448-1-1v-3c0-.551-.449-1-1-1h-3c-.552 0-1-.448-1-1s.448-1 1-1h3c1.654 0 3 1.346 3 3v3c0 .552-.448 1-1 1z">
                            </path>
                            <path
                                d="m41 44h-3c-.552 0-1-.448-1-1s.448-1 1-1h3c.551 0 1-.449 1-1v-3c0-.552.448-1 1-1s1 .448 1 1v3c0 1.654-1.346 3-3 3z">
                            </path>
                            <path
                                d="m10 44h-3c-1.654 0-3-1.346-3-3v-3c0-.552.448-1 1-1s1 .448 1 1v3c0 .551.449 1 1 1h3c.552 0 1 .448 1 1s-.448 1-1 1z">
                            </path>
                            <path
                                d="m24 42c-9.925 0-18-8.075-18-18s8.075-18 18-18 18 8.075 18 18-8.075 18-18 18zm0-34c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z">
                            </path>
                            <path
                                d="m36 25c-.552 0-1-.448-1-1 0-6.065-4.935-11-11-11-3.394 0-6.548 1.537-8.653 4.218-.342.433-.971.509-1.404.169-.435-.341-.51-.97-.169-1.404 2.487-3.167 6.215-4.982 10.227-4.982 7.168 0 13 5.832 13 13 0 .552-.448 1-1 1z">
                            </path>
                            <path
                                d="m12 25c-.552 0-1-.448-1-1 0-1.439.237-2.857.704-4.215.18-.523.75-.801 1.271-.621.522.18.8.749.621 1.271-.396 1.148-.596 2.348-.596 3.565 0 .552-.448 1-1 1z">
                            </path>
                            <path
                                d="m29.89 35.46c-.13 0-.263-.026-.391-.08-.508-.216-.745-.803-.529-1.312.324-.763.615-1.559.865-2.365.164-.528.725-.823 1.251-.659.528.164.823.724.659 1.251-.27.871-.584 1.73-.935 2.555-.162.381-.532.609-.921.609z">
                            </path>
                            <path
                                d="m31.691 29.1c-.049 0-.099-.003-.149-.011-.546-.082-.923-.591-.841-1.137.199-1.329.299-2.658.299-3.952 0-3.86-3.14-7-7-7h-.19c-.552 0-1-.448-1-1s.448-1 1-1h.19c4.962 0 9 4.038 9 9 0 1.393-.108 2.822-.321 4.248-.074.496-.501.852-.988.852z">
                            </path>
                            <path
                                d="m13.889 31.47c-.205 0-.411-.062-.589-.192-.446-.326-.543-.952-.218-1.397 1.254-1.717 1.917-3.75 1.917-5.88 0-3.177 1.707-6.151 4.454-7.763.475-.281 1.088-.12 1.369.357.279.477.12 1.089-.357 1.369-2.138 1.254-3.466 3.567-3.466 6.037 0 2.557-.796 4.999-2.302 7.06-.196.268-.5.41-.809.41z">
                            </path>
                            <path
                                d="m24.629 36.98c-.178 0-.359-.047-.522-.148-.471-.289-.618-.904-.329-1.375 2.108-3.435 3.222-7.396 3.222-11.457 0-1.654-1.346-3-3-3s-3 1.346-3 3c0 .389-.011.768-.044 1.146-.047.55-.536.963-1.082.91-.55-.047-.958-.532-.91-1.082.028-.322.036-.644.036-.974 0-2.757 2.243-5 5-5s5 2.243 5 5c0 4.431-1.216 8.754-3.518 12.503-.188.308-.517.477-.853.477z">
                            </path>
                            <path
                                d="m16.679 34.51c-.15 0-.303-.034-.446-.105-.494-.247-.694-.848-.447-1.342.123-.245.267-.478.43-.69.861-1.138 1.531-2.391 1.989-3.719.18-.522.748-.799 1.271-.619.522.18.799.75.619 1.271-.527 1.527-1.296 2.966-2.288 4.277-.093.123-.17.249-.232.374-.175.351-.528.553-.896.553z">
                            </path>
                            <path
                                d="m20.209 36.38c-.209 0-.419-.065-.6-.2-.441-.332-.531-.958-.199-1.4 2.349-3.128 3.59-6.855 3.59-10.779 0-.552.448-1 1-1s1 .448 1 1c0 4.36-1.38 8.503-3.99 11.98-.197.262-.497.399-.801.399z">
                            </path>
                        </g>
                    </svg>
                    {{-- <img src="assets/images/extra/card/ex-card.png" class="card-img-top bg-light-alt" alt="..."> --}}
                    <div class="card-body">
                        <h5 class="card-title mb-2">{{ $device_fin_pro->device_name }}</h5>
                        <div class="card-text">IP : {{ $device_fin_pro->ip_address }}</div>
                        <div class="card-text">Device ID : {{ $device_fin_pro->dev_id }}</div>
                        <div class="card-text">Port : {{ $device_fin_pro->ethernet_port }}</div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-view btn-sm text-white"
                            onclick="detail(`{{ $device_fin_pro->dev_id }}`)">View</button>
                        <button type="button" class="btn btn-warning btn-sm"
                            onclick="edit(`{{ $device_fin_pro->dev_id }}`)">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">@yield('title')</h4>
                        </div>
                        <div class="col-auto">
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
    </div> --}}
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
            order: [
                [2, 'asc']
            ]
        });

        function buat() {
            $('.modalBuat').modal('show');
        }

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('fin_pro.device_simpan') }}",
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
                        $('.modalBuat').hide();
                        setTimeout(() => {
                            window.location.href = "{{ route('fin_pro.device') }}";
                        }, 3000);
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

        function detail(dev_id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('mesin_finger/device/') }}" + '/' + dev_id + '',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        document.getElementById('detail_device_name').innerHTML = result.data.device_name;
                        document.getElementById('detail_device').innerHTML = result.data.fin_pro_device_type
                            .type;
                        document.getElementById('detail_device_sn').innerHTML = result.data.sn;
                        document.getElementById('detail_device_activation_code').innerHTML = result.data
                            .activation_code;
                        document.getElementById('detail_device_ip_address').innerHTML = result.data.ip_address;
                        document.getElementById('detail_device_comm_type').innerHTML = result.data.comm_type;
                        document.getElementById('detail_device_layar').innerHTML = result.data.layar == 0 ?
                            'TFT' : 'Black & White';
                        document.getElementById('detail_device_ethernet_port').innerHTML = result.data
                            .ethernet_port;
                        $('.modalDetail').modal('show');
                    } else {

                    }
                },
                error: function(request, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: error,
                    });
                }
            });
        }

        function edit(dev_id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('mesin_finger/device/') }}" + '/' + dev_id + '',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
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
                    } else {

                    }
                },
                error: function(request, status, error) {
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
                type: 'POST',
                url: "{{ route('fin_pro.device_update') }}",
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
                        $('.modalEdit').hide();
                        setTimeout(() => {
                            window.location.href = "{{ route('fin_pro.device') }}";
                        }, 3000);
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
    </script>
@endsection
