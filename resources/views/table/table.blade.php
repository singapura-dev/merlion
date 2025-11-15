@php
    $default_class = 'table table-hover card-table table-vcenter ';
    if($self->getSelectable()) {
        $default_class .= ' table-selectable';
    }
@endphp

<div {{$self->getAttributes('wrapper')->merge(['class' => 'table-responsive'])}}>
    <table {{$attributes->merge(['class' => $default_class])}} id="{{$self->getId()}}">
        {!! $self->header->render() !!}
        {!! $self->body->render() !!}
    </table>
</div>

@if($self->getPaginate())
    <div {{$self->getAttributes('pagination')}}>
        {{$self->getModels()->links()}}
    </div>
@endif
