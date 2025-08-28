@props([
    'hasLink' =>false,
    'value' => '',
])
@php
    $element = $hasLink ? 'a':'span';
@endphp
<{{$element}} {{$attributes}}>
{{$slot}}
</{{$element}}>
