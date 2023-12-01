<div class="modal fade modalExcelPeriode" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Download Rekap Data Karyawan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="search_rekap_all" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Tanggal Rekap</label>
                    <div class="input-group">
                        <input type="date" name="search_date_download" class="form-control" id="search_date_download">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="mb-3">
                    <div id="view_download"></div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Search</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div> --}}
            </form>
        </div>
    </div>
</div