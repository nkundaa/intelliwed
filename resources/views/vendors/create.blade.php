<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('vendors.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Service Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Service Category')" />
                            <select id="category" name="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                <option value="photographer" {{ old('category') == 'photographer' ? 'selected' : '' }}>Photography</option>
                                <option value="venue" {{ old('category') == 'venue' ? 'selected' : '' }}>Venue</option>
                                <option value="decorator" {{ old('category') == 'decorator' ? 'selected' : '' }}>Decoration</option>
                                <option value="catering" {{ old('category') == 'catering' ? 'selected' : '' }}>Catering</option>
                                <option value="music" {{ old('category') == 'music' ? 'selected' : '' }}>Music</option>
                                <option value="beauty" {{ old('category') == 'beauty' ? 'selected' : '' }}>Beauty</option>
                                <option value="transport" {{ old('category') == 'transport' ? 'selected' : '' }}>Transportation</option>
                                <option value="cake" {{ old('category') == 'cake' ? 'selected' : '' }}>Cake</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price (USD)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" required step="0.01" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Contact Info -->
                        <div class="mb-4">
                            <x-input-label for="contact_info" :value="__('Contact Information')" />
                            <x-text-input id="contact_info" class="block mt-1 w-full" type="text" name="contact_info" :value="old('contact_info')" placeholder="Phone, email, or website" />
                            <x-input-error :messages="$errors->get('contact_info')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Main Image -->
                        <div class="mb-4">
                            <x-input-label for="main_image" :value="__('Main Service Image')" />
                            <input id="main_image" class="block mt-1 w-full" type="file" name="main_image" accept="image/*" required />
                            <x-input-error :messages="$errors->get('main_image')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Upload a high-quality main image (JPG, PNG, max 4MB)</p>
                        </div>

                        <!-- Additional Images -->
                        <div class="mb-4">
                            <x-input-label for="image2" :value="__('Additional Image 2')" />
                            <input id="image2" class="block mt-1 w-full" type="file" name="image2" accept="image/*" required />
                            <x-input-error :messages="$errors->get('image2')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="image3" :value="__('Additional Image 3')" />
                            <input id="image3" class="block mt-1 w-full" type="file" name="image3" accept="image/*" required />
                            <x-input-error :messages="$errors->get('image3')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Upload 2 additional images (JPG, PNG, max 4MB each)</p>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Add Service') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>