<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Gallery</x-slot>

    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-4">
        <div class="container-fluid">
            <div class="card p-6">
                <div class="card-header">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-xl font-semibold text-gray-800">Gallery Images</h4>
                        <a href="{{ route('galleries.create') }}" class="px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 text-white rounded-md shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">Add New Image</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="relative overflow-x-auto">
                        <table id="galleryTable" class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-white uppercase bg-gradient-to-r from-violet-400 to-purple-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Title</th>
                                    <th scope="col" class="px-6 py-3">Image</th>
                                    <th scope="col" class="px-6 py-3">Description</th>
                                    <th scope="col" class="px-6 py-3">Order</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                var table = $('#galleryTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('galleries.index') }}",
                    columns: [
                        { data: 'title', name: 'title' },
                        {
                            data: 'image',
                            name: 'image',
                            render: function(data) {
                                return `<img src="${data}" alt="Gallery Image" class="max-h-[50px] rounded-lg border border-gray-200 shadow-sm">`;
                            }
                        },
                        { data: 'description', name: 'description' },
                        { data: 'order', name: 'order' },
                        {
                            data: 'active',
                            name: 'active',
                            render: function(data) {
                                return data ? 
                                    '<span class="px-2 py-1 bg-green-100 text-green-600 rounded">Active</span>' : 
                                    '<span class="px-2 py-1 bg-red-100 text-red-600 rounded">Inactive</span>';
                            }
                        },
                        {
                            data: 'id',
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `
                                    <div class="flex gap-2">
                                        <a href="/galleries/${data}/edit" class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition-colors">Edit</a>
                                        <button class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition-colors delete-btn" data-id="${data}">Delete</button>
                                    </div>
                                `;
                            }
                        }
                    ]
                });

                // Delete Gallery
                $('#galleryTable').on('click', '.delete-btn', function() {
                    var id = $(this).data('id');
                    if (confirm('Are you sure you want to delete this gallery image?')) {
                        $.ajax({
                            url: "{{ route('galleries.index') }}/" + id,
                            type: "DELETE",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                table.ajax.reload();
                                toastr.success('Gallery image deleted successfully');
                            },
                            error: function(xhr) {
                                toastr.error('Error deleting gallery image');
                            }
                        });
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
