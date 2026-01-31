<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Parint Bill Voucher</x-slot>


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
        <div class="card flex-grow mx-auto printdiv">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <p>Date:{{$file_data->file_date}}</p>
                    <div class="flex flex-col items-center">
                        <div class="flex gap-2 items-center">
                            <img src="{{ asset('bcnf.png') }}" alt="Logo" class="h-12 w-auto">
                            <div class="">
                                <p class="uppercase font-bold text-xl ">Parabar Shipping</p>
                                <p class="uppercase ">since 1984</p>

                            </div>
                        </div>
                    </div>
                    <p>Bill No: {{$file_data->bill_no}}</p>
                </div>
                <p class="text-center mb-4">Mozid Tower (3rd floor),  Opposite of customs house,  Benapole, Jashore, Bangladesh</p>
                {{-- Form --}}
                <form class="" id="filePrintForm">
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

                        <div class="flex justify-between">
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
                                                <td class="border border-gray-400 px-1 py-[1px] text-left min-w-96">{{ $item['description'] ?? '-' }}</td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-center min-w-32">{{ $item['number'] ?? '-' }}</td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left min-w-32">{{ $item['date'] ?? '-' }}</td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-right max-w-32 relative group">{{ $item['amount'] ?? 0 }}</td>
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
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="border border-gray-400 px-1 py-[1px] text-left w-16" colspan="3">Total Receptable</td>
                                            <td class="border border-gray-400 px-1 py-[1px] text-right w-16">{{ $file_data->receptable_total ?? 0 }}</td>
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
                                    <th class="border border-gray-400 px-1 py-[1px] text-right text-nowrap">Amount (Tk)</th>
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
                                                <td class="border border-gray-400 px-1 py-[1px] text-left">{{ $miscellaneous['details'] ?? '-' }}</td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left max-w-28">{{ $miscellaneous['number'] ?? '-' }}</td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-left max-w-28">{{ $miscellaneous['date'] ?? '-' }}</td>
                                                <td class="border border-gray-400 px-1 py-[1px] text-right max-w-28 relative group">{{ $miscellaneous['amount'] ?? '0' }}</td>
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
                                            <td class="border border-gray-400 px-1 py-[1px] text-right max-w-28 relative group">
                                                <input type="text" name="miscellaneous_amounts[]"
                                                    class="bg-transparent border-none p-0 w-full" value="0">
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="border border-gray-400 px-1 py-[1px] text-left px-4" colspan="2"></td>
                                        <td class="border border-gray-400 px-1 py-[1px] text-right">Total Miscellaneous
                                        </td>
                                        <td class="border border-gray-400 px-1 py-[1px] text-right">{{ $file_data->miscellaneous_total ?? 0 }}</td>
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
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">{{ $file_data->total }}</td>
                                </tr>
                                <tr>
                                    <td colspan="" class="border border-gray-400 px-1 py-[1px] text-right">Date
                                    </td>
                                    <td colspan="" class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="date" class="bg-transparent border-none p-0" value="{{ $file_data->advance_paid_date }}" readonly>
                                    </td>

                                    <td colspan="" class="border border-gray-400 px-1 py-[1px] text-right">Advance</td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">
                                        @php
                                           // Check if advance is already included in payments (by note 'Advance Payment')
                                            $hasAdvancePayment = collect($file_data->payments ?? [])->contains('note', 'Advance Payment');
                                            $advanceVal = $file_data->advance;
                                            
                                            // Make readonly if hasAdvancePayment? 
                                            // The user should still be able to edit it, and we sync it on backend.
                                        @endphp

                                        {{ $advanceVal }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="border border-gray-400 px-1 py-[1px] text-right">Balance
                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">{{ $file_data->balance }}</td>
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
                            <input type="submit" value="Print"
                                class="font-mont px-10 py-4 bg-cyan-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110 print:hidden"
                                id="printBtn">
                        </div><!-- end -->

                    </div>
                </form>
            </div>
        </div>
    </div>


    <x-slot name="script">

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            $('#printBtn').on('click', function(e) {
                e.preventDefault();
                window.print();
            });


        </script>
    </x-slot>

</x-app-layout>
