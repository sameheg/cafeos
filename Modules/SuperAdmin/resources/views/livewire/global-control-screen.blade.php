<div>
    <div wire:loading>Loading flags...</div>
    <div wire:loading.remove>
        @forelse($flags as $flag)
            <livewire:flag-toggle :module="$flag->module" :enabled="$flag->enabled" :key="$flag->id" />
        @empty
            <p>No tenants</p>
        @endforelse
    </div>
    <livewire:broadcast-form />
</div>
