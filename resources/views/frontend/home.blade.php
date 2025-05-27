@extends('layouts.frontend')

@section('content')
<!-- Sn Main Slider -->
<section class="sn-main-slider">
    <div class="sn-main-slider-carousel owl-carousel owl-theme">
        
        <div class="slide">
            <div class="container">
                <div class="row clearfix">
                    <!-- Content Column -->
                    <div class="content-column col-lg-6 cl-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="title">Sesuatu yang Akan Kamu Sukai</div>
                            <h1>Klasik. Tahan Lama. Autentik.</h1>
                            <div class="text">Setiap produk Onemens dibuat dari kulit berkualitas tinggi, menjamin tampilan elegan dan daya tahan yang tinggi.</div>
                            <div class="btns-box">
                                <a class="thm-btn thm-bg brd-rd5 d-inline-block position-relative overflow-hidden" href="{{ route('list.category') }}" title="">Ayo Mulai!</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Image Column -->
                    <div class="image-column col-lg-6 cl-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="circle-layer">
                                <span class="circle-one"></span>
                                <span class="circle-two"></span>
                            </div>
                            <div class="image">
                                <img src="{{ asset('assets/user/images/video-image1.jpg') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="slide">
            <div class="container">
                <div class="row clearfix">
                    <!-- Content Column -->
                    <div class="content-column col-lg-6 cl-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="title">Sesuatu yang Akan Kamu Sukai</div>
                            <h1>Lebih dari Sekadar Aksesoris, Ini Adalah Sebuah Pernyataan Gaya.</h1>
                            <div class="text">Produk Onemens mencerminkan selera tinggi dan kualitas yang bertahan lama.</div>
                            <div class="btns-box">
                                <a class="thm-btn thm-bg brd-rd5 d-inline-block position-relative overflow-hidden" href="{{ route('contact') }}" title="">Ayo Mulai!</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Image Column -->
                    <div class="image-column col-lg-6 cl-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="circle-layer">
                                <span class="circle-one"></span>
                                <span class="circle-two"></span>
                            </div>
                            <div class="image">
                                <img src="{{ asset('assets/user/images/video-image2.jpg') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>
<!-- End Main Slider Section -->

<section class="sn-featured-section">
    <div class="container">
        <div class="inner-container">
            <div class="clearfix">
            
                <!-- Sn Feature Block -->
                <div class="sn-feature-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="content">
                            <span class="icon fas fa-child"></span>
                            <h4>Full Grain Leather</h4>
                            <div class="text">Kulit dengan kekuatan alami yang tahan lama</div>
                        </div>
                    </div>
                </div>
                
                <!-- Sn Feature Block -->
                <div class="sn-feature-block active col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="content">
                            <span class="icon fas fa-medal"></span>
                            <h4>Pull Grain Leather</h4>
                            <div class="text">Kulit halus dengan sedikit modifikasi</div>
                        </div>
                    </div>
                </div>
                
                <!-- Sn Feature Block -->
                <div class="sn-feature-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="content">
                            <span class="icon fas fa-horse-head"></span>
                            <h4>Crazy Horse Leather</h4>
                            <div class="text">Kulit full grain dengan efek vintage</div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

<section>
    <div class="w-100 pt-120 blue-layer2 opc85 pb-130 position-relative">
        <div class="fixed-bg" style="background-image: url({{ asset('assets/user/images/parallax-bg11.jpg') }});"></div>
        <div class="container">
            <div class="sec-title2 v2 text-center w-100">
                <div class="sec-title2-inner d-inline-block">
                    <h2 class="mb-0">Temukan Kulit Premium Kami di Marketplace Favoritmu!</h2>
                    <p class="mb-0">Onemens Leather - Kini hadir di Shopee, Tokopedia, dan Lazada</p>
                </div>
            </div><!-- Sec Title 2 -->
            <div class="procedure-wrap res-row text-center w-100">
                <div class="row mrg30">
                    <div class="col-md-4 col-sm-4 col-lg-3">
                        <div class="proced-box z1 brd-rd5 thm-bg position-relative w-100">
                            <span class="rounded-circle position-absolute">2</span>
                            <h4 class="mb-0"><a role="button" title="">TOKOPEDIA</a></h4>
                            <p class="mb-0">"Jelajahi koleksi kulit asli terbaik! Full Grain, Top Grain, dan Crazy Horse dengan kualitas premium."</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-lg-3">
                        <div class="proced-box z1 brd-rd5 thm-bg position-relative w-100">
                            <span class="rounded-circle position-absolute">1</span>
                            <h4 class="mb-0"><a role="button" title="">SHOPEE</a></h4>
                            <p class="mb-0">“Kulit premium berkualitas tinggi – Full Grain, Top Grain, dan Crazy Horse untuk tampilan elegan & tahan lama!”</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-lg-3">
                        <div class="proced-box z1 brd-rd5 thm-bg position-relative w-100">
                            <span class="rounded-circle position-absolute">3</span>
                            <h4 class="mb-0"><a role="button" title="">LAZADA</a></h4>
                            <p class="mb-0">"Pilihan kulit asli terbaik – Full Grain, Top Grain, dan Crazy Horse dengan daya tahan & estetika maksimal!"</p>
                        </div>
                    </div>
                    </div>
                </div>
            </div><!-- Procedure Wrap -->
        </div>
    </div>
</section>
<section>
    <div class="w-100 pt-100 white-layer opc95 pb-110 position-relative">
        <div class="fixed-bg" style="background-image: url({{ asset('assets/user/images/parallax-bg12.png') }});"></div>
        <div class="container">
            <div class="sec-title2 v3 text-center w-100">
                <div class="sec-title2-inner d-inline-block">
                    <h2 class="mb-0">Top 3 Produk</h2>
                    <p class="mb-0">Inilah tiga produk terbaik kami – kombinasi sempurna antara keindahan, kekuatan, dan kenyamanan. Dibuat dari kulit asli yang semakin menarik seiring pemakaian!</p>
                </div>
            </div><!-- Sec Title 2 -->
            <div class="courses-wrap res-row position-relative w-100">
                <div class="row mrg30">
                    @if(isset($result) && $result && $result->isNotEmpty())
                    @foreach($result AS $row)
                    <div class="col-md-6 col-sm-6 col-lg-4">
                        <div class="course-box position-relative w-100">
                            <div class="course-img overflow-hidden position-relative w-100">
                                <a role="button" href="{{ route('detail.product',$row->id_product) }}" title=""><img class="img-fluid w-100" src="{{ image_check($row->image,'product') }}" alt="{{ $row->name }}"></a>
                            </div>
                            <div class="course-info bg-color6 position-relative w-100">
                                <h3 class="mb-0"><a role="button" href="{{ route('detail.product',$row->id_product) }}" title="">{{ $row->name }}</a></h3>
                                <h4 class="mb-0">{{ 'Rp. '.number_format($row->price,0,',','.') }}</a></h4>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="w-100 d-flex justify-content-center align-items-center flex-column">
                        <img style="max-width : 300px;min-width : 150px" src="{{ image_check('empty.svg','default') }}" alt="">
                        <h3 class="fs-3 text-center" style="color : #472c1d">Tidak ada data produk</h3>
                        <p class="text-muted fs-6 text-center">Belum ada data produk yang di display! Silahkan hubungi admin jika terjadi kesalahan</p>
                    </div>
                    @endif
            </div><!-- Courses Wrap -->
        </div>
    </div>
</section>
@endsection