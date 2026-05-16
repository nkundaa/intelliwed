<x-guest-layout>
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 1.75rem; color: var(--dark-neutral); margin-bottom: 0.5rem;">Join IntelliWed</h1>
        <p style="color: var(--text-muted);">Start your wedding journey today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Role Selection -->
        <div class="form-group">
            <label for="role" class="label">I am a:</label>
            <select id="role" name="role" class="input" required>
                <option value="client" {{ request('role') == 'client' ? 'selected' : '' }}>Couple (Planning a Wedding)</option>
                <option value="vendor" {{ request('role') == 'vendor' ? 'selected' : '' }}>Vendor (Offering Services)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="label">Full Name</label>
            <input id="name" class="input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nkunda Carmel" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="label">Email Address</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="label">Password</label>
            <input id="password" class="input" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="label">Confirm Password</label>
            <input id="password_confirmation" class="input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; margin-top: 1rem;">
            Create Account
        </button>

        <div style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-muted);">
            Already have an account? 
            <a href="{{ route('login') }}" style="color: var(--dark-neutral); font-weight: 700;">Log in instead</a>
        </div>
    </form>
</x-guest-layout>