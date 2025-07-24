@php
    $nest = false;
    $sub_menus = $self->getContent();
    if(!empty($sub_menus)) {
        $nest = true;
    }
    $label = $self->getLabel();
    $link = $self->getLink();
@endphp

@if($title)
    <li class="menu-title">
        <span>{!! $label !!}</span>
    </li>
@else
    <li class="nav-item">
        <a
            @if($nest)
                href="#{{$id}}" data-bs-toggle="collapse" role="button" aria-expanded="false"
            @else
                href="{{$link}}"
            @endif
            class="nav-link menu-link">
            @if($icon)
                {!! render($icon) !!}
            @endif
            <span>{{$label}}</span>
        </a>
        @if(!empty($sub_menus))
            <div class="collapse menu-dropdown" id="{{$id}}">
                <ul class="nav nav-sm flex-column">
                    @foreach($sub_menus as $sub_menu)
                        {!! render($sub_menu) !!}
                    @endforeach
                </ul>
            </div>
        @endif
    </li>
@endif
