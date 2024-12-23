<div class="modal fade modalDetailDataKaryawan" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" id="title_button_action">
                {{-- <h6 class="modal-title m-0" id="title_button_action">Data Karyawan</h6> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4" id="detail_foto_karyawan">

                    </div>
                    <div class="col-md-8">
                        <span style="font-size: 12pt" class="card-title">Data Pribadi</span>
                        <hr>
                        <table class="table">
                            <tr>
                                <th style="width: 25%">NIK</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_nik"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Nama Karyawan</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_nama_karyawan"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Tempat, Tanggal Lahir</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_tempat_tanggal_lahir"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Jenis Kelamin</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_jenis_kelamin"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Alamat</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_alamat"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Email</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_email"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">No. Telepon</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_no_telepon"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Status Keluarga</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_status_keluarga"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Golongan Darah</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_golongan_darah"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Pendidikan</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_pendidikan"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">NPWP</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_no_npwp"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">PIN</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_pin"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">SIM Kendaraan</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_sim_kendaraan"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">BPJS Ketenagakerjaan</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_no_bpjs_ketenagakerjaan"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">BPJS Kesehatan</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_no_bpjs_kesehatan"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Rekening Mandiri</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_no_rekening_mandiri"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Rekening BWS</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_no_rekening_bws"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Rekening BCA</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_no_rekening_bca"></td>
                            </tr>
                        </table>
                        <span style="font-size: 12pt" class="card-title">Departemen</span>
                        <hr>
                        <table class="table">
                            <tr>
                                <th style="width: 25%">Departemen</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_departemen_dept"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Bagian</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_departemen_bagian"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Level</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_departemen_level"></td>
                            </tr>
                        </table>
                        <span style="font-size: 12pt" class="card-title">Masuk Kerja</span>
                        <hr>
                        <table class="table">
                            <tr>
                                <th style="width: 25%">Tanggal Masuk</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_masuk_kerja_tgl_masuk"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%">Masa Kerja</th>
                                <th style="width: 5%" class="text-center">:</th>
                                <td id="detail_masuk_kerja_masa_kerja"></td>
                            </tr>
                        </table>
                        <span style="font-size: 12pt" class="card-title">Status Kerja</span>
                        <hr>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 33.3%">PK</th>
                                    <th class="text-center" style="width: 33.3%">Ke</th>
                                    <th class="text-center" style="width: 33.3%">Tanggal Mulai</th>
                                </tr>
                            </thead>
                            <tbody id="detail_status_kerja"></tbody>
                        </table>
                        <span style="font-size: 12pt" class="card-title">Riwayat Konseling</span>
                        <hr>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 33.3%">No</th>
                                    <th class="text-center" style="width: 33.3%">Data Riwayat</th>
                                </tr>
                            </thead>
                            <tbody id="detail_riwayat_konseling"></tbody>
                        </table>
                        <span style="font-size: 12pt" class="card-title">Riwayat Training</span>
                        <hr>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th class="text-center" style="width: 33.3%">Data Riwayat</th>
                                </tr>
                            </thead>
                            <tbody id="detail_riwayat_training"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="button_action">
                {{-- <button type="button" class="btn btn-md" style="background-color: #005B41; color: white" onclick="buat_kontrak(this.value)"><i class="mdi mdi-plus"></i> Buat Kontrak</button>
                <button type="button" class="btn btn-md" style="background-color: #508D69; color: white"><i class="mdi mdi-plus"></i> Buat Riwayat Konseling</button>
                <button type="button" class="btn btn-md" style="background-color: #363062; color: white"><i class="mdi mdi-plus"></i> Buat Riwayat Training</button> --}}
                {{-- <button type="button" class="btn btn-soft-secondary btn-md" data-bs-dismiss="modal">Close</button> --}}
            </div>
        </div>
    </div>
</div>