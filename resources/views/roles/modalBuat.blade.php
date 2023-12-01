<div class="modal fade modalBuat" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Buat User</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan" method="post">
                @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Name Access</label>
                    <input type="text" name="name" class="form-control" placeholder="Name Access">
                </div>
                <div class="mb-3">
                    <label class="form-label">Permission</label>
                    @foreach ($permission as $value)
                    <div>
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" id="">
                        {{ $value->name }}
                    </div>
                    @endforeach
                    {{-- <input type="text" name="name" class="form-control" placeholder="Nama"> --}}
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