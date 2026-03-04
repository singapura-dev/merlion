@php
    $element = $self->hasLink() ? 'a':'span';
@endphp
<{{$element}} {{$attributes}}>
@if($icon = $self->getIcon())
    {!! render($icon) !!}
@endif
{!! render($self->getContent()) !!}
</{{$element}}>
