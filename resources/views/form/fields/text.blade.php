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

@if($type === 'hidden')
    <input type="hidden"
           name="{{$name}}"
           id="{{$id}}"
           value="{{old($name, $self->getValue())}}"
    >
@else
    <x-merlion::form.field :$label :$id :$full :$label_position :attributes="$self->getAttributes('wrapper')">
        {!! render($self->getContent('before')) !!}
        <input {{$attributes->merge(['class' => 'form-control'])}}
               type="{{$type}}"
               name="{{$name}}"
               {{$required ? 'required' : ''}}
               id="{{$id}}"
               placeholder="{{$placeholder}}"
               value="{{old($name, $self->getValue())}}"
        >
        {!! render($self->getContent('after')) !!}
    </x-merlion::form.field>
@endif
@pushonce('scripts')

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
@endpushonce
