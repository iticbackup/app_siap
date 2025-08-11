<div class="modal fade modalEditIjinKerja" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Edit Formulir Ijin Keluar Masuk (Pribadi)</h6>
                <button type="button" class="btn-close" style="background-color: white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="edit_id_ijin" id="id_ijin">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">NIK Karyawan</label>
                        <input type="text" name="edit_nik" placeholder="NIK Karyawan" readonly class="form-control nik" id="nik">
                    </div>
                    <div class="mb-3">
                        <label for="">Tanggal</label>
                        <input type="date" name="edit_tanggal_ijin" class="form-control" id="tanggal_ijin">
                    </div>
                    <div class="mb-3">
                        <label for="">Jam Keluar</label>
                        <div class="input-group">
                            <select name="edit_jam_keluar_jam" class="form-control" id="jam_keluar_jam">
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
                            <select name="edit_jam_keluar_menit" class="form-control" id="jam_keluar_menit">
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
                            <select name="edit_jam_datang_jam" class="form-control" id="jam_datang_jam">
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
                            <select name="edit_jam_datang_menit" class="form-control" id="jam_datang_menit">
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
                            <select name="edit_jam_istirahat_jam" class="form-control" id="jam_istirahat_jam">
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
                            <select name="edit_jam_istirahat_menit" class="form-control" id="jam_istirahat_menit">
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
                        <label for="">Keperluan</label>
                        <textarea name="edit_keperluan" class="form-control" id="keperluan" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                    <button type="button" class="btn btn-secondary btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
