<div class="modal fade modalBuatTransferPin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" id="title_button_action">
                <h6 class="modal-title m-0" id="title_button_action">Buat Transfer PIN Karyawan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="transferpin_simpan" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="fw-bold mb-2">PIN Karyawan Lama</div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>NIK Karyawan</th>
                                        <th>Nama Karyawan</th>
                                        <th>PIN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="transferPinLama_nik"></td>
                                        <td id="transferPinLama_nama"></td>
                                        <td id="transferPinLama_pin"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="fw-bold mb-2">PIN Karyawan Baru</div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>NIK Karyawan</th>
                                        <th>Nama Karyawan</th>
                                        <th>PIN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="transferPinBaru_nik"></td>
                                        <td id="transferPinBaru_nama"></td>
                                        <td>
                                            <input type="number" name="pin" class="form-control" placeholder="PIN Karyawan" id="transferPinBaru_pin">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="nik" id="transferPinBaru_nikKaryawan">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>