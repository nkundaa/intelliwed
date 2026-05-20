@extends('layouts.front')

@section('content')
<style>
/* ── Hero ── */
.hero {
    position: relative;
    padding: 7rem 0 5rem;
    background: var(--dark-neutral);
    overflow: hidden;
}
.hero-bg { position: absolute; inset: 0; opacity: 0.4; }
.hero-bg img { width: 100%; height: 100%; object-fit: cover; }
.hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 60%, rgba(155,246,175,0.08) 100%);
}
.hero-content { position: relative; z-index: 1; text-align: center; color: white; }
.hero-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: rgba(155,246,175,0.15); border: 1px solid rgba(155,246,175,0.35);
    color: #9bf6af; border-radius: 99px;
    padding: 0.35rem 0.9rem; font-size: 0.78rem; font-weight: 600;
    letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 1.5rem;
}
.hero-title {
    font-size: clamp(2.4rem, 5vw, 4rem); font-weight: 800;
    line-height: 1.1; color: white; letter-spacing: -0.03em;
    margin-bottom: 0.5rem;
}
.hero-title span { color: var(--primary-beige); }
.hero-sub {
    font-size: 1.1rem; color: rgba(255,255,255,0.75);
    max-width: 520px; margin: 0.75rem auto 2rem; line-height: 1.65;
}

/* Search bar */
.hero-search {
    display: flex; max-width: 600px; margin: 0 auto 2rem;
    background: white; border-radius: 99px; overflow: hidden;
    box-shadow: 0 12px 40px rgba(0,0,0,0.3);
}
.hero-search input {
    flex: 1; border: none; outline: none;
    padding: 1rem 1.5rem; font-size: 0.95rem;
    font-family: inherit; color: #222; background: transparent;
}
.hero-search button {
    background: var(--dark-neutral); color: #9bf6af;
    border: none; padding: 0 1.75rem;
    font-size: 0.9rem; font-weight: 700; cursor: pointer;
    font-family: inherit; transition: background 0.2s; white-space: nowrap;
    display: flex; align-items: center; gap: 0.4rem;
}
.hero-search button:hover { background: #000; }

/* Quick pills */
.hero-pills {
    display: flex; justify-content: center; gap: 0.5rem;
    flex-wrap: wrap; font-size: 0.82rem;
    color: rgba(255,255,255,0.55); margin-bottom: 3rem;
}
.hero-pill {
    background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
    border-radius: 99px; padding: 0.3rem 0.9rem;
    color: rgba(255,255,255,0.8); text-decoration: none;
    transition: all 0.2s;
}
.hero-pill:hover { background: rgba(155,246,175,0.2); border-color: rgba(155,246,175,0.4); color: #9bf6af; }

/* Hero floating cards */
.hero-cards {
    display: flex; justify-content: center; gap: 1rem;
    flex-wrap: wrap; margin-top: 1rem;
}
.hero-stat-card {
    background: rgba(255,255,255,0.1); backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2); border-radius: 14px;
    padding: 1rem 1.5rem; text-align: center;
}
.hero-stat-card .num { font-size: 1.75rem; font-weight: 800; color: #9bf6af; line-height: 1; }
.hero-stat-card .lbl { font-size: 0.75rem; color: rgba(255,255,255,0.6); margin-top: 0.25rem; }

/* ── Section header ── */
.section-label {
    font-size: 0.75rem; text-transform: uppercase;
    letter-spacing: 0.1em; color: #9bf6af; font-weight: 700;
    margin-bottom: 0.5rem; display: block;
}
.section-title {
    font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800;
    color: var(--dark-neutral); letter-spacing: -0.02em; line-height: 1.2;
}
.section-sub {
    font-size: 1rem; color: var(--text-muted);
    margin-top: 0.5rem; line-height: 1.6; max-width: 560px;
}

/* ── Why IntelliWed ── */
.why-section { padding: 5rem 0; background: var(--soft-beige); }
.why-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.75rem; margin-top: 3rem;
}
.why-card {
    background: white; border-radius: 20px; padding: 2rem 1.75rem;
    border: 1px solid var(--border-color); transition: transform 0.2s, box-shadow 0.2s;
}
.why-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,0.1); }
.why-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--dark-neutral); color: #9bf6af;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; margin-bottom: 1.25rem;
}
.why-title { font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; }
.why-desc { font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; }

/* ── Services Grid ── */
.services-section { padding: 5rem 0; background: white; }
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.25rem; margin-top: 2.5rem;
}
.service-card {
    background: white; border-radius: 18px; overflow: hidden;
    border: 1px solid var(--border-color); text-decoration: none;
    color: inherit; display: block;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
}
.service-card:hover { transform: translateY(-4px); box-shadow: 0 14px 36px rgba(0,0,0,0.1); }
.service-img { width: 100%; height: 185px; object-fit: cover; display: block; }
.service-img-placeholder {
    width: 100%; height: 185px;
    display: flex; align-items: center; justify-content: center;
    font-size: 3rem;
}
.service-body { padding: 1.1rem 1.4rem 1.4rem; }
.service-name { font-weight: 700; font-size: 1rem; margin-bottom: 0.3rem; }
.service-hint { font-size: 0.82rem; color: var(--text-muted); }
.service-arrow {
    position: absolute; bottom: 1.2rem; right: 1.2rem;
    width: 32px; height: 32px; background: var(--dark-neutral);
    color: #9bf6af; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; opacity: 0; transition: opacity 0.2s;
}
.service-card:hover .service-arrow { opacity: 1; }

/* ── How it works ── */
.steps-section { padding: 5rem 0; background: var(--soft-beige); }
.steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 3rem; }
.step-card {
    text-align: center; padding: 2.5rem 1.75rem;
    background: white; border-radius: 22px; border: 1px solid var(--border-color);
    position: relative; transition: transform 0.2s;
}
.step-card:hover { transform: translateY(-4px); }
.step-num {
    width: 52px; height: 52px; border-radius: 50%;
    background: var(--dark-neutral); color: var(--primary-beige);
    font-weight: 800; font-size: 1.1rem;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem;
}
.step-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
.step-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; }
.step-desc { font-size: 0.88rem; color: var(--text-muted); line-height: 1.65; }
.step-connector {
    position: absolute; top: 50%; right: -1.1rem;
    transform: translateY(-50%); z-index: 1;
    color: var(--dark-neutral); font-weight: 700; font-size: 1.25rem;
}

/* ── AI Budget Planner ── */
.ai-section { padding: 5rem 0; background: white; }
.ai-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
.ai-check {
    display: flex; align-items: center; gap: 0.75rem;
    font-size: 0.95rem; margin-bottom: 0.75rem;
}
.ai-check-icon {
    width: 26px; height: 26px; background: #dcfce7; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem; color: #166534; font-weight: 700; flex-shrink: 0;
}
.ai-preview {
    background: linear-gradient(135deg, #111 0%, #222 100%);
    border-radius: 24px; padding: 2rem; color: white;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
}

/* ── Testimonials ── */
.testimonials-section { padding: 5rem 0; background: var(--dark-neutral); }
.testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.75rem; margin-top: 3rem; }
.testimonial-card {
    background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px; padding: 2rem;
    transition: background 0.2s;
}
.testimonial-card:hover { background: rgba(255,255,255,0.1); }
.testimonial-stars { color: #fbbf24; font-size: 1rem; margin-bottom: 1rem; }
.testimonial-text { color: rgba(255,255,255,0.8); font-size: 0.92rem; line-height: 1.7; margin-bottom: 1.5rem; font-style: italic; }
.testimonial-author { display: flex; align-items: center; gap: 0.75rem; }
.testimonial-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    background: var(--primary-beige); color: var(--dark-neutral);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 0.9rem; flex-shrink: 0;
}
.testimonial-name { font-weight: 700; font-size: 0.9rem; color: white; }
.testimonial-meta { font-size: 0.78rem; color: rgba(255,255,255,0.5); margin-top: 0.15rem; }

/* ── CTA Banner ── */
.cta-banner { background: white; padding: 5rem 0; text-align: center; border-top: 1px solid var(--border-color); }
.cta-inner {
    background: var(--dark-neutral); border-radius: 28px;
    padding: 4rem 3rem; max-width: 800px; margin: 0 auto;
    position: relative; overflow: hidden;
}
.cta-inner::before {
    content: ''; position: absolute; top: -60px; right: -60px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(155,246,175,0.08);
}
.cta-title { font-size: clamp(1.8rem, 3.5vw, 2.4rem); font-weight: 800; color: var(--primary-beige); margin-bottom: 1rem; letter-spacing: -0.03em; position: relative; }
.cta-sub { font-size: 1rem; color: rgba(255,255,255,0.7); max-width: 460px; margin: 0 auto 2rem; position: relative; }
.cta-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; position: relative; }

/* ── Responsive ── */
@media (max-width: 900px) {
    .ai-grid { grid-template-columns: 1fr; gap: 2.5rem; }
    .testimonials-grid { grid-template-columns: 1fr; gap: 1.25rem; }
}
@media (max-width: 768px) {
    .hero-title { font-size: 2.2rem; }
    .steps-grid { grid-template-columns: 1fr; gap: 1.5rem; }
    .step-connector { display: none; }
    .hero-cards { gap: 0.75rem; }
    .cta-inner { padding: 2.5rem 1.5rem; }
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
        <div class="hero-badge">
            <span>🌿</span> Rwanda's #1 Wedding Platform
        </div>
        <h1 class="hero-title">
            Plan Your Dream<br>
            <span>Rwandan Wedding</span>
        </h1>
        <p class="hero-sub">Discover verified vendors, manage your budget, track every detail — all in one beautiful platform built for Rwandan couples.</p>

        <!-- Search bar -->
        <form action="{{ route('services.index') }}" method="GET">
            <div class="hero-search">
                <input type="text" name="search" placeholder="Search photographers, venues, caterers…" autocomplete="off">
                <button type="submit">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
            </div>
        </form>

        <!-- Quick category pills -->
        <div class="hero-pills">
            <span style="margin-right: 0.25rem; color: rgba(255,255,255,0.4);">Popular:</span>
            <a href="{{ route('services.index', ['category' => 'venue']) }}" class="hero-pill">Venues</a>
            <a href="{{ route('services.index', ['category' => 'photographer']) }}" class="hero-pill">Photography</a>
            <a href="{{ route('services.index', ['category' => 'catering']) }}" class="hero-pill">Catering</a>
            <a href="{{ route('services.index', ['category' => 'music']) }}" class="hero-pill">Music & DJ</a>
            <a href="{{ route('services.index', ['category' => 'beauty']) }}" class="hero-pill">Beauty</a>
            <a href="{{ route('services.index', ['category' => 'decoration']) }}" class="hero-pill">Decoration</a>
        </div>

        <!-- Stats cards -->
        <div class="hero-cards">
            @php
                $vendorCount = \App\Models\Vendor::where('status','approved')->count();
                $serviceCount = \App\Models\Service::where('status','active')->count();
                $bookingCount = \App\Models\Booking::count();
            @endphp
            <div class="hero-stat-card">
                <div class="num">{{ $vendorCount > 0 ? $vendorCount . '+' : '50+' }}</div>
                <div class="lbl">Verified Vendors</div>
            </div>
            <div class="hero-stat-card">
                <div class="num">{{ $serviceCount > 0 ? $serviceCount . '+' : '200+' }}</div>
                <div class="lbl">Services Listed</div>
            </div>
            <div class="hero-stat-card">
                <div class="num">{{ $bookingCount > 0 ? $bookingCount . '+' : '100+' }}</div>
                <div class="lbl">Happy Couples</div>
            </div>
            <div class="hero-stat-card">
                <div class="num">100%</div>
                <div class="lbl">Made for Rwanda</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ WHY INTELLIWED ═══ -->
<section class="why-section">
    <div class="container">
        <div style="text-align: center;">
            <span class="section-label">Why Choose Us</span>
            <h2 class="section-title">Everything you need for the perfect day</h2>
            <p class="section-sub" style="margin: 0.5rem auto 0;">One platform, every wedding service — from venue hunting to AI-powered budget planning.</p>
        </div>

        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">✅</div>
                <div class="why-title">Verified Vendors Only</div>
                <div class="why-desc">Every vendor is reviewed and approved. No scams, no surprises — just trusted professionals.</div>
            </div>
            <div class="why-card">
                <div class="why-icon">💬</div>
                <div class="why-title">Direct Messaging</div>
                <div class="why-desc">Chat directly with vendors, ask questions, share your vision, and confirm details — all in-app.</div>
            </div>
            <div class="why-card">
                <div class="why-icon">🤖</div>
                <div class="why-title">AI Budget Planner</div>
                <div class="why-desc">Enter your budget and let our AI automatically allocate funds and suggest the best vendors.</div>
            </div>
            <div class="why-card">
                <div class="why-icon">📋</div>
                <div class="why-title">Smart Checklists</div>
                <div class="why-desc">Never miss a task. Our smart checklist guides you from engagement to "I do" with reminders.</div>
            </div>
            <div class="why-card">
                <div class="why-icon">👥</div>
                <div class="why-title">Guest Management</div>
                <div class="why-desc">Send digital invitations, track RSVPs, and manage your guest list from one clean dashboard.</div>
            </div>
            <div class="why-card">
                <div class="why-icon">🌍</div>
                <div class="why-title">Built for Rwanda</div>
                <div class="why-desc">Designed with Rwandan culture in mind — Kinyarwanda ceremonies, local vendors, RWF pricing.</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ SERVICES CATEGORIES ═══ -->
<section class="services-section">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 0;">
            <div>
                <span class="section-label">Service Categories</span>
                <h2 class="section-title">{{ __('home.everything_needed') }}</h2>
                <p class="section-sub">Browse top wedding services from Rwanda's finest professionals.</p>
            </div>
            <a href="{{ route('services.index') }}" style="font-weight: 700; color: var(--dark-neutral); font-size: 0.9rem; display: flex; align-items: center; gap: 0.3rem;">View all services <span>→</span></a>
        </div>

        <div class="services-grid">
            <a href="{{ route('services.index', ['category' => 'venue']) }}" class="service-card">
                <img src="{{ asset('images/category-venue.png') }}" class="service-img" alt="Venues" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="service-img-placeholder" style="display:none; background: #fff3e0;">🏛️</div>
                <div class="service-body">
                    <div class="service-name">Venues & Halls</div>
                    <div class="service-hint">Gardens, ballrooms, churches &amp; more</div>
                </div>
                <div class="service-arrow">→</div>
            </a>
            <a href="{{ route('services.index', ['category' => 'photographer']) }}" class="service-card">
                <img src="{{ asset('images/category-photo.png') }}" class="service-img" alt="Photography" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="service-img-placeholder" style="display:none; background: #e3f2fd;">📷</div>
                <div class="service-body">
                    <div class="service-name">Photography &amp; Video</div>
                    <div class="service-hint">Capture every precious moment</div>
                </div>
                <div class="service-arrow">→</div>
            </a>
            <a href="{{ route('services.index', ['category' => 'catering']) }}" class="service-card">
                <img src="{{ asset('images/category-catering.png') }}" class="service-img" alt="Catering" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="service-img-placeholder" style="display:none; background: #f3e5f5;">🍽️</div>
                <div class="service-body">
                    <div class="service-name">Catering &amp; Cuisine</div>
                    <div class="service-hint">Traditional &amp; contemporary menus</div>
                </div>
                <div class="service-arrow">→</div>
            </a>
            <a href="{{ route('services.index', ['category' => 'music']) }}" class="service-card">
                <img src="{{ asset('images/music-live-band.jpg') }}" class="service-img" alt="Music" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="service-img-placeholder" style="display:none; background: #e8f5e9;">🎶</div>
                <div class="service-body">
                    <div class="service-name">Music &amp; Entertainment</div>
                    <div class="service-hint">DJs, live bands &amp; performers</div>
                </div>
                <div class="service-arrow">→</div>
            </a>
            <a href="{{ route('services.index', ['category' => 'beauty']) }}" class="service-card">
                <img src="{{ asset('images/beauty.png') }}" class="service-img" alt="Beauty" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="service-img-placeholder" style="display:none; background: #fce4ec;">💄</div>
                <div class="service-body">
                    <div class="service-name">Beauty &amp; Makeup</div>
                    <div class="service-hint">Bridal beauty teams &amp; stylists</div>
                </div>
                <div class="service-arrow">→</div>
            </a>
            <a href="{{ route('services.index', ['category' => 'clothing']) }}" class="service-card">
                <img src="{{ asset('images/category-clothing.png') }}" class="service-img" alt="Attire" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="service-img-placeholder" style="display:none; background: #e0f7fa;">👗</div>
                <div class="service-body">
                    <div class="service-name">Wedding Attire</div>
                    <div class="service-hint">Gowns, suits &amp; traditional wear</div>
                </div>
                <div class="service-arrow">→</div>
            </a>
            <a href="{{ route('services.index', ['category' => 'decoration']) }}" class="service-card">
                <div class="service-img-placeholder" style="background: linear-gradient(135deg,#fff9c4,#fff3e0);">🌸</div>
                <div class="service-body">
                    <div class="service-name">Floral &amp; Decoration</div>
                    <div class="service-hint">Flowers, centrepieces &amp; themes</div>
                </div>
                <div class="service-arrow">→</div>
            </a>
            <a href="{{ route('services.index', ['category' => 'transport']) }}" class="service-card">
                <div class="service-img-placeholder" style="background: linear-gradient(135deg,#e3f2fd,#bbdefb);">🚗</div>
                <div class="service-body">
                    <div class="service-name">Transport &amp; Transfers</div>
                    <div class="service-hint">Luxury cars &amp; bridal transport</div>
                </div>
                <div class="service-arrow">→</div>
            </a>
            <a href="{{ route('services.index', ['category' => 'officiant']) }}" class="service-card">
                <div class="service-img-placeholder" style="background: linear-gradient(135deg,#f3e5f5,#e1bee7);">📿</div>
                <div class="service-body">
                    <div class="service-name">Ceremony &amp; Officiant</div>
                    <div class="service-hint">Civil, church &amp; traditional rites</div>
                </div>
                <div class="service-arrow">→</div>
            </a>
        </div>
    </div>
</section>

<!-- ═══ HOW IT WORKS ═══ -->
<section class="steps-section">
    <div class="container">
        <div style="text-align: center;">
            <span class="section-label">Simple Process</span>
            <h2 class="section-title">Plan your wedding in 3 easy steps</h2>
            <p class="section-sub" style="margin: 0.5rem auto 0;">From idea to celebration — we make it effortless.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">1</div>
                <div class="step-icon">🔍</div>
                <div class="step-title">Browse &amp; Discover</div>
                <div class="step-desc">Search verified vendors by category, location, and budget. Read reviews from real couples just like you.</div>
                <div class="step-connector">→</div>
            </div>
            <div class="step-card">
                <div class="step-num">2</div>
                <div class="step-icon">💬</div>
                <div class="step-title">Chat &amp; Book</div>
                <div class="step-desc">Message vendors directly, ask questions, and confirm your booking — all in one place, no phone tag.</div>
                <div class="step-connector">→</div>
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

<!-- ═══ AI BUDGET PLANNER ═══ -->
<section class="ai-section">
    <div class="container">
        <div class="ai-grid">
            <div>
                <span class="section-label">Smart Planning</span>
                <h2 class="section-title" style="margin-bottom: 1rem;">Not sure where to start?<br>Let AI plan it for you.</h2>
                <p style="color: var(--text-muted); line-height: 1.7; margin-bottom: 1.5rem;">Enter your budget and wedding date. Our AI automatically finds the best vendors, splits your budget across services, and creates a full plan — in seconds.</p>
                <div class="ai-check"><div class="ai-check-icon">✓</div>Auto budget allocation across all categories</div>
                <div class="ai-check"><div class="ai-check-icon">✓</div>Top-rated vendors matched to your style &amp; budget</div>
                <div class="ai-check"><div class="ai-check-icon">✓</div>Full wedding checklist generated automatically</div>
                <div class="ai-check"><div class="ai-check-icon">✓</div>Book everything with one click</div>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 2rem;">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.875rem 2rem;">Try AI Planner — Free</a>
                        <a href="{{ route('services.index') }}" class="btn btn-outline" style="padding: 0.875rem 2rem;">Browse Vendors</a>
                    @else
                        <a href="{{ route('budget.planner') }}" class="btn btn-primary" style="padding: 0.875rem 2rem;">🤖 Open AI Planner</a>
                        <a href="{{ route('services.index') }}" class="btn btn-outline" style="padding: 0.875rem 2rem;">Browse Vendors</a>
                    @endguest
                </div>
            </div>
            <div class="ai-preview">
                <div style="font-size: 0.78rem; color: #9bf6af; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">AI Budget Preview</div>
                <div style="font-size: 1.1rem; font-weight: 700; color: white; margin-bottom: 1.5rem;">Sample: 5,000,000 RWF</div>
                @php
                    $aiCategories = [
                        ['icon' => '🏛️', 'name' => 'Venue', 'pct' => 35, 'color' => '#9bf6af'],
                        ['icon' => '📷', 'name' => 'Photography', 'pct' => 20, 'color' => '#60a5fa'],
                        ['icon' => '🍽️', 'name' => 'Catering', 'pct' => 25, 'color' => '#f59e0b'],
                        ['icon' => '🎶', 'name' => 'Music', 'pct' => 10, 'color' => '#a78bfa'],
                        ['icon' => '💄', 'name' => 'Beauty', 'pct' => 10, 'color' => '#f472b6'],
                    ];
                @endphp
                @foreach($aiCategories as $cat)
                    <div style="margin-bottom: 1.1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; margin-bottom: 0.4rem;">
                            <span style="color: rgba(255,255,255,0.85);">{{ $cat['icon'] }} {{ $cat['name'] }}</span>
                            <span style="color: {{ $cat['color'] }}; font-weight: 700;">{{ $cat['pct'] }}%</span>
                        </div>
                        <div style="background: rgba(255,255,255,0.08); border-radius: 99px; height: 7px;">
                            <div style="width: {{ $cat['pct'] }}%; height: 100%; background: {{ $cat['color'] }}; border-radius: 99px; transition: width 1s;"></div>
                        </div>
                    </div>
                @endforeach
                <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.78rem; color: rgba(255,255,255,0.4);">AI-generated estimate</span>
                    @guest
                        <a href="{{ route('register') }}" style="font-size: 0.8rem; color: #9bf6af; font-weight: 700; text-decoration: none;">Try it free →</a>
                    @else
                        <a href="{{ route('budget.planner') }}" style="font-size: 0.8rem; color: #9bf6af; font-weight: 700; text-decoration: none;">Open planner →</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ TESTIMONIALS ═══ -->
<section class="testimonials-section">
    <div class="container">
        <div style="text-align: center;">
            <span class="section-label" style="color: #9bf6af;">Real Couples</span>
            <h2 class="section-title" style="color: white;">Loved by couples across Rwanda</h2>
            <p class="section-sub" style="color: rgba(255,255,255,0.6); margin: 0.5rem auto 0;">Hear from couples who planned their dream weddings with IntelliWed.</p>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"IntelliWed made planning our wedding so easy. We found our photographer, caterer, and venue all in one place. The messaging feature made it so simple to coordinate with vendors."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">A</div>
                    <div>
                        <div class="testimonial-name">Amina &amp; Jean-Pierre</div>
                        <div class="testimonial-meta">Married in Kigali · March 2026</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"The AI budget planner was a game-changer. We set our budget and it gave us a perfect breakdown — we didn't overspend a single franc. Highly recommend for any couple."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">C</div>
                    <div>
                        <div class="testimonial-name">Claire &amp; Emmanuel</div>
                        <div class="testimonial-meta">Married in Musanze · January 2026</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"We were planning from abroad and IntelliWed was the only platform that gave us full confidence. Verified vendors, real reviews, and a countdown dashboard — absolutely perfect."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">F</div>
                    <div>
                        <div class="testimonial-name">Fatuma &amp; David</div>
                        <div class="testimonial-meta">Married in Rubavu · December 2025</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ FINAL CTA ═══ -->
<section class="cta-banner">
    <div class="container">
        <div class="cta-inner">
            @guest
                <h2 class="cta-title">Your perfect wedding starts here.</h2>
                <p class="cta-sub">Join hundreds of Rwandan couples who planned their dream wedding on IntelliWed — free to start.</p>
                <div class="cta-btns">
                    <a href="{{ route('register') }}" class="btn btn-secondary" style="padding: 0.875rem 2.5rem; font-size: 1rem; font-weight: 700;">Create Free Account</a>
                    <a href="{{ route('services.index') }}" class="btn btn-outline" style="padding: 0.875rem 2rem; font-size: 1rem; border-color: rgba(255,255,255,0.35); color: white;">Browse Vendors</a>
                </div>
            @else
                <h2 class="cta-title">Keep planning, {{ auth()->user()->name }}.</h2>
                <p class="cta-sub">Your dashboard has everything you need for the big day. Keep the momentum going!</p>
                <div class="cta-btns">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="padding: 0.875rem 2.5rem; font-size: 1rem; font-weight: 700;">Go to Dashboard</a>
                    <a href="{{ route('services.index') }}" class="btn btn-outline" style="padding: 0.875rem 2rem; font-size: 1rem; border-color: rgba(255,255,255,0.35); color: white;">Browse Services</a>
                    @if(auth()->user()->isClient())
                        <a href="{{ route('chat.index') }}" class="btn btn-outline" style="padding: 0.875rem 2rem; font-size: 1rem; border-color: rgba(255,255,255,0.35); color: white;">💬 Messages</a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</section>
@endsection
