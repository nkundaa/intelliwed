<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Service - Admin Panel') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Service: {{ $service->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">Update service information as admin</p>
                </div>

                <form method="POST" action="{{ route('services.admin-update', $service->id) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h4 class="text-md font-semibold text-gray-900 mb-4 pb-2 border-b">Basic Information</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Service Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Service Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" required value="{{ $service->title }}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                    Service Category <span class="text-red-500">*</span>
                                </label>
                                <select name="category" id="category" required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @foreach($categories as $value => $label)
                                        <option value="{{ $value }}" {{ $service->category == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Price ($) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="price" id="price" required step="0.01" min="0" value="{{ $service->price }}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                    Location <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="location" id="location" required value="{{ $service->location }}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact Info -->
                            <div>
                                <label for="contact_info" class="block text-sm font-medium text-gray-700 mb-2">
                                    Contact Information (Optional)
                                </label>
                                <input type="text" name="contact_info" id="contact_info" value="{{ $service->contact_info }}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('contact_info')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Service Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="active" {{ $service->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $service->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h4 class="text-md font-semibold text-gray-900 mb-4 pb-2 border-b">Service Description</h4>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Detailed Description <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="6" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ $service->description }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Minimum 50 characters required</p>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>

                    <!-- Current Images -->
                    <div class="mb-8">
                        <h4 class="text-md font-semibold text-gray-900 mb-4 pb-2 border-bottom">Current Images</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Main Image</label>
                                @if($service->main_image)
                                    <div class="w-full h-32 bg-gray-200 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $service->main_image) }}" alt="Main image" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Image 1</label>
                                @if($service->image2)
                                    <div class="w-full h-32 bg-gray-200 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $service->image2) }}" alt="Image 2" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Image 2</label>
                                @if($service->image3)
                                    <div class="w-full h-32 bg-gray-200 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $service->image3) }}" alt="Image 3" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-between pt-6 border-t">
                        <div>
                            <form method="POST" action="{{ route('services.admin-destroy', $service->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                    Delete Service
                                </button>
                            </form>
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('services.admin') }}" 
                                class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors font-medium">
                                Update Service
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
