<div>
    <button role="button" {{$attributes->merge(['class' => 'dropdown-toggle'])}}
    data-bs-toggle="dropdown">{!! render($self->getLabel()) !!}
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        @foreach($self->getActions() as $action)
            @if($action->shouldRender())
                {!! render($action->class('dropdown-item')) !!}
            @endif
        @endforeach
    </div>
</div>

@pushonce('styles')
    <style nonce="{{csp_nonce()}}">
        .table-responsive {
            position: static !important;
        }

        .table-responsive .dropdown-menu {
            position: fixed !important;
            z-index: 1050;
        }
    </style>
@endpushonce
