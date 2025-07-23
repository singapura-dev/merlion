@props([
    'id' => '',
    'label',
    'label_width' => 'col-3',
])
<div id="field_set_{{$id}}" class="row">
    @if($label)
        <label class="{{$label_width}} col-form-label">{!!$label!!}</label>
    @endif
    <div class="col">{{$slot}}</div>
</div>
