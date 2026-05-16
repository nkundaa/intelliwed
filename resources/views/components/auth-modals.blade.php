@php
    $hasLoginError   = $errors->has('email') || ($errors->has('password') && !$errors->has('name') && !$errors->has('role'));
    $hasRegisterError = $errors->has('name') || $errors->has('role') || $errors->has('password_confirmation');
    $autoOpen = $errors->any() || session('status');
    $autoTab  = $hasRegisterError ? 'register' : 'login';
@endphp

<div id="authModalRoot"
     x-data="{
         open: {{ $autoOpen ? 'true' : 'false' }},
         tab: '{{ $autoTab }}',
     }"
     @open-auth.window="open = true; tab = $event.detail"
     @keydown.escape.window="open = false"
     x-show="open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="position: fixed; inset: 0; z-index: 99999; display: flex; align-items: center; justify-content: center; padding: 1rem; background: rgba(0,0,0,0.55); backdrop-filter: blur(2px);"
     @click.self="open = false">

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         style="background: white; border-radius: 24px; width: 100%; max-width: 460px; max-height: 92vh; overflow-y: auto; box-shadow: 0 25px 80px rgba(0,0,0,0.2); position: relative;">

        <!-- Close -->
        <button @click="open = false"
                style="position: absolute; top: 1rem; right: 1rem; width: 34px; height: 34px; border-radius: 50%; background: #f0f0f0; border: none; cursor: pointer; font-size: 1.2rem; color: #555; display: flex; align-items: center; justify-content: center; z-index: 1; transition: background 0.15s;"
                onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f0f0f0'">×</button>

        <!-- Logo + Header -->
        <div style="text-align: center; padding: 2rem 2rem 0;">
            <div style="font-size: 2.2rem; margin-bottom: 0.5rem;">💍</div>
            <h2 style="font-size: 1.5rem; margin: 0 0 0.25rem; font-family: Poppins, sans-serif;">IntelliWed</h2>
            <p style="color: #888; font-size: 0.85rem; margin: 0 0 1.5rem;">Your intelligent wedding planning platform</p>

            <!-- Tabs -->
            <div style="display: flex; background: #f5f5f5; border-radius: 12px; padding: 0.3rem; gap: 0.3rem; margin-bottom: 1.75rem;">
                <button @click="tab = 'login'"
                        :style="tab === 'login' ? 'background: white; color: #222; box-shadow: 0 1px 4px rgba(0,0,0,0.1);' : 'background: transparent; color: #888;'"
                        style="flex: 1; padding: 0.65rem; border: none; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; font-family: inherit; transition: all 0.2s;">
                    Sign In
                </button>
                <button @click="tab = 'register'"
                        :style="tab === 'register' ? 'background: white; color: #222; box-shadow: 0 1px 4px rgba(0,0,0,0.1);' : 'background: transparent; color: #888;'"
                        style="flex: 1; padding: 0.65rem; border: none; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; font-family: inherit; transition: all 0.2s;">
                    Create Account
                </button>
            </div>
        </div>

        <div style="padding: 0 2rem 2rem;">

            {{-- ─── LOGIN FORM ─── --}}
            <div x-show="tab === 'login'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

                @if(session('status'))
                    <div style="background: #f0fff4; color: #166534; border: 1px solid #bbf7d0; border-radius: 10px; padding: 0.75rem 1rem; margin-bottom: 1rem; font-size: 0.85rem;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; color: #333;">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               placeholder="name@example.com"
                               class="auth-input {{ $hasLoginError && $errors->has('email') ? 'auth-input-error' : '' }}">
                        @if($hasLoginError && $errors->has('email'))
                            <p style="color: #ef4444; font-size: 0.78rem; margin-top: 0.3rem; margin-bottom: 0;">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                            <label style="font-weight: 600; font-size: 0.85rem; color: #333;">Password</label>
                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}" style="font-size: 0.78rem; color: #888; text-decoration: none;">Forgot password?</a>
                            @endif
                        </div>
                        <input type="password" name="password" required autocomplete="current-password"
                               placeholder="••••••••"
                               class="auth-input {{ $hasLoginError && $errors->has('password') ? 'auth-input-error' : '' }}">
                        @if($hasLoginError && $errors->has('password'))
                            <p style="color: #ef4444; font-size: 0.78rem; margin-top: 0.3rem; margin-bottom: 0;">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.85rem; color: #666;">
                            <input type="checkbox" name="remember" style="width: 15px; height: 15px; accent-color: #222;">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="auth-submit-btn">Sign In</button>

                    <p style="text-align: center; margin-top: 1.1rem; font-size: 0.85rem; color: #888;">
                        No account yet?
                        <button type="button" @click="tab = 'register'" style="background: none; border: none; color: #222; font-weight: 700; cursor: pointer; font-family: inherit; font-size: inherit; padding: 0;">Create one free</button>
                    </p>
                </form>
            </div>

            {{-- ─── REGISTER FORM ─── --}}
            <div x-show="tab === 'register'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; color: #333;">I am a:</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                            <label style="cursor: pointer;">
                                <input type="radio" name="role" value="client" {{ old('role', 'client') === 'client' ? 'checked' : '' }} style="display: none;" class="role-radio">
                                <div class="role-card {{ old('role', 'client') === 'client' ? 'role-card-active' : '' }}" onclick="selectRole(this, 'client')">
                                    <div style="font-size: 1.5rem; margin-bottom: 0.25rem;">💑</div>
                                    <div style="font-weight: 700; font-size: 0.85rem;">Couple</div>
                                    <div style="font-size: 0.75rem; color: #888;">Planning a wedding</div>
                                </div>
                            </label>
                            <label style="cursor: pointer;">
                                <input type="radio" name="role" value="vendor" {{ old('role') === 'vendor' ? 'checked' : '' }} style="display: none;" class="role-radio">
                                <div class="role-card {{ old('role') === 'vendor' ? 'role-card-active' : '' }}" onclick="selectRole(this, 'vendor')">
                                    <div style="font-size: 1.5rem; margin-bottom: 0.25rem;">🛍️</div>
                                    <div style="font-weight: 700; font-size: 0.85rem;">Vendor</div>
                                    <div style="font-size: 0.75rem; color: #888;">Offering services</div>
                                </div>
                            </label>
                        </div>
                        @if($errors->has('role'))
                            <p style="color: #ef4444; font-size: 0.78rem; margin-top: 0.3rem; margin-bottom: 0;">{{ $errors->first('role') }}</p>
                        @endif
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; color: #333;">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
                               placeholder="Nkunda Carmel"
                               class="auth-input {{ $errors->has('name') ? 'auth-input-error' : '' }}">
                        @if($errors->has('name'))
                            <p style="color: #ef4444; font-size: 0.78rem; margin-top: 0.3rem; margin-bottom: 0;">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; color: #333;">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                               placeholder="name@example.com"
                               class="auth-input {{ $hasRegisterError && $errors->has('email') ? 'auth-input-error' : '' }}">
                        @if($hasRegisterError && $errors->has('email'))
                            <p style="color: #ef4444; font-size: 0.78rem; margin-top: 0.3rem; margin-bottom: 0;">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; color: #333;">Password</label>
                            <input type="password" name="password" required autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="auth-input {{ $errors->has('password') && $hasRegisterError ? 'auth-input-error' : '' }}">
                            @if($errors->has('password') && $hasRegisterError)
                                <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem; margin-bottom: 0;">{{ $errors->first('password') }}</p>
                            @endif
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; color: #333;">Confirm</label>
                            <input type="password" name="password_confirmation" required autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="auth-input {{ $errors->has('password_confirmation') ? 'auth-input-error' : '' }}">
                        </div>
                    </div>

                    <button type="submit" class="auth-submit-btn" style="background: #166534;">Create Account</button>

                    <p style="text-align: center; margin-top: 1.1rem; font-size: 0.85rem; color: #888;">
                        Already have an account?
                        <button type="button" @click="tab = 'login'" style="background: none; border: none; color: #222; font-weight: 700; cursor: pointer; font-family: inherit; font-size: inherit; padding: 0;">Sign in instead</button>
                    </p>
                </form>
            </div>

        </div>
    </div>
</div>

<style>
.auth-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid #e5e5e5;
    border-radius: 10px;
    font-size: 0.9rem;
    font-family: inherit;
    outline: none;
    transition: border-color 0.2s;
    box-sizing: border-box;
}
.auth-input:focus { border-color: #222; }
.auth-input-error { border-color: #ef4444 !important; }
.auth-submit-btn {
    width: 100%;
    padding: 0.9rem;
    background: #222;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
    transition: background 0.2s, transform 0.1s;
}
.auth-submit-btn:hover { background: #000; transform: translateY(-1px); }
.auth-submit-btn:active { transform: translateY(0); }
.role-card {
    border: 1.5px solid #e5e5e5;
    border-radius: 12px;
    padding: 0.85rem;
    text-align: center;
    transition: all 0.15s;
    background: #fafafa;
}
.role-card:hover { border-color: #aaa; background: #f5f5f5; }
.role-card-active { border-color: #222 !important; background: #f8f8f8 !important; box-shadow: 0 0 0 2px #222; }
</style>

<script>
window.openAuthModal = function(tab) {
    window.dispatchEvent(new CustomEvent('open-auth', { detail: tab || 'login' }));
};
function selectRole(cardEl, value) {
    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('role-card-active'));
    cardEl.classList.add('role-card-active');
    document.querySelectorAll('.role-radio').forEach(r => { r.checked = r.value === value; });
}
</script>
