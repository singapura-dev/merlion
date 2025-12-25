@php
    $default_class = 'table table-hover card-table table-vcenter ';
    if($self->getSelectable()) {
        $default_class .= ' table-selectable';
    }
@endphp

<div {{$self->getAttributes('wrapper')->merge(['class' => 'table-responsive'])}}>
    {!! render($self->getContent('before_table')) !!}
    <table {{$attributes->merge(['class' => $default_class])}} id="{{$self->getId()}}">
        {!! $self->header->render() !!}
        {!! $self->body->render() !!}
    </table>
    {!! render($self->getContent('after_table')) !!}
</div>

@if($self->getPaginate())
    <div {{$self->getAttributes('pagination')}}>
        {{$self->getModels()->links()}}
    </div>
@endif
