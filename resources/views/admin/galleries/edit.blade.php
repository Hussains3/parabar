<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit Gallery Image</x-slot>

    {{-- Add toastr CSS --}}
    <x-slot name="styles">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="card p-6">
            <div class="card-header">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-xl font-semibold text-gray-800">Edit Gallery Image</h4>
                    <a href="{{ route('galleries.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">Back to List</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" id="editGalleryForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $gallery->id }}">

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-violet-300 focus:ring focus:ring-violet-200 focus:ring-opacity-50" id="title" name="title" value="{{ $gallery->title }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" class="w-full rounded-md border-gray-300 shadow-sm focus:border-violet-300 focus:ring focus:ring-violet-200 focus:ring-opacity-50" id="image" name="image" accept="image/*">
                        <div class="mt-2">
                            <img src="{{ asset($gallery->image) }}" alt="Current Image" class="max-h-24 rounded shadow">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea class="w-full rounded-md border-gray-300 shadow-sm focus:border-violet-300 focus:ring focus:ring-violet-200 focus:ring-opacity-50" id="description" name="description" rows="3">{{ $gallery->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Order</label>
                        <input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-violet-300 focus:ring focus:ring-violet-200 focus:ring-opacity-50" id="order" name="order" value="{{ $gallery->order }}" min="0">
                    </div>

                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-violet-600 shadow-sm focus:border-violet-300 focus:ring focus:ring-violet-200 focus:ring-opacity-50" id="active" name="active" {{ $gallery->active ? 'checked' : '' }} value="1">
                            <span class="ml-2 text-sm text-gray-600">Active</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-2 mt-4">
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 text-white rounded-md shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="script">
        {{-- Add jQuery and toastr JS --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#editGalleryForm').on('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);

                    $.ajax({
                        url: $(this).attr('action'),
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            window.location.href = "{{ route('galleries.index') }}";
                            toastr.success('Gallery image updated successfully');
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        }
                    });
                });
            });
        </script>
    </x-slot>

</x-app-layout>
