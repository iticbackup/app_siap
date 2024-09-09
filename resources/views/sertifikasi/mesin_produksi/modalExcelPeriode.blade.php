<div class="modal fade modalExcelPeriode" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Download Excel Sertifikasi Periode</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('hrga.sertifikasi.mesin_produksi.download_pdf') }}"
                enctype="multipart/form-data" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Periode</label>
                        <div class="input-group mb-3">
                            <select name="from_pdf_periode" class="form-control" id="">
                                <option value="">-- Select From Periode --</option>
                                @for ($i = 2021; $i <= 2026; $i++)
                                    <option>{{ $i }}</option>
                                @endfor
                            </select>
                            <label class="input-group-text">To</label>
                            <select name="to_pdf_periode" class="form-control" id="">
                                <option value="">-- Select To Periode --</option>
                                @for ($i = 2021; $i <= 2026; $i++)
                                    <option>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-soft-primary btn-sm">Download</button>
                    <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
