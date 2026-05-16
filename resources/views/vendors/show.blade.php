@extends('layouts.front')

@section('title', $vendor->business_name . ' - Vendor Profile | IntelliWed')

@section('content')
<!-- Vendor Header -->
<div style="background: var(--dark-neutral); color: var(--white); padding: 6rem 0 4rem; position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.2;">
        @php
            $bgService = $vendor->services->first();
        @endphp
        @if(isset($bgService) && $bgService && $bgService->main_image)
            <img src="{{ asset('storage/' . $bgService->main_image) }}" style="width: 100%; height: 100%; object-fit: cover;">
        @endif
    </div>
    <div class="container" style="position: relative; z-index: 1;">
        <div style="display: flex; align-items: flex-end; gap: 2.5rem; flex-wrap: wrap;">
            <div style="width: 150px; height: 150px; border-radius: 1rem; background: var(--white); padding: 0.5rem; box-shadow: var(--shadow-lg);">
                <div style="width: 100%; height: 100%; border-radius: 0.75rem; background: var(--soft-beige); display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 800; color: var(--dark-neutral);">
                    {{ substr($vendor->business_name, 0, 1) }}
                </div>
            </div>
            <div style="flex: 1; min-width: 300px;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                    <span class="badge" style="background: #00cfc1; color: white;">Verified Vendor</span>
                    <span style="color: var(--primary-beige); font-weight: 600;">Since {{ $vendor->created_at->format('M Y') }}</span>
                </div>
                <h1 style="font-size: 3rem; margin-bottom: 0.5rem; color: var(--primary-beige);">{{ $vendor->business_name }}</h1>
                <p style="font-size: 1.25rem; opacity: 0.9; max-width: 600px;">Professional wedding excellence in {{ optional($vendor->services->first())->location ?? 'Rwanda' }}.</p>
            </div>
            <div style="display: flex; gap: 2rem;">
                <div style="text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary-beige);">{{ $vendor->services->count() }}</div>
                    <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.7;">Services</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary-beige);">{{ $vendor->total_bookings }}</div>
                    <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.7;">Bookings</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding: 4rem 2rem;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 4rem;">
        <!-- Main Content -->
        <div>
            <section style="margin-bottom: 4rem;">
                <h2 style="font-size: 1.75rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--soft-beige); padding-bottom: 0.5rem; display: inline-block;">About This Vendor</h2>
                <div style="line-height: 1.8; color: var(--text-muted); font-size: 1.1rem;">
                    <p>{{ $vendor->business_name }} is a dedicated wedding professional committed to making your special day extraordinary. With {{ $vendor->services->count() }} specialized services available, they offer a comprehensive range of options tailored to your unique vision.</p>
                    <p style="margin-top: 1rem;">Based in {{ optional($vendor->services->first())->location ?? 'the heart of Rwanda' }}, they bring years of experience and a passion for excellence to every event they handle.</p>
                </div>
            </section>

            <section>
                <h2 style="font-size: 1.75rem; margin-bottom: 2rem;">Available Services</h2>
                <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
                    @foreach($vendor->services as $service)
                        <div class="card" style="display: flex; gap: 1.5rem; padding: 1rem; align-items: center;">
                            <div style="width: 120px; height: 120px; border-radius: 0.5rem; overflow: hidden; flex-shrink: 0;">
                                @if($service->main_image)
                                    <img src="{{ asset('storage/' . $service->main_image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; background: var(--soft-beige); display: flex; align-items: center; justify-content: center; color: #ccc;">
                                        <svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div>
                                        <span class="badge" style="background: var(--soft-beige); color: var(--dark-neutral); margin-bottom: 0.5rem; display: inline-block;">{{ ucfirst($service->category) }}</span>
                                        <h3 style="margin: 0; font-size: 1.25rem;">{{ $service->title }}</h3>
                                    </div>
                                    <div style="text-align: right;">
                                        <div style="font-weight: 800; font-size: 1.25rem; color: var(--dark-neutral);">${{ number_format($service->price, 2) }}</div>
                                    </div>
                                </div>
                                <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0.5rem 0 1rem;">{{ Str::limit($service->description, 120) }}</p>
                                <a href="{{ route('services.show', $service->id) }}" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.85rem;">View Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Sidebar -->
        <div>
            <div class="card" style="position: sticky; top: 120px;">
                <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem;">Contact Vendor</h3>
                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--soft-beige); display: flex; align-items: center; justify-content: center; color: var(--dark-neutral);">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Email Address</div>
                            <div style="font-weight: 600;">{{ $vendor->user->email }}</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--soft-beige); display: flex; align-items: center; justify-content: center; color: var(--dark-neutral);">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Location</div>
                            <div style="font-weight: 600;">{{ optional($vendor->services->first())->location ?? 'Rwanda' }}</div>
                        </div>
                    </div>
                    
                    <hr style="border: none; border-top: 1px solid var(--border-color); margin: 0.5rem 0;">

                    @auth
                        @if(auth()->user()->isClient())
                            <a href="{{ route('chat.start', $vendor->user_id) }}" class="btn btn-primary" style="text-align: center; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Message this Vendor
                            </a>
                            <p style="font-size: 0.8rem; color: var(--text-muted); text-align: center; margin-top: 0.25rem;">Ask questions before booking</p>
                        @else
                            <p style="font-size: 0.9rem; color: var(--text-muted); text-align: center;">Interested in working with {{ $vendor->business_name }}? Browse their services to book now.</p>
                            <a href="{{ route('services.index') }}" class="btn btn-primary" style="text-align: center;">Explore More Services</a>
                        @endif
                    @else
                        <div style="background: var(--dark-neutral); border-radius: 12px; padding: 1.5rem; text-align: center;">
                            <p style="color: #ccc; font-size: 0.9rem; margin-bottom: 1rem;">Sign in to message {{ $vendor->business_name }} directly.</p>
                            <button onclick="window.openAuthModal('login')" class="btn btn-secondary" style="width: 100%; cursor: pointer; font-family: inherit; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Sign in to Message
                            </button>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
