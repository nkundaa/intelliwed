<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = Auth::user()->invitations()->withCount('guests')->latest()->get();
        return view('invitations.index', compact('invitations'));
    }

    public function create()
    {
        return view('invitations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'venue' => 'required|string|max:255',
            'message' => 'nullable|string',
            'theme' => 'required|in:classic,modern,traditional',
        ]);

        Auth::user()->invitations()->create($validated);

        return redirect()->route('invitations.index')->with('success', 'Invitation created successfully!');
    }

    public function show(Invitation $invitation)
    {
        if ($invitation->user_id !== Auth::id()) {
            abort(403);
        }

        $invitation->load('guests');
        return view('invitations.show', compact('invitation'));
    }

    public function destroy(Invitation $invitation)
    {
        if ($invitation->user_id !== Auth::id()) {
            abort(403);
        }

        $invitation->delete();
        return redirect()->route('invitations.index')->with('success', 'Invitation deleted.');
    }
}
