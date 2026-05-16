<!DOCTYPE html>
<html>
<head>
    <title>IntelliWed - Wedding Platform Rwanda</title>
    <style>
        body {
            font-family: Arial;
            margin: 0;
            background: #84acd4;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            padding: 15px 30px;
            background: black;
            color: white;
        }

        .hero {
            text-align: center;
            padding: 80px 20px;
            background: linear-gradient(120deg, #000, #444);
            color: white;
        }

        .btn {
            padding: 10px 15px;
            background: white;
            color: black;
            text-decoration: none;
            border-radius: 5px;
        }

        .section {
            padding: 40px;
            text-align: center;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(29, 28, 28, 0.1);
        }
    </style>
</head>

<body>

<div class="navbar">
    <h2>IntelliWed</h2>
    <div>
        <a href="/vendors" class="btn">Browse Vendors</a>
    </div>
</div>

<div class="hero">
    <h1>Plan Your Perfect Wedding in Rwanda</h1>
    <p>Find photographers, decorators, caterers and more</p>
    <a href="/vendors" class="btn">Get Started</a>
</div>

<div class="section">
    <h2>Why Choose IntelliWed?</h2>

    <div class="grid">
        <div class="card">
            <h3>Trusted Vendors</h3>
            <p>Verified professionals for your wedding</p>
        </div>

        <div class="card">
            <h3>Easy Booking</h3>
            <p>Book services instantly in one click</p>
        </div>

        <div class="card">
            <h3>Secure Platform</h3>
            <p>Safe and reliable system for all users</p>
        </div>
    </div>
</div>

</body>
</html>