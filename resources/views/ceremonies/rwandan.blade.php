@extends('layouts.front')

@section('title', 'Traditional Rwandan Wedding Ceremonies | IntelliWed')

@section('content')
<style>
/* Hero */
.cer-hero { background: linear-gradient(135deg,#1a1a1a 0%,#2a2a2a 100%); padding: 5rem 0; text-align: center; position: relative; overflow: hidden; }
.cer-hero::before { content:''; position:absolute; inset:0; background: radial-gradient(ellipse at 30% 50%,rgba(155,246,175,.08),transparent 60%), radial-gradient(ellipse at 70% 50%,rgba(212,175,55,.05),transparent 60%); pointer-events:none; }

/* Ceremony selector */
.cer-selector { background: white; border-bottom: 1px solid #f0f0f0; padding: 1.5rem 0; position: sticky; top: 90px; z-index: 100; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
.cer-tabs { display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 2px; scrollbar-width: none; }
.cer-tabs::-webkit-scrollbar { display: none; }
.cer-tab { flex-shrink: 0; padding: 0.55rem 1.1rem; border-radius: 99px; font-size: 0.85rem; font-weight: 700; border: 1.5px solid #e5e5e5; background: white; color: #555; cursor: pointer; text-decoration: none; transition: all 0.2s; white-space: nowrap; }
.cer-tab:hover { border-color: #222; color: #222; }
.cer-tab.active { background: #222; color: #9bf6af; border-color: #222; }

/* Cards */
.cer-grid { display: flex; flex-direction: column; gap: 2rem; padding: 3rem 0; }
.cer-card { background: white; border-radius: 20px; border: 1px solid #f0f0f0; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; scroll-margin-top: 160px; }
.cer-card-inner { display: grid; grid-template-columns: 1fr 1fr; }
.cer-left { padding: 2.5rem; border-right: 1px solid #f5f5f5; }
.cer-right { padding: 2.5rem; background: #fafaf8; }
.cer-tag { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; color: #888; margin-bottom: 0.75rem; }
.cer-title { font-size: 1.75rem; font-weight: 800; color: #1a1a1a; margin-bottom: 0.25rem; letter-spacing: -0.02em; }
.cer-subtitle { font-size: 0.9rem; color: #888; margin-bottom: 1.25rem; }
.cer-desc { font-size: 0.95rem; color: #555; line-height: 1.75; margin-bottom: 1.75rem; }

/* Steps */
.cer-steps { list-style: none; padding: 0; margin: 0 0 1.75rem; }
.cer-steps li { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.55rem 0; border-bottom: 1px solid #f9f9f9; font-size: 0.875rem; color: #444; }
.cer-steps li:last-child { border-bottom: none; }
.cer-step-num { min-width: 22px; height: 22px; background: #9bf6af; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: #166534; flex-shrink: 0; margin-top: 0.1rem; }

/* Vendor chips — now clickable */
.cer-vendors-label { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: #888; font-weight: 700; margin-bottom: 0.75rem; }
.cer-chips { display: flex; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 1.5rem; }
.cer-chip { display: flex; align-items: center; gap: 0.4rem; background: white; border: 1.5px solid #e8e8e8; border-radius: 10px; padding: 0.5rem 0.85rem; font-size: 0.82rem; color: #333; text-decoration: none; transition: all 0.2s; font-weight: 600; }
.cer-chip:hover { border-color: #9bf6af; background: #f0fff4; color: #166534; }
.cer-chip-icon { font-size: 1rem; }

/* Action buttons */
.cer-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }

/* "Plan this" pill for logged-in users */
.plan-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: #f0fff4; border: 1px solid #bbf7d0; color: #15803d; border-radius: 99px; padding: 0.3rem 0.85rem; font-size: 0.78rem; font-weight: 700; margin-bottom: 1.25rem; }

/* Responsive */
@media (max-width: 900px) {
    .cer-card-inner { grid-template-columns: 1fr; }
    .cer-left { border-right: none; border-bottom: 1px solid #f5f5f5; }
}
@media (max-width: 600px) {
    .cer-left, .cer-right { padding: 1.5rem; }
    .cer-title { font-size: 1.4rem; }
}
</style>

{{-- ═══ HERO ═══ --}}
<section class="cer-hero">
    <div class="container" style="position:relative;z-index:1;">
        <div style="display:inline-flex;align-items:center;gap:.5rem;background:rgba(155,246,175,.15);border:1px solid rgba(155,246,175,.3);padding:.4rem 1rem;border-radius:99px;margin-bottom:1.5rem;">
            <span style="color:#9bf6af;font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;">🇷🇼 Cultural Heritage</span>
        </div>
        <h1 style="font-size:clamp(2rem,5vw,3.5rem);color:white;margin-bottom:1rem;line-height:1.2;">Traditional Rwandan<br><span style="color:#9bf6af;">Wedding Ceremonies</span></h1>
        <p style="font-size:1.05rem;color:rgba(255,255,255,.65);max-width:580px;margin:0 auto 2rem;line-height:1.7;">Discover the rich cultural traditions that make Rwandan weddings unique. Each ceremony comes with a guide on what vendors and services you'll need — and direct links to book them.</p>
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            @auth
                <a href="{{ route('wedding.profile') }}" class="btn btn-secondary">Plan My Ceremony</a>
                <a href="{{ route('services.index') }}" class="btn btn-outline" style="color:white;border-color:rgba(255,255,255,.3);">Browse All Vendors</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-secondary">Start Planning Free</a>
                <a href="{{ route('services.index') }}" class="btn btn-outline" style="color:white;border-color:rgba(255,255,255,.3);">Browse Vendors</a>
            @endauth
        </div>
    </div>
</section>

{{-- ═══ STICKY NAVIGATION TABS ═══ --}}
<div class="cer-selector">
    <div class="container">
        <div class="cer-tabs" id="cerTabs">
            <a href="#gusaba"    class="cer-tab active">🤝 Gusaba</a>
            <a href="#gukwa"     class="cer-tab">💍 Gukwa</a>
            <a href="#umuganura" class="cer-tab">🪘 Umuganura</a>
            <a href="#attire"    class="cer-tab">👗 Traditional Attire</a>
            <a href="#intore"    class="cer-tab">💃 Intore Dance</a>
            <a href="#inanga"    class="cer-tab">🎻 Inanga Music</a>
        </div>
    </div>
</div>

{{-- ═══ CEREMONIES ═══ --}}
<section style="background:#fafaf8;padding-bottom:4rem;">
    <div class="container">
        <div class="cer-grid">

            {{-- ── GUSABA ── --}}
            <div class="cer-card" id="gusaba">
                <div class="cer-card-inner">
                    <div class="cer-left">
                        <div class="cer-tag">🤝 Ceremony 1 of 6</div>
                        <h2 class="cer-title">Gusaba</h2>
                        <p class="cer-subtitle">The Traditional Introduction Ceremony</p>
                        @auth <div class="plan-badge">✓ Most couples start here</div> @endauth
                        <p class="cer-desc"><strong>Gusaba</strong> is the formal introduction where the groom's family visits the bride's family to ask for her hand in marriage — a joyful occasion filled with songs, speeches, and gifts.</p>
                        <h4 style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:#888;margin-bottom:.75rem;">Key Steps</h4>
                        <ul class="cer-steps">
                            <li><div class="cer-step-num">1</div>Groom's family selects a spokesperson (Umuryango)</li>
                            <li><div class="cer-step-num">2</div>Formal request is made to the bride's family</li>
                            <li><div class="cer-step-num">3</div>Exchange of traditional gifts and baskets (Agaseke)</li>
                            <li><div class="cer-step-num">4</div>Celebration with Intore dancers and family feast</li>
                            <li><div class="cer-step-num">5</div>Bride's acceptance announced to both families</li>
                        </ul>
                    </div>
                    <div class="cer-right">
                        <div class="cer-vendors-label">Vendors you'll need</div>
                        <div class="cer-chips">
                            <a href="{{ route('services.index', ['search' => 'intore']) }}" class="cer-chip"><span class="cer-chip-icon">🎭</span> Intore Dancers</a>
                            <a href="{{ route('services.index', ['search' => 'inanga']) }}" class="cer-chip"><span class="cer-chip-icon">🥁</span> Inanga Players</a>
                            <a href="{{ route('services.index', ['category' => 'catering']) }}" class="cer-chip"><span class="cer-chip-icon">🍽️</span> Catering</a>
                            <a href="{{ route('services.index', ['category' => 'photographer']) }}" class="cer-chip"><span class="cer-chip-icon">📷</span> Photography</a>
                            <a href="{{ route('services.index', ['category' => 'decorator']) }}" class="cer-chip"><span class="cer-chip-icon">🌸</span> Decoration</a>
                        </div>
                        <div style="background:#f0fff4;border:1px solid #bbf7d0;border-radius:14px;padding:1.25rem;margin-bottom:1.5rem;">
                            <div style="font-weight:700;font-size:.875rem;color:#166534;margin-bottom:.4rem;">💡 Planning tip</div>
                            <div style="font-size:.82rem;color:#555;line-height:1.6;">Gusaba is typically held 1–3 months before the main wedding. Book your Intore group and caterer at least 6 weeks in advance as they book up fast.</div>
                        </div>
                        <div class="cer-actions">
                            <a href="{{ route('services.index', ['search' => 'intore']) }}" class="btn btn-primary" style="font-size:.875rem;">Find Intore Dancers →</a>
                            <a href="{{ route('services.index', ['category' => 'catering']) }}" class="btn btn-outline" style="font-size:.875rem;">Find Caterers →</a>
                        </div>
                        @auth
                        <div style="margin-top:1rem;">
                            <a href="{{ route('tasks.index') }}" style="font-size:.8rem;color:#888;text-decoration:underline;">+ Add Gusaba tasks to my checklist</a>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- ── GUKWA ── --}}
            <div class="cer-card" id="gukwa">
                <div class="cer-card-inner">
                    <div class="cer-left">
                        <div class="cer-tag">💍 Ceremony 2 of 6</div>
                        <h2 class="cer-title">Gukwa</h2>
                        <p class="cer-subtitle">The Bride Price Ceremony</p>
                        <p class="cer-desc"><strong>Gukwa</strong> is the formal payment of a symbolic dowry from the groom's family to the bride's family — representing gratitude, respect, and the sealing of the family bond.</p>
                        <h4 style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:#888;margin-bottom:.75rem;">Key Steps</h4>
                        <ul class="cer-steps">
                            <li><div class="cer-step-num">1</div>Negotiation of bride price between family elders</li>
                            <li><div class="cer-step-num">2</div>Presentation of cows (Inka), cash, or modern equivalents</li>
                            <li><div class="cer-step-num">3</div>Acceptance speech by bride's family head</li>
                            <li><div class="cer-step-num">4</div>Sharing of Inzoga (banana beer) to seal the agreement</li>
                            <li><div class="cer-step-num">5</div>Joyful celebration with both families united</li>
                        </ul>
                    </div>
                    <div class="cer-right">
                        <div class="cer-vendors-label">Vendors you'll need</div>
                        <div class="cer-chips">
                            <a href="{{ route('services.index', ['category' => 'music']) }}" class="cer-chip"><span class="cer-chip-icon">🎵</span> Traditional Band</a>
                            <a href="{{ route('services.index', ['category' => 'catering']) }}" class="cer-chip"><span class="cer-chip-icon">🍽️</span> Traditional Food</a>
                            <a href="{{ route('services.index', ['category' => 'decorator']) }}" class="cer-chip"><span class="cer-chip-icon">🌸</span> Decoration</a>
                            <a href="{{ route('services.index', ['search' => 'video']) }}" class="cer-chip"><span class="cer-chip-icon">📹</span> Videography</a>
                            <a href="{{ route('services.index', ['category' => 'photographer']) }}" class="cer-chip"><span class="cer-chip-icon">📷</span> Photography</a>
                        </div>
                        <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:14px;padding:1.25rem;margin-bottom:1.5rem;">
                            <div style="font-weight:700;font-size:.875rem;color:#92400e;margin-bottom:.4rem;">💡 Planning tip</div>
                            <div style="font-size:.82rem;color:#555;line-height:1.6;">Gukwa is often held on the same day as Gusaba or a week before. Coordinate your catering team to serve traditional foods like Ubugari, Isombe, and grilled meats.</div>
                        </div>
                        <div class="cer-actions">
                            <a href="{{ route('services.index', ['category' => 'music']) }}" class="btn btn-primary" style="font-size:.875rem;">Find Traditional Bands →</a>
                            <a href="{{ route('services.index', ['category' => 'catering']) }}" class="btn btn-outline" style="font-size:.875rem;">Find Caterers →</a>
                        </div>
                        @auth
                        <div style="margin-top:1rem;">
                            <a href="{{ route('tasks.index') }}" style="font-size:.8rem;color:#888;text-decoration:underline;">+ Add Gukwa tasks to my checklist</a>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- ── UMUGANURA ── --}}
            <div class="cer-card" id="umuganura">
                <div class="cer-card-inner">
                    <div class="cer-left">
                        <div class="cer-tag">🪘 Ceremony 3 of 6</div>
                        <h2 class="cer-title">Umuganura</h2>
                        <p class="cer-subtitle">The Harvest & Blessing Ceremony</p>
                        <p class="cer-desc"><strong>Umuganura</strong> is the traditional harvest festival incorporated into weddings as a blessing ritual — celebrating abundance and asking for a fruitful, prosperous union.</p>
                        <h4 style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:#888;margin-bottom:.75rem;">Key Elements</h4>
                        <ul class="cer-steps">
                            <li><div class="cer-step-num">1</div>Traditional blessing prayer by family elders</li>
                            <li><div class="cer-step-num">2</div>Sharing of first harvest foods (sorghum, millet)</li>
                            <li><div class="cer-step-num">3</div>Intore warrior dance performances</li>
                            <li><div class="cer-step-num">4</div>Inanga music and storytelling</li>
                            <li><div class="cer-step-num">5</div>Exchange of fertility blessings for the couple</li>
                        </ul>
                    </div>
                    <div class="cer-right">
                        <div class="cer-vendors-label">Vendors you'll need</div>
                        <div class="cer-chips">
                            <a href="{{ route('services.index', ['search' => 'intore']) }}" class="cer-chip"><span class="cer-chip-icon">💃</span> Intore Group</a>
                            <a href="{{ route('services.index', ['search' => 'inanga']) }}" class="cer-chip"><span class="cer-chip-icon">🎻</span> Inanga Player</a>
                            <a href="{{ route('services.index', ['category' => 'decorator']) }}" class="cer-chip"><span class="cer-chip-icon">🌾</span> Traditional Decor</a>
                            <a href="{{ route('services.index', ['category' => 'clothing']) }}" class="cer-chip"><span class="cer-chip-icon">👔</span> Attire Designer</a>
                            <a href="{{ route('services.index', ['category' => 'catering']) }}" class="cer-chip"><span class="cer-chip-icon">🍽️</span> Traditional Food</a>
                        </div>
                        <div style="background:#f0fff4;border:1px solid #bbf7d0;border-radius:14px;padding:1.25rem;margin-bottom:1.5rem;">
                            <div style="font-weight:700;font-size:.875rem;color:#166534;margin-bottom:.4rem;">💡 Planning tip</div>
                            <div style="font-size:.82rem;color:#555;line-height:1.6;">This ceremony is optional but adds deep cultural meaning. Work with an elder or cultural advisor to ensure the blessings are performed in the authentic Rwandan tradition.</div>
                        </div>
                        <div class="cer-actions">
                            <a href="{{ route('services.index', ['search' => 'intore']) }}" class="btn btn-primary" style="font-size:.875rem;">Find Intore Groups →</a>
                            <a href="{{ route('services.index', ['category' => 'decorator']) }}" class="btn btn-outline" style="font-size:.875rem;">Find Decorators →</a>
                        </div>
                        @auth
                        <div style="margin-top:1rem;">
                            <a href="{{ route('tasks.index') }}" style="font-size:.8rem;color:#888;text-decoration:underline;">+ Add Umuganura tasks to my checklist</a>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- ── TRADITIONAL ATTIRE ── --}}
            <div class="cer-card" id="attire">
                <div class="cer-card-inner">
                    <div class="cer-left">
                        <div class="cer-tag">👗 Ceremony 4 of 6</div>
                        <h2 class="cer-title">Traditional Attire</h2>
                        <p class="cer-subtitle">Umuturu wa Gakondo — Cultural Dress</p>
                        <p class="cer-desc">Rwandan traditional wedding attire features handwoven fabrics (Umushanana), elegant jewelry, and vibrant colors that represent cultural pride, beauty, and royal heritage.</p>
                        <h4 style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:#888;margin-bottom:.75rem;">What to Wear</h4>
                        <ul class="cer-steps">
                            <li><div class="cer-step-num">👰</div><strong>Bride:</strong> Umushanana (traditional wrap dress) in vibrant colors with headpiece</li>
                            <li><div class="cer-step-num">🤵</div><strong>Groom:</strong> Igitenge fabric suit or traditional Umushana wrap</li>
                            <li><div class="cer-step-num">💎</div><strong>Jewelry:</strong> Intore bead necklaces, traditional bangles</li>
                            <li><div class="cer-step-num">🌺</div><strong>Flowers:</strong> Local flowers and herbal garlands</li>
                            <li><div class="cer-step-num">🎨</div><strong>Colors:</strong> Red, orange, gold, purple — symbols of royalty & love</li>
                        </ul>
                    </div>
                    <div class="cer-right">
                        <div class="cer-vendors-label">Vendors you'll need</div>
                        <div class="cer-chips">
                            <a href="{{ route('services.index', ['category' => 'clothing']) }}" class="cer-chip"><span class="cer-chip-icon">👗</span> Fashion Designers</a>
                            <a href="{{ route('services.index', ['category' => 'beauty']) }}" class="cer-chip"><span class="cer-chip-icon">💄</span> Hair & Makeup</a>
                            <a href="{{ route('services.index', ['search' => 'jewelry']) }}" class="cer-chip"><span class="cer-chip-icon">💍</span> Jewelry</a>
                            <a href="{{ route('services.index', ['category' => 'photographer']) }}" class="cer-chip"><span class="cer-chip-icon">📷</span> Photography</a>
                        </div>
                        <div style="background:#fdf2f8;border:1px solid #f0abfc;border-radius:14px;padding:1.25rem;margin-bottom:1.5rem;">
                            <div style="font-weight:700;font-size:.875rem;color:#86198f;margin-bottom:.4rem;">💡 Planning tip</div>
                            <div style="font-size:.82rem;color:#555;line-height:1.6;">Book your attire designer at least 3 months before the wedding. Custom Umushanana dresses take 4–8 weeks to make. Schedule fittings early!</div>
                        </div>
                        <div class="cer-actions">
                            <a href="{{ route('services.index', ['category' => 'clothing']) }}" class="btn btn-primary" style="font-size:.875rem;">Find Fashion Designers →</a>
                            <a href="{{ route('services.index', ['category' => 'beauty']) }}" class="btn btn-outline" style="font-size:.875rem;">Find Hair & Makeup →</a>
                        </div>
                        @auth
                        <div style="margin-top:1rem;">
                            <a href="{{ route('tasks.index') }}" style="font-size:.8rem;color:#888;text-decoration:underline;">+ Add attire tasks to my checklist</a>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- ── INTORE DANCE ── --}}
            <div class="cer-card" id="intore">
                <div class="cer-card-inner">
                    <div class="cer-left">
                        <div class="cer-tag">💃 Ceremony 5 of 6</div>
                        <h2 class="cer-title">Intore Dance</h2>
                        <p class="cer-subtitle">Rwanda's Iconic Warrior Cultural Dance</p>
                        <p class="cer-desc"><strong>Intore</strong> is Rwanda's most recognized traditional dance — performed by warriors in elaborate costumes. At weddings, it symbolizes honor, courage, and the joyful celebration of union.</p>
                        <h4 style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:#888;margin-bottom:.75rem;">What to Expect</h4>
                        <ul class="cer-steps">
                            <li><div class="cer-step-num">1</div>Male dancers in traditional warrior attire with grass headdress (Urukangaga)</li>
                            <li><div class="cer-step-num">2</div>Female dancers in colorful Umushanana performing Umushagiriro</li>
                            <li><div class="cer-step-num">3</div>Drum ensemble (Ingoma) providing the heartbeat of celebration</li>
                            <li><div class="cer-step-num">4</div>30–90 minute performances adaptable to your event</li>
                            <li><div class="cer-step-num">5</div>Optional audience participation sections</li>
                        </ul>
                    </div>
                    <div class="cer-right">
                        <div class="cer-vendors-label">Vendors you'll need</div>
                        <div class="cer-chips">
                            <a href="{{ route('services.index', ['search' => 'intore']) }}" class="cer-chip"><span class="cer-chip-icon">💃</span> Intore Dance Group</a>
                            <a href="{{ route('services.index', ['search' => 'drum']) }}" class="cer-chip"><span class="cer-chip-icon">🥁</span> Drum Ensemble</a>
                            <a href="{{ route('services.index', ['category' => 'photographer']) }}" class="cer-chip"><span class="cer-chip-icon">📷</span> Photography</a>
                            <a href="{{ route('services.index', ['search' => 'video']) }}" class="cer-chip"><span class="cer-chip-icon">📹</span> Videography</a>
                        </div>
                        <div style="background:#ecfdf5;border:1px solid #6ee7b7;border-radius:14px;padding:1.25rem;margin-bottom:1.5rem;">
                            <div style="font-weight:700;font-size:.875rem;color:#065f46;margin-bottom:.4rem;">💡 Planning tip</div>
                            <div style="font-size:.82rem;color:#555;line-height:1.6;">A typical Intore group has 10–20 performers. Confirm your venue has enough space (at least 6m × 6m cleared floor). Great for the reception entrance or between ceremonies.</div>
                        </div>
                        <div class="cer-actions">
                            <a href="{{ route('services.index', ['search' => 'intore']) }}" class="btn btn-primary" style="font-size:.875rem;">Find Intore Groups →</a>
                            <a href="{{ route('services.index', ['search' => 'drum']) }}" class="btn btn-outline" style="font-size:.875rem;">Find Drum Ensembles →</a>
                        </div>
                        @auth
                        <div style="margin-top:1rem;">
                            <a href="{{ route('tasks.index') }}" style="font-size:.8rem;color:#888;text-decoration:underline;">+ Add Intore tasks to my checklist</a>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- ── INANGA MUSIC ── --}}
            <div class="cer-card" id="inanga">
                <div class="cer-card-inner">
                    <div class="cer-left">
                        <div class="cer-tag">🎻 Ceremony 6 of 6</div>
                        <h2 class="cer-title">Inanga Music</h2>
                        <p class="cer-subtitle">Traditional Rwandan String Instrument</p>
                        <p class="cer-desc">The <strong>Inanga</strong> is Rwanda's beloved harp-like instrument. Played by storytellers (Abagas), it creates an atmosphere of romance and cultural richness — perfect for ceremony moments and wedding receptions.</p>
                        <h4 style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:#888;margin-bottom:.75rem;">Best Moments to Use It</h4>
                        <ul class="cer-steps">
                            <li><div class="cer-step-num">🌅</div>Guest arrival — ambient ambient background music</li>
                            <li><div class="cer-step-num">🍽️</div>During dinner — romantic and relaxing atmosphere</li>
                            <li><div class="cer-step-num">💒</div>Gusaba ceremony — traditional storytelling of family history</li>
                            <li><div class="cer-step-num">🎊</div>Reception entrance of the couple</li>
                            <li><div class="cer-step-num">🌙</div>Evening wind-down for an intimate close</li>
                        </ul>
                    </div>
                    <div class="cer-right">
                        <div class="cer-vendors-label">Vendors you'll need</div>
                        <div class="cer-chips">
                            <a href="{{ route('services.index', ['search' => 'inanga']) }}" class="cer-chip"><span class="cer-chip-icon">🎻</span> Inanga Players</a>
                            <a href="{{ route('services.index', ['category' => 'music']) }}" class="cer-chip"><span class="cer-chip-icon">🎵</span> Traditional Musicians</a>
                            <a href="{{ route('services.index', ['category' => 'photographer']) }}" class="cer-chip"><span class="cer-chip-icon">📷</span> Photography</a>
                        </div>
                        <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:14px;padding:1.25rem;margin-bottom:1.5rem;">
                            <div style="font-weight:700;font-size:.875rem;color:#9a3412;margin-bottom:.4rem;">💡 Planning tip</div>
                            <div style="font-size:.82rem;color:#555;line-height:1.6;">Inanga players often combine storytelling with music. Ask your musician to prepare a special song about the couple's love story — guests absolutely love it.</div>
                        </div>
                        <div class="cer-actions">
                            <a href="{{ route('services.index', ['search' => 'inanga']) }}" class="btn btn-primary" style="font-size:.875rem;">Find Inanga Musicians →</a>
                            <a href="{{ route('services.index', ['category' => 'music']) }}" class="btn btn-outline" style="font-size:.875rem;">Browse All Music →</a>
                        </div>
                        @auth
                        <div style="margin-top:1rem;">
                            <a href="{{ route('tasks.index') }}" style="font-size:.8rem;color:#888;text-decoration:underline;">+ Add music tasks to my checklist</a>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══ BOTTOM CTA ═══ --}}
<section style="background:#1a1a1a;padding:5rem 0;text-align:center;">
    <div class="container">
        <div style="font-size:3rem;margin-bottom:1rem;">🇷🇼</div>
        <h2 style="color:white;font-size:2rem;margin-bottom:1rem;letter-spacing:-0.02em;">Plan Your Cultural Wedding<br>with IntelliWed</h2>
        <p style="color:rgba(255,255,255,.6);max-width:500px;margin:0 auto 2rem;line-height:1.7;">We connect you with the best Intore performers, Inanga musicians, traditional attire designers, and ceremony coordinators in Rwanda.</p>
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            @auth
                <a href="{{ route('wedding.profile') }}" class="btn btn-secondary">Set Up My Wedding</a>
                <a href="{{ route('services.index') }}" class="btn btn-outline" style="color:white;border-color:rgba(255,255,255,.3);">Browse All Vendors</a>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline" style="color:white;border-color:rgba(255,255,255,.3);">My Checklist</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-secondary">Start Planning Free</a>
                <a href="{{ route('services.index') }}" class="btn btn-outline" style="color:white;border-color:rgba(255,255,255,.3);">Explore Vendors</a>
            @endauth
        </div>
    </div>
</section>

<script>
// Highlight active tab on scroll
const cards = document.querySelectorAll('.cer-card[id]');
const tabs   = document.querySelectorAll('.cer-tab');

const tabMap = {};
tabs.forEach(t => {
    const id = t.getAttribute('href').replace('#','');
    tabMap[id] = t;
});

const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            tabs.forEach(t => t.classList.remove('active'));
            const tab = tabMap[e.target.id];
            if (tab) tab.classList.add('active');
        }
    });
}, { rootMargin: '-160px 0px -60% 0px' });

cards.forEach(c => observer.observe(c));

// Smooth scroll for tab clicks
tabs.forEach(tab => {
    tab.addEventListener('click', e => {
        e.preventDefault();
        const id = tab.getAttribute('href').replace('#','');
        document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
    });
});
</script>
@endsection
