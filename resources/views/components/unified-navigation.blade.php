<nav class="navbar" x-data="{ mobileMenuOpen: false }" style="background: var(--white); border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 1000; height: 90px; display: flex; align-items: center;">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">

        <!-- Left: Logo -->
        <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
            <div style="background: var(--soft-beige); padding: 0.5rem; border-radius: 12px;">
                <img src="{{ asset('images/Rwandan culture.jpeg') }}" alt="IntelliWed Logo" style="height: 40px; width: auto; object-fit: contain;">
            </div>
            <span style="font-weight: 800; font-size: 1.5rem; color: var(--dark-neutral); letter-spacing: -0.04em;">IntelliWed</span>
        </a>

        <!-- Mobile Menu Toggle -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="mobile-toggle" style="display: none;">
            <svg x-show="!mobileMenuOpen" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            <svg x-show="mobileMenuOpen" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <!-- Center: Navigation Items (Desktop) -->
        <div class="desktop-nav" style="display: flex; gap: 0.5rem; align-items: center; background: #f8f9fa; padding: 0.4rem; border-radius: 99px; border: 1px solid var(--border-color);">
            <a href="{{ route('home') }}" class="nav-pill {{ request()->routeIs('home') ? 'active' : '' }}">{{ __('nav.home') }}</a>
            <a href="{{ route('services.index') }}" class="nav-pill {{ request()->routeIs('services.*') ? 'active' : '' }}">{{ __('nav.services') }}</a>
            <a href="{{ route('vendors.index') }}" class="nav-pill {{ request()->routeIs('vendors.*') ? 'active' : '' }}">{{ __('nav.vendors') }}</a>
            <a href="{{ route('ceremonies.rwandan') }}" class="nav-pill {{ request()->routeIs('ceremonies.*') ? 'active' : '' }}">🇷🇼 Ceremonies</a>

            @auth
                <a href="{{ Auth::user()->isVendor() ? route('bookings.vendor') : route('bookings.index') }}" class="nav-pill {{ (request()->routeIs('bookings.*') || request()->routeIs('payments.*')) ? 'active' : '' }}">
                    <span style="display: flex; align-items: center; gap: 0.3rem;">
                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ __('nav.bookings') }}
                    </span>
                </a>
                <a href="{{ route('dashboard') }}" class="nav-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}">{{ __('nav.dashboard') }}</a>
            @endauth
        </div>

        <!-- Right: User Actions -->
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <x-language-switcher />

            @auth
                @php
                    $unreadNotifs = auth()->user()->unreadNotifications->count();
                    $unreadMsgs = auth()->user()->isClient()
                        ? \App\Models\Conversation::where('client_id', auth()->id())->whereHas('messages', fn($q) => $q->where('sender_id', '!=', auth()->id())->where('is_read', false))->count()
                        : \App\Models\Conversation::where('vendor_id', auth()->id())->whereHas('messages', fn($q) => $q->where('sender_id', '!=', auth()->id())->where('is_read', false))->count();
                @endphp

                <!-- Messages icon -->
                <a href="{{ route('chat.index') }}" title="Messages" style="position: relative; display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 10px; background: #f5f5f5; border: 1px solid var(--border-color); color: #555; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e5e5e5'" onmouseout="this.style.background='#f5f5f5'">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    @if($unreadMsgs > 0)
                        <span style="position: absolute; top: -4px; right: -4px; background: #ef4444; color: white; border-radius: 99px; font-size: 0.6rem; font-weight: 700; padding: 0.1rem 0.35rem; min-width: 16px; text-align: center; line-height: 1.4;">{{ $unreadMsgs > 9 ? '9+' : $unreadMsgs }}</span>
                    @endif
                </a>

                <!-- Notifications icon -->
                <a href="{{ route('notifications.index') }}" title="Notifications" style="position: relative; display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 10px; background: #f5f5f5; border: 1px solid var(--border-color); color: #555; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e5e5e5'" onmouseout="this.style.background='#f5f5f5'">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @if($unreadNotifs > 0)
                        <span style="position: absolute; top: -4px; right: -4px; background: #ef4444; color: white; border-radius: 99px; font-size: 0.6rem; font-weight: 700; padding: 0.1rem 0.35rem; min-width: 16px; text-align: center; line-height: 1.4;">{{ $unreadNotifs > 9 ? '9+' : $unreadNotifs }}</span>
                    @endif
                </a>

                <div x-data="{ open: false }" style="position: relative;">
                    <button @click="open = !open" style="display: flex; align-items: center; gap: 0.5rem; background: none; border: none; cursor: pointer; padding: 0;">
                        <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="card dropdown-menu">
                        <div style="margin-bottom: 0.75rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                            <div style="font-weight: 700;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">{{ Auth::user()->email }}</div>
                            <span style="font-size: 0.7rem; background: var(--primary-beige); color: var(--dark-neutral); padding: 0.15rem 0.5rem; border-radius: 4px; margin-top: 0.25rem; display: inline-block; font-weight: 600;">{{ strtoupper(Auth::user()->role) }}</span>
                        </div>
                        <a href="{{ route('dashboard') }}" class="dropdown-link">🏠 Dashboard</a>
                        @if(Auth::user()->isClient())
                            <a href="{{ route('wedding.profile') }}" class="dropdown-link">💍 My Wedding</a>
                            <a href="{{ route('tasks.index') }}" class="dropdown-link">✅ Checklist</a>
                            <a href="{{ route('gallery.index') }}" class="dropdown-link">🖼️ Gallery</a>
                            <a href="{{ route('chat.index') }}" class="dropdown-link">
                                💬 Messages
                                @php $unreadMsgs = \App\Models\Conversation::where('client_id', auth()->id())->whereHas('messages', fn($q) => $q->where('sender_id', '!=', auth()->id())->where('is_read', false))->count(); @endphp
                                @if($unreadMsgs > 0)
                                    <span style="background: #ef4444; color: white; border-radius: 99px; font-size: 0.65rem; padding: 0.1rem 0.4rem; float: right; font-weight: 700;">{{ $unreadMsgs }}</span>
                                @endif
                            </a>
                            <a href="{{ route('invitations.index') }}" class="dropdown-link">✉️ Guests</a>
                        @elseif(Auth::user()->isVendor())
                            <a href="{{ route('services.vendor') }}" class="dropdown-link">🛍️ My Services</a>
                            <a href="{{ route('bookings.vendor') }}" class="dropdown-link">📋 Bookings</a>
                            <a href="{{ route('chat.index') }}" class="dropdown-link">
                                💬 Messages
                                @if($unreadMsgs > 0)
                                    <span style="background: #ef4444; color: white; border-radius: 99px; font-size: 0.65rem; padding: 0.1rem 0.4rem; float: right; font-weight: 700;">{{ $unreadMsgs }}</span>
                                @endif
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="dropdown-link">⚙️ {{ __('nav.profile_settings') }}</a>
                        <div style="border-top: 1px solid var(--border-color); margin: 0.5rem 0;"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-link logout-btn">🚪 {{ __('nav.logout') }}</button>
                        </form>
                    </div>
                </div>
            @else
                <button onclick="window.openAuthModal('login')" class="btn-signin">
                    {{ __('nav.sign_in') }}
                </button>
            @endauth
        </div>
    </div>

    <!-- Mobile Navigation Overlay -->
    <div x-show="mobileMenuOpen"
         @click.away="mobileMenuOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         style="position: absolute; top: 90px; left: 0; right: 0; background: var(--white); padding: 1rem; border-bottom: 2px solid var(--border-color); box-shadow: var(--shadow-lg); z-index: 999; display: flex; flex-direction: column; gap: 0.5rem;"
         class="mobile-menu">
        <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">{{ __('nav.home') }}</a>
        <a href="{{ route('services.index') }}" class="mobile-nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">{{ __('nav.services') }}</a>
        <a href="{{ route('vendors.index') }}" class="mobile-nav-link {{ request()->routeIs('vendors.*') ? 'active' : '' }}">{{ __('nav.vendors') }}</a>
        <a href="{{ route('ceremonies.rwandan') }}" class="mobile-nav-link">🇷🇼 Rwandan Ceremonies</a>
        @auth
            <a href="{{ auth()->user()->isVendor() ? route('bookings.vendor') : route('bookings.index') }}" class="mobile-nav-link">{{ __('nav.bookings') }}</a>
            <a href="{{ route('dashboard') }}" class="mobile-nav-link">{{ __('nav.dashboard') }}</a>
            @if(auth()->user()->isClient())
                <a href="{{ route('wedding.profile') }}" class="mobile-nav-link">💍 My Wedding</a>
                <a href="{{ route('tasks.index') }}" class="mobile-nav-link">✅ Checklist</a>
                <a href="{{ route('chat.index') }}" class="mobile-nav-link">💬 Messages</a>
                <a href="{{ route('gallery.index') }}" class="mobile-nav-link">🖼️ Gallery</a>
            @endif
        @else
            <button onclick="window.openAuthModal('login'); document.querySelector('.mobile-menu').style.display='none';" class="mobile-nav-link" style="text-align: left; background: none; border: none; cursor: pointer; font-family: inherit; font-size: inherit; font-weight: 700; color: var(--dark-neutral); width: 100%; padding: 1rem; border-radius: 12px;">
                Sign In
            </button>
            <button onclick="window.openAuthModal('register'); document.querySelector('.mobile-menu').style.display='none';" class="mobile-nav-link" style="text-align: left; background: var(--primary-beige); border: none; cursor: pointer; font-family: inherit; font-size: inherit; font-weight: 700; color: var(--dark-neutral); width: 100%; padding: 1rem; border-radius: 12px;">
                Create Account
            </button>
        @endauth
    </div>
</nav>

<style>
    @media (max-width: 991px) {
        .desktop-nav { display: none !important; }
        .mobile-toggle { display: block !important; background: none; border: none; cursor: pointer; color: var(--dark-neutral); padding: 0.5rem; }
    }
    @media (min-width: 992px) {
        .mobile-menu { display: none !important; }
    }
    .mobile-nav-link {
        padding: 1rem;
        border-radius: 12px;
        font-weight: 700;
        color: var(--dark-neutral);
        text-decoration: none;
        display: block;
    }
    .mobile-nav-link.active { background: var(--soft-beige); }
    .nav-pill {
        padding: 0.5rem 1rem;
        border-radius: 99px;
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--dark-neutral);
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .nav-pill:hover { background: rgba(0,0,0,0.04); }
    .nav-pill.active { background: var(--dark-neutral); color: var(--white); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .user-avatar {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--dark-neutral); color: var(--primary-beige);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 0.9rem;
        border: 2px solid var(--border-color);
        transition: transform 0.2s ease;
    }
    .user-avatar:hover { transform: scale(1.05); }
    .dropdown-menu {
        position: absolute; right: 0; top: 120%;
        width: 240px; padding: 1rem; z-index: 1001;
        border-radius: 14px; box-shadow: var(--shadow-lg);
    }
    .logout-btn { width: 100%; text-align: left; background: none; border: none; color: #c62828 !important; font-weight: 600; cursor: pointer; }
    .btn-signin {
        background: var(--dark-neutral); color: var(--white);
        padding: 0.6rem 1.25rem; border-radius: 99px;
        font-weight: 700; font-size: 0.85rem;
        text-decoration: none; transition: all 0.2s ease;
        border: none; cursor: pointer; font-family: inherit;
    }
    .btn-signin:hover { transform: scale(1.05); background: #000; }
    .dropdown-link {
        display: block; padding: 0.55rem 0.75rem; border-radius: 8px;
        font-size: 0.875rem; font-weight: 500; color: var(--dark-neutral);
        text-decoration: none; transition: background 0.15s; margin-bottom: 0.1rem;
    }
    .dropdown-link:hover { background: var(--light-neutral); }
</style>
