{{-- <table id="datatables" class="table table-bordered dt-responsive nowrap"
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
</table> --}}
<ul class="list-group custom-list-group mb-n3">
    @forelse ($karyawanKontraks as $key => $item)
    <li class="list-group-item align-items-center d-flex justify-content-between pt-0">
        <div class="media">
            <img src="{{ asset('public/berkas/HRGA/data_karyawan/'.$item->foto_karyawan) }}" height="30" class="me-3 align-self-center rounded" alt="...">
            <div class="media-body align-self-center">
                <h5 class="mb-2">{{ $item->nik.' - '.$item->nama }}</h5>
                <p class="mb-0">Departemen : {{ $item->departemen_dept }}</p>
                <p class="mb-0">Kontrak Terakhir : {{ \Carbon\Carbon::create($item->tgl_mulai)->addYears()->format('d-m-Y') }}</p>
            </div><!--end media body-->
        </div>
    </li>
    @empty
    @endforelse
</ul>
