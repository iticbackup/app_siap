<div class="modal fade modalBuat" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Buat Rekap Pelatihan & Seminar</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan" method="post">
                @csrf
            <div class="modal-body">
                <label class="form-label">Tanggal</label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <input type="date" name="start_date" class="form-control" placeholder="Start Date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <input type="date" name="End_date" class="form-control" placeholder="End Date">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tema Seminar</label>
                    <input type="text" name="tema" class="form-control" placeholder="Tema Seminar / Pelatihan">
                </div>
                <div class="mb-3">
                    <label class="form-label">Penyelenggara</label>
                    <input type="text" name="penyelenggara" class="form-control" placeholder="Penyelenggara">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Pelatihan / Seminar</label>
                    <select name="jenis" class="form-control" id="">
                        <option value="">-- Pilih Jenis Pelatihan --</option>
                        @foreach ($rekap_kategoris as $rk)
                            <option value="{{ $rk->kategori }}">{{ $rk->kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Jumlah Hari Pelatihan</label>
                        <input type="text" name="jml_hari" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jumlah Jam Pelatihan 1 Hari</label>
                        <input type="text" name="jml_jam_dlm_hari" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Total Hari</label>
                        <input type="text" name="total_hari" class="form-control" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label">Total Peserta</label>
                            <input type="text" name="total_peserta" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Jam Peserta</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <label class="form-label">Peserta</label>
                        <select name="peserta[]" class="select2 mb-3 select2-multiple" id="" multiple="multiple"
                            data-placeholder="Choose">
                            @foreach ($departemens as $departemen)
                                <option value="{{ $departemen->departemen }}">{{ $departemen->departemen }}</option>
                            @endforeach
                        </select>
                        {{-- <input type="text" name="total_peserta" class="form-control"> --}}
                        {{-- <div class="repeater-default">
                            <div data-repeater-list="peserta">
                                <div data-repeater-item="">
                                    <div class="form-group row d-flex align-items-end">
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <select name="departemen" class="form-control departemen" id="">
                                                    <option value="">-- Pilih Departemen --</option>
                                                    @foreach ($departemens as $departemen)
                                                        <option value="{{ $departemen->id }}">{{ $departemen->departemen }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-outline-primary"><i class="fas fa-search"></i> Cari Peserta</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control peserta" id="">
                                                <option value="">-- Pilih Nama Peserta --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0 row">
                                <div class="col-sm-12">
                                    <span data-repeater-create="" class="btn btn-outline-primary">
                                        <span class="fas fa-plus"></span> Add
                                    </span>
                                </div>
                            </div>
                        </div> --}}
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