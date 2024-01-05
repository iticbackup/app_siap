<div class="modal fade modalJamPulangNonAbsen" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Buat Jam Masuk</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan-jam-keluar-non-absen" method="post">
                @csrf
                <input type="hidden" name="inoutmode_non_absen_keluar" id="inoutmode_non_absen_keluar">
                <input type="hidden" name="pin_non_absen_keluar" id="pin_non_absen_keluar">
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <td>NIK</td>
                            <td>:</td>
                            <td id="jam_keluar_nik"></td>
                        </tr>
                        <tr>
                            <td>Nama Karyawan</td>
                            <td>:</td>
                            <td id="jam_keluar_nama_karyawan"></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="tanggal_non_absen_keluar" readonly class="form-control" id="non_absen_keluar_jam_keluar_tanggal">
                            </td>
                        </tr>
                        <tr>
                            <td>Waktu</td>
                            <td>:</td>
                            <td style="vertical-align: middle">
                                <div class="input-group">
                                    <select name="jam_non_absen_keluar" class="form-control" id="jam_non_keluar">
                                        @for ($i = 0; $i <= 23; $i++)
                                        <?php 
                                        if ($i<10) {
                                            $value = "0$i";
                                        }elseif($i>=24){
                                            $value = "0".($i-24);
                                        }else{
                                            $value = $i;
                                        }
                                        ?>
                                        <option value="{{ $value }}">{{ $value }}</option>
                                        @endfor
                                    </select>
                                    <div style="margin-left: 2.5%; margin-right: 2.5%">:</div>
                                    <select name="menit_non_absen_keluar" class="form-control" id="menit_non_keluar">
                                        @for ($i = 0; $i <= 59; $i++)
                                        <?php 
                                        if ($i<10) {
                                            $value = "0$i";
                                        }else{
                                            $value = $i;
                                        }
                                        ?>
                                        <option value="{{ $value }}">{{ $value }}</option>
                                        @endfor
                                    </select>
                                    <div style="margin-left: 2.5%; margin-right: 2.5%">:</div>
                                    <select name="detik_non_absen_keluar" class="form-control" id="detik_non_keluar">
                                        @for ($i = 0; $i <= 59; $i++)
                                        <?php 
                                        if ($i<10) {
                                            $value = "0$i";
                                        }else{
                                            $value = $i;
                                        }
                                        ?>
                                        <option value="{{ $value }}">{{ $value }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">Status</td>
                            <td style="vertical-align: middle">:</td>
                            <td style="vertical-align: middle">
                                <select name="status_non_absen_keluar" class="form-control" id="status_non_absen_keluar">
                                    <option value="">-- Pilih Status --</option>
                                    @foreach ($status_absensis as $status_absensi)
                                    <option value="{{ $status_absensi->status_id }}">{{ $status_absensi->status_info }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">Penyesuaian Jam Masuk</td>
                            <td style="vertical-align: middle">:</td>
                            <td style="vertical-align: middle">
                                <div class="input-group">
                                    <input type="text" name="penyesuaian_masuk_jam_keluar_jam_non_absen" class="form-control" placeholder="Jam" id="penyesuaian_masuk_jam_keluar_jam_non_absen" autocomplete="false">
                                    &nbsp; : &nbsp;
                                    <input type="text" name="penyesuaian_masuk_jam_keluar_menit_non_absen" class="form-control" placeholder="Menit" id="penyesuaian_masuk_jam_keluar_menit_non_absen" autocomplete="false">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">Penyesuaian Jam Istirahat</td>
                            <td style="vertical-align: middle">:</td>
                            <td style="vertical-align: middle">
                                <div class="input-group">
                                    <input type="text" name="penyesuaian_istirahat_jam_keluar_jam_non_absen" class="form-control" placeholder="Jam" id="penyesuaian_istirahat_jam_keluar_jam_non_absen" autocomplete="false">
                                    &nbsp; : &nbsp;
                                    <input type="text" name="penyesuaian_istirahat_jam_keluar_menit_non_absen" class="form-control" placeholder="Menit" id="penyesuaian_istirahat_jam_keluar_menit_non_absen" autocomplete="false">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">Penyesuaian Jam Pulang</td>
                            <td style="vertical-align: middle">:</td>
                            <td style="vertical-align: middle">
                                <div class="input-group">
                                    <input type="text" name="penyesuaian_pulang_jam_keluar_jam_non_absen" class="form-control" placeholder="Jam" id="penyesuaian_pulang_jam_keluar_jam_non_absen" autocomplete="false">
                                    &nbsp; : &nbsp;
                                    <input type="text" name="penyesuaian_pulang_jam_keluar_menit_non_absen" class="form-control" placeholder="Menit" id="penyesuaian_pulang_jam_keluar_menit_non_absen" autocomplete="false">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">Keterangan</td>
                            <td style="vertical-align: middle">:</td>
                            <td>
                                <textarea name="keterangan_jam_keluar_non_absen" class="form-control" id="jam_keluar_keterangan_non_absen" cols="30" rows="5"></textarea>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>