@php
    $value = $self->getValue();
@endphp
<x-merlion::form.field :label="$self->getLabel()" :$id :label_position="$labelPosition">
    <select {{$attributes->merge(['class' => 'form-select'])}}
            name="{{$self->getFilterName()}}">
        <option value="">{{$self->getPlaceholder() ?: '-'}}</option>
        @foreach($options as $option_key => $option_label)
            <option
                @if(!is_null($value))
                    {{$value == $option_key ? 'selected' : ''}}
                @endif
                value="{{$option_key}}">{!! $option_label !!}</option>
        @endforeach
    </select>
</x-merlion::form.field>

