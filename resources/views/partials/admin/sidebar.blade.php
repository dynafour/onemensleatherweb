@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
@endphp
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
<!--begin::Page-->
<div class="app-page flex-column flex-column-fluid" id="kt_app_page">

<!--begin::Wrapper-->
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
<!--begin::Sidebar-->
<div id="reload_sidebar">
    <div id="kt_app_sidebar" class="app-sidebar flex-column bg-primary" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
        <div class="w-100 position-absolute d-flex justify-content-end p-2">
             <button class="navbar-toggler me-2 close-sidebar" type="button" onclick="set_sidebar()">
                <i class="fa-solid fa-xmark fs-1 text-white icon-custom-navbar"></i>
            </button>
        </div>
        <div class="app-sidebar-header d-flex flex-stack justify-content-center align-items-center d-none d-lg-flex pt-8 pb-2" id="kt_app_sidebar_header">
            <a href="{{ route('dashboard') }}" class="app-sidebar-logo">
                @if($setting->logo)
                    <img alt="Logo" src="{{ asset(image_check($setting->logo, 'setting')) }}" style="height: 70px;" class="d-none d-sm-inline app-sidebar-logo-default theme-light-show" />
                    <img alt="Logo" src="{{ asset(image_check($setting->logo, 'setting')) }}" style="height: 70px;" class="d-none d-sm-inline app-sidebar-logo-default theme-dark-show" />
                @endif
            </a>
        </div>
        <!--begin::Navs-->
        <div class="app-sidebar-navs flex-column-fluid py-6" id="kt_app_sidebar_navs">
            <div id="kt_app_sidebar_navs_wrappers" class="app-sidebar-wrapper hover-scroll-y my-2">
                <div class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary" style="height : 80vh;overflow-y : auto">
                    <a href="{{ route('dashboard') }}" class="menu-item menu-accordion mb-5">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-home fs-3 text-white fw-bold"></i>
                            </span>
                            <span class="menu-title fs-3 text-white fw-bold">Beranda</span>
                        </span>
                    </a>
                    
                    <label class="menu-item menu-accordion mb-1">
                        <span class="menu-link">
                            <span class="menu-title fs-3 text-white fw-bold">Manajemen</span>
                        </span>
                    </label>
                    <a href="{{ route('category') }}" class="menu-item menu-accordion mb-5">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-layer-group fs-3 text-white"></i>
                            </span>
                            <span class="menu-title fs-3 text-white">Kategori</span>
                        </span>
                    </a>
                    <a href="{{ route('product') }}" class="menu-item menu-accordion mb-5">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-boxes-stacked fs-3 text-white"></i>
                            </span>
                            <span class="menu-title fs-3 text-white">Produk</span>
                        </span>
                    </a>

                    <label class="menu-item menu-accordion mb-1">
                        <span class="menu-link">
                            <span class="menu-title fs-3 text-white fw-bold">Manajemen Keuangan</span>
                        </span>
                    </label>
                    <a href="{{ route('transaksi') }}" class="menu-item menu-accordion mb-5">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-money-bill fs-3 text-white"></i>
                            </span>
                            <span class="menu-title fs-3 text-white">Transaksi Penjualan</span>
                        </span>
                    </a>

                    <label class="menu-item menu-accordion mb-1">
                        <span class="menu-link">
                            <span class="menu-title fs-3 text-white fw-bold">Manajemen Komentar</span>
                        </span>
                    </label>
                    <a href="{{ route('comment') }}" class="menu-item menu-accordion mb-5">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-comment fs-3 text-white"></i>
                            </span>
                            <span class="menu-title fs-3 text-white">Daftar Komentar</span>
                        </span>
                    </a>

                    <label class="menu-item menu-accordion mb-1">
                        <span class="menu-link">
                            <span class="menu-title fs-3 text-white fw-bold">Admin</span>
                        </span>
                    </label>
                    <a href="{{ route('profile') }}" class="menu-item menu-accordion mb-3">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-user fs-3 text-white"></i>
                            </span>
                            <span class="menu-title fs-3 text-white">Pengaturan Profil</span>
                        </span>
                    </a>


                    <a href="{{ route('report') }}" class="menu-item menu-accordion mb-3">
                        <span class="menu-link">
                            <span class="menu-icon">
                                 <i class="fa-solid fa-print fs-3 text-white"></i>
                            </span>
                            <span class="menu-title fs-3 text-white">Cetak Laporan</span>
                        </span>
                    </a>

                    <a href="{{ route('logout') }}" onclick="confirm_alert(this, event, 'Apakah Anda yakin akan meninggalkan sistem?')" class="menu-item menu-accordion mb-5">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-right-from-bracket fs-3 text-white"></i>
                            </span>
                            <span class="menu-title fs-3 text-white">Keluar</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Navs-->
    </div>
</div>