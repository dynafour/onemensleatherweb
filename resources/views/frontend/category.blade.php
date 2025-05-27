@extends('layouts.frontend')

@section('content')
<section>
    <div class="w-100 pt-100 black-layer opc5 pb-80 position-relative">
        <div class="fixed-bg" style="background-image: url({{ asset('assets/user/images/product-bg.png') }});"></div>
        <div class="container">
            <div class="page-title-wrap text-center w-100">
                <div class="page-title-inner d-inline-block">
                    <h1 class="mb-0">Product Page</h1>
                    <ol class="breadcrumb mb-0 justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" title="">Beranda</a></li>
                        <li class="breadcrumb-item active" style="color: #BBA47F;">Kategori</a></li>
                    </ol>
                </div>
            </div><!-- Page Title Wrap -->
        </div>
    </div>
</section>
<section>
    <div class="w-100 pt-100 white-layer opc95 pb-170 position-relative">
        <div class="fixed-bg" style="background-image: url(assets/images/parallax-bg2.jpg);"></div>
        <div class="container">
            <div class="sec-title v2 text-center w-100">
                <div class="sec-title-inner d-inline-block">
                    <h2 class="mb-0 text-color3">Pilih Barangmu Di Kategori!</h2>
                    <p class="mb-0 position-relative sub-shap thm-shp d-inline-block">Klik kategori untuk membuka list barang</p>
                </div>
            </div><!-- Sec Title -->
            <div class="team-wrap res-row position-relative w-100">
                <div class="row mrg30">
                    @if(isset($result) && $result && $result->isNotEmpty())
                    @foreach($result AS $row)
                    <div class="col-md-4 col-sm-6 col-lg-3 mb-3">
                        <div class="team-box text-center position-relative w-100">
                            <div class="team-img brd-rd5 overflow-hidden position-relative w-100">
                                <img class="img-fluid w-100" src="{{ image_check($row->image,'category') }}" alt="{{ $row->name }}">
                                <div class="social-links2 z1 align-items-center justify-content-center position-absolute">
                                    <a class="brd-rd5 kaca-hvr" href="{{ route('list.product',$row->id_category) }}" title="{{ $row->name }}">
                                        <img src="{{ asset('assets/user/images/kaca.png') }}" alt="Twitter Icon" width="24" height="24">
                                    </a>
                                </div>
                            </div>
                            <div class="team-info z1 bg-color5 position-relative w-100">
                                <h3 class="mb-0"><a href="{{ route('list.product',$row->id_category) }}" title="">{{ $row->name }}</a></h3>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="w-100 d-flex justify-content-center align-items-center flex-column">
                        <img style="max-width : 300px;min-width : 150px" src="{{ image_check('empty.svg','default') }}" alt="">
                        <h3 class="fs-3 text-center" style="color : #472c1d">Tidak ada data kategori</h3>
                        <p class="text-muted fs-6 text-center">Belum ada data kategori yang di display! Silahkan hubungi admin jika terjadi kesalahan</p>
                    </div>
                    @endif
                </div>
            </div><!-- Pagination Wrap -->
        </div>
    </div>
</section>

@endsection