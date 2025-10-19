<x-guest-layout>
    {{-- Title --}}
    <x-slot name="title">{{$agent->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <style>
            .tablinks.active {
                color: #6d28d9;
                border-bottom: 2px solid #6d28d9;
            }
            .tabcontent {
                animation: fadeEffect 1s;
            }
            @keyframes fadeEffect {
                from {opacity: 0;}
                to {opacity: 1;}
            }
        </style>
    </x-slot>

    <section>

        {{-- Page Content --}}
        <div class="bg-gradient-to-r from-violet-400 to-purple-300 py-8">
            <div class="container mx-auto px-4">
                @if ($agent->agency_logo)
                    <div class="flex justify-center items-center mb-4">
                        <img src="{{ asset($agent->agency_logo) }}" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover">
                    </div>
                @endif
                <h1 class="text-3xl font-bold text-center text-gray-800">{{$agent->name}}</h1>
            </div>
        </div>

        <div class="max-w-7xl mx-auto flex flex-col gap-6">

            <div class="card p-6">
                @role('admin')
                <div class="flex justify-between items-center gap-6 mb-6 print:hidden">

                    <div class="flex justify-between items-center gap-2 flex-grow">

                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-gradient-to-r from-violet-400 to-purple-300 h-2.5 rounded-full" style="width: {{$completionPercentage.'%'}}"></div>
                        </div>
                        <p class="text-violet-700">{{$completionPercentage.'%'}}</p>
                    </div>

                    <a href="{{route('agents.edit',$agent->id)}}">
                        <button class="font-mont px-4 py-2 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 " id="">Edit</button>
                    </a>
                </div>
                @endrole


                <div class="">
                    {{-- General Information --}}
                    <div class="bg-white shadow-md rounded-lg p-6 mb-6" aria-labelledby="general-info-heading">
                        <h3 id="general-info-heading" class="text-xl font-semibold text-gray-800 mb-4">General Information</h3>
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 flex-grow">
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500" aria-hidden="true"><i class="mdi mdi-numeric"></i></span>
                                    <p class="text-gray-700"><strong>AIN No:</strong> <span>{{ $agent->ain_no ?? 'N/A' }}</span></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500" aria-hidden="true"><i class="mdi mdi-numeric"></i></span>
                                    <p class="text-gray-700"><strong>License No:</strong> <span>{{ $agent->license_no ?? 'N/A' }}</span></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500" aria-hidden="true"><i class="mdi mdi-numeric"></i></span>
                                    <p class="text-gray-700"><strong>License Issue Date:</strong> <span>{{ $agent->license_issue_date  ?? 'N/A' }}</span></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500" aria-hidden="true"><i class="mdi mdi-numeric"></i></span>
                                    <p class="text-gray-700"><strong>Membership No:</strong> <span>{{ $agent->membership_no ?? 'N/A' }}</span></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500" aria-hidden="true"><i class="mdi mdi-account-outline"></i></span>
                                    <p class="text-gray-700"><strong>{{ $agent->owners_designation ?? 'Owner / Manager' }}:</strong> <span>{{ $agent->owners_name ?? 'N/A' }}</span></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500" aria-hidden="true"><i class="mdi mdi-office-building-outline"></i></span>
                                    <p class="text-gray-700"><strong>Office Address:</strong> <span>{!! $agent->office_address ?? 'N/A' !!}</span></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500" aria-hidden="true"><i class="mdi mdi-office-building-outline"></i></span>
                                    <p class="text-gray-700"><strong>Parmanent Address:</strong> <span>{!! $agent->parmanent_address ?? 'N/A' !!}</span></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500" aria-hidden="true"><i class="mdi mdi-phone-outline"></i></span>
                                    <p class="text-gray-700"><strong>Phone:</strong> <a href="tel:{{ $agent->phone }}" class="hover:text-violet-600 transition-colors">{{ $agent->phone ?? 'N/A' }}</a></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500" aria-hidden="true"><i class="mdi mdi-email-outline"></i></span>
                                    <p class="text-gray-700"><strong>Email:</strong> <a href="mailto:{{ $agent->email }}" class="hover:text-violet-600 transition-colors">{{ $agent->email ?? 'N/A' }}</a></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500" aria-hidden="true"><i class="mdi mdi-home-outline"></i></span>
                                    <p class="text-gray-700"><strong>House:</strong> <span>{{ $agent->house ?? 'N/A' }}</span></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500" aria-hidden="true"><i class="mdi mdi-note-outline"></i></span>
                                    <p class="text-gray-700"><strong>Note:</strong> <span>{{ $agent->note ?? 'N/A' }}</span></p>
                                </div>
                            </div>
                            {{-- Licence number, membership no, permanent address --}}
                            @if ($agent->owner_photo)
                                <div class="flex-shrink-0">
                                    <img src="{{ asset($agent->owner_photo) }}" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover">
                                </div>
                            @endif
                        </div>

                    </div>
                    {{-- General Information End --}}

                    {{-- Three tab Custom Files, Donation, Fees --}}
                    <div class="mb-6">
                        <div class="border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab">
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 tablinks active" id="custom-files-tab" data-tab="custom-files">
                                        Custom Files
                                        @if($unpaidCount > 0)
                                            <span class="ml-1 px-2 py-1 text-xs text-red-600 bg-red-100 rounded-full">{{ $unpaidCount }} unpaid</span>
                                        @endif
                                    </button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 tablinks" id="donation-tab" data-tab="donation">Donation</button>
                                </li>
                                <li role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 tablinks" id="fees-tab" data-tab="fees">Fees
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab content -->
                        <div class="tab-content mt-6">
                            <!-- Custom Files Tab -->
                            <div id="custom-files" class="tabcontent active">
                                @if($unpaidCount > 0)
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">
                                                    There are <strong>{{ $unpaidCount }}</strong> unpaid custom files with a total pending amount of <strong>৳{{ number_format($unpaidTotal, 2) }}</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <table class="min-w-full divide-y divide-gray-200" id="customsfiles">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="text-left">Agent Name In Customs File</th>
                                            <th class="text-left">B/E No</th>
                                            <th class="text-left">Date</th>
                                            <th class="text-left">Fees</th>
                                            <th class="text-left">Agent Name in Chada</th>
                                            <th class="text-left">Type</th>
                                            <th class="text-left">Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($agent->custom_files as $file)
                                        <tr class="{{ $file->status == 'Unpaid' ? 'bg-red-50' : '' }}">
                                            <th>{{ $loop->index+1 }}</th>
                                            <td>{{$file->name}}</td>
                                            <td>{{$file->be_number}}</td>
                                            <td>{{$file->date ? \Carbon\Carbon::parse($file->date)->format('d-M-Y') : 'N/A'}}</td>
                                            <td>৳{{number_format($file->fees, 2)}}</td>
                                            <td>{{$file->agent ? $file->agent->name : 'Unknown'}}</td>
                                            <td>{{$file->type}}</td>
                                            <td>
                                                <button onclick="toggleStatus({{ $file->id }})" class="status-btn cursor-pointer hover:opacity-75 transition-opacity {{ $file->status == 'Unpaid' ? 'text-red-400' : 'text-green-600' }}"
                                                    data-id="{{ $file->id }}">
                                                    {{ $file->status }}
                                                </button>
                                            </td>

                                            <td class="flex justify-end items-center gap-2">
                                                @role('admin')
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
                                                @endrole

                                                @role('agent')
                                                <a class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-2xl" href="{{route('customfiles.edit', $file->id)}}">
                                                    <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                                </a>
                                                @endrole
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Donation Tab -->
                            <div id="donation" class="tabcontent hidden">
                                <div class="text-center mb-4">
                                    <h3 class="text-2xl font-medium">Donation</h3>
                                    <p>
                                        Treatment: {{ $agent->donations->where('status', 'Approved')->where('type', 'Treatment')->count() }},
                                        Education: {{ $agent->donations->where('status', 'Approved')->where('type', 'Education')->count() }},
                                        Marriage: {{ $agent->donations->where('status', 'Approved')->where('type', 'Marrige')->count() }},
                                        Other: {{ $agent->donations->where('status', 'Approved')->where('type', 'Other')->count() }}
                                    </p>
                                </div>
                                <table id="donationTable" class="display stripe text-xs sm:text-base" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Agent</th>
                                            <th>Date</th>
                                            <th>Purpose</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agent->donations as $donation)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$donation->agent->name}}</td>
                                            <td>{{ $donation->formatted_date }}</td>
                                            <td>{{$donation->purpose}}</td>
                                            <td>{{$donation->amount}} Taka</td>
                                            <td>{{$donation->status}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right font-bold">Total Approved Amount:</td>
                                            <td colspan="2" class="font-bold">
                                                {{ $agent->donations->where('status', 'Approved')->sum('amount') }} Taka
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Fees Tab -->
                            <div id="fees" class="tabcontent hidden">


                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <!-- Member Fee Card -->
                                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                                        <div class="flex justify-between items-center mb-4">
                                            <h4 class="text-lg font-semibold text-gray-800">Member Fee</h4>
                                            <span class="text-sm text-gray-500">Monthly: ৳{{ number_format($agent->member_fee_amount, 2) }}</span>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Last Paid Date:</span>
                                                <span class="font-medium">{{ $agent->last_fee_paid_date ? $agent->last_fee_paid_date->format('d M, Y') : 'Not paid yet' }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Paid Till:</span>
                                                <span class="font-medium">{{ $agent->member_fee_paid_till_date ? $agent->member_fee_paid_till_date->format('d M, Y') : 'Not paid yet' }}</span>
                                            </div>
                                            {{-- Calculate the due amount --}}
                                            @php
                                                $dueAmount = 0;
                                                if ($agent->member_fee_paid_till_date && $agent->member_fee_paid_till_date->isPast()) {
                                                    $dueAmount = $agent->member_fee_amount * (now()->diffInMonths($agent->member_fee_paid_till_date) + 1);
                                                }
                                            @endphp
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Due Amount:</span>
                                                <span class="font-medium text-red-500">৳{{ number_format($dueAmount, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Welfare Fund Card -->
                                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                                        <div class="flex justify-between items-center mb-4">
                                            <h4 class="text-lg font-semibold text-gray-800">Welfare Fund Fee</h4>
                                            <span class="text-sm text-gray-500">Monthly: ৳{{ number_format($agent->welfare_fund_amount, 2) }}</span>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Last Paid Date:</span>
                                                <span class="font-medium">{{ $agent->last_fee_paid_date ? $agent->last_fee_paid_date->format('d M, Y') : 'Not paid yet' }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Paid Till:</span>
                                                <span class="font-medium">{{ $agent->welfare_fund_paid_till_date ? $agent->welfare_fund_paid_till_date->format('d M, Y') : 'Not paid yet' }}</span>
                                            </div>
                                            {{-- Calculate the due amount --}}
                                            @php
                                                $dueAmount = 0;
                                                if ($agent->welfare_fund_paid_till_date && $agent->welfare_fund_paid_till_date->isPast()) {
                                                    $dueAmount = $agent->welfare_fund_amount * (now()->diffInMonths($agent->welfare_fund_paid_till_date) + 1);
                                                }
                                            @endphp
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Due Amount:</span>
                                                <span class="font-medium text-red-500">৳{{ number_format($dueAmount, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @role('admin')
                                <!-- Payment Form -->
                                <div class="bg-white rounded-lg shadow-md mt-6">
                                    <div class="p-6">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Record New Payment</h4>

                                        <form action="{{ route('agents.fees.store', $agent->id) }}" method="POST">
                                            @csrf

                                            <div class="grid grid-cols-3 gap-6 mb-6">

                                                {{-- Add fees type --}}
                                                <div>
                                                    <label for="fees_type" class="block text-sm font-medium text-gray-700">Fees Type</label>
                                                    <select name="fees_type" id="fees_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                                                        <option value="member_fee">Member Fee</option>
                                                        <option value="welfare_fund">Welfare Fund Fee</option>
                                                    </select>
                                                </div>

                                                <!-- Monthly  -->
                                                <div>
                                                    <label for="monthly" class="block text-sm font-medium text-gray-700">Monthly</label>
                                                    <div class="mt-1 relative rounded-md shadow-sm">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 sm:text-sm">৳</span>
                                                        </div>
                                                        <input type="number" name="monthly" id="monthly" step="0.01"
                                                            class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500" value="40">
                                                    </div>
                                                </div>

                                                {{-- Only if agent dont has any 'last_fee_paid_date' --}}
                                                @if($agent->member_fee_paid_till_date == null)

                                                <!-- Member Fee Paid Till Date -->
                                                <div>
                                                    <label for="member_fee_paid_till_date" class="block text-sm font-medium text-gray-700">Member Fee paid Till Date</label>
                                                    <div class="mt-1 relative rounded-md shadow-sm">
                                                        <input type="date" name="member_fee_paid_till_date" id="member_fee_paid_till_date"
                                                            class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500" value="{{ old('member_fee_paid_till_date', $agent->member_fee_paid_till_date ? $agent->member_fee_paid_till_date->format('Y-m-d') : now()->format('Y-m-d')) }}">
                                                    </div>
                                                </div>
                                                @endif

                                                {{-- Only if agtent dont hav any 'welfare_fund_paid_till_date' --}}
                                                @if($agent->welfare_fund_paid_till_date == null)

                                                <!-- Welfare Fund Paid Till Date -->
                                                <div>
                                                    <label for="welfare_fund_paid_till_date" class="block text-sm font-medium text-gray-700">Welfare Fund paid Till Date</label>
                                                    <div class="mt-1 relative rounded-md shadow-sm">
                                                        <input type="date" name="welfare_fund_paid_till_date" id="welfare_fund_paid_till_date"
                                                            class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500" value="{{ old('welfare_fund_paid_till_date', $agent->welfare_fund_paid_till_date ? $agent->welfare_fund_paid_till_date->format('Y-m-d') : now()->format('Y-m-d')) }}">
                                                    </div>
                                                </div>
                                                @endif



                                                @if($agent->last_fee_paid_date == null)

                                                <!-- Last Fee Paid Date -->
                                                <div>
                                                    <label for="last_fee_paid_date" class="block text-sm font-medium text-gray-700">Last Fee Paid Date</label>
                                                    <div class="mt-1 relative rounded-md shadow-sm">
                                                        <input type="date" name="last_fee_paid_date" id="last_fee_paid_date"
                                                            class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500" value="{{ old('last_fee_paid_date', $agent->last_fee_paid_date ? $agent->last_fee_paid_date->format('Y-m-d') : now()->format('Y-m-d')) }}">
                                                    </div>
                                                </div>
                                                @endif
                                                <!-- Payment Amount -->
                                                <div>
                                                    <label for="payment_amount" class="block text-sm font-medium text-gray-700">Payment Amount</label>
                                                    <div class="mt-1 relative rounded-md shadow-sm">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 sm:text-sm">৳</span>
                                                        </div>
                                                        <input type="number" name="payment_amount" id="payment_amount" step="0.01"
                                                            class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="mt-6 flex justify-end">
                                                <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white">
                                                    Record Payment
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endrole
                            </div>
                        </div>
                    </div>
                    {{-- Three tab Custom Files, Donation, Fees End --}}

                </div>
            </div> <!-- end card -->

        </div>
    </section>

    <x-slot name="script">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            var datatablelist = $('#donationTable').DataTable();
            var customsfiles = $('#customsfiles').DataTable();

            // Tab functionality
            $(document).ready(function() {
                $('.tablinks').click(function() {
                    // Remove active class from all tabs and content
                    $('.tablinks').removeClass('active');
                    $('.tabcontent').addClass('hidden').removeClass('active');

                    // Add active class to clicked tab
                    $(this).addClass('active');

                    // Show corresponding content
                    const tabId = $(this).data('tab');
                    $(`#${tabId}`).removeClass('hidden').addClass('active');
                });
            });

            function toggleStatus(id) {
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
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating status. Please try again.');
                });
            }
        </script>
    </x-slot>
</x-guest-layout>



