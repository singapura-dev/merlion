@php
    $elelment = $self->getElement() ?? 'div';
@endphp
<{{ $elelment }} {{ $self->getAttributes() }}>
{!! render($self->getContent(), $self->getContext())!!}
</{{ $elelment }}>
