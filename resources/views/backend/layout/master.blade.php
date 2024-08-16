<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href=""/>
    <title>@yield('page_title') | Soul Housing</title>
    <meta charset="utf-8"/>
    <meta
        content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel versions. Grab your copy now and get life-time updates for free."
        name="description"/>
    <meta
        content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon"
        name="keywords"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="en_US" property="og:locale"/>
    <meta content="article" property="og:type"/>
    <meta
        content="Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel Admin Dashboard Theme"
        property="og:title"/>
    <meta content="https://keenthemes.com/metronic" property="og:url"/>
    <meta content="Keenthemes | Metronic" property="og:site_name"/>
    <link href="https://preview.keenthemes.com/metronic8" rel="canonical"/>
    <link href="{{asset('backend/assets/media/logos/favicon.ico')}}" rel="shortcut icon"/>
    <!--begin::Fonts(mandatory for all pages)-->
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" rel="stylesheet"/>
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{asset('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('backend/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{asset('backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('backend/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css"/>
    <!--end::Global Stylesheets Bundle-->
    <style>
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link .menu-title {
            color: #000;
            border-bottom: 1px solid;
        }

        .app-sidebar-menu {
            background-color: #307bc4;
        }

        /* Basic button styling */
        #load-more-button {
            position: relative;
            transition: width 0.3s;
        }

        /* Loading animation styling */
        #load-more-button.loading::after {
            content: '';
            position: absolute;
            left: 10px;
            top: 35%;
            width: 16px;
            height: 16px;
            border: 2px solid #fff;
            border-radius: 50%;
            border-top: 2px solid #000;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .dt-input:focus,
        .dt-input:focus-visible {
            outline: none !important;
        }

        div.dt-container .dt-search input {
            background-color: var(--kt-input-solid-bg);
            border-color: var(--kt-input-solid-bg);
            color: var(--kt-input-solid-color);
            transition: color .2s ease;
            padding: 8px;
            border: 1px solid #e9e9e9;

        }


    </style>
    @yield('custom_css')
</head>
<!--end::Head-->
<!--begin::Body-->
<body class="app-default" data-kt-app-header-fixed="true" data-kt-app-layout="dark-sidebar"
      data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
      data-kt-app-sidebar-push-footer="true" data-kt-app-sidebar-push-header="true"
      data-kt-app-sidebar-push-toolbar="true" data-kt-app-toolbar-enabled="true" id="kt_app_body">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-theme-mode");
        } else {
            if (localStorage.getItem("data-theme") !== null) {
                themeMode = localStorage.getItem("data-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-theme", themeMode);
    }</script>
<!--end::Theme mode setup on page load-->
<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Header-->
        @include('backend.inc.header')
        <!--end::Header-->
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <!--begin::Sidebar-->
            @include('backend.inc.sidebar')
            <!--end::Sidebar-->
            <!--begin::Main-->
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">
                    <!--begin::Toolbar-->
                    @include('backend.inc.breadcrumbs')
                    <!--end::Toolbar-->
                    <!--begin::Content-->
                    <div class="app-content flex-column-fluid" id="kt_app_content">
                        <!--begin::Content container-->
                        @yield('content')
                        <!--end::Content container-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Content wrapper-->
                <!--begin::Footer-->
                @include('backend.inc.footer')
                <!--end::Footer-->
            </div>
            <!--end:::Main-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::App-->
<!--begin::Drawers-->

<!--begin::Scrolltop-->
<div class="scrolltop" data-kt-scrolltop="true" id="kt_scrolltop">
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
    <span class="svg-icon">
				<svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
					<rect fill="currentColor" height="2" opacity="0.5" rx="1" transform="rotate(90 13 6)" width="13"
                          x="13"
                          y="6"/>
					<path
                        d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                        fill="currentColor"/>
				</svg>
			</span>
    <!--end::Svg Icon-->
</div>
<!--end::Scrolltop-->
<!--begin::Javascript-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('backend/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('backend/assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="{{asset('backend/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('backend/assets/js/custom/apps/user-management/users/list/table.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/apps/user-management/users/list/export-users.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/apps/user-management/users/list/add.js')}}"></script>
<script src="{{asset('backend/assets/js/widgets.bundle.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/widgets.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/utilities/modals/create-app.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/utilities/modals/new-target.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/utilities/modals/users-search.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('backend/assets/js/custom/apps/ecommerce/catalog/save-product.js')}}"></script>
<script src="{{asset('backend/assets/plugins/custom/formrepeater/formrepeater.bundle.js')}}"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>

<!--end::Custom Javascript-->
<!--end::Javascript-->
<script>
    $(document).ready(function () {
        $('table').DataTable({
            "paging": true,
            "pageLength": 10,
            "lengthChange": false,
            "ordering": false
        });
    });


    @if(Session::has('success'))
        toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toastr-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    toastr.success("Success", "{{Session::get('success')}}");
    @endif

        @if(Session::has('error'))
        toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toastr-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    toastr.error("Error", "{{Session::get('error')}}");
    @endif

    $('.kt_add_data_modal').submit(function () {
        $('.kt_add_data_modal').find('button[type="submit"]').attr('disabled', true);
        $('.kt_add_data_modal').find('button[type="submit"]').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
    });
    $('[data-kt-users-modal-action="cancel"]').on('click', function () {
        // Find the closest modal and hide it
        var $modal = $(this).closest('.modal');
        var modal = bootstrap.Modal.getInstance($modal[0]);
        modal.hide();
    });
</script>
@yield('custom_js')
</body>
<!--end::Body-->
</html>
