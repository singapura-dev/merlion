@php
    $columns = $self->getColumns();
    $rows = $self->getRows();
@endphp
<div class="table-responsive">
    <table {{$attributes->merge(['class' => 'table mb-0'])}} id="{{$id}}">
        <thead>
        <tr>
            @if($selectable)
                <th><input class="form-check-input table-selectable-check-all" type="checkbox" value="true"></th>
            @endif
            @foreach($columns as $column)
                <th>
                    @if($column->sortable)
                        <a href="{{request()->fullUrlWithQuery(['sort_by' => $column->getName(), 'sort_type' => request('sort_type') == 'desc'?'asc':'desc'])}}"
                           class="table-sort {{request('sort_by') == $column->getName()?request('sort_type', 'asc'):''}} d-flex justify-content-between">
                            {{$column->getLabel()}}
                        </a>
                    @else
                        {{$column->getLabel()}}
                    @endif
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody class="table-tbody">
        @foreach($rows as $row)
            <tr>
                @if($selectable)
                    <td>
                        <input class="form-check-input table-selectable-check" type="checkbox" value="true">
                    </td>
                @endif
                @foreach($columns as $column)
                    <td>
                        {{$column->setRow($row)->render()}}
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if(method_exists($rows, 'links'))
    @unless($links = $rows->links())
        <div class="p-2">
            {{$rows->links()}}
        </div>
    @endunless
@endif
