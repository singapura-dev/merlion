{!! $self->getButton()->render() !!}

@php
    $class = $mode. ' '. ($mode=='modal' ? 'fade':($mode.'-'.$position));
@endphp

<div id="{{$id}}" class="{{$class}}" tabindex="-1">
    @if($mode=='modal')
        <div class="modal-dialog modal-{{$size}}" role="document">
            <div class="modal-content">
                @endif
                <div class="{{$mode}}-header">
                    <h5 class="{{$mode}}-title">{!! $self->getTitle() !!}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="{{$mode}}" aria-label="Close"></button>
                </div>
                <div {{$attributes->merge(['class'=> $mode.'-body'])}}>
                    @include('merlion::layouts.content', ['content' => $self->getContent()])
                </div>
                @if($mode=='modal')
            </div>
        </div>
    @endif
</div>
