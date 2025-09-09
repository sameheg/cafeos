<form method="POST" action="{{ route('tenant.switch') }}">
    @csrf
    <select name="tenant_id" onchange="this.form.submit()">
        @foreach(\App\Models\Tenant::all() as $tenant)
            <option value="{{ $tenant->id }}" @selected(tenant('id') === $tenant->id)>{{ $tenant->name }}</option>
        @endforeach
    </select>
</form>
