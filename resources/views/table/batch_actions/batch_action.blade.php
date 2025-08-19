@php
    $form = $self->getForm()
@endphp

<button {{$attributes->merge(['class' => 'btn'])}}
    @if(!empty($form))
            data-bs-toggle="modal" data-bs-target="#modal_{{$id}}"
    @endif
>
    {!! $self->getLabel() !!}
</button>

@if(!empty($form))
    <div class="modal" id="modal_{{$id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$self->getLabel()}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! render($form) !!}
                </div>
            </div>
        </div>
    </div>
@endif
