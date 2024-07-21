<!DOCTYPE html>
<html lang="en">

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>@yield('title') | New Akademik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{ asset('assets/images/logo-ptjki.png') }}">

    <!--begin::Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> --}}
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('assets/metronics/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/metronics/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/metronics/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('assets/metronics/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('assets/metronics/css/style.dark.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('assets/metronics/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('assets/metronics/plugins/custom/leaflet/leaflet.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/metronics/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
  />
    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }
        .text-justify {
            text-align: justify;
        }
        .white_img{
            filter: contrast(1000%) invert(100%);
        }
        i{
            font-size: unset;
            color: unset;
        }

    </style>
    <style>
        .img_carousel{
            /* background-color: rgba(0, 0, 0, 0.445); */
            position: relative;
        }
        .img_carousel img{
            width: 100%;
            height: 600px;
            object-fit: cover;
            object-position: center;
        }
        .img_carousel::before{
            background-color: rgba(0, 0, 0, 0.445);
            content: "Preview";
            margin: auto;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }
    </style>
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    @stack('css')

</head>


<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <div id="kt_aside" class="aside aside-light aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
                data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
                data-kt-drawer-toggle="#kt_aside_mobile_toggle">
                <!--begin::Brand-->
                <div class="aside-logo flex-column-auto" id="kt_aside_logo">
                    <!--begin::Logo-->
                    <a href="#">
                        {{-- <img src="{{ asset('assets/metronics/media/logos/logo-2-dark.svg') }}" class="img-fluid w-100" alt="" srcset=""> --}}
                        {{-- New Akademik --}}
                    </a>
                    <!--end::Logo-->
                    <!--begin::Aside toggler-->
                    <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
                        data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                        data-kt-toggle-name="aside-minimize">
                        <!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-double-left.svg-->
                        <span class="svg-icon svg-icon-1 rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                        fill="#000000" fill-rule="nonzero"
                                        transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                                    <path
                                        d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.5"
                                        transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                                </g>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Aside toggler-->
                </div>
                <!--end::Brand-->
                <!--begin::Aside menu-->
                <div class="aside-menu flex-column-fluid">
                    <!--begin::Aside Menu-->
                    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
                        data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
                        data-kt-scroll-offset="0">
                        <!--begin::Menu-->
                        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                            id="#kt_aside_menu" data-kt-menu="true">
                            <div class="menu-item">
                                <div class="menu-content pt-8 pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">Dashboard</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('dashboard')" href="{{ url('dashboard') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-chart-pie"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Dashboard</h5>
                                </a>
                            </div>

                            @if (Auth::user()->role->key == "dosen")
                            <div class="separator separator-solid my-2"></div>

                            <div class="menu-item">
                                <div class="menu-content pt-8 pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">Perkuliahan</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('penilaian')" href="{{ route('penilaian.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-file-contract"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Penilaian</h5>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('kuisioner')" href="{{ route('kuisioner.index-dosen') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-edit"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Kuisioner</h5>
                                </a>
                            </div>
                            @endif

                            @if (Auth::user()->role->key == "mahasiswa")
                            <div class="separator separator-solid my-2"></div>

                            <div class="menu-item">
                                <div class="menu-content pt-8 pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">Perkuliahan</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('perwalian')" href="{{ route('perwalian.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-user-graduate"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Perwalian</h5>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('nilai')" href="{{ route('nilai.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-file-signature"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Nilai</h5>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('kuisioner')" href="{{ route('kuisioner.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-edit"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Kuisioner</h5>
                                </a>
                            </div>
                            @endif

                            @if (Auth::user()->role->key == "sekretariat")
                            <div class="separator separator-solid my-2"></div>

                            <div class="menu-item">
                                <div class="menu-content pt-8 pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">Perkuliahan</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('verifikasi-perwalian')" href="{{ route('validasi-perwalian.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-user-graduate"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Verifikasi Perwalian</h5>
                                </a>
                            </div>

                            <div class="separator separator-solid my-2"></div>

                            <div class="menu-item">
                                <div class="menu-content pt-8 pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">Management</span>
                                </div>
                            </div>
                            {{-- <div class="menu-item">
                                <a class="menu-link @yield('sekretariat')" href="{{ url('indexGaleri') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-users"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Sekretariat</h5>
                                </a>
                            </div> --}}
                            <div class="menu-item">
                                <a class="menu-link @yield('dosen')" href="{{ route('management.dosen.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-users"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Dosen</h5>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('mahasiswa')" href="{{ route('management.mahasiswa.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-users"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Mahasiswa</h5>
                                </a>
                            </div>

                            <div class="separator separator-solid my-2"></div>

                            <div class="menu-item">
                                <div class="menu-content pt-8 pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">Masterdata</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('jurusan')" href="{{ route('masterdata.jurusan.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-database"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Jurusan</h5>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('matakuliah')" href="{{ route('masterdata.matakuliah.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-database"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Matakuliah</h5>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('kuisioner')" href="{{ route('masterdata.kuisioner.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-database"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Kuisioner</h5>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link @yield('kuisioner')" href="{{ route('masterdata.respon-kuisioner.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lg fa-database"></i>
                                    </span>
                                    <h5 class="menu-title mt-2">Respon Kuisioner</h5>
                                </a>
                            </div>
                            @endif
                        </div>
                        <!--end::Menu-->
                    </div>
                </div>
                <!--end::Aside menu-->
            </div>

            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div id="kt_header" style="background: #28bced" class="header align-items-stretch">
                    <!--begin::Container-->
                    <div class="container-fluid d-flex align-items-stretch justify-content-between">
                        <!--begin::Aside mobile toggle-->
                        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
                            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                                id="kt_aside_mobile_toggle">
                                <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                                <span class="svg-icon svg-icon-2x mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                                            <path
                                                d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z"
                                                fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                        </div>
                        <!--end::Aside mobile toggle-->
                        <!--begin::Mobile logo-->
                        {{-- <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                            <a href="index.html" class="d-lg-none">
                                <img alt="Logo" src="assets/metronics/media/logos/logo-3.svg" class="h-30px" />
                            </a>
                        </div> --}}
                        <!--end::Mobile logo-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                            <!--begin::Navbar-->
                            <div class="d-flex align-items-stretch" id="kt_header_nav">
                                <!--begin::Menu wrapper-->
                                <div class="header-menu align-items-stretch" data-kt-drawer="true"
                                    data-kt-drawer-name="header-menu"
                                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                                    data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                                    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle"
                                    data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                                    <!--begin::Menu-->
                                    <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
                                        id="#kt_header_menu" data-kt-menu="true">
                                        {{-- <div class="menu-item me-lg-1">
                                            <a class="menu-link active py-3" href="index.html">
                                                <span class="menu-title">Dashboard</span>
                                            </a>
                                        </div> --}}
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::Navbar-->
                            <!--begin::Topbar-->
                            <div class="d-flex align-items-stretch flex-shrink-0">
                                <!--begin::Toolbar wrapper-->
                                <div class="d-flex align-items-stretch flex-shrink-0">
                                    <!--begin::Search-->
                                    <!--begin::Chat-->

                                    <!--end::Chat-->

                                    <!--begin::User-->
                                    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                                        <!--begin::Menu wrapper-->
                                        <div class="cursor-pointer symbol symbol-50px symbol-md-60px"
                                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                            data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                                            {{-- <img src="{{ asset('assets/images/logo-ptjki.png') }}" alt="name" /> --}}
                                            <i class="fas fa-user-circle text-white" style="font-size: 40px"></i>
                                        </div>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content d-flex align-items-center px-3">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px me-5">
                                                        <i class="fas fa-user-circle" style="font-size: 40px"></i>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Username-->
                                                    <div class="d-flex flex-column">
                                                        <span class="badge badge-light-success d-block fw-bolder fs-8">{{ Auth::user()->role->nama_role }}</span>
                                                        <div class="fw-bolder d-flex align-items-center fs-5">{{ Auth::user()->name }}</div>
                                                        <a href="javascript:void()" class="fw-bold text-muted text-hover-primary fs-7"></a>
                                                    </div>
                                                    <!--end::Username-->
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <div class="menu-item px-5">
                                                {{-- <a href="{{ url('admin.profile') }}" class="menu-link px-5">Profile</a> --}}
                                                <a href="javascript:void()" data-toggle="pill" data-bs-toggle="modal" data-bs-target="#logoutModal"
                                                    class="menu-link px-5">Sign Out</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                        <!--end::Menu wrapper-->
                                    </div>
                                    <div class="toolbar" id="kt_toolbar">
                                        <!--begin::Container-->
                                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                            <!--begin::Page title-->
                                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                                <!--begin::Title-->
                                                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">@yield('title')</h1>
                                                <!--end::Title-->
                                                <!--begin::Separator-->
                                                <span class="h-20px border-gray-200 border-start mx-4"></span>
                                                <!--end::Separator-->
                                            </div>
                                        </div>
                                        <!--end::Container-->
                                    </div>
                                    <!--end::User -->
                                </div>
                                <!--end::Toolbar wrapper-->
                            </div>
                            <!--end::Topbar-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Container-->
                </div>

                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                                {{-- <button type="button" class="btn-close btn-light text-white" data-bs-dismiss="modal"></button> --}}
                            </div>
                            <div class="modal-body">Klik tombol 'Logout' dibawah ini untuk keluar dari sesi</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                <a class="btn btn-primary bg-hover-danger" href="{{ url('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ url('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <div id="kt_content_container" class="container-fluid">
                            <!--begin::Row-->
                            @yield('content')
                        </div>

                    </div>
                </div>
                <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div
                        class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-grey-800 fw-bold me-1">{{ date('Y') }}©</span>
                            <b class="text-primary">New Akademik</b>
                        </div>
                        <!--end::Copyright-->
                    </div>
                    <!--end::Container-->
                </div>
            </div>
        </div>
    </div>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('assets/metronics/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{ asset('assets/metronics/js/scripts.bundle.js')}}"></script>
    <script src="{{ asset('assets/metronics/js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    {{-- <script src="{{ asset('assets/metronics/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script> --}}
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('assets/metronics/js/custom/widgets.js')}}"></script>
    {{-- <script src="{{ asset('assets/metronics/js/custom/apps/chat/chat.js')}}"></script> --}}
    <script src="{{ asset('assets/metronics/js/custom/modals/create-app.js')}}"></script>
    <script src="{{ asset('assets/metronics/js/custom/modals/upgrade-plan.js')}}"></script>
    <script src="{{ asset('assets/metronics/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckeditor/config.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            html: "{{ session('error') }}",
        });
    </script>
    @endif
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            html: "{{ session('success') }}",
        });
    </script>
    @endif
    @if($errors->any())
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        html: '@foreach($errors->all() as $error) {!! $error."<br>" !!}@endforeach',
    })
    </script>
    @endif
    <script>
        function ajaxDelete(url){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success ml-2',
                    cancelButton: 'btn btn-danger'
                },
                    buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Anda Yakin?',
                text: "Tindakan ini tidak dapat diurungkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type    : 'DELETE',
                        url     : url,
                        data    : {_token   : "{{ csrf_token() }}"},
                        success: function (data) {
                            if(data.status == 'success'){
                                swalWithBootstrapButtons.fire(
                                'Dihapus!',
                                data.message,
                                'success'
                            )}
                            else{
                                swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    html: data.message
                                });
                            }
                            $('#table').DataTable().ajax.reload();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Dibatalkan',
                        'Data tidak jadi dihapus :',
                        'error')
                }
            })
        }
    </script>
    @stack('js')

    @yield('alerts')

</body>

</html>
