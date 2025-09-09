@php use Illuminate\Support\Str; @endphp
<h1>{{ __('qr-ordering::menu.title') }}</h1>
<form method="POST" action="{{ url('api/qr-ordering/order') }}">
    @csrf
    <ul>
    @foreach($items as $item)
        @php
            $key = 'qr-ordering::menu.items.' . Str::slug($item->name);
            $name = __($key);
            if ($name === $key) {
                $name = $item->name;
            }
        @endphp
        <li>
            <label>
                <input type="checkbox" name="items[]" value="{{ $item->id }}">
                {{ $name }} - {{ $item->formatted_price }}
            </label>
        </li>
    @endforeach
    </ul>
    <button type="submit">{{ __('qr-ordering::menu.order') }}</button>
</form>
