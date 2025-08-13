<x-merlion::layouts.html
    :$title
    :html_attributes="$self->getAttributes('html')"
    :body_attributes="$self->getAttributes('body')"
>
    @include('merlion::partials.content', [
        'content' => $self->getContent(),
    ])
</x-merlion::layouts.html>
