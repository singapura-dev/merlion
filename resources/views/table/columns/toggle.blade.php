<x-merlion::text {{$attributes}} :icon="$self->getIcon()" :hasLink="$self->hasLink()">
    @if((bool)$self->getValue())
        {!! $self->getTrueLabel() !!}
    @else
        {!! $self->getFalseLabel() !!}
    @endif
</x-merlion::text>
