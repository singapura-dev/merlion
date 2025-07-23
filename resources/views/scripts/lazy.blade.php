<script nonce="{{csp_nonce()}}">
    (function () {

        const target = document.querySelector('#{{$id}}[data-lazy-auto]');
        if (target) {
            merlion().observer.observe(target);
        }

        document.querySelectorAll('[data-lazy-target="{{$id}}"]').forEach(trigger => {
            trigger.removeEventListener('click', merlion().onLazyTriggerClick);
            trigger.addEventListener('click', merlion().onLazyTriggerClick);
        });
    })();
</script>
