<div class="modal fade modalBuatDisetujui" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Buat Validasi Disetujui</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan-disetujui" method="post">
                @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Validasi</label>
                    <input type="text" name="name" class="form-control" placeholder="Nama Validasi">
                </div>
                <div class="mb-3">
                    <label class="form-label">Departemen</label>
                    <select name="departemen_id" class="form-control" id="">
                        <option value="">-- Pilih Departemen --</option>
                        @foreach ($departemen_disetujuis as $item)
                        <option value="{{ $item->id }}">{{ $item->departemen }}</option>
                        @endforeach
                    </select>
                    {{-- <input type="text" name="departemen" class="form-control" placeholder="Departemen"> --}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="" class="form-control">
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