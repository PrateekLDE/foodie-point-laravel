<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Owner Login — {{ config('restaurant.name') }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #1c1c1a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px 32px;
            width: 100%;
            max-width: 380px;
        }
        .login-logo {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 8px;
        }
        h1 {
            text-align: center;
            font-size: 1.25rem;
            margin-bottom: 4px;
        }
        .subtitle {
            text-align: center;
            color: #6b6b65;
            font-size: .875rem;
            margin-bottom: 28px;
        }
        .form-group { margin-bottom: 16px; }
        label {
            display: block;
            font-size: .8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #6b6b65;
            margin-bottom: 6px;
        }
        input[type=email],
        input[type=password] {
            width: 100%;
            padding: 13px 16px;
            border: 1.5px solid #e2e2dd;
            border-radius: 8px;
            font-size: 1rem;
            -webkit-appearance: none;
            transition: border-color .15s;
        }
        input:focus { outline: none; border-color: #e85d04; box-shadow: 0 0 0 3px rgba(232,93,4,.15); }
        .btn {
            width: 100%;
            padding: 14px;
            background: #e85d04;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 8px;
        }
        .btn:active { opacity: .9; }
        .error {
            background: #ffe0e0;
            color: #c1121f;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: .9rem;
        }
        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .9rem;
            color: #555;
            margin-top: 12px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">🍽</div>
        <h1>{{ config('restaurant.name') }}</h1>
        <p class="subtitle">Owner access only</p>

        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"
                       value="{{ old('email') }}"
                       autocomplete="email"
                       inputmode="email"
                       required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password"
                       autocomplete="current-password"
                       required>
            </div>
            <label class="remember">
                <input type="checkbox" name="remember" value="1" checked>
                Keep me signed in
            </label>
            <button type="submit" class="btn">Sign In</button>
        </form>
    </div>
</body>
</html>
