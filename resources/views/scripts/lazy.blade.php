<script nonce="{{csp_nonce()}}">
    (function () {
        const target = document.querySelector('#{{$id}}[data-lazy-auto]');

        if (target) {
            admin().observer.observe(target);
        }

        document.querySelectorAll('[data-lazy-target="{{$id}}"]').forEach(trigger => {
            trigger.removeEventListener('click', admin().onLazyTriggerClick);
            trigger.addEventListener('click', admin().onLazyTriggerClick);
        });
    })();
</script>
