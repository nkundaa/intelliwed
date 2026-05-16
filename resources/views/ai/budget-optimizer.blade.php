@extends('layouts.dashboard')

@section('title', 'AI Wedding Budget Optimizer')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;" x-data="budgetOptimizer()">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Smart Budget Optimizer</h2>
        <p style="color: var(--text-muted); font-size: 1.1rem;">Plan your dream wedding with intelligence. Our AI distributes your budget based on your unique priorities.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 2rem;">
        <!-- Input Panel -->
        <div>
            <div class="card">
                <h3 style="margin-bottom: 1.5rem;">Input Your Details</h3>
                <form @submit.prevent="optimize">
                    <div class="form-group">
                        <label class="label">Total Wedding Budget (RWF)</label>
                        <input type="number" x-model="formData.total_budget" class="input" placeholder="e.g. 5000000" min="100000" required>
                    </div>

                    <h4 style="margin: 1.5rem 0 1rem;">Set Your Priorities</h4>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <template x-for="cat in categories" :key="cat">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #f9f9f9; border-radius: 8px;">
                                <span style="font-size: 0.9rem; font-weight: 600;" x-text="cat"></span>
                                <select x-model="formData.priorities[cat]" style="padding: 0.4rem; border: 1px solid var(--border-color); border-radius: 4px; font-size: 0.8rem;">
                                    <option value="normal">Normal</option>
                                    <option value="high">High Priority</option>
                                    <option value="low">Low Priority</option>
                                </select>
                            </div>
                        </template>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 2rem; height: 50px;" :disabled="loading">
                        <span x-show="!loading">Generate Optimized Budget</span>
                        <span x-show="loading">Calculating...</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Results Panel -->
        <div>
            <div class="card" x-show="!result" style="height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; border: 2px dashed var(--border-color); background: none;">
                <svg style="width: 64px; height: 64px; color: #ccc; margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <p style="color: var(--text-muted);">Your optimized budget breakdown will appear here.</p>
            </div>

            <div x-show="result" x-transition>
                <div class="card" style="margin-bottom: 1.5rem;">
                    <h3 style="margin-bottom: 1.5rem;">Recommended Allocation</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                        <template x-for="item in result" :key="item.category">
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem;">
                                    <span style="font-weight: 700;" x-text="item.category"></span>
                                    <span style="color: var(--dark-neutral); font-weight: 800;">RWF <span x-text="item.amount.toLocaleString()"></span></span>
                                </div>
                                <div style="width: 100%; height: 8px; background: #eee; border-radius: 4px; overflow: hidden;">
                                    <div :style="'width: ' + item.percentage + '%; background: var(--dark-neutral); height: 100%;'"></div>
                                </div>
                                <div style="margin-top: 0.5rem; font-size: 0.75rem; color: var(--text-muted);">
                                    <template x-for="tip in item.tips">
                                        <div style="margin-bottom: 2px;">• <span x-text="tip"></span></div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="card" style="background: var(--dark-neutral); color: var(--white);">
                    <h4 style="color: var(--primary-beige); margin-bottom: 0.5rem;">Next Steps</h4>
                    <p style="font-size: 0.9rem; margin-bottom: 1.5rem;">Ready to start booking? Use our Matchmaking engine to find vendors within these budget ranges.</p>
                    <a href="{{ route('ai.match') }}" class="btn btn-secondary" style="width: 100%;">Find Matched Vendors</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function budgetOptimizer() {
    return {
        loading: false,
        result: null,
        categories: [
            'Venue & Catering',
            'Attire & Beauty',
            'Photography & Video',
            'Decoration',
            'Entertainment',
            'Invitations & Logistics'
        ],
        formData: {
            total_budget: '',
            priorities: {
                'Venue & Catering': 'normal',
                'Attire & Beauty': 'normal',
                'Photography & Video': 'normal',
                'Decoration': 'normal',
                'Entertainment': 'normal',
                'Invitations & Logistics': 'normal'
            }
        },
        async optimize() {
            this.loading = true;
            try {
                const response = await fetch('{{ route("ai.budget.optimize") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.formData)
                });
                const data = await response.json();
                if (data.success) {
                    this.result = data.budget;
                }
            } catch (e) {
                console.error(e);
            }
            this.loading = false;
        }
    }
}
</script>
@endsection
