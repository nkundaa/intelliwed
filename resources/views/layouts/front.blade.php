<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IntelliWed - Your Perfect Wedding Planner')</title>

    <!-- JavaScript & CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @yield('extra-head')
    
    <style>
        /* Specific page layout tweaks */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .footer {
            background: var(--dark-neutral);
            color: var(--white);
            padding: 4rem 0 2rem;
            margin-top: 4rem;
        }
        .footer h4 {
            color: var(--primary-beige);
            margin-bottom: 1.5rem;
        }
        .footer a {
            color: #ccc;
            display: block;
            margin-bottom: 0.5rem;
        }
        .footer a:hover {
            color: var(--white);
        }
    </style>
</head>
<body>
    <x-unified-navigation />

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 3rem;">
                <div>
                    <h4 style="font-size: 1.5rem; margin-bottom: 1rem;">IntelliWed</h4>
                    <p style="color: #ccc; font-size: 0.9rem;">Your intelligent wedding planning platform with modern vendor discovery and booking tools. We make your special day effortless.</p>
                </div>
                <div>
                    <h4>Platform</h4>
                    <a href="{{ route('vendors.index') }}">Browse Vendors</a>
                    <a href="{{ route('services.index') }}">Services</a>
                    <a href="{{ route('home') }}#features">About Us</a>
                </div>
                <div>
                    <h4>Account</h4>
                    @guest
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}">My Dashboard</a>
                        <a href="{{ route('profile.edit') }}">Profile Settings</a>
                    @endguest
                </div>
                <div>
                    <h4>Contact Us</h4>
                    <p style="color: #ccc; font-size: 0.9rem; margin-bottom: 0.5rem;">Email: yoocoxy@gmail.com</p>
                    <p style="color: #ccc; font-size: 0.9rem; margin-bottom: 0.5rem;">Tel: 0789800360</p>
                    <p style="color: #ccc; font-size: 0.9rem; margin-bottom: 1rem;">Loc: Kicukiro, Niboye</p>
                    <a href="#">Privacy Policy</a>
                </div>
            </div>
            <div style="border-top: 1px solid #444; margin-top: 3rem; padding-top: 2rem; text-align: center; color: #888; font-size: 0.8rem;">
                <p>&copy; {{ date('Y') }} IntelliWed. All rights reserved. Done and Published by Nkunda Carmel</p>
            </div>
        </div>
    </footer>

    @guest
        <x-auth-modals />
    @endguest

    @yield('scripts')
</body>
</html>
