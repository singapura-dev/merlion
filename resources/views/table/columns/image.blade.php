<img src="{{$self->getValue()}}" alt="" {{$attributes}}
@if($withd = $self->getWidth() ?? $self->getSize())
    width="{{$withd}}"
@endif
>
