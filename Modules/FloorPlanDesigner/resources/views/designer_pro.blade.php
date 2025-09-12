
<div class="p-4 space-y-3">
  <div class="flex items-center gap-2">
    <button id="undoBtn" class="px-3 py-2 border rounded">Undo</button>
    <button id="redoBtn" class="px-3 py-2 border rounded">Redo</button>
    <button id="deleteBtn" class="px-3 py-2 border rounded">Delete</button>
    <div class="flex-1"></div>
    <button id="exportSvg" class="px-3 py-2 border rounded">Export SVG</button>
    <button id="exportPng" class="px-3 py-2 border rounded">Export PNG</button>
    <button id="saveBtn" class="px-3 py-2 border rounded">Save</button>
  </div>

  <div class="grid grid-cols-12 gap-4">
    <div class="col-span-2">
      <div class="border rounded p-2">
        <h3 class="font-semibold mb-2">Palette</h3>
        <div class="space-y-2">
          <button data-add="table" class="w-full px-2 py-1 border rounded">+ Table</button>
          <button data-add="chair" class="w-full px-2 py-1 border rounded">+ Chair</button>
          <button data-add="zone" class="w-full px-2 py-1 border rounded">+ Zone</button>
          <button data-add="door" class="w-full px-2 py-1 border rounded">+ Door</button>
          <button data-add="bar" class="w-full px-2 py-1 border rounded">+ Bar</button>
        </div>
      </div>
      <div class="border rounded p-2 mt-3">
        <h3 class="font-semibold mb-2">Layers</h3>
        <ul id="layers" class="text-sm"></ul>
      </div>
    </div>

    <div class="col-span-8">
      <div class="relative">
        <canvas id="canvas" width="1000" height="600" class="border rounded w-full"></canvas>
      </div>
    </div>

    <div class="col-span-2">
      <div class="border rounded p-2">
        <h3 class="font-semibold mb-2">Properties</h3>
        <div id="props" class="text-sm"></div>
      </div>
    </div>
  </div>

  <details class="border rounded p-2">
    <summary class="font-semibold cursor-pointer">Debug JSON</summary>
    <pre id="state" class="text-xs bg-gray-50 p-2 overflow-auto h-56"></pre>
    <pre id="initial-json" class="hidden">{{ json_encode($record->json_data ?? []) }}</pre>
  </details>

  <script src="/modules/floorplandesigner/pro-canvas.js"></script>
</div>
