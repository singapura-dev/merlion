@if($brandLogo = admin()->getBrandLogo())
    <img src="{{$brandLogo}}" alt="Brand logo">
@else
    @if($brandName = admin()->getBrandName())
        {!! admin()->getBrandName() !!}
    @else
        <strong>Mer</strong>lion
    @endif
@endif
