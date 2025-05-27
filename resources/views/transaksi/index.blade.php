@extends('layouts.admin')

@section('content')

<div class="d-flex flex-column flex-column-fluid px-5">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row g-5 g-xl-10">
                <div class="card mb-5 mb-xl-8">
                    <div class="card-body">
                        <div class="row w-100">
                            <div class="fv-row col-xl-3 d-flex flex-column">
                                <!--begin::Label-->
                                <label class="fw-bold fs-4 mb-2">Unggah File (xls)</label>
                                <!--end::Label-->
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#kt_modal_transaction" style="max-width : 90px;">Unggah</button>
                            </div>
                            <div class="col-xl-2"></div>
                            <div class="col-xl-7 row">
                                <!--begin::Label-->
                                <label class="fw-bold fs-4 mb-2">Cari Tanggal</label>
                                <!--end::Label-->
                                <div class="col-xl-10 d-flex justify-content-arround">
                                    <div class="me-2 position-relative">
                                        <input type="text" value="{{ $date['start'] }}" id="start_date" style="width : 220px;" name="start_date" class="form-control mb-3 mb-lg-0"  placeholder="Masukkan Tanggal Mulai" autocomplete="off" >
                                        <i class="fa-solid fa-calendar-days fs-5 position-absolute" style="right : 13px; top : 30%;"></i>
                                    </div>
                                    <div class="ms-2 position-relative">
                                        <input type="text" value="{{ $date['end'] }}" id="end_date" style="width : 220px;" name="end_date" class="form-control mb-3 mb-lg-0"  placeholder="Masukkan Tanggal Selesai" autocomplete="off" >
                                        <i class="fa-solid fa-calendar-days fs-5 position-absolute" style="right : 13px; top : 30%;"></i>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <button class="btn btn-sm btn-info" type="button" id="dateFilter" style="height : 40px;width : 90px;">Cari</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <!--begin::Row-->
            <div class="row g-5 g-xl-10">
                <div class="card mb-5 mb-xl-8">
                    <div class="d-flex flex-stack flex-wrap ms-10 mt-10">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column align-items-start">
                            <!--begin::Title-->
                            <h1 class="d-flex text-dark fw-bold m-0 fs-3">Data Transaksi</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">
                                    <a class="text-gray-600 text-hover-primary">Manajemen</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">Transaksi</li>
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
                            <input type="text" name="search" class="form-control form-control-solid w-250px" aria-label="Cari" aria-describedby="button-cari-transaction" id="searchTable" placeholder="Cari" autocomplete="off">
                        </div>
                        <div class="card-toolbar">
                        </div>
                    </div>
                    <div class="card-body py-3" id="base_table">
                        <!--begin::Table container-->
                        <div class="table-responsive" id="reload_table">
                            <!--begin::Table-->
                            <table id="transactionTable" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th class="min-w-100px">No. TRX</th>
                                        <th class="min-w-100px">Kategori</th>
                                        <th class="min-w-150px">Nama Produk</th>
                                        <th class="min-w-150px">QTY</th>
                                        <th class="min-w-150px">Harga</th>
                                        <th class="min-w-150px">Username Pelanggan</th>
                                        <th class="min-w-150px">Alamat</th>
                                        <th class="min-w-150px">Tanggal Pengiriman</th>
                                        <th class="min-w-150px">Sisa Stok</th>
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

<!-- Modal Tambah transaction -->
<div class="modal fade" id="kt_modal_transaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal" data-title="Edit Produk|Tambah Produk"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_transaction" class="form" action="{{ route('transaction.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column me-n7 pe-7" id="#">
                        
                        <div id="lead"></div>
                        <a target="_BLANK" href="{{ image_check('format_import_excel.xlsx','setting') }}" class="btn btn-sm btn-success">Unduh Format Excel</a>
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_file">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">File Import</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="file" name="file" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan File Excel" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_transaction" onclick="submit_form(this,'#form_transaction')" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>

@endsection
