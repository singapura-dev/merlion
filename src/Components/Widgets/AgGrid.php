<?php

namespace Merlion\Components\Widgets;

use Merlion\Components\Renderable;

/**
 * @method array getColumns()
 * @method array getDefaultColumnConfig()
 * @method static paginate($paginate = false)
 * @method static paginationPageSize($size)
 * @method static columns($columns)
 * @method static endpoint($endpoint)
 */
class AgGrid extends Renderable
{
    public array $js = [
        'https://cdn.jsdelivr.net/npm/ag-grid-enterprise@34.2.0/dist/ag-grid-enterprise.min.js',
        'https://cdn.jsdelivr.net/npm/@ag-grid-community/locale@34.2.0/dist/umd/@ag-grid-community/locale.min.js',
    ];

    public mixed $model = null;
    public array $rows = [];
    public array $columns = [];
    public array $defaultColumnConfig = [];
    public array $options = [];
    public array $locale = [];
    public mixed $endpoint = '';
    public mixed $paginate = false;
    public mixed $paginationPageSize = 100;
    public mixed $suppressPaginationPanel = false;
    public mixed $paginationAutoPageSize = false;
    public mixed $paginationPageSizeSelector = [20, 50, 100];

    public mixed $cellRenderers = [];

    public function renderAgGrid(): void
    {
        $this->scripts(<<<SCRIPT
agGrid.LicenseManager.setLicenseKey('[v3][RELEASE][0102]_NDg2Njc4MzY3MDgzNw==16d78ca762fb5d2ff740aed081e2af7b');
SCRIPT
        );

        if(!empty($endpoint = $this->getEndpoint())) {
            $this->scripts(<<<SCRIPT
 let onCellValueChanged = async (event) => {
                const updatedData = event.data;
                try {
                    const response = await fetch('{$endpoint}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(updatedData)
                    });

                    if (response.ok) {
                        admin().showToast({
                            message: '保存成功',
                            type: 'success'
                        });
                    } else {
                        admin().showToast({
                            message: '保存失败',
                            type: 'danger'
                        });
                    }
                } catch (error) {
                    console.error('保存出错:', error);
                }
            };
SCRIPT
);
        }
    }

    public static array $LANG_MAPS = [
        'en'    => 'AG_GRID_LOCALE_EN',
        'zh_CN' => 'AG_GRID_LOCALE_CN',
        'zh_TW' => 'AG_GRID_LOCALE_TW',
    ];

    public function getRows()
    {
        if (!empty($this->rows)) {
            return $this->evaluate($this->rows);
        }

        if (!empty($this->model)) {
            return app($this->model)->get();
        }

        return [];
    }

    public function getOptions(): array
    {
        if (!empty($this->options)) {
            $default_options = $this->evaluate($this->options);
        } else {
            $default_options = [];
        }

        return array_merge([
            'localeText'                 => $this->getLocaleText(),
            'styleNonce'                 => csp_nonce(),
            'columnDefs'                 => $this->getColumns(),
            'rowData'                    => $this->getRows(),
            'defaultColDef'              => $this->getDefaultColumnConfig(),
            'pagination'                 => $this->paginate,
            'paginationPageSize'         => $this->paginationPageSize,
            'paginationAutoPageSize'     => $this->paginationAutoPageSize,
            'suppressPaginationPanel'    => $this->suppressPaginationPanel,
            'paginationPageSizeSelector' => $this->paginationPageSizeSelector,
            'onCellValueChanged'         => "{!!onCellValueChanged!!}",
        ], $default_options);
    }

    public function cellRenderer($name, $callback = null): mixed
    {
        if (empty($callback)) {
            return $this->cellRenderers[$name] ?? null;
        }
        $this->cellRenderers[$name] = $callback;
        return $this;
    }

    public function getLocaleText(): string|array
    {
        if (!empty($this->locale)) {
            return $this->evaluate($this->locale);
        }
        $locale = static::$LANG_MAPS[app()->getLocale()] ?? 'AG_GRID_LOCALE_EN';
        return "{!!" . $locale . "!!}";
    }
}
