<div class="nav-item dropdown d-none d-md-flex me-3">
    <a href="#" {{$attributes}} data-bs-toggle="dropdown" tabindex="-1"
       aria-label="Show app menu"
       data-bs-auto-close="outside" aria-expanded="false">
        @if($icon = $self->getIcon())
            {!! render($icon) !!}
        @endif
        {!! $label !!}
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-demo dropdown-menu-arrow">
        <a class="dropdown-item" href="#"> Action </a>
        <a class="dropdown-item" href="#"> Another action </a>
    </div>
</div>
