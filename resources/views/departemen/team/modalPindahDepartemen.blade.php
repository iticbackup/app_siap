<div class="modal fade modalPindahDepartemen" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Pindah Departemen</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Team</label>
                        <input type="hidden" name="detail_team_id" id="detail_team_id">
                        <div id="detail_nama_team"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Departemen</label>
                        <div id="detail_departemen"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pindah Ke Departemen</label>
                        <select name="detail_pindah_departemen" class="form-control" id="detail_select_departemen">
                            <option value="">-- Departemen --</option>
                            @foreach ($departemens as $departemen)
                                <option value="{{ $departemen->id }}">{{ $departemen->departemen }}</option>
                            @endforeach
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
