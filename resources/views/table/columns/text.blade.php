@php
    $element = $self->hasLink() ? 'a':'span';
@endphp
<{{$element}} {{$attributes}}>

@if($icon = $self->getIcon())
    {!! render($icon) !!}
@endif

{!! to_string($self->getValue()) !!}

</{{$element}}>
