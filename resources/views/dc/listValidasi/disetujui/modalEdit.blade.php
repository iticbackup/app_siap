<div class="modal fade modalEditDisetujui" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Edit Validasi Disetujui</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-edit-disetujui" method="post">
                @csrf
                <input type="hidden" name="id" id="edit_id_validasi_disetujui">
            <div class="modal-body">
                {{-- <div class="mb-3">
                    <label class="form-label">Nama Validasi</label>
                    <input type="text" name="name" class="form-control" id="edit_name_validasi_disetujui" placeholder="Nama Validasi">
                </div>
                <div class="mb-3">
                    <label class="form-label">Departemen</label>
                    <select name="departemen_id" class="form-control" id="edit_departemen_id_validasi_disetujui">
                        <option value="">-- Pilih Departemen --</option>
                        @foreach ($departemen_disetujuis as $item)
                        <option value="{{ $item->id }}">{{ $item->departemen }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="mb-3">
                    <label class="form-label">Nama Manajemen</label>
                    <select name="name" class="form-control" id="edit_departemen_id_validasi_disetujui">
                        <option value="">-- Pilih Nama Manajemen --</option>
                        @foreach ($departemen_disetujuis as $item)
                            <optgroup label="{{ $item->departemen }}">
                                @foreach ($item->departemen_user_all as $user)
                                <option value="{{ $user->nik.'|'.$user->team.'|'.$item->id }}">{{ $user->team }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="edit_status_validasi_disetujui" class="form-control">
                        <option value="">-- Pilih Status --</option>
                        <option value="Active">Active</option>
                        <option value="InActive">InActive</option>
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