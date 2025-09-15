<x-merlion::layouts.html
    :$title
    :html_attributes="$self->getAttributes('html')"
    :body_attributes="$self->getAttributes('body')"
>
    @include('merlion::partials.content', [
        'content' => admin()->getContent('top')
    ])
    <div class="page">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    @include('merlion::components.errors')
                    @include('merlion::partials.content', [
                        'content' => $self->getContent(),
                    ])
                </div>
            </div>
        </div>
    </div>

    @include('merlion::partials.content', [
        'content' => $self->getContent('extra'),
    ])

    @include('merlion::toast')
</x-merlion::layouts.html>


