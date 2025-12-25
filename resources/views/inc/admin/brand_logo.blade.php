<a class="nav-link" href="{{admin()->getRoute('home')}}">
    <div class="brand-logo h-28px">
        @if($brandLogo = admin()->getBrandLogo())
            <img src="{{$brandLogo}}" class="h-28px" alt="Brand logo">
        @else
            @if($brandName = admin()->getBrandName())
                {!! admin()->getBrandName() !!}
            @else
                <strong>Mer</strong>lion
            @endif
        @endif
    </div>
</a>
