<script nonce="{{csp_nonce()}}">
    @if($message = admin()->getMessage())
    $(function () {
        admin().toast({
            text: "{{$message}}",
            className: "{{session('toast.type', 'success')}}",
            position: '{{session('toast.position', 'center')}}'
        })
    });
    @endif
</script>
