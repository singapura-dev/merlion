@php
    /** @var $self \Merlion\Components\Form\Fields\File */
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    if(isset($errors) && $errors->has($name)) {
       $attributes = $attributes->merge(['class' => 'is-invalid']);
    }
    $label_position = $self->getContext('label_position') ?? null;
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position>
    @stack('before_file_input')
    <input class="form-control"
           type="file"
           id="{{$id}}"
           name="{{$name}}"
           {{$required ? 'required' : ''}}
           @if($self->getMultiple())
               multiple
           @endif
           accept="{{$self->getAccept()}}"
    >
    <input type="hidden" name="{{$name}}_original" value="{{$self->getValue()}}">
    @stack('after_file_input')
</x-merlion::form.field>
