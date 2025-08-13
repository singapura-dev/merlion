<div {{$self->getAttributes('wrapper')->merge(['class' => 'table-responsive'])}}>
    <table {{$attributes->merge(['class' => 'table table-selectable table-hover card-table table-vcenter'])}}>
        {!! $self->header->render() !!}
        {!! $self->body->render() !!}
    </table>
</div>
