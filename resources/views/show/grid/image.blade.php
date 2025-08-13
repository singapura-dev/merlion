<div class="datagrid-item {{$full?'grid-full':''}}">
    <div class="datagrid-title">{!!  $self->getLabel() !!}</div>
    <div class="datagrid-content">
        <img src="{!! $self->getValue() !!}" {{$attributes}} alt="">
    </div>
</div>
