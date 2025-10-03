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
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@34.2.0/dist/ag-grid-enterprise.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@ag-grid-community/locale@34.2.0/dist/umd/@ag-grid-community/locale.min.js"></script>
    <script nonce="{{csp_nonce()}}">
        agGrid.LicenseManager.setLicenseKey('[v3][RELEASE][0102]_NDg2Njc4MzY3MDgzNw==16d78ca762fb5d2ff740aed081e2af7b');
    </script>
@endpushonce

@push('after_scripts')
    <script nonce="{{csp_nonce()}}">
        agGrid.createGrid(document.querySelector('#{{$id}}'), {!! to_string($options) !!});
    </script>
@endpush
