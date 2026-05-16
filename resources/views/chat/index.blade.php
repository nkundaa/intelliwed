@extends('layouts.dashboard')

@section('title', 'Messages')

@section('extra-head')
<style>
.chat-layout {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 0;
    height: calc(100vh - 180px);
    min-height: 500px;
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f0f0;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}
.conversations-panel {
    border-right: 1px solid #f0f0f0;
    overflow-y: auto;
    background: #fafafa;
}
.conv-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    font-weight: 700;
    font-size: 0.95rem;
    background: white;
}
.conv-item {
    padding: 1rem 1.25rem;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.15s;
    display: flex;
    gap: 0.75rem;
    align-items: flex-start;
    text-decoration: none;
    color: inherit;
}
.conv-item:hover { background: white; }
.conv-item.active { background: white; border-left: 3px solid #222; }
.conv-avatar {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: #222;
    color: #9bf6af;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    flex-shrink: 0;
}
.conv-unread {
    background: #ef4444;
    color: white;
    border-radius: 99px;
    font-size: 0.7rem;
    padding: 0.1rem 0.4rem;
    font-weight: 700;
}
.messages-panel {
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.messages-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
}
.messages-body {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    background: #fafafa;
}
.message-bubble {
    max-width: 70%;
    padding: 0.75rem 1rem;
    border-radius: 16px;
    font-size: 0.9rem;
    line-height: 1.5;
}
.message-mine {
    background: #222;
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 4px;
}
.message-theirs {
    background: white;
    border: 1px solid #f0f0f0;
    align-self: flex-start;
    border-bottom-left-radius: 4px;
}
.message-time {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.5);
    margin-top: 0.25rem;
    text-align: right;
}
.message-theirs .message-time { color: #aaa; }
.messages-input {
    padding: 1rem 1.5rem;
    border-top: 1px solid #f0f0f0;
    background: white;
    display: flex;
    gap: 0.75rem;
    align-items: center;
}
.messages-input input {
    flex: 1;
    border: 1px solid #e5e5e5;
    border-radius: 24px;
    padding: 0.65rem 1.25rem;
    font-size: 0.9rem;
    outline: none;
    transition: border 0.2s;
}
.messages-input input:focus { border-color: #9bf6af; }
.send-btn {
    background: #222;
    color: #9bf6af;
    border: none;
    border-radius: 50%;
    width: 42px; height: 42px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    transition: background 0.2s;
}
.send-btn:hover { background: #000; }
.empty-state {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #aaa;
    gap: 0.75rem;
}
@media (max-width: 768px) {
    .chat-layout { grid-template-columns: 1fr; height: auto; }
    .conversations-panel { height: 200px; }
}
</style>
@endsection

@section('content')
<div style="max-width: 1100px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h2 style="font-size: 1.5rem; margin: 0;">Messages</h2>
            <p style="color: #888; font-size: 0.9rem; margin-top: 0.25rem;">Chat with {{ $user->isClient() ? 'vendors' : 'clients' }}</p>
        </div>
    </div>

    <div class="chat-layout">
        <!-- Conversations list -->
        <div class="conversations-panel">
            <div class="conv-header">💬 Conversations</div>

            @forelse($conversations as $conv)
                @php $other = $conv->otherParticipant($user->id); @endphp
                <a href="{{ route('chat.show', $conv) }}" class="conv-item {{ isset($activeConversation) && $activeConversation->id === $conv->id ? 'active' : '' }}">
                    <div class="conv-avatar">{{ strtoupper(substr($other->name, 0, 1)) }}</div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600; font-size: 0.9rem;">{{ $other->name }}</span>
                            @php $unread = $conv->unreadCountFor($user->id); @endphp
                            @if($unread > 0)
                                <span class="conv-unread">{{ $unread }}</span>
                            @endif
                        </div>
                        @if($conv->latestMessage)
                            <div style="font-size: 0.8rem; color: #888; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 0.15rem;">
                                {{ Str::limit($conv->latestMessage->body, 40) }}
                            </div>
                            <div style="font-size: 0.7rem; color: #bbb; margin-top: 0.15rem;">
                                {{ $conv->latestMessage->created_at->diffForHumans() }}
                            </div>
                        @else
                            <div style="font-size: 0.8rem; color: #bbb; margin-top: 0.15rem; font-style: italic;">No messages yet</div>
                        @endif
                    </div>
                </a>
            @empty
                <div style="padding: 2rem; text-align: center; color: #aaa;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">💬</div>
                    <p style="font-size: 0.85rem;">No conversations yet.</p>
                    @if($user->isClient())
                        <a href="{{ route('vendors.index') }}" style="font-size: 0.85rem; color: #222; text-decoration: underline;">Find vendors</a>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Messages area -->
        <div class="messages-panel">
            @if(isset($activeConversation))
                @php $other = $activeConversation->otherParticipant($user->id); @endphp
                <!-- Header -->
                <div class="messages-header">
                    <div class="conv-avatar">{{ strtoupper(substr($other->name, 0, 1)) }}</div>
                    <div>
                        <div style="font-weight: 700; font-size: 0.95rem;">{{ $other->name }}</div>
                        <div style="font-size: 0.75rem; color: #888;">{{ ucfirst($other->role) }}</div>
                    </div>
                </div>

                <!-- Messages -->
                <div class="messages-body" id="messagesBody">
                    @forelse($messages as $message)
                        @php $mine = $message->sender_id === $user->id; @endphp
                        <div style="display: flex; flex-direction: column; align-items: {{ $mine ? 'flex-end' : 'flex-start' }};">
                            <div class="message-bubble {{ $mine ? 'message-mine' : 'message-theirs' }}">
                                {{ $message->body }}
                                <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <div style="flex: 1; display: flex; align-items: center; justify-content: center; color: #bbb; font-size: 0.9rem; font-style: italic;">
                            Send a message to start the conversation
                        </div>
                    @endforelse
                </div>

                <!-- Input -->
                <div class="messages-input">
                    <input type="text" id="messageInput" placeholder="Type a message..." onkeypress="if(event.key==='Enter')sendMessage()">
                    <button class="send-btn" onclick="sendMessage()">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </div>

            @else
                <div class="empty-state">
                    <div style="font-size: 3rem;">💬</div>
                    <div style="font-size: 1rem; font-weight: 600; color: #555;">Select a conversation</div>
                    <div style="font-size: 0.85rem; color: #aaa;">Choose from the left to start chatting</div>
                    @if($user->isClient())
                        <a href="{{ route('vendors.index') }}" class="btn btn-primary" style="margin-top: 0.5rem;">Find Vendors</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@if(isset($activeConversation))
<script>
const convId = {{ $activeConversation->id }};
let lastId = {{ $messages->last()?->id ?? 0 }};
const currentUserId = {{ $user->id }};
const messagesBody = document.getElementById('messagesBody');

function scrollToBottom() {
    messagesBody.scrollTop = messagesBody.scrollHeight;
}
scrollToBottom();

async function sendMessage() {
    const input = document.getElementById('messageInput');
    const body = input.value.trim();
    if (!body) return;
    input.value = '';

    const response = await fetch(`/chat/${convId}/send`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ body })
    });

    const msg = await response.json();
    appendMessage(msg);
    lastId = msg.id;
    scrollToBottom();
}

function appendMessage(msg) {
    const div = document.createElement('div');
    div.style.cssText = `display:flex;flex-direction:column;align-items:${msg.mine ? 'flex-end' : 'flex-start'}`;
    div.innerHTML = `
        <div class="message-bubble ${msg.mine ? 'message-mine' : 'message-theirs'}">
            ${escapeHtml(msg.body)}
            <div class="message-time">${msg.created_at}</div>
        </div>`;
    messagesBody.appendChild(div);
}

function escapeHtml(text) {
    return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// Poll for new messages every 3 seconds
setInterval(async () => {
    const response = await fetch(`/chat/${convId}/poll/${lastId}`, {
        headers: { 'Accept': 'application/json' }
    });
    const msgs = await response.json();
    if (msgs.length) {
        msgs.forEach(msg => {
            appendMessage(msg);
            lastId = msg.id;
        });
        scrollToBottom();
    }
}, 3000);
</script>
@endif
@endsection
