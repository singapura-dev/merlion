<tr {{$attributes}} data-row-id="{{$self->getModelKey()}}">
    @if($table->getSelectable())
        <td>
            <input data-table="{{$table->getId()}}" class="form-check-input row-select table-selectable-check"
                   type="checkbox"
                   value="{{$self->getModelKey()}}">
        </td>
    @endif
    @foreach($self->getColumns() as $column)
        @php
            $column_result = $column->render();
        @endphp
        <td {{$column->getAttributes('td')}}>
            {!! $column_result !!}
        </td>
    @endforeach
</tr>
