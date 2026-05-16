<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isClient()) {
            $conversations = Conversation::where('client_id', $user->id)
                ->with(['vendor', 'latestMessage'])
                ->orderByDesc('last_message_at')
                ->get();
        } else {
            $conversations = Conversation::where('vendor_id', $user->id)
                ->with(['client', 'latestMessage'])
                ->orderByDesc('last_message_at')
                ->get();
        }

        $activeConversation = $conversations->first();
        $messages = $activeConversation
            ? $activeConversation->messages()->with('sender')->orderBy('created_at')->get()
            : collect();

        if ($activeConversation) {
            $activeConversation->messages()
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return view('chat.index', compact('conversations', 'activeConversation', 'messages', 'user'));
    }

    public function show(Conversation $conversation)
    {
        $user = Auth::user();
        abort_unless(
            $conversation->client_id === $user->id || $conversation->vendor_id === $user->id,
            403
        );

        $conversations = Conversation::where('client_id', $user->id)
            ->orWhere('vendor_id', $user->id)
            ->with(['client', 'vendor', 'latestMessage'])
            ->orderByDesc('last_message_at')
            ->get();

        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get();

        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.index', compact('conversations', 'conversation', 'messages', 'user'))
            ->with('activeConversation', $conversation);
    }

    public function startOrOpen(User $vendor)
    {
        $user = Auth::user();
        abort_unless($user->isClient(), 403, 'Only clients can start conversations.');

        $conversation = Conversation::firstOrCreate(
            ['client_id' => $user->id, 'vendor_id' => $vendor->id],
            ['last_message_at' => now()]
        );

        return redirect()->route('chat.show', $conversation);
    }

    public function send(Request $request, Conversation $conversation)
    {
        $user = Auth::user();
        abort_unless(
            $conversation->client_id === $user->id || $conversation->vendor_id === $user->id,
            403
        );

        $request->validate(['body' => 'required|string|max:2000']);

        $message = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $user->id,
            'body'            => $request->body,
        ]);

        $conversation->update(['last_message_at' => now()]);

        if ($request->wantsJson()) {
            return response()->json([
                'id'         => $message->id,
                'body'       => $message->body,
                'sender'     => $user->name,
                'created_at' => $message->created_at->format('H:i'),
                'mine'       => true,
            ]);
        }

        return redirect()->route('chat.show', $conversation);
    }

    public function poll(Conversation $conversation, int $lastId = 0)
    {
        $user = Auth::user();
        abort_unless(
            $conversation->client_id === $user->id || $conversation->vendor_id === $user->id,
            403
        );

        $messages = $conversation->messages()
            ->with('sender')
            ->where('id', '>', $lastId)
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'body'       => $m->body,
                'sender'     => $m->sender->name,
                'created_at' => $m->created_at->format('H:i'),
                'mine'       => $m->sender_id === $user->id,
            ]);

        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }
}
