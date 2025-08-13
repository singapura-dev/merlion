@pushonce('after_scripts')
    <script nonce="{{csp_nonce()}}">
        @if($message = admin()->getMessage())
        (function () {
            Toastify({
                text: "{{$message}}",
                duration: 3000,
                position: "center",
                style: {
                    background: "unset",
                },
                className: "bg-{{session('toast.type')}}",
            }).showToast();
        })();
        @endif
    </script>
@endpushonce
