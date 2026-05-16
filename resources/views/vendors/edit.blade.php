<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('vendors.update', $service->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Service Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $service->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Service Category')" />
                            <select id="category" name="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                <option value="photographer" {{ old('category', $service->category) == 'photographer' ? 'selected' : '' }}>Photography</option>
                                <option value="venue" {{ old('category', $service->category) == 'venue' ? 'selected' : '' }}>Venue</option>
                                <option value="decorator" {{ old('category', $service->category) == 'decorator' ? 'selected' : '' }}>Decoration</option>
                                <option value="catering" {{ old('category', $service->category) == 'catering' ? 'selected' : '' }}>Catering</option>
                                <option value="music" {{ old('category', $service->category) == 'music' ? 'selected' : '' }}>Music</option>
                                <option value="beauty" {{ old('category', $service->category) == 'beauty' ? 'selected' : '' }}>Beauty</option>
                                <option value="transport" {{ old('category', $service->category) == 'transport' ? 'selected' : '' }}>Transportation</option>
                                <option value="cake" {{ old('category', $service->category) == 'cake' ? 'selected' : '' }}>Cake</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price (USD)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $service->price)" required step="0.01" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $service->location)" required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Contact Info -->
                        <div class="mb-4">
                            <x-input-label for="contact_info" :value="__('Contact Information')" />
                            <x-text-input id="contact_info" class="block mt-1 w-full" type="text" name="contact_info" :value="old('contact_info', $service->contact_info)" placeholder="Phone, email, or website" />
                            <x-input-error :messages="$errors->get('contact_info')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('description', $service->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Current Images -->
                        @if($service->main_image)
                        <div class="mb-4">
                            <x-input-label :value="__('Current Main Image')" />
                            <img src="{{ asset('storage/' . $service->main_image) }}" alt="Current main image" class="w-32 h-32 object-cover rounded">
                        </div>
                        @endif

                        @if($service->image2 || $service->image3)
                        <div class="mb-4">
                            <x-input-label :value="__('Current Additional Images')" />
                            <div class="flex gap-2">
                                @if($service->image2)
                                    <img src="{{ asset('storage/' . $service->image2) }}" alt="Current image 2" class="w-24 h-24 object-cover rounded">
                                @endif
                                @if($service->image3)
                                    <img src="{{ asset('storage/' . $service->image3) }}" alt="Current image 3" class="w-24 h-24 object-cover rounded">
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Main Image -->
                        <div class="mb-4">
                            <x-input-label for="main_image" :value="__('Update Main Image (Optional)')" />
                            <input id="main_image" class="block mt-1 w-full" type="file" name="main_image" accept="image/*" />
                            <x-input-error :messages="$errors->get('main_image')" class="mt-2" />
                        </div>

                        <!-- Additional Images -->
                        <div class="mb-4">
                            <x-input-label for="image2" :value="__('Update Additional Image 2 (Optional)')" />
                            <input id="image2" class="block mt-1 w-full" type="file" name="image2" accept="image/*" />
                            <x-input-error :messages="$errors->get('image2')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="image3" :value="__('Update Additional Image 3 (Optional)')" />
                            <input id="image3" class="block mt-1 w-full" type="file" name="image3" accept="image/*" />
                            <x-input-error :messages="$errors->get('image3')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Leave empty to keep current images. Max 4MB each.</p>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Service') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>