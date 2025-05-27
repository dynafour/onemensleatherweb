<div class="card mb-5 mb-xl-8 w-100">
    <div class="d-flex flex-stack flex-wrap ms-10 mt-10">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column align-items-start">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold m-0 fs-3"><?= $title; ?></h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a class="text-gray-600 text-hover-primary">Periode</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600"><?= $filter; ?></li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--begin::Bodfidffy-->
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        @if($search == true) 
        <div class="d-flex align-items-center position-relative me-3 search_mekanik w-300px">
            <input type="text" name="search" class="form-control form-control-solid w-250px" aria-label="Cari" aria-describedby="button-cari-category" id="searchTable" placeholder="Cari" autocomplete="off">
        </div>
        @endif
    </div>
    <div class="card-body py-3">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <!--begin::Table head-->
                <thead>
                    <tr class="fw-bold text-muted">
                        @if($header)
                        @foreach($header AS $field)
                        <th class="min-w-120px">{{$field}}</th>
                        @endforeach
                        @endif
                    </tr>
                </thead>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Table container-->
    </div>
</div>