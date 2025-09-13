<x-pos::layouts.master>
    <div x-data="cashierShortcuts()" x-init="register()" class="flex flex-col h-screen">
        <div class="flex flex-1">
            <div class="w-2/3 p-4 overflow-y-auto">
                <livewire:pos.cashier.item-list />
            </div>
            <div class="w-1/3 p-4 bg-gray-50 overflow-y-auto">
                <livewire:pos.cashier.cart />
            </div>
        </div>
        <div class="border-t p-4 flex justify-end gap-2">
            <button class="btn btn-primary" x-on:click="$dispatch('cashier-checkout')">{{ __('Checkout') }}</button>
            <button class="btn btn-secondary" x-on:click="$dispatch('cashier-clear-cart')">{{ __('Clear') }}</button>
        </div>
        <livewire:pos.cashier.modifier-modal />
    </div>

    {{ module_vite('build-pos', 'resources/js/cashier.js') }}
</x-pos::layouts.master>
