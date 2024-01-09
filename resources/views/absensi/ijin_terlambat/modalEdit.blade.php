<div class="modal fade modalEditIjinTerlambat" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="exampleModalCenterTitle">Edit Formulir Ijin / Terlambat (Pribadi)</h6>
                <button type="button" class="btn-close" style="background-color: white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">NIK Karyawan</label>
                        <input type="text" name="edit_nik" placeholder="NIK Karyawan" readonly class="form-control nik" id="edit_nik">
                        <input type="hidden" name="edit_att_rec" readonly class="form-control" id="edit_att_rec">
                    </div>
                    <div class="mb-3">
                        <label for="">Nama Karyawan</label>
                        <input type="text" name="edit_nama_karyawan" class="form-control" id="edit_nama_karyawan" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="">Tanggal</label>
                        <input type="date" name="edit_tanggal" class="form-control" id="edit_tanggal">
                    </div>
                    <div class="mb-3">
                        <label for="">Waktu</label>
                        <div class="input-group">
                            <select name="edit_waktu_datang_jam" class="form-control" id="edit_waktu_datang_jam">
                                <option value="">-- Jam --</option>
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
                            <select name="edit_waktu_datang_menit" class="form-control" id="edit_waktu_datang_menit">
                                <option value="">-- Menit --</option>
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
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="">Status</label>
                        <select name="edit_status" class="form-control" id="edit_status">
                            <option value="">-- Pilih Status --</option>
                            @foreach ($status_absensis as $status_absensi)
                                <option value="{{ $status_absensi->status_id }}">
                                    {{ $status_absensi->status_info }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Penyesuaian Jam Masuk</label>
                        <div class="input-group">
                            <select name="edit_jam_masuk_jam" class="form-control" id="edit_jam_masuk_jam">
                                <option value="">-- Jam --</option>
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
                            <select name="edit_jam_masuk_menit" class="form-control" id="edit_jam_masuk_menit">
                                <option value="">-- Menit --</option>
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
                    </div>
                    <div class="mb-3">
                        <label for="">Jam Datang</label>
                        <div class="input-group">
                            <select name="edit_jam_istirahat_jam" class="form-control" id="edit_jam_istirahat_jam">
                                <option value="">-- Jam --</option>
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
                            <select name="edit_jam_istirahat_menit" class="form-control" id="edit_jam_istirahat_menit">
                                <option value="">-- Menit --</option>
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
                    </div>
                    <div class="mb-3">
                        <label for="">Jam Istirahat</label>
                        <div class="input-group">
                            <select name="edit_jam_pulang_jam" class="form-control" id="edit_jam_pulang_jam">
                                <option value="">-- Jam --</option>
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
                            <select name="edit_jam_pulang_menit" class="form-control" id="edit_jam_pulang_menit">
                                <option value="">-- Menit --</option>
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
                    </div>
                    <div class="mb-3">
                        <label for="">Keterangan</label>
                        <textarea name="edit_keterangan" class="form-control" id="edit_keterangan" cols="30" rows="5"></textarea>
                    </div>
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
