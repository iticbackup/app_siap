<div class="modal fade modalDetail" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Detail Sertifikasi Mesin Produksi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>Jenis Mesin</td>
                        <td>:</td>
                        <td id="detail_jenis_mesin"></td>
                    </tr>
                    <tr>
                        <td>No. Sertifikat</td>
                        <td>:</td>
                        <td id="detail_no_sertifikat"></td>
                    </tr>
                    <tr>
                        <td>Tgl Sertifikat Pertama</td>
                        <td>:</td>
                        <td id="detail_tgl_sertifikat_pertama"></td>
                    </tr>
                    <tr>
                        <td>Periode Resertifikasi</td>
                        <td>:</td>
                        <td id="detail_periode_resertifikasi"></td>
                    </tr>
                </table>
                <hr>
                <div class="mb-3">
                    <div class="text-center">Keterangan Resertifikasi</div>
                </div>
                <div class="mb-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Tgl Perikasi Uji</th>
                                <th class="text-center">Tgl Terbit Sertifikat</th>
                                <th class="text-center">No. SuKet Terakhir</th>
                                <th class="text-center">Tgl Resertifikasi Selanjutnya</th>
                            </tr>
                        </thead>
                        <tbody id="detail_mesin_list"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>