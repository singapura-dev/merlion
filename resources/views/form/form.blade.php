<form {{$attributes}} method="{{$self->getMethod() == 'get' ? 'get':'post'}}">
    @csrf
    @method($self->getMethod())
    @include('merlion::partials.content', [
        'content' => $self->getContent(),
        'context' =>['model' => $self->getModel()]
    ])
</form>
