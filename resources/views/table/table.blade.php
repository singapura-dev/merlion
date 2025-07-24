@php
    $columns = $self->getColumns();
    $rows = $self->getRows();
    $action =$self->getActions();
@endphp
<div class="table-responsive">
    <table {{$attributes->merge(['class' => 'table mb-0'])}} id="{{$id}}">
        <thead>
        <tr class="bg-light">
            @if($selectable)
                <th><input class="form-check-input table-selectable-check-all" type="checkbox" value="true"></th>
            @endif
            @foreach($columns as $column)
                <th>
                    @if($column->sortable)
                        <a href="{{request()->fullUrlWithQuery(['sort_by' => $column->getName(), 'sort_type' => request('sort_type') == 'desc'?'asc':'desc'])}}">
                            {!! $column->getLabel() !!}
                            <i class="{{request('sort_by') === $column->getName() ? 'ti ti-'.(request('sort_type','asc') === 'asc' ? 'sort-descending':'sort-ascending') :'ti ti-arrows-sort'}} float-end"></i>
                        </a>
                    @else
                        {!! $column->getLabel() !!}
                    @endif
                </th>
            @endforeach
            @if(!empty($actions))
                <th>{{__('merlion::base.actions')}}</th>
            @endif
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
                        {{$column->model($row)->render()}}
                    </td>
                @endforeach

                @if(!empty($actions))
                    <td>
                        <div class="d-flex flex-wrap gap-1 align-items-center">
                            @foreach(deep_clone($actions) as $action)
                                {!! $action->model($row)->render() !!}
                            @endforeach
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if(method_exists($rows, 'links'))
    <div class="p-2">
        {{$rows->links()}}
    </div>
@endif
