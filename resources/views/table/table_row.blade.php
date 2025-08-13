<tr {{$attributes}}>
    @foreach($self->getColumns() as $column)
        @php
        $column_result = $column->render();
        @endphp
        <td {{$column->getAttributes('td')}}>
            {!! $column_result !!}
        </td>
    @endforeach
</tr>
