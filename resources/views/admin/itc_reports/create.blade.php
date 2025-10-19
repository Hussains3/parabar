<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">ITC Reports</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card p-6">
            <form action="{{ route('itc-reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex justify-center items-end gap-5">

                    <div class="flex items-center gap-2">
                        <label for="name" class="block mb-2">Name:</label>
                        <input type="text" name="name" id="name" class="form-input" required>
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="type" class="block mb-2">Type:</label>
                        <select class="form-select" name="type" id="type" required>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                        
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="file" class="block mb-2">PDF:</label>
                        <input type="file" name="file" id="file" class="form-input" required>
                    </div>
                    <div class="lg:col-span-2 mt-3">
                        <button type="submit"
                            class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white">Save</button>
                    </div> <!-- end button -->
                </div>
            </form>
        </div> <!-- end card -->
        <div class="card p-6">
            <table class="table w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Link</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($reports as $report)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ $report->file_link }}" 
                                    target="_blank" 
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">
                                    View PDF
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <a href="{{ route('itc-reports.edit', $report->id) }}" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                        Edit
                                    </a>
                                    <form action="{{ route('itc-reports.destroy', $report->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    </div>


    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $("form #name").on('blur', () => {
                    const slug = slugify($("form #name").val());
                    $("form #slug").val(slug);
                });
            });
        </script>
    </x-slot>
</x-app-layout>
