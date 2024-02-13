<div class="modal fade modalEditTeam" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Edit Team</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Team</label>
                        <input type="text" name="edit_team_id" id="edit_team_id">
                        <div id="edit_nama_team"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Departemen</label>
                        <div id="edit_departemen"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Jenis Kelamin</label>
                        <select name="edit_jenis_kelamin" class="form-control" id="edit_jenis_kelamin">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki - Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Status Karyawan</label>
                        <select name="edit_status" class="form-control" id="edit_status">
                            <option value="">-- Status Karyawan --</option>
                            <option value="Y">Aktif</option>
                            <option value="N">Non Aktif</option>
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
