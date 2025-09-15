@props([
    'hasLink' =>false,
    'icon' => null,
])
@php
    $element = $hasLink ? 'a':'span';
@endphp
<x-merlion::displayer :element="$element" {{$attributes}} :icon="$icon">
    {{$slot}}
</x-merlion::displayer>
