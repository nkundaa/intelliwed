@extends('layouts.dashboard')

@section('title', 'My Digital Invitations')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Digital Invitations</h2>
    <a href="{{ route('invitations.create') }}" class="btn btn-primary">Create New Invitation</a>
</div>

@if($invitations->isEmpty())
    <div class="card" style="text-align: center; padding: 4rem 2rem;">
        <svg style="width: 64px; height: 64px; color: #ccc; margin-bottom: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 2rem;">You haven't created any digital invitations yet.</p>
        <a href="{{ route('invitations.create') }}" class="btn btn-primary">Get Started</a>
    </div>
@else
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
        @foreach($invitations as $invitation)
            <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                <div style="padding: 1.5rem; flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <span class="badge" style="background: var(--soft-beige); color: var(--dark-neutral);">{{ ucfirst($invitation->theme) }} Theme</span>
                        <span style="font-size: 0.85rem; color: var(--text-muted);">{{ $invitation->event_date->format('M d, Y') }}</span>
                    </div>
                    <h3 style="margin-bottom: 0.5rem;">{{ $invitation->title }}</h3>
                    <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.5rem;">{{ $invitation->venue }}</p>
                    
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="flex: 1;">
                            <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Guests</div>
                            <div style="font-weight: 700; font-size: 1.25rem;">{{ $invitation->guests_count }}</div>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Status</div>
                            <div style="font-weight: 700; font-size: 1rem; color: #2e7d32;">Active</div>
                        </div>
                    </div>
                </div>
                <div style="padding: 1.25rem; background: #f9f9f9; border-top: 1px solid var(--border-color); display: flex; gap: 0.75rem;">
                    <a href="{{ route('invitations.show', $invitation->id) }}" class="btn btn-outline" style="flex: 1; font-size: 0.85rem;">Manage Guests</a>
                    <a href="{{ $invitation->public_url }}" target="_blank" class="btn btn-secondary" style="flex: 1; font-size: 0.85rem;">View Invitation</a>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
