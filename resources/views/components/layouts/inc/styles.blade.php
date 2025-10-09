@stack('before_styles')
@foreach(admin()->getCss() as $url)
    <link rel="stylesheet" nonce="{{csp_nonce()}}" href="{{$url}}">
@endforeach
@stack('styles')
@foreach(admin()->getStyle() as $style)
    <style nonce="{{csp_nonce()}}">
        {!! $style !!}
    </style>
@endforeach
@stack('after_styles')
