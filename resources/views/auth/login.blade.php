@extends('layouts.auth')

@section('content')
<div class="d-flex justify-content-center align-items-center flex-column flex-root">
   <!--begin::Page bg image-->
   <style>
      body { 
         background-color: var(--bs-soft-primary); 
      } 
   </style>
   <!--end::Page bg image-->
   <!--begin::Authentication - Sign-in -->
   <div class="d-flex flex-column flex-lg-row flex-column-fluid">
      <!--begin::Body-->
      <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
         <!--begin::Wrapper-->
         <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-700px p-10">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-500px">
               <!--begin::Wrapper-->
               <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                  <!--begin::Form-->
                  <form class="form w-100" method="POST" novalidate="novalidate" id="form_login" action="{{ route('login.process') }}">
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
                     <!--begin::Heading-->
                     <!--begin::Input group-->
                     <div class="fv-row mb-6">
                         <!--begin::Label-->
                        <label for="email" class="fw-semibold fs-6 mb-2">Alamat Email</label>
                        <!--end::Label-->
                        <input type="email" id="email" placeholder="Masukkan alamat email" name="email" autocomplete="off" class="form-control bg-transparent" required/>
                     </div>
                     <div class="fv-row mb-3" data-kt-password-meter="true">
                        <!--begin::Label-->
                        <label for="password" class="fw-semibold fs-6 mb-2">Kata Sandi</label>
                        <!--end::Label-->
                        <input type="password" id="password" onkeyup="hideye(this, '#hideye')" placeholder="Masukkan kata sandi" name="password" autocomplete="off" class="form-control bg-transparent" required/>
                        <span class="btn btn-sm btn-icon position-absolute translate-middle end-0 me-n2 d-none" id="hideye" style="top: 70%;" data-kt-password-meter-control="visibility">
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
                     <!--end::Input group-->
                     <!--begin::Submit button-->
                     <div class="d-grid mb-10">
                        <button type="submit" id="button_login" class="btn btn-primary mt-5">
                           <span class="indicator-label">Masuk</span>
                        </button>
                     </div>
                     <!--end::Submit button-->
                     <div class="text-gray-500 text-center fw-semibold fs-6 mb-3">
                     <a href="{{ route('forgot') }}" class="link-primary">Lupa Kata Sandi?</a></div>
                     <!-- <div class="text-gray-500 text-center fw-semibold fs-6">Belum memiliki akun? -->
                     <!-- <a href="{{ route('register') }}" class="link-primary">Daftar sekarang</a></div> -->
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
   <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
@endsection
