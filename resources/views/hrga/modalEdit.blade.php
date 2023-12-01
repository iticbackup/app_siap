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
                                <div class="mb-2">
                                    <label for="">NIK Karyawan</label>
                                    <input type="text" name="edit_nik" class="form-control nik" readonly id="edit_nik_karyawan">
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-2">
                                    <label for="">Nama Karyawan</label>
                                    <input type="text" name="edit_nama_karyawan" class="form-control nama_karyawan" id="edit_nama_karyawan" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="">Tempat Lahir</label>
                                    <input type="text" name="edit_tempat_lahir" class="form-control" placeholder="Tempat Lahir" id="edit_mb_tempat_lahir">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="">Tanggal Lahir</label>
                                    <input type="date" name="edit_tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" id="edit_mb_tanggal_lahir">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-2">
                                    <label for="">Jenis Kelamin</label>
                                    <select name="edit_jenis_kelamin" class="form-control" id="edit_mb_jenis_kelamin">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki - Laki">Laki - Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="">Email</label>
                                    <input type="email" name="edit_email" class="form-control" placeholder="Email" id="edit_email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="">NPWP</label>
                                    <input type="text" name="edit_no_npwp" class="form-control mb_npwp" placeholder="NPWP" id="edit_mb_npwp">
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="">Alamat</label>
                            <textarea name="edit_alamat" class="form-control" id="edit_mb_alamat" cols="30" rows="5"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="">No. Urut Level</label>
                                    <input type="number" name="edit_no_urut_level" placeholder="No. Urut Lvl" class="form-control" id="edit_no_urut_level">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="">No. Urut Dept</label>
                                    <input type="number" name="edit_no_urut_departemen" placeholder="No. Urut Dept" class="form-control" id="edit_no_urut_departemen">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="">No. Telepon</label>
                                    <input type="text" name="edit_no_telepon" placeholder="No. Telepon" class="form-control" id="edit_no_telepon">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="">No. BPJS Ketenagakerjaan</label>
                                    <input type="text" name="edit_no_bpjs_ketenagakerjaan" class="form-control" placeholder="No. BPJS Ketenagakerjaan" id="edit_no_bpjs_ketenagakerjaan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="">No. BPJS Kesehatan</label>
                                    <input type="text" name="edit_no_bpjs_kesehatan" class="form-control" placeholder="No. BPJS Kesehatan" id="edit_no_bpjs_kesehatan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="">No. Rekening Mandiri</label>
                                    <input type="text" name="edit_no_rekening_mandiri" class="form-control" placeholder="No. Rekening Mandiri" id="edit_no_rekening_mandiri">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="">No. Rekening BWS</label>
                                    <input type="text" name="edit_no_rekening_bws" class="form-control" placeholder="No. Rekening BWS" id="edit_no_rekening_bws">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="">Departemen</label>
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
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="">Bagian</label>
                                            <input type="text" name="edit_departemen_bagian" class="form-control" placeholder="Bagian" id="edit_departemen_bagian">
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <div class="mb-2">
                                            <label for="">Jumlah</label>
                                            <input type="text" name="departemen_jml" class="form-control" placeholder="Jumlah" id="">
                                        </div>
                                    </div> --}}
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label for="">Level</label>
                                            <select name="edit_departemen_level" class="form-control" id="edit_departemen_level">
                                                <option value="">-- Pilih Level --</option>
                                                <option value="Direktur">Direktur</option>
                                                <option value="Staff">Staff</option>
                                                <option value="Harian">Harian</option>
                                                <option value="Mingguan">Mingguan</option>
                                                <option value="Bulanan">Bulanan</option>
                                                <option value="Borongan">Borongan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="">Status KLG</label>
                                    <input type="text" name="edit_status_keluarga" class="form-control" placeholder="Status KLG" id="edit_mb_status_klg">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="">Gol. Darah</label>
                                    <input type="text" name="edit_golongan_darah" class="form-control" placeholder="Gol. Darah" id="edit_golongan_darah">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="">Pendidikan</label>
                                    <input type="text" name="edit_pendidikan" class="form-control" placeholder="Pendidikan" id="edit_pendidikan">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="">Kunci Loker</label>
                                    <input type="text" name="edit_kunci_loker" class="form-control" placeholder="Kunci Loker" id="edit_kunci_loker">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="">Status Karyawan</label>
                                    <select name="edit_status_karyawan" class="form-control" id="edit_status_karyawan">
                                        <option value="">-- Pilih Status Karyawan --</option>
                                        <option value="Y">Aktif</option>
                                        <option value="T">Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Upload Foto</label>
                            <input type="file" name="edit_foto_karyawan" class="form-control" id="edit_filetag">
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