{{-- @php
    use Spatie\Permission\Models\Role;
@endphp --}}
<div class="left-sidenav">
    <div class="brand">
        <a href="{{ route('home') }}" class="logo">
            <span>
                {{-- <img src="{{ URL::asset('public/itic/icon_itic.png') }}" alt="logo-small" class="logo-sm"> --}}
                <img src="{{ URL::asset('public/logo/sima.png') }}" class="logo-sm" style="width: 100px; height: 40px">
            </span>
            {{-- <span>
                <img src="{{ URL::asset('public/itic/text_itic.png') }}" alt="logo-large" class="logo-lg logo-light">
                <img src="{{ URL::asset('public/itic/text_itic_dark.png') }}" alt="logo-large"
                    class="logo-lg logo-dark">
            </span> --}}
        </a>
    </div>
    <div class="menu-content h-100" data-simplebar>
        <ul class="metismenu left-sidenav-menu">
            <li class="menu-label mt-0">Main</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="{{ Request::is('home') ? 'active' : '' }}"><i
                        class="mdi mdi-home"></i> Dashboard</a>
            </li>
            {{-- <li class="{{ Request::is('file_manager') ? 'active' : '' }}">
                <a href="{{ route('file_manager') }}" class="{{ Request::is('file_manager') ? 'active' : '' }}"><i
                        class="mdi mdi-file-table"></i> File Management</a>
            </li> --}}
            <li>
                <a href="javascript: void(0);"> <i data-feather="file-text"
                    class="align-self-center menu-icon"></i><span>Document Control</span><span class="menu-arrow"><i
                        class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{ route('perubahan_data') }}">
                        <i class="ti-control-record"></i>Perubahan Dokumen</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('file_manager') }}">
                        <i class="ti-control-record"></i>File Manager</a>
                    </li>
                </ul>
            </li>
            @can('rekap-list')
            <li>
                <a href="javascript: void(0);"> <i data-feather="file-text"
                        class="align-self-center menu-icon"></i><span>Rekap Pelatihan</span><span class="menu-arrow"><i
                            class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    @can('rekap-kategori')
                    <li class="nav-item"><a class="nav-link" href="{{ route('rekap_pelatihan.kategori') }}">
                            <i class="ti-control-record"></i>Kategori</a>
                    </li>
                    @endcan
                    @can('rekap-create')
                    <li class="nav-item"><a class="nav-link" href="{{ route('rekap_pelatihan.create') }}">
                            <i class="ti-control-record"></i>Buat Jadwal Pelatihan</a>
                    </li>
                    @endcan
                    @can('rekap-list')
                    <li class="nav-item"><a class="nav-link" href="{{ route('rekap_pelatihan.rekap_pelatihan') }}">
                            <i class="ti-control-record"></i>Data Rekap</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('kpi_list')
            <li>
                <a href="javascript: void(0);"> <i data-feather="file-text"
                    class="align-self-center menu-icon"></i><span>KPI</span><span class="menu-arrow"><i
                        class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    @can('kpi_departemen')
                    <li class="nav-item"><a class="nav-link" href="{{ route('kpi.kpi_departemen') }}">
                        <i class="ti-control-record"></i>Departemen</a>
                    </li>
                    @endcan
                    {{-- <li class="nav-item"><a class="nav-link" href="#">
                        <i class="ti-control-record"></i>Bobot</a>
                    </li> --}}
                    @can('kpi_indikator')
                    <li class="nav-item"><a class="nav-link" href="{{ route('kpi.kpi_indikator') }}">
                        <i class="ti-control-record"></i>Indikator</a>
                    </li>
                    @endcan
                    <li class="nav-item"><a class="nav-link" href="{{ route('kpi') }}">
                        <i class="ti-control-record"></i>Data KPI</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('hrga_list')
            <li class="menu-label mt-0">HRGA</li>
            <li class="{{ Request::is('hrga/biodata_karyawan') ? 'active' : '' }}">
                <a href="{{ route('hrga.biodata_karyawan') }}" class="{{ Request::is('hrga/biodata_karyawan') ? 'active' : '' }}"><i
                        class="mdi mdi-home"></i> Data Karyawan</a>
            </li>
            @endcan

            @php
                // dd(auth()->user()->assignRole('admin'));
            @endphp

            {{-- @if (auth()->user()->assignRole('admin') == 'admin')
            @endif --}}
            @can('kt-developer')
            <li class="menu-label mt-0">Developer</li>
            <li class="{{ Request::is('departemen') ? 'active' : '' }}">
                <a href="{{ route('departemen') }}" class="{{ Request::is('departemen') ? 'active' : '' }}"><i
                        class="mdi mdi-file-table"></i> Departemen</a>
            </li>
            <li class="{{ Request::is('activity_log') ? 'active' : '' }}">
                <a href="{{ route('activity_log') }}" class="{{ Request::is('activity_log') ? 'active' : '' }}"><i
                        class="mdi mdi-file-table"></i> Activity Log</a>
            </li>
            <li class="{{ Request::is('b_modules') ? 'active' : '' }}">
                <a href="{{ route('b_module') }}" class="{{ Request::is('b_modules') ? 'active' : '' }}"><i
                        class="mdi mdi-file-table"></i> Module</a>
            </li>
            {{-- @can('user-management-list') --}}
            <li>
                <a href="javascript: void(0);"> <i data-feather="file-text"
                        class="align-self-center menu-icon"></i><span>User Management</span><span class="menu-arrow"><i
                            class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    @can('user-list')
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">
                            <i class="ti-control-record"></i>User</a>
                    </li>
                    @endcan
                    @can('role-list')
                    <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}">
                            <i class="ti-control-record"></i>Roles</a>
                    </li>
                    @endcan
                    @can('permission-list')
                    <li class="nav-item"><a class="nav-link" href="{{ route('permission') }}">
                            <i class="ti-control-record"></i>Permissions</a>
                    </li>
                    @endcan
                </ul>
            </li>
            {{-- @endcan --}}
            @endcan
        </ul>
    </div>
</div>
