<div {{$attributes}} >
    @foreach($self->getContent() as $column)
        <div class="{{$column->getWidth()}}">
            @include('merlion::partials.content', ['content' => $column->getContent()])
        </div>
    @endforeach
</div>
