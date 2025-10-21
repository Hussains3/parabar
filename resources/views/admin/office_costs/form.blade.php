<x-app-layout>
    <x-slot name="title">{{ isset($officeCost) ? 'Edit Office Cost' : 'Create Office Cost' }}</x-slot>

    <div class="container mx-auto px-4 py-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                        {{ isset($officeCost) ? 'Edit Office Cost' : 'Create New Office Cost' }}
                    </h2>

                    <form method="POST"
                          action="{{ isset($officeCost) ? route('office-costs.update', $officeCost) : route('office-costs.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @if(isset($officeCost))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Cost Category --}}
                            <div class="col-span-2">
                                <label for="cost_category_id" class="block text-sm font-medium text-gray-700">Cost Category</label>
                                <select name="cost_category_id" id="cost_category_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('cost_category_id', $officeCost->cost_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cost_category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Cost Date --}}
                            <div>
                                <label for="cost_date" class="block text-sm font-medium text-gray-700">Cost Date</label>
                                <input type="date" name="cost_date" id="cost_date" required
                                    value="{{ old('cost_date', isset($officeCost) ? $officeCost->cost_date->format('Y-m-d') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('cost_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Amount --}}
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="number" name="amount" id="amount" step="0.01" min="0" required
                                    value="{{ old('amount', $officeCost->amount ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" name="description" id="description" required
                                    value="{{ old('description', $officeCost->description ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Notes --}}
                            <div class="col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $officeCost->notes ?? '') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Attachment --}}
                            {{-- <div class="col-span-2">
                                <label for="attachment" class="block text-sm font-medium text-gray-700">
                                    Attachment (PDF, JPG, JPEG, PNG - max 2MB)
                                </label>
                                <input type="file" name="attachment" id="attachment"
                                    class="mt-1 block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100">
                                @error('attachment')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @if(isset($officeCost) && $officeCost->attachment_path)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">Current attachment:
                                            <a href="{{ Storage::url($officeCost->attachment_path) }}"
                                               target="_blank"
                                               class="text-blue-600 hover:text-blue-800">
                                                View File
                                            </a>
                                        </p>
                                    </div>
                                @endif
                            </div> --}}

                            @if(isset($officeCost))
                                {{-- Status --}}
                                <div class="col-span-2">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="pending" {{ old('status', $officeCost->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ old('status', $officeCost->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ old('status', $officeCost->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('office-costs.index') }}"
                               class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                {{ isset($officeCost) ? 'Update' : 'Create' }} Office Cost
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
