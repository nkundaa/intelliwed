@extends('layouts.front')

@section('content')
<style>
    /* Mobile fixes for home page */
    @media (max-width: 768px) {
        .hero-section {
            padding: 4rem 1rem !important;
        }
        
        .hero-title {
            font-size: 2rem !important;
        }
        
        .hero-subtitle {
            font-size: 1rem !important;
            padding: 0 1rem !important;
        }
        
        .hero-buttons {
            flex-direction: column !important;
            gap: 1rem !important;
            width: 100% !important;
            padding: 0 1rem !important;
        }
        
        .hero-buttons a {
            width: 100% !important;
            text-align: center !important;
        }
        
        .section-title {
            font-size: 1.75rem !important;
        }
        
        .features-grid {
            grid-template-columns: 1fr !important;
            gap: 1.5rem !important;
        }
        
        .two-column-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
            text-align: center !important;
        }
        
        .feature-two-col {
            grid-template-columns: 1fr !important;
        }
        
        .cta-title {
            font-size: 2rem !important;
        }
        
        .category-card img {
            height: 180px !important;
        }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
        .hero-title {
            font-size: 3rem !important;
        }
        
        .features-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
</style>

<!-- Hero Section -->
<section style="position: relative; padding: 6rem 0; background: var(--dark-neutral); overflow: hidden;" class="hero-section">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.6;">
        <img src="{{ asset('images/hero-rwandan-couple.jpg') }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    <div class="container" style="position: relative; z-index: 1; text-align: center; color: var(--white);">
        <h1 style="font-size: 3.5rem; color: var(--primary-beige); margin-bottom: 1.5rem; line-height: 1.2;" class="hero-title">{!! __('home.hero_title') !!}</h1>
        <p style="font-size: 1.2rem; max-width: 600px; margin: 0 auto 2rem; color: #ccc;" class="hero-subtitle">{{ __('home.hero_subtitle') }}</p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;" class="hero-buttons">
            @guest
                <a href="{{ route('register') }}" class="btn btn-secondary" style="padding: 0.875rem 2rem; font-size: 1rem;">{{ __('home.get_started') }}</a>
            @else
                <a href="{{ route('budget.planner') }}" class="btn btn-secondary" style="padding: 0.875rem 2rem; font-size: 1rem;">{{ __('home.plan_budget') }}</a>
            @endguest
            <a href="{{ route('services.index') }}" class="btn btn-outline" style="padding: 0.875rem 2rem; font-size: 1rem; border-color: var(--white); color: var(--white);">{{ __('home.explore_services') }}</a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section style="padding: 4rem 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-size: 2rem; margin-bottom: 1rem;" class="section-title">{{ __('home.everything_needed') }}</h2>
            <p style="color: var(--text-muted); font-size: 1rem;">{{ __('home.everything_needed_subtitle') }}</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;" class="features-grid">
            <!-- Venue -->
            <div class="card" style="padding: 0; overflow: hidden;" class="category-card">
                <img src="{{ asset('images/category-venue.png') }}" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 0.5rem; font-size: 1.25rem;">{{ __('home.venues') }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">{{ __('home.venues_desc') }}</p>
                    <a href="{{ route('services.index', ['category' => 'venue']) }}" style="font-weight: 600; color: var(--dark-neutral); display: inline-block;">{{ __('home.browse_venues') }} →</a>
                </div>
            </div>

            <div class="card" style="padding: 0; overflow: hidden;" class="category-card">
                <img src="{{ asset('images/music-live-band.jpg') }}" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 0.5rem; font-size: 1.25rem;">{{ __('home.music') }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">{{ __('home.music_desc') }}</p>
                    <a href="{{ route('services.index', ['category' => 'music']) }}" style="font-weight: 600; color: var(--dark-neutral); display: inline-block;">{{ __('home.browse_music') }} →</a>
                </div>
            </div>

            <div class="card" style="padding: 0; overflow: hidden;" class="category-card">
                <img src="{{ asset('images/beauty.png') }}" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 0.5rem; font-size: 1.25rem;">{{ __('home.beauty') }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">{{ __('home.beauty_desc') }}</p>
                    <a href="{{ route('services.index', ['category' => 'beauty']) }}" style="font-weight: 600; color: var(--dark-neutral); display: inline-block;">{{ __('home.browse_beauty') }} →</a>
                </div>
            </div>

            <!-- Photographer -->
            <div class="card" style="padding: 0; overflow: hidden;" class="category-card">
                <img src="{{ asset('images/category-photo.png') }}" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 0.5rem; font-size: 1.25rem;">{{ __('home.photography') }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">{{ __('home.photography_desc') }}</p>
                    <a href="{{ route('services.index', ['category' => 'photographer']) }}" style="font-weight: 600; color: var(--dark-neutral); display: inline-block;">{{ __('home.browse_photography') }} →</a>
                </div>
            </div>

            <!-- Clothing -->
            <div class="card" style="padding: 0; overflow: hidden;" class="category-card">
                <img src="{{ asset('images/category-clothing.png') }}" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 0.5rem; font-size: 1.25rem;">{{ __('home.attire') }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">{{ __('home.attire_desc') }}</p>
                    <a href="{{ route('services.index', ['category' => 'clothing']) }}" style="font-weight: 600; color: var(--dark-neutral); display: inline-block;">{{ __('home.browse_attire') }} →</a>
                </div>
            </div>

            <!-- Cars -->
            <div class="card" style="padding: 0; overflow: hidden;" class="category-card">
                <img src="{{ asset('images/category-car.png') }}" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 0.5rem; font-size: 1.25rem;">{{ __('home.transport') }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">{{ __('home.transport_desc') }}</p>
                    <a href="{{ route('services.index', ['category' => 'transport']) }}" style="font-weight: 600; color: var(--dark-neutral); display: inline-block;">{{ __('home.browse_transport') }} →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Budget Planner CTA Section -->
<section style="padding: 4rem 0; background: var(--dark-neutral); color: white;">
    <div class="container">
        <div style="text-align: center;">
            <h2 style="font-size: 2rem; margin-bottom: 1rem;" class="section-title">{{ __('home.budget_confused') }}</h2>
            <p style="font-size: 1rem; margin-bottom: 2rem; opacity: 0.95; max-width: 600px; margin-left: auto; margin-right: auto;">{{ __('home.budget_desc') }}</p>
            @auth
                <a href="{{ route('budget.planner') }}" class="btn btn-secondary" style="padding: 0.875rem 2rem; font-size: 1rem; display: inline-block;">
                    🎯 {{ __('home.plan_now') }}
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-secondary" style="padding: 0.875rem 2rem; font-size: 1rem; display: inline-block;">
                    🎯 {{ __('home.register_start') }}
                </a>
            @endauth
        </div>
    </div>
</section>

<!-- Features Section -->
<section style="padding: 4rem 0; background-color: var(--soft-beige);">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;" class="two-column-grid">
            <div>
                <h2 style="font-size: 2rem; margin-bottom: 1.5rem; line-height: 1.2;" class="section-title">{!! __('home.planning_reimagined') !!}</h2>
                <p style="font-size: 1rem; color: var(--text-muted); margin-bottom: 2rem;">{{ __('home.planning_desc') }}</p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;" class="feature-two-col">
                    <div>
                        <h4 style="margin-bottom: 0.5rem; font-size: 1.1rem;">{{ __('home.easy_booking') }}</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted);">{{ __('home.easy_booking_desc') }}</p>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 0.5rem; font-size: 1.1rem;">{{ __('home.verified_vendors') }}</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted);">{{ __('home.verified_vendors_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="card" style="padding: 0; overflow: hidden; height: 350px;">
                <img src="{{ asset('images/category-venue.png') }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="padding: 4rem 0; text-align: center;">
    <div class="container">
        @guest
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;" class="cta-title">{{ __('home.ready_start') }}</h2>
            <p style="font-size: 1.1rem; color: var(--text-muted); margin-bottom: 2rem;">{{ __('home.join_today') }}</p>
            <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.875rem 2.5rem; font-size: 1rem; display: inline-block;">{{ __('home.create_account') }}</a>
        @else
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;" class="cta-title">{{ __('home.ready_plan') }}</h2>
            <p style="font-size: 1.1rem; color: var(--text-muted); margin-bottom: 2rem;">{{ __('home.continue_planning') }}</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 0.875rem 2.5rem; font-size: 1rem; display: inline-block;">{{ __('home.go_dashboard') }}</a>
        @endguest
    </div>
</section>
@endsection