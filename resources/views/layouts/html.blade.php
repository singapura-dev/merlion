<!DOCTYPE html>
<html lang="en" data-bs-theme-primary="orange">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csp-nonce" content="{{ csp_nonce() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('head')
    <title>{{admin()->getTitle() ?? config('app.name')}} | {{admin()->getBrandName()}}</title>
    @foreach($self->css as $url)
        <link rel="stylesheet" nonce="{{csp_nonce()}}" href="{{$url}}">
    @endforeach
    @foreach($self->style as $style)
        <style nonce="{{csp_nonce()}}">
            {!! $style !!}
        </style>
    @endforeach
    @stack('styles')
    @include('merlion::scripts.theme')
</head>
<body>

@yield('content')

@foreach($self->js as $url)
    <script nonce="{{csp_nonce()}}" src="{{$url}}"></script>
@endforeach
@foreach($self->script as $script)
    <script nonce="{{csp_nonce()}}">
        {!! $script !!}
    </script>
@endforeach
@include('merlion::toast')
@stack('scripts')
</body>
</html>
