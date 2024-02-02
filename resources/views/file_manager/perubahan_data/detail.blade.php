@extends('layouts.apps.master')
@section('title')
    Detail Perubahan Dokumen
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
            background-image: url(<?php echo asset('public/stamp/5O74VI6.jpg'); ?>);
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <h4 class="card-title text-white text-center" style="font-size: 14pt">Detail Perubahan Dokumen</h4>
                    <div class="text-white text-center">No. Dokumen: {{ $file_manager_perubahan_data->kode_formulir }}</div>
                </div>
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
                                <th class="text-center" style="background-color: #AAD9BB">Uraian Perubahan</th>
                                <th class="text-center" style="background-color: #AAD9BB">Disahkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($file_manager_perubahan_data_details as $file_manager_perubahan_data_detail)
                                <tr>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::create($file_manager_perubahan_data->tanggal_formulir)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">{{ $file_manager_perubahan_data_detail->no_dokumen }}</td>
                                    <td class="text-center">{{ $file_manager_perubahan_data_detail->halaman }}</td>
                                    <td class="text-center">{{ $file_manager_perubahan_data_detail->revisi }}</td>
                                    <td style="width: 500px; word-break: break-all;">{!! $file_manager_perubahan_data_detail->uraian_perubahan !!}</td>
                                    <td class="text-center">
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
                            {{-- @if ($file_manager_perubahan_data->represtative_signature == null)
                            <div style="margin-top: 9.4%; margin-bottom: 9.4%;">-</div>
                            @else
                            <div style="margin-top: 2.5%; margin-bottom: 2.5%">{!! DNS2D::getBarcodeSVG($detail_pengajuan['identifier'], 'QRCODE', 2, 2) !!}</div>
                            @endif --}}

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
                                <td colspan="2">
                                    {{-- @if ($explode_validasi[2] == 'y')
                                    <div class="alert alert-success" role="alert">
                                        <strong><i class="mdi mdi-check"></i> Approved</strong> Formulir ini telah disetujui.
                                    </div>
                                    @elseif ($explode_validasi[2] == 'n')
                                    <div class="alert alert-danger" role="alert">
                                        <strong><i class="far fa-times-circle"></i> Rejected</strong> {!! $file_manager_perubahan_data->remaks !!}
                                    </div>
                                    <p>{!! $file_manager_perubahan_data->remaks !!}</p>
                                    @endif --}}
                                    @if (!empty($file_manager_perubahan_data->status))
                                        @if ($explode_validasi[2] == 'y')
                                        <div class="alert alert-success" role="alert">
                                            <strong><i class="mdi mdi-check"></i> Approved</strong> Formulir telah disetujui.
                                        </div>
                                        @elseif ($explode_validasi[2] == 'n')
                                        <div class="alert alert-danger" role="alert">
                                            <strong><i class="far fa-times-circle"></i> Rejected</strong> {!! $file_manager_perubahan_data->remaks !!}
                                        </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
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

                    <div class="mt-3">
                        <a href="{{ route('perubahan_data') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                            Back</a>
                        @if (!empty($file_manager_perubahan_data->status))
                            @if ($explode_validasi[0] == 'y' && $explode_validasi[2] == 'y')
                            <a href="{{ route('perubahan_data.cetak_dokumen', ['id' => $file_manager_perubahan_data->id]) }}"
                                class="btn btn-primary"><i class="fas fa-print"></i> Cetak Dokumen</a>
                            @endif
                        @endif
                        @if (auth()->user()->nik == 1207514 || 
                            auth()->user()->nik == 1711952 || 
                            auth()->user()->nik == 0000000 || 
                            auth()->user()->nik == 0000010 || 
                            auth()->user()->nik == 2007275 ||
                            auth()->user()->nik == 2207603
                            )
                            @if (empty($file_manager_perubahan_data->status))
                            <a href="{{ route('perubahan_data.cek_validasi', ['id' => $file_manager_perubahan_data->id]) }}"
                                class="btn btn-primary"><i class="far fa-edit"></i> Go Verification</a>
                            {{-- <a href="{{ url()->previous() }}"
                                class="btn btn-primary"><i class="far fa-edit"></i> Go Verification</a> --}}
                            @elseif($explode_validasi[0] == 'y' && $explode_validasi[2] == null)
                            <a href="{{ route('perubahan_data.cek_validasi', ['id' => $file_manager_perubahan_data->id]) }}"
                                class="btn btn-primary"><i class="far fa-edit"></i> Go Verification</a>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <b>Catatan:</b> Formulir Perubahan Dokumen tidak bisa dicetak jika status validasi belum disetujui.
                </div>
            </div>
        </div>
    </div>
@endsection
