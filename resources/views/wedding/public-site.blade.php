<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $couple->name }} & {{ $profile->partner_name }} — Wedding</title>
    <meta name="description" content="{{ $profile->love_story ? Str::limit($profile->love_story, 160) : 'You are invited to our wedding!' }}">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $couple->name }} & {{ $profile->partner_name }} Wedding">
    <meta property="og:description" content="{{ $profile->love_story ? Str::limit($profile->love_story, 160) : 'Join us for our special day!' }}">
    @if($profile->cover_image)
    <meta property="og:image" content="{{ asset('storage/' . $profile->cover_image) }}">
    @endif

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500&display=swap');

        :root {
            --accent: {{ $profile->primary_color ?? '#9bf6af' }};
            --dark: #1a1a1a;
            --muted: #666;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #fafaf8;
            color: var(--dark);
        }

        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            background: var(--dark);
        }

        .hero-bg {
            position: absolute; inset: 0;
            object-fit: cover;
            width: 100%; height: 100%;
            opacity: 0.4;
        }

        .hero-content {
            position: relative; z-index: 1;
            color: white;
            padding: 3rem 2rem;
        }

        .couple-names {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 400;
            line-height: 1.1;
            margin-bottom: 0.5rem;
        }

        .couple-names span {
            font-style: italic;
            color: var(--accent);
        }

        .wedding-date-display {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.8);
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin: 1rem 0;
        }

        .section {
            padding: 5rem 2rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .section-divider {
            width: 60px;
            height: 2px;
            background: var(--accent);
            margin: 1rem auto 2.5rem;
        }

        .countdown-wrap {
            display: flex;
            justify-content: center;
            gap: 2rem;
            padding: 3rem 2rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }

        .cd-item {
            text-align: center;
        }

        .cd-number {
            font-size: 3rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            color: var(--dark);
            display: block;
            line-height: 1;
        }

        .cd-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--muted);
            margin-top: 0.5rem;
        }

        .story-text {
            font-size: 1.1rem;
            line-height: 1.9;
            color: #444;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
            font-style: italic;
        }

        .detail-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .detail-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }

        .detail-icon {
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }

        .detail-card h3 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .detail-card p {
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .photo-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1rem;
        }

        .photo-item {
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
        }

        .photo-item img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .photo-item:hover img { transform: scale(1.05); }

        .rsvp-section {
            background: var(--dark);
            color: white;
            padding: 5rem 2rem;
            text-align: center;
        }

        .rsvp-section .section-title { color: white; }

        .tag-pill {
            display: inline-block;
            background: var(--accent);
            color: var(--dark);
            padding: 0.3rem 1rem;
            border-radius: 99px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        footer {
            text-align: center;
            padding: 2rem;
            color: var(--muted);
            font-size: 0.8rem;
            border-top: 1px solid #e5e5e5;
        }

        @media (max-width: 640px) {
            .countdown-wrap { gap: 1rem; }
            .cd-number { font-size: 2rem; }
        }
    </style>
</head>
<body>

<!-- Hero -->
<section class="hero">
    @if($profile->cover_image)
        <img class="hero-bg" src="{{ asset('storage/' . $profile->cover_image) }}" alt="Wedding Cover">
    @else
        <div style="position:absolute;inset:0;background:linear-gradient(135deg,#1a1a1a 0%,#333 100%);"></div>
    @endif
    <div class="hero-content">
        <div class="tag-pill" style="margin-bottom: 1.5rem;">You're Invited</div>
        <h1 class="couple-names">
            {{ $couple->name }}<br>
            <span style="font-size: 0.7em; display: block; margin: 0.3rem 0;">&</span>
            <span>{{ $profile->partner_name }}</span>
        </h1>
        @if($profile->wedding_date)
            <div class="wedding-date-display">{{ $profile->wedding_date->format('l, F j, Y') }}</div>
        @endif
        @if($profile->venue)
            <div style="color: rgba(255,255,255,0.6); font-size: 0.95rem; margin-top: 0.5rem;">
                📍 {{ $profile->venue }}{{ $profile->venue_location ? ', ' . $profile->venue_location : '' }}
            </div>
        @endif
        <div style="margin-top: 2rem;">
            <a href="#details" style="display: inline-block; background: var(--accent); color: var(--dark); padding: 0.85rem 2rem; border-radius: 50px; font-weight: 600; font-size: 0.9rem; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity=0.85" onmouseout="this.style.opacity=1">
                View Details
            </a>
        </div>
    </div>
</section>

<!-- Countdown -->
@if($profile->wedding_date && $profile->days_until_wedding !== null)
<section style="padding: 4rem 2rem; background: white;">
    <div style="max-width: 700px; margin: 0 auto;">
        <p style="text-align: center; color: var(--muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 1.5rem;">Counting Down To Our Day</p>
        <div class="countdown-wrap">
            <div class="cd-item"><span class="cd-number" id="cd-days">{{ floor($profile->days_until_wedding) }}</span><div class="cd-label">Days</div></div>
            <div class="cd-item"><span class="cd-number" id="cd-hours">--</span><div class="cd-label">Hours</div></div>
            <div class="cd-item"><span class="cd-number" id="cd-mins">--</span><div class="cd-label">Minutes</div></div>
            <div class="cd-item"><span class="cd-number" id="cd-secs">--</span><div class="cd-label">Seconds</div></div>
        </div>
    </div>
</section>
@endif

<!-- Love Story -->
@if($profile->love_story)
<section class="section" id="story">
    <h2 class="section-title">Our Story</h2>
    <div class="section-divider"></div>
    <p class="story-text">"{{ $profile->love_story }}"</p>
</section>
@endif

<!-- Event Details -->
<section class="section" id="details" style="background: #fafaf8; max-width: 100%; padding: 4rem 2rem;">
    <div style="max-width: 900px; margin: 0 auto;">
        <h2 class="section-title">Wedding Details</h2>
        <div class="section-divider"></div>
        <div class="detail-cards">
            @if($profile->wedding_date)
            <div class="detail-card">
                <div class="detail-icon">📅</div>
                <h3>Date</h3>
                <p>{{ $profile->wedding_date->format('F j, Y') }}</p>
                <p style="font-size: 0.8rem; margin-top: 0.25rem; color: #aaa;">{{ $profile->wedding_date->format('l') }}</p>
            </div>
            @endif
            @if($profile->venue)
            <div class="detail-card">
                <div class="detail-icon">📍</div>
                <h3>Venue</h3>
                <p>{{ $profile->venue }}</p>
                @if($profile->venue_location)
                    <p style="font-size: 0.85rem; margin-top: 0.25rem; color: #888;">{{ $profile->venue_location }}</p>
                @endif
            </div>
            @endif
            @if($profile->ceremony_type)
            <div class="detail-card">
                <div class="detail-icon">🎊</div>
                <h3>Ceremony</h3>
                <p style="text-transform: capitalize;">{{ str_replace('-', ' ', $profile->ceremony_type) }}</p>
            </div>
            @endif
            @if($profile->theme)
            <div class="detail-card">
                <div class="detail-icon">🎨</div>
                <h3>Theme</h3>
                <p style="text-transform: capitalize;">{{ str_replace('-', ' ', $profile->theme) }}</p>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Gallery -->
@if($photos->count() > 0)
<section class="section" id="gallery">
    <h2 class="section-title">Gallery</h2>
    <div class="section-divider"></div>
    <div class="photo-gallery">
        @foreach($photos as $photo)
            <div class="photo-item">
                <img src="{{ $photo->url }}" alt="{{ $photo->caption }}" loading="lazy">
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- Special Notes / Message -->
@if($profile->special_notes)
<section style="padding: 4rem 2rem; background: white;">
    <div style="max-width: 700px; margin: 0 auto; text-align: center;">
        <div style="font-size: 2rem; margin-bottom: 1rem;">💌</div>
        <p style="font-size: 1.05rem; line-height: 1.8; color: #444; font-style: italic;">{{ $profile->special_notes }}</p>
    </div>
</section>
@endif

<!-- Footer -->
<footer>
    <p>Made with ❤️ by <strong>{{ $couple->name }}</strong> & <strong>{{ $profile->partner_name }}</strong></p>
    <p style="margin-top: 0.5rem;">Powered by <a href="{{ route('home') }}" style="color: var(--accent);">IntelliWed</a></p>
</footer>

@if($profile->wedding_date && $profile->days_until_wedding !== null)
<script>
    const weddingDate = new Date("{{ $profile->wedding_date->toIso8601String() }}");
    function tick() {
        const diff = weddingDate - new Date();
        if (diff <= 0) return;
        document.getElementById('cd-days').textContent = Math.floor(diff / 86400000);
        document.getElementById('cd-hours').textContent = String(Math.floor((diff % 86400000) / 3600000)).padStart(2,'0');
        document.getElementById('cd-mins').textContent = String(Math.floor((diff % 3600000) / 60000)).padStart(2,'0');
        document.getElementById('cd-secs').textContent = String(Math.floor((diff % 60000) / 1000)).padStart(2,'0');
    }
    tick(); setInterval(tick, 1000);
</script>
@endif
</body>
</html>
