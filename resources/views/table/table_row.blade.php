<tr {{$attributes}} data-row-id="{{$self->getModelKey()}}">
    @if($table->getSelectable())
        <td class="text-center">
            <input data-table="{{$table->getId()}}" class="form-check-input row-select table-selectable-check"
                   @if($table->getCrossPageSelection())
                       data-cross-page="1"
                   @endif

                   @if($table->getMultiple())
                       type="checkbox"
                   @else
                       type="radio" name="{{$table->getId()}}"
                   @endif
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
