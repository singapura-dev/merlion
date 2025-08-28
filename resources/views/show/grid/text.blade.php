<x-merlion::datagrid :label="$self->getLabel()" :full="$self->getFull()">
    <x-merlion::text {{$attributes}} :icon="$self->getIcon()" :hasLink="$self->hasLink()">
        {!! to_string($self->diaplayValue()) !!}
    </x-merlion::text>
</x-merlion::datagrid>
