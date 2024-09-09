<div class="modal fade modalEdit" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Edit Sertifikasi - {{ $mesin_produksi->jenis_mesin }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id">
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>Tanggal Periksa Uji</td>
                        <td>:</td>
                        <td>
                            <input type="date" name="edit_tgl_periksa_uji" id="edit_tgl_periksa_uji" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Terbit Sertifikat</td>
                        <td>:</td>
                        <td>
                            <input type="date" name="edit_tgl_terbit_sertifikat" id="edit_tgl_terbit_sertifikat" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>No. Sertifikat Terakhir</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="edit_no_sertifikat_terakhir" id="edit_no_sertifikat_terakhir" class="form-control" placeholder="No. Sertifikat Terakhir">
                        </td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>
                            <textarea name="edit_keterangan" class="form-control" id="edit_keterangan" cols="30" rows="5" placeholder="Keterangan"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Update</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>