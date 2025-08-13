<div {{$attributes}}>
    @foreach($self->getActions() as $action)
        {!! render($action, ['model' => $model]) !!}
    @endforeach
</div>
