<div class="modal fade modalEditRepresentative" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" >Edit Validasi Representative</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="edit_id">
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama Anggota</label>
                    <select name="team" class="form-control" id="edit_team">
                        <option value="">-- Pilih Nama Anggota --</option>
                        @foreach ($departemens as $item)
                            <optgroup label="{{ $item->departemen }}">
                                @foreach ($item->departemen_user_all as $user)
                                <option value="{{ $user->nik.'|'.$user->team }}">{{ $user->team }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" id="edit_status">
                        <option value="">-- Pilih Status --</option>
                        <option value="Y">Aktif</option>
                        <option value="N">NonAktif</option>
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