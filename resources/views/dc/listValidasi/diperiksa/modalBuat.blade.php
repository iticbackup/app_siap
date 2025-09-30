<div class="modal fade modalBuatDiperiksa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Buat Validasi Diperiksa</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan-diperiksa" method="post">
                @csrf
            <div class="modal-body">
                {{-- <div class="mb-3">
                    <label class="form-label">Nama Validasi</label>
                    <input type="text" name="name" class="form-control" placeholder="Nama Validasi">
                </div>
                <div class="mb-3">
                    <label class="form-label">Departemen</label>
                    <select name="departemen_id" class="form-control" id="">
                        <option value="">-- Pilih Departemen --</option>
                        @foreach ($departemen_diperiksas as $item)
                        <option value="{{ $item->id }}">{{ $item->departemen }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="mb-3">
                    <label class="form-label">Nama Karyawan</label>
                    <select name="name" class="form-control" id="">
                        <option value="">-- Pilih Nama Karyawan --</option>
                        @foreach ($departemen_diperiksas as $item)
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