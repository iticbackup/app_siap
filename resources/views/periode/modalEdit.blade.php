<div class="modal fade modalEdit" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Edit Periode</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post">
                @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Periode</label>
                    <input type="hidden" name="edit_id" class="form-control" id="edit_id" readonly autocomplete="off">
                    <input type="text" name="edit_periode" class="form-control" id="edit_periode" placeholder="Periode" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="edit_status" class="form-control" id="edit_status">
                        <option value="">-- Select Status --</option>
                        <option value="y">Aktif</option>
                        <option value="n">Non Aktif</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Update</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>