<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a class="nav-link" href="#">
                <div class="brand-logo h-28px">
                    @include(admin('merchant')->view('brand_logo'))
                </div>
            </a>
        </div>
        @include(admin('merchant')->view('user_nav'))
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav">
                @include(admin('merchant')->view('main_nav'))
            </ul>
        </div>
    </div>
</header>
