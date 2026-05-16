<x-guest-layout>
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 1.75rem; color: var(--dark-neutral); margin-bottom: 0.5rem;">Welcome back</h1>
        <p style="color: var(--text-muted);">Sign in to manage your wedding workspace.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="label">Email Address</label>
            <input id="email" class="input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <label for="password" class="label">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem;">Forgot password?</a>
                @endif
            </div>
            <input id="password" class="input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div style="margin-bottom: 1.5rem;">
            <label for="remember_me" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.9rem; color: var(--text-muted);">
                <input id="remember_me" type="checkbox" name="remember" style="width: 16px; height: 16px; accent-color: var(--dark-neutral);">
                <span>Remember me</span>
            </label>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">
            Sign In
        </button>
        
        <div style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-muted);">
            Don't have an account? 
            <a href="{{ route('register') }}" style="color: var(--dark-neutral); font-weight: 700;">Create an account</a>
        </div>
    </form>
</x-guest-layout>
