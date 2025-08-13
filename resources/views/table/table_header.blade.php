<thead>
<tr>
    @foreach($table->getColumns() as $column)
        <th>{{$column->getLabel()}}</th>
    @endforeach
</tr>
</thead>
