<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Activity Logs</x-slot>

    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="container-fluid px-4">
        <h1 class="mt-4"></h1>
        <div class="card mb-4 p-6">
            <div class="card-header mb-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center font-bold text-lg">
                        <i class="fas fa-table me-1"></i>
                        Activity Logs
                    </div>
                    <form action="{{ route('activity-logs.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all activity logs? This action cannot be undone.');">
                        @csrf
                        <button type="submit" class="text-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-800 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white">
                            <i class="fas fa-trash"></i> Clear All Logs
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="LogsTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($logs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->created_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($log->log_type) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->action }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->ip }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-center mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>


    <x-slot name="script">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                var table = $('#LogsTable').DataTable();

            });

            function showModal(id) {
                document.getElementById(id).classList.remove('hidden');
            }

            function hideModal(id) {
                document.getElementById(id).classList.add('hidden');
            }
        </script>
    </x-slot>

</x-app-layout>
