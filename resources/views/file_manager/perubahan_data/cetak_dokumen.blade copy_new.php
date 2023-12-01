<!DOCTYPE html>
<html>

<head>
    <script defer src="https://unpkg.com/pagedjs/dist/paged.polyfill.js"></script>
    <style>
        /* Styles go here */
        body {
            font-family: "Arial Narrow", Helvetica, sans-serif;
            text-align: justify;
            /* counter-reset: section; */
            counter-reset: page;
        }

        .table,
        .td,
        .th {
            border: 1px solid;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            /* position: absolute; */
        }

        .text-center {
            text-align: center
        }

        .text-bold {
            font-weight: bold
        }

        .page-header,
        .page-header-space {
            height: 100px;
        }

        .page {
            /* page-break-after: always; */
        }

        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;
            padding: 5%;
            /* border-bottom: 1px solid black; */
            /* for demo */
            /* background: yellow; */
            /* for demo */
        }

        .page-content {
            margin-top: 6%;
        }

        @page {
            /* margin: 10mm; */
            size: 210mm 297mm;
            /* margin-top: 10mm; */
            margin-left: 10mm;
            margin-right: 10mm;
        }

        @media print {
            .count-page::after {
                counter-increment: page;
                content: counter(page) ' of ' counter(pages);
            }
            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            body {
                margin: 0;
            }
            
        }
        
    </style>
    {{-- <script defer src="https://unpkg.com/pagedjs/dist/paged.polyfill.js"></script> --}}
</head>

<body>
    <div class="page-header">
        <table class="table">
            <tr>
                <td colspan="2" rowspan="4" class="td text-center" style="width: 200px">
                    <div>
                        <img src="{{ URL::asset('public/itic/icon_itic.png') }}" alt="logo-small" class="text-center"
                            width="50">
                    </div>
                    <div>
                        <span style="font-size: 8pt; font-weight: bold">PT Indonesian Tobacco Tbk.</span>
                    </div>
                </td>
                <td colspan="5" rowspan="2" style="width: 350px; font-size: 11pt" class="td text-center text-bold">FORMULIR
                </td>
                <td colspan="2" class="text-bold" style="width: 80px; border-right: 0px solid; font-size: 11pt">Nomor</td>
                <td class="text-bold" style="font-size: 11pt; width: 100px">: IT/IT/FR/04</td>
            </tr>
            <tr>
                <td colspan="2" class="text-bold" style="font-size: 11pt">Revisi</td>
                <td class="text-bold" style="font-size: 11pt">: 4</td>
            </tr>
            <tr>
                <td colspan="5" rowspan="2" class="td text-center text-bold" style="font-size: 11pt">PERMOHONAN PERUBAHAN <br> INFORMASI TERDOKUMENTASI</td>
                <td colspan="2" class="text-bold" style="font-size: 11pt">Halaman</td>
                <td class="text-bold" style="font-size: 11pt">: <span class="count-page"></span></td>
            </tr>
            <tr>
                <td colspan="2" class="text-bold" style="font-size: 11pt">Tanggal</td>
                <td class="text-bold" style="font-size: 11pt">: 31/01/2020</td>
            </tr>
        </table>
    </div>

    <div class="page-content">
        <div class="page">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <div>Pada hari <b>{{ \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->isoFormat('dddd, LL') }}</b>, mohon untuk diadakan perubahan informasi terdokumentasi sebagai berikut:</div>
                            <div class="page">
                                <div style="margin-top: 1.5%">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="th text-center">Tanggal</th>
                                                <th class="th text-center" style="width: 150px">Nomor Informasi <br> Terdokumentasi</th>
                                                <th class="th text-center">Halaman</th>
                                                <th class="th text-center">Revisi</th>
                                                <th class="th text-center">Uraian Perubahan</th>
                                                <th class="th text-center">Disahkan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($file_manager_perubahan_data_details as $file_manager_perubahan_data_detail)
                                            <tr>
                                                <td class="td text-center">{{ \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->format('d/m/Y') }}</td>
                                                <td class="td text-center">{{ $file_manager_perubahan_data_detail->no_dokumen }}</td>
                                                <td class="td text-center">{{ $file_manager_perubahan_data_detail->halaman }}</td>
                                                <td class="td text-center">{{ $file_manager_perubahan_data_detail->revisi }}</td>
                                                <td class="td" style="width: 350px; word-break: break-all;">{!! $file_manager_perubahan_data_detail->uraian_perubahan !!}</td>
                                                <td class="td text-center">
                                                    @if (empty($file_manager_perubahan_data->status))
                                                        -
                                                    @else
                                                        @php
                                                            $explode_validasi = explode('|',$file_manager_perubahan_data->status);
                                                        @endphp
                                                        {{ \Carbon\Carbon::create($explode_validasi[1])->format('d/m/Y') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                                        $explode_validasi = explode('|',$file_manager_perubahan_data->status);
                                    @endphp
                                    <table style="width: 100%; margin-top: 5%; margin-bottom: 5%">
                                        <tr>
                                            <td class="text-center" style="font-size: 10pt">Diajukan Oleh</td>
                                            <td class="text-center" style="font-size: 10pt">Disetujui Oleh</td>
                                            <td class="text-center" style="font-size: 10pt; width: 35%">Mengetahui</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <div>{!! DNS2D::getBarcodeSVG($detail_pengajuan['identifier'], 'QRCODE',1.8,1.8); !!}</div>
                                            </td>
                                            <td class="text-center">
                                                @if ($explode_validasi[0] == 'y')
                                                <div>{!! DNS2D::getBarcodeSVG($detail['identifier'], 'QRCODE',1.8,1.8); !!}</div>
                                                @else
                                                <div>-</div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($file_manager_perubahan_data->represtative_signature == null)
                                                <div>-</div>
                                                @else
                                                <div>{!! DNS2D::getBarcodeSVG($detail_representative['identifier'], 'QRCODE', 1.8, 1.8) !!}</div>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" style="font-size: 10pt">Document Control</td>
                                            <td class="text-center" style="font-size: 10pt">Staf / PIC {{ $file_manager_perubahan_data->departemen->departemen }}</td>
                                            <td class="text-center" style="font-size: 10pt">Management Represtative</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
        
                <tfoot>
                    <tr>
                        <td>
                            <!--place holder for the fixed-position footer-->
                            <div class="page-footer-space"></div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>
