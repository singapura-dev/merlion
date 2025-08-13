<div class="alert alert-dismissible alert-{{$type}}" role="alert">
    @if($icon = $self->getIcon())
        <div class="alert-icon">
            {!! render($icon) !!}
        </div>
    @endif

    @include('merlion::partials.content', [
        'content' => $self->getContent(),
    ])

    @if($closable)
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    @endif
</div>
