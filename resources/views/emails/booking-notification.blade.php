<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f5f5f5; padding: 2rem; }
        .email-card { background-color: #ffffff; padding: 2rem; border-radius: 12px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { border-bottom: 2px solid #f5f5dc; padding-bottom: 1rem; margin-bottom: 1.5rem; }
        .header h1 { font-size: 1.5rem; color: #222; margin: 0; }
        .detail-row { margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem; }
        .label { font-weight: 700; color: #666; font-size: 0.8rem; text-transform: uppercase; }
        .value { color: #222; font-size: 1rem; margin-top: 0.2rem; }
        .footer { margin-top: 2rem; font-size: 0.8rem; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="email-card">
        <div class="header">
            <h1>New Booking Request</h1>
            <p style="color: #666;">A new wedding service booking has been placed on IntelliWed.</p>
        </div>

        <div class="detail-row">
            <div class="label">Service</div>
            <div class="value">{{ $booking->service->title }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Client Name</div>
            <div class="value">{{ $booking->user->name }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Client Email</div>
            <div class="value">{{ $booking->user->email }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Wedding Date</div>
            <div class="value">{{ $booking->booking_date->format('F d, Y') }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Total Price</div>
            <div class="value">${{ number_format($booking->service->price, 2) }}</div>
        </div>

        @if($booking->notes)
        <div class="detail-row">
            <div class="label">Client Notes</div>
            <div class="value">"{{ $booking->notes }}"</div>
        </div>
        @endif

        <div style="margin-top: 2rem;">
            <a href="{{ url('/login') }}" style="background-color: #222; color: #fff; padding: 0.8rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;">View Booking in Dashboard</a>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} IntelliWed Platform. Kicukiro, Niboye.</p>
        </div>
    </div>
</body>
</html>
