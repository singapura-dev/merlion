@props([
    'id' => '',
    'label',
    'full' => false,
])
<div id="field_set_{{$id}}" class="{{$full?'w-full':''}}">
    @if($label)
        <label for="{{$id}}" class="form-label">{!!$label!!}</label>
    @endif
    {{$slot}}
</div>
