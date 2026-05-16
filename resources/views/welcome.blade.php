@extends('layouts.front')

@section('title', 'Welcome to IntelliWed')

@section('content')
<style>
    @media (max-width: 768px) {
        .welcome-card {
            padding: 1.5rem !important;
            margin: 1rem !important;
        }
        
        .welcome-title {
            font-size: 1.75rem !important;
        }
        
        .welcome-buttons {
            flex-direction: column !important;
            gap: 1rem !important;
        }
        
        .welcome-buttons a {
            width: 100% !important;
            text-align: center !important;
        }
    }
</style>

<section class="section" style="padding: 4rem 1rem;">
    <div class="container">
        <div class="card p-6 text-center welcome-card" style="padding: 3rem; max-width: 800px; margin: 0 auto;">
            <h1 class="welcome-title" style="font-size: 2.5rem; margin-bottom: 1rem;">Welcome to IntelliWed</h1>
            <p style="font-size: 1.1rem; margin-bottom: 2rem;">A modern wedding planning platform with elegant, consistent, and professional experience.</p>
            <div class="flex justify-center gap-4 mt-4 welcome-buttons" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('services.index') }}" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">Browse Services</a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">Create Account</a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">Go to Dashboard</a>
                @endguest
            </div>
        </div>
    </div>
</section>
@endsection