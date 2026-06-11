<div class="modal fade modalBuatTransferKaryawanJeda" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #5015f3; color: white">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Buat Data Karyawan Jeda</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-transfer-karyawan-jeda-simpan" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                @php
                    $sim_kendaraans = [
                        '-','A','B1','B2','C'
                    ];

                    $status_keluargas = [
                        'TK',
                        'K00',
                        'K01',
                        'K02',
                        'K03',
                        'K04',
                        'K05',
                    ];

                    $pendidikans = [
                        'TK',
                        'SD',
                        'SMP',
                        'MA',
                        'SMA',
                        'SMK',
                        'SLTA',
                        'D1',
                        'D2',
                        'D3',
                        'D4',
                        'S1',
                        'S2',
                        'S3',
                    ];
                @endphp
                {{-- <div class="mb-2">
                    <label for="">Cari Nama Karyawan</label>
                    <div class="input-group">
                        <input type="search" name="resign_nama_karyawan" class="form-control resign_nama_karyawan" id="">
                        <button type="button" class="btn btn-primary" id="resign-btn-search"><i class="fas fa-search"></i> Search</button>
                    </div>
                    <ul class="list-group" id="resign_result"></ul>
                </div>
                <hr>
                <div class="mb-2" id="resign-table"></div> --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 fw-bold fs-4">Data Karyawan Lama</div>
                        <hr>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">NIK Karyawan</label>
                            <div class="col-sm-8">
                                <input type="text" name="nik_lama" class="form-control jeda_nik_karyawan_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Nama Karyawan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_nama_karyawan_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Tempat Lahir</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_tempat_lahir_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Tanggal Lahir</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control jeda_tanggal_lahir_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Jenis Kelamin</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_jenis_kelamin_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Alamat</label>
                            <div class="col-sm-8">
                                <textarea name="" class="form-control jeda_alamat_lama" id="" cols="30" rows="5" readonly></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Kecamatan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_kecamatan_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Kelurahan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_kelurahan_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Kab/Kota</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_kab_kota_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Provinsi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_provinsi_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Email</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_email_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">No. Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_no_telepon_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Status Keluarga</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_status_keluarga_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Golongan Darah</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_golongan_darah_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Pendidikan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_pendidikan_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">NPWP</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_no_npwp_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">PIN</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_pin_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">SIM Kendaraan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_sim_kendaraan_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">BPJS Ketenagakerjaan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_no_bpjs_ketenagakerjaan_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">BPJS Kesehatan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_no_bpjs_kesehatan_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Rekening Mandiri</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_no_rekening_mandiri_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Rekening BWS</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_no_rekening_bws_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Rekening BCA</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control jeda_no_rekening_bca_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Tanggal Masuk</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control jeda_tanggal_masuk_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Tanggal Resign</label>
                            <div class="col-sm-8">
                                <input type="date" name="tanggal_resign_lama" class="form-control jeda_tanggal_resign_lama">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 fw-bold fs-4">Data Karyawan Baru</div>
                        <hr>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">NIK Baru</label>
                            <div class="col-sm-8">
                                <input type="text" name="nik_baru" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Nama Karyawan</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_karyawan_baru" class="form-control jeda_nama_karyawan_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Tempat Lahir</label>
                            <div class="col-sm-8">
                                <input type="text" name="tempat_lahir_baru" class="form-control jeda_tempat_lahir_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Tanggal Lahir</label>
                            <div class="col-sm-8">
                                <input type="date" name="tanggal_lahir_baru" class="form-control jeda_tanggal_lahir_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Jenis Kelamin</label>
                            <div class="col-sm-8">
                                <select name="jenis_kelamin_baru" class="form-control jeda_jenis_kelamin_baru" id="">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L">Laki - Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Alamat</label>
                            <div class="col-sm-8">
                                <textarea name="alamat_baru" class="form-control jeda_alamat_lama" id="" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Kecamatan</label>
                            <div class="col-sm-8">
                                <input type="text" name="kecamatan_baru" class="form-control jeda_kecamatan_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Kelurahan</label>
                            <div class="col-sm-8">
                                <input type="text" name="kelurahan_baru" class="form-control jeda_kelurahan_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Kab/Kota</label>
                            <div class="col-sm-8">
                                <input type="text" name="kab_kota_baru" class="form-control jeda_kab_kota_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Provinsi</label>
                            <div class="col-sm-8">
                                <input type="text" name="provinsi_baru" class="form-control jeda_provinsi_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Email</label>
                            <div class="col-sm-8">
                                <input type="email" name="email_baru" class="form-control jeda_email_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">No. Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_telepon_baru" class="form-control jeda_no_telepon_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Status Keluarga</label>
                            <div class="col-sm-8">
                                <select name="status_keluarga_baru" class="form-control jeda_status_keluarga_lama" id="">
                                    <option value="">-- Pilih Status Keluarga --</option>
                                    @foreach ($status_keluargas as $status_keluarga)
                                        <option value="{{ $status_keluarga }}">{{ $status_keluarga }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Golongan Darah</label>
                            <div class="col-sm-8">
                                <input type="text" name="golongan_darah_baru" class="form-control jeda_golongan_darah_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Pendidikan</label>
                            <div class="col-sm-8">
                                <select name="pendidikan_baru" class="form-control jeda_pendidikan_lama" id="">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    @foreach ($pendidikans as $pendidikan)
                                        <option value="{{ $pendidikan }}">{{ $pendidikan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">NPWP</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_npwp_baru" class="form-control jeda_no_npwp_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">PIN</label>
                            <div class="col-sm-8">
                                <input type="text" name="pin_baru" class="form-control jeda_pin_lama" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">SIM Kendaraan</label>
                            <div class="col-sm-8">
                                <select name="sim_kendaraan_baru" class="form-control jeda_sim_kendaraan_lama" id="">
                                    <option value="">-- Pilih SIM Kendaraan --</option>
                                    @foreach ($sim_kendaraans as $sim_kendaraan)
                                        <option value="{{ $sim_kendaraan }}">{{ $sim_kendaraan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">BPJS Ketenagakerjaan</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_bpjs_ketenagakerjaan_baru" class="form-control jeda_no_bpjs_ketenagakerjaan_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">BPJS Kesehatan</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_bpjs_kesehatan_baru" class="form-control jeda_no_bpjs_kesehatan_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Rekening Mandiri</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_rekening_mandiri_baru" class="form-control jeda_no_rekening_mandiri_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center jeda_no_rekening_bws_lama">Rekening BWS</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_rekening_bws_baru" class="form-control jeda_no_rekening_bws_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Rekening BCA</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_rekening_bca_baru" class="form-control jeda_no_rekening_bca_lama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-4 align-self-center">Tanggal Masuk</label>
                            <div class="col-sm-8">
                                <input type="date" name="tanggal_masuk_baru" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Submit</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>