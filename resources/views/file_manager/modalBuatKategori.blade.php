<div class="modal fade modalBuatKategori" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Create Folder</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-kategori-simpan" method="post">
                @csrf
            <div class="modal-body">
                @if (auth()->user()->nik == '0000000')
                <div class="mb-3">
                    <label class="form-label">Departemen</label>
                    <select name="departemen_id" class="form-control" id="">
                        <option value="">select</option>
                        @foreach ($departemens as $departemen)
                        <option value="{{ $departemen->id }}">{{ $departemen->departemen }}</option>
                        @endforeach
                    </select>
                    {{-- <input type="text" name="kategori" class="form-control" placeholder="Nama Folder"> --}}
                </div>
                @endif
                <div class="mb-3">
                    <label class="form-label">Nama Folder</label>
                    <select name="kategori_file" class="form-control" id="">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="PK">PK</option>
                        <option value="SOP">SOP</option>
                        <option value="IK">IK</option>
                        <option value="ITI">ITI</option>
                        <option value="FR">FR</option>
                        <option value="SMK3">SMK3</option>
                    </select>
                    {{-- <input type="text" name="kategori" class="form-control" placeholder="Nama Folder"> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Buat</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>