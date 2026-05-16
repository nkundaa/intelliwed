@extends('layouts.dashboard')

@section('title', 'Profile Settings')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; color: var(--dark-neutral);">Manage Your Account</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Update your personal information, security settings, and preferences.</p>
    </div>

    <!-- Update Profile Information -->
    <div class="card">
        <div style="max-width: 600px;">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- Update Password -->
    <div class="card">
        <div style="max-width: 600px;">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- Delete Account -->
    <div class="card" style="border: 1px solid #ffebee;">
        <div style="max-width: 600px;">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>

<style>
    /* Ensure partials use dashboard styles */
    .card form {
        margin-top: 1.5rem;
    }
    .card h2 {
        font-size: 1.25rem;
        color: var(--dark-neutral);
        margin-bottom: 0.5rem;
    }
    .card p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }
    /* Fix for Breeze default inputs if they aren't using the app.css variables */
    input[type="text"], input[type="email"], input[type="password"], select, textarea {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--dark-neutral);
        transition: var(--transition);
        margin-bottom: 0.5rem;
    }
    input:focus {
        outline: none;
        border-color: var(--dark-neutral);
        box-shadow: 0 0 0 4px var(--soft-beige);
    }
    .mt-6.flex.justify-end {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }
</style>
@endsection
