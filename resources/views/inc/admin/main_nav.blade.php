@foreach(admin()->getMenus() as $menu)
    @if(!$menu->shouldRender())
        @continue
    @endif
    @php
        $sub_menus = $menu->getContent();
    @endphp
    <li class="nav-item {{$sub_menus ? "dropdown":""}}">
        <a class="nav-link {{$sub_menus ? "dropdown-toggle":""}}"
           @if(empty($sub_menus))
               href="{{$menu->getLink()}}"
           target="{{$menu->getTarget()}}"
           @else
               role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
            @endif
        >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
            {!! render($menu->getIcon()) !!}
            </span>
            <span class="nav-link-title">  {!! $menu->getLabel() !!} </span>
        </a>
        @if(!empty($sub_menus))
            <div class="dropdown-menu">
                @foreach($sub_menus as $sub_menu)
                    @if(!$sub_menu->shouldRender())
                        @continue
                    @endif
                    <a class="dropdown-item" href="{{$sub_menu->getLink()}}"
                       target="{{$menu->getTarget()}}">{!! render($sub_menu->getIcon()?:'') !!} {!! $sub_menu->getLabel() !!} </a>
                @endforeach
            </div>
        @endif
    </li>
@endforeach
