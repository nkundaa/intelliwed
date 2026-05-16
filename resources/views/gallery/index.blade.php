@extends('layouts.dashboard')

@section('title', 'Photo Gallery')

@section('extra-head')
<style>
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}
.gallery-item {
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    aspect-ratio: 1;
    cursor: pointer;
    background: #f0f0f0;
    border: 1px solid #f0f0f0;
}
.gallery-item img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}
.gallery-item:hover img { transform: scale(1.05); }
.gallery-overlay {
    position: absolute; inset: 0;
    background: rgba(0,0,0,0.4);
    display: flex; align-items: flex-end;
    padding: 0.75rem;
    opacity: 0;
    transition: opacity 0.2s;
}
.gallery-item:hover .gallery-overlay { opacity: 1; }
.upload-zone {
    border: 2px dashed #ddd;
    border-radius: 16px;
    padding: 3rem 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: white;
}
.upload-zone:hover { border-color: #9bf6af; background: #f0fff4; }
.upload-zone.drag-over { border-color: #4ade80; background: #f0fff4; }
.album-tab {
    padding: 0.5rem 1rem;
    border-radius: 99px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    border: 1px solid #e5e5e5;
    background: white;
    transition: all 0.2s;
}
.album-tab.active { background: #222; color: white; border-color: #222; }
.lightbox {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.9);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}
.lightbox img {
    max-width: 90vw;
    max-height: 85vh;
    object-fit: contain;
    border-radius: 8px;
}
</style>
@endsection

@section('content')
<div style="max-width: 1100px; margin: 0 auto;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h2 style="font-size: 1.5rem; margin: 0;">Photo Gallery</h2>
            <p style="color: #888; font-size: 0.9rem; margin-top: 0.25rem;">{{ $photos->count() }} photo{{ $photos->count() !== 1 ? 's' : '' }}</p>
        </div>
        <button onclick="openUploadModal()" class="btn btn-primary">
            + Upload Photos
        </button>
    </div>

    <!-- Upload Zone (always visible if empty) -->
    @if($photos->isEmpty())
        <div class="upload-zone" onclick="openUploadModal()">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🖼️</div>
            <h3 style="margin-bottom: 0.5rem;">Upload your first photos</h3>
            <p style="color: #888; font-size: 0.9rem;">Share your wedding memories with family and friends</p>
            <div class="btn btn-secondary" style="margin-top: 1.5rem; display: inline-flex;">Choose Photos</div>
        </div>
    @else
        <!-- Album Tabs -->
        @if($albums->count() > 1)
            <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <button class="album-tab active" onclick="filterAlbum('all', this)">All Photos</button>
                @foreach($albums->keys() as $album)
                    <button class="album-tab" onclick="filterAlbum('{{ $album }}', this)">{{ ucfirst($album) }}</button>
                @endforeach
            </div>
        @endif

        <!-- Gallery Grid -->
        <div class="gallery-grid" id="galleryGrid">
            @foreach($photos as $photo)
                <div class="gallery-item" data-album="{{ $photo->album }}" onclick="openLightbox('{{ $photo->url }}', '{{ $photo->caption }}')">
                    <img src="{{ $photo->url }}" alt="{{ $photo->caption }}" loading="lazy">
                    <div class="gallery-overlay">
                        <div style="flex: 1;">
                            @if($photo->caption)
                                <div style="color: white; font-size: 0.8rem; font-weight: 600;">{{ $photo->caption }}</div>
                            @endif
                            <div style="color: rgba(255,255,255,0.7); font-size: 0.7rem;">{{ $photo->album }}</div>
                        </div>
                        <form method="POST" action="{{ route('gallery.destroy', $photo) }}" onsubmit="return confirm('Delete this photo?')" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background: rgba(255,255,255,0.2); border: none; color: white; border-radius: 6px; padding: 0.3rem 0.5rem; cursor: pointer; font-size: 0.75rem;">✕</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Upload Modal -->
<div id="uploadModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; padding: 2rem;">
    <div style="background: white; border-radius: 20px; padding: 2rem; width: 100%; max-width: 500px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Upload Photos</h3>
            <button onclick="closeUploadModal()" style="background: none; border: none; cursor: pointer; font-size: 1.5rem; color: #aaa;">×</button>
        </div>
        <form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label class="label">Select Photos *</label>
                <input type="file" name="photos[]" multiple accept="image/*" class="input" required style="padding: 0.5rem;">
                <p style="font-size: 0.75rem; color: #888; margin-top: 0.25rem;">Max 20 photos, 10MB each. JPG, PNG, WebP supported.</p>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="label">Album Name</label>
                <input type="text" name="album" class="input" placeholder="e.g. Reception, Ceremony, Pre-wedding..." value="general">
            </div>
            <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <input type="checkbox" name="is_public" value="1" id="isPublic">
                <label for="isPublic" style="font-size: 0.9rem; cursor: pointer;">Make public on wedding website</label>
            </div>
            <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button type="button" onclick="closeUploadModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" style="display: none;" onclick="this.style.display='none'">
    <img id="lightboxImg" src="" alt="">
    <div style="position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); color: white; font-size: 0.9rem;" id="lightboxCaption"></div>
</div>

<script>
function openLightbox(url, caption) {
    document.getElementById('lightboxImg').src = url;
    document.getElementById('lightboxCaption').textContent = caption || '';
    document.getElementById('lightbox').style.display = 'flex';
}

function filterAlbum(album, btn) {
    document.querySelectorAll('.album-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.gallery-item').forEach(item => {
        item.style.display = album === 'all' || item.dataset.album === album ? '' : 'none';
    });
}

function openUploadModal() {
    document.getElementById('uploadModal').style.display = 'flex';
}

function closeUploadModal() {
    document.getElementById('uploadModal').style.display = 'none';
}
</script>
@endsection
