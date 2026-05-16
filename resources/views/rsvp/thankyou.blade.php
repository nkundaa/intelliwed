<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You! - {{ $invitation->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400&family=Alex+Brush&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #fafaf5; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 20px; }
        .card { max-width: 500px; background: white; padding: 60px 40px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); text-align: center; }
        .cursive { font-family: 'Alex+Brush', cursive; font-size: 4rem; color: #d4af37; margin-bottom: 20px; }
        h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 20px; }
        p { color: #666; margin-bottom: 30px; }
        .btn { display: inline-block; padding: 12px 30px; background: #1a1a1a; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <div class="cursive">Thank You</div>
        <h1>Response Received!</h1>
        <p>Your RSVP for <strong>{{ $invitation->title }}</strong> has been successfully submitted. The couple has been notified.</p>
        <div style="font-size: 0.9rem; margin-bottom: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px;">
            <div style="font-weight: 600;">Save the Date</div>
            <div>{{ $invitation->event_date->format('F d, Y') }}</div>
            <div style="color: #888;">{{ $invitation->venue }}</div>
        </div>
        <a href="{{ url('/') }}" class="btn">Explore IntelliWed</a>
    </div>
</body>
</html>
