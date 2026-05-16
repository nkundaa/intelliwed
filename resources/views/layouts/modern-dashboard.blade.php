<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IntelliWed') }} | @yield('title', 'Dashboard')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="container-max">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2">
                    <span class="text-2xl">💍</span>
                    <span class="font-bold text-lg text-primary">IntelliWed</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="/vendors" class="text-sm text-muted hover:text-slate-900 transition-colors">Vendors</a>
                    <a href="/services" class="text-sm text-muted hover:text-slate-900 transition-colors">Services</a>
                    <a href="/bookings" class="text-sm text-muted hover:text-slate-900 transition-colors">Bookings</a>
                </div>

                <!-- Right Section -->
                <div class="flex items-center gap-3">
                    @auth
                        <!-- Notifications -->
                        <button class="p-2 hover:bg-slate-100 rounded-lg transition-colors relative">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Profile Menu -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 p-1 hover:bg-slate-100 rounded-lg transition-colors">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-pink-500"></div>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-900 hover:bg-slate-50">Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-slate-900 hover:bg-slate-50">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-900 hover:bg-slate-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="text-sm text-primary hover:text-primary-dark transition-colors">Login</a>
                        <a href="/register" class="btn btn-primary btn-sm">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-100 py-12 mt-16">
        <div class="container-max">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">💍 IntelliWed</h3>
                    <p class="text-sm text-slate-400">Your intelligent wedding planning platform.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-white">Product</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-white">Company</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-white">Legal</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Security</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8">
                <p class="text-sm text-slate-400 text-center">&copy; 2026 IntelliWed. All rights reserved. Designed with 💜 for your special day.</p>
            </div>
        </div>
    </footer>
</body>
</html>
