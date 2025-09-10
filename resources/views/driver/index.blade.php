<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Driver App</title>
</head>
<body>
    <h1>Driver Tracking</h1>
    <script>
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(function(pos) {
            fetch('/driver/location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    driver_id: {{ auth()->id() ?? 0 }},
                    latitude: pos.coords.latitude,
                    longitude: pos.coords.longitude
                })
            });
        });
    }
    </script>
</body>
</html>
