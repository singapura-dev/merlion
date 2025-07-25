@extends('merlion::layouts.html')

@use(Merlion\Components\Layouts\Admin)

@section('content')
    <div class="page">
        @include('merlion::layouts.partials.header')
        <div class="page-wrapper">
            @if($self->title || $self->back)
                <div class="page-header d-print-none">
                    <div class="container-xl">
                        <div class="row">
                            <div class="col">
                                <h2 class="page-title align-items-center">
                                    @if($backUrl = $self->getBack())
                                        <a class="me-1" href="{{$backUrl}}">
                                            <i class="ri-arrow-left-line px-1 py-0 ri-arrow-left-line"></i></a>
                                    @endif
                                    {!! $self->getTitle() !!}
                                </h2>
                            </div>
                            <div class="col-auto">
                                {!! render($self->getSections(Admin::SECTION_HEADER_RIGHT)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="page-body">
                <div class="container-xl">
                    @include('merlion::layouts.content', ['content' => $self->getContent()])
                </div>
            </div>
        </div>
    </div>
@endsection
