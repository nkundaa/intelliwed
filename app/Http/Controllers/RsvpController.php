<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Guest;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function show($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        return view('rsvp.show', compact('invitation'));
    }

    public function submit(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'status' => 'required|in:yes,maybe,no',
            'meal_pref' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        Guest::create(array_merge($validated, [
            'invitation_id' => $invitation->id,
            'responded_at' => now(),
        ]));

        return view('rsvp.thankyou', compact('invitation'));
    }
}
