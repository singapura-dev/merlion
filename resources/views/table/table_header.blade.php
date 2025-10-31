<thead>
<tr>
    @if($table->selectable)
        <th class="w-min"><input data-table="{{$table->getId()}}" type="checkbox"
                                 class="form-check-input row-select-all"></th>
    @endif
    @foreach($table->getColumns() as $column)
        <th {{$column->getAttributes('th')}}>
            @if($column->getSortable())
                <a href="{{$column->getSortUrl()}}" class="d-flex justify-content-between">
                    {{$column->getLabel()}}
                    <i class="{{$column->getSortIcon()}}"></i>
                </a>
            @else
                {{$column->getLabel()}}
            @endif
        </th>
    @endforeach
</tr>
</thead>
