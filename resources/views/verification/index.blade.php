@extends('layouts.dashboard')

@section('title', __('nav.verification'))

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card" style="margin-bottom: 2rem;">
        <h2 style="margin-bottom: 1.5rem;">{{ __('vendor.verification_status') }}</h2>
        
        <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--soft-beige); display: flex; align-items: center; justify-content: center;">
                @if($vendor->is_verified)
                    <svg style="width: 48px; height: 48px; color: #34aaff;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                @else
                    <svg style="width: 48px; height: 48px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-9.618 3.072 11.956 11.956 0 00-1.382 11.054 11.95 11.95 0 005.108 5.935L12 21.503l.892-.54c3.19-1.933 5.108-5.41 5.108-5.935a11.956 11.956 0 00-1.382-11.054z"></path></svg>
                @endif
            </div>
            <div>
                <h3 style="font-size: 1.25rem;">{{ $vendor->is_verified ? __('vendor.approved') : __('vendor.pending_approval') }}</h3>
                <p style="color: var(--text-muted);">{{ $vendor->is_verified ? 'Your business identity has been verified.' : 'Verify your business to earn a trust badge.' }}</p>
            </div>
        </div>

        @if(!$vendor->is_verified)
            <form action="{{ route('vendor.verification.store') }}" method="POST" enctype="multipart/form-data" style="border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label class="label">Identity Document (ID/Passport)</label>
                        <input type="file" name="id_document" class="input" required>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.25rem;">Verify your identity</p>
                    </div>
                    <div class="form-group">
                        <label class="label">Business License (RDB Cert)</label>
                        <input type="file" name="business_license" class="input">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.25rem;">Verify your business registration</p>
                    </div>
                    <div class="form-group">
                        <label class="label">Portfolio / Website Link</label>
                        <input type="url" name="portfolio_link" class="input" placeholder="https://...">
                    </div>
                    <div class="form-group">
                        <label class="label">Years of Experience</label>
                        <input type="number" name="years_experience" class="input" placeholder="e.g. 5">
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="label">Physical Business Address</label>
                        <input type="text" name="physical_address" class="input" placeholder="District, Sector, Street...">
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="label">Reference Contact (Previous Client/Vendor)</label>
                        <input type="text" name="reference_contact" class="input" placeholder="Name and Phone/Email">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">{{ __('vendor.submit_verification') }}</button>
            </form>
        @endif
    </div>

    <div class="card" style="margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1rem;">{{ __('vendor.earned_badges') }}</h3>
        <x-vendor-badges :badges="$badges" />
        @if($badges->isEmpty())
            <p style="color: var(--text-muted); font-size: 0.9rem;">You haven't earned any badges yet. Complete verification and get more bookings to earn badges!</p>
        @endif
    </div>

    @if($requests->isNotEmpty())
        <div class="card" style="padding: 0;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
                <h3 style="margin: 0;">Verification History</h3>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Admin Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                            <tr>
                                <td>{{ $request->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $request->status }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td style="font-size: 0.9rem; color: var(--text-muted);">{{ $request->admin_note ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
