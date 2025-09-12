<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Floorplan Heatmap</h1>
    <div id="heatmap" class="w-full h-96 border rounded"></div>
    <script>
        (async () => {
            const res = await fetch('/api/v1/floorplan/heatmap/{{ $record->id ?? request("id") }}');
            const json = await res.json();
            const el = document.getElementById('heatmap');
            el.innerText = 'Heatmap data points: ' + JSON.stringify(json.data || []);
        })();
    </script>
</div>
