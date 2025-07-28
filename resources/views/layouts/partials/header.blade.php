<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <!-- BEGIN NAVBAR TOGGLER -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- END NAVBAR TOGGLER -->
        <!-- BEGIN NAVBAR LOGO -->
        <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="." aria-label="Logo">
                <img src="{{admin()->getBrandLogo()}}" class="maxh-24px" alt="">
            </a>
        </div>
        <!-- END NAVBAR LOGO -->
        <div class="navbar-nav flex-row order-md-last">
            <div class="d-none d-md-flex">
                <div class="nav-item dropdown d-none d-md-flex me-3">
                    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show language"
                       data-bs-auto-close="outside" aria-expanded="false">
                        <span class="fs-2">
                            <i class="ri-translate"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                        <div class="card">
                            <div class="list-group list-group-flush list-group-hoverable">
                                @foreach(config('merlion.languages') as $lang)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <i class="flag flag-xs flag-country-{{$lang['flag']}}"></i>
                                            </div>
                                            <div class="col">
                                                <a href="{{admin()->route('lang', $lang['key'])}}"
                                                   class="text-body d-block">{{$lang['label']}}</a>
                                            </div>
                                            <div class="col-auto">
                                                @if($lang['key'] == app()->getLocale())
                                                    <i class="ti ti-check"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown"
                   aria-label="Open user menu">
                            <span class="avatar avatar-sm">
                            <img src="{{auth()->user()->avatar ?? ''}}" alt="" class="w-100 h-100">
                            </span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{auth()->user()->name}}</div>
                        <div class="mt-1 small text-secondary">UI Designer</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="#" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{admin()->route('logout')}}" class="dropdown-item">{{__("merlion::base.logout")}}</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <!-- BEGIN NAVBAR MENU -->
            <ul class="navbar-nav" id="navbar-nav">
                {!! render(admin()->getMenus()) !!}
            </ul>
            <!-- END NAVBAR MENU -->
        </div>
    </div>
</header>
@pushonce('scripts')
    <script nonce="{{csp_nonce()}}">
        (function() {
            function initActiveMenu() {
                let currentPath = location.pathname;
                if (currentPath) {
                    let a = null;
                    let links = document.getElementById("navbar-nav")?.querySelectorAll("a") || [];
                    for (let p in links) {
                        let el = links[p];
                        let url = null;
                        try {
                            url = el.getAttribute('href');
                        } catch (e) {
                            continue;
                        }
                        if (!url) {
                            continue;
                        }
                        const match = url.match(/^https?:\/\/[^\/]+(.*)$/);
                        let href = match ? match[1] || '/' : url;
                        if (href === currentPath) {
                            a = el;
                            break;
                        }
                        if (currentPath.indexOf(href) !== -1) {
                            a = el;
                        }
                    }
                    if (a) {
                        var navItem = a.closest(".nav-item");
                        if (navItem) {
                            navItem.classList.add("active");
                        }
                        let parentCollapseDiv = a.closest(".collapse.menu-dropdown");
                        if (parentCollapseDiv) {
                            parentCollapseDiv.classList.add("show");
                            parentCollapseDiv.parentElement.children[0].classList.add("active");
                            parentCollapseDiv.parentElement.children[0].setAttribute("aria-expanded", "true");
                            if (parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown")) {
                                parentCollapseDiv.parentElement.closest(".collapse").classList.add("show");
                                if (parentCollapseDiv.parentElement.closest(".collapse").previousElementSibling)
                                    parentCollapseDiv.parentElement.closest(".collapse").previousElementSibling.classList.add("active");

                                if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse.menu-dropdown")) {
                                    parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").classList.add("show");
                                    if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling) {
                                        parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling.classList.add("active");
                                        if ((document.documentElement.getAttribute("data-layout") === "horizontal") && parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.closest(".collapse")) {
                                            parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling.classList.add("active")
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            window.addEventListener("load", function () {
                initActiveMenu();
            });
        })();
    </script>
@endpushonce
