<x-app-layout>
    <x-slot name="title">{{ isset($costCategory) ? 'Edit Category' : 'Create Category' }}</x-slot>

    <div class="container mx-auto px-4 py-6">
        <div class="max-w-lg mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                        {{ isset($costCategory) ? 'Edit Category' : 'Create New Category' }}
                    </h2>

                    <form method="POST" action="{{ isset($costCategory) ? route('cost-categories.update', $costCategory) : route('cost-categories.store') }}">
                        @csrf
                        @if(isset($costCategory))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="{{ old('name', $costCategory->name ?? '') }}" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $costCategory->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $costCategory->is_active ?? true) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Active</span>
                            </label>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('cost-categories.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 mr-2">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                                {{ isset($costCategory) ? 'Update Category' : 'Create Category' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
