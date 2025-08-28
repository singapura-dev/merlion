@props([
    'hasLink' =>false,
    'icon' => null,
    'value' => '',
])
@php
    $element = $self->hasLink() ? 'a':'span';
@endphp
<{{$element}} {{$attributes}}>

@if($icon)
    {!! render($icon) !!}
@endif

{{$slot}}

</{{$element}}>
