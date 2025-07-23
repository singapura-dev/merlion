<div id="scrollbar">
    <div class="container-fluid">
        <div id="two-column-menu"></div>
        <ul class="navbar-nav" id="navbar-nav">
            {!! render(admin()->getMenus()) !!}
        </ul>
{{--        <ul class="navbar-nav" id="navbar-nav">--}}
{{--            <li class="menu-title"><span>Menu</span></li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link menu-link" href="/" aria-expanded="false">--}}
{{--                    <i class="ri-dashboard-line"></i> <span>{{__('menu.dashboard')}}</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link menu-link" href="{{url('users')}}" aria-expanded="false">--}}
{{--                    <i class="ri-group-line"></i> <span>Users</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse"--}}
{{--                   role="button" aria-expanded="false" aria-controls="sidebarDashboards">--}}
{{--                    <i class="ri-apps-line"></i> <span data-key="t-dashboards">Apps</span>--}}
{{--                </a>--}}
{{--                <div class="collapse menu-dropdown" id="sidebarApps">--}}
{{--                    <ul class="nav nav-sm flex-column">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="/inertia" class="nav-link" data-key="t-analytics"> Baku </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="#" class="nav-link" data-key="t-crm"> CFO </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}
{{--        </ul>--}}
    </div>
    <!-- Sidebar -->
</div>
<div class="sidebar-background"></div>
