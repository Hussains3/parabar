<x-app-layout>
    <x-slot name="title">Edit Fee Payment</x-slot>

    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-4">Edit Fee Payment for {{ $agent->name }}</h2>

                <form action="{{ route('agents.fees.update', ['agent' => $agent->id, 'fee' => $fee->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">৳</span>
                                </div>
                                <input type="number" name="amount" id="amount" step="0.01" value="{{ old('amount', $fee->amount) }}" 
                                    class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                            </div>
                        </div>

                        <!-- Fee For Month -->
                        <div>
                            <label for="fee_for_month" class="block text-sm font-medium text-gray-700">Fee For Month</label>
                            <input type="date" name="fee_for_month" id="fee_for_month" value="{{ old('fee_for_month', $fee->fee_for_month->format('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <!-- Payment Date -->
                        <div>
                            <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', $fee->payment_date->format('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method', $fee->payment_method) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <!-- Transaction ID -->
                        <div>
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700">Transaction ID</label>
                            <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id', $fee->transaction_id) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                                <option value="paid" {{ old('status', $fee->status) === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="pending" {{ old('status', $fee->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>

                        <!-- Remarks -->
                        <div>
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">{{ old('remarks', $fee->remarks) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between gap-x-6">
                        <form action="{{ route('agents.fees.destroy', ['agent' => $agent->id, 'fee' => $fee->id]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this payment record?')">
                                Delete Payment
                            </button>
                        </form>
                        
                        <div class="flex gap-x-4">
                            <a href="{{ route('agents.show', $agent) }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                            <button type="submit" class="bg-violet-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-600">
                                Update Payment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>