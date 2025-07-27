@php
    $wrapper = $self->getWrapper();
@endphp
<{{$wrapper}} {{$attributes}}>
@include('merlion::layouts.content', [
    'content' => $self->getContent(),
    'context' => $self->getContext(),
])
</{{$wrapper}}>
