<!doctype html>
<html {!! $htmlAttributes??'' !!} lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('merlion::components.layouts.inc.head')
</head>
<body {!!  $bodyAttributes??'' !!}>
{{$slot}}
@include('merlion::components.layouts.inc.scritps')
</body>
</html>
