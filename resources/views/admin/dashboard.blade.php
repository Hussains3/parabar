<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Dashboard</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex justify-center items-center min-h-screen">


        <div class="grid grid-cols-3 gap-4">

            <a href="{{route('ie_datas.index')}}">
            <div class="card hover:scale-105 transition-transform min-h-20 flex items-center justify-center hover:bg-red-400">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">

                                <h4 class="card-title">Importer/Exporter Information</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{route('file_datas.create')}}">
            <div class="card hover:scale-105 transition-transform min-h-20 flex items-center justify-center hover:bg-red-400">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">

                                <h4 class="card-title">Input Bill Voucher Importer/Exporter</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{route('file_datas.index')}}">
            <div class="card hover:scale-105 transition-transform min-h-20 flex items-center justify-center hover:bg-red-400">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">

                                <h4 class="card-title">Bill Print</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{route('dueimex')}}">
                <div class="card hover:scale-105 transition-transform min-h-20 flex items-center justify-center hover:bg-red-400">
                    <div class="px-4 py-2">
                        <div class="flex items-center justify-between">
                            <div class="text-start">
                                <h4 class="card-title">Importer/Exporter Due Bill</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <div class="card hover:scale-105 transition-transform min-h-20 flex items-center justify-center hover:bg-red-400">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">
                            <h4 class="card-title">Importer/Exporter Payment Bill</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:scale-105 transition-transform min-h-20 flex items-center justify-center hover:bg-red-400">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">
                            <h4 class="card-title">Accounts</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:scale-105 transition-transform min-h-20 flex items-center justify-center hover:bg-red-400">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">
                            <h4 class="card-title"> Daily Office Cost</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:scale-105 transition-transform min-h-20 flex items-center justify-center hover:bg-red-400">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">
                            <h4 class="card-title"> B/E Search</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:scale-105 transition-transform min-h-20 flex items-center justify-center hover:bg-red-400">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">
                            <h4 class="card-title">Office Staff</h4>
                        </div>
                    </div>
                </div>
            </div>


        </div> <!-- grid-end -->


    </div> <!-- flex-end -->

    <x-slot name="script">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $('#suppliers').DataTable({
                "pageLength": 100
            });

        </script>
    </x-slot>
</x-app-layout>
