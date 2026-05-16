@props(['badges' => []])

<div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
    @foreach($badges as $badge)
        <div class="badge-wrapper" title="{{ ucfirst(str_replace('_', ' ', $badge->badge_type)) }}" style="position: relative; display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background: var(--white); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
            @if($badge->badge_type == 'verified')
                <svg style="width: 20px; height: 20px; color: #34aaff;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            @elseif($badge->badge_type == 'top_rated')
                <svg style="width: 20px; height: 20px; color: #f57f17;" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
            @elseif($badge->badge_type == 'trusted')
                <svg style="width: 20px; height: 20px; color: #2e7d32;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            @elseif($badge->badge_type == 'fast_responder')
                <svg style="width: 20px; height: 20px; color: #aa6ae2;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.047a1 1 0 01.897.95l-.6 15.4a1 1 0 01-1.557.818L6.45 15.54H4a2 2 0 01-2-2V5a2 2 0 012-2h2.45l3.593-2.675a1 1 0 011.257-.278zM14 6a1 1 0 100 2 1 1 0 000-2zm0 4a1 1 0 100 2 1 1 0 000-2zm1 3a1 1 0 10-2 0 1 1 0 002 0z" clip-rule="evenodd"></path></svg>
            @endif
        </div>
    @endforeach
</div>
