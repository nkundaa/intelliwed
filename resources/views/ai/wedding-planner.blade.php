@extends('layouts.dashboard')

@section('title', 'AI Wedding Planner')

@section('extra-head')
<style>
.planner-step {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f0f0;
    padding: 2rem;
    margin-bottom: 1.5rem;
}
.priority-btn {
    padding: 0.35rem 0.75rem;
    border-radius: 99px;
    border: 1.5px solid #e5e5e5;
    background: white;
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.15s;
    color: #666;
}
.priority-btn.active-high  { background: #fef2f2; border-color: #ef4444; color: #ef4444; }
.priority-btn.active-normal{ background: #f0f9ff; border-color: #3b82f6; color: #3b82f6; }
.priority-btn.active-low   { background: #f0fdf4; border-color: #22c55e; color: #22c55e; }
.category-section {
    border: 1px solid #f0f0f0;
    border-radius: 14px;
    overflow: hidden;
    margin-bottom: 1.25rem;
}
.category-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.25rem;
    background: #fafafa;
    border-bottom: 1px solid #f0f0f0;
}
.service-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1rem;
    padding: 1.25rem;
}
.service-card {
    border: 2px solid #e5e5e5;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.2s;
    background: white;
    position: relative;
}
.service-card:hover { border-color: #aaa; transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
.service-card.selected { border-color: #222; box-shadow: 0 0 0 3px rgba(34,34,34,0.12); }
.service-card.selected::after {
    content: '✓';
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    width: 24px; height: 24px;
    background: #222;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 900;
}
.service-img {
    width: 100%; height: 130px;
    object-fit: cover;
    background: #f0f0f0;
}
.budget-bar-wrap {
    height: 8px;
    background: #f0f0f0;
    border-radius: 99px;
    overflow: hidden;
    margin-top: 0.4rem;
}
.budget-bar-fill {
    height: 100%;
    border-radius: 99px;
    transition: width 0.5s ease;
}
.sticky-summary {
    position: sticky;
    top: 100px;
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f0f0;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}
@media (max-width: 900px) {
    .planner-grid { grid-template-columns: 1fr !important; }
    .sticky-summary { position: static; }
}
</style>
@endsection

@section('content')
<div x-data="weddingPlanner()" style="max-width: 1200px; margin: 0 auto;">

    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
            <div style="width: 48px; height: 48px; background: #222; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">🤖</div>
            <div>
                <h2 style="font-size: 1.6rem; margin: 0;">AI Wedding Planner</h2>
                <p style="color: #888; margin: 0; font-size: 0.9rem;">Enter your budget — our AI will suggest the best services for your day</p>
            </div>
        </div>
    </div>

    <div class="planner-grid" style="display: grid; grid-template-columns: 1fr 320px; gap: 2rem; align-items: start;">

        <!-- LEFT: input + results -->
        <div>
            <!-- Step 1: Budget Input -->
            <div class="planner-step">
                <h3 style="font-size: 1rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="width: 28px; height: 28px; background: #222; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 800;">1</span>
                    Your Wedding Budget
                </h3>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #444; margin-bottom: 0.4rem;">Total Budget (RWF)</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #888; font-size: 0.9rem; font-weight: 600;">RWF</span>
                        <input type="number" x-model="budget" min="100000" step="50000"
                               placeholder="e.g. 5,000,000"
                               style="width: 100%; padding: 0.85rem 1rem 0.85rem 3.5rem; border: 1.5px solid #e5e5e5; border-radius: 12px; font-size: 1rem; font-family: inherit; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='#222'" onblur="this.style.borderColor='#e5e5e5'">
                    </div>
                    <p style="font-size: 0.78rem; color: #aaa; margin-top: 0.3rem;">Minimum: RWF 100,000</p>
                </div>

                <!-- Priority sliders -->
                <h3 style="font-size: 1rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="width: 28px; height: 28px; background: #222; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 800;">2</span>
                    Set Your Priorities
                </h3>

                <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <template x-for="cat in categories" :key="cat.key">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; background: #fafafa; border-radius: 10px; border: 1px solid #f0f0f0;">
                            <div style="display: flex; align-items: center; gap: 0.6rem;">
                                <span x-text="cat.icon" style="font-size: 1.1rem;"></span>
                                <span style="font-size: 0.875rem; font-weight: 600;" x-text="cat.key"></span>
                            </div>
                            <div style="display: flex; gap: 0.4rem;">
                                <button type="button" @click="setPriority(cat.key, 'high')"
                                        :class="priorities[cat.key] === 'high' ? 'priority-btn active-high' : 'priority-btn'">High</button>
                                <button type="button" @click="setPriority(cat.key, 'normal')"
                                        :class="priorities[cat.key] === 'normal' ? 'priority-btn active-normal' : 'priority-btn'">Normal</button>
                                <button type="button" @click="setPriority(cat.key, 'low')"
                                        :class="priorities[cat.key] === 'low' ? 'priority-btn active-low' : 'priority-btn'">Low</button>
                            </div>
                        </div>
                    </template>
                </div>

                <button @click="generatePlan()" :disabled="loading || !budget"
                        style="width: 100%; padding: 1rem; background: #222; color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 700; cursor: pointer; font-family: inherit; display: flex; align-items: center; justify-content: center; gap: 0.75rem; transition: background 0.2s;"
                        :style="loading || !budget ? 'opacity: 0.6; cursor: not-allowed;' : 'opacity: 1;'"
                        onmouseover="if(!this.disabled) this.style.background='#000'" onmouseout="if(!this.disabled) this.style.background='#222'">
                    <span x-show="!loading">✨ Generate My Wedding Plan</span>
                    <span x-show="loading" style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg style="width: 18px; height: 18px; animation: spin 1s linear infinite;" fill="none" viewBox="0 0 24 24"><circle style="opacity:0.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path style="opacity:0.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Analyzing your budget...
                    </span>
                </button>
            </div>

            <!-- Results -->
            <div x-show="plan.length > 0" x-transition>
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                    <h3 style="font-size: 1.1rem; margin: 0;">AI Suggested Plan</h3>
                    <span style="font-size: 0.78rem; background: #f0fff4; color: #166534; padding: 0.2rem 0.6rem; border-radius: 99px; font-weight: 700; border: 1px solid #bbf7d0;">
                        <span x-text="totalSelected"></span> service(s) selected
                    </span>
                </div>

                <template x-for="section in plan" :key="section.category">
                    <div class="category-section">
                        <div class="category-header">
                            <div>
                                <span style="font-weight: 700; font-size: 0.95rem;" x-text="section.category"></span>
                                <div class="budget-bar-wrap" style="width: 160px;">
                                    <div class="budget-bar-fill" :style="'width:' + section.percentage + '%; background: ' + getCatColor(section.category)"></div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-weight: 800; font-size: 0.95rem;">RWF <span x-text="section.amount.toLocaleString()"></span></div>
                                <div style="font-size: 0.75rem; color: #888;" x-text="section.percentage + '% of budget'"></div>
                            </div>
                        </div>

                        <!-- No services available -->
                        <div x-show="section.services.length === 0" style="padding: 1.25rem; color: #aaa; font-size: 0.875rem; text-align: center;">
                            No services listed for this category yet.
                            <br><span style="font-size: 0.78rem;">Keep this budget aside as a reserve.</span>
                        </div>

                        <!-- Service cards -->
                        <div class="service-grid" x-show="section.services.length > 0">
                            <template x-for="svc in section.services" :key="svc.id">
                                <div class="service-card"
                                     :class="isSelected(svc.id) ? 'selected' : ''"
                                     @click="toggleService(svc, section)">
                                    <img :src="svc.main_image ? '/storage/' + svc.main_image : ''"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                                         class="service-img">
                                    <div class="service-img" style="display: none; align-items: center; justify-content: center; font-size: 2rem; color: #ddd;">🎊</div>

                                    <div style="padding: 0.85rem;">
                                        <div style="font-size: 0.7rem; color: #888; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 0.25rem;" x-text="svc.category"></div>
                                        <div style="font-weight: 700; font-size: 0.875rem; margin-bottom: 0.5rem; line-height: 1.3;" x-text="svc.title"></div>
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <span style="font-weight: 800; font-size: 0.9rem;">RWF <span x-text="svc.price.toLocaleString()"></span></span>
                                            <span x-show="svc.is_verified" style="font-size: 0.65rem; background: #eff6ff; color: #1d4ed8; padding: 0.15rem 0.4rem; border-radius: 4px; font-weight: 700;">✓ Verified</span>
                                        </div>
                                        <div style="font-size: 0.72rem; color: #aaa; margin-top: 0.3rem;" x-text="svc.vendor_name"></div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Tips -->
                        <div x-show="section.tips && section.tips.length" style="padding: 0 1.25rem 1.25rem;">
                            <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 0.75rem 1rem;">
                                <div style="font-size: 0.75rem; font-weight: 700; color: #92400e; margin-bottom: 0.3rem;">💡 AI Tips</div>
                                <template x-for="tip in section.tips">
                                    <div style="font-size: 0.78rem; color: #78350f; margin-bottom: 0.2rem;">• <span x-text="tip"></span></div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- RIGHT: Sticky Summary -->
        <div>
            <div class="sticky-summary">
                <h4 style="font-size: 0.95rem; margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 1px solid #f0f0f0;">My Wedding Plan</h4>

                <!-- Before plan generated -->
                <div x-show="plan.length === 0" style="text-align: center; padding: 2rem 0; color: #bbb;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">✨</div>
                    <p style="font-size: 0.85rem;">Your selected services will appear here</p>
                </div>

                <!-- Budget overview -->
                <div x-show="plan.length > 0">
                    <div style="margin-bottom: 1.25rem;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.82rem; color: #888; margin-bottom: 0.3rem;">
                            <span>Total Budget</span>
                            <span style="font-weight: 700; color: #222;">RWF <span x-text="parseInt(budget).toLocaleString()"></span></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.82rem; color: #888; margin-bottom: 0.3rem;">
                            <span>Selected Total</span>
                            <span style="font-weight: 700;" :style="selectedTotal > parseInt(budget) ? 'color:#ef4444' : 'color:#166534'">
                                RWF <span x-text="selectedTotal.toLocaleString()"></span>
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.82rem; margin-bottom: 0.75rem;">
                            <span style="color: #888;">Remaining</span>
                            <span style="font-weight: 800;" :style="(parseInt(budget) - selectedTotal) < 0 ? 'color:#ef4444' : 'color:#222'">
                                RWF <span x-text="(parseInt(budget) - selectedTotal).toLocaleString()"></span>
                            </span>
                        </div>
                        <div style="height: 6px; background: #f0f0f0; border-radius: 99px; overflow: hidden;">
                            <div :style="'width: ' + Math.min(100, (selectedTotal / parseInt(budget)) * 100) + '%; background: ' + (selectedTotal > parseInt(budget) ? '#ef4444' : '#4ade80') + '; height: 100%; border-radius: 99px; transition: width 0.4s;'"></div>
                        </div>
                        <div style="font-size: 0.72rem; color: #aaa; margin-top: 0.3rem;" x-text="Math.round((selectedTotal / parseInt(budget)) * 100) + '% of budget used'"></div>
                    </div>

                    <!-- Selected services list -->
                    <div x-show="selectedServices.length === 0" style="color: #bbb; font-size: 0.82rem; text-align: center; padding: 1rem 0;">
                        Click on services to add them to your plan
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.6rem; max-height: 360px; overflow-y: auto; margin-bottom: 1.25rem;">
                        <template x-for="svc in selectedServices" :key="svc.id">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.6rem 0.75rem; background: #fafafa; border-radius: 8px; border: 1px solid #f0f0f0;">
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-size: 0.8rem; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" x-text="svc.title"></div>
                                    <div style="font-size: 0.72rem; color: #888;" x-text="'RWF ' + svc.price.toLocaleString()"></div>
                                </div>
                                <button @click="removeService(svc.id)" style="background: none; border: none; cursor: pointer; color: #ccc; font-size: 1rem; padding: 0.25rem; flex-shrink: 0;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#ccc'">✕</button>
                            </div>
                        </template>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                        <a x-show="selectedServices.length > 0"
                           :href="buildBookingUrl()"
                           style="display: block; text-align: center; padding: 0.85rem; background: #222; color: white; border-radius: 10px; font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: background 0.2s;"
                           onmouseover="this.style.background='#000'" onmouseout="this.style.background='#222'">
                            Book Selected Services
                        </a>
                        <button x-show="selectedServices.length > 0" @click="clearAll()"
                                style="padding: 0.75rem; background: white; color: #888; border: 1px solid #e5e5e5; border-radius: 10px; font-size: 0.85rem; cursor: pointer; font-family: inherit; transition: all 0.15s;">
                            Clear All
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>

<script>
function weddingPlanner() {
    return {
        budget: '',
        loading: false,
        plan: [],
        selectedServices: [],
        priorities: {
            'Venue & Catering': 'normal',
            'Attire & Beauty': 'normal',
            'Photography & Video': 'normal',
            'Decoration': 'normal',
            'Entertainment': 'normal',
            'Invitations & Logistics': 'normal',
        },
        categories: [
            { key: 'Venue & Catering',        icon: '🏛️' },
            { key: 'Attire & Beauty',          icon: '👗' },
            { key: 'Photography & Video',      icon: '📷' },
            { key: 'Decoration',               icon: '🌸' },
            { key: 'Entertainment',            icon: '🎵' },
            { key: 'Invitations & Logistics',  icon: '✉️' },
        ],

        get selectedTotal() {
            return this.selectedServices.reduce((sum, s) => sum + s.price, 0);
        },
        get totalSelected() {
            return this.selectedServices.length;
        },

        setPriority(cat, level) {
            this.priorities[cat] = level;
        },

        async generatePlan() {
            if (!this.budget || this.budget < 100000) return;
            this.loading = true;
            this.plan = [];
            this.selectedServices = [];
            try {
                const res = await fetch('{{ route("ai.planner.suggest") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        total_budget: this.budget,
                        priorities: this.priorities
                    })
                });
                const data = await res.json();
                if (data.success) this.plan = data.plan;
            } catch(e) { console.error(e); }
            this.loading = false;
        },

        isSelected(id) {
            return this.selectedServices.some(s => s.id === id);
        },

        toggleService(svc, section) {
            if (this.isSelected(svc.id)) {
                this.removeService(svc.id);
            } else {
                this.selectedServices.push({ ...svc, _category: section.category });
            }
        },

        removeService(id) {
            this.selectedServices = this.selectedServices.filter(s => s.id !== id);
        },

        clearAll() {
            this.selectedServices = [];
        },

        buildBookingUrl() {
            if (this.selectedServices.length === 0) return '#';
            const ids = this.selectedServices.map(s => s.id).join(',');
            return '/services?ids=' + ids;
        },

        getCatColor(cat) {
            const colors = {
                'Venue & Catering': '#f59e0b',
                'Attire & Beauty': '#ec4899',
                'Photography & Video': '#3b82f6',
                'Decoration': '#8b5cf6',
                'Entertainment': '#10b981',
                'Invitations & Logistics': '#f97316',
                'Emergency Fund': '#94a3b8',
            };
            return colors[cat] || '#9bf6af';
        }
    };
}
</script>
@endsection
