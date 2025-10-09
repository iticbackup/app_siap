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
    @php
        $total_all_jumlah_pelatihan = [];
        $total_all_peserta_pelatihan = [];
        $total_all_waktu_pelatihan = [];
        $total_all_staff_pelatihan = [];
        $total_all_nonstaff_pelatihan = [];
        $total_all_laki_laki = [];
        $total_all_perempuan = [];
    @endphp
    <tbody>
        <tr>
            <td style="border: 1px solid black;">Jumlah Pelatihan</td>
            @foreach ($departemens as $departemen)
            @php
                $total_rekap_pelatihan = [];
                // dd($departemen->departemen_user->team);
            @endphp
            <td style="text-align: center; border: 1px solid black;">
                @php
                    $rekap_pelatihans = \DB::select(\DB::raw(
                                                'select rekap_pelatihan_seminar_id,departemen_id, count(departemen_id) as jumlah_peserta, 
                                                count(departemen_id)/count(departemen_id) as nilai 
                                                from rekap_pelatihan_seminar_peserta 
                                                left join rekap_pelatihan_seminar
                                                on rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id = rekap_pelatihan_seminar.id
                                                where departemen_id='.$departemen->id.' 
                                                and rekap_pelatihan_seminar.periode='.$periode.'
                                                group by rekap_pelatihan_seminar_id',
                                        ));
                    // $rekap_pelatihans = \DB::select(\DB::raw(
                    //                             'select rekap_pelatihan_seminar_id,departemen_id, count(departemen_id) as jumlah_peserta, 
                    //                             count(departemen_id)/count(departemen_id) as nilai 
                    //                             from rekap_pelatihan_seminar_peserta 
                    //                             left join rekap_pelatihan_seminar
                    //                             on rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id = rekap_pelatihan_seminar.id
                    //                             where rekap_pelatihan_seminar_peserta.departemen_id='.$departemen->id.' 
                    //                             and rekap_pelatihan_seminar.periode='.$periode.'
                    //                             group by rekap_pelatihan_seminar_id',
                    //                     ));
                    foreach ($rekap_pelatihans as $rekap_pelatihan) {
                        array_push($total_rekap_pelatihan,$rekap_pelatihan->nilai);
                    }
                    array_push($total_all_jumlah_pelatihan,array_sum($total_rekap_pelatihan));
                @endphp
                {{ array_sum($total_rekap_pelatihan) }}
            </td>
            @endforeach
            <td style="text-align: center; border: 1px solid black;">{{ array_sum($total_all_jumlah_pelatihan) }}</td>
        </tr>

        <tr>
            <td style="border: 1px solid black;">Jumlah Peserta Pelatihan</td>
            @foreach ($departemens as $departemen)
            @php
                $total_peserta_pelatihan = [];
            @endphp
            <td style="text-align: center; border: 1px solid black;">
                @foreach ($departemen->departemen_user_all as $departemen_user_all)
                @php
                // $rekap = \App\Models\RekapPelatihanSeminarPeserta::leftJoin('rekap_pelatihan_seminar','rekap_pelatihan_seminar.id','=','rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id')
                //                                     ->where('rekap_pelatihan_seminar_peserta.peserta',$departemen_user_all->team)
                //                                     // ->where('rekap_pelatihan_seminar_peserta.departemen_id',$departemen_user_all->departemen_id)
                //                                     ->where('rekap_pelatihan_seminar.periode',$periode)
                //                                     ->get();
                $rekap = \App\Models\RekapPelatihanSeminarPeserta::leftJoin('rekap_pelatihan_seminar','rekap_pelatihan_seminar.id','=','rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id')
                                                    ->where('rekap_pelatihan_seminar_peserta.peserta',$departemen_user_all->team)
                                                    // ->where('rekap_pelatihan_seminar_peserta.departemen_id',$departemen_user_all->departemen_id)
                                                    ->where('rekap_pelatihan_seminar.periode',$periode)
                                                    ->get();
                $simpan_rekap = json_encode($rekap->count());
                array_push($total_peserta_pelatihan,$simpan_rekap);
                @endphp
                @endforeach
                @php
                    array_push($total_all_peserta_pelatihan,array_sum($total_peserta_pelatihan))
                @endphp
                {{ array_sum($total_peserta_pelatihan) }}
            </td>
            @endforeach
            <td style="text-align: center; border: 1px solid black;">{{ array_sum($total_all_peserta_pelatihan) }}</td>
        </tr>

        <tr>
            <td style="border: 1px solid black;">Total Waktu Pelatihan (Jam)</td>
            @foreach ($departemens as $departemen)
            @php
                $total_waktu_pelatihan = [];
            @endphp
            <td style="text-align: center; border: 1px solid black;">
                @php
                    $rekap_waktu_pelatihans = \DB::select(\DB::raw(
                        'select rekap_pelatihan_seminar_id,departemen_id, 
                        count(departemen_id) as jumlah_peserta, 
                        jml_jam_dlm_hari, 
                        count(departemen_id)/count(departemen_id) as jml_pelatihan,
                        count(departemen_id) * jml_jam_dlm_hari * jml_hari as jml_jam
                        from rekap_pelatihan_seminar_peserta 
                        left join rekap_pelatihan_seminar
                        on rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id = rekap_pelatihan_Seminar.id
                        where departemen_id='.$departemen->id.' and rekap_pelatihan_seminar.periode='.$periode.' group by rekap_pelatihan_seminar_id'
                    ));

                    foreach ($rekap_waktu_pelatihans as $rekap_waktu_pelatihan) {
                        array_push($total_waktu_pelatihan,$rekap_waktu_pelatihan->jml_jam);
                    }
                @endphp
                @php
                    array_push($total_all_waktu_pelatihan,array_sum($total_waktu_pelatihan))
                @endphp
                {{ array_sum($total_waktu_pelatihan) }}
            </td>
            @endforeach
            <td style="text-align: center; border: 1px solid black;">{{ array_sum($total_all_waktu_pelatihan) }}</td>
        </tr>

        <tr>
            <td style="background-color: #35ff86; border: 1px solid black;">Staff</td>
            @foreach ($departemens as $departemen)
            @php
                $total_rekap_pelatihan_staff = [];
            @endphp
            <td style="text-align: center; background-color: #35ff86; border: 1px solid black;">
                {{-- @php
                    $rekap_pelatihan_staffs = \DB::select(\DB::raw(
                                                'select rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id,rekap_pelatihan_seminar_peserta.departemen_id, count(rekap_pelatihan_seminar_peserta.departemen_id) as jumlah_peserta, 
                                                count(rekap_pelatihan_seminar_peserta.departemen_id)/count(rekap_pelatihan_seminar_peserta.departemen_id) as nilai 
                                                from rekap_pelatihan_seminar_peserta 
                                                left join rekap_pelatihan_seminar
                                                on rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id = rekap_pelatihan_seminar.id
                                                left join departemen_user
                                                on departemen_user.team = rekap_pelatihan_seminar_peserta.peserta
                                                where rekap_pelatihan_seminar_peserta.departemen_id = '.$departemen->id.'
                                                and departemen_user.staff = "y"
                                                and rekap_pelatihan_seminar.periode = '.$periode.'
                                                GROUP BY rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id',
                                        ));
                foreach ($rekap_pelatihan_staffs as $rekap_pelatihan_staff) {
                    array_push($total_rekap_pelatihan_staff,$rekap_pelatihan_staff->nilai);
                }
                @endphp
                @php
                    array_push($total_all_staff_pelatihan,array_sum($total_rekap_pelatihan_staff))
                @endphp
                {{ array_sum($total_rekap_pelatihan_staff) }} --}}
                @foreach ($departemen->departemen_user_all as $departemen_user_all)
                @php
                    $rekap_staff = \App\Models\RekapPelatihanSeminarPeserta::leftJoin('rekap_pelatihan_Seminar','rekap_pelatihan_Seminar.id','=','rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id')
                                                    ->leftJoin('departemen_user','departemen_user.team','=','rekap_pelatihan_seminar_peserta.peserta')
                                                    // ->leftJoin('departemen_user','departemen_user.team','=','rekap_pelatihan_seminar_peserta.peserta')
                                                    ->where('rekap_pelatihan_seminar_peserta.peserta',$departemen_user_all->team)
                                                    // ->where('rekap_pelatihan_seminar_peserta.departemen_id',$departemen_user_all->departemen_id)
                                                    ->where('rekap_pelatihan_Seminar.periode',$periode)
                                                    ->where('departemen_user.staff','y')
                                                    ->get();
                    $simpan_rekap_staff = json_encode($rekap_staff->count());
                    array_push($total_rekap_pelatihan_staff,$simpan_rekap_staff);
                @endphp
                @endforeach
                @php
                    array_push($total_all_staff_pelatihan,array_sum($total_rekap_pelatihan_staff))
                @endphp
                {{ array_sum($total_rekap_pelatihan_staff) }}
                {{-- @php
                    $rekap_pelatihan_staffs = \App\Models\DepartemenUser::where('departemen_id',$departemen->id)
                                                                        ->where('staff','y')
                                                                        ->count();
                    array_push($total_all_staff_pelatihan,$rekap_pelatihan_staffs);
                @endphp
                {{ $rekap_pelatihan_staffs }} --}}
            </td>
            @endforeach
            <td style="text-align: center; background-color: #35ff86; border: 1px solid black;">{{ array_sum($total_all_staff_pelatihan) }}</td>
        </tr>

        <tr>
            <td style="background-color: #eeff35; border: 1px solid black;">Non Staff</td>
            @foreach ($departemens as $departemen)
            @php
                $total_rekap_pelatihan_nonstaff = [];
            @endphp
            <td style="text-align: center; background-color: #eeff35; border: 1px solid black;">
                @foreach ($departemen->departemen_user_all as $departemen_user_all)
                    @php
                        $rekap_nonstaff = \App\Models\RekapPelatihanSeminarPeserta::leftJoin('rekap_pelatihan_seminar','rekap_pelatihan_seminar.id','=','rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id')
                                                    ->leftJoin('departemen_user','departemen_user.team','=','rekap_pelatihan_seminar_peserta.peserta')
                                                    // ->leftJoin('departemen_user','departemen_user.team','=','rekap_pelatihan_seminar_peserta.peserta')
                                                    ->where('rekap_pelatihan_seminar_peserta.peserta',$departemen_user_all->team)
                                                    // ->where('rekap_pelatihan_seminar_peserta.departemen_id',$departemen_user_all->departemen_id)
                                                    ->where('rekap_pelatihan_seminar.periode',$periode)
                                                    ->where('departemen_user.staff','n')
                                                    ->get();
                        $simpan_rekap_nonstaff = json_encode($rekap_nonstaff->count());
                        array_push($total_rekap_pelatihan_nonstaff,$simpan_rekap_nonstaff);
                    @endphp
                @endforeach
                @php
                    array_push($total_all_nonstaff_pelatihan,array_sum($total_rekap_pelatihan_nonstaff))
                @endphp
                {{ array_sum($total_rekap_pelatihan_nonstaff) }}
                {{-- @php
                    $rekap_pelatihan_nonstaffs = \DB::select(\DB::raw(
                                                'select rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id,rekap_pelatihan_seminar_peserta.departemen_id, count(rekap_pelatihan_seminar_peserta.departemen_id) as jumlah_peserta, 
                                                count(rekap_pelatihan_seminar_peserta.departemen_id)/count(departemen_user.departemen_id) as nilai 
                                                from rekap_pelatihan_seminar_peserta 
                                                left join rekap_pelatihan_seminar
                                                on rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id = rekap_pelatihan_Seminar.id
                                                left join departemen_user
                                                on departemen_user.team = rekap_pelatihan_seminar_peserta.peserta
                                                where rekap_pelatihan_seminar_peserta.departemen_id = '.$departemen->id.'
                                                and departemen_user.staff = "n"
                                                and rekap_pelatihan_seminar.periode = '.$periode.'
                                                GROUP BY rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id',
                                        ));
                foreach ($rekap_pelatihan_nonstaffs as $rekap_pelatihan_nonstaff) {
                    array_push($total_rekap_pelatihan_nonstaff,$rekap_pelatihan_nonstaff->nilai);
                }
                @endphp
                @php
                    array_push($total_all_nonstaff_pelatihan,array_sum($total_rekap_pelatihan_nonstaff))
                @endphp
                {{ array_sum($total_rekap_pelatihan_nonstaff) }} --}}
                
                
                {{-- @php
                    $rekap_pelatihan_nonstaffs = \App\Models\DepartemenUser::where('departemen_id',$departemen->id)
                                                                        ->where('staff','n')
                                                                        ->count();
                    array_push($total_all_nonstaff_pelatihan,$rekap_pelatihan_nonstaffs);
                @endphp
                {{ $rekap_pelatihan_nonstaffs }} --}}
            </td>
            @endforeach
            <td style="text-align: center; background-color: #eeff35; border: 1px solid black;">{{ array_sum($total_all_nonstaff_pelatihan) }}</td>
        </tr>

        <tr>
            <td style="background-color: #ffdd35; border: 1px solid black;">Laki - Laki</td>
            @foreach ($departemens as $departemen)
            @php
                $total_rekap_laki_laki = [];
            @endphp
            <td style="text-align: center; background-color: #ffdd35; border: 1px solid black;">
                @foreach ($departemen->departemen_user_all as $departemen_user_all)
                    @php
                        $rekap_laki_laki = \App\Models\RekapPelatihanSeminarPeserta::leftJoin('rekap_pelatihan_Seminar','rekap_pelatihan_Seminar.id','=','rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id')
                                                    ->leftJoin('departemen_user','departemen_user.team','=','rekap_pelatihan_seminar_peserta.peserta')
                                                    ->where('rekap_pelatihan_seminar_peserta.peserta',$departemen_user_all->team)
                                                    // ->where('rekap_pelatihan_seminar_peserta.departemen_id',$departemen_user_all->departemen_id)
                                                    ->where('rekap_pelatihan_Seminar.periode',$periode)
                                                    ->where('departemen_user.jenis_kelamin','L')
                                                    ->get();
                        $simpan_rekap_laki_laki = json_encode($rekap_laki_laki->count());
                        array_push($total_rekap_laki_laki,$simpan_rekap_laki_laki);
                    @endphp
                @endforeach
                @php
                    array_push($total_all_laki_laki,array_sum($total_rekap_laki_laki))
                @endphp
                {{ array_sum($total_rekap_laki_laki) }}
            </td>
            @endforeach
            <td style="text-align: center; background-color: #ffdd35; border: 1px solid black;">{{ array_sum($total_all_laki_laki) }}</td>
        </tr>

        <tr>
            <td style="background-color: #ffdd35; border: 1px solid black;">Perempuan</td>
            @foreach ($departemens as $departemen)
            @php
                $total_rekap_perempuan = [];
            @endphp
            <td style="text-align: center; background-color: #ffdd35; border: 1px solid black;">
                @foreach ($departemen->departemen_user_all as $departemen_user_all)
                    @php
                        $rekap_perempuan = \App\Models\RekapPelatihanSeminarPeserta::leftJoin('rekap_pelatihan_Seminar','rekap_pelatihan_Seminar.id','=','rekap_pelatihan_seminar_peserta.rekap_pelatihan_seminar_id')
                                                    ->leftJoin('departemen_user','departemen_user.team','=','rekap_pelatihan_seminar_peserta.peserta')
                                                    ->where('rekap_pelatihan_seminar_peserta.peserta',$departemen_user_all->team)
                                                    // ->where('rekap_pelatihan_seminar_peserta.departemen_id',$departemen_user_all->departemen_id)
                                                    ->where('rekap_pelatihan_Seminar.periode',$periode)
                                                    ->where('departemen_user.jenis_kelamin','P')
                                                    ->get();
                        $simpan_rekap_perempuan = json_encode($rekap_perempuan->count());
                        array_push($total_rekap_perempuan,$simpan_rekap_perempuan);
                    @endphp
                @endforeach
                @php
                    array_push($total_all_perempuan,array_sum($total_rekap_perempuan))
                @endphp
                {{ array_sum($total_rekap_perempuan) }}
            </td>
            @endforeach
            <td style="text-align: center; background-color: #ffdd35; border: 1px solid black;">{{ array_sum($total_all_perempuan) }}</td>
        </tr>
    </tbody>
</table>