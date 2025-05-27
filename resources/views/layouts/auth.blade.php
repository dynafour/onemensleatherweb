<!DOCTYPE html>
<html lang="en" data-bs-theme-mode="light">
<head>
    <base href="{{ url('/') }}/"/>
    <title>{{ ucfirst(config('app.name')) }}{{ isset($title) ? ' | '.$title : '' }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <link rel="icon" href="{{ image_check($setting->icon,'setting') }}?v={{ time() }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="{{ asset('assets/public/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/public/css/loading_custom.css') }}" rel="stylesheet" type="text/css">
    <style>
        input::placeholder {
            color: #918F8F !important;
            opacity: 1; /* Pastikan tidak transparan */
        }
    </style>
</head>

<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center">
    <script>
        var defaultThemeMode = "light"; 
        var themeMode = document.documentElement.hasAttribute("data-bs-theme-mode") 
            ? document.documentElement.getAttribute("data-bs-theme-mode") 
            : (localStorage.getItem("data-bs-theme") ?? defaultThemeMode);

        if (themeMode === "system") { 
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    </script>

    @yield('content')
   

    <script>
        var BASE_URL = "{{ url('/') }}";
        var hostUrl = "{{ asset('assets/admin/') }}";
        var css_btn_confirm = 'btn btn-primary';
        var css_btn_cancel = 'btn btn-danger';
        var image_default = "{{ asset('assets/public/images/user.jpg') }}";
        var csrf_token = "{{ csrf_token() }}";
    </script>

    <script src="{{ asset('assets/public/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/public/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/public/js/mekanik.js') }}"></script>
    <script src="{{ asset('assets/public/js/function.js') }}"></script>
    <script src="{{ asset('assets/public/js/global.js') }}"></script>
    @if (Request::is('login'))
        <script src="{{ asset('assets/admin/js/modul/auth/login.js') }}"></script>
    @endif

     @if (Request::is('register'))
        <script src="{{ asset('assets/admin/js/modul/auth/register.js') }}"></script>
    @endif

    @if (Request::is('forgot-password'))
        @if (Request::has('token'))
            <script src="{{ asset('assets/admin/js/modul/auth/confirm.js') }}"></script>
        @else
            <script src="{{ asset('assets/admin/js/modul/auth/forgot.js') }}"></script>
        @endif
    @endif
</body>
</html>
