<x-core::components.layouts.app>
    <h1>{{ __('Tenants') }}</h1>
    <ul>
        @foreach($tenants as $tenant)
            <li>{{ $tenant->name }}</li>
        @endforeach
    </ul>
</x-core::components.layouts.app>
