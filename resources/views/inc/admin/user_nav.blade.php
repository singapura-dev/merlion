<div class="navbar-nav flex-row order-md-last">
    <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu">
            <span class="avatar avatar-sm">
                <img src="{{auth()->user()->avatar ?? 'https://robohash.org/user'}}" alt="">
            </span>
            <div class="d-none d-xl-block ps-2">
                <div>{{auth()->user()->name ?? '-'}}</div>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            @foreach(admin()->getMenus('user') as $menu)
                @if($menu->getDivider())
                    <div class="dropdown-divider"></div>
                @else
                    <a class="dropdown-item" href="{{ $menu->getLink()}}">{!! $menu->getLabel() !!}</a>
                @endif
            @endforeach
            <a href="{{admin()->getRoute('logout')}}" class="dropdown-item">{{__('merlion::base.logout')}}</a>
        </div>
    </div>
</div>
