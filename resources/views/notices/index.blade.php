<x-guest-layout>

    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    <main>
        <section>
            <div class="bg-gradient-to-r from-violet-400 to-purple-300 py-8">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl font-bold text-center text-gray-800">Notice Board</h1>
                </div>
            </div>
            <div class="max-w-7xl mx-auto py-10">
                <div class="container mx-auto px-4 py-8">

                    @role('admin')
                    {{-- Notice Create Form --}}
                    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                        <h2 class="text-xl font-bold mb-4">Create New Notice</h2>
                        <form action="{{ route('notices.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Title -->
                                <div class="md:col-span-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                    <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                </div>

                                <!-- File -->
                                <div>
                                    <label for="file" class="block text-sm font-medium text-gray-700">File (PDF)</label>
                                    <input type="file" name="file" id="file" accept="application/pdf" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                </div>

                                <!-- Publish Date -->
                                <div>
                                    <label for="publish_date" class="block text-sm font-medium text-gray-700">Publish Date</label>
                                    <input type="date" name="publish_date" id="publish_date" class="mt-1 block w-full file:border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                </div>

                                {{-- <!-- Archive Date -->
                                <div>
                                    <label for="archive_date" class="block text-sm font-medium text-gray-700">Archive Date</label>
                                    <input type="date" name="archive_date" id="archive_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                </div> --}}

                                {{-- <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        <option value="active">Active</option>
                                        <option value="archived">Archived</option>
                                    </select>
                                </div> --}}
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Create Notice
                                </button>
                            </div>
                        </form>
                    </div>
                    @endrole

                    <!-- Notices List -->
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <table id="noticesTable" class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Publish Date</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($notices as $notice)
                                    <tr>
                                        <!-- Serial No -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $loop->iteration }}</div>
                                        </td>
                                        <!-- Title -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{route('notices.show', $notice->id)}}" class="text-sm text-gray-900 hover:text-blue-700 hover:text-base transition duration-300">
                                                <div class="text-sm font-medium ">{{ $notice->title }}</div>
                                            </a>
                                        </td>

                                        <!-- Publish Date -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm text-gray-500">
                                                {{$notice->publish_date }}
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex space-x-4 justify-end items-center">
                                                <!-- Download Button -->
                                                <a href="{{ $notice->file_link }}" download class="text-green-500 hover:text-green-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                </a>
                                                @role('admin')

                                                <!-- Delete Button -->
                                                <form action="{{ route('notices.destroy', $notice) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this notice?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endrole
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <!-- Empty State -->
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            No notices found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-slot name="scripts">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#noticesTable').DataTable();
            });
        </script>
    </x-slot>

</x-guest-layout>
