<div {{$attributes->merge(['class' => 'dropdown'])}}>
    <a role="button" class="btn dropdown-toggle" data-bs-toggle="dropdown">
        @if($icon = $self->getIcon())
            {!! render($icon) !!}
        @endif
        {{$self->getLabel()}}
    </a>
    <div class="dropdown-menu dropdown-menu-arrow">
        @foreach($self->getActions() as $action)
            <a role="button" data-table="{{$self->table->getId()}}"
                {{$action->getAttributes()->merge(['class' => 'dropdown-item'])}}>
                @if($icon = $action->getIcon())
                    {!! render($icon) !!}
                @endif
                {{$action->getLabel()}}
            </a>
        @endforeach
    </div>
</div>
