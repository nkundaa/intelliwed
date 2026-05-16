@extends('layouts.dashboard')

@section('title', 'Create Digital Invitation')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <h2 style="margin-bottom: 2rem;">Create Wedding Invitation</h2>
        <form action="{{ route('invitations.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label class="label">Invitation Title</label>
                    <input type="text" name="title" class="input" placeholder="Our Wedding Day" required>
                </div>
                <div class="form-group">
                    <label class="label">Event Date</label>
                    <input type="date" name="event_date" class="input" required>
                </div>
            </div>

            <div class="form-group">
                <label class="label">Venue Name & Address</label>
                <input type="text" name="venue" class="input" placeholder="Kigali Convention Center, KG 2 Rd, Kigali" required>
            </div>

            <div class="form-group">
                <label class="label">Personal Message (Optional)</label>
                <textarea name="message" class="input" rows="4" placeholder="Join us as we celebrate our love and commitment to each other..."></textarea>
            </div>

            <div class="form-group">
                <label class="label">Select Theme</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                    <label style="cursor: pointer;">
                        <input type="radio" name="theme" value="classic" checked style="display: none;">
                        <div class="theme-option" style="padding: 1.5rem; border: 2px solid var(--border-color); border-radius: 8px; text-align: center;">
                            <div style="font-weight: 700;">Classic</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Elegant & Timeless</div>
                        </div>
                    </label>
                    <label style="cursor: pointer;">
                        <input type="radio" name="theme" value="modern" style="display: none;">
                        <div class="theme-option" style="padding: 1.5rem; border: 2px solid var(--border-color); border-radius: 8px; text-align: center;">
                            <div style="font-weight: 700;">Modern</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Sleek & Minimalist</div>
                        </div>
                    </label>
                    <label style="cursor: pointer;">
                        <input type="radio" name="theme" value="traditional" style="display: none;">
                        <div class="theme-option" style="padding: 1.5rem; border: 2px solid var(--border-color); border-radius: 8px; text-align: center;">
                            <div style="font-weight: 700;">Traditional</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Warm & Cultural</div>
                        </div>
                    </label>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 3rem;">
                <button type="submit" class="btn btn-primary" style="flex: 2;">Create Invitation</button>
                <a href="{{ route('invitations.index') }}" class="btn btn-outline" style="flex: 1;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
    input[type="radio"]:checked + .theme-option {
        border-color: var(--dark-neutral) !important;
        background: var(--soft-beige);
    }
</style>
@endsection
