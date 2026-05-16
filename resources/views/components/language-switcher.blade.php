<div x-data="{ open: false }" style="position: relative;">
    <button @click="open = !open" style="display: flex; align-items: center; gap: 0.5rem; background: var(--light-neutral); border: 1px solid var(--border-color); padding: 0.5rem 0.75rem; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.9rem; color: var(--dark-neutral);">
        <span>{{ App::getLocale() == 'rw' ? 'EN' : strtoupper(App::getLocale()) }}</span>
        <svg style="width: 16px; height: 16px; transition: transform 0.3s;" :style="open ? 'transform: rotate(180deg)' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div x-show="open" @click.away="open = false" x-transition class="card" style="position: absolute; right: 0; top: 120%; width: 160px; padding: 0.5rem; z-index: 1002; box-shadow: var(--shadow-lg);">

        <a href="{{ route('language.switch', 'en') }}" class="dropdown-link {{ App::getLocale() == 'en' ? 'active-locale' : '' }}" style="display: flex; align-items: center; justify-content: space-between;">
            <span>English</span>
            @if(App::getLocale() == 'en') <svg style="width: 16px; height: 16px; color: #2e7d32;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> @endif
        </a>
        <a href="{{ route('language.switch', 'fr') }}" class="dropdown-link {{ App::getLocale() == 'fr' ? 'active-locale' : '' }}" style="display: flex; align-items: center; justify-content: space-between;">
            <span>Français</span>
            @if(App::getLocale() == 'fr') <svg style="width: 16px; height: 16px; color: #2e7d32;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> @endif
        </a>
    </div>
</div>

<style>
    .dropdown-link.active-locale {
        background-color: var(--soft-beige);
        color: var(--dark-neutral);
        font-weight: 700;
    }
</style>
