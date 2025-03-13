<!DOCTYPE html>

<html lang="fr">

<head>
    <title></title>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="{{ url('assets/fav.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
</head>

@php
    $url = '';
@endphp

<body id="kt_body" {{-- style="background-image: url('{{ url('assets/media/patterns/header-bg.jpg') }}')" --}} class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled bg-white">
    {{-- <body id="kt_body" style="background-image: url('assets/back.png')" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled"> --}}
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div id="kt_header" class="header align-items-stretch" data-kt-sticky="true"
                    data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <div class="container-xxl d-flex align-items-center">
                        <div class="d-flex topbar align-items-center d-lg-none ms-n2 me-3" title="Show aside menu">
                            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                                id="kt_header_menu_mobile_toggle">
                                <span class="svg-icon svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                            fill="black" />
                                        <path opacity="0.3"
                                            d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                            fill="black" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0">
                            <a href="">
                                <img alt="Logo" src="{{ url('assets/fav.png') }}" class="logo-default h-25px" />
                                {{-- <img alt="Logo" src="{{ url('assets/fav.png') }}" class="logo-sticky h-25px" /> --}}
                            </a>
                        </div>
                        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                            <div class="d-flex align-items-stretch" id="kt_header_nav">
                                @include('layouts.menu')
                                {{-- <div class="header-menu align-items-stretch" data-kt-drawer="true"
                                    data-kt-drawer-name="header-menu"
                                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                                    data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                                    data-kt-drawer-direction="start"
                                    data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                                    data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                                    <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
                                        id="#kt_header_menu" data-kt-menu="true">

                                        <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"
                                            class="menu-item menu-lg-down-accordion me-lg-1">
                                            <span class="menu-link py-3">
                                                <span class="menu-title">BIC</span>
                                                <span class="menu-arrow d-lg-none"></span>
                                            </span>
                                            <div
                                                class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">

                                                <div class="menu-item">
                                                    <a class="menu-link py-3" href="{{ route('bic_trt') }}">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">CNMAJ</span>
                                                    </a>
                                                </div>

                                                <div class="menu-item">
                                                    <a class="menu-link py-3" href="{{ route('bic.chargement') }}">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">Chargement bic</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link py-3" href="{{ route('bic_trt') }}">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">Traitement bic</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--end::Menu-->
                                </div> --}}
                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::Navbar-->
                            <!--begin::Topbar-->
                            <div class="d-flex align-items-stretch flex-shrink-0">
                                <!--begin::Toolbar wrapper-->
                                <div class="topbar d-flex align-items-stretch flex-shrink-0">


                                    <!--end::Notifications-->
                                    <!--begin::Chat-->
                                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                                        <!--begin::Menu wrapper-->
                                        <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px"
                                            id="kt_drawer_chat_toggle">
                                            <!--begin::Svg Icon | path: icons/duotune/communication/com012.svg-->
                                            <span class="svg-icon svg-icon-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                        d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z"
                                                        fill="black" />
                                                    <rect x="6" y="12" width="7" height="2" rx="1"
                                                        fill="black" />
                                                    <rect x="6" y="7" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <span
                                                class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
                                        </div>
                                        <!--end::Menu wrapper-->
                                    </div>
                                    <!--end::Chat-->

                                    <!--begin::User-->
                                    <div class="d-flex align-items-center me-n3 ms-1 ms-lg-3"
                                        id="kt_header_user_menu_toggle">
                                        <!--begin::Menu wrapper-->
                                        <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                            data-kt-menu-placement="bottom-end">
                                            <img class="h-30px w-30px rounded"
                                                src="{{ url('assets/media/avatars/150-25.jpg') }}" alt="" />
                                        </div>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content d-flex align-items-center px-3">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px me-5">
                                                        <img alt="Logo"
                                                            src="{{ url('assets/media/avatars/150-25.jpg') }}" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Username-->
                                                    <div class="d-flex flex-column">
                                                        <div class="fw-bolder d-flex align-items-center fs-5">Max Smith
                                                            <span
                                                                class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span>
                                                        </div>
                                                        <a href="#"
                                                            class="fw-bold text-muted text-hover-primary fs-7">max@kt.com</a>
                                                    </div>
                                                    <!--end::Username-->
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator my-2"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="../../demo2/dist/account/overview.html"
                                                    class="menu-link px-5">My Profile</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="../../demo2/dist/pages/projects/list.html"
                                                    class="menu-link px-5">
                                                    <span class="menu-text">My Projects</span>
                                                    <span class="menu-badge">
                                                        <span
                                                            class="badge badge-light-danger badge-circle fw-bolder fs-7">3</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5" data-kt-menu-trigger="hover"
                                                data-kt-menu-placement="left-start">
                                                <a href="#" class="menu-link px-5">
                                                    <span class="menu-title">My Subscription</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <!--begin::Menu sub-->
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../../demo2/dist/account/referrals.html"
                                                            class="menu-link px-5">Referrals</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../../demo2/dist/account/billing.html"
                                                            class="menu-link px-5">Billing</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../../demo2/dist/account/statements.html"
                                                            class="menu-link px-5">Payments</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../../demo2/dist/account/statements.html"
                                                            class="menu-link d-flex flex-stack px-5">Statements
                                                            <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                data-bs-toggle="tooltip"
                                                                title="View your statements"></i></a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu separator-->
                                                    <div class="separator my-2"></div>
                                                    <!--end::Menu separator-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content px-3">
                                                            <label
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <input class="form-check-input w-30px h-20px"
                                                                    type="checkbox" value="1" checked="checked"
                                                                    name="notifications" />
                                                                <span
                                                                    class="form-check-label text-muted fs-7">Notifications</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="../../demo2/dist/account/statements.html"
                                                    class="menu-link px-5">My Statements</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator my-2"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5" data-kt-menu-trigger="hover"
                                                data-kt-menu-placement="left-start">
                                                <a href="#" class="menu-link px-5">
                                                    <span class="menu-title position-relative">Language
                                                        <span
                                                            class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">English
                                                            <img class="w-15px h-15px rounded-1 ms-2"
                                                                src="assets/media/flags/united-states.svg"
                                                                alt="" /></span></span>
                                                </a>
                                                <!--begin::Menu sub-->
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../../demo2/dist/account/settings.html"
                                                            class="menu-link d-flex px-5 active">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="assets/media/flags/united-states.svg"
                                                                    alt="" />
                                                            </span>English</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../../demo2/dist/account/settings.html"
                                                            class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="assets/media/flags/spain.svg"
                                                                    alt="" />
                                                            </span>Spanish</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../../demo2/dist/account/settings.html"
                                                            class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="assets/media/flags/germany.svg"
                                                                    alt="" />
                                                            </span>German</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../../demo2/dist/account/settings.html"
                                                            class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="assets/media/flags/japan.svg"
                                                                    alt="" />
                                                            </span>Japanese</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../../demo2/dist/account/settings.html"
                                                            class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="assets/media/flags/france.svg"
                                                                    alt="" />
                                                            </span>French</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5 my-1">
                                                <a href="../../demo2/dist/account/settings.html"
                                                    class="menu-link px-5">Account Settings</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="../../demo2/dist/authentication/flows/basic/sign-in.html"
                                                    class="menu-link px-5">Sign Out</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator my-2"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <div class="menu-content px-5">
                                                    <label
                                                        class="form-check form-switch form-check-custom form-check-solid pulse pulse-success"
                                                        for="kt_user_menu_dark_mode_toggle">
                                                        <input class="form-check-input w-30px h-20px" type="checkbox"
                                                            value="1" name="mode"
                                                            id="kt_user_menu_dark_mode_toggle"
                                                            data-kt-url="../../demo2/dist/index.html" />
                                                        <span class="pulse-ring ms-n1"></span>
                                                        <span class="form-check-label text-gray-600 fs-7">Dark
                                                            Mode</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                        <!--end::Menu wrapper-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('toolbar')
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">

                        @yield('content')

                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Container-->
                <!--begin::Footer-->
                <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div
                        class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted fw-bold me-1">2024</span>
                            <a href="" target="_blank" class="text-gray-800 text-hover-primary">ORABANK
                                BENIN</a>
                        </div>

                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>




    <script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ url('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ url('assets/plugins/easypie.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ url('assets/js/sweetalert.js') }}"></script>

    <script src="{{ url('assets/global/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <script src="{{ url('assets/js/select2fr.js') }}"></script>

    @yield('js')
</body>
<!--end::Body-->

</html>
