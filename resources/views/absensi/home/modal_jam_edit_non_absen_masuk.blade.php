<div class="modal fade modalEditJamMasukNonAbsen" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Edit Jam Masuk</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-edit-jam-masuk-non-absen" method="post">
                @csrf
                <input type="hidden" name="edit_att_rec_non_absen" id="edit_att_rec_non_absen">
                {{-- <input type="hidden" name="edit_pin_non_absen_masuk" id="edit_pin_non_absen_masuk"> --}}
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <td>NIK</td>
                            <td>:</td>
                            <td id="edit_jam_masuk_nik"></td>
                        </tr>
                        <tr>
                            <td>Nama Karyawan</td>
                            <td>:</td>
                            <td id="edit_jam_masuk_nama_karyawan"></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="edit_tanggal_non_absen_masuk" readonly class="form-control" id="edit_non_absen_masuk_jam_masuk_tanggal">
                            </td>
                        </tr>
                        <tr>
                            <td>Waktu</td>
                            <td>:</td>
                            <td><input type="text" name="edit_waktu_non_absen_masuk" class="form-control" readonly id="edit_non_absen_masuk_jam_masuk_waktu"></td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">Status</td>
                            <td style="vertical-align: middle">:</td>
                            <td style="vertical-align: middle">
                                <select name="edit_jam_masuk_status_non_absen_masuk" class="form-control" id="edit_non_absen_masuk_jam_masuk_status">
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
                                    <input type="text" name="edit_penyesuaian_masuk_jam_masuk_jam_non_absen" class="form-control" placeholder="Jam" id="edit_penyesuaian_masuk_jam_masuk_jam_non_absen" autocomplete="false">
                                    &nbsp; : &nbsp;
                                    <input type="text" name="edit_penyesuaian_masuk_jam_masuk_menit_non_absen" class="form-control" placeholder="Menit" id="edit_penyesuaian_masuk_jam_masuk_menit_non_absen" autocomplete="false">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">Penyesuaian Jam Istirahat</td>
                            <td style="vertical-align: middle">:</td>
                            <td style="vertical-align: middle">
                                <div class="input-group">
                                    <input type="text" name="edit_penyesuaian_istirahat_jam_masuk_jam_non_absen" class="form-control" placeholder="Jam" id="edit_penyesuaian_istirahat_jam_masuk_jam_non_absen" autocomplete="false">
                                    &nbsp; : &nbsp;
                                    <input type="text" name="edit_penyesuaian_istirahat_jam_masuk_menit_non_absen" class="form-control" placeholder="Menit" id="edit_penyesuaian_istirahat_jam_masuk_menit_non_absen" autocomplete="false">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">Penyesuaian Jam Pulang</td>
                            <td style="vertical-align: middle">:</td>
                            <td style="vertical-align: middle">
                                <div class="input-group">
                                    <input type="text" name="edit_penyesuaian_pulang_jam_masuk_jam_non_absen" class="form-control" placeholder="Jam" id="edit_penyesuaian_pulang_jam_masuk_jam_non_absen" autocomplete="false">
                                    &nbsp; : &nbsp;
                                    <input type="text" name="edit_penyesuaian_pulang_jam_masuk_menit_non_absen" class="form-control" placeholder="Menit" id="edit_penyesuaian_pulang_jam_masuk_menit_non_absen" autocomplete="false">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">Keterangan</td>
                            <td style="vertical-align: middle">:</td>
                            <td>
                                <textarea name="edit_keterangan_jam_masuk_non_absen" class="form-control" id="edit_jam_masuk_keterangan_non_absen" cols="30" rows="5"></textarea>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>