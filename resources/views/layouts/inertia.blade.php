@push('head')
    @vite($page['props']['resource'] ?? [])
@endpush

@inertia
