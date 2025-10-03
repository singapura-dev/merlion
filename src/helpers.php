<?php

use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;
use Merlion\Components\Layouts\Admin;

if (!function_exists('admin')) {
    function admin($id = null): Admin
    {
        $id = $id ?? Context::get('merlion_id', 'admin');
        if (empty(app()->bound("merlion.admin.{$id}"))) {
            $config = config("merlion.{$id}", []);
            $admin  = Admin::make(array_merge(['id' => $id], $config));
            $admin->boot();
            app()->instance("merlion.admin.{$id}", $admin);
        }
        return app("merlion.admin.{$id}");
    }
}

if (!function_exists('csp_nonce')) {
    function csp_nonce(): string|null
    {
        return admin()->getCspNonce();
    }
}

if (!function_exists('render')) {
    function render($element, array $context = [])
    {
        if (is_string($element)) {
            return $element;
        }

        if (is_bool($element)) {
            return $element ? 'true' : 'false';
        }

        if (is_numeric($element)) {
            return (string)$element;
        }

        if (is_array($element)) {
            $result = '';
            foreach ($element as $_element) {
                $result .= render($_element, $context);
            }
            return $result;
        }

        if (is_object($element) && method_exists($element, 'render')) {
            if (!empty($context) && method_exists($element, 'context')) {
                $element->context($context);
            }
            return $element->render();
        }

        return (string)$element;
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

if (!function_exists('public_method_exists')) {
    function public_method_exists($class, $property): bool
    {
        try {
            $reflection = new ReflectionClass($class);
            $prop       = $reflection->getMethod($property);
            return $prop->isPublic();
        } catch (Exception $e) {
            return false;
        }
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
    function to_string($data, $pretty = false, $html_filter = true): string
    {
        if (is_numeric($data)) {
            return (string)$data;
        }

        if (Str::isJson($data) || is_array($data)) {
            $str = json_encode($data, $pretty ? JSON_PRETTY_PRINT : 0);
        } else {
            $str = render($data);
        }

        if ($html_filter) {
            $str = str_replace(['"##HTML##', '##HTML##"'], ['', ''], $str);
        }
        return $str;
    }
}

if (!function_exists('deep_clone')) {
    function deep_clone($renderable)
    {
        if (is_array($renderable)) {
            return array_map(function ($value) {
                return deep_clone($value);
            }, $renderable);
        }
        if (is_object($renderable)) {
            return clone $renderable;
        }
        return $renderable;
    }
}
