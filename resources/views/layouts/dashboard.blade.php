<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $header ?? 'Dashboard' }} | IntelliWed</title>
    <script>
        (function(){var t=localStorage.getItem('iw_theme');if(t)document.documentElement.setAttribute('data-theme',t);})();
    </script>

    <!-- JavaScript & CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @yield('extra-head')
</head>
<body>
    <x-unified-navigation />
    
    <div class="dashboard-layout">
        <!-- Main Content (Full Width - No Sidebar) -->
        <main class="main-content">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h1 style="font-size: 1.75rem;">{{ $header ?? 'Dashboard' }}</h1>
                    <p style="color: var(--text-muted);">Welcome back, {{ auth()->user()->name }}</p>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="text-align: right;">
                        <span class="badge {{ auth()->user()->isAdmin() ? 'badge-approved' : (auth()->user()->isVendor() ? 'badge-pending' : 'badge-approved') }}" style="background: var(--primary-beige); color: var(--dark-neutral);">
                            {{ strtoupper(auth()->user()->role) }}
                        </span>
                    </div>
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--dark-neutral); color: var(--primary-beige); display: flex; align-items: center; justify-content: center; font-weight: 700;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            @if (session('status'))
                <div class="card" style="background: #e8f5e9; color: #2e7d32; margin-bottom: 2rem; padding: 1rem;">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @guest
        <x-auth-modals />
    @endguest

    <style>
        .dashboard-layout {
            display: block;
            margin-top: 0;
        }
        .main-content {
            width: 100%;
            max-width: 100%;
            padding: 2rem 3rem;
            background-color: #fafafa;
            min-height: calc(100vh - 73px);
            margin: 0 auto;
        }
        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem;
            }
        }
    </style>
</body>
</html>