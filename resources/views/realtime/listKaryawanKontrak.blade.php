<table id="datatables" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">NIK</th>
            <th class="text-center">Nama Karyawan</th>
            <th class="text-center">Departemen</th>
            <th class="text-center">Kontrak Terakhir</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($karyawanKontraks as $key => $item)
            <tr>
                <td class="text-center">{{ $key+1 }}</td>
                <td class="text-center">{{ $item->nik }}</td>
                <td class="text-center">{{ $item->nama }}</td>
                <td class="text-center">{{ $item->departemen_dept }}</td>
                <td class="text-center">{{ \Carbon\Carbon::create($item->tgl_mulai)->addYears()->format('Y-m-d') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Data Belum Tersedia</td>
            </tr>
        @endforelse
    </tbody>
</table>