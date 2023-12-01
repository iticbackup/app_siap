<title>Dokumen - {{ $file_manager_perubahan_data->kode_formulir }}</title>
<style>
    * {
    box-sizing: border-box;
    }
    body {
        font-family: "Arial Narrow", Helvetica, sans-serif;
        text-align: justify;
    }
    @media print {
        .table,
        .td,
        .th {
            border: 1px solid;
        }
    
        .table {
            width: 100%;
            border-collapse: collapse;
        }
    
        .text-center {
            text-align: center;
        }
    
        .text-bold {
            font-weight: bold;
        }

        table {
            page-break-inside: auto;
        }

        /* tr {
            page-break-inside: avoid !important;
        } */

        /* header {
            position: fixed;
            top: 0;
        } */

        .header {
            position: fixed;
            top: 0;
            width: 100%;
        }
        
        footer {
            page-break-after: always;
        }
    }

    @media only screen{
        .table,
        .td,
        .th {
            border: 1px solid;
        }
    
        .table {
            width: 100%;
            border-collapse: collapse;
        }
    
        .text-center {
            text-align: center
        }
    
        .text-bold {
            font-weight: bold
        }

        .container{
            width: 21cm;
            height: 29.7cm;
            margin: auto;
        }
    }

    .column {
        float: left;
        width: 33.3%;
        padding: 10px;
        height: 300px; /* Should be removed. Only for demonstration */
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>

<div class="container">
    <section class="header">
        <table class="table">
            <tr>
                <td colspan="2" rowspan="4" class="td text-center" style="width: 150px">
                    <div>
                        <img src="{{ URL::asset('public/itic/icon_itic.png') }}" alt="logo-small" class="text-center"
                            width="50">
                    </div>
                    <div>
                        <span style="font-size: 8pt; font-weight: bold">PT Indonesian Tobacco Tbk.</span>
                    </div>
                </td>
                <td colspan="5" rowspan="2" style="width: 250px; font-size: 11pt" class="td text-center text-bold">FORMULIR
                </td>
                <td colspan="2" class="text-bold" style="border-right: 0px solid; font-size: 11pt">Nomor</td>
                <td class="text-bold" style="font-size: 11pt">: IT/IT/FR/04</td>
            </tr>
            <tr>
                <td colspan="2" class="text-bold" style="font-size: 11pt">Revisi</td>
                <td class="text-bold" style="font-size: 11pt">: 4</td>
            </tr>
            <tr>
                <td colspan="5" rowspan="2" class="td text-center text-bold" style="font-size: 11pt">PERMOHONAN PERUBAHAN <br> INFORMASI TERDOKUMENTASI</td>
                <td colspan="2" class="text-bold" style="font-size: 11pt">Halaman</td>
                <td class="text-bold" style="font-size: 11pt">: 1</td>
            </tr>
            <tr>
                <td colspan="2" class="text-bold" style="font-size: 11pt">Tanggal</td>
                <td class="text-bold" style="font-size: 11pt">: 31/01/2020</td>
            </tr>
        </table>
    </section>
    <section class="page">
        <p>Pada hari <b>{{ \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->isoFormat('dddd, LL') }}</b>, mohon untuk diadakan perubahan informasi terdokumentasi sebagai berikut:</p>
        <table class="table">
            <thead>
                <tr>
                    <th class="th">Tanggal</th>
                    <th class="th" style="width: 150px">Nomor Informasi <br> Terdokumentasi</th>
                    <th class="th">Halaman</th>
                    <th class="th">Revisi</th>
                    <th class="th">Uraian Perubahan</th>
                    <th class="th">Disahkan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($file_manager_perubahan_data_details as $file_manager_perubahan_data_detail)
                <tr>
                    <td class="td text-center">{{ \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->format('d/m/Y') }}</td>
                    <td class="td text-center">{{ $file_manager_perubahan_data_detail->no_dokumen }}</td>
                    <td class="td text-center">{{ $file_manager_perubahan_data_detail->halaman }}</td>
                    <td class="td text-center">{{ $file_manager_perubahan_data_detail->revisi }}</td>
                    <td class="td" style="width: 250px; word-break: break-all;">{!! $file_manager_perubahan_data_detail->uraian_perubahan !!}</td>
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
    </section>
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
    
    {{-- <div class="row" style="margin-top: 2.5%">
        <div class="column text-center">
            <div>Disetujui Oleh</div>
            @if ($explode_validasi[0] == 'y')
            <div style="margin-top: 2.5%; margin-bottom: 2.5%">{!! DNS2D::getBarcodeSVG($detail['identifier'], 'QRCODE',2,2); !!}</div>
            @else
            <div style="margin-top: 9.4%; margin-bottom: 9.4%;">-</div>
            @endif
            <div>Document Control</div>
        </div>
        <div class="column text-center">
            <div>Diajukan Oleh</div>
            <div style="margin-top: 2.5%; margin-bottom: 2.5%">{!! DNS2D::getBarcodeSVG($detail_pengajuan['identifier'], 'QRCODE',2,2); !!}</div>
            <div>Staf / PIC {{ $file_manager_perubahan_data->departemen->departemen }}</div>
        </div>
        <div class="column text-center">
            <div>Mengetahui</div>
            @if ($file_manager_perubahan_data->represtative_signature == null)
            <div style="margin-top: 9.4%; margin-bottom: 9.4%;">-</div>
            @else
            <div style="margin-top: 2.5%; margin-bottom: 2.5%">{!! DNS2D::getBarcodeSVG($detail_pengajuan['identifier'], 'QRCODE', 2, 2) !!}</div>
            @endif
            <div>Management Represtative</div>
        </div>
    </div> --}}
    <footer>
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
        <table>
            <tr>
                <td>
                    <div>{!! DNS2D::getBarcodeSVG($file_manager_perubahan_data->kode_formulir, 'QRCODE',2,2); !!}</div>
                </td>
                <td style="font-size: 8pt">
                    <div>Informasi:</div>
                    <div>Berkas ini telah diverifikasi secara SAH oleh sistem tanggal {{ \Carbon\Carbon::create($file_manager_perubahan_data->created_at)->isoFormat('LL') }}</div>
                </td>
            </tr>
        </table>
    </footer>
</div>
