@extends('layouts.apps.master')
@section('title')
    File Manager
@endsection

@section('css')
    <link href="{{ URL::asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/treeview/themes/default/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css">
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
    @include('file_manager.modalBuatKategori')
    @include('file_manager.modalBuatUpload')
    @include('file_manager.modalBuatUploadFR')
    @include('file_manager.modalPreviewFile')
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">File Manager</h4>
                        </div>
                        <div class="col-auto">
                            {{-- <div class="dropdown">
                                <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <!-- <i class="las la-menu align-self-center text-muted icon-xs"></i>  -->
                                    <i class="mdi mdi-dots-horizontal text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" onclick="buat_kategori()">Create Folder</a>
                                </div>
                            </div> --}}
                            @if (auth()->user()->nik == '0000000')
                                <a class="btn btn-outline-primary" onclick="buat_kategori()"><i
                                        class="fas fa-plus me-2 "></i>Create Folder</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="jstree">
                        <ul>
                            @foreach ($departemens as $departemen)
                                @php
                                    $file_manager_kategoris = \App\Models\FileManagerCategory::where('departemen_id', $departemen->id)->get();
                                @endphp
                                <li data-jstree='{"icon":"fa fa-folder text-warning font-18"}'>{{ $departemen->departemen }}
                                    <ul>
                                        @foreach ($file_manager_kategoris as $file_manager_kategori)
                                            <li data-jstree='{"icon":"fa fa-folder text-warning font-18"}'>
                                                <a href="javascript:void()"
                                                    onclick="kategori_list({{ $file_manager_kategori->id }})">{{ $file_manager_kategori->kategori }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <div id="text_file_manager"></div>
                    <div id="title_file_manager"></div>
                </div>
                <div class="card-body">
                    <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="data-body"></tbody>
                    </table>
                    {{-- <table id="datatables" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table> --}}
                </div>
            </div>
        </div>
        {{-- @foreach ($departemens as $departemen)
            <div class="col-md-3">
                <a href="{{ route('file_manager.detail_departemen',['id' => $departemen->id]) }}">
                    <div class="card" style="background-color: #F8F0E5">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{ asset('public/assets/images/hierarchy-structure.png') }}" width="100">
                                <h4>{{ $departemen->departemen }}</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach --}}
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
    <script src="{{ URL::asset('public/assets/plugins/treeview/jstree.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.treeview.init.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.form-upload.init.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js" integrity="sha512-Z8CqofpIcnJN80feS2uccz+pXWgZzeKxDsDNMD/dJ6997/LSRY+W4NmEt9acwR+Gt9OHN0kkI1CTianCwoqcjQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function buat_kategori() {
            $('.modalBuatKategori').modal('show');
        }

        $('#form-kategori-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('file_manager.kategori_simpan') }}",
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
                        // get_kategori();
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                        $('.modalBuatKategori').modal('close');
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

        // function kategori_list(id) {
        //     // alert(id);
        //     var table = $('#datatables').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ url('file_manager/kategori/') }}"+'/'+id,
        //         columns: [
        //             {
        //                 data: 'title',
        //                 name: 'title'
        //             },
        //             {
        //                 data: 'action',
        //                 name: 'action',
        //                 orderable: false,
        //                 searchable: false
        //             },
        //         ]
        //     });
        // }
        // const kategori_id = [];
        function kategori_list(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('file_manager/kategori/') }}" + '/' + id,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function(xhr) {
                    document.getElementById('data-body').innerHTML = "<tr>" +
                        "<td colspan='2' class='text-center'>" +
                        "<div class='spinner-border spinner-border-custom-2 text-primary' role='status'></div>" +
                        "</td>" +
                        "</tr>";
                },
                success: (result) => {
                    if (result.success == true) {

                        if (result.status_aktif == true) {
                            if (result.kategori != 'FR' && result.kategori != 'ITI') {
                                var x = document.getElementById('title_file_manager');
                                x.style.display = "block";
                                x.innerHTML = '<div>' +
                                    '<div class="alert alert-outline-primary" role="alert">' +
                                    '<strong>Informasi!</strong> ' + result.status_message +
                                    '</div>' +
                                    // '<span class="badge bg-primary" style="font-size:12pt; margin-bottom: 0.5%">'+result.status_message+'</span><br>'+
                                    '<div class="button-items">' +
                                    '<button onclick="uploadBerkas(`' + result.kategori_id +
                                '`)" class="btn btn-outline-primary btn-sm add-file"><i class="las la-cloud-upload-alt me-2 font-15"></i>Upload File</button>' +
                                    '<button onclick="uploadBerkasFR(`' + result.kategori_id +
                                '`)" class="btn btn-outline-danger btn-sm add-file"><i class="las la-cloud-upload-alt me-2 font-15"></i>Upload FR</button>' +
                                    // '<button onclick="alert(`'+"Fitur ini sedang maintenance"+'`)" class="btn btn-outline-danger btn-sm add-file"><i class="las la-cloud-upload-alt me-2 font-15"></i>Upload FR</button>'+
                                    '</div>'
                                '</div>';

                                document.getElementById('text_file_manager').innerHTML = '<h5>'+result.kategori+'<h5>';
                            } else {
                                var x = document.getElementById('title_file_manager');
                                //    x.style.display = "none";
                                x.innerHTML = '<div>' +
                                    '<div class="alert alert-outline-primary" role="alert">' +
                                    '<strong>Informasi!</strong> ' + result.status_message +
                                    '</div>' +
                                    // '<span class="badge bg-primary" style="font-size:12pt; margin-bottom: 0.5%">'+result.status_message+'</span><br>'+
                                    '<div class="button-items">' +
                                    '<button onclick="uploadBerkas(`' + result.kategori_id +
                                '`)" class="btn btn-outline-primary btn-sm add-file"><i class="las la-cloud-upload-alt me-2 font-15"></i>Upload File</button>' +
                                    // '<button onclick="alert(`'+"Fitur ini sedang maintenance"+'`)" class="btn btn-outline-danger btn-sm add-file"><i class="las la-cloud-upload-alt me-2 font-15"></i>Upload FR</button>'+
                                    '</div>'
                                '</div>';

                                document.getElementById('text_file_manager').innerHTML = '<h5>'+result.kategori+'<h5>';
                            }
                        }else{
                            if (result.kategori == 'ITI' || result.kategori == 'FR') {
                                var x = document.getElementById('title_file_manager');
                                x.style.display = "block";
                                x.innerHTML = '<div>' +
                                    '<div class="button-items">' +
                                    '<button onclick="uploadBerkas(`' + result.kategori_id +
                                '`)" class="btn btn-outline-primary btn-sm add-file"><i class="las la-cloud-upload-alt me-2 font-15"></i>Upload File</button>' +
                                    // '<button onclick="alert(`'+"Fitur ini sedang maintenance"+'`)" class="btn btn-outline-danger btn-sm add-file"><i class="las la-cloud-upload-alt me-2 font-15"></i>Upload FR</button>'+
                                    '</div>'
                                '</div>';

                                document.getElementById('text_file_manager').innerHTML = '<h5>'+result.kategori+'<h5>';
                            }else{
                                var x = document.getElementById('title_file_manager');
                                x.style.display = "none";

                                // document.getElementById('text_file_manager').innerHTML = '<h5>'+result.kategori+'<h5>';
                                document.getElementById('text_file_manager').innerHTML = "<h5>"+result.kategori+"</h5>"+
                                                                                        "@can('filemanager_upload')"+
                                                                                        "<div>"+
                                                                                            '<div class="button-items">' +
                                                                                                '<button onclick="uploadBerkas(`' + result.kategori_id +
                                                                                            '`)" class="btn btn-outline-primary btn-sm add-file"><i class="las la-cloud-upload-alt me-2 font-15"></i>Upload File</button>' +
                                                                                                '<button onclick="uploadBerkasFR(`' + result.kategori_id +
                                                                                            '`)" class="btn btn-outline-danger btn-sm add-file"><i class="las la-cloud-upload-alt me-2 font-15"></i>Upload FR</button>' +
                                                                                        "</div>"+
                                                                                        "@endcan";
                            }
                        }
                        const dataFileManagerList = result.data;
                        var txtFileManagerList = "";
                        dataFileManagerList.forEach(data_file_manager_list);

                        function data_file_manager_list(value, index) {
                            txtFileManagerList = txtFileManagerList + "<tr>";
                            txtFileManagerList = txtFileManagerList + "<td>" +
                                                                        "<span class='badge bg-primary'>" + value.no_dokumen + "</span>" + " - " +
                                                                        "<span>" + value.title + "</span>" + "</td>";
                            if (result.status_aktif == true) {
                                txtFileManagerList = txtFileManagerList + "<td>" +
                                                                                "<div class='btn-group'>" +
                                                                                "<button class='btn btn-success' onclick='preview_file(" + value.id +
                                                                                ")'><i class='fas fa-eye'></i> Preview</button>" +
                                                                                "<a class='btn btn-primary' href='{{ url('file_manager/download/') }}" + '/' +
                                                                                value.id + "'><i class='fas fa-download'></i> Download</a>" +
                                                                                '<button onclick="hapus_file(`' + value.id + '`)" class="btn btn-danger">' +
                                                                                "<i class='fas fa-trash'></i>" + "</button>" +
                                                                                // '<button onclick="alert(`'+"Fitur ini sedang maintenance"+'`)" class="btn btn-danger">'+"<i class='fas fa-trash'></i>"+"</button>"+
                                                                                "</div>" +
                                                                            "</td>";
                            }else{
                                if (result.kategori == 'ITI' || result.kategori == 'FR') {
                                    txtFileManagerList = txtFileManagerList + "<td>" +
                                                                                    "<div class='btn-group'>" +
                                                                                        "<button class='btn btn-success' onclick='preview_file(" + value.id +
                                                                                        ")'><i class='fas fa-eye'></i> Preview</button>" +
                                                                                    "<a class='btn btn-primary' href='{{ url('file_manager/download/') }}" + '/' +
                                                                                    value.id + "'><i class='fas fa-download'></i> Download</a>" +
                                                                                    '<button onclick="hapus_file(`' + value.id + '`)" class="btn btn-danger">' +
                                                                                    "<i class='fas fa-trash'></i>" + "</button>" +
                                                                                    // '<button onclick="alert(`'+"Fitur ini sedang maintenance"+'`)" class="btn btn-danger">'+"<i class='fas fa-trash'></i>"+"</button>"+
                                                                                    "</div>" +
                                                                                "</td>";
                                }else{
                                    txtFileManagerList = txtFileManagerList + "<td>" +
                                                                                    "<div class='btn-group'>" +
                                                                                        "<button class='btn btn-success' onclick='preview_file(" + value.id +
                                                                                        ")'><i class='fas fa-eye'></i> Preview</button>" +
                                                                                    "<a class='btn btn-primary' href='{{ url('file_manager/download/') }}" + '/' +
                                                                                    value.id + "'><i class='fas fa-download'></i> Download</a>" +
                                                                                    "@can('filemanager_delete')"+
                                                                                    '<button onclick="hapus_file(`' + value.id + '`)" class="btn btn-danger">' +
                                                                                    "<i class='fas fa-trash'></i>" + "</button>" +
                                                                                    "@endcan"+
                                                                                    // '<button onclick="alert(`'+"Fitur ini sedang maintenance"+'`)" class="btn btn-danger">'+"<i class='fas fa-trash'></i>"+"</button>"+
                                                                                    "</div>" +
                                                                                "</td>";
                                }

                            }
                            txtFileManagerList = txtFileManagerList + "</tr>";
                        }
                        document.getElementById('data-body').innerHTML = txtFileManagerList;

                        if (!result.data.length) {
                            // alert('data tidak ditemukan');
                            document.getElementById('data-body').innerHTML = '<tr>'+
                                                                                "<td colspan='2' class='text-center'>" +
                                                                                    "Data Belum Tersedia" +
                                                                                "</td>" +
                                                                            '</tr>';
                        }
                    } else {

                    }
                },
                error: function(request, status, error) {

                }
            });
        }

        function hapus_file(id) {
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '$success',
                cancelButtonColor: '$danger',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if (result.value) {
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('file_manager/delete/') }}" + '/' + id,
                        contentType: "application/json;  charset=utf-8",
                        cache: false,
                        beforeSend: function(xhr) {
                            document.getElementById('data-body').innerHTML = "<tr>" +
                                "<td colspan='2' class='text-center'>" +
                                "<div class='spinner-border spinner-border-custom-2 text-primary' role='status'></div>" +
                                "</td>" +
                                "</tr>";
                        },
                        success: (result) => {
                            if (result.success == true) {
                                iziToast.success({
                                    title: result.message_title,
                                    message: result.message_content
                                });
                                kategori_list(result.file_manager_category_id);
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
                }
            })
            // $.ajax({
            //     type: 'GET',
            //     url: "{{ url('file_manager/delete/') }}" + '/' + id,
            //     contentType: "application/json;  charset=utf-8",
            //     cache: false,
            //     beforeSend: function(xhr) {
            //         document.getElementById('data-body').innerHTML = "<tr>" +
            //             "<td colspan='2' class='text-center'>" +
            //             "<div class='spinner-border spinner-border-custom-2 text-primary' role='status'></div>" +
            //             "</td>" +
            //             "</tr>";
            //     },
            //     success: (result) => {
            //         if (result.success == true) {
            //             iziToast.success({
            //                 title: result.message_title,
            //                 message: result.message_content
            //             });
            //             kategori_list(result.file_manager_category_id);
            //         } else {
            //             iziToast.error({
            //                 title: result.success,
            //                 message: result.error
            //             });
            //         }
            //     },
            //     error: function(request, status, error) {
            //         iziToast.error({
            //             title: 'Error',
            //             message: error,
            //         });
            //     }
            // });
        }

        function uploadBerkas(kategori_id) {
            // alert(kategori_id);
            $('#file_manager_category_id').val(kategori_id);
            // $('#departemen_id').val(kategori_id);
            $('.modalBuatUpload').modal('show');
        }

        function uploadBerkasFR(kategori_id) {
            // alert(kategori_id);
            $('#file_manager_category_id_fr').val(kategori_id);
            // $('#departemen_id').val(kategori_id);
            $('.modalBuatUploadFR').modal('show');
        }

        $('#form-upload-file').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('file_manager.file_manager_list_upload_simpan') }}",
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
                        // get_kategori();
                        setTimeout(() => {
                            // location.reload();
                        }, 3000);
                        kategori_list(result.kategori_id);
                        $('.modalBuatUpload').modal('hide');
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

        $('#form-upload-file-fr').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('file_manager.file_manager_list_upload_fr_simpan') }}",
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
                        // get_kategori();
                        setTimeout(() => {
                            // location.reload();
                        }, 3000);
                        kategori_list(result.kategori_id);
                        $('.modalBuatUploadFR').modal('hide');
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

        function preview_file(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('file_manager/preview/') }}" + '/' + id,
                contentType: "application/json;  charset=utf-8",
                cache: false,
                success: (result) => {
                    if (result.success == true) {
                        document.getElementById('preview_file').innerHTML = '<iframe src="' + result.url +
                            '" width="100%" height="720px" scrolling="auto" frameBorder="0"></frame>';
                        $('.modalPreviewFile').modal('show');
                    } else {

                    }
                },
                error: function(request, status, error) {

                }
            });
        }

        // function download_file(id) {
        //     $.ajax({
        //         type:'GET',
        //         url: "{{ url('file_manager/download/') }}"+'/'+id,
        //         contentType: "application/json;  charset=utf-8",
        //         cache: false,
        //         success: (result) => {
        //             if(result.success == true){

        //             }else{

        //             }
        //         },
        //         error: function (request, status, error) {
        //         }
        //     });
        // }
    </script>
@endsection
