<x-merlion::datagrid :label="$self->getLabel()" :full="$self->getFull()">
    <x-merlion::text {{$attributes->merge(['class' => 'font-monospace'])}}>
        {!! to_string($self->getValue(), true) !!}
    </x-merlion::text>
</x-merlion::datagrid>
