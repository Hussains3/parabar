<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Input Bill Voucher</x-slot>


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



        {{-- Form --}}
        <div class="card flex-grow max-w-2xl mx-auto">
            <div class="p-6">
                <form class="" id="fileReciveForm" enctype="multipart/form-data"
                    action="{{ route('file_datas.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="">

                        {{-- Section One --}}
                        <div class="grid grid-cols-4 gap-4 mb-4 bg-center bg-no-repeat bg-contain bg-opacity-10 backdrop-blur-2xl"
                            style="background-image: url('{{ asset('bcnft.png') }}');">


                            <div class="col-span-4">
                                <label for="manifest_no" class="block mb-2">Importer/Exporter</label>
                                <select name="ie_data_id" id="ie_data_id" class="form-input">
                                    @foreach ($ie_datas as $item)
                                        <option value="{{ $item->id }}"
                                            @if (isset($_GET['id']) && $_GET['id'] == $item->id) selected @endif>{{ $item->org_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> <!-- end -->

                            <div class="">
                                <label for="manifest_number" class="block mb-2">Manifest Number</label>
                                <input type="text" class="form-input" id="manifest_number" name="manifest_number"
                                    placeholder="Manifestnumber" required autofocus>

                            </div> <!-- end -->

                            <div class="">
                                <label for="be_number" class="block mb-2">B/E Number</label>
                                <input type="text" class="form-input" id="be_number" name="be_number"
                                    placeholder="B/E Number" required>
                            </div> <!-- end -->
                            <div class="">
                                <label for="file_date" class="block mb-2">Date</label>
                                <input type="text" class="form-input" id="file_date" name="file_date"
                                    required value="{{ date('d/m/Y') }}">
                                {{-- skipme --}}
                            </div> <!-- end -->
                            <div class="">
                                <label for="package" class="block mb-2">Package</label>
                                <input type="text" class="form-input" id="package" name="package" required>

                            </div> <!-- end -->
                            <div class="">
                                <label for="lc_no" class="block mb-2">LC Number</label>
                                <input type="text" class="form-input" id="lc_no" name="lc_no" required>

                            </div> <!-- end -->
                            <div class="">
                                <label for="lc_value" class="block mb-2">LC Value</label>
                                <input type="number" class="form-input" id="lc_value" name="lc_value" step="0.01" required>

                            </div> <!-- end -->
                            <div class="col-span-2">
                                <label for="lc_bank" class="block mb-2">LC Bank</label>
                                <input list="banks" class="form-input" name="lc_bank" id="lc_bank">

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
                        {{-- Bill table --}}
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-700 mb-4">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-700 px-1 py-[1px] text-left w-16">Sl.</th>
                                        <th class="border border-gray-700 px-1 py-[1px] text-left">Subject</th>
                                        <th class="border border-gray-700 px-1 py-[1px] text-left w-32">Reference</th>
                                        <th class="border border-gray-700 px-1 py-[1px] text-right w-32">Cost</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">1</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Coat Fee</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_coat_fee" id="actual_coat_fee" value="25" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">2</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Association B/E Entry Fee</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_asso_be_entry_fee" id="actual_asso_be_entry_fee" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">3</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">Cargo Branch </td>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_cargo_branch_aro" id="actual_cargo_branch_aro" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">RO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_cargo_branch_ro" id="actual_cargo_branch_ro" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">AC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_cargo_branch_ac" id="actual_cargo_branch_ac" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">4</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Manifest Dept.</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_manifest_dept" id="actual_manifest_dept" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">5</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">42 Number Shed</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_fourtytwo_shed_aro" id="actual_fourtytwo_shed_aro" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">6</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">Examination</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Normal</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_examination_normal" id="actual_examination_normal" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">IMR</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_examination_irm" id="actual_examination_irm" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">Goinda</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_examination_goinda" id="actual_examination_goinda" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="7">6</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="7">Assessement</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_aro" id="actual_assessement_aro" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">RO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_ro" id="actual_assessement_ro" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">AC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_ac" id="actual_assessement_ac" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">DC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_dc" id="actual_assessement_dc" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">JC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_jc" id="actual_assessement_jc" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">ADC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_adc" id="actual_assessement_adc" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">Commissioner</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_assessement_commissionar" id="actual_assessement_commissionar" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">8</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">Lab Test Fee</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Receptable</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_lab_test_fee_receptable" id="actual_lab_test_fee_receptable" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">Sample Processing</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_lab_test_fee_sample_processing" id="actual_lab_test_fee_sample_processing" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">9</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Group+Sipay</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_group_sipay" id="actual_group_sipay" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">10</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Bank Chalan</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_bank_chalan" id="actual_bank_chalan" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">11</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Bank Chalan (Evening charge)</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_bank_chalan_evening" id="actual_bank_chalan_evening" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">12</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Delivery cost</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_delivery_cost" id="actual_delivery_cost" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">13</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">Unstamping Department</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">RO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_unstamping_dep_ro" id="actual_unstamping_dep_ro" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_unstamping_dep_aro" id="actual_unstamping_dep_aro" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">14</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Loading/Un-Loading</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_load_unload" id="actual_load_unload" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">15</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Shed</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_shed" id="actual_shed" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">16</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Exit</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_exit" id="actual_exit" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">17</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Finaly Out get</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_finaly_out_get" id="actual_finaly_out_get" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">18</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">File Commission</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_file_commission" id="actual_file_commission" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">19</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Other Cost</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="actual_other_cost" id="actual_other_cost" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>





                                    <tr class="bg-gray-50 font-semibold">
                                        <td class="border border-gray-700 px-4 py-2" colspan="3">Total</td>
                                        <td class="border border-gray-700 px-4 py-2 text-right">
                                            <input type="number" name="actual_total" id="actual_total" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>




                        <div class="self-end col-span-2 flex justify-end">
                            <input type="hidden" name="bill_no" id="bill_no">
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

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>

            $(document).ready(function () {

                //Before submitting the form generate bill no
                $('#fileReciveForm').on('submit', function(e) {
                    const date = new Date();
                    const year = date.getFullYear().toString().slice(-2); // Get last two digits of year
                    const month = ('0' + (date.getMonth() + 1)).slice(-2); // Get month with leading zero
                    const day = ('0' + date.getDate()).slice(-2); // Get day with leading zero
                    const randomNum = Math.floor(1000 + Math.random() * 9000); // Generate a random 4-digit number
                    const billNo = `BV${year}${month}${day}${randomNum}`;
                    $('#bill_no').val(billNo);
                });

                $('#fileReciveForm input[type="number"]').on('input', function() {
                    //Make sure all number inputs value should not be lower than 0.00
                    if (parseFloat($(this).val()) < 0) {
                        $(this).val('0.00');
                    }

                    calculateTotal();
                });
                // Initial calculation
                calculateTotal();
            });

            // Calculate total cost
            function calculateTotal() {
                let total = 0.00;
                $('#fileReciveForm input[type="number"]').not('#actual_total,#lc_value').each(function() {
                    const value = parseFloat($(this).val()) || 0.00;
                    total += value;
                });
                // Update the total field with 2 decimal places
                $('#actual_total').val(total.toFixed(2));
            }
        </script>
    </x-slot>

</x-app-layout>
