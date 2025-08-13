<div {{$attributes->merge(['class' => 'card'])}}>

    @include('merlion::partials.content', [
        'content' => $self->getContent('header')
    ])

    @include('merlion::partials.content', [
        'content' => $self->getContent('body')
    ])

    @include('merlion::partials.content', [
        'content' => $self->getContent()
    ])

    @include('merlion::partials.content', [
        'content' => $self->getContent('footer')
    ])
</div>
