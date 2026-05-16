<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Invitation: {{ $invitation->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;600&family=Alex+Brush&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: {{ $invitation->theme == 'traditional' ? '#800000' : ($invitation->theme == 'modern' ? '#1a1a1a' : '#d4af37') }};
            --accent: {{ $invitation->theme == 'traditional' ? '#ffd700' : ($invitation->theme == 'modern' ? '#00cfc1' : '#f4e4bc') }};
            --bg: {{ $invitation->theme == 'modern' ? '#ffffff' : '#fafaf5' }};
            --text: #333333;
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg); color: var(--text); line-height: 1.6; }
        
        .invitation-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
            border: 8px solid white;
            outline: 1px solid var(--primary);
        }

        .header {
            padding: 60px 40px;
            text-align: center;
            background: var(--bg);
            border-bottom: 1px solid var(--accent);
        }

        .cursive { font-family: 'Alex+Brush', cursive; font-size: 4rem; color: var(--primary); margin-bottom: 20px; }
        .playfair { font-family: 'Playfair Display', serif; font-size: 1.5rem; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 20px; }
        
        .details { padding: 40px; text-align: center; }
        .details h2 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 20px; }
        .details p { margin-bottom: 10px; font-size: 1.1rem; }
        
        .rsvp-form { padding: 40px; background: #fdfdfd; border-top: 1px solid #eee; }
        .rsvp-form h3 { font-family: 'Playfair Display', serif; margin-bottom: 20px; text-align: center; }
        
        .form-group { margin-bottom: 20px; }
        .label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem; }
        .input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-family: inherit; }
        
        .btn { 
            display: block; width: 100%; padding: 15px; background: var(--primary); color: white; 
            border: none; border-radius: 6px; font-size: 1.1rem; font-weight: 600; cursor: pointer;
            transition: opacity 0.3s;
        }
        .btn:hover { opacity: 0.9; }

        .status-options { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 20px; }
        .status-option { 
            text-align: center; padding: 10px; border: 1px solid #ddd; border-radius: 6px; cursor: pointer;
            font-size: 0.9rem; transition: all 0.3s;
        }
        .status-option:hover { border-color: var(--primary); }
        input[type="radio"]:checked + .status-option { background: var(--primary); color: white; border-color: var(--primary); }

        @media (max-width: 600px) {
            .invitation-container { margin: 0; border-radius: 0; border: none; }
            .cursive { font-size: 3rem; }
        }
    </style>
</head>
<body>
    <div class="invitation-container">
        <div class="header">
            <div class="cursive">Save the Date</div>
            <div class="playfair">{{ $invitation->title }}</div>
            <div style="height: 2px; width: 60px; background: var(--primary); margin: 0 auto;"></div>
        </div>

        <div class="details">
            <h2>{{ $invitation->event_date->format('F d, Y') }}</h2>
            <p style="font-weight: 600;">{{ $invitation->venue }}</p>
            <p style="margin-top: 20px; font-style: italic; color: #666;">
                "{{ $invitation->message }}"
            </p>
        </div>

        <div class="rsvp-form">
            <h3>Kindly Respond by {{ $invitation->event_date->subWeeks(2)->format('F d') }}</h3>
            <form action="{{ route('rsvp.submit', $invitation->token) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="label">Your Name</label>
                    <input type="text" name="name" class="input" placeholder="Full Name" required>
                </div>
                
                <div class="form-group">
                    <label class="label">Email Address</label>
                    <input type="email" name="email" class="input" placeholder="email@example.com">
                </div>

                <div class="label">Will you be attending?</div>
                <div class="status-options">
                    <label>
                        <input type="radio" name="status" value="yes" checked style="display: none;">
                        <div class="status-option">Yes, I'll be there!</div>
                    </label>
                    <label>
                        <input type="radio" name="status" value="maybe" style="display: none;">
                        <div class="status-option">Maybe</div>
                    </label>
                    <label>
                        <input type="radio" name="status" value="no" style="display: none;">
                        <div class="status-option">Regretfully, no</div>
                    </label>
                </div>

                <div class="form-group">
                    <label class="label">Meal Preference / Allergies</label>
                    <input type="text" name="meal_pref" class="input" placeholder="Vegetarian, Nut Allergy, etc.">
                </div>

                <div class="form-group">
                    <label class="label">Message for the Couple</label>
                    <textarea name="note" class="input" rows="3" placeholder="Leave a note..."></textarea>
                </div>

                <button type="submit" class="btn">Send Response</button>
            </form>
        </div>
    </div>

    <div style="text-align: center; padding: 20px; font-size: 0.8rem; color: #999;">
        Powered by <a href="{{ url('/') }}" style="color: inherit; font-weight: 600;">IntelliWed</a>
    </div>
</body>
</html>
