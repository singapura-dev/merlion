@php
    /** @var Merlion\Components\Form\Form $self */
$method = $self->getMethod();
@endphp
<form {{$attributes}}
      method="{{$method == 'get' ? 'get':'post'}}"
      action="{{$self->getAction()}}"
      enctype="multipart/form-data">
    @if($method != 'get')
        @csrf
        @method($self->getMethod())
    @endif
    @include('merlion::partials.content', [
        'content' => $self->getContent(),
        'context' =>['model' => $self->getModel()]
    ])

    @include('merlion::partials.content', [
        'content' => $self->getContent('footer'),
        'context' =>['model' => $self->getModel()]
    ])
</form>
