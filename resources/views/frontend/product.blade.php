@extends('layouts.frontend')


@section('content')
<section>
    <div class="w-100 pt-100 black-layer opc5 pb-80 position-relative">
        <div class="fixed-bg" style="background-image: url({{ asset('assets/user/images/pag-top-bg.png') }});"></div>
        <div class="container">
            <div class="page-title-wrap text-center w-100">
                <div class="page-title-inner d-inline-block">
                    <h1 class="mb-0">{{ ($detail != null) ? $detail->name : 'List Produk' }}</h1>
                    <ol class="breadcrumb mb-0 justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" title="">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('list.category') }}" title="">Kategori</a></li>
                        <li class="breadcrumb-item active"  style="color: #BBA47F;">{{ ($detail != null) ? $detail->name : 'List Produk' }}</li>
                    </ol>
                </div>
            </div>
        </div>
</section>
<section>
    <div class="w-100 pt-100 pb-110 position-relative">
        <div class="container">
            <div class="prod-wrap position-relative w-100">
                <div class="row justify-content-center mrg30">
                    @if(isset($result) && $result && $result->isNotEmpty())
                    @foreach($result AS $row)
                    <div class="col-md-4 col-sm-6 col-lg-3 mb-3">
                        <div class="prod-box position-relative w-100">
                            <div class="prod-img brd-rd5 position-relative overflow-hidden w-100">
                                <img class="img-fluid w-100" src="{{ image_check($row->image,'product') }}" alt="{{ $row->name }}">
                                <a class="thm-bg z1 brd-rd5 text-center position-absolute" href="{{ route('detail.product',$row->id_product) }}" title=""><i class="fas fa-shopping-cart"></i></a>
                            </div>
                            <div class="prod-info position-relative w-100">
                                <span class="price z1 scndry-bg rounded-pill position-absolute text-center price-text">
                                    <small>Rp.&nbsp;</small>{{ number_format($row->price,0,',','.') }}</span>
                                <h3 class="mb-0"><a href="{{ route('detail.product',$row->id_product) }}" title="">{{ $row->name }}</a></h3>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="w-100 d-flex justify-content-center align-items-center flex-column">
                        <img style="max-width : 300px;min-width : 150px" src="{{ image_check('empty.svg','default') }}" alt="">
                        <h3 class="fs-3 text-center" style="color : #472c1d">Tidak ada data Produk</h3>
                        <p class="text-muted fs-6 text-center">Belum ada data Produk yang di display! Silahkan hubungi admin jika terjadi kesalahan</p>
                    </div>
                    @endif
                </div>
            </div><!-- Products Wrap -->


            @if($totalPages > 0)
                <div class="pagination-wrap mt-60 text-center w-100">
                    <ul class="pagination justify-content-center">
                        {{-- Tombol Sebelumnya --}}
                        @if($currentPage > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ route('list.product', [$id_category, ($currentPage - 2) * $perPage]) }}">
                                    <i class="fas fa-chevron-left"></i> Sebelumnya
                                </a>
                            </li>
                        @endif

                        {{-- Nomor halaman --}}
                        @for ($i = 1; $i <= $totalPages; $i++)
                            @php $offset = ($i - 1) * $perPage; @endphp
                            @if($i == $currentPage)
                                <li class="page-item active">
                                    <a class="page-link">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ route('list.product', [$id_category, $offset]) }}">
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                    </a>
                                </li>
                            @endif
                        @endfor

                        {{-- Tombol Berikutnya --}}
                        @if($currentPage < $totalPages)
                            <li class="page-item">
                                <a class="page-link" href="{{ route('list.product', [$id_category, $currentPage * $perPage]) }}">
                                    Berikutnya <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div><!-- Pagination Wrap -->
            @endif

        </div>
    </div>
</section>
@endsection