@extends('layouts.front')

@section('content')
<style>
/* ── Hero ── */
.hero { position: relative; padding: 7rem 0 5rem; background: var(--dark-neutral); overflow: hidden; }
.hero-bg { position: absolute; inset: 0; opacity: 0.45; }
.hero-bg img { width: 100%; height: 100%; object-fit: cover; }
.hero-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%); }
.hero-content { position: relative; z-index: 1; text-align: center; color: white; }
.hero-title { font-size: 3.5rem; font-weight: 800; line-height: 1.15; color: var(--primary-beige); letter-spacing: -0.03em; }
.hero-sub { font-size: 1.15rem; color: rgba(255,255,255,0.8); max-width: 520px; margin: 1rem auto 2rem; }

/* Search bar */
.hero-search { display: flex; max-width: 580px; margin: 0 auto 2.5rem; background: white; border-radius: 99px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.25); }
.hero-search input { flex: 1; border: none; outline: none; padding: 1rem 1.5rem; font-size: 0.95rem; font-family: inherit; color: #222; background: transparent; }
.hero-search button { background: var(--dark-neutral); color: white; border: none; padding: 0 1.75rem; font-size: 0.9rem; font-weight: 700; cursor: pointer; font-family: inherit; transition: background 0.2s; white-space: nowrap; }
.hero-search button:hover { background: #000; }

/* CTAs */
.hero-pills { display: flex; justify-content: center; gap: 0.5rem; flex-wrap: wrap; font-size: 0.82rem; color: rgba(255,255,255,0.6); }
.hero-pill { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 99px; padding: 0.3rem 0.9rem; color: rgba(255,255,255,0.8); text-decoration: none; transition: background 0.2s; }
.hero-pill:hover { background: rgba(255,255,255,0.2); color: white; }

/* ── Social proof ── */
.proof-bar { background: var(--soft-beige); border-bottom: 1px solid var(--border-color); padding: 1.25rem 0; }
.proof-items { display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap; }
.proof-item { text-align: center; }
.proof-num { font-size: 1.6rem; font-weight: 800; color: var(--dark-neutral); line-height: 1; }
.proof-lbl { font-size: 0.78rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.2rem; }

/* ── How it works ── */
.steps-section { padding: 5rem 0; }
.steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2.5rem; margin-top: 3rem; }
.step-card { text-align: center; padding: 2rem 1.5rem; background: white; border-radius: 20px; border: 1px solid var(--border-color); position: relative; }
.step-num { width: 48px; height: 48px; border-radius: 50%; background: var(--dark-neutral); color: var(--primary-beige); font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
.step-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
.step-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; }
.step-desc { font-size: 0.9rem; color: var(--text-muted); line-height: 1.6; }
.step-arrow { position: absolute; top: 50%; right: -1.5rem; transform: translateY(-50%); color: #ddd; font-size: 1.5rem; }

/* ── Categories ── */
.cats-section { padding: 5rem 0; background: var(--soft-beige); }
.cats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem; margin-top: 3rem; }
.cat-card { background: white; border-radius: 18px; overflow: hidden; border: 1px solid var(--border-color); text-decoration: none; color: inherit; display: block; transition: transform 0.2s, box-shadow 0.2s; }
.cat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.1); }
.cat-img { width: 100%; height: 180px; object-fit: cover; display: block; }
.cat-img-placeholder { width: 100%; height: 180px; background: var(--light-neutral); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
.cat-body { padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; }
.cat-name { font-weight: 700; font-size: 1rem; }
.cat-arrow { color: #aaa; font-size: 1.1rem; }

/* ── CTA Banner ── */
.cta-banner { background: var(--dark-neutral); color: white; padding: 5rem 0; text-align: center; }
.cta-title { font-size: 2.5rem; font-weight: 800; color: var(--primary-beige); margin-bottom: 1rem; letter-spacing: -0.03em; }
.cta-sub { font-size: 1.05rem; color: rgba(255,255,255,0.75); max-width: 480px; margin: 0 auto 2rem; }
.cta-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }

/* ── Section header ── */
.section-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: #888; font-weight: 700; margin-bottom: 0.5rem; }
.section-title { font-size: 2rem; font-weight: 800; color: var(--dark-neutral); letter-spacing: -0.02em; }
.section-sub { font-size: 1rem; color: var(--text-muted); margin-top: 0.5rem; }

/* ── Responsive ── */
@media (max-width: 768px) {
    .hero-title { font-size: 2.2rem; }
    .hero-sub { font-size: 1rem; }
    .steps-grid { grid-template-columns: 1fr; gap: 1.5rem; }
    .step-arrow { display: none; }
    .proof-items { gap: 1.5rem; }
    .cta-title { font-size: 1.75rem; }
}
@media (max-width: 480px) {
    .hero-search { border-radius: 14px; flex-direction: column; }
    .hero-search button { border-radius: 0 0 14px 14px; padding: 0.85rem; }
}
</style>

<!-- ═══ HERO ═══ -->
<section class="hero">
    <div class="hero-bg"><img src="{{ asset('images/hero-rwandan-couple.jpg') }}" alt="Wedding couple"></div>
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <p style="font-size: 0.8rem; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.55); margin-bottom: 0.75rem;">Rwanda's #1 Wedding Platform</p>
        <h1 class="hero-title">{!! __('home.hero_title') !!}</h1>
        <p class="hero-sub">{{ __('home.hero_subtitle') }}</p>

        <!-- Search bar -->
        <form action="{{ route('services.index') }}" method="GET">
            <div class="hero-search">
                <input type="text" name="search" placeholder="Search photographers, venues, caterers…" autocomplete="off">
                <button type="submit">Search</button>
            </div>
        </form>

        <!-- Quick category pills -->
        <div class="hero-pills">
            <span style="margin-right: 0.25rem;">Popular:</span>
            <a href="{{ route('services.index', ['category' => 'venue']) }}" class="hero-pill">Venues</a>
            <a href="{{ route('services.index', ['category' => 'photographer']) }}" class="hero-pill">Photography</a>
            <a href="{{ route('services.index', ['category' => 'catering']) }}" class="hero-pill">Catering</a>
            <a href="{{ route('services.index', ['category' => 'music']) }}" class="hero-pill">Music & DJ</a>
            <a href="{{ route('services.index', ['category' => 'beauty']) }}" class="hero-pill">Beauty</a>
        </div>
    </div>
</section>

<!-- ═══ SOCIAL PROOF ═══ -->
<div class="proof-bar">
    <div class="container">
        <div class="proof-items">
            @php
                $vendorCount = \App\Models\Vendor::where('status','approved')->count();
                $serviceCount = \App\Models\Service::where('status','active')->count();
                $bookingCount = \App\Models\Booking::count();
            @endphp
            <div class="proof-item">
                <div class="proof-num">{{ $vendorCount > 0 ? $vendorCount : '50+' }}</div>
                <div class="proof-lbl">Verified Vendors</div>
            </div>
            <div class="proof-item">
                <div class="proof-num">{{ $serviceCount > 0 ? $serviceCount : '200+' }}</div>
                <div class="proof-lbl">Services Listed</div>
            </div>
            <div class="proof-item">
                <div class="proof-num">{{ $bookingCount > 0 ? $bookingCount : '100+' }}</div>
                <div class="proof-lbl">Happy Couples</div>
            </div>
            <div class="proof-item">
                <div class="proof-num">100%</div>
                <div class="proof-lbl">Made for Rwanda</div>
            </div>
        </div>
    </div>
</div>

<!-- ═══ HOW IT WORKS ═══ -->
<section class="steps-section">
    <div class="container">
        <div style="text-align: center;">
            <p class="section-label">Simple Process</p>
            <h2 class="section-title">Plan your wedding in 3 easy steps</h2>
            <p class="section-sub">From idea to celebration — we make it effortless.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">1</div>
                <div class="step-icon">🔍</div>
                <div class="step-title">Browse & Discover</div>
                <div class="step-desc">Search verified vendors by category, location, and budget. Read reviews from real couples.</div>
                <div class="step-arrow">→</div>
            </div>
            <div class="step-card">
                <div class="step-num">2</div>
                <div class="step-icon">💬</div>
                <div class="step-title">Chat & Book</div>
                <div class="step-desc">Message vendors directly, ask questions, and confirm your booking — all in one place.</div>
                <div class="step-arrow">→</div>
            </div>
            <div class="step-card">
                <div class="step-num">3</div>
                <div class="step-icon">💍</div>
                <div class="step-title">Celebrate</div>
                <div class="step-desc">Use your personal dashboard to track tasks, manage guests, and count down to the big day.</div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2.5rem;">
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.875rem 2.5rem; font-size: 1rem;">Get Started — It's Free</a>
            @else
                <a href="{{ route('services.index') }}" class="btn btn-primary" style="padding: 0.875rem 2.5rem; font-size: 1rem;">Browse All Services</a>
            @endguest
        </div>
    </div>
</section>

<!-- ═══ CATEGORIES ═══ -->
<section class="cats-section">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 0;">
            <div>
                <p class="section-label">What We Offer</p>
                <h2 class="section-title">{{ __('home.everything_needed') }}</h2>
            </div>
            <a href="{{ route('services.index') }}" style="font-weight: 700; color: var(--dark-neutral); font-size: 0.9rem;">View all services →</a>
        </div>

        <div class="cats-grid">
            <a href="{{ route('services.index', ['category' => 'venue']) }}" class="cat-card">
                <img src="{{ asset('images/category-venue.png') }}" class="cat-img" alt="Venues" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="cat-img-placeholder" style="display:none;">🏛️</div>
                <div class="cat-body"><span class="cat-name">{{ __('home.venues') }}</span><span class="cat-arrow">→</span></div>
            </a>
            <a href="{{ route('services.index', ['category' => 'photographer']) }}" class="cat-card">
                <img src="{{ asset('images/category-photo.png') }}" class="cat-img" alt="Photography" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="cat-img-placeholder" style="display:none;">📷</div>
                <div class="cat-body"><span class="cat-name">{{ __('home.photography') }}</span><span class="cat-arrow">→</span></div>
            </a>
            <a href="{{ route('services.index', ['category' => 'catering']) }}" class="cat-card">
                <img src="{{ asset('images/category-venue.png') }}" class="cat-img" alt="Catering" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="cat-img-placeholder" style="display:none;">🍽️</div>
                <div class="cat-body"><span class="cat-name">Catering</span><span class="cat-arrow">→</span></div>
            </a>
            <a href="{{ route('services.index', ['category' => 'music']) }}" class="cat-card">
                <img src="{{ asset('images/music-live-band.jpg') }}" class="cat-img" alt="Music" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="cat-img-placeholder" style="display:none;">🎶</div>
                <div class="cat-body"><span class="cat-name">{{ __('home.music') }}</span><span class="cat-arrow">→</span></div>
            </a>
            <a href="{{ route('services.index', ['category' => 'beauty']) }}" class="cat-card">
                <img src="{{ asset('images/beauty.png') }}" class="cat-img" alt="Beauty" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="cat-img-placeholder" style="display:none;">💄</div>
                <div class="cat-body"><span class="cat-name">{{ __('home.beauty') }}</span><span class="cat-arrow">→</span></div>
            </a>
            <a href="{{ route('services.index', ['category' => 'clothing']) }}" class="cat-card">
                <img src="{{ asset('images/category-clothing.png') }}" class="cat-img" alt="Attire" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="cat-img-placeholder" style="display:none;">👗</div>
                <div class="cat-body"><span class="cat-name">{{ __('home.attire') }}</span><span class="cat-arrow">→</span></div>
            </a>
        </div>
    </div>
</section>

<!-- ═══ AI BUDGET PLANNER HIGHLIGHT ═══ -->
<section style="padding: 5rem 0; background: white;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
            <div>
                <p class="section-label">Smart Planning</p>
                <h2 class="section-title" style="margin-bottom: 1rem;">Not sure where to start? <br>Let AI plan it for you.</h2>
                <p style="color: var(--text-muted); line-height: 1.7; margin-bottom: 1.5rem;">Enter your budget and wedding date. Our AI automatically finds the best vendors, splits your budget across services, and creates a full plan — in seconds.</p>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem;">
                        <span style="width: 24px; height: 24px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #166534; font-weight: 700; flex-shrink: 0;">✓</span>
                        Auto budget allocation across categories
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem;">
                        <span style="width: 24px; height: 24px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #166534; font-weight: 700; flex-shrink: 0;">✓</span>
                        Top-rated vendors matched to your style
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem;">
                        <span style="width: 24px; height: 24px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #166534; font-weight: 700; flex-shrink: 0;">✓</span>
                        Book everything in one click
                    </div>
                </div>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.875rem 2rem;">Try AI Planner — Free</a>
                @else
                    <a href="{{ route('budget.planner') }}" class="btn btn-primary" style="padding: 0.875rem 2rem;">🤖 Open AI Planner</a>
                @endguest
            </div>
            <div style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 24px; padding: 2.5rem; color: white;">
                <div style="font-size: 0.8rem; color: #9bf6af; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;">AI Budget Preview</div>
                @php
                    $categories = [
                        ['icon' => '🏛️', 'name' => 'Venue', 'pct' => 35, 'color' => '#9bf6af'],
                        ['icon' => '📷', 'name' => 'Photography', 'pct' => 20, 'color' => '#60a5fa'],
                        ['icon' => '🍽️', 'name' => 'Catering', 'pct' => 25, 'color' => '#f59e0b'],
                        ['icon' => '🎶', 'name' => 'Music', 'pct' => 10, 'color' => '#a78bfa'],
                        ['icon' => '💄', 'name' => 'Beauty', 'pct' => 10, 'color' => '#f472b6'],
                    ];
                @endphp
                @foreach($categories as $cat)
                    <div style="margin-bottom: 1.1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; margin-bottom: 0.3rem;">
                            <span>{{ $cat['icon'] }} {{ $cat['name'] }}</span>
                            <span style="color: {{ $cat['color'] }}; font-weight: 700;">{{ $cat['pct'] }}%</span>
                        </div>
                        <div style="background: rgba(255,255,255,0.1); border-radius: 99px; height: 6px;">
                            <div style="width: {{ $cat['pct'] }}%; height: 100%; background: {{ $cat['color'] }}; border-radius: 99px;"></div>
                        </div>
                    </div>
                @endforeach
                <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.8rem; color: rgba(255,255,255,0.5);">Based on a sample budget of 5,000,000 RWF</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ FINAL CTA ═══ -->
<section class="cta-banner">
    <div class="container">
        @guest
            <h2 class="cta-title">Your perfect wedding starts here.</h2>
            <p class="cta-sub">Join hundreds of couples who planned their dream wedding on IntelliWed.</p>
            <div class="cta-btns">
                <a href="{{ route('register') }}" class="btn btn-secondary" style="padding: 0.875rem 2.5rem; font-size: 1rem;">Create Free Account</a>
                <a href="{{ route('services.index') }}" class="btn btn-outline" style="padding: 0.875rem 2rem; font-size: 1rem; border-color: rgba(255,255,255,0.4); color: white;">Browse Vendors</a>
            </div>
        @else
            <h2 class="cta-title">Keep planning, {{ auth()->user()->name }}.</h2>
            <p class="cta-sub">Your dashboard has everything you need for the big day.</p>
            <div class="cta-btns">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="padding: 0.875rem 2.5rem; font-size: 1rem;">Go to Dashboard</a>
                <a href="{{ route('services.index') }}" class="btn btn-outline" style="padding: 0.875rem 2rem; font-size: 1rem; border-color: rgba(255,255,255,0.4); color: white;">Browse Services</a>
            </div>
        @endauth
    </div>
</section>
@endsection
