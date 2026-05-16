<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-rose-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-transparent">IntelliWed</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 hover:text-pink-600 transition-colors duration-200 {{ request()->routeIs('home') ? 'border-b-2 border-pink-500' : '' }}">
                        {{ __('Home') }}
                    </a>
                    <a href="{{ route('vendors.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-600 hover:text-pink-600 transition-colors duration-200 {{ request()->routeIs('vendors.*') ? 'border-b-2 border-pink-500 text-pink-600' : '' }}">
                        {{ __('Vendors') }}
                    </a>
                    <a href="{{ route('services.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-600 hover:text-pink-600 transition-colors duration-200 {{ request()->routeIs('services.*') ? 'border-b-2 border-pink-500 text-pink-600' : '' }}">
                        {{ __('Services') }}
                    </a>
                </div>
            </div>

            <!-- Authentication Links -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-pink-500 to-rose-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-pink-600 hover:to-rose-700 transition-all duration-200 shadow-md">
                        {{ __('Dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" class="ml-3 bg-gradient-to-r from-pink-500 to-rose-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-pink-600 hover:to-rose-700 transition-all duration-200 shadow-md">
                        {{ __('Register') }}
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-900 hover:bg-gray-50 hover:text-pink-600 {{ request()->routeIs('home') ? 'bg-pink-50 border-l-4 border-pink-500 text-pink-700' : '' }}">
                {{ __('Home') }}
            </a>
            <a href="{{ route('vendors.index') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-pink-600 {{ request()->routeIs('vendors.*') ? 'bg-pink-50 border-l-4 border-pink-500 text-pink-700' : '' }}">
                {{ __('Vendors') }}
            </a>
            <a href="{{ route('services.index') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-pink-600 {{ request()->routeIs('services.*') ? 'bg-pink-50 border-l-4 border-pink-500 text-pink-700' : '' }}">
                {{ __('Services') }}
            </a>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-pink-600">
                        {{ __('Dashboard') }}
                    </a>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-pink-600">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-pink-600">
                        {{ __('Register') }}
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
