<div class="modal fade modalRekap" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Rekap Pelatihan & Seminar Karyawan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-rekap-pelatihan" method="post">
                @csrf
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tema</th>
                            <th>:</th>
                            <th id="detail_nama_pelatihan"></th>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <th>:</th>
                            <th id="detail_jenis"></th>
                        </tr>
                        <tr>
                            <th>Kategori Pelatihan</th>
                            <th>:</th>
                            <th id="detail_kategori_pelatihan"></th>
                        </tr>
                        <tr>
                            <th>Penyelenggara</th>
                            <th>:</th>
                            <th id="detail_penyelenggara"></th>
                        </tr>
                        <tr>
                            <th>Total Peserta</th>
                            <th>:</th>
                            <th id="detail_total_peserta"></th>
                        </tr>
                    </thead>
                </table>
                <div class="text-center" style="font-weight: bold; font-size: 14pt">DATA PESERTA</div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Rekap Pelatihan / Seminar Peserta</th>
                            <th class="text-center">To</th>
                            <th class="text-center">Rekap Pelatihan / Seminar Karyawan</th>
                        </tr>
                    </thead>
                    <tbody id="result_data_peserta">

                    </tbody>
                </table>
                <div class="mb-3">
                    <span style="font-weight: bold">Note:</span>
                    <ul>
                        <li>
                            Bertanda <i class="mdi mdi-arrow-right-bold-circle-outline"></i> artinya Rekap Pelatihan Seminar Peserta yang telah diikuti <b>akan disalin</b> ke Rekap Pelatihan / Seminar Karyawan HRGA
                        </li>
                        <li>
                            Bertanda <i class="mdi mdi-check-circle-outline" style="color: green"></i> artinya Rekap Pelatihan Seminar Peserta yang telah diikuti <b>telah disalin</b> ke Rekap Pelatihan / Seminar Karyawan HRGA
                        </li>
                    </ul>
                </div>
                {{-- <div class="mb-3">
                    <label for="">Nama Pelatihan</label>
                    <div id="detail_nama_pelatihan"></div>
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