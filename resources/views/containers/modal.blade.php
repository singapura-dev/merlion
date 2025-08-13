<div {{$attributes->merge(['class' => 'modal fade', 'tabindex' => -1])}} id="{{$id}}">
    <div {{$attributes->merge(['class' => 'modal-dialog modal-'.$size], 'dialog')}} role="document">
        <div {{$attributes->merge(['class' => 'modal-content'], 'content')}}>
            <div {{$attributes->merge(['class' => 'modal-header'], 'header')}}>
                <h5 {{$attributes->merge(['class' => 'modal-title'], 'title')}}>{!! render($title) !!}</h5>
                @if($closable)
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                @endif
            </div>
            <div {{$attributes->merge(['class' => 'modal-body'], 'body')}}>
                @include('merlion::partials.content', [
                    'content' => $self->getContent(),
                ])
            </div>
        </div>
    </div>
</div>
