<x-merlion::layouts.ajax>
    @include('merlion::partials.content', [
    'content' => $self->getContent(),
])
</x-merlion::layouts.ajax>
