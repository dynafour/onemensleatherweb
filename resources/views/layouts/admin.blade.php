@php
    $role = session(config('session.prefix').'_id_role');
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
@endphp
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

    <!--begin::Fonts(mandatory for all pages)-->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet">
    <!--end::Fonts-->

    <!-- UNTUK SEO -->
    <link rel="icon" href="{{ image_check($setting->icon,'setting') }}?v={{ time() }}" type="image/x-icon">
    <!-- UNTUK CSS -->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/public/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/public/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/public/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/admin.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/public/css/custom_pribadi.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('assets/public/css/loading_custom.css') }}" rel="stylesheet" type="text/css" />
     <script src="https://kit.fontawesome.com/c772e3a5a0.js" crossorigin="anonymous"></script>
     <script type="text/javascript" src="{{ asset('assets/public/plugins/ckeditor5/ckeditor.js') }}"></script>
     <script>
        var CKEditor_tool = ["heading", "alignment","|",'fontSize','fontColor', 'fontBackgroundColor',"|", "bold", "italic", "link", "bulletedList", "numberedList", "|", "outdent", "indent", "|", "blockQuote", "insertTable", "mediaEmbed", "undo", "redo"];
         var font_color =  [
            {
                color: 'hsl(0, 0%, 0%)',
                label: 'Black'
            },
            {
                color : 'hsl(0, 0%, 100%)',
                label : 'White'
            },
            {
                color: 'hsl(0, 75%, 60%)',
                label: 'Red'
            },
            {
                color: 'hsl(120, 75%, 60%)',
                label: 'Green'
            },
            {
                color: 'hsl(240, 75%, 60%)',
                label: 'Blue'
            },
            {
                color: 'hsl(60, 75%, 60%)',
                label: 'Yellow'
            },
            {
                color: 'hsl(235, 85%, 35%)',
                label : 'Primary'
            }
        ];
    </script>
    <!--end::Global Stylesheets Bundle-->
    <?php
    if (isset($css_add) && is_array($css_add)) {
        foreach ($css_add as $css) {
            echo $css;
        }
    } else {
        echo (isset($css_add) && ($css_add != "") ? $css_add : "");
    }
    ?>

    <style>
        .cursor-pointer{
            cursor: pointer !important;
        }
        .cursor-disabled{
            cursor: not-allowed !important;
        }
        .cursor-scroll{
            cursor: all-scroll;
        }
        /* .form-control,
        .form-select{
            border : 1px solid var(--bs-gray-300) !important;
        } */
        .menu-accordion.active{
            color : #FF286B !important;
        }
        .swal2-textarea{
            color : #FFFFFF !important;
        }

        .background-partisi{
            background-position : center !important;
            background-repeat : no-repeat !important;
            background-size :cover !important;
        }
        .swal2-textarea {
            color : black !important;
        }
    </style>
</head>

<!--end::Head-->
<!--begin::Body-->
<body id="kt_app_body" <?= ($segment1 == 'pos') ? 'data-kt-app-sidebar-minimize="on"' : '';?> data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true"  data-kt-app-toolbar-enabled="true" class="app-default">
    <script>
		var defaultThemeMode = "light"; 
		var themeMode; 
		if ( document.documentElement ) { 
			if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { 
				themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); 
			} else { 
				if ( localStorage.getItem("data-bs-theme") !== null ) { 
					themeMode = localStorage.getItem("data-bs-theme"); 
				} else { 
					themeMode = defaultThemeMode; 
				} 
			} 
			if (themeMode === "system") { 
				themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
			} document.documentElement.setAttribute("data-bs-theme", themeMode); 
		}
		</script>

        @include('partials.admin.sidebar')
         @include('partials.admin.navbar')

        @yield('content')

        <div id="alert-container-noreload" class="alert-container-noreload"></div>
        <audio id="alert-sound-noreload" src="{{ image_check('notif.mp3','attr') }}"></audio>
        @include('partials.admin.embed')
        @include('partials.admin.loading')
        <!--begin::Javascript-->

        <script>
            var BASE_URL = "{{ url('/') }}";
            var hostUrl = "{{ asset('assets/admin/') }}";
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

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/public/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/public/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('assets/public/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!-- <script src="{{ asset('assets/public/js/.config-datatable.js'); }}"></script> -->
    <script src="{{ asset('assets/public/plugins/custom/vis-timeline/vis-timeline.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(used for this page only)-->
    <!-- <script src="{{ asset('assets/admin/js/custom/widgets.js'); }}"></script> -->
    <script src="{{ asset('assets/admin/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom/utilities/modals/create-campaign.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom/utilities/modals/users-search.js') }}"></script>

    <script src="{{ asset('assets/public/js/mekanik.js') }}"></script>
    <script src="{{ asset('assets/public/js/function.js') }}"></script>
    <script src="{{ asset('assets/public/js/global.js') }}"></script>
    <script src="{{ asset('assets/admin/js/modul/mekanik.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom/javascript_pribadi.js') }}"></script>
    
    <script>
        $('[data-kt-menu-trigger="click"]').on('click', function () {
            var menu = KTMenu.getInstance(this);
            if (menu) {
                menu.toggle();
            }
        });

        function set_sidebar() {
            document.getElementById('kt_app_sidebar').classList.toggle('drawer-start');
        }

    </script>

    @if (Request::is('product'))
        <script src="{{ asset('assets/admin/js/modul/manajemen/product.js') }}"></script>
    @endif

     @if (Request::is('category'))
        <script src="{{ asset('assets/admin/js/modul/manajemen/category.js') }}"></script>
    @endif


    @if (Request::is('comment'))
        <script src="{{ asset('assets/admin/js/modul/manajemen/comment.js') }}"></script>
    @endif

     @if (Request::is('transaksi'))
        <script src="{{ asset('assets/admin/js/modul/transaksi/transaksi.js') }}"></script>
    @endif

    @if (Request::is('report'))
        <script src="{{ asset('assets/admin/js/modul/transaksi/laporan.js') }}"></script>
    @endif

    </body>
    <!--end::Body-->

</html>
