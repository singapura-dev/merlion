<x-merlion::text {{$attributes}} :icon="$self->getIcon()" :hasLink="$self->hasLink()">
    @if($self->getValue())
        {!! $self->getYesLabel() !!}
    @else
        {!! $self->getNoLabel() !!}
    @endif
</x-merlion::text>
