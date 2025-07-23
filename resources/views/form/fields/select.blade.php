@php
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    if ($errors->has($name)) {
       $attributes = $attributes->merge(['class' => 'is-invalid']);
    }
@endphp

<x-merlion::form.field :$label :$id>

    <select {{$attributes->merge(['class' => 'form-select'])}}
            name="{{$name}}" id="{{$id}}">
        <option>-</option>
        @foreach($self->getOptions() as $_value => $_label)
            <option value="{{$_value}}">{!! $_label !!}</option>
        @endforeach
    </select>

    <script nonce="{{csp_nonce()}}">
        (function () {
            let item = document.querySelector("select[name={{$name}}]");
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
</x-merlion::form.field>
