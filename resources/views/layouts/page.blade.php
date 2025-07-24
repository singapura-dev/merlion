@extends('merlion::layouts.html')

@section('content')
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="#" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{admin()->getBrandLogoSmallDark()}}" alt="" height="22">
                        </span>
                                <span class="logo-lg">
                            <img src="{{admin()->getBrandLogoDark()}}" alt="" height="17">
                        </span>
                            </a>

                            <a href="#" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{admin()->getBrandLogoSmall()}}" alt="" height="22">
                        </span>
                                <span class="logo-lg">
                            <img src="{{admin()->getBrandLogo()}}" alt="" height="17">
                        </span>
                            </a>
                        </div>

                        <button type="button"
                                class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none"
                                id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="dropdown ms-1 topbar-head-dropdown header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-translate fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                @foreach(config('merlion.languages') as $lang)
                                    <a href="{{route('admin.lang', $lang['key'])}}"
                                       class="dropdown-item language py-2">
                                        <i class="flag flag-country-{{$lang['flag']}} flag-xs me-1 rounded"></i>
                                        <span class="align-middle">{{$lang['label']}}</span>
                                        @if(app()->getLocale() == $lang['key'])
                                            <span class="float-end text-success"><i class="ri-check-line"></i></span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button"
                                    class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle"
                                    data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                 src="{{auth()->user()->avatar ?? '/vendor/merlion/images/users/user-dummy-img.jpg' }}"
                                 alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{auth()->user()->name}}</span>
                            </span>
                        </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i
                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">Profile</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('admin.logout')}}">
                                    <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">{{__('merlion::base.logout')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="#" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="/vendor/merlion/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="/vendor/merlion/images/logo-dark.png" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="#" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="/vendor/merlion/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="/vendor/merlion/images/logo-light.png" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                        id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
            @include('merlion::layouts.partials.sidebar')

        </div>
        <!-- Left Sidebar End -->

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @if($self->title || $self->back)
                        <div class="row">
                            <div class="col-12">
                                <div
                                    class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 align-items-center">
                                        @if($backUrl = $self->getBack())
                                            <a class="me-1" href="{{$backUrl}}">
                                                <i class="ri-arrow-left-line px-1 py-0 ri-arrow-left-line"></i></a>
                                        @endif
                                        {!! $self->getTitle() !!}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    @endif
                    @include('merlion::layouts.content', ['content' => $self->getContent()])
                </div>
                <!-- container-fluid -->
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            {{date('Y')}} © Merlion.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Merlion
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
@endsection
