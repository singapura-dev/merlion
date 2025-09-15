@props([
    'hasLink' =>false,
    'value' => '',
    'icon' => null,
    'element' => 'div'
])
<{{$element}} {{$attributes}}>
@if($icon && $icon->position == 'start')
    {!! render($icon) !!}
@endif
{{$slot}}
@if($icon && $icon->position == 'end')
    {!! render($icon) !!}
@endif
</{{$element}}>
