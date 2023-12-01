<div class="modal fade modalBuatRiwayatKonseling" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Data Riwayat Konseling Karyawan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="riwayat_konseling_simpan" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="riwayat_konseling_id" id="riwayat_konseling_id">
            <div class="modal-body">
                <div class="mb-3">
                    <span style="font-size: 10pt;" class="card-title">Formulir Riwayat Konseling Karyawan</span>
                    <hr>
                    <table class="table">
                        <tr>
                            <th>NIK</th>
                            <th>: <input type="hidden" name="riwayat_konseling_nik" id="detail_nik_riwayat_konseling"></th>
                            <td id="detail_riwayat_konseling_nik"></td>
                        </tr>
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>:</th>
                            <td id="detail_riwayat_konseling_nama_karyawan"></td>
                        </tr>
                        <tr>
                            <th>Riwayat Konseling</th>
                            <th>:</th>
                            <td><input type="text" name="nama_riwayat_konseling" class="form-control" placeholder="Riwayat Konseling" id=""></td>
                        </tr>
                    </table>
                    <hr>
                    <table class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Riwayat Konseling</th>
                            </tr>
                        </thead>
                        <tbody id="detail_riwayat_konseling_datatables"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" id="button_riwayat_konseling">
            </div>
            </form>
        </div>
    </div>
</div>