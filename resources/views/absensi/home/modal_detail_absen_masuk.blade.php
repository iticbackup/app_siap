<div class="modal fade modalDetailAbsenMasuk" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Edit Jam Masuk</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan-jam-masuk-detail_masuk" method="post">
                @csrf
                <input type="hidden" name="detail_masuk_pin" id="detail_masuk_pin">
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>NIK</td>
                                <td>:</td>
                                <td id="detail_masuk_nik"></td>
                            </tr>
                            <tr>
                                <td>Nama Karyawan</td>
                                <td>:</td>
                                <td id="detail_masuk_nama_karyawan"></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                {{-- <td id="detail_masuk_tanggal_masuk"></td>◘ --}}
                                <td><input type="text" name="detail_masuk_tanggal_masuk" class="form-control" readonly id="detail_masuk_tanggal_masuk"></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">Status</td>
                                <td style="vertical-align: middle">:</td>
                                <td style="vertical-align: middle">
                                    <select name="detail_masuk_jam_masuk_status" class="form-control" id="detail_masuk_jam_masuk_status">
                                        <option value="">-- Pilih Status --</option>
                                        @foreach ($status_absensis as $status_absensi)
                                            <option value="{{ $status_absensi->status_id }}">
                                                {{ $status_absensi->status_info }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">Penyesuaian Jam Masuk</td>
                                <td style="vertical-align: middle">:</td>
                                <td style="vertical-align: middle">
                                    <div class="input-group">
                                        <input type="text" name="detail_masuk_penyesuaian_masuk_jam_masuk_jam"
                                            class="form-control" placeholder="Jam" id="detail_masuk_penyesuaian_masuk_jam_masuk_jam" autocomplete="false">
                                        &nbsp; : &nbsp;
                                        <input type="text" name="detail_masuk_penyesuaian_masuk_jam_masuk_menit"
                                            class="form-control" placeholder="Menit" id="detail_masuk_penyesuaian_masuk_jam_masuk_menit"
                                            autocomplete="false">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">Penyesuaian Jam Istirahat</td>
                                <td style="vertical-align: middle">:</td>
                                <td style="vertical-align: middle">
                                    <div class="input-group">
                                        <input type="text" name="detail_masuk_penyesuaian_istirahat_jam_masuk_jam"
                                            class="form-control" placeholder="Jam" id="detail_masuk_penyesuaian_istirahat_jam_masuk_jam" autocomplete="false">
                                        &nbsp; : &nbsp;
                                        <input type="text" name="detail_masuk_penyesuaian_istirahat_jam_masuk_menit"
                                            class="form-control" placeholder="Menit" id="detail_masuk_penyesuaian_istirahat_jam_masuk_menit"
                                            autocomplete="false">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">Penyesuaian Jam Pulang</td>
                                <td style="vertical-align: middle">:</td>
                                <td style="vertical-align: middle">
                                    <div class="input-group">
                                        <input type="text" name="detail_masuk_penyesuaian_pulang_jam_masuk_jam"
                                            class="form-control" placeholder="Jam" id="detail_masuk_penyesuaian_pulang_jam_masuk_jam" autocomplete="false">
                                        &nbsp; : &nbsp;
                                        <input type="text" name="detail_masuk_penyesuaian_pulang_jam_masuk_menit"
                                            class="form-control" placeholder="Menit" id="detail_masuk_penyesuaian_pulang_jam_masuk_menit"
                                            autocomplete="false">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">Keterangan</td>
                                <td style="vertical-align: middle">:</td>
                                <td>
                                    <textarea name="detail_masuk_keterangan_jam_masuk" class="form-control" id="detail_masuk_keterangan_jam_masuk" cols="30"
                                        rows="5"></textarea>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
                    <button type="button" class="btn btn-soft-secondary btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
