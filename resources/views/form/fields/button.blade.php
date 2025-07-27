@php
    $icon = $self->getIcon()??null;
@endphp
<button {{$attributes}}>
    @if($icon && $iconPosition == 'before')
        {!! render($icon) !!}
    @endif
    {!! render($label) !!}
    @if($icon && $iconPosition == 'after')
        {!! render($icon) !!}
    @endif
</button>
