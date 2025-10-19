<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Agents</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex gap-6">


        {{-- Table --}}
        <div class="card w-full">
            <div class="p-6 flex">
                <div class="container mx-auto px-4 py-8 flex-grow">
                    <!-- Page Heading -->
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Notices</h1>

                    <!-- Notices List -->
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($notices as $notice)
                                    <tr>
                                        <!-- File Name -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $notice }}</div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex space-x-4">
                                                <!-- View Button -->
                                                <a href="{{ route('notices.show', $notice) }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                                    </svg>
                                                </a>

                                                <!-- Download Button -->
                                                <a href="{{ route('notices.show', $notice) }}" download class="text-green-500 hover:text-green-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('notices.destroy', $notice) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this notice?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <!-- Empty State -->
                                    <tr>
                                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                                            No notices found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="container mx-auto px-4 py-8">
                    <!-- Page Heading -->
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Upload Notice</h1>

                    <!-- Form -->
                    <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6">
                        <form action="{{ route('notices.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- File Input -->
                            <div class="mb-6">
                                <label for="notice" class="block text-sm font-medium text-gray-700">Choose a PDF file</label>
                                <div class="mt-1">
                                    <input type="file" name="notice" id="notice" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                                @error('notice')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->

                            <div class="flex-end">
                                <button type="submit"
                                    class="font-mont mt-2 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300"
                                    id="baccountSaveBtn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <x-slot name="script">

    </x-slot>
</x-app-layout>
