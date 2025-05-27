@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
@endphp
<header class="style3 w-100">
    <div class="top-noti scndry-bg text-center w-100">
        <div class="container">
            <div class="topbar-inner d-flex flex-wrap align-items-center justify-content-between w-100">
                <div class="topbar-right d-inline-flex align-items-center flex-wrap">
                    <a class="search-btn d-inline-block position-relative" href="javascript:void(0);" title=""><i class="fas fa-search"></i></a>
                </div>
            </div>
        </div>
    </div><!-- Topbar -->
    <div class="logo-menu-wrap position-relative w-100">
        <div class="container">
            <div class="logo-menu-inner d-flex flex-wrap align-items-center justify-content-between position-relative w-100">
                <div class="logo v2 z1 bg-color10 position-absolute text-center"><h1 class="mb-0"><a class="d-block" href="{{ route('home') }}" title="Home"><img class="img-fluid" src="{{ asset('assets/user/images/logo-logo2.png') }}" alt="Logo" srcset="{{ asset('assets/user/images/logo-logo2.png') }}"></a></h1></div><!-- Logo -->
                <nav class="d-flex flex-wrap align-items-center justify-content-between w-100">
                    <div class="header-left">
                        <ul class="mb-0 list-unstyled d-inline-flex">
                            <li class="{{ ($segment1 == 'home') ? 'active' : '' }}"><a href="{{ route('home') }}" title="">Beranda</a></li>
                            <li class="{{ (in_array($segment1,['list-categories','list-product','detail-product'])) ? 'active' : '' }}"><a href="{{ route('list.category') }}" title="">Produk</a></li>
                            <li class="{{ ($segment1 == 'about') ? 'active' : '' }}"><a href="{{ route('about') }}" title="">Tentang</a></li>
                            <li class="{{ ($segment1 == 'contact') ? 'active' : '' }}"><a href="{{ route('contact') }}" title="">Kontak</a></li>
                        </ul>
                    </div>
                </nav><!-- Navigation -->
            </div>
        </div>
    </div><!-- Logo & Menu Wrap -->
</header><!-- Header -->
<div class="header-search d-flex flex-wrap align-items-center position-fixed w-100">
    <span class="search-close-btn position-absolute"><i class="fas fa-times"></i></span>
    <form class="w-100 position-relative">
        <button type="submit"><i class="fas fa-search"></i></button>
        <input type="text" placeholder="Search">
    </form>
</div><!-- Header Search -->
<div class="sticky-menu">
    <div class="container">
        <div class="sticky-menu-inner d-flex flex-wrap align-items-center justify-content-between w-100">
            <nav class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="header-left">
                    <ul class="mb-0 list-unstyled d-inline-flex">
                        <li class="{{ ($segment1 == 'home') ? 'active' : '' }}"><a href="{{ route('home') }}" title="">Beranda</a></li>
                            <li class="{{ (in_array($segment1,['list-categories','list-product','detail-product'])) ? 'active' : '' }}"><a href="{{ route('list.category') }}" title="">Produk</a></li>
                            <li class="{{ ($segment1 == 'about') ? 'active' : '' }}"><a href="{{ route('about') }}" title="">Tentang</a></li>
                            <li class="{{ ($segment1 == 'contact') ? 'active' : '' }}"><a href="{{ route('contact') }}" title="">Kontak</a></li>
                        </ul>
                </div>
            </nav>
        </div>
    </div>
</div><!-- Sticky Menu -->
<div class="rspn-hdr">
    <div class="lg-mn">
        <span class="rspn-mnu-btn"><i class="fa fa-list-ul"></i></span>
    </div>
    <div class="rsnp-mnu">
        <span class="rspn-mnu-cls"><i class="fa fa-times"></i></span>
        <ul class="mb-0 list-unstyled w-100">
            <li class="{{ ($segment1 == 'home') ? 'active' : '' }}"><a href="{{ route('home') }}" title="">Beranda</a></li>
            <li class="{{ (in_array($segment1,['list-categories','list-product','detail-product'])) ? 'active' : '' }}"><a href="{{ route('list.category') }}" title="">Produk</a></li>
            <li class="{{ ($segment1 == 'about') ? 'active' : '' }}"><a href="{{ route('about') }}" title="">Tentang</a></li>
            <li class="{{ ($segment1 == 'contact') ? 'active' : '' }}"><a href="{{ route('contact') }}" title="">Kontak</a></li>
        </ul>
    </div><!-- Responsive Menu -->
</div><!-- Responsive Header -->