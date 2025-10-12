@php
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    $value = to_json($self->getValue());
    $label_position = $self->getContext('label_position') ?? null;
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position>
    <div id="{{$id}}" {{$attributes}}></div>
    <input type="hidden" name="{{$name}}" value="{{to_string($value)}}">
</x-merlion::form.field>

@pushonce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jsoneditor@10.4.1/dist/jsoneditor.min.js"></script>
@endpushonce

@pushonce('styles')
    <link href="https://cdn.jsdelivr.net/npm/jsoneditor@10.4.1/dist/jsoneditor.min.css" rel="stylesheet">
@endpushonce

@push('scripts')
    <script nonce="{{csp_nonce()}}">
        (function() {
            const container = document.getElementById("{{$id}}");
            const options = {
                mode: 'tree',
                modes: ['code', 'form', 'tree'],
                onChangeText: function(jsonString) {
                    document.querySelector('input[name="{{$name}}"]').value = jsonString;
                }
            };
            const editor = new JSONEditor(container, options);

            // set json
            const initialJson = @json($value);
            editor.set(initialJson);

            // get json
            const updatedJson = editor.get();
        })();
    </script>
@endpush
