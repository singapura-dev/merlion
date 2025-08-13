@php
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    $value = $self->getValue();
    if(isset($errors) && $errors->has($name)) {
       $attributes = $attributes->merge(['class' => 'is-invalid']);
    }
    $label_position = $self->getContext('label_position') ?? null;
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position>
    <select name="{{$name}}" id="{{$id}}" {{$attributes->merge(['class' => 'form-select'])}}>
        @foreach($options as $option_key=> $option_label)
            <option value="{{$option_key}}"
                    @if(old($name, $value) == $option_key) selected @endif
            >{!! $option_label !!}</option>
        @endforeach
    </select>
</x-merlion::form.field>
