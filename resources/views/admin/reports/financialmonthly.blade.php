<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Monthly Bank Report</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col sm:flex-row gap-6">

        {{-- Form --}}
        <div class="card max-w-3xl">
            <div class="p-6">
                <h2 class="mb-4 text-xl">Select Month</h2>
                <form  id="dailyreport">
                    <select id="targatedMonth" name="targatedMonth" class="">
                        <option value="01" @if ($thisMonth == '01') selected @endif>January</option>
                        <option value="02" @if ($thisMonth == '02') selected @endif>February</option>
                        <option value="03" @if ($thisMonth == '03') selected @endif>March</option>
                        <option value="04" @if ($thisMonth == '04') selected @endif>April</option>
                        <option value="05" @if ($thisMonth == '05') selected @endif>May</option>
                        <option value="06" @if ($thisMonth == '06') selected @endif>June</option>
                        <option value="07" @if ($thisMonth == '07') selected @endif>July</option>
                        <option value="08" @if ($thisMonth == '08') selected @endif>August</option>
                        <option value="09" @if ($thisMonth == '09') selected @endif>September</option>
                        <option value="10" @if ($thisMonth == '10') selected @endif>October</option>
                        <option value="11" @if ($thisMonth == '11') selected @endif>November</option>
                        <option value="12" @if ($thisMonth == '12') selected @endif>December</option>
                    </select>
                </form>
            </div>
        </div>


        {{-- Table --}}
        <div class="card flex-grow">
            <div class="p-6">

                <h2 class="mb-4 text-xl">Transactions</h2>
                <table id="transactionsTable" class="responsive display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Transaction Date</th>
                            <th>Bank Account</th>
                            <th>Transaction Number </th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>


    <x-slot name="script">
        <!-- Datatable script-->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
        {{-- <script src="{{asset('libs/moment/moment.js')}}"></script> --}}
        <script>
            // const moment = require('moment');
            $(document).ready(function() {
                $('#targatedMonth').on('change', function() {
                    datatablelist.draw();
                });
                var datatablelist = $('#transactionsTable').DataTable({
                    dom: 'Bfrtip',
                    layout: {
                        topStart: {
                            buttons: 'pdfHtml5',
                        }
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{!! route('reports.financial.monthly') !!}",
                        data: function(d) {
                            d.targatedMonth = $('#targatedMonth').val();
                        },
                        beforeSend: function() {
                            // setting a timeout
                            console.log($('#targatedMonth').val());
                        },
                    },
                    responsive: true,
                    columnDefs: [
                        { responsivePriority: 1, targets: 0 },
                        { responsivePriority: 2, targets: -1 }
                    ],
                    columns: [{
                            "render": function(data, type, full, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'transaction_date',
                            name: 'transaction_date'
                        },
                        {
                            data: null,
                            render: function(data) {
                                return data.bank_account.account_number;
                            }
                        },
                        {
                            data: 'txn_number',
                            name: 'txn_number'
                        },


                        {
                            data: null,
                            render: function(data) {
                                if (data.type == 'deposit') {
                                    return `<span class="bg-green-500/40 text-xs px-2 py1 rounded-full capitalize">${data.type}</span>`;
                                } else {
                                    return `<span class="bg-red-500/40 text-xs px-2 py1 rounded-full capitalize">${data.type}</span>`;
                                }
                            }
                        },
                        {
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            data: null,
                            render: function(data) {
                                return `<div class="flex flex-col sm:flex-row gap-5 justify-end items-center">
                                    <a href="${BASE_URL}transactions/${data.id}" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                        <span class="menu-icon"><i class="mdi mdi-eye"></i></span>
                                    </a>
                                    <a href="${BASE_URL}transactions/${data.id}/edit" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                        <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                    </a>
                                    <button type="button"  class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl" onclick="transactionDelete(${data.id});">
                                        <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                        </button>
                                    </div>`;
                            }
                        }
                    ]
                });

                $(".dt-buttons .dt-button").addClass("font-mont px-4 py-2 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:bg-seagreen");

            });
        </script>
    </x-slot>
</x-app-layout>
