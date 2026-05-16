@extends('layouts.dashboard')

@section('title', 'AI Vendor Matchmaking')

@section('content')
<div x-data="matchmaking()">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Algorithmic Matchmaking</h2>
        <p style="color: var(--text-muted); font-size: 1.1rem;">Finding the perfect vendors for your wedding shouldn't be a chore. Our engine matches you based on your needs.</p>
    </div>

    <div class="card" style="margin-bottom: 3rem;">
        <form @submit.prevent="findMatches" style="display: grid; grid-template-columns: 1.5fr 2fr 1fr; gap: 1.5rem; align-items: flex-end;">
            <div class="form-group" style="margin: 0;">
                <label class="label">Approx. Budget per Service (RWF)</label>
                <input type="number" x-model="formData.budget" class="input" placeholder="e.g. 500000">
            </div>
            <div class="form-group" style="margin: 0;">
                <label class="label">Categories Interested In</label>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <template x-for="cat in allCategories" :key="cat">
                        <label style="cursor: pointer;">
                            <input type="checkbox" :value="cat" x-model="formData.categories" style="display: none;">
                            <div :class="formData.categories.includes(cat) ? 'chip-active' : 'chip-inactive'" x-text="cat" style="padding: 0.4rem 0.8rem; border-radius: 20px; border: 1px solid var(--border-color); font-size: 0.85rem; font-weight: 600;"></div>
                        </label>
                    </template>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="height: 45px;" :disabled="loading">
                <span x-show="!loading">Find Matches</span>
                <span x-show="loading">Matching...</span>
            </button>
        </form>
    </div>

    <div x-show="matches.length > 0" x-transition>
        <h3 style="margin-bottom: 1.5rem;">Your Top Matches</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
            <template x-for="service in matches" :key="service.id">
                <div class="card" style="padding: 0; overflow: hidden; position: relative;">
                    <div style="position: absolute; top: 1rem; left: 1rem; z-index: 10;">
                        <div style="background: var(--dark-neutral); color: var(--primary-beige); padding: 0.4rem 0.8rem; border-radius: 20px; font-weight: 800; font-size: 0.8rem; box-shadow: var(--shadow-md);">
                            <span x-text="service.match_score"></span>% Match
                        </div>
                    </div>
                    <div style="height: 200px; background: #eee;">
                        <img :src="service.main_image ? '/storage/' + service.main_image : 'https://via.placeholder.com/400x200?text=No+Image'" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                            <span x-text="service.category" style="font-size: 0.75rem; font-weight: 700; color: var(--accent); text-transform: uppercase;"></span>
                            <div style="display: flex; gap: 0.25rem;">
                                <template x-for="badge in service.vendor.badges">
                                    <div :title="badge.badge_type" style="width: 18px; height: 18px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <svg x-show="badge.badge_type == 'verified'" style="width: 12px; height: 12px; color: #34aaff;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <h4 x-text="service.title" style="margin-bottom: 0.75rem; font-size: 1.1rem;"></h4>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                            <span style="font-weight: 800; font-size: 1.1rem;">RWF <span x-text="parseInt(service.price).toLocaleString()"></span></span>
                            <a :href="'/services/' + service.id" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">View Profile</a>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <div x-show="searched && matches.length == 0" style="text-align: center; padding: 4rem;">
        <p style="color: var(--text-muted);">No vendors matched your exact criteria. Try adjusting your budget or categories.</p>
    </div>
</div>

<style>
    .chip-active { background: var(--dark-neutral); color: var(--white); border-color: var(--dark-neutral) !important; }
    .chip-inactive { background: var(--white); color: var(--text-muted); }
</style>

<script>
function matchmaking() {
    return {
        loading: false,
        searched: false,
        matches: [],
        allCategories: ['Venue', 'Catering', 'Photography', 'Decoration', 'Entertainment', 'Attire'],
        formData: {
            budget: '',
            categories: []
        },
        async findMatches() {
            this.loading = true;
            this.searched = true;
            try {
                const response = await fetch('{{ route("ai.match.process") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.formData)
                });
                const data = await response.json();
                if (data.success) {
                    this.matches = data.matches;
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
