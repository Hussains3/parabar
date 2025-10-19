<x-app-layout>
    <x-slot name="title">Advisory Committee Members</x-slot>

    <x-slot name="headerstyle">
        {{-- Datatable CSS --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    </x-slot>

    <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-xl font-semibold text-gray-800">Advisory Committee Members</h4>
                <div class="flex gap-2">
                    <a href="{{ route('advisory.create') }}" class="px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 text-white rounded-md shadow-md hover:shadow-lg transition-all duration-200">Add New Member</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table id="advisory-table" class="display stripe text-sm" style="width:100%">
                    <thead class="bg-gradient-to-r from-violet-400 to-purple-300 text-white">
                        <tr>
                            <th class="p-3 text-left">Photo</th>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">Designation</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">Phone</th>
                            <th class="p-3 text-left">Office</th>
                            <th class="p-3 text-left">Type</th>
                            <th class="p-3 text-left">Order</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="script">
        {{-- Datatable Script --}}
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                var table = $('#advisory-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('advisory.index') }}",
                    columns: [
                        {
                            data: 'photo',
                            name: 'photo',
                            orderable: false,
                            render: function(data) {
                                if (data) {
                                    return `<img src="${data}" class="w-12 h-12 rounded-full object-cover"/>`;
                                }
                                return `<img src="/images/placeholder.jpg" class="w-12 h-12 rounded-full object-cover"/>`;
                            }
                        },
                        { data: 'name', name: 'name' },
                        { data: 'designation', name: 'designation' },
                        { data: 'email', name: 'email' },
                        { data: 'phone', name: 'phone' },
                        { 
                            data: 'officename',
                            render: function(data, type, row) {
                                return data + '<br/>' + (row.officeaddress || '');
                            }
                        },
                        { data: 'type', name: 'type' },
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
                            render: function(data) {
                                return `
                                    <div class="flex gap-2 justify-end">
                                        <a href="/advisory/${data}/edit" class="text-blue-500 hover:text-blue-700">
                                            <i class="mdi mdi-pencil text-xl"></i>
                                        </a>
                                        <button onclick="deleteAdvisory(${data})" class="text-red-500 hover:text-red-700">
                                            <i class="mdi mdi-delete text-xl"></i>
                                        </button>
                                    </div>
                                `;
                            }
                        }
                    ]
                });
            });

            function deleteAdvisory(id) {
                if (confirm('Are you sure you want to delete this member?')) {
                    $.ajax({
                        url: `/advisory/${id}`,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#advisory-table').DataTable().ajax.reload();
                            alert(response.success);
                        },
                        error: function(xhr) {
                            alert('Error deleting member');
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
