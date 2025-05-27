@extends('layouts.auth')

@section('content')
<div class="d-flex flex-column flex-root">
    <!--begin::Page bg image-->
    <style>
      body { 
         background-color: var(--bs-soft-primary); 
      } 
   </style>
   <!--end::Page bg image-->
    <!--begin::Authentication - Sign-up -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center align-items-center">
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <!--begin::Wrapper-->
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-700px p-10">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-500px">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                        <!--begin::Form-->
                        <form class="form w-100" method="POST"  novalidate="novalidate" id="form_register" action="{{ route('register.process') }}">
                             @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                @if(isset($setting->landing_logo) && file_exists(public_path('data/setting/'.$setting->landing_logo)))
                                <img src="{{ image_check($setting->landing_logo,'setting') }}" alt="Logo" width="180px">
                                @endif
                                <!--begin::Title-->
                                <p style="color : #5B5A5A;" class="fw-bold mt-2 fs-5">Manajemen Keuangan dan Produk untuk Toko Onemens Leather</p>
                                <!--end::Title-->
                            </div>
                            <!--begin::Input group=-->
                            <div class="fv-row mb-6">
                                <!--begin::Label-->
                                <label for="name" class="fw-semibold fs-6 mb-2">Nama Pengguna</label>
                                <!--end::Label-->
                                <!--begin::Email-->
                                <input type="text" placeholder="Masukkan nama pengguna" id="name" name="name" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            
                            
                            <!--begin::Input group-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-6">
                                <!--begin::Label-->
                                <label for="email" class="fw-semibold fs-6 mb-2">Alamat Email</label>
                                <!--end::Label-->
                                <!--begin::Email-->
                                <input type="email" id="email" placeholder="Masukkan alamat email" name="email" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <div class="fv-row mb-6" data-kt-password-meter="true">
                                <!--begin::Wrapper-->
                                <div class="mb-1">
                                    <!--begin::Input wrapper-->
                                    <div class="position-relative mb-3">
                                        <!--begin::Label-->
                                        <label for="password" class="fw-semibold fs-6 mb-2">Kata Sandi</label>
                                        <!--end::Label-->
                                        <input class="form-control bg-transparent" type="password" id="password" placeholder="Masukkan kata sandi" name="password" autocomplete="off" />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle end-0 me-n2" style="top: 70%;" data-kt-password-meter-control="visibility">
                                            <i class="ki-duotone ki-eye-slash fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                            <i class="ki-duotone ki-eye fs-2 d-none">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </div>
                                    <!--end::Input wrapper-->
                                    <!--begin::Meter-->
                                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-primary rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-primary rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-primary rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-primary rounded h-5px"></div>
                                    </div>
                                    <!--end::Meter-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Hint-->
                                <div class="text-muted">Kata sandi harus berisi minimal 8 karakter yang di antaranya terdapat huruf besar, kecil dan simbol</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group=-->
                            <!--end::Input group=-->
                            <div class="fv-row mb-6">
                                <!--begin::Label-->
                                <label for="repassword" class="fw-semibold fs-6 mb-2">Konfirmasi Kata Sandi</label>
                                <!--end::Label-->
                                <!--begin::Repeat Password-->
                                <input placeholder="Masukkan konfirmasi kata sandi" id="repassword" name="repassword" type="password" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Repeat Password-->
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-6">
                                <!--begin::Label-->
                                <label for="question" class="fw-semibold fs-6 mb-2">Pertanyaan Pemulihan</label>
                                <!--end::Label-->
                                <!--begin::Email-->
                                <input type="text" placeholder="Masukkan pertanyaan pemulihan" id="question" name="question" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--begin::Input group=-->
                            <div class="fv-row mb-6">
                                <!--begin::Label-->
                                <label for="answer" class="fw-semibold fs-6 mb-2">Jawaban Pemulihan</label>
                                <!--end::Label-->
                                <!--begin::Email-->
                                <input type="text" placeholder="Masukkan pertanyaan pemulihan" id="answer" name="answer" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="button_register" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Daftar</span>
                                    <!--end::Indicator label-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                            <!--begin::Sign up-->
                            <div class="text-gray-500 text-center fw-semibold fs-6">Sudah Punya Akun ?
                            <a href="{{ route('login') }}" class="link-primary fw-semibold">Masuk</a></div>
                            <!--end::Sign up-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-up-->
</div>
@endsection