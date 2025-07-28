<div {{$attributes->merge(['class' => 'dropdown'])}}>
    <div type="button" data-bs-toggle="dropdown">
        {!! render($self->getButton()) !!}
    </div>
    <ul class="dropdown-menu">
        @foreach($self->getActions() as $action)
            <li class="dropdown-item"> {!! render($action) !!} </li>
        @endforeach
    </ul>
</div>
