@extends('layouts.front')

@section('title', isset($categoryName) ? $categoryName . ' - Browse Vendors' : 'Browse Vendors')

@section('content')
<!-- Hero Header -->
<div style="background: var(--soft-beige); padding: 5rem 0; border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">{{ isset($categoryName) ? $categoryName : 'Discover Top Vendors' }}</h1>
        <p style="color: var(--text-muted); max-width: 600px;">
            Find the best wedding professionals to make your special day absolutely perfect.
        </p>
    </div>
</div>

<div class="container" style="padding: 4rem 2rem;">
    <!-- Category Tabs -->
    <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 3rem;">
        <a href="{{ route('vendors.index') }}" class="btn {{ !isset($categoryName) ? 'btn-primary' : 'btn-outline' }}">All Vendors</a>
        <a href="{{ route('services.index') }}?category=photographer" class="btn btn-outline">Photographers</a>
        <a href="{{ route('services.index') }}?category=venue" class="btn btn-outline">Venues</a>
        <a href="{{ route('services.index') }}?category=decorator" class="btn btn-outline">Decorators</a>
        <a href="{{ route('services.index') }}?category=catering" class="btn btn-outline">Caterers</a>
        <a href="{{ route('services.index') }}?category=music" class="btn btn-outline">Music</a>
    </div>

    <!-- Vendors Grid -->
    @if($vendors->isEmpty())
        <div class="card" style="text-align: center; padding: 6rem 0; border: 1px dashed var(--dark-beige);">
            <svg style="width: 64px; height: 64px; color: #ccc; margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <h2 style="color: var(--text-muted);">No vendors found</h2>
            <p style="color: var(--text-muted);">Check back soon as more professionals join our platform.</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
            @foreach($vendors as $vendor)
                <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="height: 200px; position: relative;">
                        @php
                            $representativeService = $vendor->services->first();
                        @endphp
                        @if($representativeService && $representativeService->main_image)
                            <img src="{{ asset('storage/' . $representativeService->main_image) }}" alt="{{ $vendor->business_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: var(--light-neutral); display: flex; align-items: center; justify-content: center; color: #ccc;">
                                <svg style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        @endif
                        <div style="position: absolute; top: 1rem; left: 1rem;">
                            <span class="badge" style="background: var(--dark-neutral); color: var(--primary-beige);">{{ $vendor->services->count() }} Services</span>
                        </div>
                    </div>

                    <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
                        <h3 style="margin-bottom: 0.5rem; font-size: 1.25rem;">{{ $vendor->business_name }}</h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5; flex: 1;">
                            Professional wedding service provider offering a variety of packages to make your day special.
                        </p>
                        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 1rem;">
                            <div style="color: var(--text-muted); font-size: 0.85rem;">
                                {{ $vendor->total_bookings }} Bookings
                            </div>
                            <a href="{{ route('vendors.show', $vendor->id) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">View Profile</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection