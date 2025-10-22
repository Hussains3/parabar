<x-app-layout>

    {{-- Title --}}
    <x-slot name="title">Daily Costs</x-slot>
    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>
        {{-- Page Content --}}
    <div class="flex flex-col gap-4">

        <div class="card w-full">
            <div class="p-6">
                {{--  --}}
                <div class="flex justify-between items-center mb-6">
                    <h1 class="mb-4 text-xl">Daily Costs ({{$date}})</h1>
                    <form action="{{ route('office-costs.dailycost') }}" method="GET" class="flex justify-center items-center gap-4">
                        <div class="flex justify-start items-center gap-4">
                            <label for="start_date" class="block ">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                class="mform-input">
                        </div>

                        <div class="md:col-span-4 flex justify-end">
                            <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Costs Table -->
                <div class="rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y ">
                        <thead class="">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Sirial Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class=" divide-y ">
                            @foreach ($dailyCosts as $cost)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->index+1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $cost->category->name }}</td>
                                    <td class="px-6 py-4">{{ $cost->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($cost->amount, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td >
                                    <div class="flex justify-between items-center">

                                        <label for="initial_cost_category_id" class="block">Category</label>
                                        <select name="initial_cost_category_id" id="initial_cost_category_id" required
                                            class="form-select">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex justify-between items-center">

                                        <label for="initial_description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <input type="text" name="initial_description" id="initial_description" class="form-input">
                                    </div>

                                </td>
                                <td class="flex justify-between items-end">
                                    <div class="flex justify-between items-center">

                                        <div class="flex justify-between items-center">

                                            <label for="initial_amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                            <input type="number" name="initial_amount" id="initial_amount" step="0.01" min="0" required  class="form-input">
                                        </div>
                                        <button type="submit" class="block text-center px-4 py-0.5 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white"
                                            id="formsubmitbtn">Add</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <form action="{{route('office-costs.store')}}" method="post" id="submitableform">
                        @csrf
                        <input type="hidden" name="cost_category_id">
                        <input type="hidden" name="description">
                        <input type="hidden" name="amount" >
                        <input type="hidden" name="cost_date" value="{{$date}}">

                    </form>
                </div>
                {{--  --}}
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            // Handle the Add button click with jquery
            $(document).ready(function() {
                $('#formsubmitbtn').click(function(event) {
                    event.preventDefault(); // Prevent the default form submission
                    // Get values from the input fields
                    var categoryId = $('#initial_cost_category_id').val();
                    var description = $('#initial_description').val();
                    var amount = $('#initial_amount').val();

                    //Make sure categoryId and amount are provided
                    if(!categoryId || !amount){
                        alert('Please provide both category and amount.');
                        return;
                    }else{

                        // Set the values in the hidden form
                        var form = $('#submitableform');
                        form.find('input[name="cost_category_id"]').val(categoryId);
                        form.find('input[name="description"]').val(description);
                        form.find('input[name="amount"]').val(amount);
                        // Submit the hidden form
                        form.submit();
                    }


                });
            });
        </script>
    </x-slot>
</x-app-layout>
