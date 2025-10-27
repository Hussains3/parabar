<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Importer/Exporter Payment Bill</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-4">

        <!-- Payment Section -->
        <div class="card max-w-2xl mx-auto">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Payment Management</h2>

                {{-- <!-- Payment History -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Payment History</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        @if(!empty($file_data->payments))
                            <div class="space-y-2">
                                @foreach($file_data->payments as $payment)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200 last:border-0">
                                        <div>
                                            <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($payment['date'])->format('d M, Y') }}</span>
                                        </div>
                                        <div class="font-medium">৳{{ number_format($payment['amount'], 2) }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No payments recorded yet.</p>
                        @endif
                    </div>
                </div> --}}

                <!-- Add New Payment -->
                <div>
                    <h3 class="text-lg font-semibold mb-2">Add Payment</h3>
                    <form action="{{ route('file_datas.add-payment', $file_data->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="amount" class="block">Amount</label>
                                <input type="number" step="1" name="amount" id="amount" required class="forn-input" max="{{$file_data->bill_total-$file_data->total_paid}}">
                            </div>
                            <div>
                                <label for="payment_date" class="block">Payment Date</label>
                                <input type="date" name="payment_date" id="payment_date" required
                                    class="forn-input"
                                    value="{{ date('Y-m-d') }}"
                                >
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="">
                                    <input type="radio" name="status" id="auto" value="Auto" checked>
                                    <label for="auto">Auto</label>
                                </div>
                                <div class="">
                                    <input type="radio" name="status" id="unpaid" value="Unpaid">
                                    <label for="unpaid">Unpaid</label>
                                </div>
                                <div class="">
                                    <input type="radio" name="status" id="partial" value="Partial">
                                    <label for="partial">Partial</label>
                                </div>
                                <div class="">
                                    <input type="radio" name="status" id="paid" value="Paid">
                                    <label for="paid">Paid</label>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Record Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="card w-full">
            <div class="p-6">
                {{-- Table start here --}}
                <table id="filedataTable" class="table is-narrow">
                    <thead>
                        <tr>
                            <th>Serial No</th>
                            <th>C Number</th>
                            <th>Date</th>
                            <th>Package</th>
                            <th>Manifest No</th>
                            <th>LC No</th>
                            <th>Bank</th>
                            <th>Importer/Exporter</th>
                            <th>Bill No</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($file_datas as $file_data)
                        <tr>
                            <th>{{ $loop->index+1 }}</th>
                            <td>{{$file_data->be_number}}</td>
                            <td>{{$file_data->file_date}}</td>
                            <td>{{$file_data->package}}</td>
                            <td>{{$file_data->manifest_number}}</td>
                            <td>{{$file_data->lc_no}}</td>
                            <td>{{$file_data->lc_bank}}</td>
                            <td>{{$file_data->ie_data->org_name}}</td>
                            <td>{{$file_data->bill_no}}</td>
                            <td>
                                @if ($file_data->status == 'Unpaid')
                                    <span class="text-red-600">Unpaid</span>
                                @elseif ($file_data->status == 'Partial')
                                    <span class="text-orange-600">Partial</span>
                                @else
                                <span class="text-green-600">Paid</span>
                                @endif
                            </td>

                            <td class="flex justify-end items-center gap-2">
                                    <a class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-2xl" href="{{route('file_datas.edit', $file_data->id)}}">
                                        <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                    </a>
                                    <a class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-2xl" href="{{ route('file_datas.destroy', $file_data->id) }}"
                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $file_data->id }}').submit();">
                                    <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                    </a>

                                    <form id="delete-form-{{ $file_data->id }}" action="{{ route('file_datas.destroy', $file_data->id) }}" method="POST" style="display: none;">
                                        @method('DELETE')
                                        @csrf
                                    </form>

                                    <a class="text-orange-400 hover:text-red-600  hover:scale-105 transition duration-150 ease-in-out text-2xl" href="{{route('file_datas.editprint', $file_data->id)}}"><span class="menu-icon"><i class="mdi mdi-printer"></i></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div> <!-- flex-end -->

    <x-slot name="script">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $('#filedataTable').DataTable({
                "pageLength": 100
            });

        </script>
    </x-slot>
</x-app-layout>
