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
    <textarea name="{{$name}}" id="{{$id}}"
              {{$attributes->merge(['class' => 'form-control', 'data-bs-toggle'=>"autosize"])}}>{{old($name, $self->getValue())}}</textarea>
    @push('scripts')
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
    @endpush
</x-merlion::form.field>
