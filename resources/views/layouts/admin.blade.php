<x-merlion::layouts.html
    :$title
    :html_attributes="$self->getAttributes('html')"
    :body_attributes="$self->getAttributes('body')"
>
    @include('merlion::partials.content', [
        'content' => admin()->getContent('top'),
    ])
    <div class="page">
        @include(admin()->view('header'))
        <div class="page-wrapper">
            @if(admin()->hasPageHeader())
                @include(admin()->view('page_header'))
            @endif
            <div class="page-body">
                <div class="container-xl">
                    @include('merlion::components.alerts')
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


