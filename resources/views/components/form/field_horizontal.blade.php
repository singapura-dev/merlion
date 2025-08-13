@props([
    'id' => '',
    'label',
    'label_width' => 'col-3',
    'full' => false,
])
<div id="field_set_{{$id}}" class="row {{$full?'w-full':''}}">
    @if($label)
        <label for="{{$id}}" class="{{$label_width}} col-form-label">{!!$label!!}</label>
    @endif
    <div class="col">{{$slot}}</div>
</div>
