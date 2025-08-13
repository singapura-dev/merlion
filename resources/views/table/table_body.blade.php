<tbody {{$attributes}}>
@foreach($self->getRows() as $row)
    {!! $row->render() !!}
@endforeach
</tbody>
