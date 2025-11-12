@php
    $name = $self->getName();
    $options = $self->getOptions();
    $id = $self->getId();
    $label = $self->getLabel();
    $value = $self->getValue();
    if(isset($errors) && $errors->has($name)) {
       $attributes = $attributes->merge(['class' => 'is-invalid']);
    }
    $label_position = $self->getContext('label_position') ?? null;
    $multiple = (bool) $self->getMultiple();
    if($multiple) {
        if(empty($value)) {
            $value = [];
        }
        $name = $name.'[]';
    }
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position>
    <select name="{{$name}}" id="{{$id}}"
            {{$attributes->merge(['class' => 'form-select'])}} @if($multiple) multiple @endif>
        @if($nullable)
            <option value="">{{$self->getNullableLabel()}}</option>
        @endif
        @foreach($options as $option_key => $option_label)
            <option value="{{$option_key}}"
                    @if(!$multiple)
                        @if(old($name, $value) == $option_key) selected @endif
                    @else
                        @if(in_array($option_key, old($name, $value))) selected @endif
                    @endif
            >{!! $option_label !!}</option>
        @endforeach
    </select>
</x-merlion::form.field>

@if($multiple)
    @pushonce('styles')
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.min.css"
              rel="stylesheet">
        <style>
            .ts-dropdown {
                background-color: white;
            }

            .ts-wrapper.form-control, .ts-wrapper.form-select {
                padding: 3px !important;
            }

            .ts-wrapper .form-control, .ts-wrapper .form-select, .ts-wrapper.form-control, .ts-wrapper.form-select {
                box-shadow: var(--tblr-shadow-input);
            }

            .ts-control .item {
                border-radius: 5px !important;
                padding-left: 6px !important;
            }
        </style>
    @endpushonce

    @pushonce('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
    @endpushonce

    @push('after_scripts')
        <script nonce="{{csp_nonce()}}">
            document.addEventListener('DOMContentLoaded', function() {
                var el;
                window.TomSelect &&
                new TomSelect((el = document.getElementById("{{$id}}")), {
                    plugins: [
                        'remove_button'
                    ],
                    copyClassesToDropdown: false,
                    dropdownParent: 'body',
                    controlInput: '<input>',
                    create: {{$self->getCreatable()?"true":"false"}}
                });
            });
        </script>
    @endpush
@endif
