<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IntelliWed') }} - Welcome</title>

    <!-- JavaScript & CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body {
            background-color: var(--soft-beige);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .auth-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .auth-card {
            width: 100%;
            max-width: 450px;
            background: var(--white);
            padding: 3rem 2.5rem;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
        }
    </style>
</head>
<body>
    <x-unified-navigation />
    
    <div class="auth-container">
        <div class="auth-card">
            <div style="text-align: center; margin-bottom: 2.5rem;">
                <a href="/" style="display: inline-flex; align-items: center; gap: 0.75rem; font-weight: 700; font-size: 1.5rem;">
                    <img src="{{ asset('images/Rwandan culture.jpeg') }}" alt="IntelliWed Logo" style="height: 60px; width: auto; object-fit: contain;">
                    <span style="color: var(--dark-neutral);">IntelliWed</span>
                </a>
            </div>
            
            {{ $slot }}
        </div>
    </div>
</body>
</html>
