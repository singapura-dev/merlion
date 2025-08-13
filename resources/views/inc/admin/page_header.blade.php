<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">{{admin()->getPagePreTitle()}}</div>
                <h2 class="page-title gap-1">
                    @if($backUrl = admin()->getBackUrl())
                        <a class="btn btn-action" href="{{$backUrl}}"><i class="ti ti-arrow-left icon"></i></a>
                    @endif
                    {{admin()->getPageTitle()}}
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                @include('merlion::partials.content', [
                    'content' => $self->getContent('header'),
                ])
            </div>
        </div>
    </div>
</div>
