@extends('layouts.frontend')

@section('content')
<section>
    <div class="w-100 pt-100 black-layer opc5 pb-80 position-relative">
        <div class="fixed-bg" style="background-image: url({{ asset('assets/user/images/contact-bg.png') }});"></div>
        <div class="container">
            <div class="page-title-wrap text-center w-100">
                <div class="page-title-inner d-inline-block">
                    <h1 class="mb-0">Tentang</h1>
                    <ol class="breadcrumb mb-0 justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" title="">Beranda</a></li>
                        <li class="breadcrumb-item active" style="color: #BBA47F;">Tentang</li>
                    </ol>
                </div>
            </div><!-- Page Title Wrap -->
        </div>
    </div>
</section>
<section>
    <div class="w-100 blue-layer opc1 pb-120 position-relative">
        <div class="fixed-bg back-blend-multiply bg-color5"></div>
        <div class="container">
            <div class="quote-facts-wrap position-relative w-100">
                <div class="row mrg30 align-items-end">
                    <div class="col-md-8 col-sm-12 col-lg-8">
                        <div class="quote-box-wrap position-relative w-100">
                            <img class="img-fluid brd-rd5 overlap65" src="{{ asset('assets/user/images/resources/massoleh.png') }}" alt="Quote Image">
                            <div class="quote-box position-absolute w-100">
                                <div class="quote-box-inner thm-bg w-100">
                                    <i class="fas fa-quote-left scndry-bg brd-rd5 position-absolute"></i>
                                    <p class="mb-0">Onemeans Leather adalah toko yang menyediakan berbagai aksesoris berkualitas tinggi dari kulit asli.</p>
                                </div>
                                <div class="quote-box-info position-relative overflow-hidden thm-bg brd-rd5 w-100">
                                    <h3 class="mb-0">Mas Soleh</h3>
                                    <span class="d-block">Pemilik</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-lg-4">
                        <div class="facts-wrap position-relative w-100">
                            <div class="fact-box position-relative d-flex flex-wrap w-100">
                                <i class="fas fa-paw thm-clr d-inline-block"></i>
                                <div class="fact-box-inner">
                                    <span class="scndry-clr d-block"><i class="counter">200</i>+</span>
                                    <h4 class="mb-0">Jumlah Produk</h4>
                                    <p class="mb-0">Koleksi Terlengkap & Berkualitas</p>
                                </div>
                            </div>
                            <div class="fact-box position-relative d-flex flex-wrap w-100">
                                <i class="fas fa-list-ul thm-clr d-inline-block"></i>
                                <div class="fact-box-inner">
                                    <span class="scndry-clr d-block"><i class="counter">4.8</i>+</span>
                                    <h4 class="mb-0">Tingkat Kepercayaan</h4>
                                    <p class="mb-0">Kepercayaan Anda, Prioritas Kami</p>
                                </div>
                            </div>
                            <div class="fact-box position-relative d-flex flex-wrap w-100">
                                <i class="fas fa-users thm-clr d-inline-block"></i>
                                <div class="fact-box-inner">
                                    <span class="scndry-clr d-block"><i class="counter">5000</i>+</span>
                                    <h4 class="mb-0">Jumlah Pelanggan</h4>
                                    <p class="mb-0">Pilihan Anda, Komitmen Kami</p>
                                </div>
                            </div>
                        </div><!-- Facts Wrap -->
                    </div>
                </div>
            </div><!-- Quotes & Facts Wrap -->
        </div>
    </div>
</section>
<section>
                
                </div>
            </div>
        </section>
        <section>
            <div class="w-100 position-relative">
                <div class="special-wrap res-row overflow-hidden position-relative w-100">
                    <div class="row mrg">
                        <div class="col-md-6 col-sm-6 col-lg-4">
                            <div class="special-box v3 text-center z1 thm-bg grad-bg2 d-flex position-relative justify-content-center flex-wrap w-100">
                                <div class="special-box-inner">
                                    <h4 class="mb-0">2015</h4>
                                    <p class="mb-0">Onemens Leather mulai masuk marketplace seperti Shopee, Tokopedia, dan Lazada untuk menjangkau lebih banyak pelanggan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-4">
                            <div class="special-box v3 text-center z1 thm-bg grad-bg2 d-flex position-relative justify-content-center flex-wrap w-100">
                                <div class="special-box-inner">
                                    <h4 class="mb-0">2020</h4>
                                    <p class="mb-0">Memperluas jaringan supplier, meningkatkan kualitas produk, dan membangun branding sebagai penyedia kulit premium.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-4">
                            <div class="special-box v3 text-center z1 thm-bg grad-bg2 d-flex position-relative justify-content-center flex-wrap w-100">
                                <div class="special-box-inner">
                                    <h4 class="mb-0">2025</h4>
                                    <p class="mb-0">Menjadi brand kulit premium terkemuka dengan ekspansi ke pasar internasional dan inovasi dalam kurasi produk berkualitas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection