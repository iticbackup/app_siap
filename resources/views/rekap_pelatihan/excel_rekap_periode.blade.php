<table>
    <thead>
        <tr>
            <td colspan="2" style="font-weight: bold; text-align: center; height: 50px; vertical-align: middle">Total Rekap Seminar dan Pelatihan PT Indonesian Tobacco Tbk. <br> Periode Tahun {{ $periode }}</td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black; font-weight: bold; background-color: #B0D9B1; height: 30px; vertical-align: middle">Bulan</td>
            <td style="text-align: center; border: 1px solid black; font-weight: bold; background-color: #B0D9B1; height: 30px; vertical-align: middle">Total Pelatihan</td>
        </tr>
    </thead>
    <tbody>
        @php
            $total_all_rekap = [];
        @endphp
        @for ($i = $start_month; $i <= $end_month; $i++)
        @php
            $total_month_rekap = \App\Models\RekapPelatihanSeminar::whereMonth('created_at',$i)->whereYear('created_at',$periode)->count();
            array_push($total_all_rekap,$total_month_rekap);
        @endphp
        <tr>
            <td style="text-align: center; border: 1px solid black; width: 250px">
                @php
                    switch ($i) {
                        case "1":
                            echo "Januari";
                            break;
                        case "2":
                            echo "Februari";
                            break;
                        case "3":
                            echo "Maret";
                            break;
                        case "4":
                            echo "April";
                            break;
                        case "5":
                            echo "Mei";
                            break;
                        case "6":
                            echo "Juni";
                            break;
                        case "7":
                            echo "Juli";
                            break;
                        case "8":
                            echo "Agustus";
                            break;
                        case "9":
                            echo "September";
                            break;
                        case "10":
                            echo "Oktober";
                            break;
                        case "11":
                            echo "November";
                            break;
                        case "12":
                            echo "Desember";
                            break;
                        default;
                    }
                @endphp
            </td>
            <td style="text-align: center; border: 1px solid black; width: 250px">{{ $total_month_rekap }}</td>
        </tr>
        @endfor
        <tr>
            <td style="text-align: center; border: 1px solid black; font-weight: bold;">Total</td>
            <td style="text-align: center; border: 1px solid black; font-weight: bold;">{{ array_sum($total_all_rekap) }}</td>
        </tr>
    </tbody>
</table>