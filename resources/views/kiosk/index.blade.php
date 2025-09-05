<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kiosk Order</title>
</head>
<body>
    <h1>Kiosk Order</h1>
    <form method="POST" action="/kiosk/order" id="order-form">
        @csrf
        <div>
            @foreach($products as $product)
                <div>
                    <label>
                        {{ $product->name }}
                        <input type="number" name="products[{{ $product->id }}]" min="0" value="0">
                    </label>
                </div>
            @endforeach
        </div>
        <div>
            <label for="payment_method">Payment</label>
            <select name="payment[method]" id="payment_method">
                <option value="cash">Cash</option>
                <option value="card">Card</option>
            </select>
        </div>
        <button type="submit">Submit</button>
    </form>
    <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/kiosk/service-worker.js');
    }
    </script>
</body>
</html>
