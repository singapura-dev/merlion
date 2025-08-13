<x-merlion::datagrid :label="$self->getLabel()" :full="$self->getFull()">
    <div {{$attributes}}>
        {!! to_string($self->getValue()) !!}
    </div>
</x-merlion::datagrid>
