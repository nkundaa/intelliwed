@extends('layouts.dashboard')

@section('title', 'My Wedding Profile')

@section('extra-head')
<style>
.profile-hero {
    background: linear-gradient(135deg, #222 0%, #3a3a3a 100%);
    border-radius: 16px;
    padding: 2.5rem;
    color: white;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}
.profile-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(155,246,175,0.15) 0%, transparent 70%);
    border-radius: 50%;
}
.form-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid #f0f0f0;
    margin-bottom: 1.5rem;
}
.form-section h3 {
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #888;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f0f0f0;
}
.theme-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 0.75rem;
}
.theme-option {
    border: 2px solid #e5e5e5;
    border-radius: 12px;
    padding: 1rem 0.75rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: white;
}
.theme-option:hover { border-color: #9bf6af; background: #f0fff4; }
.theme-option.selected { border-color: #222; background: #f9f9f9; }
.theme-option input { display: none; }
.countdown-display {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}
.countdown-item {
    text-align: center;
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 1rem;
    min-width: 70px;
}
.countdown-number {
    font-size: 2rem;
    font-weight: 700;
    color: #9bf6af;
    line-height: 1;
}
.countdown-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: rgba(255,255,255,0.6);
    margin-top: 0.25rem;
}
.website-url-box {
    background: #f9f9f9;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: 1rem;
}
.website-url-box span {
    font-family: monospace;
    font-size: 0.9rem;
    color: #444;
    flex: 1;
}
</style>
@endsection

@section('content')
<div style="max-width: 900px; margin: 0 auto;">

    <!-- Hero Banner -->
    <div class="profile-hero">
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                <svg style="width: 24px; height: 24px; color: #9bf6af;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                <span style="color: #9bf6af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.8rem;">My Wedding</span>
            </div>
            <h1 style="font-size: 1.75rem; color: white; margin-bottom: 0.5rem;">
                {{ $profile ? auth()->user()->name . ' & ' . $profile->partner_name : 'Set Up Your Wedding' }}
            </h1>
            @if($profile && $profile->wedding_date)
                <p style="color: rgba(255,255,255,0.7); margin-bottom: 1rem;">{{ $profile->wedding_date->format('F j, Y') }}</p>
                @php $daysLeft = $profile->days_until_wedding; @endphp
                @if($daysLeft !== null)
                    <div class="countdown-display" id="countdown-display">
                        <div class="countdown-item">
                            <div class="countdown-number" id="cd-days">{{ floor($daysLeft) }}</div>
                            <div class="countdown-label">Days</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="cd-hours">--</div>
                            <div class="countdown-label">Hours</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="cd-mins">--</div>
                            <div class="countdown-label">Minutes</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="cd-secs">--</div>
                            <div class="countdown-label">Seconds</div>
                        </div>
                    </div>
                @else
                    <span style="color: rgba(255,255,255,0.5);">Wedding day has passed</span>
                @endif
            @else
                <p style="color: rgba(255,255,255,0.6);">Fill in your details to start your wedding journey.</p>
            @endif
        </div>
    </div>

    @if(session('status'))
        <div style="background: #e8f5e9; color: #2e7d32; padding: 1rem 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; border: 1px solid #c8e6c9;">
            ✓ {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('wedding.profile.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Basic Info -->
        <div class="form-section">
            <h3>💍 The Couple</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                <div>
                    <label class="label">Your Name</label>
                    <input type="text" class="input" value="{{ auth()->user()->name }}" disabled style="background: #f9f9f9;">
                </div>
                <div>
                    <label class="label">Partner's Name *</label>
                    <input type="text" name="partner_name" class="input" value="{{ old('partner_name', $profile->partner_name ?? '') }}" required placeholder="e.g. Amina Uwase">
                    @error('partner_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label">Wedding Date</label>
                    <input type="date" name="wedding_date" class="input" value="{{ old('wedding_date', $profile && $profile->wedding_date ? $profile->wedding_date->format('Y-m-d') : '') }}" min="{{ now()->addDay()->format('Y-m-d') }}">
                    @error('wedding_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label">Expected Guests</label>
                    <input type="number" name="guest_count_estimate" class="input" value="{{ old('guest_count_estimate', $profile->guest_count_estimate ?? '') }}" placeholder="e.g. 200" min="1">
                </div>
            </div>
        </div>

        <!-- Venue -->
        <div class="form-section">
            <h3>📍 Venue & Location</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                <div>
                    <label class="label">Venue Name</label>
                    <input type="text" name="venue" class="input" value="{{ old('venue', $profile->venue ?? '') }}" placeholder="e.g. Kigali Convention Centre">
                </div>
                <div>
                    <label class="label">Location / City</label>
                    <input type="text" name="venue_location" class="input" value="{{ old('venue_location', $profile->venue_location ?? '') }}" placeholder="e.g. Kigali, Rwanda">
                </div>
            </div>
        </div>

        <!-- Budget -->
        <div class="form-section">
            <h3>💰 Budget</h3>
            <div>
                <label class="label">Total Wedding Budget (RWF)</label>
                <input type="number" name="total_budget" class="input" value="{{ old('total_budget', $profile->total_budget ?? '') }}" placeholder="e.g. 5000000" min="0" step="10000" style="max-width: 300px;">
                <p style="font-size: 0.8rem; color: #888; margin-top: 0.5rem;">This helps our AI make better recommendations for your budget.</p>
            </div>
        </div>

        <!-- Wedding Theme -->
        <div class="form-section">
            <h3>🎨 Wedding Theme</h3>
            <div class="theme-grid">
                @foreach(['luxury' => ['🌟', 'Luxury'], 'traditional' => ['🪘', 'Traditional'], 'modern' => ['✨', 'Modern'], 'minimalist' => ['🌿', 'Minimalist'], 'garden' => ['🌸', 'Garden'], 'royal' => ['👑', 'Royal'], 'afro-fusion' => ['🌍', 'Afro-Fusion']] as $value => [$icon, $label])
                    <label class="theme-option {{ old('theme', $profile->theme ?? '') === $value ? 'selected' : '' }}">
                        <input type="radio" name="theme" value="{{ $value }}" {{ old('theme', $profile->theme ?? '') === $value ? 'checked' : '' }}>
                        <div style="font-size: 1.75rem; margin-bottom: 0.5rem;">{{ $icon }}</div>
                        <div style="font-size: 0.85rem; font-weight: 600;">{{ $label }}</div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Ceremony Type -->
        <div class="form-section">
            <h3>🪘 Ceremony Type</h3>
            <p style="font-size: 0.85rem; color: #888; margin-bottom: 1rem;">Select the type of wedding ceremony you're planning.</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 0.75rem;">
                @foreach(['gusaba' => ['🤝', 'Gusaba', 'Traditional introduction'], 'gukwa' => ['💍', 'Gukwa', 'Bride price ceremony'], 'traditional' => ['🪘', 'Traditional', 'Full traditional'], 'civil' => ['📜', 'Civil', 'Court ceremony'], 'modern' => ['💒', 'Modern', 'Church / modern'], 'reception' => ['🎉', 'Reception', 'Party & celebration'], 'mixed' => ['🌍', 'Mixed', 'Combination']] as $value => [$icon, $label, $desc])
                    <label style="border: 2px solid {{ old('ceremony_type', $profile->ceremony_type ?? '') === $value ? '#222' : '#e5e5e5' }}; border-radius: 12px; padding: 1rem; cursor: pointer; text-align: center; background: {{ old('ceremony_type', $profile->ceremony_type ?? '') === $value ? '#f9f9f9' : 'white' }};">
                        <input type="radio" name="ceremony_type" value="{{ $value }}" {{ old('ceremony_type', $profile->ceremony_type ?? '') === $value ? 'checked' : '' }} style="display: none;">
                        <div style="font-size: 1.5rem; margin-bottom: 0.25rem;">{{ $icon }}</div>
                        <div style="font-size: 0.85rem; font-weight: 700;">{{ $label }}</div>
                        <div style="font-size: 0.7rem; color: #888; margin-top: 0.2rem;">{{ $desc }}</div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Love Story -->
        <div class="form-section">
            <h3>💌 Your Love Story</h3>
            <p style="font-size: 0.85rem; color: #888; margin-bottom: 1rem;">Share your love story — it will appear on your wedding website.</p>
            <textarea name="love_story" class="input" rows="5" placeholder="How did you meet? What makes your story special..." style="resize: vertical;">{{ old('love_story', $profile->love_story ?? '') }}</textarea>
        </div>

        <!-- Wedding Website -->
        <div class="form-section">
            <h3>🌐 Wedding Website</h3>
            <p style="font-size: 0.85rem; color: #888; margin-bottom: 1rem;">Share a personal wedding website with your guests.</p>

            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="website_enabled" value="1" {{ old('website_enabled', $profile->website_enabled ?? false) ? 'checked' : '' }} id="websiteToggle" style="width: 18px; height: 18px;">
                    <span style="font-weight: 600;">Enable my wedding website</span>
                </label>
            </div>

            @if($profile && $profile->slug)
                <div class="website-url-box">
                    <svg style="width: 18px; height: 18px; color: #9bf6af; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    <span>{{ url('/wedding/' . $profile->slug) }}</span>
                    <a href="{{ route('wedding.site', $profile->slug) }}" target="_blank" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Preview</a>
                    <button type="button" onclick="copyUrl()" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Copy</button>
                </div>
            @endif

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                <div>
                    <label class="label">Website Theme</label>
                    <select name="website_theme" class="input">
                        @foreach(['classic' => 'Classic Elegance', 'modern' => 'Modern Minimal', 'romantic' => 'Romantic Rose', 'cultural' => 'African Cultural', 'garden' => 'Garden Dream'] as $v => $l)
                            <option value="{{ $v }}" {{ old('website_theme', $profile->website_theme ?? 'classic') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label">Accent Color</label>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <input type="color" name="primary_color" value="{{ old('primary_color', $profile->primary_color ?? '#9bf6af') }}" style="width: 50px; height: 40px; border: 1px solid #e5e5e5; border-radius: 8px; cursor: pointer;">
                        <span style="font-size: 0.85rem; color: #888;">Choose your color</span>
                    </div>
                </div>
            </div>

            <div style="margin-top: 1rem;">
                <label class="label">Cover Photo</label>
                <input type="file" name="cover_image" accept="image/*" class="input" style="padding: 0.5rem;">
                @if($profile && $profile->cover_image)
                    <div style="margin-top: 0.5rem;">
                        <img src="{{ asset('storage/' . $profile->cover_image) }}" style="width: 200px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e5e5;">
                    </div>
                @endif
            </div>
        </div>

        <!-- Special Notes -->
        <div class="form-section">
            <h3>📝 Special Notes</h3>
            <textarea name="special_notes" class="input" rows="3" placeholder="Any special requirements, allergies, or notes for vendors...">{{ old('special_notes', $profile->special_notes ?? '') }}</textarea>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-bottom: 2rem;">
            <a href="{{ route('dashboard') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary" style="min-width: 180px;">
                💾 Save Wedding Profile
            </button>
        </div>
    </form>
</div>

@if($profile && $profile->wedding_date && $profile->days_until_wedding !== null)
<script>
    const weddingDate = new Date("{{ $profile->wedding_date->toIso8601String() }}");
    function updateCountdown() {
        const now = new Date();
        const diff = weddingDate - now;
        if (diff <= 0) return;
        const days = Math.floor(diff / 86400000);
        const hours = Math.floor((diff % 86400000) / 3600000);
        const mins = Math.floor((diff % 3600000) / 60000);
        const secs = Math.floor((diff % 60000) / 1000);
        document.getElementById('cd-days').textContent = days;
        document.getElementById('cd-hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('cd-mins').textContent = String(mins).padStart(2, '0');
        document.getElementById('cd-secs').textContent = String(secs).padStart(2, '0');
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>
@endif

<script>
document.querySelectorAll('.theme-option').forEach(option => {
    option.addEventListener('click', function() {
        document.querySelectorAll('.theme-option').forEach(o => o.classList.remove('selected'));
        this.classList.add('selected');
        this.querySelector('input').checked = true;
    });
});

function copyUrl() {
    const url = "{{ $profile && $profile->slug ? url('/wedding/' . $profile->slug) : '' }}";
    navigator.clipboard.writeText(url).then(() => {
        alert('Link copied to clipboard!');
    });
}
</script>
@endsection
