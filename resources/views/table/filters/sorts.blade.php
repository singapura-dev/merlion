@if(!empty($sorts))
    <x-merlion::form.field label="{{__('merlion::base.sort')}}" :$id :label_position="$labelPosition??null">
        <select name="sort" class="form-select">
            <option value="">-</option>
            @foreach($sorts as $sort)
                <option
                    {{$sort->selected() ? 'selected':''}} value="{{$sort->getName()}}">{{$sort->getLabel()}}</option>
            @endforeach
        </select>
    </x-merlion::form.field>
@endif
