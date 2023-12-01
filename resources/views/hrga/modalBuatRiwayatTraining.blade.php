<div class="modal fade modalBuatRiwayatTraining" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Data Riwayat Training Karyawan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="riwayat_training_simpan" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="riwayat_training_id" id="riwayat_training_id">
            <div class="modal-body">
                <div class="mb-3">
                    <span style="font-size: 10pt;" class="card-title">Formulir Riwayat Training Karyawan</span>
                    <hr>
                    <table class="table">
                        <tr>
                            <th>NIK</th>
                            <th>: <input type="hidden" name="riwayat_training_nik" id="detail_nik_riwayat_training"></th>
                            <td id="detail_riwayat_training_nik"></td>
                        </tr>
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>:</th>
                            <td id="detail_riwayat_training_nama_karyawan"></td>
                        </tr>
                        <tr>
                            <th>Riwayat Training</th>
                            <th>:</th>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="nama_riwayat_training" class="form-control" placeholder="Riwayat Training" id="">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <table class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Riwayat Rekap Pelatihan / Seminar</th>
                                {{-- <th class="text-center">Riwayat Training</th> --}}
                            </tr>
                        </thead>
                        <tbody id="detail_riwayat_training_datatables"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" id="button_riwayat_training">
            </div>
            </form>
        </div>
    </div>
</div>