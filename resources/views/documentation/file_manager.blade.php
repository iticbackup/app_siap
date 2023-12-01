@extends('layouts.docs.master')
@section('content')
    <div class="col-md-12">
        <div class="mt-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>File Manager</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div>File Manager merupakan aplikasi untuk melakukan penyimpanan data penting. setiap departemen mempunyai folder - folder sendiri untuk penyimpanan data.
                            Penyimpanan tersebut telah sesuai dan sudah diverifikasi oleh departemen - departemen sendiri dan tidak bisa melakukan update data secara sepihak.
                            Document Control dibagi menjadi beberapa kategori yaitu:
                        </div>
                        <ul>
                            <li>File Manager</li>
                            <li>Perubahan Dokumen</li>
                        </ul>
                    </div>
                    <div>
                        <h5><i class="fa fa-file"></i> File Manager</h5>
                        <div>Cara Penggunaan:</div>
                        {{-- <ol>
                            <li>Buat folder setiap departemen masing - masing.</li>
                            <li>Klik folder SOP dan lain - lain.</li>
                            <li>.</li>
                        </ol> --}}
                        <div>1. Klik <b>Create Folder</b> setiap departemen masing - masing.</div>
                        <img src="{{ asset('public/documentation/file_manager_1.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        <div>2. Maka muncul popup <b>Create Folder</b>. Buat nama folder sesuai dengan File tersebut.</div>
                        <img src="{{ asset('public/documentation/file_manager_create_folder.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        <div>3. Klik folder <b>SOP</b>, lalu klik tombol <b>Upload File</b>.</div>
                        <img src="{{ asset('public/documentation/file_manager.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        <div>4. Maka muncul popup <b>Upload File</b> tersebut. lalu isi form sesuai dengan file dokumen tersebut.</div>
                        <img src="{{ asset('public/documentation/file_manager_upload_file.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        <div class="alert custom-alert custom-alert-primary icon-custom-alert shadow-sm fade show d-flex justify-content-between" role="alert">  
                            <div class="media">
                                <i class="la la-exclamation-triangle alert-icon text-primary align-self-center font-30 me-3"></i>
                                <div class="media-body align-self-center">
                                    <h5 class="mb-1 fw-bold mt-0">Informasi</h5>
                                    <span>Formulir inputan <b>Upload File</b> hanya diinput sekali ketika melakukan submit. Dan tidak ada tombol untuk melakukan edit file atau penghapusan file.</span>
                                </div>
                            </div>
                        </div>
                        <div>5. Tampilan hasil <b>Upload File</b>.</div>
                        <img src="{{ asset('public/documentation/file_manager_akhir.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        
                        {{-- Perubahan Dokumen --}}
                        <h5><i class="fa fa-file"></i> Perubahan Dokumen</h5>
                        <div>Perubahan Dokumen yang dimaksud adalah perubahan dokumen yang akan diperbarui disetiap dokumen tersebut. Isi dari <b>Perubahan Dokumen</b> terdiri dari:</div>
                        <ol>
                            <li>Kode Formulir</li>
                            <li>Departemen</li>
                            <li>Tanggal Formulir Dibuat</li>
                            <li>Status</li>
                        </ol>
                        <img src="{{ asset('public/documentation/perubahan_dokumen.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        <div>Cara Penggunaan:</div>
                        <div>1. Klik <b>Buat Perubahan Dokumen</b>.</div>
                        <img src="{{ asset('public/documentation/perubahan_dokumen_1.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        <div>2. Buat isi formulir perubahan dokumen sesuai dengan dokumen yang akan dirubah.</div>
                        <img src="{{ asset('public/documentation/perubahan_dokumen_2.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        <div><b>Keterangan:</b></div>
                        <ol>
                            <li>Format untuk pengisian No. Dokumen yaitu: <b>IT/IT/SOP/001</b> dan tidak boleh input seperti: <b style="color: red; text-decoration: line-through;">IT.IT.SOP.001</b></li>
                            <li>Tombol <button type="button" class="btn btn-outline-primary mt-1 mb-1"><i class="fas fa-plus"></i> Add</button> berfungsi untuk menambah inputan detail formulir yang lebih dari 1 inputan.</li>
                            <li>Tombol <button type="button" class="btn btn-outline-danger mt-1 mb-1"><i class="far fa-trash-alt"></i> Delete</button> berfungsi untuk menghapus inputan 1 baris.</li>
                        </ol>
                        <div>Contoh Inputan Perubahan Dokumen</div>
                        <img src="{{ asset('public/documentation/perubahan_dokumen_3.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        <div>Contoh Hasil Inputan Perubahan Dokumen</div>
                        <img src="{{ asset('public/documentation/perubahan_dokumen_4.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        <img src="{{ asset('public/documentation/perubahan_dokumen_5_detail.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        <div>3. Halaman Validasi untuk melakukan verifikasi dokumen oleh <b>Document Control</b> dan <b>Management Representative</b> </div>
                        <img src="{{ asset('public/documentation/perubahan_dokumen_6_validasi.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                        <div><b>Keterangan:</b></div>
                        <ol>
                            <li>Tombol <button type="button" class="btn btn-outline-info mt-1 mb-1"><i class="fas fa-eye"></i> Lihat Dokumen</button> berfungsi untuk melihat file dokumen sesuai dengan perubahan dokumen.</li>
                        </ol>
                        <div class="alert custom-alert custom-alert-danger icon-custom-alert shadow-sm fade show d-flex justify-content-between" role="alert">  
                            <div class="media">
                                <i class="la la-exclamation-triangle alert-icon text-danger align-self-center font-30 me-3"></i>
                                <div class="media-body align-self-center">
                                    <h5 class="mb-1 fw-bold mt-0">Catatan</h5>
                                    <span>QR Code tidak bisa dimanipulasi dikarenakan telah terecord oleh sistem.</span>
                                </div>
                            </div>
                        </div>
                        <div>Contoh Hasil Validasi Perubahan Dokumen</div>
                        <img src="{{ asset('public/documentation/perubahan_dokumen_7_approved.jpg') }}" class="mb-3" style="border: 1px solid blue; width: 100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
