<x-app-layout>
    <x-slot name="title">Unpaid Customs Files Report</x-slot>

    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable CSS --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
        <style>
            @media print {
                table td {
                    border: 1px solid #000 !important;
                }

            }
        </style>
    </x-slot>

    <div class="container mx-auto px-4 py-6">


        {{-- Agents Table --}}
        <div class="bg-white rounded-lg shadow-md printdiv">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4 print:hidden">
                    <h2 class="text-2xl font-bold mb-6">Agents with Unpaid Files</h2>
                    <button class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white" id="printbutton">Print</button>
                </div>
                <h2 class="text-2xl font-bold mb-6 text-center hidden print:block">Unpaid Customs Files Report </h2>
                {{-- Statistics Cards --}}
                <div class="flex justify-center items-center gap-6 mb-6">
                    <!-- Total Unpaid Files -->
                    <div class="flex justify-between items-center gap-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Unpaid Files</h3>
                        <p class="text-lg font-bold text-red-600">{{ $statistics['total_unpaid'] }}</p>
                    </div>

                    <!-- Total Unpaid IM Files -->
                    <div class="flex justify-between items-center gap-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Unpaid IM Files</h3>
                        <p class="text-lg font-bold text-orange-600">{{ $statistics['total_unpaid_im'] }}</p>
                    </div>

                    <!-- Total Unpaid EX Files -->
                    <div class="flex justify-between items-center gap-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Unpaid EX Files</h3>
                        <p class="text-lg font-bold text-yellow-600">{{ $statistics['total_unpaid_ex'] }}</p>
                    </div>

                    <!-- Total Unpaid EX Files -->
                    <div class="flex justify-between items-center gap-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Total </h3>
                        <p class="text-lg font-bold text-yellow-600">{{ '৳ '.$statistics['total_due'] }}</p>
                    </div>

                </div>

                <table id="unpaidTable" class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unpaid IM Files</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unpaid EX Files</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Unpaid Files</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount Due</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- Datatable Script --}}
    <x-slot name="script">
        <!-- Datatable Scripts -->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

        <script>
            // Print Function
            function printDiv() {
                var printContents = document.querySelector('.printdiv').innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = `
                    <div class="p-4">
                        <style>
                            @media print {
                                table { width: 100%; }
                                th, td { padding: 8px; text-align: left; }
                                th { background-color: #f3f4f6 !important; }
                                .buttons-pdf, .buttons-excel, #unpaidTable_filter { display: none; }
                                thead { display: table-header-group; }
                                tfoot { display: table-footer-group; }
                                @page { size: landscape; }
                            }
                        </style>
                        ${printContents}
                    </div>
                `;

                window.print();
                document.body.innerHTML = originalContents;
                // Reinitialize DataTable after printing
                $('#unpaidTable').DataTable({
                    // ... same options will be reinitialized by the code below
                });
            }

            // Attach print function to button
            document.getElementById('printbutton').addEventListener('click', printDiv);

            $(document).ready(function() {
                $('#unpaidTable').DataTable({
                    processing: false,
                    serverSide: false,
                    paging: false,
                    dom: 'Bfrti',
                    buttons: [
                        {
                            extend: 'pdf',
                            title: 'Unpaid Customs Files Report',
                            footer: true
                        },
                        {
                            extend: 'excel',
                            title: 'Unpaid Customs Files Report',
                            footer: true
                        }
                    ],
                    ajax: "{{ route('reports.unpaid') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'name', name: 'name' },
                        { data: 'unpaid_im_count', name: 'unpaid_im_count' },
                        { data: 'unpaid_ex_count', name: 'unpaid_ex_count' },
                        { data: 'total_unpaid_count', name: 'total_unpaid_count' },
                        { data: 'total_unpaid_amount', name: 'total_unpaid_amount' }
                    ],
                    order: [[1, 'asc']],
                    createdRow: function(row, data, dataIndex) {
                        $(row).addClass('hover:bg-gray-50 transition-colors duration-150 ease-in-out');
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
