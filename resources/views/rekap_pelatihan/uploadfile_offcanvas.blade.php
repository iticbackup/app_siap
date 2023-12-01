<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasUpload" aria-labelledby="offcanvasstartLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title m-0" id="offcanvasuploadLabel"></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <form id="upload_files" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="upload_id" id="upload_id">
        <table class="table mb-0 table-centered">
            <tbody>
                <tr>
                    <td><p><b>Tanggal Pelaksanaan</b></p></td>
                    <td>:</td>
                    <td>
                        <p id="upload_tanggal" style="margin-bottom: -2.5%"></p>
                        <p id="upload_time"></p>
                    </td>
                </tr>
                <tr>
                    <td><p><b>Penyelenggara</b></p></td>
                    <td>:</td>
                    <td><p id="upload_penyelenggara"></p></td>
                </tr>
                <tr>
                    <td><p><b>Kategori Pelatihan / Seminar</b></p></td>
                    <td>:</td>
                    <td><p id="upload_kategori_pelatihan"></p></td>
                </tr>
                <tr>
                    <td><p><b>Jumlah Hari Pelatihan</b></p></td>
                    <td>:</td>
                    <td><p id="upload_jml_hari"></p></td>
                </tr>
                <tr>
                    <td><p><b>Jumlah Jam Pelatihan Dalam 1 Hari</b></p></td>
                    <td>:</td>
                    <td><p id="upload_jml_jam_hari"></p></td>
                </tr>
                <tr>
                    <td><p><b>Jumlah Hari Pelatihan * Jam</b></p></td>
                    <td>:</td>
                    <td><p id="upload_total_jml_hari_jam"></p></td>
                </tr>
                <tr>
                    <td><p><b>Total Peserta</b></p></td>
                    <td>:</td>
                    <td><p id="upload_total_peserta"></p></td>
                </tr>
                <tr>
                    <td><p><b>Total Peserta * Jam</b></p></td>
                    <td>:</td>
                    <td><p id="upload_total_peserta_jam"></p></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p style="margin-bottom: 0%"><b>File Sertifikat</b></p>
                        <div id="upload_file_sertifikat"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p style="margin-bottom: 0%"><b>File Absensi</b></p>
                        <div id="upload_file_absensi"></div>
                    </td>
                </tr>
                <tr>
                    <td><p><b>Peserta</b></p></td>
                    <td>:</td>
                    <td><p id="upload_peserta"></p></td>
                </tr>
            </tbody>
        </table>
        </form>
        {{-- <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for=""><b>Tanggal Pelaksanaan</b></label>
                            <p id="detail_tanggal"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for=""><b>Penyelenggara</b></label>
                            <p id="detail_penyelenggara"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for=""><b>Kategori Pelatihan / Seminar</b></label>
                            <p id="detail_kategori_pelatihan"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label for=""><b>Jumlah Hari Pelatihan</b></label>
                    <p id="detail_jml_hari"></p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label for=""><b>Jumlah Jam Pelatihan Dalam 1 Hari</b></label>
                    <p id="detail_jml_jam_hari"></p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label for=""><b>Jumlah Hari Pelatihan * Jam</b></label>
                    <p id="detail_total_jml_hari_jam"></p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label for=""><b>Total Peserta</b></label>
                    <p id="detail_total_peserta"></p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label for=""><b>Total Peserta * Jam</b></label>
                    <p id="detail_total_peserta_jam"></p>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-md-7">
            <div class="mb-3">
                <label for=""><b>Peserta</b></label>
                <p id="detail_peserta"></p>
            </div>
        </div> --}}
    </div>
</div>