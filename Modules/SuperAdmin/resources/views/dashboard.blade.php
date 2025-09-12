<x-filament::page>
    <div class="grid grid-cols-1 gap-4">
        {{ \Filament\Widgets\Widget::widget(Modules\SuperAdmin\Filament\Widgets\HealthMonitor::class) }}
        {{ \Filament\Widgets\Widget::widget(Modules\SuperAdmin\Filament\Widgets\MttrChart::class) }}
    </div>
</x-filament::page>
