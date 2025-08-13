@foreach(admin()->getCss() as $url)
    <link rel="stylesheet" nonce="{{csp_nonce()}}" href="{{$url}}">
@endforeach
@foreach(admin()->getStyle() as $style)
    <style nonce="{{csp_nonce()}}">
        {!! $style !!}
    </style>
@endforeach
@stack('styles')
