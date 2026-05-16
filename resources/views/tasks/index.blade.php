@extends('layouts.dashboard')

@section('title', 'Wedding Checklist')

@section('extra-head')
<style>
.progress-bar-wrap {
    background: #f0f0f0;
    border-radius: 99px;
    height: 10px;
    overflow: hidden;
    margin-top: 0.5rem;
}
.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #9bf6af, #4ade80);
    border-radius: 99px;
    transition: width 0.5s ease;
}
.task-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.2s;
    margin-bottom: 0.6rem;
}
.task-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
.task-card.completed { opacity: 0.6; }
.task-card.completed .task-title { text-decoration: line-through; color: #aaa; }
.task-checkbox {
    width: 22px; height: 22px;
    border-radius: 50%;
    border: 2px solid #ddd;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s;
}
.task-checkbox.done { background: #9bf6af; border-color: #4ade80; }
.task-checkbox.done::after { content: '✓'; font-size: 13px; color: #166534; font-weight: 700; }
.priority-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.priority-high { background: #ef4444; }
.priority-medium { background: #f59e0b; }
.priority-low { background: #6ee7b7; }
.cat-pill {
    font-size: 0.7rem;
    padding: 0.2rem 0.6rem;
    border-radius: 99px;
    font-weight: 600;
    text-transform: capitalize;
    background: #f0f0f0;
    color: #666;
}
.add-task-form {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #f0f0f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    margin-bottom: 2rem;
}
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}
.stat-mini {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    border: 1px solid #f0f0f0;
    text-align: center;
}
@media (max-width: 640px) {
    .stats-row { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endsection

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h2 style="font-size: 1.5rem; margin: 0;">Wedding Checklist</h2>
            <p style="color: #888; font-size: 0.9rem; margin-top: 0.25rem;">Stay on top of every detail</p>
        </div>
        <button onclick="toggleAddForm()" class="btn btn-primary" style="gap: 0.5rem;">
            + Add Task
        </button>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-mini">
            <div style="font-size: 2rem; font-weight: 700; color: #222;">{{ $stats['total'] }}</div>
            <div style="font-size: 0.8rem; color: #888;">Total Tasks</div>
        </div>
        <div class="stat-mini">
            <div style="font-size: 2rem; font-weight: 700; color: #4ade80;">{{ $stats['completed'] }}</div>
            <div style="font-size: 0.8rem; color: #888;">Completed</div>
        </div>
        <div class="stat-mini">
            <div style="font-size: 2rem; font-weight: 700; color: #f59e0b;">{{ $stats['pending'] }}</div>
            <div style="font-size: 0.8rem; color: #888;">Pending</div>
        </div>
        <div class="stat-mini">
            <div style="font-size: 2rem; font-weight: 700; color: #ef4444;">{{ $stats['overdue'] }}</div>
            <div style="font-size: 0.8rem; color: #888;">Overdue</div>
        </div>
    </div>

    <!-- Progress -->
    @if($stats['total'] > 0)
    <div style="background: white; border-radius: 12px; padding: 1.25rem; border: 1px solid #f0f0f0; margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #666; margin-bottom: 0.5rem;">
            <span>Overall Progress</span>
            <span>{{ round(($stats['completed'] / $stats['total']) * 100) }}%</span>
        </div>
        <div class="progress-bar-wrap">
            <div class="progress-bar-fill" style="width: {{ round(($stats['completed'] / $stats['total']) * 100) }}%"></div>
        </div>
    </div>
    @endif

    <!-- Add Task Form -->
    <div class="add-task-form" id="addTaskForm" style="{{ session('showAddForm') ? '' : 'display:none;' }}">
        <h3 style="margin-bottom: 1.25rem; font-size: 1rem;">Add New Task</h3>
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div style="grid-column: 1 / -1;">
                    <label class="label">Task Title *</label>
                    <input type="text" name="title" class="input" required placeholder="e.g. Book the photographer" value="{{ old('title') }}">
                </div>
                <div>
                    <label class="label">Category</label>
                    <select name="category" class="input">
                        @foreach(['venue' => '📍 Venue', 'catering' => '🍽️ Catering', 'attire' => '👗 Attire', 'photography' => '📷 Photography', 'decor' => '🌸 Decor', 'music' => '🎵 Music', 'invitations' => '✉️ Invitations', 'transport' => '🚗 Transport', 'ceremony' => '🪘 Ceremony', 'other' => '📝 Other'] as $v => $l)
                            <option value="{{ $v }}" {{ old('category') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label">Priority</label>
                    <select name="priority" class="input">
                        <option value="high">🔴 High</option>
                        <option value="medium" selected>🟡 Medium</option>
                        <option value="low">🟢 Low</option>
                    </select>
                </div>
                <div>
                    <label class="label">Due Date</label>
                    <input type="date" name="due_date" class="input" value="{{ old('due_date') }}">
                </div>
                <div>
                    <label class="label">Notes (optional)</label>
                    <input type="text" name="description" class="input" placeholder="Any extra details..." value="{{ old('description') }}">
                </div>
            </div>
            <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button type="button" onclick="toggleAddForm()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </div>
        </form>
    </div>

    @if($tasks->isEmpty())
        <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 16px; border: 1px dashed #ddd;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
            <h3 style="margin-bottom: 0.5rem;">No tasks yet</h3>
            <p style="color: #888; margin-bottom: 1.5rem;">Add your first task to get started, or we'll suggest tasks based on your wedding profile.</p>
            <button onclick="showAddForm()" class="btn btn-primary">Add Your First Task</button>
        </div>
    @else
        <!-- Tasks by category -->
        @foreach($grouped as $category => $categoryTasks)
            @php
                $icons = ['venue'=>'📍','catering'=>'🍽️','attire'=>'👗','photography'=>'📷','decor'=>'🌸','music'=>'🎵','invitations'=>'✉️','transport'=>'🚗','ceremony'=>'🪘','other'=>'📝'];
            @endphp
            <div style="margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                    <span style="font-size: 1.1rem;">{{ $icons[$category] ?? '📝' }}</span>
                    <h3 style="font-size: 0.95rem; text-transform: capitalize; color: #444; font-weight: 700;">{{ str_replace('-', ' ', ucfirst($category)) }}</h3>
                    <span style="font-size: 0.75rem; background: #f0f0f0; color: #666; padding: 0.15rem 0.5rem; border-radius: 99px;">{{ $categoryTasks->count() }}</span>
                </div>

                @foreach($categoryTasks as $task)
                    <div class="task-card {{ $task->status === 'completed' ? 'completed' : '' }}" id="task-{{ $task->id }}">
                        <!-- Checkbox -->
                        <div class="task-checkbox {{ $task->status === 'completed' ? 'done' : '' }}" onclick="toggleTask({{ $task->id }}, this)"></div>

                        <!-- Priority dot -->
                        <div class="priority-dot priority-{{ $task->priority }}"></div>

                        <!-- Content -->
                        <div style="flex: 1; min-width: 0;">
                            <div class="task-title" style="font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $task->title }}</div>
                            @if($task->description)
                                <div style="font-size: 0.8rem; color: #888; margin-top: 0.15rem;">{{ $task->description }}</div>
                            @endif
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.4rem; flex-wrap: wrap;">
                                @if($task->due_date)
                                    <span style="font-size: 0.75rem; color: {{ $task->isOverdue() ? '#ef4444' : '#888' }};">
                                        📅 {{ $task->due_date->format('M j, Y') }}{{ $task->isOverdue() ? ' · OVERDUE' : '' }}
                                    </span>
                                @endif
                                @if($task->is_ai_suggested)
                                    <span style="font-size: 0.7rem; background: #f0fff4; color: #166534; padding: 0.1rem 0.4rem; border-radius: 4px; border: 1px solid #bbf7d0;">AI</span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div style="display: flex; gap: 0.5rem; align-items: center; flex-shrink: 0;">
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Remove this task?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: none; border: none; cursor: pointer; color: #ccc; font-size: 1.1rem; padding: 0.25rem;" title="Delete">✕</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
</div>

<script>
function toggleAddForm() {
    const form = document.getElementById('addTaskForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
function showAddForm() {
    document.getElementById('addTaskForm').style.display = 'block';
}

async function toggleTask(taskId, el) {
    const card = document.getElementById('task-' + taskId);
    const response = await fetch(`/tasks/${taskId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'Accept': 'application/json',
        }
    });
    const data = await response.json();
    if (data.success) {
        if (data.status === 'completed') {
            el.classList.add('done');
            card.classList.add('completed');
        } else {
            el.classList.remove('done');
            card.classList.remove('completed');
        }
    }
}
</script>
@endsection
