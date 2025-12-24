@inertia

@pushonce('meta')
    {{
    Vite::useBuildDirectory(\Merlion\Components\Inertia::$buildDirectory)
    ->withEntryPoints(\Merlion\Components\Inertia::$resources)
}}
    @inertiaHead
@endpushonce
