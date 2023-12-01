<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Dokumen Permohonan Perubahan Informasi Terdokumentasi - {{ $file_manager_perubahan_data->kode_formulir }}</title>
    <script src="https://unpkg.com/pagedjs/dist/paged.polyfill.js"></script>
    <script>
        // @see: https://gitlab.pagedmedia.org/tools/pagedjs/issues/84#note_535
        class RepeatingTableHeaders extends Paged.Handler {
            constructor(chunker, polisher, caller) {
                super(chunker, polisher, caller);
            }

            afterPageLayout(pageElement, page, breakToken, chunker) {
                // Find all split table elements
                let tables = pageElement.querySelectorAll("table[data-split-from]");

                tables.forEach((table) => {
                    // Get the reference UUID of the node
                    let ref = table.dataset.ref;
                    // Find the node in the original source
                    let sourceTable = chunker.source.querySelector("[data-ref='" + ref + "']");
                    // Find if there is a header
                    let header = sourceTable.querySelector("thead");
                    if (header) {
                        // Clone the header element
                        let clonedHeader = header.cloneNode(true);
                        // Insert the header at the start of the split table
                        table.insertBefore(clonedHeader, table.firstChild);
                    }
                });

            }
        }

        Paged.registerHandlers(RepeatingTableHeaders);
    </script>
    <style>
        html,
        body {
            font-size: 15px;
        }

        body {
            margin: 0;
            -webkit-print-color-adjust: exact;
            font-family: "Arial Narrow", Helvetica, sans-serif;
            counter-reset: page;
        }

        @page {
            size: A4;
            margin-top: 0mm;
            margin-bottom: 20mm;
            margin-left: 15mm;
            margin-right: 15mm;
        }

        @page {
            padding-top: 2rem;

            @top-center {
                content: element(title);
            }

            @top-right {
                color: white;
                content: counter(page) ' of ' counter(pages);
            }

            @bottom-left {
                content: element(footer);
            }
        }

        @page: nth(1) {
            padding-top: 0;

            @top-center {
                content: "";
            }

            @top-right {
                content: "";
            }

            @bottom-left {
                content: "";
            }
        }

        #count-page::after {
            counter-increment: page;
            content: counter(page) ' of ' counter(pages);
        }

        .pagedjs_page:not([data-page-number="0"]) .pagedjs_margin-top-left-corner-holder,
        .pagedjs_page:not([data-page-number="0"]) .pagedjs_margin-top,
        .pagedjs_page:not([data-page-number="0"]) .pagedjs_margin-top-right-corner-holder {
            background: #658db4;
            outline: 2px #658db4;
        }

        .cover {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .title {
            position: running(title);
            color: white;
            font-size: 1.25rem;
        }

        .footer {
            position: running(footer);
            font-size: 1rem;
            color: #999;
            /* border-top: 2px solid #ccc; */
        }

        .row {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }

        .col {
            margin-left: 2rem;
        }

        .avoid-break {
            page-break-inside: avoid;
        }

        .force-break {
            page-break-before: always;
        }

        .section+.section {
            margin-top: 4rem;
        }

        /* table {
            border-collapse: collapse;
            margin-top: 2.5rem;
            width: 100%;
            font-size: 1.1em;
        } */

        /* table,
        th,
        td {
            border: 1px solid #ccc;
        }

        td,
        th {
            padding: 1em;
        } */

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

        .pagedjs_pagebox * {
            box-sizing: none;
        }

        ul{
            margin: 1%
        }
    </style>
</head>

<body>
    <div class="avoid-break force-break">
        <table>
            <thead>
                <tr>
                    <td>
                        <div class="header-space">
                            <table class="table">
                                <tr>
                                    <td colspan="2" rowspan="4" class="td text-center" style="width: 200px">
                                        <div>
                                            <img src="{{ URL::asset('public/itic/icon_itic.png') }}" alt="logo-small"
                                                class="text-center" width="50">
                                        </div>
                                        <div>
                                            <span style="font-size: 8pt; font-weight: bold">PT Indonesian Tobacco
                                                Tbk.</span>
                                        </div>
                                    </td>
                                    <td colspan="5" rowspan="2" style="width: 350px; font-size: 11pt"
                                        class="td text-center text-bold">FORMULIR
                                    </td>
                                    <td colspan="2" class="text-bold"
                                        style="width: 80px; border-right: 0px solid; font-size: 11pt">Nomor</td>
                                    <td class="text-bold" style="font-size: 11pt; width: 100px">: IT/IT/FR/04</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-bold" style="font-size: 11pt">Revisi</td>
                                    <td class="text-bold" style="font-size: 11pt">: 4</td>
                                </tr>
                                <tr>
                                    <td colspan="5" rowspan="2" class="td text-center text-bold"
                                        style="font-size: 11pt">PERMOHONAN PERUBAHAN <br> INFORMASI TERDOKUMENTASI</td>
                                    <td colspan="2" class="text-bold" style="font-size: 11pt">Halaman</td>
                                    <td class="text-bold" style="font-size: 11pt">: <span id="count-page"></span></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-bold" style="font-size: 11pt">Tanggal</td>
                                    <td class="text-bold" style="font-size: 11pt">: 31/01/2020</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="content">
                            <div>Pada hari
                                <b>{{ \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->isoFormat('dddd, LL') }}</b>,
                                mohon untuk diadakan perubahan informasi terdokumentasi sebagai berikut:
                            </div>
                            <div style="margin-top: 1.5%">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="th text-center">Tanggal</th>
                                            <th class="th text-center" style="width: 150px">Nomor Informasi <br>
                                                Terdokumentasi</th>
                                            <th class="th text-center">Halaman</th>
                                            <th class="th text-center">Revisi</th>
                                            <th class="th text-center">Uraian Perubahan</th>
                                            <th class="th text-center">Disahkan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 0;
                                        @endphp
                                        @foreach ($file_manager_perubahan_data_details as $key => $file_manager_perubahan_data_detail)
                                            <tr>
                                                <td class="td text-center" style="vertical-align: top">
                                                    {{ \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->format('d/m/Y') }}
                                                </td>
                                                <td class="td text-center" style="vertical-align: top">
                                                    {{ $file_manager_perubahan_data_detail->no_dokumen }}
                                                </td>
                                                <td class="td text-center" style="vertical-align: top">
                                                    {{ $file_manager_perubahan_data_detail->halaman }}
                                                </td>
                                                <td class="td text-center" style="vertical-align: top">
                                                    {{ $file_manager_perubahan_data_detail->revisi }}
                                                </td>
                                                <td class="td" style="width: 250px; vertical-align: top;">
                                                    {!! $file_manager_perubahan_data_detail->uraian_perubahan !!}
                                                </td>
                                                <td class="td text-center" style="vertical-align: top;">
                                                    @if (empty($file_manager_perubahan_data->status))
                                                        -
                                                    @else
                                                        @php
                                                            $explode_validasi = explode('|', $file_manager_perubahan_data->status);
                                                        @endphp
                                                        {{ \Carbon\Carbon::create($explode_validasi[1])->format('d/m/Y') }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @php
                                $detail = [
                                    'identifier' => 'ID: ' . $file_manager_perubahan_data->id . "\n" . 'Kode Formulir: ' . $file_manager_perubahan_data->kode_formulir . "\n" . 'Signature: ' . $file_manager_perubahan_data->disetujui_signature . "\n" . 'Tanggal Formulir: ' . \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->isoFormat('LL'),
                                ];
                                $detail_pengajuan = [
                                    'identifier' => 'ID: ' . $file_manager_perubahan_data->id . "\n" . 'Kode Formulir: ' . $file_manager_perubahan_data->kode_formulir . "\n" . 'Signature: ' . $file_manager_perubahan_data->pengajuan_signature . "\n" . 'Tanggal Formulir: ' . \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->isoFormat('LL'),
                                ];
                                $detail_representative = [
                                    'identifier' => 'ID: ' . $file_manager_perubahan_data->id . "\n" . 'Kode Formulir: ' . $file_manager_perubahan_data->kode_formulir . "\n" . 'Signature: ' . $file_manager_perubahan_data->represtative_signature . "\n" . 'Tanggal Formulir: ' . \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->isoFormat('LL'),
                                ];
                                $explode_validasi = explode('|', $file_manager_perubahan_data->status);
                            @endphp
                            <table style="width: 100%; margin-top: 2.5%;">
                                <tr>
                                    <td class="text-center" style="font-size: 10pt">Diajukan Oleh</td>
                                    <td class="text-center" style="font-size: 10pt">Disetujui Oleh</td>
                                    <td class="text-center" style="font-size: 10pt; width: 35%">Mengetahui</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div>{!! DNS2D::getBarcodeSVG($detail_pengajuan['identifier'], 'QRCODE', 1.8, 1.8) !!}</div>
                                    </td>
                                    <td class="text-center">
                                        @if ($explode_validasi[0] == 'y')
                                            <div>{!! DNS2D::getBarcodeSVG($detail['identifier'], 'QRCODE', 1.8, 1.8) !!}</div>
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
                                    <td class="text-center" style="font-size: 10pt">Staf / PIC
                                        {{ $file_manager_perubahan_data->departemen->departemen }}</td>
                                    <td class="text-center" style="font-size: 10pt">Document Control</td>
                                    <td class="text-center" style="font-size: 10pt">Management Represtative</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            <table>
                <tr>
                    <td>
                        <div>{!! DNS2D::getBarcodeSVG($file_manager_perubahan_data->kode_formulir, 'QRCODE', 2, 2) !!}</div>
                    </td>
                    <td style="font-size: 8pt">
                        <div style="color: black; margin-bottom: 2.5%">No. Formulir: {{ $file_manager_perubahan_data->kode_formulir }}</div>
                        <div style="color: black">Informasi:</div>
                        <div style="color: black">Berkas ini telah diverifikasi secara SAH oleh sistem tanggal
                            {{ \Carbon\Carbon::create($file_manager_perubahan_data->created_at)->isoFormat('LL') }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
