<div class="dropdown">
    <a href="#" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
        <i class="ti ti-filter"></i></a>
    <div class="dropdown-menu dropdown-menu-md p-0">
        <form class="d-flex flex-column gap-3 p-3">
            <div class="d-flex flex-wrap gap-3 ">
                {!! render($self->getFilters()) !!}
                @include('merlion::table.filters.per_page', ['id'=>$id.'_per_page', 'perPages' => $self->perPages, 'allowAll' => $self->allowAll])
                @include('merlion::table.filters.sorts', ['id'=>$id.'_sort','sorts' => $self->getSorts()])
            </div>
            <div>
                <button class="btn btn-primary"><i class="ti ti-search"></i></button>
            </div>
        </form>
    </div>
</div>

