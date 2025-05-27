<script>
    var BASE_URL = "{{ url('/') }}";
    var hostUrl = "{{ asset('assets/user/') }}";
    var css_btn_confirm = 'btn btn-primary';
    var css_btn_cancel = 'btn btn-danger';
    var csrf_token = "{{ csrf_token() }}";
    var base_foto = "{{image_check('notfound.jpg','default') }}";
    var user_base_foto = "{{image_check('user.jpg','default') }}";
    var div_loading = '<div class="logo-spinner-parent">\
                    <div class="logo-spinner">\
                        <div class="logo-spinner-loader"></div>\
                    </div>\
                    <p id="text_loading">Tunggu sebentar...</p>\
                </div>';
    addEventListener('keypress', function(e) {
        if (e.keyCode === 13 || e.which === 13) {
            e.preventDefault();
            return false;
        }
    });
</script>
<script src="{{ asset('assets/user/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/user/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/user/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/user/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/user/js/counterup.min.js') }}"></script>
<script src="{{ asset('assets/user/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('assets/user/js/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/user/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/user/js/owl.js') }}"></script>
<script src="{{ asset('assets/user/js/custom-scripts.js') }}"></script>
<script src="{{ asset('assets/public/js/mekanik.js') }}"></script>
<script src="{{ asset('assets/public/js/function.js') }}"></script>
<script src="{{ asset('assets/public/js/global.js') }}"></script>
<script src="{{ asset('assets/public/js/alert/sweetalert2.min.js') }}"></script>