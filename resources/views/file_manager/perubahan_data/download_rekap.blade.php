<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Perubahan Dokumen Periode {{ $periode }}</title>
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
                                    <td class="td text-center" style="width: 200px">
                                        <div>
                                            <img src="{{ URL::asset('public/itic/icon_itic.png') }}" alt="logo-small"
                                                class="text-center" width="50">
                                        </div>
                                        <div>
                                            <span style="font-size: 8pt; font-weight: bold">PT Indonesian Tobacco
                                                Tbk.</span>
                                        </div>
                                    </td>
                                    <td colspan="5" rowspan="2" style="width: 500px; font-size: 11pt"
                                        class="td text-center text-bold">REKAP PERUBAHAN DOKUMEN <br> TAHUN {{ $periode }}
                                    </td>
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
                            <div style="margin-top: 1.5%">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="th text-center">No</th>
                                            <th class="th text-center">Tanggal</th>
                                            <th class="th text-center">No. Formulir</th>
                                            <th class="th text-center">Departemen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($file_manager_perubahan_datas as $key => $file_manager_perubahan_data)
                                            <tr>
                                                <td class="td text-center">{{ $key+1 }}</td>
                                                <td class="td text-center">{{ $file_manager_perubahan_data->tanggal_formulir != null ? \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->isoFormat('LL') : '-' }}</td>
                                                <td class="td text-center">{{ $file_manager_perubahan_data->kode_formulir }}</td>
                                                <td class="td text-center">{{ $file_manager_perubahan_data->departemen->departemen }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="td text-center">Data Belum Tersedia</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>