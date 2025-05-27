@extends('layouts.admin')

@section('content')

<div class="d-flex flex-column flex-column-fluid px-5">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10">
                <div class="card mb-5 mb-xl-8">
                    <div class="d-flex flex-stack flex-wrap ms-10 mt-10">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column align-items-start">
                            <!--begin::Title-->
                            <h1 class="d-flex text-dark fw-bold m-0 fs-3">Data Produk</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">
                                    <a class="text-gray-600 text-hover-primary">Manajemen</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">Produk</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <!--begin::Body-->
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <div class="d-flex align-items-center position-relative me-3 search_mekanik w-300px">
                            <input type="text" name="search" class="form-control form-control-solid w-250px" aria-label="Cari" aria-describedby="button-cari-product" id="searchTable" placeholder="Cari" autocomplete="off">
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Add product-->
                             <button type="button" class="btn btn-sm btn-success" onclick="tambah_data()" data-bs-toggle="modal" data-bs-target="#kt_modal_product">
                                <i class="ki-duotone ki-plus fs-2"></i>Tambah Produk</button>
                            <!--end::Add product-->
                        </div>
                    </div>
                    <div class="card-body py-3" id="base_table">
                        <!--begin::Table container-->
                        <div class="table-responsive" id="reload_table">
                            <!--begin::Table-->
                            <table id="productTable" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th class="min-w-50px">No</th>
                                        <th class="min-w-120px">Kode</th>
                                        <th class="min-w-150px">Nama Barang</th>
                                        <th class="min-w-120px">Kategori</th>
                                        <th class="min-w-100px">Total Penjualan</th>
                                        <th class="min-w-100px">Stok Tersedia</th>
                                        <th class="min-w-100px text-center">Status</th>
                                        <th class="min-w-100px text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>

<!-- Modal Tambah product -->
<div class="modal fade" id="kt_modal_product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal" data-title="Edit Produk|Tambah Produk"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_product" class="form"  method="POST" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column me-n7 pe-7" id="#">
                        
                        <div id="lead"></div>

                        <!--begin::Input group-->
                        <div class="fv-row mb-7 d-flex justify-content-center align-items-center flex-column">
                            <!--begin::Label-->
                            <label class="d-block fw-semibold fs-6 mb-5 required">Gambar</label>
                            <!--end::Label-->
                            <!--begin::Image input-->
                            <div class="image-input" data-kt-image-input="true" style="background-image: url('<?= image_check('notfound.jpg','default') ?>')">
                                <!--begin::Image preview wrapper-->
                                <div id="display_image" class="image-input-wrapper w-200px h-200px" style="background-image: url('<?= image_check('notfound.jpg','default') ?>')"></div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Ubah Foto">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                                    <!--begin::Inputs-->
                                    <input type="file" id="product_file" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <input type="hidden" name="name_image">
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_foto" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Batalkan Foto">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_foto" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Hapus Foto">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Remove button-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Tipe: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group-->
                        <div class="fv-row mb-7 d-none" id="req_code">
                            <!--begin::Input-->
                            <input type="text" name="code" class="form-control form-control-solid mb-3 mb-lg-0 bg-secondary" readonly autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7" id="req_id_category">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Kategori</label>
                                    <!--end::Label-->
                                    <div>
                                        <select id="select_id_category" name="id_category" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kategori Produk">
                                            <option value="">Pilih Kategori Produk</option>
                                            @if($category)
                                                @foreach ($category as $row)
                                                    <option value="{{ $row->id_category }}" {{($row->status == 'N') ? 'disabled' : '';}}>{{$row->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <div class="col-md-6">
                                 <!--begin::Input group-->
                                <div class="fv-row mb-7" id="req_material">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Bahan Produk</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="material" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Bahan Produk" autocomplete="off" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id_product">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7" id="req_name">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Nama Produk</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Nama Produk" autocomplete="off" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7" id="req_size">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Ukuran Produk</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="size" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Ukuran Produk" autocomplete="off" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6" id="pane_stock">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7" id="req_stock">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Stok Awal</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="number" min="1" name="stock" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Stock Awal" autocomplete="off" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <div class="col-md-6" id="pane_color">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7" id="req_color">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Warna Produk</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="color" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Warna Produk" autocomplete="off" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                 <!--begin::Input group-->
                                <div class="fv-row mb-7" id="req_link">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Link Produk</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="link" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Link Produk" autocomplete="off" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <div class="col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7" id="req_price">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Harga Produk</label>
                                    <!--end::Label-->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="input-harga">Rp.</span>
                                        <input type="text" id="fake_price" onkeyup="matauang(this,'#real_price')" class="form-control mb-3 mb-lg-0" placeholder="Masukkan Harga Produk" aria-describedby="input-harga">
                                    </div>
                                    <!--begin::Input-->
                                    <input type="hidden" id="real_price" name="price" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>
                        
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_description">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Deskripsi Produk</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="description" id="description" cols="30" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Deskripsi Produk" rows="10"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        

                        <div id="management_stock">
                            <hr>
                            <!--begin::Input group-->
                            <div class="fv-row mb-7" id="req_addstock">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Tambah Stok</label>
                                <!--end::Label-->
                                <div class="input-group">
                                    <!--begin::Input-->
                                    <input type="number" min="1" name="addstock" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Tambahkan Stock" autocomplete="off" />
                                    <!--end::Input-->
                                    <button type="button" onclick="add_stock(this)" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-plus fs-3"></i>
                                    </button>
                                </div>
                                <div class="table-responsive mt-5">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Masuk</th>
                                                <th>Stock Masuk</th>
                                            </tr>
                                        </thead>
                                        <tbody id="display_table">
                                            <tr>
                                                <td colspan="2"><center>Tidak ada data stock</center></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>


                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" data-editor="description" id="submit_product" onclick="submit_form(this,'#form_product',1)" class="btn btn-primary">
                            <span class="indicator-label">Kirim</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="kt_modal_detail_product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_detail_modal"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <div class="row w-100">
                    <div class="col-md-5 d-flex justify-content-center pt-7">
                    <div id="display_image_detail" class="background-partisi image-input-wrapper w-250px h-250px" style="background-image : url('{{ image_check(`default.jpg`,`default`) }}')"></div> 
                    </div>
                    <div class="col-md-7">
                        <div class="table-responsive mt-5">
                            <table class="table table-striped mb-5">
                                <thead class="bg-primary">
                                    <tr>
                                        <th colspan="2" class="ps-2 text-white"><b>Detail Produk</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-2 min-w-150px">Harga</td>
                                        <td class="ps-2" id="detail_price"> - </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-2">Bahan</td>
                                        <td class="ps-2" id="detail_material"> - </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-2">Ukuran Produk</td>
                                        <td class="ps-2" id="detail_size"> - </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-2">Warma Produk</td>
                                        <td class="ps-2" id="detail_color"> - </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-2">Link Produk</td>
                                        <td class="ps-2" id="detail_link"> - </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-2">Deskripsi Produk</td>
                                        <td class="ps-2" id="detail_description"> - </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tanggal Masuk</th>
                                        <th>Stock Masuk</th>
                                    </tr>
                                </thead>
                                <tbody id="display_table_detail">
                                    <tr>
                                        <td colspan="2"><center>Tidak ada data stock</center></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
