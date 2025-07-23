@props([
    'id' => '',
    'label',
    'label_position' => 'default',
])
@include('merlion::components.form.field_'.$label_position)
