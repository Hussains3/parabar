<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Report</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-4">

        <div class="card w-full">
            <div class="p-6">
                <form action="{{ route('file_datas.report') }}" method="GET" class="flex print:hidden justify-center items-end gap-4 mb-6 flex-wrap">
                    <div>
                        <label for="report_type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="report_type" id="report_type"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="custom" selected>Custom</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                            <option value="previous_month">Previous Month</option>
                            <option value="previous_year">Previous Year</option>
                        </select>
                    </div>
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                            Apply
                        </button>
                    </div>
                </form>

                @if($file_datas->count() > 0)
                <h3 class="text-center text-xl font-semibold">BE Reprat</h3>
                <p class="text-center mb-4">
                    {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                </p>
                <div class="mb-4">
                    {{-- Summary Cards --}}
                    <div class="flex justify-center items-center gap-6 mb-6 font-semibold">
                        {{-- Total Amount Card --}}
                        <p class="">Total File: {{ $file_datas->count() }}</p>
                        <p class="">Total Bill: {{ $file_datas->sum('bill_total') }} Tk</p>
                        <p class="">Total Paid: {{ $file_datas->sum('total_paid') }} Tk</p>
                        <p class="">Total Due: {{ $file_datas->sum('balance') }} Tk</p>
                    </div>
                </div>

                @endif
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
                            <th class="text-right print:hidden">Action</th>
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

                            <td class="flex print:hidden justify-end items-center gap-2">
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
                "pageLength": 100,
                "searching": false,
                "lengthChange": false,
                "ordering": false,
                "info": true,
                "navigate": false,
            });

        </script>
    </x-slot>
</x-app-layout>
