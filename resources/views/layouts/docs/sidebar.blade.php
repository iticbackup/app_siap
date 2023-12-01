<div class="left-sidenav">
    <div class="brand">
        <a href="{{ route('docs.index') }}" class="logo">
            <span>
                <img src="{{ URL::asset('public/logo/sima.png') }}" class="logo-sm" style="width: 100px; height: 40px">
            </span>
            <span>
                {{-- <img src="{{ URL::asset('public/itic/text_itic.png') }}" alt="logo-large" class="logo-lg logo-light">
                <img src="{{ URL::asset('public/itic/text_itic_dark.png') }}" alt="logo-large"
                    class="logo-lg logo-dark"> --}}
            </span>
        </a>
    </div>
    <div class="menu-content h-100" data-simplebar>
        <ul class="metismenu left-sidenav-menu">
            <li class="{{ Request::is('docs/file_management') ? 'active' : '' }}">
                <a href="{{ route('docs.file_management') }}" class="{{ Request::is('docs/file_management') ? 'active' : '' }}"><i
                        class="mdi mdi-home"></i> File Management</a>
            </li>
            <li class="{{ Request::is('docs/rekap_pelatihan') ? 'active' : '' }}">
                <a href="#" class="{{ Request::is('docs/rekap_pelatihan') ? 'active' : '' }}"><i
                        class="mdi mdi-home"></i> Rekap Pelatihan</a>
            </li>
        </ul>
    </div>
</div>