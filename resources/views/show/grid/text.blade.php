@php
    $element = $self->hasLink() ? 'a':'div';
@endphp
<x-merlion::datagrid :label="$self->getLabel()" :full="$self->getFull()">
    <{{$element}} {{$attributes}}>
    {!! to_string($self->getValue()) !!}
</{{$element}}>
</x-merlion::datagrid>
