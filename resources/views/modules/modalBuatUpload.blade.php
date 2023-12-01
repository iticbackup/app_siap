<div class="modal fade modalBuatUpload" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Upload File Modul</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama File</label>
                    <input type="text" name="title" class="form-control" placeholder="Nama File">
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload File</label>
                    <input type="file" name="files" class="dropify">
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