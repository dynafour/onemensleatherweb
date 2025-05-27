@extends('layouts.admin')

@section('content')


<div class="d-flex flex-column flex-column-fluid px-5">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <form id="kt_app_content_container" class="app-container container-fluid">
            <div class="row g-5 g-xl-10">
                <div id="width_main_pane" class="col-xl-12 d-flex">
                    <div class="card mb-5 mb-xl-8 flex-fill" style="min-height: 300px;">
                        <!--begin::Body-->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <!--begin::Page title-->
                            <div class="page-title d-flex align-items-center">
                                <!--begin::Title-->
                                <h1 class="d-flex text-primary fw-bold m-0 fs-3">Formulir Laporan</h1>
                                <!--end::Title-->
                            </div>
                        </div>
                        <div class="card-body py-3" >

                            <!--begin::Input group-->
                            <div class="row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-5 col-form-label fw-semibold fs-6">Data apa yang kamu perlukan?</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-7">
                                    <select name="tipe" id="tipe" class="form-select form-select-solid" onchange="select_tipe_report(this)" aria-describedby="select-data" data-control="select2" data-placeholder="Pilih tipe laporan">
                                        <option value=""></option>
                                        <option value="1">Daftar Barang</option>
                                        <option value="2">Daftar Stock</option>
                                        <option value="3">Daftar Transaksi</option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-5 col-form-label fw-semibold fs-6">Pilih periode waktu</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-7">
                                    <select name="periode" id="periode" class="form-select form-select-solid" onchange="set_periode(this)" aria-describedby="select-data" data-control="select2" data-placeholder="Pilih periode">
                                        <option value=""></option>
                                        <option value="1">Tanggal</option>
                                        <option value="2">Bulan</option>
                                        <option value="3">Tahun</option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                </div>
                <div id="pane_filter" class="col-xl-5 d-flex d-none">
                    <div class="card mb-5 mb-xl-8 flex-fill" style="min-height: 300px;">
                        <!--begin::Body-->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <!--begin::Page title-->
                            <div class="page-title d-flex align-items-center">
                                <!--begin::Title-->
                                <h1 class="d-flex text-primary fw-bold m-0 fs-3">Filter</h1>
                                <!--end::Title-->
                            </div>
                        </div>
                        <div class="card-body py-3" >
                            <div class="d-none mb-10" id="pane_filter_product">
                                <select name="id_product" id="id_product" class="form-select form-select-solid filter-input" data-control="select2" data-placeholder="Pilih Produk">
                                    <option value=""></option>
                                    @if($product)
                                    @foreach($product AS $row)
                                    <option data-name="{{ $row->name }}" value="{{ $row->id_product }}">{{ $row->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <!--begin::Input group-->
                            <div class="fv-row mb-10 filter-laporan d-none" id="pane_filter_tanggal">
                                <input class="form-control form-control-solid" id="tanggal" name="tanggal" placeholder="Pilih tanggal filter"/>
                            </div>
                            <!--end::Input group-->

                            <div  id="pane_filter_bulan" class="d-flex filter-laporan justify-content-between mb-10 d-none">
                                <div class="me-1" style="width : 200px">
                                <select name="start_month" id="start_month" onchange="pick_start_month(this)" class="form-select form-select-solid filter-input" data-control="select2" data-placeholder="Bulan awal">
                                    <option value=""></option>
                                    @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ getMonthById($i) }}</option>
                                    @endfor
                                </select>
                                </div>

                                <div class="ms-1" style="width : 200px">
                                <select name="end_month" id="end_month" class="form-select form-select-solid filter-input" data-control="select2" data-placeholder="Bulan akhir" disabled="true">
                                    <option value=""></option>
                                    @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ getMonthById($i) }}</option>
                                    @endfor
                                </select>
                                </div>
                            </div>
                            
                            <div id="pane_filter_tahun" class="d-none filter-laporan">
                                <select name="year" id="year" class=" form-select form-select-solid filter-input mb-10" data-control="select2" data-placeholder="Pilih tahun">
                                    <option value=""></option>
                                    @for ($year = 2024; $year <= date('Y'); $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor      
                                </select>
                            </div>
                            

                            <div class="w-100 d-flex justify-content-center align-items-center">
                                <button type="button" onclick="reset_form()" class="mx-4 btn btn-sm btn-danger">Reset</button>
                                <button type="button" onclick="cek_data()" class="mx-4 btn btn-sm btn-info">Cek</button>
                                <button type="button" onclick="cetak_excel()" id="button_cetak" class="mx-4 btn btn-sm btn-success d-none">Cetak</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DISPLAY TABLE -->
                <div id="display_report" class="col-xl-12 d-flex"></div>
            </div>
        </form>
    </div>
</div>
@endsection