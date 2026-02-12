@php
    $value = $self->getValue();
@endphp
<x-merlion::form.field :label="$self->getLabel()" :$id :label_position="$labelPosition">
    <select {{$attributes->merge(['class' => 'form-select tomselected'])}}
            @if($self->getMultiple())
                multiple
            name="{{$self->getFilterName()}}[]"
            @else
                name="{{$self->getFilterName()}}"
        @endif
    >
        <option value="">{{$self->getPlaceholder() ?: ''}}</option>
        @foreach($options as $option_key => $option_label)
            <option
                @if($self->getMultiple())
                    @if(in_array($option_key, $value?:[])) selected @endif
                @else
                    @if(!is_null($value))
                        {{$value == $option_key ? 'selected' : ''}}
                    @endif
                @endif
                value="{{$option_key}}">{!! $option_label !!}</option>
        @endforeach
    </select>
    @pushonce('before_styles')
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/tom-select@2.5.1/dist/css/tom-select.bootstrap5.min.css">
    @endpushonce
    @pushonce('after_scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.5.1/dist/js/tom-select.complete.min.js"></script>
    @endpushonce
    @push('scripts')
        <script nonce="{{csp_nonce()}}">
            document.addEventListener('DOMContentLoaded', function() {
                new TomSelect('select#{{$self->getId()}}', {
                    plugins: {
                        remove_button: {
                            title: 'Remove this item',
                        },
                        'clear_button': {
                            'title': 'Remove all selected options',
                        }
                    },
                });
            });
        </script>
    @endpush
</x-merlion::form.field>

