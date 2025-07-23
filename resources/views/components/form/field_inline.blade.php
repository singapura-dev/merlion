@props([
    'id' => '',
    'label',
    'label_width' => 'col-3',
])
<div id="field_set_{{$id}}" class="input-group">
    @if($label)
        <span class="input-group-text">
            {!!$label!!}
        </span>
    @endif
    {{$slot}}
</div>
