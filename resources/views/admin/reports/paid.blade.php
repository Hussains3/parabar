<x-app-layout>
    <x-slot name="title">Daily Paid Files Report</x-slot>

    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        {{-- Date Filter and Print Button --}}
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="p-4">
                <div class="flex items-end justify-between gap-4">
                    <div class="flex-1">
                        <label for="date" class="block text-sm font-medium text-gray-700">Select Date</label>
                        <input type="text" id="date" name="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $targetDate }}">
                    </div>
                    <div>
                        <button onclick="printStats()" class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print Statistics
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <!-- Total Paid IM Files Card -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                <h3 class="text-gray-500 text-sm font-medium">Total IM Files Fees</h3>
                <div class="mt-2 flex items-baseline">
                    <p class="text-2xl font-semibold text-gray-900">৳{{ number_format($statistics['total_paid_im'], 2) }}</p>
                </div>
            </div>

            <!-- Total Paid EX Files Card -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                <h3 class="text-gray-500 text-sm font-medium">Total EX Files Fees</h3>
                <div class="mt-2 flex items-baseline">
                    <p class="text-2xl font-semibold text-gray-900">৳{{ number_format($statistics['total_paid_ex'], 2) }}</p>
                </div>
            </div>

            <!-- Total Files Count Card -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                <h3 class="text-gray-500 text-sm font-medium">Total Paid Files</h3>
                <div class="mt-2 flex items-baseline">
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($statistics['total_paid_files']) }}</p>
                </div>
            </div>

            <!-- Total Amount Card -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                <h3 class="text-gray-500 text-sm font-medium">Total Fees Collected</h3>
                <div class="mt-2 flex items-baseline">
                    <p class="text-2xl font-semibold text-gray-900">৳{{ number_format($statistics['total_paid_amount'], 2) }}</p>
                </div>
            </div>
        </div>



        {{-- DataTable --}}
        <div class="bg-white shadow rounded-lg">
            <div class="p-4">
                <table id="paidFilesTable" class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Agent Name</th>
                            <th>AIN No</th>
                            <th>BE No</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Fees</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="script">
        {{-- Datatable js --}}
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            $(document).ready(function() {
                // Initialize date picker
                const datePicker = flatpickr("#date", {
                    dateFormat: "Y-m-d",
                    onChange: function(selectedDates, dateStr, instance) {
                        // Reload the page with the new date
                        window.location.href = "{{ route('reports.paid') }}?date=" + dateStr;
                    }
                });

                // Initialize DataTable
                $('#paidFilesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('reports.paid') }}",
                        data: function(d) {
                            d.date = $('#date').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'agent_name', name: 'agent_name'},
                        {data: 'agent_ain', name: 'agent_ain'},
                        {data: 'be_number', name: 'be_number'},
                        {data: 'date', name: 'date'},
                        {data: 'type', name: 'type'},
                        {data: 'fees', name: 'fees'}
                    ],
                    order: [[4, 'desc']]
                });
            });
        </script>
    </x-slot>

    {{-- Print Template --}}
    <div id="print-template" class="hidden print:block">
        <div class="print-section p-8" >
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold">Daily Paid Files Report</h1>
                <p class="text-gray-600">Date: <span id="print-date"></span></p>
            </div>
            <div class="flex justify-between items-center gap-6">
                <div class="border p-4 rounded">
                    <h3 class="font-semibold text-gray-800">IM Files Total</h3>
                    <p class="text-xl">৳<span id="print-im"></span></p>
                </div>
                <div class="border p-4 rounded">
                    <h3 class="font-semibold text-gray-800">EX Files Total</h3>
                    <p class="text-xl">৳<span id="print-ex"></span></p>
                </div>
                <div class="border p-4 rounded">
                    <h3 class="font-semibold text-gray-800">Total Files</h3>
                    <p class="text-xl"><span id="print-files"></span></p>
                </div>
                <div class="border p-4 rounded">
                    <h3 class="font-semibold text-gray-800">Total Collection</h3>
                    <p class="text-xl">৳<span id="print-total"></span></p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body  {
                visibility: hidden;
            }
            #print-template {
                visibility: visible !important;
                text-align: center !important;
            }
            #print-template {
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
            }
            @page {
                size: auto;
                margin: 1cm;
            }
        }
    </style>

    <script>
        function printStats() {
            // Update print template with current values
            document.getElementById('print-date').textContent = document.getElementById('date').value;
            document.getElementById('print-im').textContent = '{{ number_format($statistics['total_paid_im'], 2) }}';
            document.getElementById('print-ex').textContent = '{{ number_format($statistics['total_paid_ex'], 2) }}';
            document.getElementById('print-files').textContent = '{{ number_format($statistics['total_paid_files']) }}';
            document.getElementById('print-total').textContent = '{{ number_format($statistics['total_paid_amount'], 2) }}';

            // Show the print section
            document.querySelector('.print-section').style.display = 'block';

            // Print after a small delay to ensure content is visible
            setTimeout(function() {
                window.print();
                // Hide the print section again after printing
                setTimeout(function() {
                    document.querySelector('.print-section').style.display = 'none';
                }, 1000);
            }, 100);
        }
    </script>
</x-app-layout>
