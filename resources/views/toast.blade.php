@pushonce('after_scripts')
    @if($message = admin()->getMessage())
        <script nonce="{{csp_nonce()}}">
            (function () {
                admin().showToast({
                    message: "{{$message}}",
                    type: "{{session('toast.type')}}"
                });
            })();
        </script>
    @endif
@endpushonce
