<div class="modal fade modalBuatKontrakKaryawan" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Data Kontrak Karyawan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="kontrak_kerja_simpan" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="kontrak_id" id="kontrak_id">
            <div class="modal-body">
                <div class="mb-3">
                    <table class="table">
                        <tr>
                            <th>NIK</th>
                            <th>: <input type="hidden" name="kontrak_nik" id="detail_nik_kontrak"></th>
                            <td id="detail_kontrak_nik"></td>
                        </tr>
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>:</th>
                            <td id="detail_kontrak_nama_karyawan"></td>
                        </tr>
                    </table>
                    <span style="font-size: 10pt;" class="card-title">Formulir Kontrak Karyawan</span>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="">PK</label>
                                <select name="kontrak_kerja_pk" class="form-control" id="">
                                    <option value="">-- Pilih PK --</option>
                                    <option value="Kontrak">Kontrak</option>
                                    <option value="Tetap">Tetap</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="">Ke</label>
                                <input type="text" name="kontrak_kerja_ke" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="">Tanggal Mulai</label>
                                <input type="date" name="kontrak_kerja_tanggal_mulai" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">PK</th>
                                <th class="text-center">Ke</th>
                                <th class="text-center">Tanggal Mulai</th>
                            </tr>
                        </thead>
                        <tbody id="detail_kontrak_datatables"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" id="button_kontrak_kerja">
            </div>
            </form>
        </div>
    </div>
</div>