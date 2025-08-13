<form class="d-flex flex-wrap gap-2 align-items-end">
    {!! render($self->getFilters(), ['labelPosition' => 'inline']) !!}
    @include('merlion::table.filters.per_page', ['perPages' => $self->getPerPages(), 'labelPosition' => 'inline'])
    @include('merlion::table.filters.sorts', ['sorts'=>$self->getSorts(),'labelPosition' => 'inline'])
    <button class="btn btn-light"><i class="ti ti-search"></i></button>
</form>
