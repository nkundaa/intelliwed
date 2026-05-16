@extends('layouts.dashboard')

@section('title', 'Manage Invitation')

@section('content')
<div style="display: flex; gap: 2rem;">
    <!-- Sidebar: Stats & Share -->
    <div style="width: 320px; flex-shrink: 0;">
        <div class="card" style="margin-bottom: 2rem; text-align: center;">
            <h3 style="margin-bottom: 1.5rem;">Share Invitation</h3>
            <div style="padding: 1.5rem; background: var(--white); border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 1.5rem;">
                <img src="{{ $invitation->qr_code_url }}" alt="QR Code" style="width: 150px; height: 150px; margin: 0 auto 1rem;">
                <p style="font-size: 0.8rem; color: var(--text-muted);">Scan this QR code to view the invitation</p>
            </div>
            <div class="form-group" style="text-align: left;">
                <label class="label">Invitation Link</label>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="text" value="{{ $invitation->public_url }}" readonly class="input" style="font-size: 0.8rem;">
                    <button onclick="navigator.clipboard.writeText('{{ $invitation->public_url }}')" class="btn btn-outline" style="padding: 0.5rem;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-1 4h.01M9 16h5m0 0l-1.5 1.5M14 16l-1.5-1.5"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 1.5rem;">RSVP Summary</h3>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.9rem; color: var(--text-muted);">Attending</span>
                    <span class="badge" style="background: #e8f5e9; color: #2e7d32; font-weight: 700;">{{ $invitation->guests->where('status', 'yes')->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.9rem; color: var(--text-muted);">Maybe</span>
                    <span class="badge" style="background: #fff8e1; color: #f57f17; font-weight: 700;">{{ $invitation->guests->where('status', 'maybe')->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.9rem; color: var(--text-muted);">Not Attending</span>
                    <span class="badge" style="background: #ffebee; color: #c62828; font-weight: 700;">{{ $invitation->guests->where('status', 'no')->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.9rem; color: var(--text-muted);">Pending</span>
                    <span class="badge" style="background: var(--light-neutral); color: var(--dark-neutral); font-weight: 700;">{{ $invitation->guests->where('status', 'pending')->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content: Guest List -->
    <div style="flex: 1;">
        <div class="card" style="padding: 0;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0;">Guest Responses</h3>
                <button class="btn btn-outline" style="font-size: 0.85rem;">Export CSV</button>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Guest Name</th>
                            <th>Status</th>
                            <th>Meal Preference</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invitation->guests as $guest)
                            <tr>
                                <td style="font-weight: 600;">
                                    {{ $guest->name }}
                                    <div style="font-size: 0.8rem; font-weight: 400; color: var(--text-muted);">{{ $guest->email ?? $guest->phone }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $guest->status == 'yes' ? 'approved' : ($guest->status == 'no' ? 'rejected' : 'pending') }}">
                                        {{ ucfirst($guest->status) }}
                                    </span>
                                </td>
                                <td style="font-size: 0.9rem;">{{ $guest->meal_pref ?? '-' }}</td>
                                <td style="font-size: 0.85rem; color: var(--text-muted);">{{ $guest->responded_at ? $guest->responded_at->format('M d, Y') : '-' }}</td>
                            </tr>
                        @endforeach
                        @if($invitation->guests->isEmpty())
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 4rem; color: var(--text-muted);">No responses yet. Share your invitation link to get started!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
