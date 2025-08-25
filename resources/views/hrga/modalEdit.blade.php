<div class="modal fade modalEditDataKaryawan" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Edit Data Karyawan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <img src="" id="edit_preview_image" style="width: 350px; height: 450px; object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_nik" class="form-control nik" readonly id="edit_nik_karyawan">
                                    <label for="">NIK Karyawan</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_nama_karyawan" class="form-control nama_karyawan" id="edit_nama_karyawan" readonly>
                                    <label for="">Nama Karyawan</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_tempat_lahir" class="form-control" placeholder="Tempat Lahir" id="edit_mb_tempat_lahir">
                                    <label for="">Tempat Lahir</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-2">
                                    <input type="date" name="edit_tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" id="edit_mb_tanggal_lahir">
                                    <label for="">Tanggal Lahir</label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-floating mb-2">
                                    <select name="edit_jenis_kelamin" class="form-control" id="edit_mb_jenis_kelamin">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki - Laki">Laki - Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <label for="">Jenis Kelamin</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-2">
                                    <input type="email" name="edit_email" class="form-control" placeholder="Email" id="edit_email">
                                    <label for="">Email</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_no_npwp" class="form-control mb_npwp" placeholder="NPWP" id="edit_mb_npwp">
                                    <label for="">NPWP</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_no_telepon" placeholder="No. Telepon" class="form-control" id="edit_no_telepon">
                                    <label for="">No. Telepon</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-2">
                            <textarea name="edit_alamat" class="form-control" id="edit_mb_alamat" cols="30" rows="5"></textarea>
                            <label for="">Alamat</label>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="text" name="edit_kelurahan" class="form-control" placeholder="Kelurahan"
                                    id="edit_kelurahan">
                                    <label for="kelurahan">Kelurahan</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="text" name="edit_kecamatan" class="form-control" placeholder="Kecamatan"
                                    id="edit_kecamatan">
                                    <label for="kecamatan">Kecamatan</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="text" name="edit_kab_kota" class="form-control" placeholder="Kab/Kota"
                                    id="edit_kab_kota">
                                    <label for="kab_kota">Kab/Kota</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    {{-- <input type="text" name="provinsi" class="form-control" placeholder="Provinsi"
                                    id="provinsi"> --}}
                                    <select name="edit_provinsi" class="form-control provinsi edit_provinsi">
                                    </select>
                                    <label for="provinsi">Provinsi</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_no_bpjs_ketenagakerjaan" class="form-control" placeholder="No. BPJS Ketenagakerjaan" id="edit_no_bpjs_ketenagakerjaan">
                                    <label for="">No. BPJS Ketenagakerjaan</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_no_bpjs_kesehatan" class="form-control" placeholder="No. BPJS Kesehatan" id="edit_no_bpjs_kesehatan">
                                    <label for="">No. BPJS Kesehatan</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_no_rekening_mandiri" class="form-control" placeholder="No. Rekening Mandiri" id="edit_no_rekening_mandiri">
                                    <label for="">No. Rekening Mandiri</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_no_rekening_bws" class="form-control" placeholder="No. Rekening BWS" id="edit_no_rekening_bws">
                                    <label for="">No. Rekening BWS</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_no_rekening_bca" class="form-control" placeholder="No. Rekening BCA" id="edit_no_rekening_bca">
                                    <label for="">No. Rekening BCA</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="edit_sim_kendaraan" class="form-control" id="edit_sim_kendaraan">
                                            <label for="">SIM Kendaraan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-2">
                                            <select name="edit_departemen_dept" class="form-control" id="edit_departemen_dept">
                                                <option value="">-- Pilih Departemen --</option>
                                                <option value="Direktur">Direktur</option>
                                                <option value="Internal Audit">Internal Audit</option>
                                                <option value="FIN & ACC">Finance & Accounting</option>
                                                <option value="QC">QC</option>
                                                <option value="HRGA">HRGA</option>
                                                <option value="IT">IT</option>
                                                <option value="CorSec">Corsec</option>
                                                <option value="MARKETING">Marketing</option>
                                                <option value="PURCHASING">Purchasing</option>
                                                <option value="PPIC TEMBAKAU">PPIC Tembakau</option>
                                                <option value="PPIC PENUNJANG">PPIC Penunjang</option>
                                                <option value="PRODUKSI PRIMARY">Produksi Primary</option>
                                                <option value="PRODUKSI AMBRI">Produksi Ambri</option>
                                                <option value="PRODUKSI PACKING">Produksi Packing</option>
                                                <option value="GD. KLATEN">GD. Klaten</option>
                                            </select>
                                            <label for="">Departemen</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-2">
                                            <input type="text" name="edit_departemen_bagian" class="form-control" placeholder="Bagian" id="edit_departemen_bagian">
                                            <label for="">Bagian</label>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <div class="mb-2">
                                            <label for="">Jumlah</label>
                                            <input type="text" name="departemen_jml" class="form-control" placeholder="Jumlah" id="">
                                        </div>
                                    </div> --}}
                                    <div class="col-md-2">
                                        <div class="form-floating mb-2">
                                            <select name="edit_departemen_level" class="form-control" id="edit_departemen_level">
                                                <option value="">-- Pilih Level --</option>
                                                <option value="Direktur">Direktur</option>
                                                <option value="Staff">Staff</option>
                                                <option value="Harian">Harian</option>
                                                <option value="Mingguan">Mingguan</option>
                                                <option value="Bulanan">Bulanan</option>
                                                <option value="Borongan">Borongan</option>
                                            </select>
                                            <label for="">Level</label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_status_keluarga" class="form-control" placeholder="Status KLG" id="edit_mb_status_klg">
                                    <label for="">Status KLG</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_golongan_darah" class="form-control" placeholder="Gol. Darah" id="edit_golongan_darah">
                                    <label for="">Gol. Darah</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-2">
                                    {{-- <input type="text" name="edit_pendidikan" class="form-control" placeholder="Pendidikan" id="edit_pendidikan"> --}}
                                    <select name="edit_pendidikan" class="form-control" id="edit_pendidikan">
                                        <option value="">-- Pilih Pendidikan --</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SLTP">SLTP</option>
                                        <option value="MTS">MTS</option>
                                        <option value="SMA">SMA</option>
                                        <option value="SLTA">SLTA</option>
                                        <option value="SMK">SMK</option>
                                        <option value="MA">MA</option>
                                        <option value="D1">D1</option>
                                        <option value="D2">D2</option>
                                        <option value="D3">D3</option>
                                        <option value="D4">D4</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                    <label for="">Pendidikan</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-2">
                                    <input type="text" name="edit_kunci_loker" class="form-control" placeholder="Kunci Loker" id="edit_kunci_loker">
                                    <label for="">Kunci Loker</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-2">
                                    <select name="edit_status_karyawan" class="form-control" id="edit_status_karyawan">
                                        <option value="">-- Pilih Status Karyawan --</option>
                                        <option value="Y">Aktif</option>
                                        <option value="T">Non Aktif</option>
                                    </select>
                                    <label for="">Status Karyawan</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="file" name="edit_foto_karyawan" class="form-control" id="edit_filetag">
                            <label for="">Upload Foto</label>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="mb-2">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Update</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>