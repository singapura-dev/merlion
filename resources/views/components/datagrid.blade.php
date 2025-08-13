@props([
    'full' => false,
    'label' => ''
])
<div class="datagrid-item {{$full?'grid-full':''}}">
    @if($label)
        <div class="datagrid-title">{!! $label !!}</div>
    @endif
    <div class="datagrid-content">
        {{$slot}}
    </div>
</div>
