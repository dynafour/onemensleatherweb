@extends('layouts.frontend')


@section('content')

<section>
    <div class="w-100 pt-100 black-layer opc5 pb-80 position-relative">
        <div class="fixed-bg" style="background-image: url({{ asset('assets/user/images/product-bg.png') }});"></div>
        <div class="container">
            <div class="page-title-wrap text-center w-100">
                <div class="page-title-inner d-inline-block">
                    <h1 class="mb-0">{{ $result->name }}</h1>
                    <ol class="breadcrumb mb-0 justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" title="">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('list.product',$result->id_category) }}" title="">{{ $result->category->name }}</a></li>
                        <li class="breadcrumb-item active" style="color: #BBA47F;">{{ $result->name }}</li>
                    </ol>
                </div>
            </div><!-- Page Title Wrap -->
        </div>
    </div>
</section>
<section>
    <div class="w-100 pt-110 pb-120 position-relative">
        <div class="container">
            <div class="page-wrap wide-sec3 position-relative w-100">
                <div class="row mrg30">
                    <div class="col-md-12 col-sm-12 col-lg-8">
                        <div class="prod-detail w-100">
                            <div class="prod-detail-info-wrap d-flex flex-wrap w-100">
                                <div class="prod-detail-img brd-rd10 overflow-hidden">
                                    <img class="img-fluid w-100" src="{{ image_check($result->image,'product') }}" alt="{{ $result->name }}">
                                </div>
                                <div class="prod-detail-info">
                                    <h2 class="mb-0">{{ $result->name }}</h2>
                                    <div class="price-stock d-flex flex-wrap justify-content-between align-items-center w-100">
                                        <span class="price scndry-clr d-inline-block"><ins><small>Rp.&nbsp;</small>{{ number_format($result->price,0,',','.') }}</ins></span>
                                        <span class="d-inline-block">Stok Tersedia:<span class="thm-clr">{{ number_format(($result->total_stock - $result->total_sold),0,',','.') }}</span></span>
                                    </div>
                                    <span class="d-block sku mb-2">Bahan: <i class="font-style-normal">{{ $result->material }}</i></span>
                                    <div style="display: flex; align-items: center; gap: 30px; margin-bottom: 20px; flex-wrap: wrap;">

                                        <!-- Ukuran -->
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <label style="font-weight: bold;">Ukuran :</label>
                                            <div style="padding: 8px 16px; background-color: #f8f8f8; border-radius: 10px; min-width: 100px;">{{ $result->size }}</div>
                                        </div>
                                        
                                        <!-- Warna -->
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <label style="font-weight: bold;">Warna :</label>
                                            <div style="padding: 8px 16px; background-color: #f8f8f8; border-radius: 10px; min-width: 100px;">{{ $result->color }}</div>
                                        </div>
                                        
                                        </div>
                                        
                                        <!-- Tombol Beli -->
                                        @if($result->link != '')
                                        <div>
                                        <a href="{{ $result->link }}" target="_BLANK" style="background-color: #3c2415; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: bold;">
                                            BELI SEKARANG
                                        </a>
                                        </div>
                                        @endif
                                        
                                </div>
                            </div>
                            <div class="prod-detail-meta d-flex flex-wrap align-items-center justify-content-between w-100">
                                <ul class="meta3 mb-0 list-unstyled d-flex flex-wrap">
                                    
                                </ul>
                            </div>
                            <p class="mb-0">DESKRIPSI PRODUK</p>
                            <ul class="mb-0">
                                {!! $result->description !!}
                            </ul>                                          
                            <div class="additional-info d-flex flex-wrap justify-content-between align-items-center w-100">
                                <h3 class="position-relative">Informasi Tambahan</h3>
                                <ul class="mb-0 list-unstyled">
                                    <li><span class="d-inline-block">Produk Terjual: </span>{{number_format($result->total_sold,0,',','.')}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                
                                    
                                </div>
                            </div>
                        </aside><!-- Sidebar -->
                    </div>
                </div>
            </div><!-- Page Wrap -->
        </div>
    </div>
</section>
@endsection