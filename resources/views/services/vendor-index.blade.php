@extends('layouts.dashboard')

@section('title', 'My Services')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.5rem; color: var(--dark-neutral);">My Wedding Services</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Manage and track the performance of your listings.</p>
    </div>
    <a href="{{ route('services.create') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">+ Add New Service</a>
</div>

@if($services->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
        @foreach($services as $service)
            <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                <div style="height: 200px; position: relative;">
                    @if($service->main_image)
                        <img src="{{ asset('storage/' . $service->main_image) }}" alt="{{ $service->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: var(--light-neutral); display: flex; align-items: center; justify-content: center; color: #ccc;">
                            <svg style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div style="position: absolute; top: 1rem; right: 1rem;">
                        <span class="badge" style="background: {{ $service->status == 'active' ? '#e8f5e9; color: #2e7d32;' : '#ffebee; color: #c62828;' }}">
                            {{ ucfirst($service->status) }}
                        </span>
                    </div>
                </div>

                <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                        <h3 style="margin: 0; font-size: 1.25rem;">{{ $service->title }}</h3>
                        <div style="font-weight: 700; color: var(--dark-neutral); font-size: 1.1rem;">${{ number_format($service->price, 2) }}</div>
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">{{ ucfirst($service->category) }} • {{ $service->location }}</p>

                    <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--border-color); padding-top: 1rem; margin-bottom: 1.5rem; font-size: 0.85rem; color: var(--medium-neutral);">
                        <span style="display: flex; align-items: center; gap: 0.3rem;">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            {{ $service->bookings_count }} Bookings
                        </span>
                        <span style="display: flex; align-items: center; gap: 0.3rem;">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            {{ $service->visits_count }} Views
                        </span>
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: auto;">
                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-outline" style="flex: 1; padding: 0.5rem;">View</a>
                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-secondary" style="flex: 1; padding: 0.5rem;">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card" style="text-align: center; padding: 6rem 0; border: 1px dashed var(--dark-beige);">
        <svg style="width: 64px; height: 64px; color: #ccc; margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        <h2 style="color: var(--text-muted);">No services listed yet</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">Start reaching more clients by listing your wedding services today.</p>
        <a href="{{ route('services.create') }}" class="btn btn-primary" style="padding: 1rem 3rem;">List Your First Service</a>
    </div>
@endif
@endsection
