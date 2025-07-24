@props([
    'id' => '',
    'label',
    'full' => false,
])
<div id="field_set_{{$id}}" class="{{$full?'w-full':''}}">
    @if($label)
        <label class="form-label">{!!$label!!}</label>
    @endif
    {{$slot}}
</div>
