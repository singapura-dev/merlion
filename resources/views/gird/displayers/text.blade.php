<div class="datagrid-item {{$full?'w-full':''}}">
    <div class="datagrid-title">{{$label}}</div>
    <div {{$attributes->merge(['class'=>'datagrid-content '. ($self->getStatus() ? 'status status-'.$self->getStatus() : '')])}}>
        {{$self->getValue()}}
    </div>
</div>
