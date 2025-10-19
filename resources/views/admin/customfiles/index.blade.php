<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Customs File</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-4">
        {{-- This content shouldnt be shown to checker role --}}
        @unlessrole('checker|payunpay')
        {{-- Import Form --}}
        <div class="card w-full print:hidden">
            <div class="p-6">
                <form action="{{ route('customfiles.store') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-4">
                    @csrf
                    <input type="file" name="excel_file" accept=".xlsx,.xls" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                    <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white">
                        Import
                    </button>
                </form>
                @if(session('success'))
                    <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mt-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
        @endunlessrole

        {{-- Table --}}
        <div class="card w-full print:hidden">
            <div class="p-6">
                @role('payunpay')
                <div class="flex justify-start items-center mb-4 gap-4">
                    <button id="oldClearButton" class="block text-center px-2 py-1 bg-gradient-to-r from-red-400 to-red-600 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-md text-white">
                        <i class="mdi mdi-delete"></i> Clear 2 year old  Paid
                    </button>
                    <button id="clearMemoSession" class="block text-center px-2 py-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-md text-white">
                        <i class="mdi mdi-delete"></i> Clear Memo Session
                    </button>
                    {{-- Add memo printing button--}}
                    <button id="printMemo" class="block text-center px-2 py-1 bg-gradient-to-r from-green-400 to-green-600 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-md text-white">
                        <i class="mdi mdi-printer"></i> Print Memo
                    </button>
                </div>
                @endrole
                {{-- Table start here --}}
                <table id="customsfiles" class="table is-narrow">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Agent Name In Customs File</th>
                            <th>B/E No</th>
                            <th>Fees</th>
                            <th>Type</th>
                            @unlessrole('checker')
                            <th>Status</th>
                            @unlessrole('payunpay')
                            <th>Action</th>
                            @endunlessrole
                            @endunlessrole
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($customFiles as $file)
                        <tr>
                            <th>{{ $loop->index+1 }}</th>
                            <td>{{$file->name}}</td>
                            <td>{{$file->be_number}}</td>
                            <td>{{$file->fees}}</td>
                            <td>{{$file->type}}</td>
                            @unlessrole('checker')
                            <td>
                                <button
                                    onclick="toggleStatus({{ $file->id }})"
                                    class="status-btn cursor-pointer hover:opacity-75 transition-opacity {{ $file->status == 'Unpaid' ? 'text-red-400' : 'text-green-600' }}"
                                    data-id="{{ $file->id }}"
                                >
                                    {{ $file->status }}
                                </button>
                            </td>
                            @unlessrole('payunpay')
                            <td class="flex justify-end items-center gap-2">
                                <a class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-2xl" href="{{route('customfiles.edit', $file->id)}}">
                                    <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                </a>
                                <a class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-2xl" href="{{ route('customfiles.destroy', $file->id) }}"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $file->id }}').submit();">
                                <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                </a>

                                <form id="delete-form-{{ $file->id }}" action="{{ route('customfiles.destroy', $file->id) }}" method="POST" style="display: none;">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            </td>
                            @endunlessrole
                            @endunlessrole
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        @role('payunpay')
        {{-- Print Template --}}
        <div class="printWraper  print:block card p-6" >
            <style>
                .printWraper table td {
                        border: 1px solid #000;
                        padding: 8px;
                        text-align: left;
                    }
                    .printWraper table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                        font-size: 14px;
                    }

                /* @media print {
                    @page {
                        margin: 0.5cm;
                    }
                    body > *:not(.printWraper) {
                        display: none;
                    }
                    .printWraper table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                        font-size: 14px;
                    }
                    .printWraper table td {
                        border: 1px solid #000;
                        padding: 8px;
                        text-align: left;
                    }
                    .printWraper .agentName {
                        font-weight: bold;
                        margin-bottom: 10px;
                        display: inline-block;
                    }
                    .printWraper .totalfees {
                        text-align: center;
                        font-weight: bold;
                    }
                } */
            </style>
            <h2 class="text-center text-2xl font-bold">Benapole Customs C&F Agents Association</h2>
            <div class="">
                Agent Name: <span class="agentName text-lg font-semibold mb-4"></span><br>
                <table>
                    <tbody>
                        <tr>
                            <td>Import Files</td>
                            <td class="im_count">0</td>
                            <td class="imfees">600</td>
                            <td class="im_imfees">0</td>
                            <td class="totalfees" rowspan="2">0</td>
                        </tr>
                        <tr>
                            <td>Export Files</td>
                            <td class="ex_count">0</td>
                            <td class="exfees">500</td>
                            <td class="ex_exfees">0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Print Template --}}
        @endrole
    </div> <!-- flex-end -->

    <x-slot name="script">
        <!-- Datatable script-->
        <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
        <script>
            // Initialize DataTable
            new DataTable('#customsfiles', {
                // paginate: false,
                // pageLength: 100,
                layout: {
                    topStart: 'info',
                    bottom: 'paging',
                    bottomStart: null,
                    bottomEnd: null,
                }
            });

            // Handle after print event
            function handleAfterPrint() {
                clearMemoSession();
                // Remove the event listener
                window.removeEventListener('afterprint', handleAfterPrint);
            }

            // Handle old records deletion
            document.getElementById('oldClearButton').addEventListener('click', function() {
                if (confirm('Are you sure you want to delete all paid customs files older than 2 years? This action cannot be undone.')) {
                    fetch('{{ route("customfiles.clearOld") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload(); // Reload to update the table
                        } else {
                            alert(data.message || 'Error deleting old records');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting old records. Please try again.');
                    });
                }
            });

            // Handle clearing the memo session
            document.getElementById('clearMemoSession').addEventListener('click', function() {
                clearMemoSession();
            });

            // Function to clear memo session and reset displays
            function clearMemoSession() {
                sessionStorage.removeItem('agent_id');
                sessionStorage.removeItem('agent_name');
                sessionStorage.removeItem('im_count');
                sessionStorage.removeItem('ex_count');

                // Clear the print template display
                document.querySelector('.agentName').textContent = '';
                document.querySelector('.im_count').textContent = '0';
                document.querySelector('.ex_count').textContent = '0';
                document.querySelector('.im_imfees').textContent = '0';
                document.querySelector('.ex_exfees').textContent = '0';
                document.querySelector('.totalfees').textContent = '0';
            }

            // Handle printing memo
            document.getElementById('printMemo').addEventListener('click', function() {
                const agentName = sessionStorage.getItem('agent_name');
                if (!agentName) {
                    alert('No agent data available to print');
                    return;
                }

                // Get counts
                const imCount = parseInt(sessionStorage.getItem('im_count') || 0);
                const exCount = parseInt(sessionStorage.getItem('ex_count') || 0);

                // If no files are marked as paid
                if (imCount === 0 && exCount === 0) {
                    alert('No files have been marked as paid yet');
                    return;
                }

                // Calculate fees
                const imFees = imCount * 600; // 600 per import file
                const exFees = exCount * 500; // 500 per export file
                const totalFees = imFees + exFees;

                // Update print template values
                document.querySelector('.printWraper').style.display = 'block';
                document.querySelector('.agentName').textContent = agentName;
                document.querySelector('.im_count').textContent = imCount;
                document.querySelector('.ex_count').textContent = exCount;
                document.querySelector('.im_imfees').textContent = imFees;
                document.querySelector('.ex_exfees').textContent = exFees;
                document.querySelector('.totalfees').textContent = totalFees;

                // Remove any existing print event listeners
                window.removeEventListener('afterprint', handleAfterPrint);

                // Add event listener for after print
                window.addEventListener('afterprint', handleAfterPrint);

                // Show print dialog
                window.print();
            });

            function toggleStatus(id) {
                const button = document.querySelector(`button[data-id="${id}"]`);
                if (button.textContent.trim() === 'Paid') {
                    alert('Cannot change status from Paid to Unpaid');
                    return;
                }

                if (!confirm('Are you sure you want to mark this file as Paid?')) {
                    return;
                }
                fetch(`/customfiles/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const button = document.querySelector(`button[data-id="${id}"]`);
                        button.textContent = data.status;
                        button.classList.toggle('text-red-400', data.status === 'Unpaid');
                        button.classList.toggle('text-green-600', data.status === 'Paid');



                        // Current session agent_id is same as the data.agent_id
                        // Check if the agent_id in sessionStorage is different from the one in data
                        // If the agent_id is different, reset the counters and store the new agent information
                        if (sessionStorage.getItem('agent_id') !== null && sessionStorage.getItem('agent_id') != data.agent_id) {

                            // Reset counters if the agent_id changed
                            sessionStorage.setItem('im_count', 0);
                            sessionStorage.setItem('ex_count', 0);
                        }


                        // Store agent information
                        sessionStorage.setItem('agent_id', data.agent_id);
                        sessionStorage.setItem('agent_name', data.agent_name);



                        // Get existing counts or initialize to 0
                        let imCount = parseInt(sessionStorage.getItem('im_count') || 0);
                        let exCount = parseInt(sessionStorage.getItem('ex_count') || 0);


                        // Increment the appropriate counter based on file type
                        if (data.type === 'IM') {
                            imCount += 1;
                            sessionStorage.setItem('im_count', imCount);
                        } else if (data.type === 'EX') {
                            exCount += 1;
                            sessionStorage.setItem('ex_count', exCount);
                        }

                        // Update the display in the print template
                        document.querySelector('.agentName').textContent = data.agent_name;
                        document.querySelector('.im_count').textContent = imCount;
                        document.querySelector('.ex_count').textContent = exCount;
                    }

                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating status. Please try again.');
                });
            }
        </script>
    </x-slot>
</x-app-layout>
