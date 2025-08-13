<div class="datagrid-item">
    <div class="datagrid-title">{!!  $self->getLabel() !!}</div>
    <div class="datagrid-content">
        <div {{$attributes}}>
            {!! to_string($self->getValue()) !!}
        </div>
    </div>
</div>
