<x-merlion::form.field :label="$self->getLabel()" :$id :label_position="$labelPosition">
    <input {{$attributes->merge(['class' => 'form-control'])}}
           type="{{$self->getInputType()}}"
           name="{{$self->getFilterName()}}"
           value="{{$self->getValue()}}"
           placeholder="{{$self->getPlaceholder()}}"
    >
</x-merlion::form.field>

