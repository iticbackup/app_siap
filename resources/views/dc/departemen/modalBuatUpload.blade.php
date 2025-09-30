<div class="modal fade modalBuatUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Upload File</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-upload-file-simpan" method="post" enctype="multipart/form-data">
                @csrf
                {{-- <input type="hidden" name="file_manager_category_id" id="file_manager_category_id"> --}}
                {{-- <input type="text" name="departemen_id" id="departemen_id"> --}}
                <input type="hidden" name="modaldc_category_id" id="modalIdKategori">
            <div class="modal-body">
                {{-- <div class="mb-3">
                    <label class="form-label">No. Dokumen</label>
                    <input type="text" name="no_dokumen" class="form-control" placeholder="No. Dokumen">
                    <div class="mt-2">
                        <div>Cara Penulisan No. Dokumen:</div>
                        <ul>
                            <li>IT.IT.SOP.01 <i class="fas fa-check text-success"></i></li>
                            <li>IT/IT/SOP/01 <i class="fas fa-times text-danger"></i></li>
                        </ul>
                    </div>
                </div> --}}
                <div class="mb-3">
                    <div>Cara Penulisan No. Dokumen:</div>
                    <ul>
                        <li>IT.IT.SOP.01 <i class="fas fa-check text-success"></i></li>
                        <li>IT/IT/SOP/01 <i class="fas fa-times text-danger"></i></li>
                    </ul>
                </div>
                <hr>
                <div class="repeater">
                    <div data-repeater-list="documents">
                        <div data-repeater-item class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label>No. Dokumen</label>
                                    <input type="text" name="no_dokumen" class="form-control" placeholder="No. Dokumen" id="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label>Nama Dokumen</label>
                                    <input type="text" name="nama_dokumen" class="form-control" placeholder="Nama Dokumen" id="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label>Tanggal Terbit</label>
                                    <input type="date" name="tanggal_terbit" class="form-control" placeholder="Nama Dokumen" id="">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="mb-3">
                                    <label>No. Revisi</label>
                                    <input type="number" min="0" name="no_revisi" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label>Upload Dokumen</label>
                                    <input type="file" name="files" class="form-control" placeholder="No. Revisi" id="">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <input data-repeater-delete type="button" class="btn btn-danger" value="Delete">
                            </div>
                        </div>
                    </div>
                    <input data-repeater-create type="button" class="btn btn-success" value="Tambah">
                </div>
                {{-- <hr>
                <div class="mb-3">
                    <label>Validasi</label>
                    <div class="row">
                        <div class="col-md-4">
                            <select name="validasi_disetujui" class="form-control" id="">
                                <option value="">-- Pilih Disetujui Oleh --</option>
                                @foreach ($listValidasiDisetujuis as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <div id="preview_validasi_disetujui"></div>
                        </div>
                        <div class="col-md-4">
                            <select name="validasi_diperiksa" class="form-control" id="">
                                <option value="">-- Pilih Diperiksa Oleh --</option>
                                @foreach ($listValidasiDiperiksas as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="validasi_dibuat" class="form-control" id="">
                                <option value="">-- Pilih Dibuat Oleh --</option>
                                @foreach ($listValidasiDibuats as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="mb-3">
                    <label class="form-label">Nama File</label>
                    <input type="text" name="title" class="form-control" placeholder="Nama File">
                </div> --}}

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Submit</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>