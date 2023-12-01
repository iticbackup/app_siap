<div class="modal fade modalBuatUploadFR" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Upload File FR</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-upload-file-fr" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="file_manager_category_id_fr" id="file_manager_category_id_fr">
                {{-- <input type="text" name="departemen_id" id="departemen_id"> --}}
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">No. Dokumen</label>
                    <input type="text" name="no_dokumen_fr" class="form-control" placeholder="No. Dokumen">
                    {{-- <span class="text-primary">Format penulisan: IT.xx.xxx.xx</span> --}}
                    <div class="mt-2">
                        <div>Cara Penulisan No. Dokumen:</div>
                        <ul>
                            <li>IT.IT.SOP.01 <i class="fas fa-check text-success"></i></li>
                            <li>IT/IT/SOP/01 <i class="fas fa-times text-danger"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama File</label>
                    <input type="text" name="title_fr" class="form-control" placeholder="Nama File">
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload File</label>
                    <input type="file" id="input-file-now" name="files_fr" class="dropify">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Submit</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>