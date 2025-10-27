<x-app-layout>

    {{-- Title --}}
    <x-slot name="title">Daily Costs</x-slot>
    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>
        {{-- Page Content --}}
    <div class="flex gap-4">
        <div class="card p-6 print:hidden">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                    {{ isset($officeCost) ? 'Edit Office Cost' : 'Create New Office Cost' }}
                </h2>
                <a href="{{route('office-costs.index')}}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">All Cost</a>
            </div>

            <form method="POST" action="{{ route('office-costs.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($officeCost))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Cost Category --}}
                    <div class="col-span-2">
                        <label for="cost_category_id" class="block text-sm font-medium text-gray-700">Cost Category</label>
                        <select name="cost_category_id" id="cost_category_id" required
                            class="form-input">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
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
                            value="{{date('Y-m-d')}}" class="form-input">
                        @error('cost_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                        <input type="number" name="amount" id="amount" step="0.01" min="0" required class="form-input">
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <input type="text" name="description" id="description"
                            value="{{ old('description', $officeCost->description ?? '') }}"
                            class="form-input">
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        {{ isset($officeCost) ? 'Update' : 'Create' }} Office Cost
                    </button>
                </div>
            </form>
        </div>

        <div class="card flex-grow printable">
            <div class="p-6">
                {{--  --}}
                <div class="flex justify-between items-center mb-6">
                    <div class="mb-4">
                        <h1 class="text-xl">Daily cost <span class="text-md">({{$totalAmount."Taka"}})</span></h1>
                        <p class="text-seagreen">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</p>
                    </div>
                    <div class="">

                        <form action="{{ route('office-costs.dailycost') }}" method="GET" class="flex print:hidden justify-center items-center gap-4">
                            <div class="flex justify-start items-center gap-4">
                                <label for="start_date" class="block ">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{$date}}"
                                    class="mform-input">
                            </div>

                            <div class="md:col-span-4 flex justify-end">
                                <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white">
                                    Apply Filters
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Costs Table -->
                <div class="rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y ">
                        <thead class="">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Sirial Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class=" divide-y ">
                            @foreach ($dailyCosts as $cost)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->index+1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $cost->cost_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $cost->category->name }}</td>
                                    <td class="px-6 py-4">{{ $cost->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($cost->amount, 2) }} TK</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                {{-- Spanning 4 columns to align the label and value correctly --}}
                                <td colspan="4" class="px-6 py-4 text-right font-bold tracking-wider">Total Cost:</td>

                                {{-- Use $dailyCosts->sum('amount') to calculate the total --}}
                                <td class="px-6 py-4 whitespace-nowrap font-bold">
                                    {{ number_format($dailyCosts->sum('amount'), 2) }} TK
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                {{--  --}}
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
        </script>
    </x-slot>
</x-app-layout>
