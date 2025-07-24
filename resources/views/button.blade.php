@php
    $icon = $self->getIcon();
    $label = $self->getLabel();
    $iconPosition = $self->getIconPosition();
@endphp
<{{$wrapper}} {{$attributes}}>

@if($icon && $iconPosition == 'start')
    {!! render($icon) !!}
@endif

{!! render($label) !!}

@if($icon && $iconPosition == 'end')
    {!! render($icon) !!}
@endif
</{{$wrapper}}>
