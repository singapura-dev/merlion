@php
    /** @var Merlion\Components\Form\Form $self */
@endphp
<form {{$attributes}}
      method="{{$self->getMethod() == 'get' ? 'get':'post'}}"
      action="{{$self->getAction()}}"
      enctype="multipart/form-data">
    @csrf
    @method($self->getMethod())
    @include('merlion::partials.content', [
        'content' => $self->getContent(),
        'context' =>['model' => $self->getModel()]
    ])

    @include('merlion::partials.content', [
        'content' => $self->getContent('footer'),
        'context' =>['model' => $self->getModel()]
    ])
</form>
