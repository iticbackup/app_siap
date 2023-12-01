<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title m-0" id="offcanvasRightLabel"></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <form id="canvas_right_update" method="post">
            @csrf
            <input type="hidden" name="update_id" id="update_id">
            <table class="table mb-0 table-centered">
                <tbody>
                    <tr>
                        <td>
                            <p><b>Tanggal Pelaksanaan</b></p>
                            <p id="update_tanggal"></p>
                            <p id="update_time"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>Penyelenggara</b></p>
                            <p id="update_penyelenggara"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>Kategori Pelatihan / Seminar</b></p>
                            <p id="update_kategori_pelatihan"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>Jumlah Hari Pelatihan</b></p>
                            <p id="update_jml_hari"></p>
                            <input type="hidden" id="text_update_jml_hari">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>Jumlah Jam Pelatihan Dalam 1 Hari</b></p>
                            <div class="input-group mb-3">
                                <input type="text" name="update_jml_jam_dlm_hari" class="form-control" placeholder="" id="update_jml_jam_hari">
                                <button type="button" class="btn btn-primary" onclick="hitung()"><i class="mdi mdi-calculator-variant"></i> Hitung</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>Jumlah Hari Pelatihan * Jam</b></p>
                            <p id="update_total_jml_hari_jam"></p>
                            <input type="hidden" id="text_update_total_jml_hari_jam">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>Total Peserta</b></p>
                            <p id="update_total_peserta"></p>
                            <input type="hidden" id="text_update_total_peserta">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>Total Peserta * Jam</b></p>
                            <p id="update_total_peserta_jam"></p>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <button type="submit" class="btn btn-primary"><i class="mdi mdi-progress-upload"></i> Submit</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>