
<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Importers/Exporters with Unpaid Files</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="">

        {{-- Table --}}
        <div class="card rounded-tl-none">
            <div class="p-6">

                <h2 class="mb-4 text-xl">All Importers/Exporters with Unpaid Files</h2>
                <table id="ie_dataTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Organization Name</th>
                            <th>Unpaid Files Count</th>
                            <th>Total Unpaid Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @foreach($ie_datas as $ie)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">
                                    {{  $loop->index+1 }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $ie->org_name }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $ie->file_datas->count() }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ number_format($ie->file_datas->sum('balance'), 2) }} Tk
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('ie_datas.show', $ie->id) }}"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-600">
                                            View Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>


    <x-slot name="script">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            var datatablelist = $('#ie_dataTable').DataTable();

        </script>
    </x-slot>
</x-app-layout>

