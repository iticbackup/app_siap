<style>
    *{
        font-family: Arial, Helvetica, sans-serif
    }
    table,
    td,
    th {
        border: 1px solid;
    }

    table {
        border-collapse: collapse;
    }

</style>
<title>Rekap Pelatihan Peserta - {{ $rekap_pelatihan->tema }}</title>
@php
    $mengetahui = 'Zonnete Bryllian Dheo';
@endphp
@foreach ($rekap_pelatihan->rekap_pelatihan_seminar_peserta as $peserta)

{{-- Page 1 --}}
<div style="
page-break-after: always;
">

<table style="width: 100%; margin-bottom: 1%">
    <tr>
        <td rowspan="4" style="text-align: center; font-size: 9pt; width: 25%">
            <img src="{{ asset('public/logo/logo_itic.png') }}" width="35">
            <div style="font-size: 8pt">PT Indonesian Tobacco Tbk.</div>
        </td>
        <td rowspan="2" style="text-align: center; width: 50%; font-weight: bold; font-size: 11pt;">Formulir</td>
        <td style="font-size: 9pt; width: 9%; border-right: 0px">Nomor</td>
        <td style="font-size: 9pt; width: 1%; border-left: 0px; border-right: 0px">:</td>
        <td style="font-size: 9pt; width: 15%; border-left: 0px">IT/HRGA/FR/18</td>
    </tr>
    <tr>
        <td style="font-size: 9pt; width: 9%; border-right: 0px">Revisi</td>
        <td style="font-size: 9pt; width: 1%; border-left: 0px; border-right: 0px">:</td>
        <td style="font-size: 9pt; width: 15%; border-left: 0px">3</td>
    </tr>
    <tr>
        <td rowspan="2" style="text-align: center; width: 50%; font-weight: bold; font-size: 11pt;">Evaluasi Pelatihan</td>
        <td style="font-size: 9pt; width: 9%; border-right: 0px">Halaman</td>
        <td style="font-size: 9pt; width: 1%; border-left: 0px; border-right: 0px">:</td>
        <td style="font-size: 9pt; width: 15%; border-left: 0px">1</td>
    </tr>
    <tr>
        <td style="font-size: 9pt; width: 9%; border-right: 0px">Tanggal</td>
        <td style="font-size: 9pt; width: 1%; border-left: 0px; border-right: 0px">:</td>
        <td style="font-size: 9pt; width: 15%; border-left: 0px">31/01/2020</td>
    </tr>
</table>

@php
    $explode_tanggal = explode(',',$rekap_pelatihan->tanggal);
    
    if (\Carbon\Carbon::create($explode_tanggal[0])->format('Y-m-d') == \Carbon\Carbon::create($explode_tanggal[1])->format('Y-m-d')) {
        $tanggal = \Carbon\Carbon::create($explode_tanggal[1])->isoFormat('DD MMMM YYYY');
    }else{
        $tanggal = \Carbon\Carbon::create($explode_tanggal[0])->isoFormat('DD MMMM').' - '.\Carbon\Carbon::create($explode_tanggal[1])->isoFormat('DD MMMM YYYY');
    }
@endphp

<table style="width: 100%; font-size: 10pt; margin-bottom: 1%">
    <tr>
        <td style="width: 15%; text-align: center; font-size: 9pt; font-weight: bold">Topik Pelatihan : </td>
        <td style="width: 35%; padding-left: 2.5%; font-size: 8pt;">{{ $rekap_pelatihan->tema }}</td>
        <td style="width: 15%; text-align: center; font-size: 9pt; font-weight: bold">Nama Trainer : </td>
        <td style="width: 35%; padding-left: 2.5%; font-size: 8pt;">{{ $rekap_pelatihan->penyelenggara }}</td>
    </tr>
    <tr>
        <td style="width: 15%; text-align: center; font-size: 9pt; font-weight: bold">Tanggal : </td>
        <td style="width: 35%; padding-left: 2.5%; font-size: 8pt;">{{ $tanggal }}</td>
        <td style="width: 15%; text-align: center; font-size: 9pt; font-weight: bold">Jumlah Hari <br> / Jam : </td>
        <td style="width: 35%; padding-left: 2.5%; font-size: 8pt;">{{ $rekap_pelatihan->jml_hari.' Hari / '.$rekap_pelatihan->jml_jam_dlm_hari.' Jam' }}</td>
    </tr>
</table>

<p style="font-size: 9pt">Tujuan dari formulir ini guna melibatkan peserta training untuk memberikan umpan balik supaya:</p>
<ol style="font-size: 9pt">
    <li>Kualitas dan isi pelatihan bisa dipantau agar bisa ditingkatkan lagi</li>
    <li>Kualitas dari trainer bisa dinilai</li>
    <li>Keefektifan program pelatihan bisa dievaluasi</li>
    <li>Proses pembelajaran bisa di tingkatkan</li>
</ol>
<p style="font-size: 9pt">Tolong berikan pendapat anda pada masing-masing pernyataan dengan tanda "<img src="{{ asset('public/icon/check.png') }}" width="15" />"</p>

<table style="width: 100%; font-size: 9pt; margin-bottom: 1%">
    <tr>
        <td colspan="3" rowspan="2" style="width: 50%; text-align: center; font-weight: bold">Pernyataan</td>
        <td style="width: 10%; text-align: center; font-weight: bold">Sangat Tidak Setuju</td>
        <td style="width: 10%; text-align: center; font-weight: bold">Tidak Setuju</td>
        <td style="width: 10%; text-align: center; font-weight: bold">Netral</td>
        <td style="width: 10%; text-align: center; font-weight: bold">Setuju</td>
        <td style="width: 10%; text-align: center; font-weight: bold">Sangat Setuju</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold">1</td>
        <td style="text-align: center; font-weight: bold">2</td>
        <td style="text-align: center; font-weight: bold">3</td>
        <td style="text-align: center; font-weight: bold">4</td>
        <td style="text-align: center; font-weight: bold">5</td>
    </tr>
    @php
        $pertanyaans = [
            [
                'no' => 1,
                'pertanyaan' => 'Tujuan dan atau sasaran saya mengikuti pelatihan terpenuhi'
            ],
            [
                'no' => 2,
                'pertanyaan' => 'Materi pelatihan sesuai dengan tujuan dan atau sasaran pelatihan'
            ],
            [
                'no' => 3,
                'pertanyaan' => 'Materi pelatihan dapat diterapkan di tempat kerja saya saat ini'
            ],
            [
                'no' => 4,
                'pertanyaan' => 'Materi dan atau pelatihan ini dapat dimengerti'
            ],
            [
                'no' => 5,
                'pertanyaan' => 'Materi pelatihan spesifik dan terfokus'
            ],
            [
                'no' => 6,
                'pertanyaan' => 'Materi dan atau pelatihan ini dapat menambah wawasan serta menambah/meningkatkan kemampuan dan ketrampilan'
            ],
            [
                'no' => 7,
                'pertanyaan' => 'Pemaparan trainer saat training berlangsung dilakukan dengan jelas dan dapat dimengerti'
            ],
            [
                'no' => 8,
                'pertanyaan' => 'Trainer menggunakan berbagai methode pembelajaran'
            ],
            [
                'no' => 9,
                'pertanyaan' => 'Trainer banyak mengetahui tentang materi pelatihan'
            ],
            [
                'no' => 10,
                'pertanyaan' => 'Administrasi pelatihan efektif & efisien'
            ],
            [
                'no' => 11,
                'pertanyaan' => 'Mengikuti pelatihan sangat bermanfaat'
            ],
            [
                'no' => 12,
                'pertanyaan' => 'Saya merekomendasikan pelatihan ini agar dilakukan ke staff / pimpinan lainnya yang memerlukan pengetahuan dan pengembangan pada area / tempat kerjanya'
            ],
            [
                'no' => 13,
                'pertanyaan' => ''
            ],
            [
                'no' => 14,
                'pertanyaan' => 'Apa rencana yang akan anda lakukan di tempat kerja sebagai hasil dari mengikuti pelatihan ini?'
            ],
            [
                'no' => 15,
                'pertanyaan' => 'Apa komentar / pendapat anda tentang pelatihan ini'
            ],
        ];
    @endphp
    @foreach ($pertanyaans as $item)
    @if ($item['no'] <= 12)
        <tr>
            <td style="width: 5%; text-align: center">{{ $item['no'] }}</td>
            <td colspan="2" style="width: 35%; padding-left: 2.5%">{{ $item['pertanyaan'] }}</td>
            <td style="width: 10%; text-align: center"></td>
            <td style="width: 10%; text-align: center"></td>
            <td style="width: 10%; text-align: center"></td>
            <td style="width: 10%; text-align: center"></td>
            <td style="width: 10%; text-align: center"></td>
        </tr>
    @else
        @if ($item['no'] == 13)
        <tr>
            <td style="width: 5%; text-align: center">13</td>
            <td style="width: 20%; padding-left: 2.5%; border-right: 0px solid white">Durasi pelatihan</td>
            <td style="width: 25%; border-left: 0px solid white">
                <ol>
                    <li>Terlalu singkat</li>
                    <li>Sesuai / tepat</li>
                    <li>Terlalu lama</li>
                </ol>
            </td>
            <td colspan="5"></td>
        </tr>
        @else
        <tr>
            <td style="width: 5%; text-align: center">{{ $item['no'] }}</td>
            <td colspan="2" style="width: 35%; padding-left: 2.5%">{{ $item['pertanyaan'] }}</td>
            <td colspan="5"></td>
        </tr>
        @endif
    @endif
    @endforeach
</table>

<div style="font-size: 9pt; text-align: right">Peserta Pelatihan</div>
<div style="font-size: 9pt; text-align: right; text-decoration: underline; font-weight: bold; margin-top: 8%">{{ $peserta->peserta }}</div>
</div>

{{-- End Page 1 --}}

{{-- Page 2 --}}
<div style="
page-break-after: always;
">
<table style="width: 100%; margin-bottom: 1%">
    <tr>
        <td rowspan="4" style="text-align: center; font-size: 9pt; width: 25%">
            <img src="{{ asset('public/logo/logo_itic.png') }}" width="35">
            <div style="font-size: 8pt">PT Indonesian Tobacco Tbk.</div>
        </td>
        <td rowspan="2" style="text-align: center; width: 50%; font-weight: bold; font-size: 11pt;">Formulir</td>
        <td style="font-size: 9pt; width: 9%; border-right: 0px">Nomor</td>
        <td style="font-size: 9pt; width: 1%; border-left: 0px; border-right: 0px">:</td>
        <td style="font-size: 9pt; width: 15%; border-left: 0px">IT/HRGA/FR/18</td>
    </tr>
    <tr>
        <td style="font-size: 9pt; width: 9%; border-right: 0px">Revisi</td>
        <td style="font-size: 9pt; width: 1%; border-left: 0px; border-right: 0px">:</td>
        <td style="font-size: 9pt; width: 15%; border-left: 0px">3</td>
    </tr>
    <tr>
        <td rowspan="2" style="text-align: center; width: 50%; font-weight: bold; font-size: 11pt;">Evaluasi Pelatihan</td>
        <td style="font-size: 9pt; width: 9%; border-right: 0px">Halaman</td>
        <td style="font-size: 9pt; width: 1%; border-left: 0px; border-right: 0px">:</td>
        <td style="font-size: 9pt; width: 15%; border-left: 0px">2</td>
    </tr>
    <tr>
        <td style="font-size: 9pt; width: 9%; border-right: 0px">Tanggal</td>
        <td style="font-size: 9pt; width: 1%; border-left: 0px; border-right: 0px">:</td>
        <td style="font-size: 9pt; width: 15%; border-left: 0px">31/01/2020</td>
    </tr>
</table>

<table style="width: 100%; margin-bottom: 1%; border:0px; font-size: 9pt">
    <tr>
        <td style="border:0px; width: 20%">NIK</td>
        <td style="border:0px; width: 1%">:</td>
        <td style="border:0px;">{{ $peserta->hrga_karyawan->nik }}</td>
    </tr>
    <tr>
        <td style="border:0px; width: 20%">Nama</td>
        <td style="border:0px; width: 1%">:</td>
        <td style="border:0px;">{{ $peserta->peserta }}</td>
    </tr>
    <tr>
        <td style="border:0px; width: 20%">Departemen</td>
        <td style="border:0px; width: 1%">:</td>
        <td style="border:0px;">{{ $peserta->departemen->departemen }}</td>
    </tr>
    <tr>
        <td style="border:0px; width: 20%">Training / Seminar</td>
        <td style="border:0px; width: 1%">:</td>
        <td style="border:0px;">
            <div style="word-wrap: break-word;">{{ $rekap_pelatihan->tema }}</div>
        </td>
    </tr>
    <tr>
        <td style="border:0px; width: 20%; vertical-align: top">Periode Evaluasi</td>
        <td style="border:0px; width: 1%; vertical-align: top">:</td>
        <td style="border:0px;">
            <table style="border: 0px">
                <tr>
                    <td style="border: 0px;">
                        <div style="border: 2px solid black;">&nbsp; a. &nbsp;</div>
                    </td>
                    <td style="border: 0px">1 bulan setelah training &nbsp;</td>
                    <td style="border: 0px">
                        <div style="border: 2px solid black;">&nbsp; c. &nbsp;</div>
                    </td>
                    <td style="border: 0px">6 bulan setelah training &nbsp;</td>
                </tr>
                <tr>
                    <td style="border: 0px">
                        <div style="border: 2px solid black;">&nbsp; b. &nbsp;</div>
                    </td>
                    <td style="border: 0px">3 bulan setelah training &nbsp;</td>
                    <td style="border: 0px">
                        <div style="border: 2px solid black;">&nbsp; d. &nbsp;</div>
                    </td>
                    <td style="border: 0px">12 bulan setelah training &nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div style="margin-bottom: 1%; font-size: 9pt;">
    <div style="font-weight: bold; margin-bottom: 1%">A. Tabel Evaluasi</div>
    <table style="width: 100%; margin-bottom: 1%">
        <tr>
            <td rowspan="3" style="font-weight: bold; text-align: center; width: 1%">No.</td>
            <td rowspan="3" style="font-weight: bold; text-align: center">Parameter Penilaian</td>
            <td colspan="6" style="font-weight: bold; text-align: center">Hasil Evaluasi</td>
            <td rowspan="3" style="font-weight: bold; text-align: center; width: 10%">Nilai</td>
            <td rowspan="3" style="font-weight: bold; text-align: center">Kesimpulan / Komentar</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold; text-align: center">Trainer</td>
            <td colspan="3" style="font-weight: bold; text-align: center">Atasan Terkait</td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: center; width: 5%">B</td>
            <td style="font-weight: bold; text-align: center; width: 5%">C</td>
            <td style="font-weight: bold; text-align: center; width: 5%">K</td>
            <td style="font-weight: bold; text-align: center; width: 5%">B</td>
            <td style="font-weight: bold; text-align: center; width: 5%">C</td>
            <td style="font-weight: bold; text-align: center; width: 5%">K</td>
        </tr>
        <tr>
            <td style="text-align: center">1.</td>
            <td>Peserta memahami materi training/ Nilai Tes Tulis</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td rowspan="6"></td>
            <td rowspan="6"></td>
        </tr>
        <tr>
            <td style="text-align: center">2.</td>
            <td>Peserta mampu menerapkan materi training/ Nilai Praktik</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center">3.</td>
            <td>Peserta bekerja sesuai dengan SOP yang berlaku</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center">4.</td>
            <td>Kualitas Pekerjaan meningkat, peserta bertanggung jawab terhadap pekerjaannya</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center">5.</td>
            <td>Peserta mampu berkomunikasi dan berkoordinasi dengan baik dalam pekerjaannya.</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold; text-align: center">Total Skor</td>
            <td colspan="3"></td>
            <td colspan="3"></td>
        </tr>
    </table>
    <div style="font-weight: bold; margin-bottom: 1%">B. Petunjuk Pengisian</div>
    <div>Berilah tanda (X) pada kolom yang sesuai.</div>
    <ol>
        <li>
            <span>B</span>
            <span>: Baik, Skor 3</span>
        </li>
        <li>
            <span>C</span>
            <span>: Cukup, Skor 2</span>
        </li>
        <li>
            <span>K</span>
            <span>: Kurang, Skor 1</span>
        </li>
    </ol>
    <div>Cara Perhitungan Nilai : Skor Trainer + Skor Atasan Terkait</div>
    <ol>
        <li>
            <span>A</span>
            <span>: 25 - 30 (Lolos evaluasi)</span>
        </li>
        <li>
            <span>B</span>
            <span>: 20 - 24 (Lolos evaluasi)</span>
        </li>
        <li>
            <span>C</span>
            <span>: < 20 (Tidak Lolos evaluasi dan harus mengikuti pelatihan berikutnya)</span>
        </li>
    </ol>
</div>

<table style="width: 70%; font-size: 9pt; border:0px; margin-top: 5%">
    <tr>
        <td style="border:0px; padding-bottom: 15%">Dibuat oleh,</td>
        <td style="border:0px;">Mengetahui,</td>
    </tr>
    <tr>
        <td style="border:0px; text-decoration: underline">{{ auth()->user()->name }}</td>
        <td style="border:0px; text-decoration: underline">{{ $mengetahui }}</td>
    </tr>
    <tr>
        <td style="border:0px; font-weight: bold">Dept. HRGA</td>
        <td style="border:0px; font-weight: bold">Manager / PIC Dept.</td>
    </tr>
</table>
</div>

{{-- End Page 2 --}}

@endforeach