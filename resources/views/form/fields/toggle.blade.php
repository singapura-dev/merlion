@php
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    $type = $self->getInputType();
    $placeholder = $self->getPlaceholder();
    if(isset($errors) && $errors->has($name)) {
       $attributes = $attributes->merge(['class' => 'is-invalid']);
    }
    $label_position = $self->getContext('label_position') ?? null;
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position>
    <label class="form-check form-switch form-switch-3">
        <input type="hidden" name="{{$name}}" value="0">
        <input {{$attributes->merge(['class' => 'form-check-input'])}}
               type="checkbox"
               name="{{$name}}"
               {{$required ? 'required' : ''}}
               id="{{$id}}"
               placeholder="{{$placeholder}}"
               @if(old($name, $self->getValue()))
                   checked
               @endif
               value="1"
        >
    </label>
</x-merlion::form.field>
