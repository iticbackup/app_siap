<div class="modal fade modalEditDataKaryawan" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Edit Data Karyawan Non Aktif</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="edit_nik" id="edit_nik">
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td id="edit_nik_karyawan"></td>
                    </tr>
                    <tr>
                        <td>Nama Karyawan</td>
                        <td>:</td>
                        <td id="edit_nama_karyawan"></td>
                    </tr>
                    <tr>
                        <td>Tanggal Resign</td>
                        <td>:</td>
                        <td>
                            <input type="date" name="edit_tanggal_resign" class="form-control" id="">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-soft-secondary btn-md" data-bs-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>