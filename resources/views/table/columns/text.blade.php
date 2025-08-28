<x-merlion::text {{$attributes}} :icon="$self->getIcon()" :hasLink="$self->hasLink()">
    @if($icon = $self->getIcon())
        {!! render($icon) !!}
    @endif
    {!! to_string($self->diaplayValue()) !!}
</x-merlion::text>
