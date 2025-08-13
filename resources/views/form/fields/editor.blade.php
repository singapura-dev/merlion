@php
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    if(isset($errors) && $errors->has($name)) {
       $attributes = $attributes->merge(['class' => 'is-invalid']);
    }
    $label_position = $self->getContext('label_position') ?? null;
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position>
    <textarea {{$attributes}} id="{{$id}}">{!! $value !!}</textarea>
    <script nonce="{{csp_nonce()}}">
        document.addEventListener("DOMContentLoaded", function () {
            let options = {
                selector: '#{{$id}}',
                height: 300,
                menubar: false,
                statusbar: false,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
                    'preview', 'anchor',
                    'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
            }
            if (localStorage.getItem("tablerTheme") === 'dark') {
                options.skin = 'oxide-dark';
                options.content_css = 'dark';
            }
            hugeRTE.init(options);
        })
    </script>
</x-merlion::form.field>
