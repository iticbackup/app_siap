<div class="modal fade modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Edit Kategori Dokumen Kontrol</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="dc_category" class="form-control" placeholder="Kategori" id="edit_dc_category">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="edit_status" class="form-control">
                        <option value="">-- Pilih Status --</option>
                        <option value="Active">Active</option>
                        <option value="InActive">InActive</option>
                    </select>
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