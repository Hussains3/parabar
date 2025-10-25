<x-app-layout>
    <x-slot name="title">Office Costs</x-slot>

    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Office Costs</h1>
            <a href="{{ route('office-costs.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Cost
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <form action="{{ route('office-costs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category" id="category"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="md:col-span-4 flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Costs Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($officeCosts as $cost)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $cost->cost_date}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $cost->category->name }}</td>
                            <td class="px-6 py-4">{{ $cost->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($cost->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $cost->status === 'approved' ? 'bg-green-100 text-green-800' :
                                       ($cost->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($cost->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('office-costs.edit', $cost) }}"
                                class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>

                                <form method="POST" action="{{ route('office-costs.destroy', $cost) }}" class="inline"
                                    onsubmit="const btn = this.querySelector('button'); btn.disabled = true; btn.innerText = 'Deleting...'; return confirm('Are you sure you want to delete this cost?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-transparent border-none cursor-pointer font-medium">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $officeCosts->links() }}
        </div>
    </div>
</x-app-layout>
