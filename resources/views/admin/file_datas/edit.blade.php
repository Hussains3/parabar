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
    <div class="flex gap-6">
        <!-- Payment Section -->
        <div class="card mx-auto">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Payment Management</h2>

                <div class="mb-4">
                    <div class="flex justify-between mb-2">
                        <span>Payment Status:</span>
                        <span class="font-semibold">{{ ($file_data->status) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Total Bill Amount:</span>
                        <span class="font-semibold">৳{{ number_format($file_data->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Total Paid:</span>
                        <span class="font-semibold text-green-600">৳{{ number_format($file_data->total_paid ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span>Balance:</span>
                        <span class="font-semibold text-red-600">৳{{ number_format($file_data->balance, 2) }}</span>
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
                                    max="{{$file_data->total-$file_data->total_paid}}"
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

        <div class="card flex-grow mx-auto printdiv">
            <div class="p-6">

                {{-- File Edit Form --}}
                <form class="" id="fileEditForm" enctype="multipart/form-data"
                    action="{{ route('file_datas.update', $file_data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="">

                        {{-- File Information --}}
                        <div class="card p-4">
                            <p class="text-sm font-semibold text-seagreen">File Information</p>

                            <div class="grid grid-cols-3 gap-x-2 gap-y-1">
                                <div class="flex items-center">
                                    <label for="job_no">JOB NO:</label>
                                    <input type="text" name="job_no" id="job_no" class="form-none"
                                        placeholder="Enter Job No" value="{{ $file_data->job_no }}">
                                </div>
                                <div class="flex items-center">
                                    <label for="bill_no">BILL NO:</label>
                                    <input type="text" name="bill_no" id="bill_no" class="form-none" readonly value="{{ $file_data->bill_no }}">
                                </div>
                                <div class="flex items-center">
                                    <label for="ie_data_id">TO M/S</label>
                                    <select name="ie_data_id" id="ie_data_id" class="form-none">
                                        @foreach ($ie_datas as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($file_data->ie_data_id == $item->id) selected @endif>{{ $item->org_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> <!-- end -->

                                <div class="flex items-center">
                                    <label for="manifest_number">Manifest No</label>
                                    <input type="text" class="form-none" id="manifest_number"
                                        name="manifest_number" placeholder="Manifestnumber" required value="{{ $file_data->manifest_number }}">

                                </div> <!-- end -->


                                <div class="flex items-center">
                                    <label for="file_date">B/E Date</label>
                                    <input type="text" class="form-none" id="file_date" name="file_date" required
                                        value="{{ $file_data->file_date }}">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="package">Total Pkg</label>
                                    <input type="text" class="form-none" id="package" name="package" required value="{{ $file_data->package }}">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="delivary_date">Delivary Date</label>
                                    <input type="text" class="form-none" id="delivary_date" name="delivary_date"
                                        required value="{{ $file_data->delivary_date }}">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="lc_no">LC Number</label>
                                    <input type="text" class="form-none" id="lc_no" name="lc_no" required value="{{ $file_data->lc_no }}">

                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="net_wt">N.WT</label>
                                    <input type="text" class="form-none" id="net_wt" name="net_wt" value="{{ $file_data->net_wt }}">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="goods_name">Goods</label>
                                    <input type="text" class="form-none" id="goods_name" name="goods_name" value="{{ $file_data->goods_name }}">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="invoice_number">Invoice No</label>
                                    <input type="number" class="form-none" id="invoice_number"
                                        name="invoice_number" step="0.01" required value="{{ $file_data->invoice_number }}">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="invoice_date">Invoice Date</label>
                                    <input type="date" class="form-none" id="invoice_date" name="invoice_date"
                                        step="0.01" value="{{ $file_data->invoice_date }}">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="be_number">B/E No</label>
                                    <input type="text" class="form-none" id="be_number" name="be_number"
                                        placeholder="B/E Number" required value="{{ $file_data->be_number }}">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="be_date">B/E Date</label>
                                    <input type="text" class="form-none" id="be_date" name="be_date"
                                        placeholder="B/E Number" required value="{{ $file_data->be_date }}">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="lc_value">Invoice Value</label>
                                    <input type="number" class="form-none" id="lc_value" name="lc_value"
                                        step="0.01" required value="{{ $file_data->lc_value }}">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="dollar_rate">Dollar Rate</label>
                                    <input type="number" class="form-none" id="dollar_rate" name="dollar_rate" value="{{ $file_data->dollar_rate }}">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="ass_value">Ass Value</label>
                                    <input type="number" class="form-none" id="ass_value" name="ass_value"
                                        readonly value="{{ $file_data->ass_value }}">
                                </div> <!-- end -->
                            </div>
                        </div>

                        {{-- Goods Information --}}
                        <div class="card p-4">
                            <p class="text-sm font-semibold text-seagreen">Goods Information</p>
                            <table class="border-collapse border border-gray-400 w-full">
                                <tr>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">Goods recept DT</td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right"><input type="date"
                                            class="bg-transparent border-none p-0 w-full" id="goods_recept_date"
                                            name="goods_recept_date" value="{{ $file_data->goods_recept_date }}"></td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">Document recept DT</td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right"><input type="date"
                                            class="bg-transparent border-none p-0 w-full" id="document_recept_date"
                                            name="document_recept_date" value="{{ $file_data->document_recept_date }}"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">Bond license recept DT
                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right"><input type="date"
                                            class="bg-transparent border-none p-0 w-full"
                                            id="bond_license_recept_date" name="bond_license_recept_date" value="{{ $file_data->bond_license_recept_date }}"></td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">Advance TK recept DT
                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right"><input type="date"
                                            class="bg-transparent border-none p-0 w-full" id="advance_paid_date"
                                            name="advance_paid_date" value="{{ $file_data->advance_paid_date }}"></td>
                                </tr>
                            </table>
                        </div>

                        <div class="grid grid-cols-6">
                            {{-- Remarks --}}
                            <div class="card p-4 col-span-2 gap-4">
                                <div class="text-sm font-semibold text-seagreen">Remarks</div>
                                <table class="border-collapse border border-gray-400 w-full" id="remarksTable">
                                    <tbody>
                                        @if(is_array($file_data->remarks) && count($file_data->remarks) > 0)
                                            @foreach($file_data->remarks as $remark)
                                            <tr>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left">
                                                    <input type="text" class="bg-transparent border-none p-0" name="remarks_name[]" value="{{ $remark['name'] ?? '-' }}">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] relative group">
                                                    <input type="number" class="text-left bg-transparent border-none p-0 max-w-10" name="remarks_value[]" value="{{ $remark['value'] ?? 0 }}">
                                                    <button type="button" class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left">
                                                    <input type="text" class="bg-transparent border-none p-0" name="remarks_name[]" value="-">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] relative group">
                                                    <input type="number" class="text-left bg-transparent border-none p-0 max-w-10" name="remarks_value[]" value="0">
                                                    <button type="button" class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            {{-- Receiptable --}}
                            <div class="card p-4 col-span-4">
                                <div class="text-sm font-semibold text-seagreen">Receiptable</div>
                                <table class="border-collapse border border-gray-400 w-full" id="receiptableTable">
                                    <thead>
                                        <th class="border border-gray-400 px-1 py-[1px] text-left w-16">Description
                                        </th>
                                        <th class="border border-gray-400 px-1 py-[1px] text-left w-16">No</th>
                                        <th class="border border-gray-400 px-1 py-[1px] text-left w-16">Date</th>
                                        <th class="border border-gray-400 px-1 py-[1px] text-right w-16 text-nowrap">
                                            Amount (Tk)</th>
                                    </thead>
                                    <tbody>
                                        @if(is_array($file_data->receptables) && count($file_data->receptables) > 0)
                                            @foreach($file_data->receptables as $item)
                                            <tr>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left min-w-96">
                                                    <input type="text" class="bg-transparent border-none p-0 w-full"
                                                        name="receptable_descriptions[]" value="{{ $item['description'] ?? '-' }}">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-center min-w-32">
                                                    <input type="text" class="bg-transparent border-none p-0 w-full"
                                                        name="receptable_numbers[]" value="{{ $item['number'] ?? '-' }}">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left min-w-32">
                                                    <input type="text" class="bg-transparent border-none p-0 w-full"
                                                        name="receptable_date[]" value="{{ $item['date'] ?? '-' }}">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-right max-w-32 relative group">
                                                    <input type="number" class="bg-transparent border-none p-0 w-28" name="receptable_amounts[]" value="{{ $item['amount'] ?? 0 }}">
                                                    <button type="button" class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible rowRemove" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left min-w-96">
                                                    <input type="text" class="bg-transparent border-none p-0 w-full"
                                                        name="receptable_descriptions[]" value="-">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-center min-w-32">
                                                    <input type="text" class="bg-transparent border-none p-0 w-full"
                                                        name="receptable_numbers[]" value="-">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left min-w-32">
                                                    <input type="text" class="bg-transparent border-none p-0 w-full"
                                                        name="receptable_date[]" value="-">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-right max-w-32 relative group">
                                                    <input type="number" class="bg-transparent border-none p-0 w-28" name="receptable_amounts[]" value="0">
                                                    <button type="button" class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible rowRemove" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="border border-gray-400 px-1 py-[1px] text-left w-16"
                                                colspan="3">Total Receptable</td>
                                            <td class="border border-gray-400 px-1 py-[1px] text-right w-16">
                                                <input type="number" name="receptable_total" id="receptable_total" class="bg-transparent border-none p-0 w-full" value="{{ $file_data->receptable_total ?? 0 }}">
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- Miscellaneous and Other Information --}}
                        <div class="card p-4">
                            <div class="text-sm font-semibold text-seagreen">Miscellaneous and Others</div>
                            <table class="border border-gray-400 border-collapse w-full" id="miscellaneousTable">
                                <thead>
                                    <th class="border border-gray-400 px-1 py-[1px] text-left">Details</th>
                                    <th class="border border-gray-400 px-1 py-[1px] text-left">No</th>
                                    <th class="border border-gray-400 px-1 py-[1px] text-left">Date</th>
                                    <th class="border border-gray-400 px-1 py-[1px] text-left">Cost</th>
                                    <th class="border border-gray-400 px-1 py-[1px] text-right">Amount (Tk)</th>
                                </thead>
                                <tbody>
                                    @php
                                        // Ensure miscellaneouses is an array and decode if it's a JSON string
                                        $miscellaneouses = $file_data->miscellaneouses;
                                        if (is_string($miscellaneouses)) {
                                            $miscellaneouses = json_decode($miscellaneouses, true);
                                        }
                                        $miscellaneouses = is_array($miscellaneouses) ? $miscellaneouses : [];
                                    @endphp

                                    @if (!empty($miscellaneouses) && count($miscellaneouses) > 0)
                                        @foreach ($miscellaneouses as $miscellaneous)
                                            <tr>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left">
                                                    <input type="text" name="miscellaneous_detailses[]"
                                                        class="bg-transparent border-none p-0 w-full"
                                                        value="{{ $miscellaneous['details'] ?? '-' }}">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left max-w-28">
                                                    <input type="text" name="miscellaneous_numbers[]"
                                                        class="bg-transparent border-none p-0 max-w-28"
                                                        value="{{ $miscellaneous['number'] ?? '-' }}">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left max-w-28">
                                                    <input type="text" name="miscellaneous_dates[]"
                                                        class="bg-transparent border-none p-0 max-w-28"
                                                        value="{{ $miscellaneous['date'] ?? '-' }}">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left max-w-28">
                                                    <input type="text" name="miscellaneous_costs[]"
                                                        class="bg-transparent border-none p-0 max-w-28"
                                                        value="{{ $miscellaneous['cost'] ?? '-' }}">
                                                </td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-right max-w-28 relative group">
                                                    <input type="text" name="miscellaneous_amounts[]"
                                                        class="bg-transparent border-none p-0 w-full"
                                                        value="{{ $miscellaneous['amount'] ?? '0' }}">
                                                    <button type="button"
                                                        class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible rowRemove"
                                                        onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="border border-gray-400 px-1 py-[1px] text-left">
                                                <input type="text" name="miscellaneous_detailses[]"
                                                    class="bg-transparent border-none p-0 w-full" value="-">
                                            </td>
                                            <td class="border border-gray-400 px-1 py-[1px] text-left max-w-28">
                                                <input type="text" name="miscellaneous_numbers[]"
                                                    class="bg-transparent border-none p-0 max-w-28" value="-">
                                            </td>
                                            <td class="border border-gray-400 px-1 py-[1px] text-left max-w-28">
                                                <input type="text" name="miscellaneous_dates[]"
                                                    class="bg-transparent border-none p-0 max-w-28" value="-">
                                            </td>
                                            <td class="border border-gray-400 px-1 py-[1px] text-left max-w-28">
                                                <input type="text" name="miscellaneous_costs[]"
                                                    class="bg-transparent border-none p-0 max-w-28" value="-">
                                            </td>
                                            <td class="border border-gray-400 px-1 py-[1px] text-right max-w-28 relative group">
                                                <input type="text" name="miscellaneous_amounts[]"
                                                    class="bg-transparent border-none p-0 w-full" value="0">
                                                <button type="button"
                                                    class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible rowRemove"
                                                    onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="border border-gray-400 px-1 py-[1px] text-left px-4" colspan="3"></td>
                                        <td class="border border-gray-400 px-1 py-[1px] text-right">Total Miscellaneous
                                        </td>
                                        <td class="border border-gray-400 px-1 py-[1px] text-right w-16">
                                            <input type="number" name="miscellaneous_total" id="miscellaneous_total"
                                                class="bg-transparent border-none p-0 w-full"
                                                value="{{ $file_data->miscellaneous_total ?? 0 }}">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                        {{-- Payment Details --}}
                        <div class="card p-4">
                            <div class="text-sm font-semibold text-seagreen">PAYMENT DETAILS</div>
                            <table class="border border-gray-400 border-collapse w-full">
                                <tr>
                                    <td colspan="3" class="border border-gray-400 px-1 py-[1px] text-right">Total
                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="number" name="total" id="total"
                                            class="bg-transparent border-none p-0 text-right"
                                            value="{{ $file_data->total }}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="" class="border border-gray-400 px-1 py-[1px] text-right">Date
                                    </td>
                                    <td colspan="" class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="date" class="bg-transparent border-none p-0" value="{{ $file_data->advance_paid_date }}" name="advance_paid_date">
                                    </td>

                                    <td colspan="" class="border border-gray-400 px-1 py-[1px] text-right">Advance
                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">
                                        @php
                                           // Check if advance is already included in payments (by note 'Advance Payment')
                                            $hasAdvancePayment = collect($file_data->payments ?? [])->contains('note', 'Advance Payment');
                                            $advanceVal = $file_data->advance;
                                            
                                            // Make readonly if hasAdvancePayment? 
                                            // The user should still be able to edit it, and we sync it on backend.
                                        @endphp
                                        <input type="number" name="advance" id="advance"
                                            class="bg-transparent border-none p-0" value="{{ $advanceVal }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="border border-gray-400 px-1 py-[1px] text-right">Balance
                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="number" name="balance" id="balance"
                                            class="bg-transparent border-none p-0" value="{{ $file_data->balance }}"
                                            readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">In Word</td>
                                    <td colspan="3" class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="text" name="totalInWord" id="totalInWord"
                                            class="bg-transparent border-none p-0 w-full capitalize text-right"
                                            value="{{ $file_data->total_in_word }}">
                                    </td>
                                </tr>
                            </table>
                        </div>

                        {{-- Bank Details --}}
                        <div class="card p-4">
                            <div class="text-sm font-semibold text-seagreen">BANK DETAILS</div>
                            <table class="border border-gray-400 border-collapse w-full">
                                <tr>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">A/C NAME</td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="text" name="account_holder_name" id="account_holder_name"
                                            class="bg-transparent border-none p-0 w-full capitalize text-right"
                                            value="{{ $file_data->account_holder_name }}">
                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">AC NO</td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="text" name="account_number" id="account_number"
                                            class="bg-transparent border-none p-0 w-full capitalize text-right"
                                            value="{{ $file_data->account_number }}">
                                    </td>

                                </tr>
                                <tr>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">Bank Name</td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right" colspan="3">
                                        <input list="banks" class="bg-transparent border-none p-0 w-full text-right"
                                            name="lc_bank" id="lc_bank" value="{{ $file_data->lc_bank }}">
                                        <datalist id="banks">
                                            @php
                                                $banksJson = file_get_contents(base_path('banks.json'));
                                                $banks = json_decode($banksJson, true);
                                            @endphp
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank['BankName'] }}">
                                            @endforeach
                                        </datalist>
                                    </td>

                                </tr>
                            </table>
                        </div>


                        <div class="self-end col-span-2 flex justify-end">
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

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
           $(document).ready(function() {
            // Constants
            const SELECTORS = {
                billNo: '#bill_no',
                numberInputs: '#fileEditForm input[type="number"]',
                remarksTable: '#remarksTable',
                receiptableTable: '#receiptableTable',
                miscellaneousTable: '#miscellaneousTable',
                receptableTotal: '#receptable_total',
                miscellaneousTotal: '#miscellaneous_total',
                total: '#total',
                advance: '#advance',
                balance: '#balance',
                totalInWord: '#totalInWord',
                lcValue: '#lc_value',
                dollarRate: '#dollar_rate',
                assValue: '#ass_value'
            };

            // Initialize
            // generateBillNumber(); // Don't generate bill number on edit
            setupEventListeners();
            calculateTotal();
            updateReceptableTotalAndPaymentTotal();
            updateMiscellaneousTotalAndPaymentTotal();

            // Setup all event listeners
            function setupEventListeners() {
                // Prevent negative numbers and trigger calculation
                $(SELECTORS.numberInputs).on('input', function() {
                    const $this = $(this);
                    if (parseFloat($this.val()) < 0) {
                        $this.val('0.00');
                    }
                    calculateTotal();
                });

                // Dynamic row addition
                $(SELECTORS.remarksTable).on('input', 'tr:last-child input',
                    () => addRowIfNeeded(SELECTORS.remarksTable, createRemarksRow));

                $(SELECTORS.receiptableTable + ' tbody').on('input', 'tr:last-child input',
                    () => addRowIfNeeded(SELECTORS.receiptableTable + ' tbody', createReceiptableRow));

                $(SELECTORS.miscellaneousTable + ' tbody').on('input', 'tr:last-child input',
                    () => addRowIfNeeded(SELECTORS.miscellaneousTable + ' tbody', createMiscellaneousRow));

                // Recalculate on input/change/removal
                $(SELECTORS.receiptableTable + ' tbody')
                    .on('input change', 'input[name="receptable_amounts[]"]', updateReceptableTotalAndPaymentTotal)
                    .on('click', '.rowRemove', updateReceptableTotalAndPaymentTotal);

                $(SELECTORS.miscellaneousTable + ' tbody')
                    .on('input change', 'input[name="miscellaneous_amounts[]"]', updateMiscellaneousTotalAndPaymentTotal)
                    .on('click', '.rowRemove', updateMiscellaneousTotalAndPaymentTotal);

                // Dollar to Taka conversion
                $(SELECTORS.lcValue + ', ' + SELECTORS.dollarRate).on('input', calculateAssValue);
                
                // Recalculate total/balance when advance changes
                $(SELECTORS.advance).on('input', calculateTotal);
            }

            // Generic function to calculate table totals
            function calculateTableTotal(inputSelector) {
                let total = 0;
                $(inputSelector).each(function() {
                    const value = parseFloat($(this).val());
                    if (!isNaN(value)) total += value;
                });
                return total;
            }

            // Update receptable total and payment total
            function updateReceptableTotalAndPaymentTotal() {
                const total = calculateTableTotal('input[name="receptable_amounts[]"]');
                $(SELECTORS.receptableTotal).val(total.toFixed(2));
                calculateTotal();
            }

            // Update miscellaneous total and payment total
            function updateMiscellaneousTotalAndPaymentTotal() {
                const total = calculateTableTotal('input[name="miscellaneous_amounts[]"]');
                $(SELECTORS.miscellaneousTotal).val(total.toFixed(2));
                calculateTotal();
            }

            // Calculate total cost
            function calculateTotal() {
                const receptableValue = parseFloat($(SELECTORS.receptableTotal).val()) || 0;
                const miscellaneousValue = parseFloat($(SELECTORS.miscellaneousTotal).val()) || 0;
                const total = receptableValue + miscellaneousValue;

                $(SELECTORS.total).val(total.toFixed(2));

                // Calculate balance - In edit mode, we might need to consider existing payments?
                // For now, mirroring create logic: Total - Advance
                // But wait, the controller logic uses total_paid. 
                // Let's assume the user edits current details which affects total, and advance is adjustable.
                
                const advance = parseFloat($(SELECTORS.advance).val()) || 0;
                
                // Balance Calculation
                // Logic: Balance = Total - Sum(All Payments)
                // "Sum(All Payments)" includes the Advance.
                // However, 'total_paid' from DB is a snapshot. When we edit 'advance' in this form,
                // we are effectively changing the 'Sum(All Payments)'.
                // So, effective_total_paid = (total_paid_from_db - old_advance_from_db) + current_advance_input
                
                // Get these values from data attributes or hidden inputs we need to add
                // We'll rely on the existing variables rendered in Blade or add new ones.
                // Assuming we can't easily add hidden inputs in this specific replace call without breaking layout,
                // let's grab them from PHP directly here since this is a Blade file.
                
                const totalPaidFromDb = {{ $file_data->total_paid ?? 0 }};
                
                // We need to know if the old 'total_paid' INCLUDED the old 'advance'.
                // Since we normalized the data, yes it should.
                // But we need the OLD advance value to subtract it.
                const oldAdvanceFromDb = {{ $file_data->advance ?? 0 }};
                
                // Base payments (excluding the advance component, which is editable)
                // If old_advance was 0, base payments is just total_paid.
                // If old_advance was > 0, and legacy logic didn't put it in payments, we have a problem.
                // BUT, my recent backend 'update'/'addPayment' logic fixed this for *touched* records.
                // For untouched records, 'total_paid' might NOT include 'advance'.
                
                // Wait, simply doing Balance = Total - Advance is what the Create form does.
                // For Edit, if we have "Other Payments" (e.g. partial payments made later), they reduce the balance.
                // So Balance = (Total - Advance) - OtherPayments.
                // OtherPayments = TotalPaidFromDB - (AdvanceComponentInTotalPaid).
                
                // Let's simplified this: 
                // Balance = Total - (TotalPaid - OldAdvance + NewAdvance)
                // Assume TotalPaid ALWAYS includes the OldAdvance (if recorded correctly).
                // If legacy record (Advance not in TotalPaid), then TotalPaid is just OtherPayments.
                
                // Correction: The backend now checks if "Advance Payment" note exists.
                // We can check that here too? No, complicated.
                
                // Safer Logic mimicking Frontend "View":
                // Balance = Total - Advance - (TotalPaid - OldAdvanceVerified)
                
                // Actually, let's look at the user request: "Balance should be calculate from total bill minus sum of all payments"
                // On the Edit Screen:
                // User sees "Total Paid" at the top (static text).
                // User changes "Total Bill".
                // User changes "Advance".
                
                // Let's assume 'total_paid' passed from controller is the Source of Truth for historical payments.
                // If we assume 'total_paid' includes the 'advance' stored in DB:
                let baseOtherPayments = 0;
                @php
                    $hasAdvancePayment = collect($file_data->payments ?? [])->contains('note', 'Advance Payment');
                    // If advance is in payments, existing TotalPaid includes it.
                    $dbTotalPaid = $file_data->total_paid ?? 0;
                    $dbAdvance = $file_data->advance ?? 0;
                    
                    if ($hasAdvancePayment) {
                        $otherPayments = $dbTotalPaid - $dbAdvance;
                    } else {
                        // Legacy: TotalPaid does NOT include advance.
                        $otherPayments = $dbTotalPaid; 
                    }
                @endphp
                
                baseOtherPayments = {{ $otherPayments }};
                
                // Balance = Total - (OtherPayments + NewAdvance)
                const balance = total - (baseOtherPayments + advance);
                
                // Update Inputs
                $(SELECTORS.balance).val(balance.toFixed(2));

                // Convert to words (assuming numberToWords function exists)
                if (typeof numberToWords === 'function') {
                    $(SELECTORS.totalInWord).val(numberToWords(balance));
                }
            }

            // Calculate dollar to taka conversion
            function calculateAssValue() {
                const lcValue = parseFloat($(SELECTORS.lcValue).val());
                const dollarRate = parseFloat($(SELECTORS.dollarRate).val());

                if (isNaN(lcValue) || isNaN(dollarRate)) {
                    $(SELECTORS.assValue).val('0.00');
                    return;
                }

                const assValue = lcValue * dollarRate;
                $(SELECTORS.assValue).val(assValue.toFixed(2));
            }

            // Generic function to add row if needed
            function addRowIfNeeded(tableSelector, rowCreator) {
                const $lastRow = $(tableSelector + ' tr:last');
                const hasContent = $lastRow.find('input').toArray().some(input =>
                    $(input).val() !== '' && $(input).val() !== '0'
                );

                if (hasContent) {
                    $(tableSelector).append(rowCreator());
                }
            }

            // Row creators
            function createRemarksRow() {
                return `<tr>
                    <td class="border border-gray-400 px-1 py-[1px] text-left">
                        <input type="text" class="bg-transparent border-none p-0" name="remarks_name[]">
                    </td>
                    <td class="border border-gray-400 px-1 py-[1px] relative group">
                        <input type="number" class="text-left bg-transparent border-none p-0 max-w-10" name="remarks_value[]" value="0">
                        <button type="button" class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible" onclick="removeRow(this)">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </td>
                </tr>`;
            }

            function createReceiptableRow() {
                return createTableRow([
                    { name: 'receptable_descriptions[]', type: 'text', value: '-', width: 'w-full' },
                    { name: 'receptable_numbers[]', type: 'text', value: '-', width: 'w-full', align: 'center' },
                    { name: 'receptable_date[]', type: 'text', value: '-', width: 'w-16' },
                    { name: 'receptable_amounts[]', type: 'text', value: '0', width: 'w-28', align: 'right', hasButton: true }
                ]);
            }

            function createMiscellaneousRow() {
                return createTableRow([
                    { name: 'miscellaneous_detailses[]', type: 'text', value: '-', width: 'w-full' },
                    { name: 'miscellaneous_numbers[]', type: 'text', value: '-', width: 'w-full', align: 'center' },
                    { name: 'miscellaneous_dates[]', type: 'text', value: '-', width: 'w-16' },
                    { name: 'miscellaneous_costs[]', type: 'text', value: '-', width: 'w-28' }, // Added Cost column
                    { name: 'miscellaneous_amounts[]', type: 'text', value: '0', width: 'w-28', align: 'right', hasButton: true }
                ]);
            }

            // Generic table row creator
            function createTableRow(columns) {
                let row = '<tr>';
                columns.forEach(col => {
                    const align = col.align || 'left';
                    const tdClass = col.hasButton ? 'relative group' : '';
                    row += `<td class="border border-gray-400 px-1 py-[1px] text-${align} ${col.width || ''} ${tdClass}">
                        <input type="${col.type}" class="bg-transparent border-none p-0 ${col.width || ''}"
                            name="${col.name}" value="${col.value}">`;
                    if (col.hasButton) {
                        row += `<button type="button" class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible" onclick="removeRow(this)">
                            <i class="mdi mdi-delete"></i>
                        </button>`;
                    }
                    row += '</td>';
                });
                row += '</tr>';
                return row;
            }

            // Make removeRow global
            window.removeRow = function(button) {
                $(button).closest('tr').remove();
                updateReceptableTotalAndPaymentTotal();
                updateMiscellaneousTotalAndPaymentTotal();
            };
            
            // Print function
            function printDiv() {
                let printContent = $('.printdiv').html();
                let originalContent = $('body').html();

                $('body').html(printContent);
                window.print();
                $('body').html(originalContent);
            }
        });
        </script>
    </x-slot>

</x-app-layout>
