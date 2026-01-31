<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Input Bill Voucher</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">



        {{-- Form --}}
        <div class="card flex-grow max-w-7xl mx-auto">
            <div class="p-6">
                <!-- File create form -->
                <form class="" id="fileCreateForm" enctype="multipart/form-data"
                    action="{{ route('file_datas.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="">

                        {{-- File Information --}}
                        <h2 class="text-lg font-semibold text-center">Input Bill Voucher Information</h2>
                        <div class="card p-4">
                            <p class="text-sm font-semibold text-seagreen">File Information</p>

                            <div class="grid grid-cols-3 gap-x-2 gap-y-1">
                                <div class="flex items-center">
                                    <label for="job_no">JOB NO:</label>
                                    <input type="text" name="job_no" id="job_no" class="form-none"
                                        placeholder="Enter Job No">
                                </div>
                                <div class="flex items-center">
                                    <label for="bill_no">BILL NO:</label>
                                    <input type="text" name="bill_no" id="bill_no" class="form-none" readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="ie_data_id">TO M/S</label>
                                    <select name="ie_data_id" id="ie_data_id" class="form-none">
                                        @foreach ($ie_datas as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($_GET['id']) && $_GET['id'] == $item->id) selected @endif>{{ $item->org_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> <!-- end -->

                                <div class="flex items-center">
                                    <label for="manifest_number">Manifest No</label>
                                    <input type="text" class="form-none" id="manifest_number"
                                        name="manifest_number" placeholder="Manifestnumber" required autofocus>

                                </div> <!-- end -->


                                <div class="flex items-center">
                                    <label for="file_date">B/E Date</label>
                                    <input type="text" class="form-none" id="file_date" name="file_date" required
                                        value="{{ date('d/m/Y') }}">
                                    {{-- skipme --}}
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="package">Total Pkg</label>
                                    <input type="text" class="form-none" id="package" name="package" required>
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="delivary_date">Delivary Date</label>
                                    <input type="text" class="form-none" id="delivary_date" name="delivary_date"
                                        required value="{{ date('d/m/Y') }}">
                                    {{-- skipme --}}
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="lc_no">LC Number</label>
                                    <input type="text" class="form-none" id="lc_no" name="lc_no" required>

                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="net_wt">N.WT</label>
                                    <input type="text" class="form-none" id="net_wt" name="net_wt">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="goods_name">Goods</label>
                                    <input type="text" class="form-none" id="goods_name" name="goods_name">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="invoice_number">Invoice No</label>
                                    <input type="number" class="form-none" id="invoice_number"
                                        name="invoice_number" step="0.01" required>
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="invoice_date">Invoice Date</label>
                                    <input type="date" class="form-none" id="invoice_date" name="invoice_date"
                                        step="0.01">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="be_number">B/E No</label>
                                    <input type="text" class="form-none" id="be_number" name="be_number"
                                        placeholder="B/E Number" required>
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="be_date">B/E Date</label>
                                    <input type="text" class="form-none" id="be_date" name="be_date"
                                        placeholder="B/E Number" required>
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="lc_value">Invoice Value</label>
                                    <input type="number" class="form-none" id="lc_value" name="lc_value"
                                        step="0.01" required>
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="dollar_rate">Dollar Rate</label>
                                    <input type="number" class="form-none" id="dollar_rate" name="dollar_rate">
                                </div> <!-- end -->
                                <div class="flex items-center">
                                    <label for="ass_value">Ass Value</label>
                                    <input type="number" class="form-none" id="ass_value" name="ass_value"
                                        readonly>
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
                                            name="goods_recept_date"></td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">Document recept DT</td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right"><input type="date"
                                            class="bg-transparent border-none p-0 w-full" id="document_recept_date"
                                            name="document_recept_date"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">Bond license recept DT
                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right"><input type="date"
                                            class="bg-transparent border-none p-0 w-full"
                                            id="bond_license_recept_date" name="bond_license_recept_date"></td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">Advance TK recept DT
                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right"><input type="date"
                                            class="bg-transparent border-none p-0 w-full" id="advance_paid_date"
                                            name="advance_paid_date"></td>
                                </tr>
                            </table>
                        </div>

                        <div class="grid grid-cols-6">
                            {{-- Remarks --}}
                            <div class="card p-4 col-span-2 gap-4">
                                <div class="text-sm font-semibold text-seagreen">Remarks</div>
                                <table class="border-collapse border border-gray-400 w-full" id="remarksTable">
                                    <tbody>
                                        <tr>
                                            <td class="border border-gray-400 px-1 py-[1px] text-left">
                                                <input type="text" class="bg-transparent border-none p-0" name="remarks_name[]" value="-">
                                            </td>
                                            <td class="border border-gray-400 px-1 py-[1px] relative group">
                                                <input type="number" class="text-left bg-transparent border-none p-0 max-w-10" name="remarks_value[]" value="0">
                                                <button class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button>
                                            </td>
                                        </tr>
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
                                                <button class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible rowRemove" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="border border-gray-400 px-1 py-[1px] text-left w-16"
                                                colspan="3">Total Receptable</td>
                                            <td class="border border-gray-400 px-1 py-[1px] text-right w-16">
                                                <input type="number" name="receptable_total" id="receptable_total" class="bg-transparent border-none p-0 w-full">
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
                                    <tr>
                                        <td class="border border-gray-400 px-1 py-[1px] text-left">
                                            <input type="text" name="miscellaneous_detailses[]" class="bg-transparent border-none p-0 w-full" value="-">
                                        </td>
                                        <td class="border border-gray-400 px-1 py-[1px] text-left max-w-28">
                                            <input type="text" name="miscellaneous_numbers[]" class="bg-transparent border-none p-0 max-w-28" value="-">
                                        </td>
                                        <td class="border border-gray-400 px-1 py-[1px] text-left max-w-28">
                                            <input type="text" name="miscellaneous_dates[]" class="bg-transparent border-none p-0 max-w-28" value="-">
                                        </td>
                                        <td class="border border-gray-400 px-1 py-[1px] text-left max-w-28">
                                            <input type="text" name="miscellaneous_costs[]" class="bg-transparent border-none p-0 max-w-28" value="0">
                                        </td>
                                        <td class="border border-gray-400 px-1 py-[1px] text-right max-w-28 relative group">
                                            <input type="text" name="miscellaneous_amounts[]" class="bg-transparent border-none p-0 w-full" value="0">
                                            <button class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible rowRemove" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="border border-gray-400 px-1 py-[1px] text-left" colspan="3"></td>
                                        <td class="border border-gray-400 px-1 py-[1px] text-right">Total Miscellaneous
                                        </td>
                                        <td class="border border-gray-400 px-1 py-[1px] text-right w-16">
                                            <input type="number" name="miscellaneous_total" id="miscellaneous_total" class="bg-transparent border-none p-0 w-full">
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
                                            class="bg-transparent border-none p-0 text-right" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="" class="border border-gray-400 px-1 py-[1px] text-right">Date
                                    </td>
                                    <td colspan="" class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="date" class="bg-transparent border-none p-0" name="advance_paid_date">
                                    </td>

                                    <td colspan="" class="border border-gray-400 px-1 py-[1px] text-right">Advance

                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="number" name="advance" id="advance"
                                            class="bg-transparent border-none p-0" value="0">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="border border-gray-400 px-1 py-[1px] text-right">Balance
                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="number" name="balance" id="balance"
                                            class="bg-transparent border-none p-0" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">In Word</td>
                                    <td colspan="3" class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="text" name="totalInWord" id="totalInWord"
                                            class="bg-transparent border-none p-0 w-full capitalize text-right">
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
                                            class="bg-transparent border-none p-0 w-full capitalize text-right">
                                    </td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">AC NO</td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">
                                        <input type="text" name="account_number" id="account_number"
                                            class="bg-transparent border-none p-0 w-full capitalize text-right">
                                    </td>

                                </tr>
                                <tr>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right">Bank Name</td>
                                    <td class="border border-gray-400 px-1 py-[1px] text-right" colspan="3">
                                        <input list="banks" class="bg-transparent border-none p-0 w-full text-right"
                                            name="lc_bank" id="lc_bank">
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
                            <input type="submit" value="Submit"
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
                numberInputs: '#fileCreateForm input[type="number"]',
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
            generateBillNumber();
            setupEventListeners();
            calculateTotal();
            updateReceptableTotalAndPaymentTotal();
            updateMiscellaneousTotalAndPaymentTotal();

            // Generate bill number
            function generateBillNumber() {
                const date = new Date();
                const year = date.getFullYear().toString().slice(-2);
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const randomNum = Math.floor(1000 + Math.random() * 9000);
                $(SELECTORS.billNo).val(`BV${year}${month}${day}${randomNum}`);
            }

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

                // Calculate balance
                const advance = parseFloat($(SELECTORS.advance).val()) || 0;
                const balance = total - advance;
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
                    { name: 'miscellaneous_costs[]', type: 'text', value: '0', width: 'w-28' }, // Added Cost column
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
        });
        </script>
    </x-slot>

</x-app-layout>
