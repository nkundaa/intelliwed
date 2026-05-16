@extends('layouts.dashboard')

@section('title', 'Notifications')

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h2 style="font-size: 1.5rem; margin: 0;">Notifications</h2>
            <p style="color: #888; font-size: 0.9rem; margin-top: 0.25rem;">Stay up to date with your wedding journey</p>
        </div>
        @if($notifications->where('read_at', null)->count() > 0)
            <form method="POST" action="{{ route('notifications.mark-read') }}">
                @csrf
                <button type="submit" class="btn btn-outline" style="font-size: 0.85rem; padding: 0.5rem 1rem;">Mark all read</button>
            </form>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div style="text-align: center; padding: 5rem 2rem; background: white; border-radius: 16px; border: 1px dashed #ddd;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🔔</div>
            <h3 style="margin-bottom: 0.5rem;">No notifications yet</h3>
            <p style="color: #888;">You'll receive updates about bookings, messages, and more here.</p>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @foreach($notifications as $notification)
                @php
                    $data = $notification->data;
                    $isUnread = is_null($notification->read_at);
                @endphp
                <div style="background: white; border-radius: 14px; padding: 1.25rem; border: 1px solid {{ $isUnread ? '#9bf6af' : '#f0f0f0' }}; display: flex; gap: 1rem; align-items: flex-start; {{ $isUnread ? 'background: #f0fff4;' : '' }}">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: {{ $isUnread ? '#9bf6af' : '#f0f0f0' }}; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;">
                        {{ $data['icon'] ?? '🔔' }}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-weight: {{ $isUnread ? '700' : '500' }}; font-size: 0.9rem; margin-bottom: 0.2rem;">
                            {{ $data['title'] ?? 'Notification' }}
                        </div>
                        @if(isset($data['message']))
                            <div style="font-size: 0.85rem; color: #666; line-height: 1.5;">{{ $data['message'] }}</div>
                        @endif
                        <div style="font-size: 0.75rem; color: #aaa; margin-top: 0.5rem;">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @if($isUnread)
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #4ade80; flex-shrink: 0; margin-top: 0.35rem;"></div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div style="margin-top: 2rem; display: flex; justify-content: center;">
                {{ $notifications->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
