<div class="modal fade modalPrint" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-0">Cetak Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('presensi.detail_print',['nik' => $biodata_karyawan->nik]) }}" method="get" target="_blank">
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>NIK</th>
                            <th>:</th>
                            <td>{{ $biodata_karyawan->nik }}</td>
                        </tr>
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>:</th>
                            <td>{{ $biodata_karyawan->nama }}</td>
                        </tr>
                        <tr>
                            <th>Departemen</th>
                            <th>:</th>
                            <td>{{ $satuan_kerja }}</td>
                        </tr>
                        <tr>
                            <th>Opsional Waktu</th>
                            <th>:</th>
                            <td>
                                <div class="input-group">
                                    <select name="cetak_bulan" class="form-control" id="">
                                        <option value="">-- Bulan --</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select name="cetak_tahun" class="form-control" id="">
                                        <option value="">-- Tahun --</option>
                                        @for ($i = 2012; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Cetak</button>
                    <button type="button" class="btn btn-dark btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
