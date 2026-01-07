<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
<meta name="csp-nonce" content="{{ csp_nonce() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@stack('meta')
<title>{{$title??config('app.name')}}</title>
@include('merlion::components.layouts.inc.styles')

@if(!empty($vite = admin()->getVite()))
    @vite($vite)
@endif
