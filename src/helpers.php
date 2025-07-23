<?php

declare(strict_types=1);

use Merlion\Components\Layouts\Admin;

if (!function_exists('admin')) {
    /**
     * Get admin page instance
     */
    function admin(): Admin
    {
        if (app()->bound('merlion.admin')) {
            return app('merlion.admin');
        }
        app()->instance('merlion.admin', $admin = Admin::make());
        return $admin;
    }
}

if (!function_exists('evaluate')) {
    function evaluate($value, ...$context)
    {
        if ($value instanceof Closure) {
            return call_user_func($value, ...$context);
        }
        return $value;
    }
}

if (!function_exists('render')) {
    function render($renderable, ...$args)
    {
        if (is_string($renderable)) {
            return $renderable;
        }

        if (is_numeric($renderable)) {
            return (string)$renderable;
        }

        if (is_null($renderable)) {
            return '';
        }

        if (is_bool($renderable)) {
            return $renderable ? 'true' : 'false';
        }

        if (is_array($renderable)) {
            $result = '';
            foreach ($renderable as $item) {
                $result .= render($item, ...$args);
            }

            return $result;
        }

        if ($renderable instanceof Closure) {
            $renderable = evaluate($renderable, ...$args);
            return render($renderable, ...$args);
        }

        if (empty($renderable)) {
            return '';
        }

        if (method_exists($renderable, 'toResponse')) {
            return $renderable;
        }

        if (method_exists($renderable, 'render')) {
            if (is_array($args[0] ?? null) && method_exists($renderable, 'set')) {
                $renderable->set($args[0]);
            }
            return $renderable->render();
        }

        return (string)$renderable;
    }
}

if (!function_exists('public_property_exists')) {
    function public_property_exists($class, $property): bool
    {
        try {
            $reflection = new ReflectionClass($class);
            $prop       = $reflection->getProperty($property);
            return $prop->isPublic();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('csp_nonce')) {
    function csp_nonce(): string|null
    {
        return admin()->getCspNonce();
    }
}

if (!function_exists('to_json')) {
    function to_json($string)
    {
        if ('string' === gettype($string)) {
            return json_decode($string, true);
        }
        return $string;
    }
}

if (!function_exists('to_string')) {
    function to_string($data): string
    {
        if (is_numeric($data)) {
            return (string)$data;
        }
        if (\Illuminate\Support\Str::isJson($data) || is_array($data)) {
            return json_encode($data);
        }
        return (string)$data;
    }
}

if (!function_exists('to_url_data')) {
    function to_url_data($data): string
    {
        return base64_encode(to_string($data));
    }
}

if (!function_exists('from_url_data')) {
    function from_url_data($data): array
    {
        return to_json(base64_decode($data));
    }
}
