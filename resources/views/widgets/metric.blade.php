@php
    $link = $self->getLink();

@endphp
<div class="card card-sm">
    <div class="card-body">
        @if($link)
            <a href="{{$link}}" target="{{$self->getTarget()}}">
        @endif
                <div class="row align-items-center">
                    <div class="col-auto">
                        @if($icon = $self->getIcon())
                            <span class="bg-{{$color}} text-white avatar">
                        {!! render($icon)!!}
                    </span>
                        @endif
                    </div>
                    <div class="col">
                        <div><strong>{{$title}}</strong></div>
                        <div class="text-secondary">{{$sub_title}}</div>
                    </div>
                </div>
        @if($link)
            </a>
        @endif
    </div>
</div>
