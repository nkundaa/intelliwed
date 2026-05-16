@extends('layouts.dashboard')

@section('title', 'Admin - Verification Requests')

@section('content')
<div class="card" style="padding: 0;">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
        <h3 style="margin: 0;">Pending Verifications</h3>
    </div>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Vendor</th>
                    <th>Document</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr>
                        <td style="font-weight: 600;">
                            {{ $request->vendor->business_name }}
                            <div style="font-size: 0.8rem; font-weight: 400; color: var(--text-muted);">{{ $request->vendor->user->email }}</div>
                        </td>
                        <td>
                            <a href="{{ asset('storage/' . $request->id_document_path) }}" target="_blank" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">View Document</a>
                        </td>
                        <td>{{ $request->created_at->diffForHumans() }}</td>
                        <td>
                            <div x-data="{ showReview: false }">
                                <button @click="showReview = !showReview" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Process Review</button>
                                
                                <div x-show="showReview" x-transition style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 2000; display: flex; align-items: center; justify-content: center;">
                                    <div @click.away="showReview = false" class="card" style="width: 100%; max-width: 500px; margin: 1rem;">
                                        <h3 style="margin-bottom: 1.5rem;">Review Verification</h3>
                                        <form action="{{ route('admin.verifications.review', $request->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label class="label">Decision</label>
                                                <select name="status" class="input" required>
                                                    <option value="approved">Approve</option>
                                                    <option value="rejected">Reject</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="label">Admin Note (optional)</label>
                                                <textarea name="admin_note" class="input" rows="3" placeholder="Explain why it was rejected..."></textarea>
                                            </div>
                                            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                                                <button type="submit" class="btn btn-primary" style="flex: 1;">Submit Decision</button>
                                                <button type="button" @click="showReview = false" class="btn btn-outline" style="flex: 1;">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if($requests->isEmpty())
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 3rem; color: var(--text-muted);">No pending verification requests.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
