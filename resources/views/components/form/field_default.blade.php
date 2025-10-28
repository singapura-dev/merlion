@props([
    'id' => '',
    'label',
    'full' => false,
    'atttibutes' => new \Illuminate\View\ComponentAttributeBag(),
])
<div id="field_set_{{$id}}" {{$attributes->merge(['class' => $full? 'w-100':''])}}>
    @if($label)
        <label for="{{$id}}" class="form-label">{!!$label!!}</label>
    @endif
    {{$slot}}
</div>
