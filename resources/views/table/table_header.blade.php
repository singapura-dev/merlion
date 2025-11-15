<thead>
<tr>
    @if($table->selectable)
        <th class="w-min text-center">
            @if($table->getMultiple())
                <input data-table="{{$table->getId()}}" type="checkbox" class="form-check-input row-select-all">
            @else
                <a class="btn btn-sm btn-action row-clear-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-1">
                        <path d="M18 6l-12 12"></path>
                        <path d="M6 6l12 12"></path>
                    </svg>
                </a>
            @endif
        </th>
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
