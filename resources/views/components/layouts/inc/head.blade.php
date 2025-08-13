<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
<meta name="csp-nonce" content="{{ csp_nonce() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@stack('meta')
<title>{{$title??config('app.name')}}</title>
@include('merlion::components.layouts.inc.styles')
