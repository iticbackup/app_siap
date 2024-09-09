<div class="modal fade modalBuat" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Buat Sertifikasi Mesin Produksi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>Jenis Mesin</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="jenis_mesin" class="form-control" placeholder="Jenis Mesin">
                        </td>
                    </tr>
                    <tr>
                        <td>No. Sertifikat</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="no_sertifikat" class="form-control"
                                placeholder="No. Sertifikat">
                        </td>
                    </tr>
                    <tr>
                        <td>Tgl Sertifikat Pertama</td>
                        <td>:</td>
                        <td>
                            <input type="date" name="tgl_sertifikat_pertama" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Periode Resertifikasi</td>
                        <td>:</td>
                        <td>
                            <div class="input-group">
                                <input type="number" name="periode_resertifikasi" class="form-control">
                                <label class="input-group-text">Tahun</label>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Submit</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>