@extends('layouts.dashboard')

@section('title', 'Create New Service')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div class="card">
        <div style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
            <h2 style="font-size: 1.5rem; color: var(--dark-neutral);">Add New Wedding Service</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Fill in the details below to create your premium service listing.</p>
        </div>

        <form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Basic Information -->
            <div style="margin-bottom: 3rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.5rem; color: var(--accent); text-transform: uppercase; letter-spacing: 0.05em;">Basic Information</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div style="grid-column: span 2;">
                        <label for="title" class="label">Service Title <span style="color: #c62828;">*</span></label>
                        <input type="text" name="title" id="title" class="input" required placeholder="e.g., Premium Wedding Photography Package">
                        @error('title') <p style="color: #c62828; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category" class="label">Category <span style="color: #c62828;">*</span></label>
                        <select name="category" id="category" class="input" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category') <p style="color: #c62828; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="price" class="label">Price (RWF) <span style="color: #c62828;">*</span></label>
                        <input type="number" name="price" id="price" class="input" required step="1" min="0" placeholder="500000">
                        @error('price') <p style="color: #c62828; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="location" class="label">Location <span style="color: #c62828;">*</span></label>
                        <input type="text" name="location" id="location" class="input" required placeholder="e.g., New York, NY">
                        @error('location') <p style="color: #c62828; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="contact_info" class="label">Contact Info</label>
                        <input type="text" name="contact_info" id="contact_info" class="input" placeholder="Email or Phone">
                        @error('contact_info') <p style="color: #c62828; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div style="margin-bottom: 3rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.5rem; color: var(--accent); text-transform: uppercase; letter-spacing: 0.05em;">Service Details</h3>
                <label for="description" class="label">Detailed Description <span style="color: #c62828;">*</span></label>
                <textarea name="description" id="description" rows="6" class="input" required placeholder="Describe what makes your service unique..."></textarea>
                @error('description') <p style="color: #c62828; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>

            <!-- Image Uploads -->
            <div style="margin-bottom: 3rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.5rem; color: var(--accent); text-transform: uppercase; letter-spacing: 0.05em;">Service Gallery</h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem;">
                    <!-- Main Image -->
                    <div style="text-align: center;">
                        <label class="label">Main Image</label>
                        <div class="image-upload-box" onclick="document.getElementById('main_image').click()">
                            <input type="file" name="main_image" id="main_image" class="hidden" accept="image/*" required onchange="previewImage(this, 'main_preview')">
                            <div id="main_preview" style="height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; color: var(--text-muted);">
                                <svg style="width: 32px; height: 32px; margin-bottom: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span style="font-size: 0.8rem;">Upload</span>
                            </div>
                        </div>
                        @error('main_image') <p style="color: #c62828; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
                    </div>

                    <!-- Image 2 -->
                    <div style="text-align: center;">
                        <label class="label">Gallery 1 <span style="color:#aaa;font-weight:400;">(optional)</span></label>
                        <div class="image-upload-box" onclick="document.getElementById('image2').click()">
                            <input type="file" name="image2" id="image2" class="hidden" accept="image/*" onchange="previewImage(this, 'image2_preview')">
                            <div id="image2_preview" style="height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; color: var(--text-muted);">
                                <svg style="width: 32px; height: 32px; margin-bottom: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span style="font-size: 0.8rem;">Add</span>
                            </div>
                        </div>
                        @error('image2') <p style="color: #c62828; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
                    </div>

                    <!-- Image 3 -->
                    <div style="text-align: center;">
                        <label class="label">Gallery 2 <span style="color:#aaa;font-weight:400;">(optional)</span></label>
                        <div class="image-upload-box" onclick="document.getElementById('image3').click()">
                            <input type="file" name="image3" id="image3" class="hidden" accept="image/*" onchange="previewImage(this, 'image3_preview')">
                            <div id="image3_preview" style="height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; color: var(--text-muted);">
                                <svg style="width: 32px; height: 32px; margin-bottom: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span style="font-size: 0.8rem;">Add</span>
                            </div>
                        </div>
                        @error('image3') <p style="color: #c62828; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div style="display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                <a href="{{ route('services.vendor') }}" class="btn btn-outline" style="padding: 0.75rem 2rem;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 3rem;">Create Listing</button>
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
