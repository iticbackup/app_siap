@extends('layouts.apps.master')
@section('title')
    Departemen - {{ $departemen->departemen }}
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
    <link href="{{ URL::asset('public/assets/plugins/treeview/themes/default/style.css') }}" rel="stylesheet">

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

    @include('file_manager.modalBuatKategori')

    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">{{ $departemen->departemen }}</h4>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <!-- <i class="las la-menu align-self-center text-muted icon-xs"></i>  -->
                                    <i class="mdi mdi-dots-horizontal text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" onclick="buat_kategori()">Create Folder</a>
                                    {{-- <a class="dropdown-item" href="#">Delete</a>
                                    <a class="dropdown-item" href="#">Settings</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="jstree">
                        <ul>
                            @foreach ($file_manager_kategoris as $file_manager_kategori)
                            {{-- @php
                                $file_manager_lists = \App\Models\FileManagerList::where('file_manager_category_id',$file_manager_kategori->id)->get();
                            @endphp --}}
                            <li data-jstree='{"icon":"fa fa-folder text-warning font-18"}'>
                                {{ $file_manager_kategori->kategori }}
                                {{-- <ul>
                                    @foreach ($file_manager_lists as $file_manager_list)
                                    <li data-jstree='{"icon":"fa fa-folder text-primary font-18"}'>$file_manager_list</li>
                                    @endforeach
                                </ul> --}}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- <div class="files-nav">
                        <div class="nav flex-column nav-pills" id="folder_kategori">
                            <a class="nav-link" href="javascript:void()" aria-selected="true">
                                <i data-feather="folder" class="align-self-center icon-dual-file icon-sm me-3"></i>
                                <div class="d-inline-block align-self-center">
                                    <h5 class="m-0">Projects</h5>
                                    <small>80GB/200GB Used</small>
                                </div>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">{{ $departemen->departemen }}</h4>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <!-- <i class="las la-menu align-self-center text-muted icon-xs"></i>  -->
                                    <i class="mdi mdi-dots-horizontal text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Create Folder</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                    <a class="dropdown-item" href="#">Settings</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="title_file_manager"></div>
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">Title</th>
                            </tr>
                        </thead>
                        <tbody>
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
    <script src="{{ URL::asset('public/assets/plugins/treeview/jstree.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.treeview.init.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function buat_kategori() {
            $('.modalBuatKategori').modal('show');
        }

        // function get_kategori() {
        //     $.ajax({
        //         type:'GET',
        //         url: "{{ route('file_manager.kategori',['id' => $departemen->id]) }}",
        //         contentType: "application/json;  charset=utf-8",
        //         cache: false,
        //         success: (result) => {
        //             const dataKategori = result.data;
        //             var txtKategori = ""
        //             dataKategori.forEach(data_kategori);
                    
        //             function data_kategori(value, index){
        //                 txtKategori = txtKategori+"<a class='nav-link' href='#' aria-selected='true'>";
        //                 txtKategori = txtKategori+"<i class='mdi mdi-folder-text align-self-center icon-dual-file icon-sm me-3'></i>";
        //                 txtKategori = txtKategori+"<div class='d-inline-block align-self-center'>";
        //                 txtKategori = txtKategori+"<h5 class='m-0'>"+value.kategori+"</h5>";
        //                 txtKategori = txtKategori+"</div>";
        //                 txtKategori = txtKategori+"</a>";
        //             }
                    
        //             document.getElementById('folder_kategori').innerHTML = txtKategori;
        //             // console.table(result.data);
        //         },
        //         error: function (request, status, error) {
        //             iziToast.error({
        //                 title: 'Error',
        //                 message: error,
        //             });
        //         }
        //     });
        // }

        $(document).ready(function(){
            // get_kategori();
        })

        $('#form-kategori-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type:'POST',
                url: "{{ route('file_manager.kategori_simpan',['id' => $departemen->id]) }}",
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
                        // get_kategori();
                        $('.modalBuatKategori').modal('close');
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
