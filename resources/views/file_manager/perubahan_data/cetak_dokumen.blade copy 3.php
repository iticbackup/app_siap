<!DOCTYPE html>
<html>

<head>
    {{-- <script defer src="https://unpkg.com/pagedjs/dist/paged.polyfill.js"></script> --}}
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

        .page-footer,
        .page-footer-space {
            height: 50px;

        }

        .page-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid black;
            /* for demo */
            background: yellow;
            /* for demo */
        }

        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;
            /* border-bottom: 1px solid black; */
            /* for demo */
            /* background: yellow; */
            /* for demo */
        }

        .page {
            /* page-break-after: always; */
        }

        @page {
            margin: 10mm;
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

    <div class="page-footer">
        <table>
            <tr>
                <td>
                    <div>{!! DNS2D::getBarcodeSVG($file_manager_perubahan_data->kode_formulir, 'QRCODE',1.5,1.5); !!}</div>
                </td>
                <td style="font-size: 8pt">
                    <div>Informasi:</div>
                    <div>Berkas ini telah diverifikasi secara SAH oleh sistem tanggal {{ \Carbon\Carbon::create($file_manager_perubahan_data->created_at)->isoFormat('LL') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <td>
                    <!--place holder for the fixed-position header-->
                    <div class="page-header-space"></div>
                </td>
            </tr>
        </thead>

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
                    <!--*** CONTENT GOES HERE ***-->
                    {{-- <div class="page">PAGE 1</div> --}}
                    {{-- <div class="page" style="line-height: 3">
                        PAGE 3 - Long Content
                        <br />
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc
                        tincidunt metus eu consectetur rutrum. Praesent tempor facilisis
                        dapibus. Aliquam cursus diam ac vehicula pulvinar. Integer lacinia
                        non odio et condimentum. Aenean faucibus cursus mi, sed interdum
                        turpis sagittis a. Quisque quis pellentesque mi. Ut erat eros,
                        posuere sed scelerisque ut, pharetra vitae tellus. Suspendisse
                        ligula sapien, laoreet ac hendrerit sit amet, viverra vel mi.
                        Pellentesque faucibus nisl et dolor pharetra, vel mattis massa
                        venenatis. Integer congue condimentum nisi, sed tincidunt velit
                        tincidunt non. Nulla sagittis sed lorem pretium aliquam. Praesent
                        consectetur volutpat nibh, quis pulvinar est volutpat id. Cras
                        maximus odio posuere suscipit venenatis. Donec rhoncus scelerisque
                        metus, in tempus erat rhoncus sed. Morbi massa sapien, porttitor
                        id urna vel, volutpat blandit velit. Cras sit amet sem eros.
                        Quisque commodo facilisis tristique. Proin pellentesque sodales
                        rutrum. Vestibulum purus neque, congue vel dapibus in, venenatis
                        ut felis. Donec et ligula enim. Sed sapien sapien, tincidunt vitae
                        lectus quis, ultricies rhoncus mi. Nunc dapibus nulla tempus nunc
                        interdum, sed facilisis ex pellentesque. Nunc vel lorem leo. Cras
                        pharetra sodales metus. Cras lacus ex, consequat at consequat vel,
                        laoreet ac dui. Curabitur aliquam, sapien quis congue feugiat,
                        nisi nisl feugiat diam, sed vehicula velit nulla ac nisl. Aliquam
                        quis nisi euismod massa blandit pharetra nec eget nunc. Etiam eros
                        ante, auctor sit amet quam vel, fringilla faucibus leo. Morbi a
                        pulvinar nulla. Praesent sed vulputate nisl. Orci varius natoque
                        penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                        Aenean commodo mollis iaculis. Maecenas consectetur enim vitae
                        mollis venenatis. Ut scelerisque pretium orci id laoreet. In sit
                        amet pharetra diam. Vestibulum in molestie lorem. Nunc gravida,
                        eros non consequat fermentum, ex orci vestibulum orci, non
                        accumsan sem velit ac lectus. Vivamus malesuada lacus nec velit
                        dignissim, ac fermentum nulla pretium. Aenean mi nisi, convallis
                        sed tempor in, porttitor eu libero. Praesent et molestie ante.
                        Duis suscipit vitae purus sit amet aliquam. Vestibulum lectus
                        justo, lobortis a purus a, dapibus efficitur metus. Suspendisse
                        potenti. Duis dictum ex lorem. Suspendisse nec ligula consectetur
                        magna hendrerit ullamcorper et eget mauris. Etiam vestibulum
                        sodales diam, eget venenatis nunc luctus quis. Ut fermentum
                        placerat neque nec elementum. Praesent orci erat, rhoncus vitae
                        est eu, dictum molestie metus. Cras et fermentum elit. Aenean eget
                        augue lacinia, varius ante in, ullamcorper dolor. Cras viverra
                        purus non egestas consectetur. Nulla nec dolor ac lectus convallis
                        aliquet sed a metus. Suspendisse eu imperdiet nunc, id pulvinar
                        risus. Maecenas varius sagittis est, vel fermentum risus accumsan
                        at. Vestibulum sollicitudin dui pharetra sapien volutpat, id
                        convallis mi vestibulum. Phasellus commodo sit amet lorem quis
                        imperdiet. Proin nec diam sed urna euismod ultricies at sed urna.
                        Quisque ornare, nulla et vehicula ultrices, massa purus vehicula
                        urna, ac sodales lacus leo vitae mi. Sed congue placerat justo at
                        placerat. Aenean suscipit fringilla vehicula. Quisque iaculis orci
                        vitae arcu commodo maximus. Maecenas nec nunc rutrum, cursus elit
                        quis, porttitor sapien. Sed ac hendrerit ipsum, lacinia fringilla
                        velit. Donec ultricies feugiat dictum.
                    </div> --}}
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
    <script>
        // window.print();
        // window.onfocus=function(){ window.close();}
    </script>
</body>

</html>
