<div class="modal fade modalBuatDataResign" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #F31559; color: white">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Buat Data Karyawan Resign</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-resign-simpan" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="mb-2">
                    <label for="">Cari Nama Karyawan</label>
                    <div class="input-group">
                        <input type="search" name="resign_nama_karyawan" class="form-control resign_nama_karyawan" id="">
                        <button type="button" class="btn btn-primary" id="resign-btn-search"><i class="fas fa-search"></i> Search</button>
                    </div>
                    <ul class="list-group" id="resign_result"></ul>
                </div>
                <hr>
                <div class="mb-2" id="resign-table"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Submit</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>