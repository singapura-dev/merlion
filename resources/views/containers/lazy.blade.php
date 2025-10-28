<div {{$attributes}} data-lazy
     data-renderable="{{base64_encode($renderable)}}"
     data-url="{{$self->getRenderUrl()}}"
     data-payload="{{base64_encode(to_string($self->getContext()))}}">
</div>
