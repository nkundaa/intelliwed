<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Service $service)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title'  => 'nullable|string|max:255',
            'body'   => 'required|string|min:10|max:2000',
        ]);

        // One review per user per service
        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'service_id' => $service->id],
            $validated
        );

        return redirect()->route('services.show', $service)->with('status', 'Review submitted. Thank you!');
    }

    public function destroy(Review $review)
    {
        abort_unless($review->user_id === Auth::id() || Auth::user()->isAdmin(), 403);
        $review->delete();

        return back()->with('status', 'Review removed.');
    }
}
