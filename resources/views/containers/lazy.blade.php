<div {{$attributes}} data-lazy
     data-renderable="{{base64_encode($renderable)}}"
     data-payload="{{base64_encode(to_string($self->getContext()))}}">
</div>
