@extends('layouts.front')

@section('title', $service->title . ' | IntelliWed')

@section('content')
<div class="container" style="padding: 4rem 2rem;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; align-items: start;">
        <!-- Left: Service Details -->
        <div>
            <div class="card" style="padding: 0; overflow: hidden; margin-bottom: 2rem;">
                <div style="height: 500px; position: relative;">
                    @if($service->main_image)
                        <img src="{{ asset('storage/' . $service->main_image) }}" alt="{{ $service->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: var(--light-neutral); display: flex; align-items: center; justify-content: center; color: #ccc;">
                            <svg style="width: 80px; height: 80px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div style="position: absolute; top: 1.5rem; left: 1.5rem; display: flex; gap: 0.5rem;">
                        <span class="badge" style="background: var(--dark-neutral); color: var(--primary-beige); padding: 0.5rem 1rem;">{{ ucfirst($service->category) }}</span>
                    </div>
                </div>

                <div style="padding: 2.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h1 style="font-size: 2.5rem; color: var(--dark-neutral); margin: 0;">{{ $service->title }}</h1>
                        <div style="font-size: 2rem; font-weight: 700; color: var(--accent);">${{ number_format($service->price, 2) }}</div>
                    </div>

                    <div style="display: flex; gap: 2rem; color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.5rem;">
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $service->vendor_name }}
                        </span>
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ $service->location }}
                        </span>
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $service->visits_count ?? 0 }} Views
                        </span>
                    </div>

                    <div style="margin-bottom: 3rem;">
                        <h3 style="font-size: 1.25rem; margin-bottom: 1.5rem; color: var(--dark-neutral);">About this service</h3>
                        <p style="color: var(--text-muted); line-height: 1.8; font-size: 1.1rem; white-space: pre-line;">{{ $service->description }}</p>
                    </div>

                    @if($service->image2 || $service->image3)
                        <h3 style="font-size: 1.25rem; margin-bottom: 1.5rem; color: var(--dark-neutral);">Service Gallery</h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            @if($service->image2)
                                <div class="card" style="padding: 0; height: 300px; overflow: hidden;">
                                    <img src="{{ asset('storage/' . $service->image2) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @endif
                            @if($service->image3)
                                <div class="card" style="padding: 0; height: 300px; overflow: hidden;">
                                    <img src="{{ asset('storage/' . $service->image3) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Booking Widget -->
        <aside style="position: sticky; top: 6rem;">
            @auth
                @if(auth()->user()->isClient())
                    <div class="card" style="padding: 2.5rem; background: var(--soft-beige); border: 1px solid var(--dark-beige);">
                        <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem; text-align: center;">Book this Service</h3>
                        <form method="POST" action="{{ route('bookings.store', $service->id) }}">
                            @csrf
                            <div class="form-group">
                                <label class="label">Wedding Date</label>
                                <input type="date" name="booking_date" class="input" required>
                            </div>
                            <div class="form-group">
                                <label class="label">Notes for Vendor</label>
                                <textarea name="notes" rows="4" class="input" placeholder="Share your vision or requests..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; margin-top: 1rem;">Request Booking</button>
                        </form>
                    </div>
                @else
                    <div class="card" style="padding: 2rem; text-align: center; background: var(--white); border: 1px dashed var(--border-color);">
                        <p style="color: var(--text-muted); font-size: 0.9rem;">You are currently logged in as a <strong>{{ auth()->user()->role }}</strong>. Please switch to a couple account to book services.</p>
                    </div>
                @endif
            @else
                <div class="card" style="padding: 2.5rem; text-align: center; background: var(--dark-neutral); color: var(--white);">
                    <h3 style="color: var(--primary-beige); margin-bottom: 1rem;">Interested in this service?</h3>
                    <p style="color: #ccc; margin-bottom: 2rem; font-size: 0.95rem;">Sign in to check availability and book your wedding vendor.</p>
                    <a href="{{ route('login') }}" class="btn btn-secondary" style="width: 100%; padding: 1rem;">Sign in to Book</a>
                </div>
            @endauth

            <!-- Chat with Vendor -->
            @auth
                @if(auth()->user()->isClient() && $service->vendor)
                    <div class="card" style="margin-top: 1.5rem; padding: 1.5rem; text-align: center; border: 1px solid #f0f0f0;">
                        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">💬</div>
                        <h4 style="margin-bottom: 0.5rem; font-size: 0.95rem;">Have questions?</h4>
                        <p style="font-size: 0.85rem; color: #888; margin-bottom: 1rem;">Chat directly with the vendor before booking.</p>
                        <a href="{{ route('chat.start', $service->vendor->user_id) }}" class="btn btn-outline" style="width: 100%; font-size: 0.9rem;">Chat with Vendor</a>
                    </div>
                @endif
            @endauth
        </aside>
    </div>

    <!-- Reviews Section -->
    <div style="margin-top: 3rem; padding-bottom: 3rem;">
        <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem;">Reviews & Ratings</h2>

        @php
            $reviews = $service->reviews()->with('user')->latest()->get();
            $avgRating = $reviews->avg('rating') ?? 0;
        @endphp

        @if($reviews->count() > 0)
            <!-- Rating Summary -->
            <div style="background: white; border-radius: 16px; padding: 2rem; border: 1px solid #f0f0f0; margin-bottom: 2rem; display: flex; align-items: center; gap: 3rem; flex-wrap: wrap;">
                <div style="text-align: center;">
                    <div style="font-size: 3.5rem; font-weight: 700; color: #222; line-height: 1;">{{ number_format($avgRating, 1) }}</div>
                    <div style="font-size: 1.25rem; color: #fbbf24; margin: 0.25rem 0;">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= round($avgRating) ? '★' : '☆' }}
                        @endfor
                    </div>
                    <div style="font-size: 0.8rem; color: #888;">{{ $reviews->count() }} review{{ $reviews->count() !== 1 ? 's' : '' }}</div>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    @for($star = 5; $star >= 1; $star--)
                        @php $count = $reviews->where('rating', $star)->count(); @endphp
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.4rem;">
                            <span style="font-size: 0.8rem; color: #888; min-width: 40px;">{{ $star }}★</span>
                            <div style="flex: 1; background: #f0f0f0; border-radius: 99px; height: 8px; overflow: hidden;">
                                <div style="height: 100%; background: #fbbf24; border-radius: 99px; width: {{ $reviews->count() > 0 ? round(($count / $reviews->count()) * 100) : 0 }}%;"></div>
                            </div>
                            <span style="font-size: 0.8rem; color: #888; min-width: 20px;">{{ $count }}</span>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Individual Reviews -->
            <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2rem;">
                @foreach($reviews as $review)
                    <div style="background: white; border-radius: 14px; padding: 1.5rem; border: 1px solid #f0f0f0;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem; flex-wrap: wrap; gap: 0.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: #222; color: #9bf6af; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                                <div>
                                    <div style="font-weight: 700; font-size: 0.9rem;">{{ $review->user->name }}</div>
                                    <div style="font-size: 0.75rem; color: #aaa;">{{ $review->created_at->format('M j, Y') }}</div>
                                </div>
                            </div>
                            <div style="color: #fbbf24; font-size: 1rem;">
                                @for($i = 1; $i <= 5; $i++){{ $i <= $review->rating ? '★' : '☆' }}@endfor
                                @if($review->is_verified) <span style="font-size: 0.7rem; background: #dcfce7; color: #166534; padding: 0.15rem 0.4rem; border-radius: 4px; margin-left: 0.4rem;">✓ Verified</span> @endif
                            </div>
                        </div>
                        @if($review->title)
                            <div style="font-weight: 700; margin-bottom: 0.4rem; font-size: 0.95rem;">{{ $review->title }}</div>
                        @endif
                        <p style="color: #555; font-size: 0.9rem; line-height: 1.6; margin: 0;">{{ $review->body }}</p>
                        @auth
                            @if(auth()->id() === $review->user_id)
                                <form method="POST" action="{{ route('reviews.destroy', $review) }}" style="margin-top: 0.75rem;" onsubmit="return confirm('Delete your review?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="font-size: 0.75rem; color: #aaa; background: none; border: none; cursor: pointer; padding: 0;">Delete review</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                @endforeach
            </div>
        @else
            <div style="background: white; border-radius: 14px; padding: 3rem; border: 1px dashed #ddd; text-align: center; margin-bottom: 2rem;">
                <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">⭐</div>
                <p style="color: #888;">No reviews yet. Be the first to review!</p>
            </div>
        @endif

        <!-- Write a Review -->
        @auth
            @if(auth()->user()->isClient())
                @php $userReview = $reviews->where('user_id', auth()->id())->first(); @endphp
                <div style="background: white; border-radius: 16px; padding: 2rem; border: 1px solid #f0f0f0;">
                    <h3 style="margin-bottom: 1.25rem; font-size: 1.1rem;">{{ $userReview ? 'Update Your Review' : 'Write a Review' }}</h3>
                    <form method="POST" action="{{ route('reviews.store', $service) }}">
                        @csrf
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.5rem;">Rating *</label>
                            <div style="display: flex; gap: 0.5rem;" id="starRating">
                                @for($i = 1; $i <= 5; $i++)
                                    <label style="cursor: pointer; font-size: 1.75rem; color: #ddd; transition: color 0.1s;" id="star-{{ $i }}">
                                        <input type="radio" name="rating" value="{{ $i }}" style="display: none;" {{ ($userReview && $userReview->rating == $i) ? 'checked' : '' }}>★
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label class="label">Title (optional)</label>
                            <input type="text" name="title" class="input" placeholder="Summarize your experience" value="{{ $userReview->title ?? old('title') }}">
                        </div>
                        <div style="margin-bottom: 1.5rem;">
                            <label class="label">Your Review *</label>
                            <textarea name="body" class="input" rows="4" required placeholder="Tell others what you think about this service...">{{ $userReview->body ?? old('body') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ $userReview ? 'Update Review' : 'Submit Review' }}</button>
                    </form>
                </div>
            @endif
        @else
            <div style="background: #fafaf8; border-radius: 14px; padding: 1.5rem; border: 1px dashed #ddd; text-align: center;">
                <a href="{{ route('login') }}" style="color: #222; font-weight: 600;">Sign in</a> to leave a review.
            </div>
        @endauth
    </div>
</div>

<script>
// Star rating interaction
document.querySelectorAll('#starRating label').forEach((star, index) => {
    star.addEventListener('mouseover', () => {
        document.querySelectorAll('#starRating label').forEach((s, i) => {
            s.style.color = i <= index ? '#fbbf24' : '#ddd';
        });
    });
    star.addEventListener('click', () => {
        star.querySelector('input').checked = true;
        document.querySelectorAll('#starRating label').forEach((s, i) => {
            s.style.color = i <= index ? '#fbbf24' : '#ddd';
        });
    });
});
document.getElementById('starRating').addEventListener('mouseleave', () => {
    const checked = document.querySelector('#starRating input:checked');
    const checkedIndex = checked ? parseInt(checked.value) - 1 : -1;
    document.querySelectorAll('#starRating label').forEach((s, i) => {
        s.style.color = i <= checkedIndex ? '#fbbf24' : '#ddd';
    });
});
// Init checked state
const checkedStar = document.querySelector('#starRating input:checked');
if (checkedStar) {
    const idx = parseInt(checkedStar.value) - 1;
    document.querySelectorAll('#starRating label').forEach((s, i) => {
        s.style.color = i <= idx ? '#fbbf24' : '#ddd';
    });
}
</script>
@endsection
