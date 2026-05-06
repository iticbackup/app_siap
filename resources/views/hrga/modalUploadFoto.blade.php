<div class="modal fade modalUploadFoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" id="title_button_action">
                <h6 class="modal-title m-0" id="title_button_action">Upload Foto Karyawan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="upload_foto_simpan" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="upload_foto_id" id="upload_foto_id">
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label align-self-center mb-lg-0 text-end">NIK :</label>
                        <div class="col-sm-10" id="upload_foto_nik">
                            {{-- <input class="form-control" type="text"> --}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Karyawan :</label>
                        <div class="col-sm-10" id="upload_foto_karyawan">
                            {{-- <input class="form-control" type="text" name="email"> --}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Upload Foto Karyawan :</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" name="foto_karyawan" placeholder="Upload Foto Karyawan">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>