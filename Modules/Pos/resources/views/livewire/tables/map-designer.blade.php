<div>
    <h1 class="text-xl font-bold mb-4">Table Map Designer</h1>

    <div class="table-map">
        <!-- Map designer canvas -->
    </div>

    @if($canUpdate)
        <button wire:click="save" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Save Layout</button>
    @endif

    @error('layoutData')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
    <button wire:click="save" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Save Layout</button>
</div>
