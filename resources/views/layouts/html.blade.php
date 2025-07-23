<!doctype html>
<html {{$attributes->merge(['lang' => 'en'])}}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
