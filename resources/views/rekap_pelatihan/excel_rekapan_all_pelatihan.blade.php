<table>
    <thead>
        <tr>
            <td colspan="14" style="text-align: center; font-weight: bold; height: 50px; vertical-align: middle">Rekap Seminar dan Pelatihan PT Indonesian Tobacco Tbk. All Departemen <br> Periode Tahun {{ $periode }}</td>
        </tr>
        <tr>
            <td></td>
            @foreach ($departemens as $departemen)
            <td style="word-wrap: break-word; height: 80px; background-color: #bdcade; font-weight: bold; border: 1px solid black; vertical-align: middle; text-align: center">{{ $departemen->departemen }}</td>
            @endforeach
            <td style="word-wrap: break-word; height: 80px; background-color: #CEDEBD; font-weight: bold; border: 1px solid black; vertical-align: middle; text-align: center">Grand Total</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="background-color: #bdcade; height: 80px; border: 1px solid black; text-align: center; font-weight: bold;">Staff</td>
            @foreach ($departemens as $departemen)
            @php
                $total_rekap_pelatihan_staff = [];
            @endphp
            <td style="height: 80px; border: 1px solid black; text-align: center;">
                @php
                    $rekap_pelatihan_staffs = \DB::select(\DB::raw(
                                                'select rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id,rekap_pelatihan_seminar_peserta.departemen_id, count(rekap_pelatihan_seminar_peserta.departemen_id) as jumlah_peserta, 
                                                count(rekap_pelatihan_seminar_peserta.departemen_id)/count(rekap_pelatihan_seminar_peserta.departemen_id) as nilai 
                                                from rekap_pelatihan_seminar_peserta 
                                                left join rekap_pelatihan_seminar
                                                on rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id = rekap_pelatihan_Seminar.id
                                                left join departemen_user
                                                on departemen_user.team = rekap_pelatihan_seminar_peserta.peserta
                                                where rekap_pelatihan_seminar_peserta.departemen_id = '.$departemen->id.'
                                                and departemen_user.staff = "y"
                                                GROUP BY rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id',
                                        ));
                foreach ($rekap_pelatihan_staffs as $rekap_pelatihan_staff) {
                    array_push($total_rekap_pelatihan_staff,$rekap_pelatihan_staff->nilai);
                }
                @endphp
                {{ array_sum($total_rekap_pelatihan_staff) }}
            </td>
            @endforeach
        </tr>
        <tr>
            <td style="background-color: #eeff35; height: 80px; border: 1px solid black; text-align: center; font-weight: bold;">Non Staff</td>
            @foreach ($departemens as $departemen)
            @php
                $total_rekap_pelatihan_nonstaff = [];
            @endphp
            <td style="height: 80px; border: 1px solid black; text-align: center;">
                @php
                    $rekap_pelatihan_nonstaffs = \DB::select(\DB::raw(
                                                'select rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id,rekap_pelatihan_seminar_peserta.departemen_id, count(rekap_pelatihan_seminar_peserta.departemen_id) as jumlah_peserta, 
                                                count(rekap_pelatihan_seminar_peserta.departemen_id)/count(rekap_pelatihan_seminar_peserta.departemen_id) as nilai 
                                                from rekap_pelatihan_seminar_peserta 
                                                left join rekap_pelatihan_seminar
                                                on rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id = rekap_pelatihan_Seminar.id
                                                left join departemen_user
                                                on departemen_user.team = rekap_pelatihan_seminar_peserta.peserta
                                                where rekap_pelatihan_seminar_peserta.departemen_id = '.$departemen->id.'
                                                and departemen_user.staff = "n"
                                                GROUP BY rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id',
                                        ));
                foreach ($rekap_pelatihan_nonstaffs as $rekap_pelatihan_nonstaff) {
                    array_push($total_rekap_pelatihan_nonstaff,$rekap_pelatihan_nonstaff->nilai);
                }
                @endphp
                {{ array_sum($total_rekap_pelatihan_nonstaff) }}
            </td>
            @endforeach
        </tr>
    </tbody>
</table>