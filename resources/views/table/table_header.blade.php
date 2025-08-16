<thead>
<tr>
    @if($table->selectable)
        <th class="w-min"><input data-table="{{$table->getId()}}" type="checkbox"
                                 class="form-check-input row-select-all"></th>
    @endif
    @foreach($table->getColumns() as $column)
        <th>{{$column->getLabel()}}</th>
    @endforeach
</tr>
</thead>
