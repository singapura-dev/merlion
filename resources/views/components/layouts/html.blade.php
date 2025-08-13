<!doctype html>
<html {{$htmlAttributes->merge(['lang' => 'en'])}}>
<head>
    @include('merlion::components.layouts.inc.head')
</head>
<body {{$bodyAttributes}}>
{{$slot}}
@include('merlion::components.layouts.inc.scritps')
</body>
</html>
