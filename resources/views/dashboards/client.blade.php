@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('extra-head')
<style>
.welcome-banner {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    border-radius: 20px;
    padding: 2.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.welcome-banner::before {
    content: '';
    position: absolute;
    top: -60%;
    right: -5%;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(155,246,175,0.1) 0%, transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.countdown-chips {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.25rem;
    flex-wrap: wrap;
}
.cd-chip {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 12px;
    padding: 0.75rem 1.1rem;
    text-align: center;
    min-width: 72px;
}
.cd-num { font-size: 1.75rem; font-weight: 700; color: #9bf6af; line-height: 1; }
.cd-lbl { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.5); margin-top: 0.2rem; }
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 0.85rem;
    margin-bottom: 2rem;
}
.quick-btn {
    background: white;
    border: 1px solid #f0f0f0;
    border-radius: 14px;
    padding: 1.1rem 0.75rem;
    text-align: center;
    text-decoration: none;
    color: #222;
    transition: all 0.2s;
    display: block;
}
.quick-btn:hover {
    border-color: #9bf6af;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}
.quick-btn .icon { font-size: 1.75rem; margin-bottom: 0.4rem; }
.quick-btn .label { font-size: 0.8rem; font-weight: 600; color: #333; }
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}
.widget {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f0f0;
    overflow: hidden;
}
.widget-header {
    padding: 1.1rem 1.5rem;
    border-bottom: 1px solid #f5f5f5;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.widget-header h3 { font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: #555; }
.widget-body { padding: 1.5rem; }
.progress-track {
    background: #f0f0f0;
    border-radius: 99px;
    height: 8px;
    overflow: hidden;
    margin-top: 0.5rem;
}
.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #9bf6af, #4ade80);
    border-radius: 99px;
    transition: width 0.5s;
}
.task-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.65rem 0;
    border-bottom: 1px solid #f9f9f9;
    font-size: 0.875rem;
}
.task-row:last-child { border-bottom: none; }
.task-check {
    width: 20px; height: 20px;
    border-radius: 50%;
    border: 2px solid #ddd;
    flex-shrink: 0;
}
.task-check.done { background: #9bf6af; border-color: #4ade80; display: flex; align-items: center; justify-content: center; }
.task-check.done::after { content: '✓'; font-size: 11px; font-weight: 700; color: #166534; }
.stat-mini-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.stat-mini {
    background: white;
    border-radius: 12px;
    padding: 1.25rem 1rem;
    border: 1px solid #f0f0f0;
    text-align: center;
}
.stat-mini .num { font-size: 1.75rem; font-weight: 700; color: #222; }
.stat-mini .lbl { font-size: 0.75rem; color: #888; margin-top: 0.2rem; }
@media (max-width: 900px) {
    .dashboard-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .stat-mini-row { grid-template-columns: repeat(2, 1fr); }
    .quick-actions { grid-template-columns: repeat(3, 1fr); }
}
</style>
@endsection

@section('content')

@if(session('status'))
    <div style="background: #e8f5e9; color: #2e7d32; padding: 0.85rem 1.25rem; border-radius: 10px; margin-bottom: 1.25rem; border: 1px solid #c8e6c9; font-size: 0.9rem;">
        ✓ {{ session('status') }}
    </div>
@endif

<!-- Welcome Banner with Countdown -->
<div class="welcome-banner">
    <div style="position: relative; z-index: 1;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
            <div>
                <p style="color: rgba(255,255,255,0.5); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.4rem;">Welcome back</p>
                <h2 style="color: white; font-size: 1.6rem; margin-bottom: 0.25rem;">{{ $user->name }}</h2>
                @if($weddingProfile && $weddingProfile->partner_name)
                    <p style="color: #9bf6af; font-size: 0.95rem;">
                        💍 {{ $user->name }} & {{ $weddingProfile->partner_name }}
                        @if($weddingProfile->wedding_date)
                            · {{ $weddingProfile->wedding_date->format('M j, Y') }}
                        @endif
                    </p>
                @else
                    <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem;">Ready to plan your perfect wedding?</p>
                @endif
            </div>
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                @if($weddingProfile)
                    <a href="{{ route('wedding.profile') }}" style="background: rgba(255,255,255,0.1); color: white; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; text-decoration: none; border: 1px solid rgba(255,255,255,0.15); display: flex; align-items: center; gap: 0.4rem;">
                        ✏️ Edit Profile
                    </a>
                @else
                    <a href="{{ route('wedding.profile') }}" style="background: #9bf6af; color: #1a1a1a; padding: 0.5rem 1.25rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none;">
                        🌟 Set Up Wedding
                    </a>
                @endif
                @if($unreadMessages > 0)
                    <a href="{{ route('chat.index') }}" style="background: rgba(255,255,255,0.1); color: white; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; text-decoration: none; border: 1px solid rgba(255,255,255,0.15);">
                        💬 {{ $unreadMessages }} new message{{ $unreadMessages > 1 ? 's' : '' }}
                    </a>
                @endif
            </div>
        </div>

        @if($weddingProfile && $weddingProfile->wedding_date && $weddingProfile->days_until_wedding !== null)
            <div class="countdown-chips" id="countdownRow">
                <div class="cd-chip"><div class="cd-num" id="cd-days">{{ floor($weddingProfile->days_until_wedding) }}</div><div class="cd-lbl">Days</div></div>
                <div class="cd-chip"><div class="cd-num" id="cd-hours">--</div><div class="cd-lbl">Hours</div></div>
                <div class="cd-chip"><div class="cd-num" id="cd-mins">--</div><div class="cd-lbl">Minutes</div></div>
                <div class="cd-chip"><div class="cd-num" id="cd-secs">--</div><div class="cd-lbl">Seconds</div></div>
                <div style="display: flex; align-items: center; padding: 0 0.5rem; color: rgba(255,255,255,0.5); font-size: 0.8rem;">until the big day!</div>
            </div>
        @elseif(!$weddingProfile || !$weddingProfile->wedding_date)
            <div style="margin-top: 1rem; color: rgba(255,255,255,0.5); font-size: 0.85rem;">
                🗓️ <a href="{{ route('wedding.profile') }}" style="color: #9bf6af; text-decoration: underline;">Set your wedding date</a> to see the countdown
            </div>
        @endif
    </div>
</div>

<!-- Quick Stats Row -->
<div class="stat-mini-row">
    <div class="stat-mini">
        <div class="num">{{ $clientStats['total_bookings'] }}</div>
        <div class="lbl">Bookings</div>
    </div>
    <div class="stat-mini">
        <div class="num" style="color: #f59e0b;">{{ $clientStats['pending_bookings'] }}</div>
        <div class="lbl">Pending</div>
    </div>
    <div class="stat-mini">
        <div class="num" style="color: #4ade80;">{{ $guestStats['confirmed'] }}</div>
        <div class="lbl">Guests RSVPd</div>
    </div>
    <div class="stat-mini">
        <div class="num" style="color: #a78bfa;">{{ $taskStats['completed'] }}/{{ $taskStats['total'] }}</div>
        <div class="lbl">Tasks Done</div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <a href="{{ route('wedding.profile') }}" class="quick-btn">
        <div class="icon">💍</div>
        <div class="label">My Wedding</div>
    </a>
    <a href="{{ route('tasks.index') }}" class="quick-btn">
        <div class="icon">✅</div>
        <div class="label">Checklist</div>
    </a>
    <a href="{{ route('budget.planner') }}" class="quick-btn">
        <div class="icon">💰</div>
        <div class="label">Budget</div>
    </a>
    <a href="{{ route('invitations.index') }}" class="quick-btn">
        <div class="icon">✉️</div>
        <div class="label">Guests</div>
    </a>
    <a href="{{ route('gallery.index') }}" class="quick-btn">
        <div class="icon">🖼️</div>
        <div class="label">Gallery</div>
    </a>
    <a href="{{ route('chat.index') }}" class="quick-btn" style="{{ $unreadMessages > 0 ? 'border-color: #9bf6af; background: #f0fff4;' : '' }}">
        <div class="icon">💬</div>
        <div class="label">
            Messages
            @if($unreadMessages > 0)
                <span style="background: #ef4444; color: white; border-radius: 99px; font-size: 0.65rem; padding: 0.1rem 0.4rem; margin-left: 2px;">{{ $unreadMessages }}</span>
            @endif
        </div>
    </a>
    <a href="{{ route('vendors.index') }}" class="quick-btn">
        <div class="icon">🔍</div>
        <div class="label">Find Vendors</div>
    </a>
    <a href="{{ route('ai.budget') }}" class="quick-btn">
        <div class="icon">🤖</div>
        <div class="label">AI Tools</div>
    </a>
</div>

<!-- Dashboard Widgets Grid -->
<div class="dashboard-grid">

    <!-- Tasks Widget -->
    <div class="widget">
        <div class="widget-header">
            <h3>📋 Checklist</h3>
            <a href="{{ route('tasks.index') }}" style="font-size: 0.8rem; color: #888; text-decoration: none;">View all →</a>
        </div>
        <div class="widget-body">
            @if($taskStats['total'] > 0)
                <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: #888; margin-bottom: 0.5rem;">
                    <span>Progress</span>
                    <span>{{ $taskStats['completed'] }} / {{ $taskStats['total'] }} done</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ $taskStats['total'] > 0 ? round(($taskStats['completed'] / $taskStats['total']) * 100) : 0 }}%"></div>
                </div>
                <div style="margin-top: 1.25rem;">
                    @foreach($tasks as $task)
                        <div class="task-row">
                            <div class="task-check {{ $task->status === 'completed' ? 'done' : '' }}"></div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="{{ $task->status === 'completed' ? 'text-decoration: line-through; color: #aaa;' : '' }} white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $task->title }}</div>
                                @if($task->due_date)
                                    <div style="font-size: 0.7rem; color: {{ $task->isOverdue() ? '#ef4444' : '#aaa' }};">
                                        {{ $task->due_date->format('M j') }}{{ $task->isOverdue() ? ' · Overdue' : '' }}
                                    </div>
                                @endif
                            </div>
                            <span style="font-size: 0.7rem; color: #ccc;">{{ ['high'=>'🔴','medium'=>'🟡','low'=>'🟢'][$task->priority] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 1.5rem; color: #aaa;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📋</div>
                    <p style="font-size: 0.85rem;">No tasks yet.</p>
                    <a href="{{ route('tasks.index') }}" style="font-size: 0.85rem; color: #222; text-decoration: underline; margin-top: 0.5rem; display: block;">Create your checklist</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Budget Widget -->
    <div class="widget">
        <div class="widget-header">
            <h3>💰 Budget Overview</h3>
            <a href="{{ route('budget.planner') }}" style="font-size: 0.8rem; color: #888; text-decoration: none;">Manage →</a>
        </div>
        <div class="widget-body">
            @if($weddingProfile && $weddingProfile->total_budget)
                @php
                    $spent = $weddingProfile->budget_spent;
                    $budget = $weddingProfile->total_budget;
                    $pct = $budget > 0 ? min(100, round(($spent / $budget) * 100)) : 0;
                    $remaining = $weddingProfile->budget_remaining;
                @endphp
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1rem;">
                    <div>
                        <div style="font-size: 0.75rem; color: #888;">Total Budget</div>
                        <div style="font-size: 1.5rem; font-weight: 700;">{{ number_format($budget) }} RWF</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 0.75rem; color: #888;">Remaining</div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: {{ $pct > 90 ? '#ef4444' : '#4ade80' }};">{{ number_format($remaining) }} RWF</div>
                    </div>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ $pct }}%; {{ $pct > 90 ? 'background: linear-gradient(90deg, #ef4444, #f87171);' : '' }}"></div>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #888; margin-top: 0.5rem;">
                    <span>Spent: {{ number_format($spent) }} RWF</span>
                    <span>{{ $pct }}%</span>
                </div>
                @if($pct > 90)
                    <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 0.65rem 0.85rem; margin-top: 1rem; font-size: 0.8rem; color: #dc2626;">
                        ⚠️ You're nearing your budget limit!
                    </div>
                @endif
            @else
                <div style="text-align: center; padding: 1.5rem; color: #aaa;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">💰</div>
                    <p style="font-size: 0.85rem;">Set your wedding budget.</p>
                    <a href="{{ route('wedding.profile') }}" style="font-size: 0.85rem; color: #222; text-decoration: underline; margin-top: 0.5rem; display: block;">Add budget to profile</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Guests Widget -->
    <div class="widget">
        <div class="widget-header">
            <h3>👥 Guests</h3>
            <a href="{{ route('invitations.index') }}" style="font-size: 0.8rem; color: #888; text-decoration: none;">Manage →</a>
        </div>
        <div class="widget-body">
            @if($guestStats['total'] > 0)
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; margin-bottom: 1rem;">
                    <div style="text-align: center; background: #f9f9f9; border-radius: 10px; padding: 0.75rem;">
                        <div style="font-size: 1.4rem; font-weight: 700;">{{ $guestStats['total'] }}</div>
                        <div style="font-size: 0.7rem; color: #888;">Invited</div>
                    </div>
                    <div style="text-align: center; background: #f0fff4; border-radius: 10px; padding: 0.75rem;">
                        <div style="font-size: 1.4rem; font-weight: 700; color: #4ade80;">{{ $guestStats['confirmed'] }}</div>
                        <div style="font-size: 0.7rem; color: #888;">Confirmed</div>
                    </div>
                    <div style="text-align: center; background: #fffbeb; border-radius: 10px; padding: 0.75rem;">
                        <div style="font-size: 1.4rem; font-weight: 700; color: #f59e0b;">{{ $guestStats['pending'] }}</div>
                        <div style="font-size: 0.7rem; color: #888;">Pending</div>
                    </div>
                </div>
                @if($guestStats['total'] > 0)
                    <div class="progress-track">
                        <div class="progress-fill" style="width: {{ round(($guestStats['confirmed'] / $guestStats['total']) * 100) }}%"></div>
                    </div>
                    <div style="text-align: right; font-size: 0.75rem; color: #888; margin-top: 0.4rem;">{{ round(($guestStats['confirmed'] / $guestStats['total']) * 100) }}% confirmed</div>
                @endif
            @else
                <div style="text-align: center; padding: 1.5rem; color: #aaa;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">✉️</div>
                    <p style="font-size: 0.85rem;">No invitations sent yet.</p>
                    <a href="{{ route('invitations.index') }}" style="font-size: 0.85rem; color: #222; text-decoration: underline; margin-top: 0.5rem; display: block;">Create invitations</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Bookings Widget -->
    <div class="widget">
        <div class="widget-header">
            <h3>📦 Recent Bookings</h3>
            <a href="{{ route('bookings.index') }}" style="font-size: 0.8rem; color: #888; text-decoration: none;">View all →</a>
        </div>
        <div class="widget-body">
            @if($bookings->count() > 0)
                @foreach($bookings->take(3) as $booking)
                    <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f9f9f9;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: {{ $booking->status === 'confirmed' ? '#f0fff4' : ($booking->status === 'pending' ? '#fffbeb' : '#f9f9f9') }}; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;">
                            {{ $booking->status === 'confirmed' ? '✅' : ($booking->status === 'pending' ? '⏳' : '📦') }}
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 0.85rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Booking #{{ $booking->id }}</div>
                            <div style="font-size: 0.75rem; color: #888;">{{ $booking->booking_date ? $booking->booking_date->format('M j, Y') : 'No date' }}</div>
                        </div>
                        <div style="text-align: right; flex-shrink: 0;">
                            <div style="font-size: 0.85rem; font-weight: 600;">{{ number_format($booking->total_price) }}</div>
                            <div style="font-size: 0.65rem; text-transform: uppercase; color: {{ $booking->status === 'confirmed' ? '#4ade80' : '#f59e0b' }};">{{ $booking->status }}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 1.5rem; color: #aaa;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📦</div>
                    <p style="font-size: 0.85rem;">No bookings yet.</p>
                    <a href="{{ route('services.index') }}" style="font-size: 0.85rem; color: #222; text-decoration: underline; margin-top: 0.5rem; display: block;">Browse services</a>
                </div>
            @endif
        </div>
    </div>

</div>

<!-- AI Tools Banner -->
<div style="background: linear-gradient(135deg, #f0fff4 0%, #dcfce7 100%); border: 1px solid #bbf7d0; border-radius: 16px; padding: 1.5rem 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <div style="width: 48px; height: 48px; background: #222; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">🤖</div>
        <div>
            <div style="font-weight: 700; font-size: 0.95rem;">AI-Powered Planning</div>
            <div style="font-size: 0.85rem; color: #555;">Let our AI optimize your budget and find the best vendors for you.</div>
        </div>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('ai.budget') }}" class="btn btn-primary" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;">Optimize Budget</a>
        <a href="{{ route('ai.match') }}" class="btn btn-outline" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;">Match Vendors</a>
    </div>
</div>

@if($weddingProfile && $weddingProfile->website_enabled && $weddingProfile->slug)
<div style="background: white; border: 1px solid #f0f0f0; border-radius: 16px; padding: 1.5rem 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <div style="font-size: 1.5rem;">🌐</div>
        <div>
            <div style="font-weight: 700; font-size: 0.95rem;">Your Wedding Website is Live!</div>
            <div style="font-size: 0.8rem; color: #888; font-family: monospace;">{{ url('/wedding/' . $weddingProfile->slug) }}</div>
        </div>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('wedding.site', $weddingProfile->slug) }}" target="_blank" class="btn btn-secondary" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;">View Site</a>
    </div>
</div>
@endif

@if($weddingProfile && $weddingProfile->wedding_date && $weddingProfile->days_until_wedding !== null)
<script>
    const weddingDate = new Date("{{ $weddingProfile->wedding_date->toIso8601String() }}");
    function tick() {
        const diff = weddingDate - new Date();
        if (diff <= 0) return;
        document.getElementById('cd-days').textContent = Math.floor(diff / 86400000);
        document.getElementById('cd-hours').textContent = String(Math.floor((diff % 86400000) / 3600000)).padStart(2,'0');
        document.getElementById('cd-mins').textContent = String(Math.floor((diff % 3600000) / 60000)).padStart(2,'0');
        document.getElementById('cd-secs').textContent = String(Math.floor((diff % 60000) / 1000)).padStart(2,'0');
    }
    tick(); setInterval(tick, 1000);
</script>
@endif
@endsection