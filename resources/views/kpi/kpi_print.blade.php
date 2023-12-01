<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Dokumen Key Performance Indikator</title>
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
            background-image: url(<?php echo asset('public/stamp/5O74VI6.jpg'); ?>);
            mix-blend-mode: lighten;
        }
    </style>
</head>
<body>
    @foreach ($kpis as $kpi)
    <div class="avoid-break force-break">
        <table>
            <thead>
                <tr>
                    <td>
                        <div class="header-space">
                            <table class="table">
                                <tr>
                                    <td rowspan="2" class="td text-center" style="width: 200px">
                                        <div>
                                            <img src="{{ URL::asset('public/itic/icon_itic.png') }}" alt="logo-small"
                                                class="text-center" width="50">
                                        </div>
                                        <div>
                                            <span style="font-size: 8pt; font-weight: bold">PT Indonesian Tobacco
                                                Tbk.</span>
                                        </div>
                                    </td>
                                    <td style="
                                        width: 480px; 
                                        font-size: 11pt;
                                        font-family: Arial, Helvetica, sans-serif; 
                                        text-align: center; 
                                        font-weight: bold;
                                        border-bottom: 1px solid black
                                        ">
                                        KEY PERFORMANCE INDICATOR
                                    </td>
                                </tr>
                                <tr>
                                    <td style="
                                    text-align: center;
                                    font-family: Arial, Helvetica, sans-serif;
                                    font-weight: bold;
                                    ">Departemen : {{ $kpi->kpi_team->kpi_departemen->departemen }}</td>
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
                            <table>
                                <tr>
                                    <th style="text-align: left">Nama Karyawan</th>
                                    <th style="text-align: left">: {{ $kpi->kpi_team->departemen_user->team }}</th>
                                </tr>
                                <tr>
                                    <th style="text-align: left">Jabatan</th>
                                    <th style="text-align: left">: {{ $kpi->kpi_team->kpi_departemen->departemen }}</th>
                                </tr>
                                <tr>
                                    <th style="text-align: left">Nomor Induk Karyawan</th>
                                    <th style="text-align: left">: {{ $kpi->kpi_team->departemen_user->nik }}</th>
                                </tr>
                                <tr>
                                    <th style="text-align: left">Periode Penilaian</th>
                                    <th style="text-align: left">: {{ \Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY') }}</th>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="th" rowspan="2">No</th>
                                        <th class="th" rowspan="2">Indikator</th>
                                        <th class="th" colspan="2">Target</th>
                                        <th class="th" colspan="2">Realisasi</th>
                                        <th class="th" rowspan="2">(%) Pencapaian</th>
                                        <th class="th" rowspan="2">Bobot</th>
                                        <th class="th" rowspan="2">Nilai</th>
                                        <th class="th" rowspan="2">Skor</th>
                                        <th class="th" rowspan="2">Keterangan</th>
                                    </tr>
                                    <tr>
                                        <th class="th">Nilai</th>
                                        <th class="th">Ket./Satuan</th>
                                        <th class="th">Nilai</th>
                                        <th class="th">Ket./Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_nilai_kpi = [];
                                    @endphp

                                    @foreach ($kpi->kpi_detail as $key_2 => $kpi_detail)
                                        @php
                                            array_push($total_nilai_kpi,$kpi_detail->skor);
                                        @endphp
                                        <tr>
                                            <td class="td text-center">{{ $key_2+1 }}</td>
                                            <td class="td">{{ $kpi_detail->indikator }}</td>
                                            <td class="td text-center">{{ $kpi_detail->target_nilai }}</td>
                                            <td class="td text-center">{{ $kpi_detail->target_keterangan }}</td>
                                            <td class="td text-center">{{ $kpi_detail->realisasi_nilai }}</td>
                                            <td class="td text-center">{{ $kpi_detail->realisasi_keterangan }}</td>
                                            <td class="td text-center">{{ $kpi_detail->pencapaian }}</td>
                                            <td class="td text-center">{{ $kpi_detail->bobot }}%</td>
                                            <td class="td text-center">{{ $kpi_detail->nilai }}</td>
                                            <td class="td text-center">{{ $kpi_detail->skor }}</td>
                                            <td class="td text-center">{{ $kpi_detail->keterangan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <table class="table" style="width: 50%; margin-top: 1%">
                                    <thead>
                                        <tr>
                                            <th class="th" colspan="2">Bobot Nilai</th>
                                            <th class="th">Keterangan</th>
                                            <th class="th">Skala</th>
                                            <th class="th">Prosentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kpi_bobots as $kpi_bobot)
                                        <tr>
                                            <td class="td text-center">{{ $kpi_bobot->bobot_huruf }}</td>
                                            <td class="td text-center">{{ $kpi_bobot->bobot_nilai }}</td>
                                            <td class="td text-center">{{ $kpi_bobot->keterangan }}</td>
                                            <td class="td text-center">{{ $kpi_bobot->skala }}</td>
                                            <td class="td text-center">{{ $kpi_bobot->prosentase }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <table class="table" style="width: 25%; margin-top: 1%; margin-left: 25%">
                                    <tr>
                                        <th class="th text-center">Total Nilai</th>
                                    </tr>
                                    <tr>
                                        <th class="th text-center" style="font-size: 48pt">{{ number_format(array_sum($total_nilai_kpi),2,',','.') }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">
                                            @if (number_format(array_sum($total_nilai_kpi),2,',','.') < '2,00')
                                                BURUK
                                            @elseif(number_format(array_sum($total_nilai_kpi),2,',','.') >= '2,00' && number_format(array_sum($total_nilai_kpi),2,',','.') <= '2,50')
                                                KURANG
                                            @elseif(number_format(array_sum($total_nilai_kpi),2,',','.') >= '2,51' && number_format(array_sum($total_nilai_kpi),2,',','.') <= '3,00')
                                                CUKUP
                                            @elseif(number_format(array_sum($total_nilai_kpi),2,',','.') >= '3,01' && number_format(array_sum($total_nilai_kpi),2,',','.') <= '3,50')
                                                BAIK
                                            @elseif(number_format(array_sum($total_nilai_kpi),2,',','.') >= '3,51' && number_format(array_sum($total_nilai_kpi),2,',','.') <= '4,00')
                                                BAIK SEKALI
                                            @endif
                                        </th>
                                    </tr>
                                </table>
                            </div>
                            <div style="margin-top: 0.5%; margin-bottom: 0.5%;">Catatan: {{ $kpi->remaks == null ? '-' : $kpi->remaks }}</div>
                            @php
                            $mengetahui = [
                                'identifier' => 'Signature: '.$kpi->mengetahui."\n".
                                                'Departemen: '.'Direktur'."\n".
                                                // 'Penilaian Departemen: '.$kpi->kpi_team->departemen_user->departemen->departemen."\n".
                                                // 'Penilaian Jabatan: '.$kpi->kpi_team->jabatan."\n".
                                                'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')."\n".
                                                'Tanggal Dibuat: '.\Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL')
                            ];
                            $penilai = [
                                'identifier' => 'Signature: '.$kpi->penilai."\n".
                                                'Penilaian Departemen: '.$kpi->kpi_team->kpi_departemen->departemen."\n".
                                                // 'Penilaian Jabatan: '.$kpi_supervisor->jabatan."\n".
                                                'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')."\n".
                                                'Tanggal Dibuat: '.\Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL')
                            ];
                            $dinilai = [
                                'identifier' => 'Signature: '.$kpi->yang_dinilai."\n". 
                                                'Penilaian Departemen: '.$kpi->kpi_team->kpi_departemen->departemen."\n".
                                                // 'Penilaian Jabatan: '.$kpi->kpi_team->jabatan."\n".
                                                'Periode Penilaian: '.\Carbon\Carbon::create($kpi->periode)->isoFormat('MMMM YYYY')."\n".
                                                'Tanggal Dibuat: '.\Carbon\Carbon::create($kpi->created_at)->isoFormat('LLL')
                            ];
                            @endphp
                            <table class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td class="td text-center" colspan="3" style="font-weight: bold">Validasi</td>
                                    </tr>
                                    <tr>
                                        <td class="td text-center" style="width: 30%; font-weight: bold">Mengetahui</td>
                                        <td class="td text-center" style="width: 30%; font-weight: bold">Penilai</td>
                                        <td class="td text-center" style="width: 30%; font-weight: bold">Yang Dinilai</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="td text-center">
                                            @if (empty($kpi->status_mengetahui))
                                                <span>Waiting Verification</span>
                                            @else
                                                @php
                                                    $explode_status_mengetahui = explode("|",$kpi->status_mengetahui);
                                                @endphp
                                                @if ($explode_status_mengetahui[0] == null)
                                                    <span>Waiting Verification</span>
                                                @elseif($explode_status_mengetahui[0] == 'y')
                                                    <div style="margin-top: 1%; margin-bottom: 1%">{!! DNS2D::getBarcodeSVG($mengetahui['identifier'], 'QRCODE', 1.5, 1.5) !!}</div>
                                                @elseif($explode_status_mengetahui[0] == 'n')
                                                    <div class="stamp" style="margin-top: 1%; margin-bottom: 1%">REJECTED</div>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="td text-center">
                                            @if (empty($kpi->status_penilai))
                                                <span>Waiting Verification</span>
                                            @else
                                                @php
                                                    $explode_status_penilai = explode("|",$kpi->status_penilai);
                                                @endphp
                                                @if ($explode_status_penilai[0] == null)
                                                    <span>Waiting Verification</span>
                                                @elseif($explode_status_penilai[0] == 'y')
                                                    <div style="margin-top: 1%; margin-bottom: 1%">{!! DNS2D::getBarcodeSVG($penilai['identifier'], 'QRCODE', 1.5, 1.5) !!}</div>
                                                @elseif($explode_status_penilai[0] == 'n')
                                                    <div class="stamp" style="margin-top: 1%; margin-bottom: 1%">REJECTED</div>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="td text-center">
                                            <div style="margin-top: 1%; margin-bottom: 1%">{!! $kpi->yang_dinilai == null ? '-' : DNS2D::getBarcodeSVG($dinilai['identifier'], 'QRCODE', 1.4, 1.4) !!}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td text-center">{{ $kpi->mengetahui }}</td>
                                        <td class="td text-center">{{ $kpi->penilai }}</td>
                                        <td class="td text-center">{{ $kpi->yang_dinilai }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endforeach
</body>
</html>