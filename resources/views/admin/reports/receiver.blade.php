<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">File Receive Report</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">
        <div class="card w-full">

            {{-- Filter form --}}
            <div class="mb-4">
                <div class="p-4 shadow-md rounded-t-lg">
                    <div class="flex justify-between items-center gap-4">
                        <h2 class="text-xl">File Receive Report</h2>
                        <div class="flex justify-between items-center gap-4 flex-grow max-w-4xl">
                            <lable class="text-nowrap">Lodgement Date</lable>
                            <div id="reportrange" class="bg-white cursor-pointer px-5 py-1 border border-gray-300 rounded-sm w-full">
                                <i class="mdi  mdi-calendar-clock text-green-400"></i>&nbsp;
                                <span></span> <i class="mdi mdi-arrow-down"></i>
                            </div>
                            <input type="hidden" id="from_date" name="from_date">
                            <input type="hidden" id="to_date" name="to_date">
                            
                            {{-- Select Agent --}}
                            <select name="agent_id" id="agent_id" class="form-select w-full">
                                <option value="">Select Agent</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="">
                            <button type="button" name="filter" id="filter" class="font-mont cursor-pointer px-4 py-3 bg-green-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110">Search</button>
                            <button type="button" name="refresh" id="refresh" class="font-mont cursor-pointer px-4 py-3 bg-indigo-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110">Reset</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Report table --}}
            <div class="p-6">
                {{-- Table start here --}}
                <table id="all_report" class="table is-narrow">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lodg.No</th>
                            <th>Agent</th>
                            <th>B/E No</th>
                            <th>M/F No</th>
                            <th>M/F Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div> <!-- flex-end -->

    <x-slot name="script">
        <!-- Datatable script-->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script>
            $(function() {
                // Date Range Picker Initialization
                var start = moment().startOf('year');
                var end = moment().endOf('year');
                
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
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'This Year': [moment().startOf('year'), moment().endOf('year')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);

                cb(start, end);

                // Initialize DataTable with AJAX
                function load_data(from_date = '', to_date = '', agent_id = '') {
                    $('#all_report').DataTable({
                        processing: true,
                        serverSide: true,
                        destroy: true,
                        paging: false,
                        searching: false,
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'pdf',
                                title: 'Receiver Report',
                                footer: true
                            },
                            {
                                extend: 'excel',
                                title: 'Receiver Report',
                                footer: true
                            },
                            {
                                extend: 'print',
                                title: 'Receiver Report',
                                footer: true
                            }
                        ],
                        ajax: {
                            url: '{!! route("reports.receiver_report") !!}',
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
                                }
                            },
                            { data: 'lodgement_no', name: 'lodgement_no' },
                            { data: 'agent.name', name: 'agent.name' },
                            { data: 'be_number', name: 'be_number' },
                            { data: 'manifest_no', name: 'manifest_no' },
                            { data: 'manifest_date', name: 'manifest_date' },
                            { data: 'status', name: 'status' }
                        ]
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
