<{{$wrapper}} {{$attributes}} id="{{$id}}"
@if($auto)
    data-lazy-auto
@else
    data-lazy
@endif
data-renderable="{{$self->getRenderable()}}" data-payload='{{to_string($self->payload())}}'>
</{{$wrapper}}>

@include('merlion::scripts.lazy', ['id' => $id])
