<div class="modal fade modalBuatCategory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Buat Kategori</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-category-simpan" method="post">
                @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="dc_category_id" class="form-control">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($dc_categories as $category)
                            <option value="{{ $category->id }}">{{ $category->dc_category }}</option>
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