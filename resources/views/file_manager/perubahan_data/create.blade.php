@extends('layouts.apps.master')
@section('title')
    Buat Perubahan Dokumen
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/css/iziToast.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ URL::asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"> --}}
    <style>
        @media (max-width: 1518px) {
            .table-container { 
                /* width: 100% !important; */
                overflow-x: scroll; 
                width: 65%;
            }
        }
        @media (max-width: 1920px) {
            .table-container { 
                /* width: 100% !important; */
                overflow-x: scroll; 
                width: 99.9%;
            }
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
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <h4 class="card-title text-white text-center" style="font-size: 14pt">Formulir Perubahan Dokumen</h4>
                </div>
                {{-- <form action="{{ route('perubahan_data.simpan') }}" method="post" enctype="multipart/form-data"> --}}
                <div class="card-body">
                    <form id="detail_post" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">No. Dokumen</label>
                                    <input type="text" name="no_dokumen" class="form-control" placeholder="No. Dokumen"
                                        id="">
                                    <div class="text-primary" style="font-size: 9pt">Format penulisan: IT/xx/xxx/xx</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Halaman</label>
                                    <input type="text" name="halaman" class="form-control" placeholder="Halaman"
                                        id="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Revisi</label>
                                    <input type="text" name="revisi" class="form-control" placeholder="Revisi"
                                        id="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kategori File</label>
                                    <select name="kategori_file" class="form-control" id="">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="PK">PK</option>
                                        <option value="SOP">SOP</option>
                                        <option value="IK">IK</option>
                                        <option value="ITI">ITI</option>
                                        <option value="FR">FR</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Upload File</label>
                                    <input type="file" name="files" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Uraian Perubahan</label>
                                    <span></span>
                                    <textarea name="uraian_perubahan" class="form-control editor" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">No. Dokumen</label>
                                            <input type="text" name="no_dokumen" class="form-control" placeholder="No. Dokumen"
                                                id="">
                                            <div class="text-primary" style="font-size: 8pt">Format penulisan: IT/xx/xxx/xx</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">Halaman</label>
                                            <input type="text" name="halaman" class="form-control" placeholder="Halaman"
                                                id="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">Revisi</label>
                                            <input type="text" name="revisi" class="form-control" placeholder="Revisi"
                                                id="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">Kategori File</label>
                                            <select name="kategori_file" class="form-control" id="">
                                                <option value="">-- Pilih Kategori --</option>
                                                <option value="PK">PK</option>
                                                <option value="SOP">SOP</option>
                                                <option value="IK">IK</option>
                                                <option value="ITI">ITI</option>
                                                <option value="FR">FR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-1">
                                <div class="mb-3">
                                    <label class="form-label">No. Dokumen</label>
                                    <input type="text" name="no_dokumen" class="form-control" placeholder="No. Dokumen"
                                        id="">
                                    <div class="text-primary" style="font-size: 9pt">Format penulisan: IT/xx/xxx/xx</div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-1">
                                <div class="mb-3">
                                    <label class="form-label">Halaman</label>
                                    <input type="text" name="halaman" class="form-control" placeholder="Halaman"
                                        id="">
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-1">
                                <div class="mb-3">
                                    <label class="form-label">Revisi</label>
                                    <input type="text" name="revisi" class="form-control" placeholder="Revisi"
                                        id="">
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-1">
                                <div class="mb-3">
                                    <label class="form-label">Kategori File</label>
                                    <select name="kategori_file" class="form-control" id="">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="PK">PK</option>
                                        <option value="SOP">SOP</option>
                                        <option value="IK">IK</option>
                                        <option value="ITI">ITI</option>
                                        <option value="FR">FR</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">Uraian Perubahan</label>
                                    <span></span>
                                    <textarea name="uraian_perubahan" class="form-control editor" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Upload File</label>
                                    <input type="file" name="files" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr style="border-top: 1px dashed rgb(0, 17, 255);">
                    </form>
                    <form id="formulir_simpan" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">No. Formulir</label>
                                <input type="text" class="form-control"
                                    value="{{ $file_manager_perubahan_data->kode_formulir }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Formulir Dibuat</label>
                                <input type="date" name="tanggal_formulir" class="form-control" required id="">
                            </div>
                        </div>
                        <hr style="border-top: 1px dashed rgb(0, 17, 255);">
                        <h5>Detail Formulir</h5>
                        <div class="table-container">
                            <table id="datatables" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No. Dokumen</th>
                                        <th class="text-center">Halaman</th>
                                        <th class="text-center">Revisi</th>
                                        <th class="text-center">Kategori File</th>
                                        <th class="text-center">Uraian Perubahan</th>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Submit</button>
                            <button type="button" class="btn btn-success" onclick="save_change()"><i class="fa fa-save"></i> Save Change</button>
                            <a href="{{ route('perubahan_data') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </form>
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
    <script src="{{ URL::asset('public/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.form-repeater.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> --}}
    <script src="{{ URL::asset('public/assets/js/iziToast.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/ckeditor.js') }}"></script>
    {{-- <script src="{{ URL::asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/pages/jquery.form-upload.init.js') }}"></script> --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        ClassicEditor
            .create(document.querySelector('.editor'),{
                toolbar: [ 'bold', 'italic', 'numberedList', 'bulletedList' ]
            });
        // $('#summernote').summernote({
        //     toolbar:[

        //     // This is a Custom Button in a new Toolbar Area
        //     ['custom', ['examplePlugin']],

        //     // You can also add Interaction to an existing Toolbar Area
        //     ['style', ['style' ,'examplePlugin']]
        //     ]
        // });

        $(document).ready(function(){
            $('.modalLoading').modal('show');
        });

        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('perubahan_data.create', ['id' => $file_manager_perubahan_data->id]) }}",
            columns: [{
                    data: 'no_dokumen',
                    name: 'no_dokumen'
                },
                {
                    data: 'halaman',
                    name: 'halaman'
                },
                {
                    data: 'revisi',
                    name: 'revisi'
                },
                {
                    data: 'kategori_file',
                    name: 'kategori_file'
                },
                {
                    data: 'uraian_perubahan',
                    name: 'uraian_perubahan'
                },
                {
                    data: 'files',
                    name: 'files'
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
                    targets: [0, 1, 2, 3, 5, 6]
                },
            ],
        });

        $('#detail_post').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            // alert(formData);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('perubahan_data.detail_form_simpan', ['id' => $file_manager_perubahan_data->id]) }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('.modalLoading').modal('show');
                    // document.getElementById('view_download').innerHTML =
                    //     "<div class='spinner-border spinner-border-custom-2 text-primary' role='status'></div>";
                },
                success: (result) => {
                    if (result.success != false) {
                        iziToast.success({
                            title: result.message_title,
                            message: result.message_content
                        });

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

        $('#formulir_simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            // // alert(formData);
            // // $('#image-input-error').text('');
            // $.ajax({
            //     type: 'POST',
            //     url: "{{ route('perubahan_data.detail_form_simpan', ['id' => $file_manager_perubahan_data->id]) }}",
            //     data: formData,
            //     contentType: false,
            //     processData: false,
            //     beforeSend: function() {
            //         // $('.modalLoading').modal('show');
            //         // document.getElementById('view_download').innerHTML =
            //         //     "<div class='spinner-border spinner-border-custom-2 text-primary' role='status'></div>";
            //     },
            //     success: (result) => {
            //         if (result.success != false) {
            //             iziToast.success({
            //                 title: result.message_title,
            //                 message: result.message_content
            //             });

            //             table.ajax.reload(null, false);

            //         }else{
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

            iziToast.show({
                theme: 'dark',
                icon: 'icon-person',
                title: 'Pemberitahuan',
                message: 'Apakah sudah melengkapi semua formulir ini ?',
                position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    ['<button>Ya</button>', function(instance, toast) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('perubahan_data.simpan', ['id' => $file_manager_perubahan_data->id]) }}",
                            data: formData,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                $('.modalLoading').modal('show');
                                // document.getElementById('view_download').innerHTML =
                                //     "<div class='spinner-border spinner-border-custom-2 text-primary' role='status'></div>";
                            },
                            success: (result) => {
                                if (result.success != false) {
                                    iziToast.success({
                                        title: result.message_title,
                                        message: result.message_content
                                    });
                                    setTimeout(() => {
                                        $('.modalLoading').modal('hide');
                                        window.location.href =
                                            result.link;
                                    }, 5000);
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
                    }, false], // true to focus
                    ['<button>Tidak</button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutUp',
                            onClosing: function(instance, toast, closedBy) {
                                console.info('closedBy: ' +
                                    closedBy
                                    ); // The return will be: 'closedBy: buttonName'
                            }
                        }, toast, 'buttonName');
                    }]
                ],
                onOpening: function(instance, toast) {
                    console.info('callback abriu!');
                },
                onClosing: function(instance, toast, closedBy) {
                    console.info('closedBy: ' +
                        closedBy); // tells if it was closed by 'drag' or 'button'
                }
            });
        });

        function delete_formulir_perubahan(id, id_perubahan_data) {
            // alert(id_perubahan_data);
            iziToast.show({
                theme: 'dark',
                icon: 'icon-person',
                title: 'Pemberitahuan',
                message: 'Apakah yakin untuk menghapus ini ?',
                position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(252, 45, 45)',
                buttons: [
                    ['<button>Ya</button>', function(instance, toast) {
                        $.ajax({
                            type: 'GET',
                            url: "{{ url('perubahan_data/') }}"+'/'+id+'/'+id_perubahan_data+'/'+'delete',
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                // $('.modalLoading').modal('show');
                                // document.getElementById('view_download').innerHTML =
                                //     "<div class='spinner-border spinner-border-custom-2 text-primary' role='status'></div>";
                            },
                            success: (result) => {
                                if (result.success != false) {
                                    iziToast.success({
                                        title: result.message_title,
                                        message: result.message_content
                                    });
                                    // setTimeout(() => {
                                    //     $('.modalLoading').modal('hide');
                                    //     window.location.href =
                                    //         result.link;
                                    // }, 5000);
                                    table.ajax.reload();
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
                    }, false], // true to focus
                    ['<button>Tidak</button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutUp',
                            onClosing: function(instance, toast, closedBy) {
                                console.info('closedBy: ' +
                                    closedBy
                                    ); // The return will be: 'closedBy: buttonName'
                            }
                        }, toast, 'buttonName');
                    }]
                ],
                onOpening: function(instance, toast) {
                    console.info('callback abriu!');
                },
                onClosing: function(instance, toast, closedBy) {
                    console.info('closedBy: ' +
                        closedBy); // tells if it was closed by 'drag' or 'button'
                }
            });
        }

        function save_change() {
            iziToast.success({
                title: 'Save Change',
                message: 'Data perubahan telah disimpan'
            });
        }
    </script>
@endsection
