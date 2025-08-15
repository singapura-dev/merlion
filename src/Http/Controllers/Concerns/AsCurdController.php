<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Merlion\Concerns\CanCallMethods;

trait AsCurdController
{
    use AuthorizesRequests {
        authorize as authorizeBase;
    }

    use CanCallMethods;

    protected string $model = '';
    protected string $route = '';
    protected string $lang = '';
    protected string $label = '';
    protected string $policy = '';

    protected function route($name, ...$args): string
    {
        return admin()->getRoute($this->getRoute() . '.' . $name, ...$args);
    }

    protected function getRoute(): string
    {
        return $this->route ?: Str::kebab(Str::plural(class_basename($this->getModel())));
    }

    protected function getModel(): string
    {
        return $this->model;
    }

    protected function getQueryBuilder(): Builder
    {
        return app($this->getModel())->query();
    }

    protected function getLabelPlural(): string
    {
        return $this->lang('label_plural', $this->getLabel());
    }

    protected function lang($key, $fallback = null): string
    {
        $lang_key = $this->getLang() . '.' . $key;
        if (Lang::has($lang_key)) {
            return __($lang_key);
        }
        return $fallback ?? Str::title($key);
    }

    protected function getLang(): string
    {
        return $this->lang ?: Str::kebab(class_basename($this->getModel()));
    }

    protected function getLabel(): string
    {
        return $this->label ?: $this->lang('label', class_basename($this->getModel()));
    }

    protected function schemas(): array
    {
        return [];
    }

    protected function authorize($action, ...$args): void
    {
        if (empty($this->policy)) {
            return;
        }
        $this->authorizeBase($action, ...$args);
    }

    protected function can($action, ...$args): bool
    {
        return auth()->user()->can($action, ...$args);
    }

    protected function canSoftDelete(): bool
    {
        if (in_array(SoftDeletes::class, class_uses_recursive($this->getModel()))) {
            return true;
        }
        return false;
    }
}
