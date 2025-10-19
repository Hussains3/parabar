<x-app-layout>
    <x-slot name="title">Record Fee Payment</x-slot>

    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-4">Record Fee Payment for {{ $agent->name }}</h2>

                <form action="{{ route('agents.fees.store', $agent) }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <!-- Fee Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Fee Type</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                                <option value="member_fee">Member Fee</option>
                                <option value="welfare_fund">Welfare Fund</option>
                            </select>
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">৳</span>
                                </div>
                                <input type="number" name="amount" id="amount" step="0.01" value="{{ old('amount') }}" 
                                    class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                            </div>
                        </div>

                        <!-- Fee For Month -->
                        <div>
                            <label for="fee_for_month" class="block text-sm font-medium text-gray-700">Fee For Month</label>
                            <input type="date" name="fee_for_month" id="fee_for_month" value="{{ old('fee_for_month') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <!-- Payment Date -->
                        <div>
                            <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', now()->format('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <!-- Transaction ID -->
                        <div>
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700">Transaction ID</label>
                            <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <!-- Remarks -->
                        <div>
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">{{ old('remarks') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <a href="{{ route('agents.show', $agent) }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                        <button type="submit" class="bg-violet-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-600">
                            Record Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>