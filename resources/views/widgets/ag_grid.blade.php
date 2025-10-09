@php
    $id = $self->getId();
    $language_map = [
        'en' => 'AG_GRID_LOCALE_EN',
        'zh_CN' => 'AG_GRID_LOCALE_CN',
        'zh_TW' => 'AG_GRID_LOCALE_TW',
    ];
    $rows = $self->getRows();
    $columns = $self->getColumns();
    $options = $self->getOptions();
@endphp
<div id="{{$id}}" {{$attributes}}></div>

@pushonce('scripts')
    @foreach($self->getJs() as $url)
        <script nonce="{{csp_nonce()}}" src="{{$url}}"></script>
    @endforeach
@endpushonce

@push('after_scripts')
    <script nonce="{{csp_nonce()}}">

        (function() {
            @foreach($self->getScript() as $script)
                {!! $script !!}
            @endforeach

            let gridApi = agGrid.createGrid(document.querySelector('#{{$id}}'), {!! to_string($options) !!});
        })();
     </script>
@endpush
