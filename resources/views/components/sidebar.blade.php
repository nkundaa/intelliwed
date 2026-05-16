@auth
@php
    $user = auth()->user();
    $currentRoute = request()->route()->getName();
@endphp

<!-- Dynamic Sidebar Navigation -->
<aside class="sidebar-transition fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transform lg:translate-x-0 lg:static lg:inset-0" 
       x-data="{ sidebarOpen: false }" 
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-14 px-4 border-b border-gray-200">
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/>
                </svg>
            </div>
            <span class="text-sm font-bold bg-gradient-to-r from-yellow-600 to-yellow-700 bg-clip-text text-transparent">IntelliWed</span>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden">
            <svg class="w-6 h-6 text-gray-500 hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    
    <!-- Role-Based Navigation -->
    <nav class="mt-4 px-2">
        
        @if($user->isAdmin())
            <!-- Admin Sidebar -->
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md transition-colors duration-200
                          {{ $currentRoute == 'dashboard' ? 'bg-yellow-50 text-yellow-700 border-l-2 border-yellow-500' : 'text-gray-700 hover:bg-gray-50 hover:text-yellow-600' }}">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                
                <a href="#" class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-yellow-600 transition-colors duration-200">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Users
                </a>
                
                <a href="#" class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-yellow-600 transition-colors duration-200">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Vendors
                </a>
                
                <a href="{{ route('services.admin') }}" 
                   class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md transition-colors duration-200
                          {{ str_contains($currentRoute, 'services.admin') ? 'bg-yellow-50 text-yellow-700 border-l-2 border-yellow-500' : 'text-gray-700 hover:bg-gray-50 hover:text-yellow-600' }}">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Services
                </a>
                
                <a href="{{ route('bookings.admin') }}" 
                   class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md transition-colors duration-200
                          {{ str_contains($currentRoute, 'bookings.admin') ? 'bg-yellow-50 text-yellow-700 border-l-2 border-yellow-500' : 'text-gray-700 hover:bg-gray-50 hover:text-yellow-600' }}">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Bookings
                </a>
            </div>
            
        @elseif($user->isVendor())
            <!-- Vendor Sidebar -->
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md transition-colors duration-200
                          {{ $currentRoute == 'dashboard' ? 'bg-yellow-50 text-yellow-700 border-l-2 border-yellow-500' : 'text-gray-700 hover:bg-gray-50 hover:text-yellow-600' }}">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('services.vendor') }}" 
                   class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md transition-colors duration-200
                          {{ str_contains($currentRoute, 'services.vendor') ? 'bg-yellow-50 text-yellow-700 border-l-2 border-yellow-500' : 'text-gray-700 hover:bg-gray-50 hover:text-yellow-600' }}">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    My Services
                </a>
                
                <a href="{{ route('services.create') }}" 
                   class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md transition-colors duration-200
                          {{ $currentRoute == 'services.create' ? 'bg-yellow-50 text-yellow-700 border-l-2 border-yellow-500' : 'text-gray-700 hover:bg-gray-50 hover:text-yellow-600' }}">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Service
                </a>
                
                <a href="#" class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-yellow-600 transition-colors duration-200">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Bookings
                </a>
            </div>
            
        @else
            <!-- User Sidebar -->
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md transition-colors duration-200
                          {{ $currentRoute == 'dashboard' ? 'bg-yellow-50 text-yellow-700 border-l-2 border-yellow-500' : 'text-gray-700 hover:bg-gray-50 hover:text-yellow-600' }}">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('services.index') }}" 
                   class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md transition-colors duration-200
                          {{ str_contains($currentRoute, 'services') ? 'bg-yellow-50 text-yellow-700 border-l-2 border-yellow-500' : 'text-gray-700 hover:bg-gray-50 hover:text-yellow-600' }}">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Browse Services
                </a>
                
                <a href="#" class="group flex items-center px-2 py-1.5 text-xs font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-yellow-600 transition-colors duration-200">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    My Bookings
                </a>
            </div>
        @endif
        
    </nav>
    
    <!-- Sidebar Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
        <div class="flex items-center space-x-3">
            <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ $user->name }}&background=pink&color=fff" alt="{{ $user->name }}">
            <div>
                <p class="text-sm font-medium text-gray-700">{{ $user->name }}</p>
                <p class="text-xs text-gray-500">{{ ucfirst($user->role) }}</p>
            </div>
        </div>
    </div>
</aside>
@endauth
