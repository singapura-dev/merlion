<?php

namespace Merlion\Components\Widgets;

use Merlion\Components\Renderable;

/**
 * @method array getColumns()
 * @method $this query($query)
 * @method $this columns($columns)
 */
class AgGrid extends Renderable
{
    public ?string $model = null;
    public array $rows = [];
    public mixed $query = null;
    public array $columns = [];
    public array $options = [];
    public array $locale = [];

    public static array $LANG_MAPS = [
        'en'    => 'AG_GRID_LOCALE_EN',
        'zh_CN' => 'AG_GRID_LOCALE_CN',
        'zh_TW' => 'AG_GRID_LOCALE_TW',
    ];

    public function getRows()
    {
        if (!empty($this->rows)) {
            return $this->rows;
        }

        if (!empty($this->query)) {
            return $this->query->get();
        }

        if (!empty($this->model)) {
            return $this->model::all();
        }

        return [];
    }

    public function getOptions()
    {
        if (!empty($this->options)) {
            return $this->evaluate($this->options);
        }

        return [
            'localeText' => $this->getLocaleText(),
            'styleNonce' => csp_nonce(),
            'columnDefs' => $this->getColumns(),
            'rowData'    => $this->getRows(),
        ];
    }

    public function getLocaleText(): string|array
    {
        if (!empty($this->locale)) {
            return $this->evaluate($this->locale);
        }
        $locale = static::$LANG_MAPS[app()->getLocale()] ?? 'AG_GRID_LOCALE_EN';
        return "##HTML##" . $locale . "##HTML##";
    }
}
