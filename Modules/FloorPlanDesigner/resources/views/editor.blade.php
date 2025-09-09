<x-floor-plan-designer::components.layouts.master>
    <div id="floor-editor" dir="rtl">
        <div class="palette">
            <button id="add-table">@lang('floor-plan-designer::addTable')</button>
            <button id="add-chair">@lang('floor-plan-designer::addChair')</button>
            <button id="save-layout">@lang('floor-plan-designer::save')</button>
        </div>
        <div id="canvas" class="relative border h-96 w-full"></div>
    </div>
    <script>
        window.initialLayout = @json($layout);
    </script>
    <script src="{{ asset('modules/floor-plan-designer/editor.js') }}"></script>
</x-floor-plan-designer::components.layouts.master>
