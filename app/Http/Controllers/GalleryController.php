<?php

namespace App\Http\Controllers;

use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $photos = $user->galleryPhotos()->orderBy('album')->orderBy('sort_order')->get();
        $albums = $photos->groupBy('album');
        return view('gallery.index', compact('photos', 'albums', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photos'    => 'required|array|max:20',
            'photos.*'  => 'image|max:10240',
            'album'     => 'nullable|string|max:100',
            'is_public' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $album = $request->album ?: 'general';
        $isPublic = $request->boolean('is_public');
        $maxOrder = $user->galleryPhotos()->max('sort_order') ?? 0;

        $uploaded = [];
        foreach ($request->file('photos') as $i => $file) {
            $path = $file->store('gallery/' . $user->id, 'public');
            $uploaded[] = GalleryPhoto::create([
                'user_id'    => $user->id,
                'path'       => $path,
                'album'      => $album,
                'is_public'  => $isPublic,
                'sort_order' => $maxOrder + $i + 1,
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'count' => count($uploaded)]);
        }

        return redirect()->route('gallery.index')->with('status', count($uploaded) . ' photo(s) uploaded!');
    }

    public function update(Request $request, GalleryPhoto $photo)
    {
        abort_unless($photo->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'caption'   => 'nullable|string|max:255',
            'album'     => 'nullable|string|max:100',
            'is_public' => 'nullable|boolean',
        ]);
        $validated['is_public'] = $request->boolean('is_public');
        $photo->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy(GalleryPhoto $photo)
    {
        abort_unless($photo->user_id === Auth::id() || Auth::user()->isAdmin(), 403);
        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('status', 'Photo deleted.');
    }
}
