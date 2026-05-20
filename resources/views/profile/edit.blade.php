@extends('layouts.dashboard')

@section('title', 'Profile Settings')

@section('content')
<div style="max-width: 720px;">
    <!-- Header -->
    <div style="margin-bottom: 2.5rem;">
        <h2 style="font-size: 1.6rem; color: var(--text-main); margin-bottom: 0.35rem;">Account Settings</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Manage your profile, security, appearance preferences, and account data.</p>
    </div>

    <!-- ── Appearance / Dark Mode ── -->
    <div class="card profile-section" style="margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--dark-neutral); color: var(--primary-beige); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">🎨</div>
            <div>
                <h3 style="font-size: 1.1rem; margin: 0; color: var(--text-main);">Appearance</h3>
                <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0;">Choose your preferred display theme.</p>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <!-- Light mode card -->
            <label class="theme-option" id="theme-light-card" style="cursor: pointer; flex: 1; min-width: 140px;">
                <input type="radio" name="theme" value="light" style="display:none;" onchange="applyTheme('light')">
                <div class="theme-preview" style="border-radius: 14px; overflow: hidden; border: 2px solid var(--border-color); transition: border-color 0.2s; padding: 1rem; background: #fff; text-align: center;">
                    <div style="width: 100%; height: 50px; background: linear-gradient(135deg, #f8f8f8, #e5e5e5); border-radius: 8px; margin-bottom: 0.75rem; display: flex; align-items: center; justify-content: center; gap: 4px;">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #ccc;"></div>
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #bbb;"></div>
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #aaa;"></div>
                    </div>
                    <div style="font-size: 0.82rem; font-weight: 600; color: #222;">☀️ Light</div>
                    <div style="font-size: 0.72rem; color: #888; margin-top: 0.2rem;">Clean & bright</div>
                </div>
            </label>

            <!-- Dark mode card -->
            <label class="theme-option" id="theme-dark-card" style="cursor: pointer; flex: 1; min-width: 140px;">
                <input type="radio" name="theme" value="dark" style="display:none;" onchange="applyTheme('dark')">
                <div class="theme-preview" style="border-radius: 14px; overflow: hidden; border: 2px solid var(--border-color); transition: border-color 0.2s; padding: 1rem; background: #1a1a1a; text-align: center;">
                    <div style="width: 100%; height: 50px; background: linear-gradient(135deg, #222, #333); border-radius: 8px; margin-bottom: 0.75rem; display: flex; align-items: center; justify-content: center; gap: 4px;">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #444;"></div>
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #555;"></div>
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #9bf6af;"></div>
                    </div>
                    <div style="font-size: 0.82rem; font-weight: 600; color: #f0f0f0;">🌙 Dark</div>
                    <div style="font-size: 0.72rem; color: #888; margin-top: 0.2rem;">Easy on the eyes</div>
                </div>
            </label>
        </div>

        <p id="theme-saved-msg" style="font-size: 0.8rem; color: #9bf6af; margin-top: 0.75rem; display: none; font-weight: 600;">✓ Theme saved</p>
    </div>

    <!-- ── Update Profile Information ── -->
    <div class="card profile-section" style="margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--dark-neutral); color: var(--primary-beige); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">👤</div>
            <div>
                <h3 style="font-size: 1.1rem; margin: 0; color: var(--text-main);">Profile Information</h3>
                <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0;">Update your name and email address.</p>
            </div>
        </div>
        @include('profile.partials.update-profile-information-form')
    </div>

    <!-- ── Update Password ── -->
    <div class="card profile-section" style="margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--dark-neutral); color: var(--primary-beige); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">🔒</div>
            <div>
                <h3 style="font-size: 1.1rem; margin: 0; color: var(--text-main);">Change Password</h3>
                <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0;">Keep your account secure with a strong password.</p>
            </div>
        </div>
        @include('profile.partials.update-password-form')
    </div>

    <!-- ── Delete Account ── -->
    <div class="card profile-section" style="border: 1px solid #ffcdd2;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #ffebee; color: #c62828; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">⚠️</div>
            <div>
                <h3 style="font-size: 1.1rem; margin: 0; color: #c62828;">Danger Zone</h3>
                <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0;">Permanently delete your account and all data.</p>
            </div>
        </div>
        @include('profile.partials.delete-user-form')
    </div>
</div>

<style>
    .profile-section { transition: box-shadow 0.2s; }
    .profile-section:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08); }

    .profile-section form { margin-top: 1rem; }
    .profile-section h2 { font-size: 1.1rem; color: var(--text-main); margin-bottom: 0.4rem; }
    .profile-section p { font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem; }

    /* Input overrides */
    input[type="text"], input[type="email"], input[type="password"], select, textarea {
        display: block; width: 100%;
        padding: 0.75rem 1rem;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-main);
        transition: var(--transition);
        margin-bottom: 0.5rem;
        font-family: inherit;
    }
    input:focus, textarea:focus {
        outline: none;
        border-color: #9bf6af;
        box-shadow: 0 0 0 3px rgba(155,246,175,0.2);
    }
    .mt-6.flex.justify-end {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    /* Selected theme card highlight */
    .theme-option.selected .theme-preview {
        border-color: #9bf6af !important;
        box-shadow: 0 0 0 3px rgba(155,246,175,0.25);
    }
</style>

<script>
function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('iw_theme', theme);
    updateThemeCards(theme);
    const msg = document.getElementById('theme-saved-msg');
    msg.style.display = 'block';
    setTimeout(() => { msg.style.display = 'none'; }, 2000);
}

function updateThemeCards(theme) {
    document.querySelectorAll('.theme-option').forEach(card => card.classList.remove('selected'));
    const card = document.getElementById('theme-' + theme + '-card');
    if (card) card.classList.add('selected');
    const radio = document.querySelector(`input[name="theme"][value="${theme}"]`);
    if (radio) radio.checked = true;
}

document.addEventListener('DOMContentLoaded', function () {
    const saved = localStorage.getItem('iw_theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
    updateThemeCards(saved);
});
</script>
@endsection
