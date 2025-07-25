@php
    $nest = false;
    $sub_menus = $self->getContent();
    if(!empty($sub_menus)) {
        $nest = true;
    }
    $label = $self->getLabel();
    $link = $self->getLink();
    $icon = $self->getIcon();
@endphp

@if($title)
    <li class="menu-title">
        <span>{!! $label !!}</span>
    </li>
@else
    <li class="nav-item @if($nest) dropdown @endif">
        <a
            @if($nest)
                href="#{{$id}}" data-bs-toggle="dropdown" role="button" aria-expanded="false"
            class="nav-link dropdown-toggle"
            @else
                href="{{$link}}" class="nav-link "
            @endif
        >
            @if($icon)
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                {!! render($icon) !!}
                </span>
            @endif
            <span class="nav-link-title">{{$label}}</span>
        </a>
        @if(!empty($sub_menus))
            <div class="dropdown-menu" data-bs-popper="static" id="{{$id}}">
                @foreach($sub_menus as $sub_menu)
                    <a href="{{$sub_menu->getLink()}}" class="dropdown-item">
                        @if($sub_menu_icon = $sub_menu->getIcon())
                            <span class="nav-link-icon">
                                {!! render($sub_menu_icon) !!}
                            </span>
                        @endif
                        {{$sub_menu->getLabel()}}</a>
                @endforeach
            </div>
        @endif
    </li>
@endif
