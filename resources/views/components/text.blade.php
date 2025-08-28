@props([
    'hasLink' =>false,
    'value' => '',
    'icon' => null,
])
@php
    $element = $hasLink ? 'a':'span';
@endphp
<{{$element}} {{$attributes}}>
@if($icon && $icon->position == 'start')
    {!! render($icon) !!}
@endif
{{$slot}}
@if($icon && $icon->position == 'end')
    {!! render($icon) !!}
@endif
</{{$element}}>
