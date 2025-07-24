@php
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    $type = $self->getInputType();
    $placeholder = $self->getPlaceholder();
    if($errors->has($name)) {
       $attributes = $attributes->merge(['class' => 'is-invalid']);
    }
@endphp

<x-merlion::form.field :$label :$id :$full>
    <textarea {{$attributes->merge(['class' => 'form-control'])}}
              type="{{$type}}"
              name="{{$name}}"
              rows="{{$rows}}"
              id="{{$id}}"
              placeholder="{{$placeholder}}"
    >{{old($name, $self->getValue())}}</textarea>
</x-merlion::form.field>

<script nonce="{{csp_nonce()}}">
    (function () {
        let item = document.querySelector("#{{$id}}");
        item.addEventListener('change', function (e) {
            e.target.closest('form').dispatchEvent(new CustomEvent('field_value_changed', {
                detail: {
                    name: "{{$name}}",
                    value: e.target.value
                }
            }));
        });
    })();
</script>
