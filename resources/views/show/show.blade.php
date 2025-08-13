<div {{$attributes->merge(['class' => 'datagrid'])}}>
    @include('merlion::partials.content', [
        'content' => $self->getContent()
    ])
</div>
