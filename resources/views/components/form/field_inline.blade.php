@props([
    'id' => '',
    'label',
    'label_width' => 'col-3',
    'full' => false,
])
<div id="field_set_{{$id}}" class="input-group {{$full?'w-full':''}}">
    @if($label)
        <label class="input-group-text" for="{{$id}}">
            {!!$label!!}
        </label>
    @endif
    {{$slot}}
</div>
