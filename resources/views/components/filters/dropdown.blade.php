<div class="dropdown">
    <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown"><i class="ti ti-filter"></i></a>
    <div class="dropdown-menu dropdown-menu-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap gap-3">
                    {!! render($self->getFilters()) !!}
                    <div class="input-group">
                        <span class="input-group-text">每页</span>
                        <select name="per_page" class="form-select">
                            @foreach($self->perPages as $perPage)
                                <option
                                    value="{{$perPage}}" {{request('per_page') == $perPage ? 'selected':''}}>{{$perPage}}</option>
                            @endforeach
                            @if($allowAll)
                                <option value="all" {{request('per_page') == 'all' ? 'selected':''}}>All
                                </option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex gap-3 justify-content-between">
                @if($sorts = $self->getSorts())
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-arrows-sort"></i></span>
                        <select name="sort" class="form-select">
                            <option value="">排序</option>
                            @foreach($sorts as $sort)
                                <option
                                    {{$sort->selected() ? 'selected':''}} value="{{$sort->getName()}}">{{$sort->getLabel()}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <button class="btn"><i class="ti ti-search"></i></button>
            </div>
        </div>
    </div>
</div>
