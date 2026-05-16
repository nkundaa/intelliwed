@extends('layouts.front')

@section('title', 'Traditional Rwandan Wedding Ceremonies | IntelliWed')

@section('content')
<style>
.ceremony-hero {
    background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
    padding: 5rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.ceremony-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 30% 50%, rgba(155,246,175,0.08) 0%, transparent 60%),
                radial-gradient(ellipse at 70% 50%, rgba(212,175,55,0.05) 0%, transparent 60%);
    pointer-events: none;
}
.ceremony-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    padding: 4rem 0;
}
.ceremony-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1px solid #f0f0f0;
    transition: transform 0.3s, box-shadow 0.3s;
}
.ceremony-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.12);
}
.ceremony-card-header {
    padding: 2rem;
    background: linear-gradient(135deg, #222 0%, #333 100%);
    color: white;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.ceremony-icon {
    width: 60px; height: 60px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem;
    background: rgba(255,255,255,0.1);
    flex-shrink: 0;
}
.ceremony-card-body { padding: 1.75rem; }
.step-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.step-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.6rem 0;
    border-bottom: 1px solid #f9f9f9;
    font-size: 0.875rem;
    color: #444;
}
.step-list li:last-child { border-bottom: none; }
.step-num {
    min-width: 22px; height: 22px;
    background: #9bf6af;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem;
    font-weight: 700;
    color: #166534;
    flex-shrink: 0;
    margin-top: 0.1rem;
}
.vendors-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}
.vendor-chip {
    background: #f9f9f9;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    padding: 0.75rem;
    text-align: center;
    font-size: 0.8rem;
    color: #444;
}
.vendor-chip .v-icon { font-size: 1.5rem; margin-bottom: 0.25rem; }
</style>

<!-- Hero -->
<section class="ceremony-hero">
    <div class="container" style="position: relative; z-index: 1;">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(155,246,175,0.15); border: 1px solid rgba(155,246,175,0.3); padding: 0.4rem 1rem; border-radius: 99px; margin-bottom: 1.5rem;">
            <span style="color: #9bf6af; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em;">Cultural Heritage</span>
        </div>
        <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); color: white; margin-bottom: 1rem; line-height: 1.2;">Traditional Rwandan<br><span style="color: #9bf6af;">Wedding Ceremonies</span></h1>
        <p style="font-size: 1.1rem; color: rgba(255,255,255,0.65); max-width: 600px; margin: 0 auto 2rem; line-height: 1.7;">Celebrate love the Rwandan way. Discover the rich cultural traditions that make Rwandan weddings some of the most meaningful in Africa.</p>
        @auth
            <a href="{{ route('wedding.profile') }}" class="btn btn-secondary" style="font-size: 0.95rem;">Plan My Ceremony</a>
        @else
            <a href="{{ route('register') }}" class="btn btn-secondary" style="font-size: 0.95rem;">Start Planning Free</a>
        @endauth
    </div>
</section>

<!-- Main Ceremonies -->
<section style="background: #fafaf8; padding: 0 0 3rem;">
    <div class="container">
        <div class="ceremony-cards">

            <!-- Gusaba -->
            <div class="ceremony-card">
                <div class="ceremony-card-header">
                    <div class="ceremony-icon">🤝</div>
                    <div>
                        <h2 style="color: white; margin: 0; font-size: 1.4rem;">Gusaba</h2>
                        <p style="color: rgba(255,255,255,0.6); font-size: 0.85rem; margin: 0.2rem 0 0;">The Traditional Introduction</p>
                    </div>
                </div>
                <div class="ceremony-card-body">
                    <p style="color: #555; font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.25rem;">
                        <strong>Gusaba</strong> is the formal introduction ceremony where the groom's family visits the bride's family to ask for her hand in marriage. It is a deeply respectful and joyful occasion filled with songs, speeches, and gifts.
                    </p>
                    <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: #888; margin-bottom: 0.75rem;">Key Steps</h4>
                    <ul class="step-list">
                        <li><div class="step-num">1</div>Groom's family selects a spokesperson (Umuryango)</li>
                        <li><div class="step-num">2</div>Formal request is made to the bride's family</li>
                        <li><div class="step-num">3</div>Exchange of traditional gifts and necklaces (Agaseke)</li>
                        <li><div class="step-num">4</div>Celebration with Intore dancers and family feast</li>
                        <li><div class="step-num">5</div>Bride's acceptance announced to both families</li>
                    </ul>
                    <div style="margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid #f0f0f0;">
                        <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: #888; margin-bottom: 0.5rem;">You'll need</div>
                        <div class="vendors-grid">
                            <div class="vendor-chip"><div class="v-icon">🎭</div>Intore Dancers</div>
                            <div class="vendor-chip"><div class="v-icon">🥁</div>Inanga Players</div>
                            <div class="vendor-chip"><div class="v-icon">🍶</div>Catering</div>
                            <div class="vendor-chip"><div class="v-icon">📷</div>Photography</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gukwa -->
            <div class="ceremony-card">
                <div class="ceremony-card-header">
                    <div class="ceremony-icon">💍</div>
                    <div>
                        <h2 style="color: white; margin: 0; font-size: 1.4rem;">Gukwa</h2>
                        <p style="color: rgba(255,255,255,0.6); font-size: 0.85rem; margin: 0.2rem 0 0;">Bride Price Ceremony</p>
                    </div>
                </div>
                <div class="ceremony-card-body">
                    <p style="color: #555; font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.25rem;">
                        <strong>Gukwa</strong> (bride price) is the formal payment of a symbolic dowry from the groom's family to the bride's family. It represents gratitude, respect, and the sealing of the family bond.
                    </p>
                    <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: #888; margin-bottom: 0.75rem;">Key Steps</h4>
                    <ul class="step-list">
                        <li><div class="step-num">1</div>Negotiation of bride price between family elders</li>
                        <li><div class="step-num">2</div>Presentation of cows (Inka), cash, or modern equivalents</li>
                        <li><div class="step-num">3</div>Acceptance speech by bride's family head</li>
                        <li><div class="step-num">4</div>Sharing of Inzoga (banana beer) to seal the deal</li>
                        <li><div class="step-num">5</div>Joyful celebration with both families united</li>
                    </ul>
                    <div style="margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid #f0f0f0;">
                        <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: #888; margin-bottom: 0.5rem;">You'll need</div>
                        <div class="vendors-grid">
                            <div class="vendor-chip"><div class="v-icon">🎵</div>Traditional Band</div>
                            <div class="vendor-chip"><div class="v-icon">🍽️</div>Traditional Food</div>
                            <div class="vendor-chip"><div class="v-icon">🌸</div>Decoration</div>
                            <div class="vendor-chip"><div class="v-icon">📹</div>Videography</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kwita Izina (Naming) -->
            <div class="ceremony-card">
                <div class="ceremony-card-header">
                    <div class="ceremony-icon">🪘</div>
                    <div>
                        <h2 style="color: white; margin: 0; font-size: 1.4rem;">Umuganura</h2>
                        <p style="color: rgba(255,255,255,0.6); font-size: 0.85rem; margin: 0.2rem 0 0;">Harvest & Blessing Ceremony</p>
                    </div>
                </div>
                <div class="ceremony-card-body">
                    <p style="color: #555; font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.25rem;">
                        <strong>Umuganura</strong> is the traditional Rwandan harvest festival ceremony sometimes incorporated into weddings as a blessing ritual, celebrating abundance and asking for a fruitful union.
                    </p>
                    <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: #888; margin-bottom: 0.75rem;">Key Elements</h4>
                    <ul class="step-list">
                        <li><div class="step-num">1</div>Traditional blessing prayer by family elders</li>
                        <li><div class="step-num">2</div>Sharing of first harvest foods (sorghum, millet)</li>
                        <li><div class="step-num">3</div>Intore warrior dance performances</li>
                        <li><div class="step-num">4</div>Inanga music and storytelling</li>
                        <li><div class="step-num">5</div>Exchange of fertility blessings for the couple</li>
                    </ul>
                    <div style="margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid #f0f0f0;">
                        <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: #888; margin-bottom: 0.5rem;">You'll need</div>
                        <div class="vendors-grid">
                            <div class="vendor-chip"><div class="v-icon">💃</div>Intore Group</div>
                            <div class="vendor-chip"><div class="v-icon">🎻</div>Inanga Player</div>
                            <div class="vendor-chip"><div class="v-icon">🌾</div>Traditional Decor</div>
                            <div class="vendor-chip"><div class="v-icon">👔</div>Attire Designer</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Traditional Attire -->
            <div class="ceremony-card">
                <div class="ceremony-card-header" style="background: linear-gradient(135deg, #4a0e8f 0%, #6b21a8 100%);">
                    <div class="ceremony-icon">👗</div>
                    <div>
                        <h2 style="color: white; margin: 0; font-size: 1.4rem;">Traditional Attire</h2>
                        <p style="color: rgba(255,255,255,0.6); font-size: 0.85rem; margin: 0.2rem 0 0;">Umuturu wa Gakondo</p>
                    </div>
                </div>
                <div class="ceremony-card-body">
                    <p style="color: #555; font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.25rem;">
                        Rwandan traditional wedding attire is characterized by beautiful handwoven fabrics (Umushanana), elegant jewelry, and vibrant colors that represent cultural pride and beauty.
                    </p>
                    <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: #888; margin-bottom: 0.75rem;">What to Wear</h4>
                    <ul class="step-list">
                        <li><div class="step-num">👰</div><strong>Bride:</strong> Umushanana (traditional wrap dress) in vibrant colors with headpiece</li>
                        <li><div class="step-num">🤵</div><strong>Groom:</strong> Igitenge fabric suit or traditional Umushana wrap</li>
                        <li><div class="step-num">💎</div><strong>Jewelry:</strong> Intore bead necklaces, traditional bangles</li>
                        <li><div class="step-num">🌺</div><strong>Flowers:</strong> Local flowers and herbal garlands</li>
                        <li><div class="step-num">🎨</div><strong>Colors:</strong> Red, orange, gold, purple — symbols of royalty & love</li>
                    </ul>
                    <div style="margin-top: 1.25rem;">
                        <a href="{{ route('services.index') }}?category=fashion" class="btn btn-secondary" style="font-size: 0.85rem; width: 100%; justify-content: center;">Find Fashion Designers →</a>
                    </div>
                </div>
            </div>

            <!-- Intore Dance -->
            <div class="ceremony-card">
                <div class="ceremony-card-header" style="background: linear-gradient(135deg, #065f46 0%, #047857 100%);">
                    <div class="ceremony-icon">💃</div>
                    <div>
                        <h2 style="color: white; margin: 0; font-size: 1.4rem;">Intore Dance</h2>
                        <p style="color: rgba(255,255,255,0.6); font-size: 0.85rem; margin: 0.2rem 0 0;">Warrior Cultural Dance</p>
                    </div>
                </div>
                <div class="ceremony-card-body">
                    <p style="color: #555; font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.25rem;">
                        <strong>Intore</strong> is Rwanda's most iconic traditional dance, performed by warriors in elaborate costumes. At weddings, it symbolizes honor, courage, and celebration of the union.
                    </p>
                    <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: #888; margin-bottom: 0.75rem;">What to Expect</h4>
                    <ul class="step-list">
                        <li><div class="step-num">1</div>Male dancers in traditional warrior attire with grass headdress</li>
                        <li><div class="step-num">2</div>Female dancers in colorful Umushanana performing Umushagiriro</li>
                        <li><div class="step-num">3</div>Drum ensemble (Ingoma) providing the heartbeat of the celebration</li>
                        <li><div class="step-num">4</div>30–90 minute performances adaptable to your event</li>
                    </ul>
                    <div style="margin-top: 1.25rem;">
                        <a href="{{ route('services.index') }}?category=traditional-dance" class="btn btn-secondary" style="font-size: 0.85rem; width: 100%; justify-content: center;">Find Intore Groups →</a>
                    </div>
                </div>
            </div>

            <!-- Inanga Music -->
            <div class="ceremony-card">
                <div class="ceremony-card-header" style="background: linear-gradient(135deg, #7c2d12 0%, #9a3412 100%);">
                    <div class="ceremony-icon">🎻</div>
                    <div>
                        <h2 style="color: white; margin: 0; font-size: 1.4rem;">Inanga Music</h2>
                        <p style="color: rgba(255,255,255,0.6); font-size: 0.85rem; margin: 0.2rem 0 0;">Traditional String Instrument</p>
                    </div>
                </div>
                <div class="ceremony-card-body">
                    <p style="color: #555; font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.25rem;">
                        The <strong>Inanga</strong> is Rwanda's beloved traditional harp-like instrument. Played by storytellers (Abagas), it creates an atmosphere of romance and cultural richness perfect for wedding receptions.
                    </p>
                    <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: #888; margin-bottom: 0.75rem;">When to Use It</h4>
                    <ul class="step-list">
                        <li><div class="step-num">🌅</div>Guest arrival ceremony — ambient background music</li>
                        <li><div class="step-num">🍽️</div>During dinner — romantic and relaxing atmosphere</li>
                        <li><div class="step-num">💒</div>Gusaba ceremony — traditional storytelling of family history</li>
                        <li><div class="step-num">🎊</div>Reception introduction of the couple</li>
                    </ul>
                    <div style="margin-top: 1.25rem;">
                        <a href="{{ route('services.index') }}?category=music" class="btn btn-secondary" style="font-size: 0.85rem; width: 100%; justify-content: center;">Find Musicians →</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: #1a1a1a; padding: 5rem 0; text-align: center;">
    <div class="container">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🇷🇼</div>
        <h2 style="color: white; font-size: 2rem; margin-bottom: 1rem;">Plan Your Cultural Wedding<br>with IntelliWed</h2>
        <p style="color: rgba(255,255,255,0.6); max-width: 500px; margin: 0 auto 2rem; line-height: 1.7;">We connect you with the best Intore performers, Inanga musicians, traditional attire designers, and ceremony coordinators in Rwanda.</p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            @auth
                <a href="{{ route('wedding.profile') }}" class="btn btn-secondary">Set Up My Wedding</a>
                <a href="{{ route('services.index') }}" class="btn btn-outline" style="color: white; border-color: rgba(255,255,255,0.3);">Browse Vendors</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-secondary">Start Planning Free</a>
                <a href="{{ route('services.index') }}" class="btn btn-outline" style="color: white; border-color: rgba(255,255,255,0.3);">Explore Vendors</a>
            @endauth
        </div>
    </div>
</section>
@endsection
