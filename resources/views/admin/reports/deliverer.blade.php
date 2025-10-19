<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Delivery Report</x-slot>

    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable CSS --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">
        {{-- Table --}}
        <div class="card w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl">Delivery Report</h2>
                    <div class="p-4 shadow-md rounded-lg bg-slate-100 w-3/4">
                        <form action="" method="get">
                            @csrf
                            @method('GET')
                            <div class="flex justify-between items-center gap-4">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Lodgement Date</label>
                                    <div id="reportrange" class="bg-white cursor-pointer px-4 py-2 border border-gray-300 rounded-md w-full">
                                        <i class="mdi mdi-calendar-clock text-green-400"></i>&nbsp;
                                        <span></span> <i class="mdi mdi-arrow-down"></i>
                                    </div>
                                    <input type="hidden" id="from_date" name="from_date">
                                    <input type="hidden" id="to_date" name="to_date">
                                </div>

                                {{-- Select Agent --}}
                                <div class="flex-1">
                                    <label for="agent_id" class="block text-sm font-medium text-gray-700 mb-1">Select Agent</label>
                                    <select name="agent_id" id="agent_id" class="form-select rounded-md w-full">
                                        <option value="">All Agents</option>
                                        @foreach ($agents as $agent)
                                            <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->ain_no }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex items-end gap-2">
                                    <button type="button" name="filter" id="filter" class="px-4 py-2 bg-green-600 text-white font-semibold text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all">
                                        <i class="mdi mdi-filter-outline mr-1"></i>Search
                                    </button>
                                    <button type="button" name="refresh" id="refresh" class="px-4 py-2 bg-gray-600 text-white font-semibold text-sm rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all">
                                        <i class="mdi mdi-refresh mr-1"></i>Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Table Start --}}
                <div class="overflow-x-auto">
                    <table id="all_report" class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manifest No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">B/E No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manifest Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <!-- Datatable Scripts -->
        <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script>
            $(function() {
                // Date Range Picker Initialization
                var start = moment().startOf('month');
                var end = moment().endOf('month');

                function cb(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#from_date').val(start.format('YYYY-MM-DD'));
                    $('#to_date').val(end.format('YYYY-MM-DD'));
                }

                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                        'This Year': [moment().startOf('year'), moment().endOf('year')]
                    }
                }, cb);

                cb(start, end);

                // Initialize DataTable
                function load_data(from_date = '', to_date = '', agent_id = '') {
                    $('#all_report').DataTable({
                        processing: true,
                        serverSide: true,
                        paging: false,
                        destroy: true,
                        dom: '<"flex justify-between items-center mb-4"lB>rtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                        buttons: [
                            {
                                extend: 'excel',
                                text: '<i class="mdi mdi-file-excel-box mr-1"></i>Excel',
                                className: 'bg-green-600 text-white px-3 py-2 rounded-md text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all',
                                title: 'Delivery Report - ' + moment().format('DD MMM YYYY'),
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5]
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="mdi mdi-file-pdf-box mr-1"></i>PDF',
                                className: 'bg-red-600 text-white px-3 py-2 rounded-md text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all ml-2',
                                title: 'Delivery Report - ' + moment().format('DD MMM YYYY'),
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5]
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="mdi mdi-printer mr-1"></i>Print',
                                className: 'bg-gray-600 text-white px-3 py-2 rounded-md text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all ml-2',
                                title: 'Delivery Report - ' + moment().format('DD MMM YYYY'),
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5]
                                }
                            }
                        ],
                        ajax: {
                            url: '{!! route("reports.deliver_report") !!}',
                            data: {
                                from_date: from_date,
                                to_date: to_date,
                                agent_id: agent_id
                            }
                        },
                        columns: [
                            {
                                title: "No",
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                },
                                className: 'text-center'
                            },
                            { 
                                data: 'manifest_no',
                                name: 'manifest_no',
                                className: 'whitespace-nowrap'
                            },
                            { 
                                data: 'be_number',
                                name: 'be_number',
                                className: 'whitespace-nowrap'
                            },
                            { 
                                data: 'agent.name',
                                name: 'agent.name',
                                className: 'whitespace-nowrap'
                            },
                            { 
                                data: 'manifest_date',
                                name: 'manifest_date',
                                className: 'whitespace-nowrap'
                            },
                            { 
                                data: 'status',
                                name: 'status',
                                className: 'text-center'
                            }
                        ],
                        order: [[4, 'desc']], // Sort by manifest date by default
                        createdRow: function(row, data, dataIndex) {
                            $(row).addClass('hover:bg-gray-50 transition-colors duration-150 ease-in-out');
                        }
                    });
                }

                load_data();

                // Filter Button Click
                $('#filter').click(function() {
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var agent_id = $('#agent_id').val();

                    if (from_date != '' && to_date != '') {
                        load_data(from_date, to_date, agent_id);
                    } else {
                        alert('Both Date is required');
                    }
                });

                // Refresh Button Click
                $('#refresh').click(function() {
                    $('#from_date').val('');
                    $('#to_date').val('');
                    $('#agent_id').val('');
                    load_data();
                });
            });
        </script>
    </x-slot>
</x-app-layout>
