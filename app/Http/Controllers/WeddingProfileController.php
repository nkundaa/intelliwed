<?php

namespace App\Http\Controllers;

use App\Models\WeddingProfile;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WeddingProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->weddingProfile;
        return view('wedding.profile', compact('user', 'profile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'partner_name'       => 'required|string|max:255',
            'wedding_date'       => 'nullable|date|after:today',
            'venue'              => 'nullable|string|max:255',
            'venue_location'     => 'nullable|string|max:255',
            'theme'              => 'nullable|in:luxury,traditional,modern,minimalist,garden,royal,afro-fusion',
            'ceremony_type'      => 'nullable|in:gusaba,gukwa,traditional,civil,modern,reception,mixed',
            'total_budget'       => 'nullable|numeric|min:0',
            'guest_count_estimate' => 'nullable|integer|min:1',
            'love_story'         => 'nullable|string|max:2000',
            'website_enabled'    => 'nullable|boolean',
            'website_theme'      => 'nullable|string|max:50',
            'primary_color'      => 'nullable|string|max:20',
            'special_notes'      => 'nullable|string|max:1000',
            'cover_image'        => 'nullable|image|max:5120',
        ]);

        $user = Auth::user();

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('wedding-covers', 'public');
        }

        $validated['website_enabled'] = $request->boolean('website_enabled');

        $profile = $user->weddingProfile;

        if ($profile) {
            if ($profile->cover_image && isset($validated['cover_image'])) {
                Storage::disk('public')->delete($profile->cover_image);
            }
            $profile->update($validated);
        } else {
            $validated['user_id'] = $user->id;
            $profile = WeddingProfile::create($validated);

            // Seed default tasks for new profiles
            if ($user->tasks()->count() === 0) {
                Task::defaultTasksFor($user->id);
            }
        }

        return redirect()->route('wedding.profile')->with('status', 'Wedding profile saved successfully!');
    }

    public function publicSite(string $slug)
    {
        $profile = WeddingProfile::where('slug', $slug)
            ->where('website_enabled', true)
            ->firstOrFail();

        $couple = $profile->user;
        $photos = $couple->galleryPhotos()->where('is_public', true)->latest()->take(12)->get();

        return view('wedding.public-site', compact('profile', 'couple', 'photos'));
    }

    public function generateSlug(Request $request)
    {
        $user = Auth::user();
        $profile = $user->weddingProfile;

        if (!$profile) {
            return response()->json(['error' => 'No profile found'], 404);
        }

        if (!$profile->slug) {
            $base = Str::slug($user->name . '-' . now()->year);
            $slug = $base;
            $i = 1;
            while (WeddingProfile::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $profile->update(['slug' => $slug]);
        }

        return response()->json([
            'slug' => $profile->slug,
            'url' => route('wedding.site', $profile->slug),
        ]);
    }
}
