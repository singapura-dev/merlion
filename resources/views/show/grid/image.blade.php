<div class="datagrid-item {{$full?'grid-full':''}}">
    <div class="datagrid-title">{!!  $self->getLabel() !!}</div>
    <div class="datagrid-content">
        @if($self->getMultiple())
            <div class="d-flex">
                @foreach(to_json($self->getValue()??[]) as $value)
                    <img src="{{$value}}" alt="" {{$attributes}}
                    @if($withd = $self->getWidth() ?? $self->getSize())
                        width="{{$withd}}"
                            @endif
                    >
                @endforeach
            </div>
        @else
            <img src="{{$self->getValue()}}" alt="" {{$attributes}}
            @if($withd = $self->getWidth() ?? $self->getSize())
                width="{{$withd}}"
                    @endif
            >
        @endif
    </div>
</div>
