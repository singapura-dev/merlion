@if($self->getIcon())
    <i {{$attributes->merge(['class'=>$self->getIcon()]) }}></i>
@elseif($self->getSvg())
    <span {{$attributes}}>
        {!! $self->getSvg() !!}
    </span>
@elseif($self->getImage())
    <img src="{{$self->getImage()}}" class="mw-100 mh-100" alt="">
@endif
