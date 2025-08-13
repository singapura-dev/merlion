@php
    $element = $self->hasLink() ? 'a':'button';
@endphp
<{{$element}} {{$attributes}}>
@if($icon = $self->getIcon())
    {!! render($icon) !!}
@endif
{!! $label !!}
</{{$element}}>
