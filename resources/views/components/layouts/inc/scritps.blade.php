@stack('before_scripts')

@foreach(admin()->getJs() as $url)
    <script nonce="{{csp_nonce()}}" src="{{$url}}"></script>
@endforeach

@stack('scripts')

@foreach(admin()->getScript() as $script)
    <script nonce="{{csp_nonce()}}">
        {!! $script !!}
    </script>
@endforeach

@stack('after_scripts')
