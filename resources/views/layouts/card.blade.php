<div {{$attributes->merge(['class' => 'card'])}}>
    @include('merlion::layouts.content', [
        'content' => $self->getContent(),
    ])
</div>
