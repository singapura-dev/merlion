@if($brandLogo = admin()->getBrandLogo())
    <img src="{{$brandLogo}}" alt="Brand logo">
@else
    <strong>Mer</strong>lion
@endif
