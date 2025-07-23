@props([
    'id' => '',
    'label',
])
<div id="field_set_{{$id}}">
    @if($label)
        <label class="form-label">{!!$label!!}</label>
    @endif
    {{$slot}}
</div>
