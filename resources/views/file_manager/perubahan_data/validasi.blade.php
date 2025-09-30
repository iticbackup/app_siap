@extends('layouts.apps.master')
@section('title')
    Validasi Perubahan Dokumen
@endsection
@section('css')
    <style>
        .column {
            float: left;
            width: 33.3%;
            padding: 10px;
            height: 300px;
            /* Should be removed. Only for demonstration */
        }

        .stamp {
            position: relative;
            display: inline-block;
            color: rgb(255, 0, 0);
            padding: 15px;
            background-color: white;
            box-shadow:inset 0px 0px 0px 5px rgb(255, 0, 0);
        }

        .stamp:after{
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-image: url("../../public/stamp/5O74VI6.jpg");
            mix-blend-mode: lighten;
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @yield('title')
        @endslot
        @slot('title')
            @yield('title')
        @endslot
    @endcomponent
    @include('file_manager.perubahan_data.modalCekDokumen')
    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success border-0" role="alert">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger border-0" role="alert">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="card">
                <div class="card-header bg-dark">
                    <h4 class="card-title text-white text-center" style="font-size: 14pt">Validasi Perubahan Dokumen</h4>
                    <div class="text-white text-center">No. Dokumen: {{ $file_manager_perubahan_data->kode_formulir }}</div>
                </div>
                <form action="{{ route('perubahan_data.validasi_submit',['id' => $file_manager_perubahan_data->id]) }}" method="post">
                    @csrf
                <div class="card-body">
                    <p>Pada hari
                        <b>{{ \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->isoFormat('dddd, LL') }}</b>,
                        mohon untuk diadakan perubahan informasi terdokumentasi sebagai berikut:
                    </p>
                    <table class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center" style="background-color: #AAD9BB">Tanggal</th>
                                <th class="text-center" style="background-color: #AAD9BB">No. Dokumen</th>
                                <th class="text-center" style="background-color: #AAD9BB">Halaman</th>
                                <th class="text-center" style="background-color: #AAD9BB">Revisi</th>
                                <th class="text-center" style="width: 50%; background-color: #AAD9BB">Uraian Perubahan</th>
                                <th class="text-center" style="background-color: #AAD9BB">File</th>
                                {{-- <th class="text-center" style="width: 10%; background-color: #AAD9BB">Disahkan</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($file_manager_perubahan_data_details as $file_manager_perubahan_data_detail)
                                {{-- @if (empty($file_manager_perubahan_data_detail->validasi))
                                <input type="hidden" name="id[]" value="{{ $file_manager_perubahan_data_detail->id }}" id="">
                                @endif --}}
                                <tr>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">{{ $file_manager_perubahan_data_detail->no_dokumen }}</td>
                                    <td class="text-center">{{ $file_manager_perubahan_data_detail->halaman }}</td>
                                    <td class="text-center">{{ $file_manager_perubahan_data_detail->revisi }}</td>
                                    <td style="word-break: break-all;">{!! $file_manager_perubahan_data_detail->uraian_perubahan !!}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-info" onclick="cek_dokumen(`{{ $file_manager_perubahan_data_detail->file_manager_perubahan_data_id }}`,`{{ $file_manager_perubahan_data_detail->id }}`)"><i class="fa fa-eye"></i> Lihat Dokumen</button>
                                    </td>
                                    {{-- <td class="text-center">
                                        @if (empty($file_manager_perubahan_data_detail->validasi))
                                            <select name="validasi[]" class="form-control" id="">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="y">Disetujui</option>
                                                <option value="n">Ditolak</option>
                                            </select>
                                        @else
                                            @php
                                                $explode_validasi = explode('|',$file_manager_perubahan_data_detail->validasi);
                                            @endphp
                                            {{ \Carbon\Carbon::create($explode_validasi[1])->format('d/m/Y') }}
                                        @endif
                                    </td> --}}
                                    {{-- @php
                                        if (empty($file_manager_perubahan_data->status)) {
                                            $validasi = '-';
                                        }else{
                                            $explode_validasi_all = explode('|',$file_manager_perubahan_data->status);
                                            if ($explode_validasi_all[0] == 'y') {
                                                $validasi_dc = '<span class="text-success" style="font-weight: bold">DC</span> '.\Carbon\Carbon::create($explode_validasi_all[1])->format('d/m/Y');
                                            }elseif($explode_validasi_all[0] == 'n'){
                                                $validasi_dc = '<span class="text-danger" style="font-weight: bold">DC</span> '.\Carbon\Carbon::create($explode_validasi_all[1])->format('d/m/Y');
                                            }
                                        }
                                    @endphp --}}
                                    {{-- <td class="text-center">{!! $validasi_dc !!}</td> --}}
                                </tr>
                            @endforeach
                            @php
                                $explode_validasi_signature = explode('|',$file_manager_perubahan_data->status);
                            @endphp
                            @if (empty($file_manager_perubahan_data->status))
                                @if (auth()->user()->nik == '1207514' || 
                                auth()->user()->nik == '0000000' || 
                                auth()->user()->nik == '0000010' || 
                                auth()->user()->nik == '2103484' ||
                                auth()->user()->nik == '2007275' ||
                                auth()->user()->nik == '2207603'
                                )
                                <tr>
                                    <td colspan="5" style="text-align: right">
                                        Status Validasi Document Control
                                    </td>
                                    <td>
                                        <select name="validasi_document_control" class="form-control" id="validasi_document_control">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="y">Disetujui</option>
                                            <option value="n">Ditolak</option>
                                        </select>
                                    </td>
                                </tr>
                                @endif
                            @else
                            @if ($explode_validasi_signature[2] == null)
                                @if (auth()->user()->nik == 1711952 || auth()->user()->nik == 0000000)
                                    <tr>
                                        <td colspan="5" style="text-align: right">
                                            Status Validasi Management Representative
                                        </td>
                                        <td>
                                            <select name="validasi_management_repesentative" class="form-control" id="validasi_management_representative">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="y">Disetujui</option>
                                                <option value="n">Ditolak</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endif
                            @endif

                            @endif
                            {{-- @if ($explode_validasi_signature[0] != null)
                                @if (auth()->user()->nik == 1207514 || auth()->user()->nik == 0000000)
                                <tr>
                                    <td colspan="6" style="text-align: right">Status Validasi Document Control</td>
                                    <td>
                                        <select name="validasi_document_control" class="form-control" id="">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="y">Disetujui</option>
                                            <option value="n">Ditolak</option>
                                        </select>
                                    </td>
                                </tr>
                                @endif
                            @endif --}}
                            {{-- @if ($file_manager_perubahan_data->disetujui_signature == null)
                                @if (auth()->user()->nik == 1207514 || auth()->user()->nik == 0000000)
                                <tr>
                                    <td colspan="6" style="text-align: right">Status Validasi Document Control</td>
                                    <td>
                                        <select name="validasi_document_control" class="form-control" id="">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="y">Disetujui</option>
                                            <option value="n">Ditolak</option>
                                        </select>
                                    </td>
                                </tr>
                                @endif
                            @endif
                            @if ($file_manager_perubahan_data->represtative_signature == null)
                                @if (auth()->user()->nik == 1711952 || auth()->user()->nik == 0000000)
                                <tr>
                                    <td colspan="6" style="text-align: right">Status Validasi Management Representative</td>
                                    <td>
                                        <select name="validasi_management_repesentative" class="form-control" id="">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="y">Disetujui</option>
                                            <option value="n">Ditolak</option>
                                        </select>
                                    </td>
                                </tr>
                                @endif
                            @endif --}}
                        </tbody>
                    </table>
                    @php
                        $explode_validasi = explode('|',$file_manager_perubahan_data->status);
                    @endphp
                    @if (auth()->user()->nik == '1207514' || 
                    auth()->user()->nik == '1711952' ||
                    auth()->user()->nik == '0000000' ||
                    auth()->user()->nik == '0000010' ||
                    auth()->user()->nik == '2007275' ||
                    auth()->user()->nik == '2207603'
                    )
                        @if ($file_manager_perubahan_data->status == null || $explode_validasi[2] == null)
                        <div class="mb-2 badge badge-outline-danger">
                            <b>Catatan:</b>
                            Jika status validasi Ditolak maka, remaks harus diisi.
                        </div>
                        <div class="mb-3" id="remaks" style="display: none">
                            <label for="">Remaks</label>
                            <textarea name="remakss" class="form-control" id="" cols="30" rows="5"></textarea>
                        </div>
                        @endif
                    @endif
                    @php
                        $detail = [
                            'identifier' => 'ID: ' . $file_manager_perubahan_data->id . "\n" . 
                                            'Kode Formulir: ' . $file_manager_perubahan_data->kode_formulir . "\n" . 
                                            'Signature: ' . $file_manager_perubahan_data->disetujui_signature . "\n" . 
                                            'Tanggal Formulir: ' . \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->isoFormat('LL'),
                        ];
                        $detail_pengajuan = [
                            'identifier' => 'ID: ' . $file_manager_perubahan_data->id . "\n" . 
                                            'Kode Formulir: ' . $file_manager_perubahan_data->kode_formulir . "\n" . 
                                            'Signature: ' . $file_manager_perubahan_data->pengajuan_signature . "\n" . 
                                            'Tanggal Formulir: ' . \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->isoFormat('LL'),
                        ];
                        $detail_representative = [
                            'identifier' => 'ID: ' . $file_manager_perubahan_data->id . "\n" . 
                                            'Kode Formulir: ' . $file_manager_perubahan_data->kode_formulir . "\n" . 
                                            'Signature: ' . $file_manager_perubahan_data->represtative_signature . "\n" . 
                                            'Tanggal Formulir: ' . \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->isoFormat('LL'),
                        ];
                    @endphp
                    <div class="row">
                        <div class="column text-center">
                            <div>Diajukan Oleh</div>
                            <div style="margin-top: 2.5%; margin-bottom: 2.5%">{!! DNS2D::getBarcodeSVG($detail_pengajuan['identifier'], 'QRCODE', 2, 2) !!}</div>
                            <div>Staf / PIC {{ $file_manager_perubahan_data->departemen->departemen }}</div>
                        </div>
                        <div class="column text-center">
                            <div>Disetujui Oleh</div>
                            {{-- @if ($explode_validasi[0] == 'y')
                            <div style="margin-top: 2.5%; margin-bottom: 2.5%">{!! DNS2D::getBarcodeSVG($detail['identifier'], 'QRCODE', 2, 2) !!}</div>
                            @else
                            <div style="margin-top: 9.4%; margin-bottom: 9.4%;">-</div>
                            @endif --}}
                            @if (empty($file_manager_perubahan_data->status))
                            <div style="margin-top: 9.4%; margin-bottom: 9.4%;">-</div>
                            @else
                                @if ($explode_validasi[0] == null)
                                <div style="margin-top: 9.4%; margin-bottom: 9.4%;">-</div>
                                @elseif($explode_validasi[0] == 'y')
                                <div style="margin-top: 2.5%; margin-bottom: 2.5%">{!! DNS2D::getBarcodeSVG($detail['identifier'], 'QRCODE', 2, 2) !!}</div>
                                @elseif($explode_validasi[0] == 'n')
                                <div style="margin-top: 6%; margin-bottom: 6%;" class="stamp">REJECTED</div>
                                @endif
                            @endif
                            <div>Document Control</div>
                        </div>
                        <div class="column text-center">
                            <div>Mengetahui</div>
                            {{-- @if($explode_validasi[2] == 'n')
                            <div style="margin-top: 6%; margin-bottom: 6%;" class="stamp">REJECTED</div>
                            @elseif ($file_manager_perubahan_data->represtative_signature == null)
                            <div style="margin-top: 9.4%; margin-bottom: 9.4%;">-</div>
                            @else
                            <div style="margin-top: 2.5%; margin-bottom: 2.5%">{!! DNS2D::getBarcodeSVG($detail_pengajuan['identifier'], 'QRCODE', 2, 2) !!}</div>
                            @endif --}}
                            @if (empty($file_manager_perubahan_data->status))
                            <div style="margin-top: 9.4%; margin-bottom: 9.4%;">-</div>
                            @else
                                @if ($explode_validasi[2] == null)
                                <div style="margin-top: 9.4%; margin-bottom: 9.4%;">-</div>
                                @elseif($explode_validasi[2] == 'y')
                                <div style="margin-top: 2.5%; margin-bottom: 2.5%">{!! DNS2D::getBarcodeSVG($detail_representative['identifier'], 'QRCODE', 2, 2) !!}</div>
                                @elseif($explode_validasi[2] == 'n')
                                <div style="margin-top: 6%; margin-bottom: 6%;" class="stamp">REJECTED</div>
                                @endif
                            @endif
                            <div>Management Represtative</div>
                        </div>
                    </div>
                    <footer>
                        <table>
                            <tr>
                                <td>
                                    <div>{!! DNS2D::getBarcodeSVG($file_manager_perubahan_data->kode_formulir, 'QRCODE', 2, 2) !!}</div>
                                </td>
                                <td style="font-size: 8pt">
                                    <div>Informasi:</div>
                                    <div>Berkas ini telah diverifikasi secara SAH oleh sistem tanggal
                                        {{ \Carbon\Carbon::create($file_manager_perubahan_data->created_at)->isoFormat('LL') }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </footer>
                </div>
                <div class="card-footer">
                    {{-- <a href="{{ route('perubahan_data') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                        Back</a> --}}
                    <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                        Back</a>
                    @if (auth()->user()->nik == '1207514' || 
                    auth()->user()->nik == '1711952' || 
                    auth()->user()->nik == '0000000' || 
                    auth()->user()->nik == '0000010' || 
                    auth()->user()->nik == '2007275' ||
                    auth()->user()->nik == '2207603'
                    )
                        @php
                            $explode_validasi = explode('|',$file_manager_perubahan_data->status);
                            // dd($explode_validasi);
                        @endphp
                        {{-- @if ($explode_validasi[0] != 'y' || $explode_validasi[2] != 'y')
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Submit</button>
                        @endif --}}
                        @if (empty($file_manager_perubahan_data->status))
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Submit</button>
                        @elseif ($explode_validasi[0] == 'n')
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Submit</button>
                        @elseif ($explode_validasi[0] == 'y' && $explode_validasi[2] == null)
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Submit</button>
                        @endif
                    @endif
                    {{-- <a href="{{ route('perubahan_data.cetak_dokumen', ['id' => $file_manager_perubahan_data->id]) }}"
                        class="btn btn-primary"><i class="fas fa-print"></i> Cetak Dokumen</a> --}}
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function cek_dokumen(id,id_perubahan_data) {
            $.ajax({
                type:'GET',
                url: "{{ url('perubahan_data/') }}"+'/'+id+'/'+id_perubahan_data+'/'+'cek_dokumen',
                contentType: "application/json;  charset=utf-8",
                cache: false,
                beforeSend: function(xhr) {
                    document.getElementById('file_dokumen').innerHTML = "<div class='spinner-border spinner-border-custom-2 text-primary' role='status'></div>";
                    $('.modalCekDokumen').modal('show');
                },
                success: (result) => {
                    document.getElementById('file_dokumen').innerHTML = '<iframe src="'+result.files+'" width="100%" height="720px" scrolling="auto" frameBorder="0"></frame>'
                    // if(result.success == true){
                    //     document.getElementById('title_file_manager').innerHTML ='<h4 class="card-title">'+
                    //                                         '<button onclick="uploadBerkas(`'+result.kategori_id+'`)" class="btn btn-outline-primary btn-sm add-file" style="margin-left: 1%"><i class="las la-cloud-upload-alt me-2 font-15"></i>Upload File</button>'+
                    //                                         '</h4>';
                    //     const dataFileManagerList = result.data;
                    //     var txtFileManagerList = "";
                    //     dataFileManagerList.forEach(data_file_manager_list);
                    //     function data_file_manager_list(value, index){
                    //         txtFileManagerList = txtFileManagerList+"<tr>";
                    //         txtFileManagerList = txtFileManagerList+"<td>"+value.title+"</td>";
                    //         txtFileManagerList = txtFileManagerList+"<td>"+
                    //                                                     "<div class='btn-group'>"+
                    //                                                         "<button class='btn btn-success' onclick='preview_file("+value.id+")'><i class='fas fa-eye'></i> Preview</button>"+
                    //                                                         "<button class='btn btn-primary' onclick='download_file("+value.id+")'><i class='fas fa-download'></i> Download</button>"+
                    //                                                     "</div>"
                    //                                                 +"</td>";
                    //         txtFileManagerList = txtFileManagerList+"</tr>";
                    //     }
                    //     document.getElementById('data-body').innerHTML = txtFileManagerList;
                    // }else{

                    // }
                },
                error: function (request, status, error) {

                }
            });
        }

        $('#validasi_document_control').change(function(){
            const status_management_representative = $('#validasi_document_control').val();
            if (status_management_representative == 'n') {
                document.getElementById("remaks").style.display = "block";
            }else{
                document.getElementById("remaks").style.display = "none";
            }
        });

        $('#validasi_management_representative').change(function(){
            const status_management_representative = $('#validasi_management_representative').val();
            if (status_management_representative == 'n') {
                document.getElementById("remaks").style.display = "block";
            }else{
                document.getElementById("remaks").style.display = "none";
            }
        });

    </script>
@endsection