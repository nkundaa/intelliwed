@extends('layouts.dashboard')

@section('title', 'Edit Service')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card">
        <div style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="font-size: 1.5rem; color: var(--dark-neutral);">Edit Service: {{ $service->title }}</h2>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Update your service details and gallery.</p>
            </div>
            <form method="POST" action="{{ route('services.destroy', $service->id) }}" onsubmit="return confirm('Delete this service permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="color: #c62828; font-weight: 600; background: none; border: 1px solid #c62828; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;">Delete Service</button>
            </form>
        </div>

        <form method="POST" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div style="margin-bottom: 3rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.5rem; color: var(--accent); text-transform: uppercase; letter-spacing: 0.05em;">Basic Information</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div style="grid-column: span 2;">
                        <label for="title" class="label">Service Title <span style="color: #c62828;">*</span></label>
                        <input type="text" name="title" id="title" class="input" required value="{{ $service->title }}">
                        @error('title') <p style="color: #c62828; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category" class="label">Category <span style="color: #c62828;">*</span></label>
                        <select name="category" id="category" class="input" required>
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}" {{ $service->category == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category') <p style="color: #c62828; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="price" class="label">Price ($) <span style="color: #c62828;">*</span></label>
                        <input type="number" name="price" id="price" class="input" required step="0.01" min="0" value="{{ $service->price }}">
                        @error('price') <p style="color: #c62828; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="location" class="label">Location <span style="color: #c62828;">*</span></label>
                        <input type="text" name="location" id="location" class="input" required value="{{ $service->location }}">
                        @error('location') <p style="color: #c62828; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status" class="label">Status <span style="color: #c62828;">*</span></label>
                        <select name="status" id="status" class="input" required>
                            <option value="active" {{ $service->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $service->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div style="margin-bottom: 3rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.5rem; color: var(--accent); text-transform: uppercase; letter-spacing: 0.05em;">Service Details</h3>
                <label for="description" class="label">Detailed Description <span style="color: #c62828;">*</span></label>
                <textarea name="description" id="description" rows="6" class="input" required>{{ $service->description }}</textarea>
                @error('description') <p style="color: #c62828; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>

            <!-- Image Uploads -->
            <div style="margin-bottom: 3rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.5rem; color: var(--accent); text-transform: uppercase; letter-spacing: 0.05em;">Update Gallery</h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem;">
                    <!-- Main Image -->
                    <div style="text-align: center;">
                        <label class="label">Main Image</label>
                        <div class="image-upload-box" onclick="document.getElementById('main_image').click()">
                            <input type="file" name="main_image" id="main_image" class="hidden" accept="image/*" onchange="previewImage(this, 'main_preview')">
                            <div id="main_preview" style="height: 100%;">
                                @if($service->main_image)
                                    <img src="{{ asset('storage/' . $service->main_image) }}" alt="Main">
                                @else
                                    <div style="height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; color: var(--text-muted);">
                                        <svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Image 2 -->
                    <div style="text-align: center;">
                        <label class="label">Gallery 1</label>
                        <div class="image-upload-box" onclick="document.getElementById('image2').click()">
                            <input type="file" name="image2" id="image2" class="hidden" accept="image/*" onchange="previewImage(this, 'image2_preview')">
                            <div id="image2_preview" style="height: 100%;">
                                @if($service->image2)
                                    <img src="{{ asset('storage/' . $service->image2) }}" alt="G1">
                                @else
                                    <div style="height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; color: var(--text-muted);">
                                        <svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Image 3 -->
                    <div style="text-align: center;">
                        <label class="label">Gallery 2</label>
                        <div class="image-upload-box" onclick="document.getElementById('image3').click()">
                            <input type="file" name="image3" id="image3" class="hidden" accept="image/*" onchange="previewImage(this, 'image3_preview')">
                            <div id="image3_preview" style="height: 100%;">
                                @if($service->image3)
                                    <img src="{{ asset('storage/' . $service->image3) }}" alt="G2">
                                @else
                                    <div style="height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; color: var(--text-muted);">
                                        <svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div style="display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                <a href="{{ route('services.vendor') }}" class="btn btn-outline" style="padding: 0.75rem 2rem;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 3rem;">Update Service</button>
            </div>
        </form>
    </div>
</div>

<style>
    .image-upload-box {
        height: 150px;
        border: 2px dashed var(--border-color);
        border-radius: 12px;
        cursor: pointer;
        transition: var(--transition);
        background: var(--soft-beige);
        overflow: hidden;
    }
    .image-upload-box:hover {
        border-color: var(--dark-neutral);
        background: var(--white);
    }
    .image-upload-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
