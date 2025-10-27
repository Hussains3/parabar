<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit Bill Voucher</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        <style>
            .ui-autocomplete {
                background-color: #fff;
                border: 1px solid #ccc;
                max-height: 200px;
                overflow-y: auto;
                z-index: 1000;
            }

            .ui-menu-item {
                padding: 5px 10px;
                cursor: pointer;
            }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">
        <!-- Payment Section -->
        <div class="card max-w-2xl mx-auto">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Payment Management</h2>

                <div class="mb-4">
                    <div class="flex justify-between mb-2">
                        <span>Payment Status:</span>
                        <span class="font-semibold">{{ ($file_data->status) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Total Bill Amount:</span>
                        <span class="font-semibold">৳{{ number_format($file_data->bill_total, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Total Paid:</span>
                        <span class="font-semibold text-green-600">৳{{ number_format($file_data->total_paid ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span>Balance:</span>
                        <span class="font-semibold text-red-600">৳{{ number_format($file_data->bill_total - $file_data->total_paid, 2) }}</span>
                    </div>
                </div>

                <!-- Payment History -->
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
                </div>

                <!-- Add New Payment -->
                <div>
                    <h3 class="text-lg font-semibold mb-2">Add Payment</h3>
                    <form action="{{ route('file_datas.add-payment', $file_data->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="amount" class="block">Amount</label>
                                <input type="number" step="1" name="amount" id="amount" required
                                    class="forn-input"
                                    max="{{$file_data->bill_total-$file_data->total_paid}}"
                                >
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

        <div class="card flex-grow max-w-2xl mx-auto printdiv">
            <div class="p-6">

                {{-- Form --}}
                <form class="" id="fileReciveForm" enctype="multipart/form-data"
                    action="{{ route('file_datas.update', $file_data) }}" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- Section One --}}
                    <div class="grid grid-cols-4 gap-4 mb-4 bg-center bg-no-repeat bg-contain bg-opacity-10 backdrop-blur-2xl"
                        style="background-image: url('{{ asset('bcnft.png') }}');">


                        <div class="col-span-3">
                            <label for="manifest_no" class="block mb-2">Importer/Exporter</label>
                            <select name="ie_data_id" id="ie_data_id" class="form-input">
                                @foreach ($ie_datas as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($file_data->ie_data_id == $item->id) selected @endif>{{ $item->org_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> <!-- end -->

                        <div class="">
                            <label for="manifest_number" class="block mb-2">Manifest Number</label>
                            <input type="text" class="form-input" id="manifest_number" name="manifest_number" required value="{{$file_data->manifest_number}}">

                        </div> <!-- end -->

                        <div class="">
                            <label for="be_number" class="block mb-2">B/E Number</label>
                            <input type="text" class="form-input" id="be_number" name="be_number" value="{{$file_data->be_number}}">
                        </div> <!-- end -->
                        <div class="">
                            <label for="file_date" class="block mb-2">Date</label>
                            <input type="text" class="form-input" id="file_date" name="file_date" value="{{$file_data->file_date}}">
                            {{-- skipme --}}
                        </div> <!-- end -->
                        <div class="">
                            <label for="package" class="block mb-2">Package</label>
                            <input type="text" class="form-input" id="package" name="package" required value="{{$file_data->package}}">

                        </div> <!-- end -->
                        <div class="">
                            <label for="lc_no" class="block mb-2">LC Number</label>
                            <input type="text" class="form-input" id="lc_no" name="lc_no" required value="{{$file_data->lc_no}}">

                        </div> <!-- end -->
                        <div class="">
                            <label for="lc_value" class="block mb-2">LC Value</label>
                            <input type="number" class="form-input" id="lc_value" name="lc_value" required value="{{$file_data->lc_value}}">

                        </div> <!-- end -->
                        <div class="col-span-2">
                            <label for="lc_bank" class="block mb-2">LC Bank</label>
                            <input list="banks" class="form-input" name="lc_bank" id="lc_bank" required value="{{$file_data->lc_bank}}">

                            <datalist id="banks">
                                @php
                                    $banksJson = file_get_contents(base_path('banks.json'));
                                    $banks = json_decode($banksJson, true);
                                @endphp
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank['BankName'] }}">
                                @endforeach
                            </datalist>

                        </div> <!-- end -->
                    </div>
                    <div class="">
                        <div class="mb-2">
                            <div class="font-semibold text-base col-span-4">
                                <p>Bill Number: {{$file_data->bill_no}}</p>
                            </div> <!-- end -->
                        </div>
                        {{-- Bill table --}}
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-700 mb-4">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-700 px-1 py-[1px] text-left w-16">Sl.</th>
                                        <th class="border border-gray-700 px-1 py-[1px] text-left">Subject</th>
                                        <th class="border border-gray-700 px-1 py-[1px] text-left w-32">Reference</th>
                                        <th class="border border-gray-700 px-1 py-[1px] text-right w-32">Cost Bill</th>
                                        <th class="border border-gray-700 px-1 py-[1px] text-right w-32">Cost Actual</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">1</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Coat Fee</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_coat_fee" id="bill_coat_fee" value="{{ $file_data->bill_coat_fee ?? 25 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_coat_fee" id="actual_coat_fee" value="{{ $file_data->actual_coat_fee ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">2</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Association B/E Entry Fee</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_asso_be_entry_fee" id="bill_asso_be_entry_fee" value="{{ $file_data->bill_asso_be_entry_fee ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_asso_be_entry_fee" id="actual_asso_be_entry_fee" value="{{ $file_data->actual_asso_be_entry_fee ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">3</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">Cargo Branch </td>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_cargo_branch_aro" id="bill_cargo_branch_aro" value="{{ $file_data->bill_cargo_branch_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_cargo_branch_aro" id="actual_cargo_branch_aro" value="{{ $file_data->actual_cargo_branch_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">RO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_cargo_branch_ro" id="bill_cargo_branch_ro" value="{{ $file_data->bill_cargo_branch_ro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_cargo_branch_ro" id="actual_cargo_branch_ro" value="{{ $file_data->actual_cargo_branch_ro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">AC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_cargo_branch_ac" id="bill_cargo_branch_ac" value="{{ $file_data->bill_cargo_branch_ac ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_cargo_branch_ac" id="actual_cargo_branch_ac" value="{{ $file_data->actual_cargo_branch_ac ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">4</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Manifest Dept.</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_manifest_dept" id="bill_manifest_dept" value="{{ $file_data->bill_manifest_dept ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_manifest_dept" id="actual_manifest_dept" value="{{ $file_data->actual_manifest_dept ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">5</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">42 Number Shed</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_fourtytwo_shed_aro" id="bill_fourtytwo_shed_aro" value="{{ $file_data->bill_fourtytwo_shed_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_fourtytwo_shed_aro" id="actual_fourtytwo_shed_aro" value="{{ $file_data->actual_fourtytwo_shed_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">6</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">Examination</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Normal</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_examination_normal" id="bill_examination_normal" value="{{ $file_data->bill_examination_normal ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_examination_normal" id="actual_examination_normal" value="{{ $file_data->actual_examination_normal ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">IMR</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_examination_irm" id="bill_examination_irm" value="{{ $file_data->bill_examination_irm ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_examination_irm" id="actual_examination_irm" value="{{ $file_data->actual_examination_irm ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">Goinda</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_examination_goinda" id="bill_examination_goinda" value="{{ $file_data->bill_examination_goinda ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_examination_goinda" id="actual_examination_goinda" value="{{ $file_data->actual_examination_goinda ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="7">6</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="7">Assessement</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_aro" id="bill_assessement_aro" value="{{ $file_data->bill_assessement_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_aro" id="actual_assessement_aro" value="{{ $file_data->actual_assessement_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">RO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_ro" id="bill_assessement_ro" value="{{ $file_data->bill_assessement_ro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_ro" id="actual_assessement_ro" value="{{ $file_data->actual_assessement_ro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">AC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_ac" id="bill_assessement_ac" value="{{ $file_data->bill_assessement_ac ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_ac" id="actual_assessement_ac" value="{{ $file_data->actual_assessement_ac ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">DC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_dc" id="bill_assessement_dc" value="{{ $file_data->bill_assessement_dc ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_dc" id="actual_assessement_dc" value="{{ $file_data->actual_assessement_dc ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">JC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_jc" id="bill_assessement_jc" value="{{ $file_data->bill_assessement_jc ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_jc" id="actual_assessement_jc" value="{{ $file_data->actual_assessement_jc ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">ADC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_adc" id="bill_assessement_adc" value="{{ $file_data->bill_assessement_adc ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_adc" id="actual_assessement_adc" value="{{ $file_data->actual_assessement_adc ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">Commissioner</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_commissionar" id="bill_assessement_commissionar" value="{{ $file_data->bill_assessement_commissionar ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_commissionar" id="actual_assessement_commissionar" value="{{ $file_data->actual_assessement_commissionar ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">8</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">Lab Test Fee</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Receptable</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_lab_test_fee_receptable" id="bill_lab_test_fee_receptable" value="{{ $file_data->bill_lab_test_fee_receptable ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_lab_test_fee_receptable" id="actual_lab_test_fee_receptable" value="{{ $file_data->actual_lab_test_fee_receptable ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">Sample Processing</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_lab_test_fee_sample_processing" id="bill_lab_test_fee_sample_processing" value="{{ $file_data->bill_lab_test_fee_sample_processing ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_lab_test_fee_sample_processing" id="actual_lab_test_fee_sample_processing" value="{{ $file_data->actual_lab_test_fee_sample_processing ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">9</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Group+Sipay</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_group_sipay" id="bill_group_sipay" value="{{ $file_data->bill_group_sipay ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_group_sipay" id="actual_group_sipay" value="{{ $file_data->actual_group_sipay ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">10</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Bank Chalan</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_bank_chalan" id="bill_bank_chalan" value="{{ $file_data->bill_bank_chalan ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_bank_chalan" id="actual_bank_chalan" value="{{ $file_data->actual_bank_chalan ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">11</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Bank Chalan (Evening charge)</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_bank_chalan_evening" id="bill_bank_chalan_evening" value="{{ $file_data->bill_bank_chalan_evening ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_bank_chalan_evening" id="actual_bank_chalan_evening" value="{{ $file_data->actual_bank_chalan_evening ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">12</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Delivery cost</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_delivery_cost" id="bill_delivery_cost" value="{{ $file_data->bill_delivery_cost ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_delivery_cost" id="actual_delivery_cost" value="{{ $file_data->actual_delivery_cost ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">13</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">Unstamping Department</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">RO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_unstamping_dep_ro" id="bill_unstamping_dep_ro" value="{{ $file_data->bill_unstamping_dep_ro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_unstamping_dep_ro" id="actual_unstamping_dep_ro" value="{{ $file_data->actual_unstamping_dep_ro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_unstamping_dep_aro" id="bill_unstamping_dep_aro" value="{{ $file_data->bill_unstamping_dep_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_unstamping_dep_aro" id="actual_unstamping_dep_aro" value="{{ $file_data->actual_unstamping_dep_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">14</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Loading/Un-Loading</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_load_unload" id="bill_load_unload" value="{{ $file_data->bill_load_unload ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_load_unload" id="actual_load_unload" value="{{ $file_data->actual_load_unload ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">15</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Shed</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_shed" id="bill_shed" value="{{ $file_data->bill_shed ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_shed" id="actual_shed" value="{{ $file_data->actual_shed ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">16</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Exit</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_exit" id="bill_exit" value="{{ $file_data->bill_exit ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_exit" id="actual_exit" value="{{ $file_data->actual_exit ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">17</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Finaly Out get</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_finaly_out_get" id="bill_finaly_out_get" value="{{ $file_data->bill_finaly_out_get ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_finaly_out_get" id="actual_finaly_out_get" value="{{ $file_data->actual_finaly_out_get ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">18</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">File Commission</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_file_commission" id="bill_file_commission" value="{{ $file_data->bill_file_commission ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_file_commission" id="actual_file_commission" value="{{ $file_data->actual_file_commission ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">19</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Other Cost</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_other_cost" id="bill_other_cost" value="{{ $file_data->bill_other_cost ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_other_cost" id="actual_other_cost" value="{{ $file_data->actual_other_cost ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>





                                    <tr class="bg-gray-50 font-semibold">
                                        <td class="border border-gray-700 px-4 py-2" colspan="3">Total</td>
                                        <td class="border border-gray-700 px-4 py-2 text-right">
                                            <input type="number" name="bill_total" id="bill_total" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                        <td class="border border-gray-700 px-4 py-2 text-right">
                                            <input type="number" name="actual_total" id="actual_total" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>




                        <div class="self-end col-span-2 flex justify-end">
                            <input type="hidden" name="bill_no" value="{{$file_data->bill_no}}">
                            <input type="submit" value="Update"
                                class="font-mont px-10 py-4 bg-cyan-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110"
                                id="baccountSaveBtn">
                        </div><!-- end -->



                    </div>
                </form>
            </div>
        </div>
    </div>


    <x-slot name="script">

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>

            // Initialize all event handlers
            function initializeEventHandlers() {
                // Handle number input changes for both bill and actual fields
                $('#fileReciveForm input[type="number"][id^="bill_"], #fileReciveForm input[type="number"][id^="actual_"]').on('input', function() {
                    // Make sure all number inputs value should not be lower than 0.00
                    if (parseFloat($(this).val()) < 0) {
                        $(this).val('0.00');
                    }
                    calculateTotal();
                });

                // Link corresponding bill and actual fields
                $('#fileReciveForm input[type="number"][id^="bill_"]').on('input', function() {
                    const actualId = $(this).attr('id').replace('bill_', 'actual_');
                    if (!$('#' + actualId).val()) {
                        $('#' + actualId).val($(this).val()).trigger('input');
                    }
                });
            }

            $(document).ready(function () {
                // Initialize handlers
                initializeEventHandlers();

                // Initial calculation
                calculateTotal();

            });

            // Calculate both totals
            function calculateTotal() {
                // Calculate bill total
                let billTotal = 0.00;
                $('input[type="number"][id^="bill_"]').not('#bill_total').each(function() {
                    const value = parseFloat($(this).val()) || 0.00;
                    billTotal += value;
                });
                $('#bill_total').val(billTotal.toFixed(2));

                // Calculate actual total
                let actualTotal = 0.00;
                $('input[type="number"][id^="actual_"]').not('#actual_total').each(function() {
                    const value = parseFloat($(this).val()) || 0.00;
                    actualTotal += value;
                });
                $('#actual_total').val(actualTotal.toFixed(2));
            }

            // Print function
            function printDiv() {
                let printContent = $('.printdiv').html();
                let originalContent = $('body').html();

                $('body').html(printContent);
                window.print();
                $('body').html(originalContent);
            }
        </script>
    </x-slot>

</x-app-layout>
