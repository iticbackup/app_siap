<div class="modal fade modalBuatIjinKerja" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="exampleModalCenterTitle">Formulir Ijin Keluar Masuk (Pribadi)</h6>
                <button type="button" class="btn-close" style="background-color: white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">NIK Karyawan</label>
                        <input type="text" name="nik" placeholder="NIK Karyawan" readonly class="form-control nik" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Nama Karyawan</label>
                        <div class="input-group">
                            <input type="search" name="nama_karyawan" class="form-control nama_karyawan" id="">
                            <button type="button" class="btn btn-primary" id="btn-search"><i class="bx bx-search"></i> Search</button>
                        </div>
                        <ul class="list-group" id="result"></ul>
                    </div>
                    <div class="mb-3">
                        <label for="">Tanggal</label>
                        <input type="date" name="tanggal_ijin" class="form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Jam Keluar</label>
                        <div class="input-group">
                            <select name="jam_keluar_jam" class="form-control" id="">
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
                            <select name="jam_keluar_menit" class="form-control" id="">
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
                        <label for="">Jam Masuk</label>
                        <div class="input-group">
                            <select name="jam_datang_jam" class="form-control" id="">
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
                            <select name="jam_datang_menit" class="form-control" id="">
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
                            <select name="jam_istirahat_jam" class="form-control" id="">
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
                            <select name="jam_istirahat_menit" class="form-control" id="">
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
                        <textarea name="keperluan" class="form-control" id="" cols="30" rows="5"></textarea>
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
