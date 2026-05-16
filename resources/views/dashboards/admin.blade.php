@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('extra-head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}
.admin-stat {
    background: white;
    border-radius: 14px;
    padding: 1.5rem;
    border: 1px solid #f0f0f0;
    position: relative;
    overflow: hidden;
}
.admin-stat .icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 2.5rem;
    opacity: 0.1;
}
.admin-stat .num { font-size: 2rem; font-weight: 700; line-height: 1; }
.admin-stat .lbl { font-size: 0.75rem; color: #888; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.4rem; }
.admin-stat .sub { font-size: 0.75rem; color: #f59e0b; margin-top: 0.25rem; }
.charts-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}
.chart-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #f0f0f0;
}
.chart-card h3 {
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #555;
    margin-bottom: 1.25rem;
}
.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}
.data-table th {
    text-align: left;
    padding: 0.75rem 1rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #888;
    border-bottom: 1px solid #f0f0f0;
    font-weight: 600;
}
.data-table td {
    padding: 0.85rem 1rem;
    border-bottom: 1px solid #f9f9f9;
    color: #333;
}
.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: #fafafa; }
.badge-sm {
    font-size: 0.7rem;
    padding: 0.2rem 0.6rem;
    border-radius: 99px;
    font-weight: 600;
    text-transform: uppercase;
}
.badge-confirmed { background: #dcfce7; color: #166534; }
.badge-pending { background: #fef9c3; color: #854d0e; }
.badge-active { background: #dbeafe; color: #1d4ed8; }
.badge-rejected { background: #fee2e2; color: #991b1b; }
.admin-tabs {
    display: flex;
    gap: 0.25rem;
    background: #f5f5f5;
    padding: 0.35rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}
.admin-tab {
    flex: 1;
    text-align: center;
    padding: 0.6rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    background: none;
    color: #888;
}
.admin-tab.active { background: white; color: #222; box-shadow: 0 1px 4px rgba(0,0,0,0.08); }
@media (max-width: 768px) {
    .charts-grid { grid-template-columns: 1fr; }
    .admin-stats { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endsection

@section('content')
<div style="max-width: 100%;">

    @if(session('status'))
        <div style="background: #e8f5e9; color: #2e7d32; padding: 0.85rem 1.25rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.9rem;">
            ✓ {{ session('status') }}
        </div>
    @endif

    <!-- Key Metrics -->
    <div class="admin-stats">
        <div class="admin-stat">
            <div class="icon">👥</div>
            <div class="num">{{ $stats['total_users'] }}</div>
            <div class="lbl">Total Users</div>
            <div class="sub">{{ $stats['total_clients'] }} couples</div>
        </div>
        <div class="admin-stat">
            <div class="icon">🏪</div>
            <div class="num">{{ $stats['total_vendors'] }}</div>
            <div class="lbl">Vendors</div>
            @if($stats['pending_vendors'] > 0)
                <div class="sub">{{ $stats['pending_vendors'] }} awaiting review</div>
            @endif
        </div>
        <div class="admin-stat">
            <div class="icon">📋</div>
            <div class="num">{{ $stats['total_bookings'] }}</div>
            <div class="lbl">Bookings</div>
        </div>
        <div class="admin-stat">
            <div class="icon">🛍️</div>
            <div class="num">{{ $stats['total_services'] }}</div>
            <div class="lbl">Services</div>
            <div class="sub">{{ $stats['active_services'] }} active</div>
        </div>
        <div class="admin-stat">
            <div class="icon">👁️</div>
            <div class="num">{{ number_format($stats['total_visits']) }}</div>
            <div class="lbl">Total Views</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="charts-grid">
        <!-- Booking Status Chart -->
        <div class="chart-card">
            <h3>📊 Booking Breakdown</h3>
            <canvas id="bookingChart" height="200"></canvas>
        </div>

        <!-- User Roles Chart -->
        <div class="chart-card">
            <h3>👤 User Distribution</h3>
            <canvas id="userChart" height="200"></canvas>
        </div>
    </div>

    <!-- Tabbed Content -->
    <div style="background: white; border-radius: 16px; border: 1px solid #f0f0f0; overflow: hidden; margin-bottom: 2rem;">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f0f0f0;">
            <div class="admin-tabs">
                <button class="admin-tab active" onclick="showTab('vendors', this)">🏪 Vendors ({{ $allVendors->count() }})</button>
                <button class="admin-tab" onclick="showTab('users', this)">👥 Users ({{ $allUsers->count() }})</button>
                <button class="admin-tab" onclick="showTab('bookings', this)">📋 Bookings ({{ $allBookings->count() }})</button>
                <button class="admin-tab" onclick="showTab('services', this)">🛍️ Services ({{ $allServices->count() }})</button>
            </div>
        </div>

        <!-- Vendors Tab -->
        <div id="tab-vendors">
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Business</th>
                            <th>Email</th>
                            <th>Category</th>
                            <th>Services</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allVendors as $vendor)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $vendor->business_name ?? $vendor->user->name }}</div>
                                    <div style="font-size: 0.75rem; color: #888;">ID #{{ $vendor->id }}</div>
                                </td>
                                <td style="color: #666;">{{ $vendor->user->email }}</td>
                                <td style="color: #666; text-transform: capitalize;">{{ $vendor->category ?? '—' }}</td>
                                <td style="font-weight: 600;">{{ $vendor->services->count() }}</td>
                                <td>
                                    <span class="badge-sm {{ $vendor->status === 'approved' ? 'badge-confirmed' : ($vendor->status === 'pending' ? 'badge-pending' : 'badge-rejected') }}">
                                        {{ ucfirst($vendor->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                                        <a href="{{ route('vendors.show', $vendor->id) }}" style="font-size: 0.8rem; color: #666; text-decoration: none; padding: 0.25rem 0.6rem; border: 1px solid #e5e5e5; border-radius: 6px;">View</a>
                                        @if($vendor->status === 'pending')
                                            <span style="font-size: 0.8rem; color: #888; padding: 0.25rem 0.6rem; border: 1px solid #e5e5e5; border-radius: 6px; cursor: default;">Pending review</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center; padding: 2rem; color: #aaa;">No vendors found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Users Tab -->
        <div id="tab-users" style="display: none;">
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allUsers as $u)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #222; color: #9bf6af; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; flex-shrink: 0;">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                                        <div>
                                            <div style="font-weight: 600;">{{ $u->name }}</div>
                                            <div style="font-size: 0.75rem; color: #888;">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-sm {{ $u->role === 'admin' ? 'badge-active' : ($u->role === 'vendor' ? 'badge-pending' : 'badge-confirmed') }}">{{ ucfirst($u->role) }}</span>
                                </td>
                                <td>
                                    <span class="badge-sm {{ $u->status === 'approved' ? 'badge-confirmed' : 'badge-pending' }}">{{ ucfirst($u->status ?? 'active') }}</span>
                                </td>
                                <td style="color: #888; font-size: 0.8rem;">{{ $u->created_at->format('M j, Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" style="text-align:center; padding: 2rem; color: #aaa;">No users found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bookings Tab -->
        <div id="tab-bookings" style="display: none;">
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Services</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allBookings as $booking)
                            <tr>
                                <td style="color: #888; font-size: 0.8rem;">#{{ $booking->id }}</td>
                                <td>
                                    <div style="font-weight: 600;">{{ $booking->user->name }}</div>
                                    <div style="font-size: 0.75rem; color: #888;">{{ $booking->user->email }}</div>
                                </td>
                                <td>{{ $booking->items->count() }} service(s)</td>
                                <td style="font-weight: 600;">{{ number_format($booking->total_price) }} RWF</td>
                                <td style="color: #888; font-size: 0.8rem;">{{ $booking->booking_date ? $booking->booking_date->format('M j, Y') : '—' }}</td>
                                <td>
                                    <span class="badge-sm {{ $booking->status === 'confirmed' ? 'badge-confirmed' : ($booking->status === 'pending' ? 'badge-pending' : 'badge-active') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center; padding: 2rem; color: #aaa;">No bookings yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Services Tab -->
        <div id="tab-services" style="display: none;">
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Vendor</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allServices as $service)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $service->title }}</div>
                                </td>
                                <td style="color: #666;">{{ $service->vendor->user->name ?? '—' }}</td>
                                <td style="color: #888; text-transform: capitalize; font-size: 0.85rem;">{{ $service->category }}</td>
                                <td style="font-weight: 600;">{{ number_format($service->price) }} RWF</td>
                                <td>
                                    <span class="badge-sm {{ $service->status === 'active' ? 'badge-confirmed' : 'badge-pending' }}">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; padding: 2rem; color: #aaa;">No services listed</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
        <a href="{{ route('admin.verifications') }}" style="background: white; border: 1px solid #f0f0f0; border-radius: 14px; padding: 1.25rem; text-decoration: none; color: #222; display: flex; align-items: center; gap: 0.75rem; transition: all 0.2s;" onmouseover="this.style.borderColor='#9bf6af'" onmouseout="this.style.borderColor='#f0f0f0'">
            <span style="font-size: 1.5rem;">✅</span>
            <div>
                <div style="font-weight: 700; font-size: 0.9rem;">Verifications</div>
                <div style="font-size: 0.75rem; color: #888;">Review vendor requests</div>
            </div>
        </a>
        <a href="{{ route('bookings.admin-index') }}" style="background: white; border: 1px solid #f0f0f0; border-radius: 14px; padding: 1.25rem; text-decoration: none; color: #222; display: flex; align-items: center; gap: 0.75rem; transition: all 0.2s;" onmouseover="this.style.borderColor='#9bf6af'" onmouseout="this.style.borderColor='#f0f0f0'">
            <span style="font-size: 1.5rem;">📋</span>
            <div>
                <div style="font-weight: 700; font-size: 0.9rem;">All Bookings</div>
                <div style="font-size: 0.75rem; color: #888;">Manage every booking</div>
            </div>
        </a>
        <a href="{{ route('services.index') }}" style="background: white; border: 1px solid #f0f0f0; border-radius: 14px; padding: 1.25rem; text-decoration: none; color: #222; display: flex; align-items: center; gap: 0.75rem; transition: all 0.2s;" onmouseover="this.style.borderColor='#9bf6af'" onmouseout="this.style.borderColor='#f0f0f0'">
            <span style="font-size: 1.5rem;">🛍️</span>
            <div>
                <div style="font-weight: 700; font-size: 0.9rem;">Marketplace</div>
                <div style="font-size: 0.75rem; color: #888;">Browse all services</div>
            </div>
        </a>
        <a href="{{ route('vendors.index') }}" style="background: white; border: 1px solid #f0f0f0; border-radius: 14px; padding: 1.25rem; text-decoration: none; color: #222; display: flex; align-items: center; gap: 0.75rem; transition: all 0.2s;" onmouseover="this.style.borderColor='#9bf6af'" onmouseout="this.style.borderColor='#f0f0f0'">
            <span style="font-size: 1.5rem;">🏪</span>
            <div>
                <div style="font-weight: 700; font-size: 0.9rem;">Vendor Directory</div>
                <div style="font-size: 0.75rem; color: #888;">All registered vendors</div>
            </div>
        </a>
    </div>

</div>

<script>
// Charts
const bookingData = {
    pending: {{ $allBookings->where('status', 'pending')->count() }},
    confirmed: {{ $allBookings->where('status', 'confirmed')->count() }},
    completed: {{ $allBookings->where('status', 'completed')->count() }},
    cancelled: {{ $allBookings->where('status', 'cancelled')->count() }},
};

new Chart(document.getElementById('bookingChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
        datasets: [{
            data: [bookingData.pending, bookingData.confirmed, bookingData.completed, bookingData.cancelled],
            backgroundColor: ['#fbbf24', '#34d399', '#60a5fa', '#f87171'],
            borderWidth: 0,
            hoverOffset: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { padding: 12, font: { size: 12 } } } },
        cutout: '65%',
    }
});

const userData = {
    clients: {{ $stats['total_clients'] }},
    vendors: {{ $stats['total_vendors'] }},
    admins: {{ \App\Models\User::where('role', 'admin')->count() }},
};

new Chart(document.getElementById('userChart'), {
    type: 'doughnut',
    data: {
        labels: ['Couples', 'Vendors', 'Admins'],
        datasets: [{
            data: [userData.clients, userData.vendors, userData.admins],
            backgroundColor: ['#a78bfa', '#9bf6af', '#fbbf24'],
            borderWidth: 0,
            hoverOffset: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { padding: 12, font: { size: 12 } } } },
        cutout: '65%',
    }
});

// Tabs
function showTab(name, btn) {
    ['vendors', 'users', 'bookings', 'services'].forEach(t => {
        document.getElementById('tab-' + t).style.display = 'none';
    });
    document.querySelectorAll('.admin-tab').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).style.display = 'block';
    btn.classList.add('active');
}
</script>
@endsection
