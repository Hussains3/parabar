<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">All Invoices</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-4">

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
