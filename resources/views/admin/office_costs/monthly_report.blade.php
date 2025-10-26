<x-app-layout>
    <x-slot name="title">Monthly Cost Report</x-slot>

    {{-- Print Styles --}}
    <style>
        @media print {
            /* Hide non-printable elements */
            .no-print {
                display: none !important;
            }

            /* Remove background colors and shadows */
            body {
                background: white !important;
            }

            .card {
                box-shadow: none !important;
                padding: 0 !important;
                border: none !important;
            }

            /* Ensure table fits on page */
            table {
                font-size: 12px !important;
                width: 100% !important;
            }

            /* Add header and footer for print */
            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            /* Improve table borders for print */
            table, th, td {
                border: 1px solid #ddd !important;
            }

            /* Company info for print */
            .print-header {
                display: block !important;
                text-align: center;
                margin-bottom: 20px;
            }

            /* Page break rules */
            tr {
                page-break-inside: avoid;
            }
        }

        /* Hide print-only elements when not printing */
        .print-header {
            display: none;
        }
    </style>

    <div class="card p-6">
        {{-- Print Header (Only visible when printing) --}}
        <div class="print-header">
            <h1 class="text-2xl font-bold">Company Name</h1>
            <p>Monthly Cost Report - {{ $year }}</p>
            <p>Generated on: {{ now()->format('d M, Y') }}</p>
        </div>
        <!-- Page title and filter -->
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Monthly Cost Report - {{ $year }}</h1>
            <div class="flex items-center space-x-4">
                <form class="flex space-x-2 no-print" action="{{ route('office-costs.monthly-report') }}" method="GET">
                    <div class="flex items-center space-x-2">
                        <select name="year" class="form-select">
                            @php
                                $currentYear = date('Y');
                                for($y = $currentYear; $y >= $currentYear - 5; $y--) {
                                    $selected = $y == $year ? 'selected' : '';
                                    echo "<option value='$y' $selected>$y</option>";
                                }
                            @endphp
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Filter
                        </button>
                    </div>
                </form>
                <button onclick="window.print()" class="no-print inline-flex items-center px-4 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-seagreen hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Report
                </button>
            </div>
        </div>

        <!-- Report Table -->
        <div class=" rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="">
                    <thead class="">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Serial No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Month</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Office Cost</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">File Profit</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider"> Total Profit</th>
                        </tr>
                    </thead>
                    <tbody class=" divide-y">
                        @foreach($report as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $row['serial_no'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $row['month'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">{{ $row['cost'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">{{ $row['total_bill'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">{{ $row['profit'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="">
                        <tr class="font-semibold">
                            <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm">Total</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                {{ number_format(collect($report)->sum(fn($row) => (float)str_replace(',', '', $row['cost'])), 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                {{ number_format(collect($report)->sum(fn($row) => (float)str_replace(',', '', $row['total_bill'])), 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                {{ number_format(collect($report)->sum(fn($row) => (float)str_replace(',', '', $row['profit'])), 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
