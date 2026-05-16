@extends('layouts.dashboard')

@section('title', 'Admin Service Management')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2 style="font-size: 1.5rem; color: var(--dark-neutral);">Global Service Catalog</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Review and manage all wedding services listed on the platform.</p>
    </div>
</div>

@if($services->count() > 0)
    <div class="card" style="padding: 0;">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Service Details</th>
                        <th>Vendor</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 48px; height: 48px; border-radius: 8px; overflow: hidden; background: var(--light-neutral); border: 1px solid var(--border-color);">
                                        @if($service->main_image)
                                            <img src="{{ asset('storage/' . $service->main_image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc;">
                                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--dark-neutral);">{{ $service->title }}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $service->location }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $service->vendor_name ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <span class="badge" style="background: var(--soft-beige); color: var(--dark-neutral);">
                                    {{ ucfirst($service->category) }}
                                </span>
                            </td>
                            <td style="font-weight: 700;">${{ number_format($service->price, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $service->status == 'active' ? 'approved' : 'pending' }}">
                                    {{ ucfirst($service->status) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.75rem;">
                                    <a href="{{ route('services.admin-edit', $service->id) }}" style="color: var(--accent); font-weight: 600; font-size: 0.85rem;">Edit</a>
                                    <form method="POST" action="{{ route('services.admin-destroy', $service->id) }}" onsubmit="return confirm('Delete this service permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: #c62828; font-weight: 600; font-size: 0.85rem; background: none; border: none; cursor: pointer;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="card" style="text-align: center; padding: 4rem 2rem;">
        <h3 style="color: var(--text-muted);">No services found</h3>
        <p style="color: var(--text-muted);">The platform's service catalog is currently empty.</p>
    </div>
@endif
@endsection
