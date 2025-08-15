<!doctype html>
<html {{$htmlAttributes}}>
<head>
    @include('merlion::components.layouts.inc.head')
</head>
<body {{$bodyAttributes}}>
{{$slot}}
@include('merlion::components.layouts.inc.scritps')
</body>
</html>
