<div>
    <label class="flex items-center space-x-2">
        <span>{{ ucfirst($module) }}</span>
        <input type="checkbox" wire:model="enabled" aria-label="Toggle {{ $module }}" />
    </label>
</div>
