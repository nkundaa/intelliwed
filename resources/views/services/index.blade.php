@extends('layouts.front')

@section('title', __('marketplace.title') . ' | IntelliWed')

@section('content')
<!-- Simplified Header -->
<div style="background: var(--soft-beige); padding: 2rem 0; border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <!-- Title and Subtitle removed as requested -->
    </div>
</div>

<div class="container" style="padding: 4rem 2rem;">
    <!-- Budget Planner CTA -->
    <div style="background: var(--dark-neutral); color: var(--white); border-radius: 24px; padding: 3rem; margin-bottom: 4rem; display: flex; justify-content: space-between; align-items: center; box-shadow: var(--shadow-lg);">
        <div>
            <h2 style="margin: 0 0 0.75rem 0; font-size: 2rem; color: var(--primary-beige);">Need a Quick Plan?</h2>
            <p style="margin: 0; opacity: 0.8; font-size: 1.1rem;">Our AI will automatically distribute your budget across top-rated services.</p>
        </div>
        <a href="{{ route('budget.planner') }}" class="btn btn-secondary" style="padding: 1rem 2rem; font-size: 1.1rem;">
            🎯 Auto Budget Plan
        </a>
    </div>

    <!-- Search and Filter Bar -->
    <div class="card" style="margin-bottom: 4rem; padding: 2rem; border-radius: 20px;">
        <form action="{{ route('services.index') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1.5rem; align-items: flex-end;">
            <div class="form-group" style="margin: 0;">
                <label class="label" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Search Vendors</label>
                <input type="text" name="search" value="{{ request('search') }}" class="input" placeholder="Keyword, vendor name..." style="border-radius: 12px;">
            </div>
            <div class="form-group" style="margin: 0;">
                <label class="label" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Category</label>
                <select name="category" class="input" style="border-radius: 12px;">
                    <option value="">All Categories</option>
                    <option value="venue" {{ request('category') == 'venue' ? 'selected' : '' }}>{{ __('home.venues') }}</option>
                    <option value="photographer" {{ request('category') == 'photographer' ? 'selected' : '' }}>{{ __('home.photography') }}</option>
                    <option value="catering" {{ request('category') == 'catering' ? 'selected' : '' }}>Catering</option>
                    <option value="music" {{ request('category') == 'music' ? 'selected' : '' }}>{{ __('home.music') }}</option>
                    <option value="beauty" {{ request('category') == 'beauty' ? 'selected' : '' }}>{{ __('home.beauty') }}</option>
                    <option value="decorator" {{ request('category') == 'decorator' ? 'selected' : '' }}>Decorators</option>
                </select>
            </div>
            <div class="form-group" style="margin: 0;">
                <label class="label" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Price Range</label>
                <select name="price_range" class="input" style="border-radius: 12px;">
                    <option value="">Any Price</option>
                    <option value="0-500000" {{ request('price_range') == '0-500000' ? 'selected' : '' }}>{{ __('marketplace.under_500k') }}</option>
                    <option value="500000-2000000" {{ request('price_range') == '500000-2000000' ? 'selected' : '' }}>{{ __('marketplace.500k_2m') }}</option>
                    <option value="2000000+" {{ request('price_range') == '2000000+' ? 'selected' : '' }}>{{ __('marketplace.over_2m') }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="height: 50px; padding: 0 2rem; border-radius: 12px;">Search</button>
        </form>
    </div>

    <!-- Services Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2.5rem;">
        @foreach($services as $service)
            <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; border-radius: 20px; transition: transform 0.3s ease;">
                <div style="height: 280px; position: relative;">
                    @if($service->main_image)
                        <img src="{{ asset('storage/' . $service->main_image) }}" alt="{{ $service->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #ccc;">
                            <svg style="width: 64px; height: 64px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div style="position: absolute; top: 1.25rem; left: 1.25rem;">
                        <span class="badge" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(10px); color: white; border: none; font-weight: 700; padding: 0.5rem 1rem;">{{ ucfirst($service->category) }}</span>
                    </div>
                </div>

                <div style="padding: 2rem; flex: 1; display: flex; flex-direction: column;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <h3 style="margin: 0; font-size: 1.5rem; letter-spacing: -0.02em;">{{ $service->title }}</h3>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $service->location }}
                    </div>

                    <div style="font-weight: 800; color: var(--dark-neutral); font-size: 1.5rem; margin-bottom: 1.5rem;">
                        RWF {{ number_format($service->price, 0) }}
                    </div>

                    <div style="display: flex; gap: 0.75rem; margin-top: auto; flex-wrap: wrap;">
                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-outline" style="flex: 1; border-radius: 12px; font-weight: 700; min-width: 100px;">View Details</a>
                        @auth
                            @if(auth()->user()->isClient())
                                @if($service->vendor)
                                    <a href="{{ route('chat.start', $service->vendor->user_id) }}" class="btn btn-outline" style="border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 0.3rem; padding: 0.6rem 1rem;" title="Chat with vendor">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        Chat
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('cart.add', $service->id) }}" style="flex: 1.5; min-width: 120px;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="width: 100%; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        {{ __('marketplace.add_to_cart') }}
                                    </button>
                                </form>
                            @endif
                        @else
                            <button onclick="window.openAuthModal('login')" class="btn btn-outline" style="border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 0.3rem; padding: 0.6rem 1rem; cursor: pointer; font-family: inherit;" title="Sign in to message vendor">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Chat
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($services->count() === 0)
        <div style="text-align: center; padding: 8rem 0;">
            <svg style="width: 80px; height: 80px; color: #ddd; margin-bottom: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <h2 style="color: var(--text-muted); font-size: 2rem;">{{ __('marketplace.no_services') }}</h2>
            <p style="color: var(--text-muted); font-size: 1.1rem;">{{ __('marketplace.try_adjusting') }}</p>
        </div>
    @endif
</div>
@endsection
