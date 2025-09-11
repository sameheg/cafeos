<!DOCTYPE html>
<html lang="en" dir="{{ $theme->rtl ?? false ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body class="bg-gray-50" style="--primary: {{ $theme->colors['primary'] ?? '#6366f1' }};">
    <div>
        <form method="POST" action="{{ route('login') }}" aria-label="login-form">
            @csrf
            <input aria-label="email" type="email" name="email" />
            <input aria-label="password" type="password" name="password" />
            <button type="submit">Login</button>
        </form>
        <button aria-label="sso-button">SSO</button>
        <select aria-label="theme-selector">
            <option>Default</option>
        </select>
    </div>
</body>
</html>
