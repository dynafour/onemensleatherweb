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
                  @if ($view == true)
                  <form class="form w-100" method="POST" novalidate="novalidate" id="form_confirm" action="{{ route('confirm.process') }}">
                    @else
                    <form class="form w-100" method="POST" novalidate="novalidate" id="form_forgot" action="{{ route('forgot.process') }}">
                    @endif
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
                     @if($view == false)
                     <!--begin::Input group-->
                     <div class="fv-row mb-6">
                         <!--begin::Label-->
                        <label for="email" class="fw-semibold fs-6 mb-2">Alamat Email</label>
                        <!--end::Label-->
                        <input type="email" id="email" placeholder="Masukkan alamat email" name="email" autocomplete="off" class="form-control bg-transparent" required/>
                     </div>
                     <!--end::Input group-->
                     @else
                     @if($user->question)
                     <div class="text-center mb-11 w-100">
                        <p class="text-muted fs-5">Silahkan jawab pertanyaan berikut sebagai konfirmasi bahwa anda adalah pemilik dari akun <span class="text-primary fw-bold">{{ $email }}</span></p>
                     </div>

                     <div class="text-center mb-11 w-100">
                        <i class="fw-bold text-dark fs-3">"{{ $user->question }}"</i>
                     </div>
                     <!--begin::Input group-->
                     <div class="fv-row mb-6">
                         <!--begin::Label-->
                        <label for="answer" class="fw-semibold fs-6 mb-2">Jawaban Pemulihan</label>
                        <!--end::Label-->
                        <input type="text" id="answer" placeholder="Masukkan jawaban pemulihan" name="answer" autocomplete="off" class="form-control bg-transparent" required/>
                        <input type="hidden" id="id_user" name="id_user" value="{{ $user->id_user }}">
                     </div>
                     <!--end::Input group-->
                     @else
                     <div class="w-100 alert alert-danger">Akun anda belum mendaftarkan pertanyaan untuk pemulihan! Pemulihan tidak bisa dilakukan. Silahkan hubungi admin</div>
                     @endif

                     @endif
                     <!--begin::Submit button-->
                     @if($view == false)
                     <div class="d-grid mb-10">
                        <button type="submit" id="button_forgot" class="btn btn-primary mt-5">
                           <span class="indicator-label">Konfirmasi</span>
                        </button>
                     </div>
                     @else

                     @if($user->question)
                     <div class="d-grid mb-10">
                        <button type="submit" id="button_confirm" class="btn btn-primary mt-5">
                           <span class="indicator-label">Konfirmasi</span>
                        </button>
                     </div>
                     <span class="text-danger fs-6">Nb : Link konfirmasi hanya berlaku 1 jam terhitung dari waktu konfirmasi email</span>
                     @else
                     <div class="d-grid mb-10">
                        <a role="button" href="{{ route('login') }}" class="btn btn-primary mt-5">
                           <span class="indicator-label">Kembali Ke Login</span>
                        </a>
                     </div>
                     @endif

                     @endif


                     @if ($view == false)
                     <!--end::Submit button-->
                     <div class="text-gray-500 text-center fw-semibold fs-6 mb-3">
                     <a href="{{ route('login') }}" class="link-primary">Kembali ke halaman login?</a></div>
                     <!-- <div class="text-gray-500 text-center fw-semibold fs-6">Belum memiliki akun? -->
                     <!-- <a href="{{ route('register') }}" class="link-primary">Daftar sekarang</a></div> -->
                     <!--end::Sign up-->
                     @endif
                      
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

<!-- Modal Tambah change_password -->
<div class="modal fade" id="change_password" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Ubah Kata Sandi</h1>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_change_password" class="form" action="{{ route('auth.change_password') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column me-n7 pe-7" id="#">
                        <div class="fv-row mb-6" data-kt-password-meter="true">
                            <!--begin::Wrapper-->
                            <div class="mb-1" id="req_password">
                                <!--begin::Input wrapper-->
                                <div class="position-relative mb-3" >
                                    @if($view == true && $user)
                                    <input type="hidden" id="id_user" name="id_user" value="{{ $user->id_user }}">
                                    @endif
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
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Input group=-->
                        <!--end::Input group=-->
                        <div class="fv-row mb-6" id="req_repassword">
                            <!--begin::Label-->
                            <label for="repassword" class="fw-semibold fs-6 mb-2">Konfirmasi Kata Sandi</label>
                            <!--end::Label-->
                            <!--begin::Repeat Password-->
                            <input placeholder="Masukkan konfirmasi kata sandi" id="repassword" name="repassword" type="password" autocomplete="off" class="form-control bg-transparent" />
                            <!--end::Repeat Password-->
                        </div>
                        <!--end::Input group=-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_change_password" onclick="submit_form(this,'#form_change_password')" class="btn btn-primary">
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
@endsection



