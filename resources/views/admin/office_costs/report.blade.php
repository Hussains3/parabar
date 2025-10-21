<x-app-layout>
    <x-slot name="title">Office Cost Report</x-slot>

    <div class="container mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Office Cost Report</h1>
        </div>

        {{-- Advanced Filter Form --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <form action="{{ route('office-costs.report') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- Report Type --}}
                    <div>
                        <label for="report_type" class="block text-sm font-medium text-gray-700">Report Type</label>
                        <select name="report_type" id="report_type" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            onchange="toggleDateInputs(this.value)">
                            <option value="custom" {{ request('report_type', 'custom') == 'custom' ? 'selected' : '' }}>Custom Date Range</option>
                            <option value="monthly" {{ request('report_type') == 'monthly' ? 'selected' : '' }}>Current Month</option>
                            <option value="yearly" {{ request('report_type') == 'yearly' ? 'selected' : '' }}>Current Year</option>
                            <option value="previous_month" {{ request('report_type') == 'previous_month' ? 'selected' : '' }}>Previous Month</option>
                            <option value="previous_year" {{ request('report_type') == 'previous_year' ? 'selected' : '' }}>Previous Year</option>
                        </select>
                    </div>

                    {{-- Date Range --}}
                    <div id="dateRangeInputs" class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" 
                                value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" 
                                value="{{ request('end_date', now()->format('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    {{-- Category Filter --}}
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" id="category_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status Filter --}}
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

                    {{-- Amount Range --}}
                    <div>
                        <label for="min_amount" class="block text-sm font-medium text-gray-700">Min Amount</label>
                        <input type="number" name="min_amount" id="min_amount" 
                            value="{{ request('min_amount') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="max_amount" class="block text-sm font-medium text-gray-700">Max Amount</label>
                        <input type="number" name="max_amount" id="max_amount" 
                            value="{{ request('max_amount') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('office-costs.report') }}" 
                       class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200">
                        Reset Filters
                    </a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Generate Report
                    </button>
                </div>
            </form>
        </div>        @if(isset($summary) && $summary->count() > 0)
            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Total Amount Card --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Total Amount</h3>
                    <p class="text-3xl font-bold text-blue-600">৳ {{ number_format($totalAmount, 2) }}</p>
                </div>
                {{-- Total Transactions Card --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Total Transactions</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $summary->sum('count') }}</p>
                </div>
                {{-- Date Range Card --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Period</h3>
                    <p class="text-lg text-gray-600">
                        {{ \Carbon\Carbon::parse(request('start_date'))->format('M d, Y') }} -
                        {{ \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') }}
                    </p>
                </div>
            </div>

            {{-- Category-wise Summary Table --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Category-wise Summary</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Transactions</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">% of Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($summary as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->category->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            {{ $item->count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            ৳ {{ number_format($item->total_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            {{ number_format(($item->total_amount / $totalAmount) * 100, 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- Total Row --}}
                                <tr class="bg-gray-50 font-semibold">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Total</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                        {{ $summary->sum('count') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        ৳ {{ number_format($totalAmount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">100%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Charts Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                {{-- Category Distribution Chart --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Cost Distribution by Category</h2>
                    <div class="h-80">
                        <canvas id="costDistributionChart"></canvas>
                    </div>
                </div>

                {{-- Monthly Trends Chart --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Monthly Cost Trends</h2>
                    <div class="h-80">
                        <canvas id="monthlyTrendsChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Export Options --}}
            <div class="mt-6 flex justify-end space-x-4">
                <button onclick="window.print()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200">
                    Print Report
                </button>
                <a href="#" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                    Export to Excel
                </a>
            </div>

            @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Toggle date inputs based on report type
                function toggleDateInputs(value) {
                    const dateInputs = document.getElementById('dateRangeInputs');
                    dateInputs.style.display = value === 'custom' ? 'grid' : 'none';
                }

                document.addEventListener('DOMContentLoaded', function() {
                    // Initialize with current selection
                    toggleDateInputs(document.getElementById('report_type').value);

                    // Category Distribution Chart
                    const ctxDistribution = document.getElementById('costDistributionChart').getContext('2d');
                    new Chart(ctxDistribution, {
                        type: 'doughnut',
                        data: {
                            labels: {!! json_encode($summary->pluck('category.name')->unique()) !!},
                            datasets: [{
                                data: {!! json_encode($summary->groupBy('category_id')->map->sum('total_amount')->values()) !!},
                                backgroundColor: [
                                    '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#6366F1',
                                    '#EC4899', '#8B5CF6', '#14B8A6', '#F97316', '#06B6D4'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right'
                                }
                            }
                        }
                    });

                    // Monthly Trends Chart
                    const ctxTrends = document.getElementById('monthlyTrendsChart').getContext('2d');
                    new Chart(ctxTrends, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($monthlyTrends->pluck('month')) !!},
                            datasets: [{
                                label: 'Monthly Total',
                                data: {!! json_encode($monthlyTrends->pluck('total_amount')) !!},
                                borderColor: '#3B82F6',
                                tension: 0.1,
                                fill: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return '৳ ' + value.toLocaleString();
                                        }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return '৳ ' + context.parsed.y.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
            @endpush
        @else
            {{-- No Data State --}}
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <p class="text-gray-500">No cost data available for the selected period.</p>
            </div>
        @endif
    </div>
</x-app-layout>
