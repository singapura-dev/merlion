@php
    $icon = $self->getIcon();
    $label = $self->getLabel();
    $iconPosition = $self->getIconPosition();
@endphp
<{{$wrapper}} {{$attributes->merge(['role' => 'button'])}}>

@if($icon && $iconPosition == 'before')
    {!! render($icon) !!}
@endif
{!! render($label) !!}
@if($icon && $iconPosition == 'after')
    {!! render($icon) !!}
@endif
</{{$wrapper}}>
