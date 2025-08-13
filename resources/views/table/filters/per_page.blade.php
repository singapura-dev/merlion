<x-merlion::form.field label="每页" :$id :label_position="$labelPosition??null">
    <select name="per_page" class="form-select">
        @foreach($perPages as $perPage)
            <option value="{{$perPage}}" {{request('per_page', 10) == $perPage ? 'selected':''}}>{{$perPage}}</option>
        @endforeach
        @if($allowAll)
            <option value="all" {{request('per_page') == 'all' ? 'selected':''}}>All
            </option>
        @endif
    </select>
</x-merlion::form.field>
