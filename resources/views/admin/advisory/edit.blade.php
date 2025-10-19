<x-app-layout>
    <x-slot name="title">Edit Advisory Committee Member</x-slot>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Member</h4>
        </div>
        <div class="p-6">
            <form action="{{ route('advisory.update', $advisory->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block mb-2">Name</label>
                        <input type="text" class="form-input" id="name" name="name" value="{{ old('name', $advisory->name) }}" required>
                        @error('name')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="designation" class="block mb-2">Designation</label>
                        <input type="text" class="form-input" id="designation" name="designation" value="{{ old('designation', $advisory->designation) }}">
                        @error('designation')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="order" class="block mb-2">Display Order</label>
                        <input type="number" class="form-input" id="order" name="order" value="{{ old('order', $advisory->order) }}">
                        @error('order')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="photo" class="block mb-2">Photo</label>
                        @if($advisory->photo)
                            <div class="mb-2">
                                <img src="{{ asset($advisory->photo) }}" alt="Current photo" class="w-32">
                            </div>
                        @endif
                        <input type="file" class="form-input" id="photo" name="photo" accept="image/*">
                        @error('photo')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block mb-2">Message</label>
                        <textarea class="form-input" id="message" name="message" rows="4">{{ old('message', $advisory->message) }}</textarea>
                        @error('message')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block mb-2">Email</label>
                        <input type="email" class="form-input" id="email" name="email" value="{{ old('email', $advisory->email) }}">
                        @error('email')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block mb-2">Phone</label>
                        <input type="text" class="form-input" id="phone" name="phone" value="{{ old('phone', $advisory->phone) }}">
                        @error('phone')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="officename" class="block mb-2">Office Name</label>
                        <input type="text" class="form-input" id="officename" name="officename" value="{{ old('officename', $advisory->officename) }}">
                        @error('officename')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="officeaddress" class="block mb-2">Office Address</label>
                        <textarea class="form-input" id="officeaddress" name="officeaddress" rows="3">{{ old('officeaddress', $advisory->officeaddress) }}</textarea>
                        @error('officeaddress')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block mb-2">Type</label>
                        <select class="form-select" id="type" name="type">
                            <option value="EC Committee" @if ($advisory->type == 'EC Committee') selected @endif>EC Committee</option>
                            <option value="Ex-President" @if ($advisory->type == 'Ex-President') selected @endif>Ex-President</option>
                            <option value="Ex-General Secretary" @if ($advisory->type == 'Ex-General Secretary') selected @endif>Ex-General Secretary</option>
                            <option value="Election Committee" @if ($advisory->type == 'Election Committee') selected @endif>Election Committee</option>
                            <option value="Internal Audit Committee" @if ($advisory->type == 'Internal Audit Committee') selected @endif>Internal Audit Committee</option>
                        </select>
                        @error('type')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox" name="active" value="1" {{ $advisory->active ? 'checked' : '' }}>
                            <span class="ml-2">Active</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('advisory.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 text-white rounded-md shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">Update Member</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
