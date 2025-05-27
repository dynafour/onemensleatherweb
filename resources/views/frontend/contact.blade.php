@extends('layouts.frontend')

@section('content')
<section>
    <div class="w-100 pt-100 black-layer opc5 pb-80 position-relative">
    <div class="fixed-bg" style="background-image: url('{{ asset('assets/user/images/contact-bg - Copy.png') }}');"></div>
        <div class="container">
            <div class="page-title-wrap text-center w-100">
                <div class="page-title-inner d-inline-block">
                    <h1 class="mb-0">Kontak Kami</h1>
                    <ol class="breadcrumb mb-0 justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" title="">Beranda</a></li>
                        <li class="breadcrumb-item active" style="color: #BBA47F;">Kontak Kami</li>
                    </ol>
                </div>
            </div><!-- Page Title Wrap -->
        </div>
    </div>
</section>
<section>
    <div class="w-100 pt-100 thm-layer opc6 pb-30 position-relative">
        <div class="fixed-bg" style="background-color: #BBA47F;"></div>
        <div class="container">
            <div class="sec-title3 text-center w-100">
                <div class="sec-title3-inner d-inline-block">
                    <h3 class="mb-0">Informasi Kontak</h3>
                    <p class="mb-0">Hubungi kami untuk informasi lebih lanjut mengenai layanan dan produk kami. Kami siap membantu Anda dengan segala kebutuhan dan pertanyaan yang Anda miliki.</p>
                </div>
            </div>
            <div class="contact-info-wrap text-center position-relative w-100">
                <div class="row mrg30">
                    <div class="col-md-4 col-sm-6 col-lg-4">
                        <div class="contact-info-box position-relative w-100">
                            <i class="fas fa-envelope-open brd-rd10 d-inline-block scndry-clr"></i>
                            <span class="d-block"><a href="mailto:onemens@gmail.com" title="">onemens@gmail.com</a></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-lg-4">
                        <div class="contact-info-box position-relative w-100">
                            <i class="fas fa-home brd-rd10 d-inline-block scndry-clr"></i>
                            <p class="mb-0">Kabupaten Gersik, Jawa Timur</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-lg-4">
                        <div class="contact-info-box position-relative w-100">
                            <i class="fas fa-phone-alt brd-rd10 d-inline-block scndry-clr"></i>
                            <span class="d-block">+62 822-2330-6966</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="w-100 pt-100 gray-layer opc7 pb-100 position-relative">
        <div class="fixed-bg" style="background-image: url(asset('assets/user/images/parallax-bg14.jpg') }});"></div>
        <div class="container">
            <div class="sec-title4 text-center w-100">
                <div class="sec-title4-inner d-inline-block">
                    <div class="fixed-bg" style="background-image: url(asset('assets/user/images/pattern-bg2.jpg') }});"></div>
                        <div class="container">
                            <div class="sec-title2 v3 text-center w-100">
                                <div class="sec-title2-inner d-inline-block">
                                    <h2 class="mb-0">Berikan Pendapatmu</h2>
                                </div>
                            </div><!-- Sec Title 2 -->
                            @if(isset($result) && $result && $result->isNotEmpty())
                            <div class="client-reviews-wrap res-row text-center w-100">
                                <div class="row mrg30">
                                    @foreach($result AS $row)
                                    <div class="col-md-6 col-sm-6 col-lg-4">
                                        <div class="client-review-box brd-rd5 position-relative w-100">
                                            <div class="quote-icon mb-3">
                                                <i class="fas fa-quote-left scndry-clr" style="font-size: 24px; background: #fff; padding: 10px; margin-top: 10px; border-radius: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.2);"></i>
                                            </div>
                                            <h3 class="mb-0">{{ $row->name }}</h3>
                                            <p class="mb-0">{{ $row->description }}</p>
                                            <span class="d-block thm-clr">{{ $row->subject }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div><!-- Client Reviews Wrap -->
                            @endif
                            <div class="sec-title3 text-center w-100">
                                <div class="sec-title3-inner d-inline-block">
                                    <h2 class="mt-4 mb-0" style="padding-top: 70px;">Hubungi Kami:</h2>
                                    <p class="mb-0">Tinggalkan ulasan tentang Onemeans Leather dan bantu kami memberikan layanan yang lebih baik!</p>
                                </div>
                            </div>
                        </div>
                    </div>
            <div class="contact-form d-flex flex-wrap justify-content-center text-center w-100">
                <form class="w-100" method="POST" id="email-form" action="{{ route('insert.comment') }}">
                    <div class="response w-100"></div>
                    <div class="field-box w-100 d-flex justify-content-center align-items-start flex-column" id="req_name">
                        <input class="brd-rd10 mb-2 fname" type="text" name="name" placeholder="Nama" required autocomplete="off">
                    </div>
                    <div class="field-box w-100 d-flex justify-content-center align-items-start flex-column" id="req_email">
                        <input class="brd-rd10 mb-2 email" type="email" name="email" placeholder="Email" required autocomplete="off">
                    </div>
                    <div class="field-box w-100 d-flex justify-content-center align-items-start flex-column" id="req_subject">
                        <input class="brd-rd10 mb-2 subject" type="text" name="subject" placeholder="Subjek" required autocomplete="off">
                    </div>
                    <div class="field-box w-100 d-flex justify-content-center align-items-start flex-column" id="req_description">
                        <textarea class="brd-rd10 mb-2 contact_message" name="description" placeholder="Beritahu kami tentang pendapat Anda" required></textarea>
                    </div>
                    <button class="thm-btn scndry-bg brd-rd10 position-relative overflow-hidden btn-kirim" type="button" data-loader="big" onclick="submit_form(this,'#email-form')" id="submit">Kirim</button></div>
                </form>
            </div><!-- Contact Form -->
        </div>
    </div>
</section>
@endsection