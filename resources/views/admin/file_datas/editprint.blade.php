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





        <div class="card flex-grow max-w-2xl mx-auto printdiv">
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
                <form class="" id="fileReciveForm" enctype="multipart/form-data"
                    action="{{ route('file_datas.updateprint', $file_data) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="">
                        <div class="mb-2">
                            <div class="font-semibold text-base col-span-4">
                                <p>Importer/Exporter: {{$file_data->ie_data->org_name}}</p>
                            </div> <!-- end -->
                            <div class="flex justify-between gap-8">
                                <div class="">
                                    <div class=" text-base col-span-2">
                                        <p>Manifest Number: {{$file_data->manifest_number}}</p>
                                    </div> <!-- end -->
                                    <div class=" text-base ">
                                        <p>B/E Number: {{$file_data->be_number}}</p>
                                    </div> <!-- end -->
                                    <div class=" text-base ">
                                        <p>Package: {{$file_data->package}}</p>
                                    </div> <!-- end -->
                                </div>
                                <div class="">
                                    <div class=" text-base ">
                                        <p>LC Number: {{$file_data->lc_no}}</p>
                                    </div> <!-- end -->
                                    <div class=" text-base ">
                                        <p>LC Value: {{$file_data->lc_value}}</p>
                                    </div> <!-- end -->
                                </div>
                            </div>
                            <div class="text-base col-span-2">
                                <p>LC Bank: {{$file_data->lc_bank}}</p>
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
                                            <input type="number" name="bill_coat_fee" id="bill_coat_fee" value="{{ $file_data->actual_coat_fee ?? 25 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">2</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Association B/E Entry Fee</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_asso_be_entry_fee" id="bill_asso_be_entry_fee" value="{{ $file_data->actual_asso_be_entry_fee ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">3</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">Cargo Branch </td>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_cargo_branch_aro" id="bill_cargo_branch_aro" value="{{ $file_data->actual_cargo_branch_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">RO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_cargo_branch_ro" id="bill_cargo_branch_ro" value="{{ $file_data->actual_cargo_branch_ro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">AC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_cargo_branch_ac" id="bill_cargo_branch_ac" value="{{ $file_data->actual_cargo_branch_ac ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">4</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Manifest Dept.</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_manifest_dept" id="bill_manifest_dept" value="{{ $file_data->actual_manifest_dept ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">5</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">42 Number Shed</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_fourtytwo_shed_aro" id="bill_fourtytwo_shed_aro" value="{{ $file_data->actual_fourtytwo_shed_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">6</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="3">Examination</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Normal</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_examination_normal" id="bill_examination_normal" value="{{ $file_data->actual_examination_normal ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">IMR</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_examination_irm" id="bill_examination_irm" value="{{ $file_data->actual_examination_irm ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">Goinda</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_examination_goinda" id="bill_examination_goinda" value="{{ $file_data->actual_examination_goinda ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="7">6</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="7">Assessement</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_aro" id="bill_assessement_aro" value="{{ $file_data->actual_assessement_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">RO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_ro" id="bill_assessement_ro" value="{{ $file_data->actual_assessement_ro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">AC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_ac" id="bill_assessement_ac" value="{{ $file_data->actual_assessement_ac ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">DC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_dc" id="bill_assessement_dc" value="{{ $file_data->actual_assessement_dc ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">JC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_jc" id="bill_assessement_jc" value="{{ $file_data->actual_assessement_jc ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">ADC</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_adc" id="bill_assessement_adc" value="{{ $file_data->actual_assessement_adc ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">Commissioner</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_assessement_commissionar" id="bill_assessement_commissionar" value="{{ $file_data->actual_assessement_commissionar ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">8</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">Lab Test Fee</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Receptable</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_lab_test_fee_receptable" id="bill_lab_test_fee_receptable" value="{{ $file_data->actual_lab_test_fee_receptable ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">Sample Processing</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_lab_test_fee_sample_processing" id="bill_lab_test_fee_sample_processing" value="{{ $file_data->actual_lab_test_fee_sample_processing ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">9</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Group+Sipay</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_group_sipay" id="bill_group_sipay" value="{{ $file_data->actual_group_sipay ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">10</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Bank Chalan</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_bank_chalan" id="bill_bank_chalan" value="{{ $file_data->actual_bank_chalan ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">11</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Bank Chalan (Evening charge)</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_bank_chalan_evening" id="bill_bank_chalan_evening" value="{{ $file_data->actual_bank_chalan_evening ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">12</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Delivery cost</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_delivery_cost" id="bill_delivery_cost" value="{{ $file_data->actual_delivery_cost ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">13</td>
                                        <td class="border border-gray-700 px-1 py-[1px]" rowspan="2">Unstamping Department</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">RO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_unstamping_dep_ro" id="bill_unstamping_dep_ro" value="{{ $file_data->actual_unstamping_dep_ro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">ARO</td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_unstamping_dep_aro" id="bill_unstamping_dep_aro" value="{{ $file_data->actual_unstamping_dep_aro ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">14</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Loading/Un-Loading</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_load_unload" id="bill_load_unload" value="{{ $file_data->actual_load_unload ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">15</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Shed</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_shed" id="bill_shed" value="{{ $file_data->actual_shed ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">16</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Exit</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_exit" id="bill_exit" value="{{ $file_data->actual_exit ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">17</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Finaly Out get</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_finaly_out_get" id="bill_finaly_out_get" value="{{ $file_data->actual_finaly_out_get ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">18</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">File Commission</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_file_commission" id="bill_file_commission" value="{{ $file_data->actual_file_commission ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-700 px-1 py-[1px]">19</td>
                                        <td class="border border-gray-700 px-1 py-[1px]">Other Cost</td>
                                        <td class="border border-gray-700 px-1 py-[1px]"></td>
                                        <td class="border border-gray-700 px-1 py-[1px] text-right">
                                            <input type="number" name="bill_other_cost" id="bill_other_cost" value="{{ $file_data->actual_other_cost ?? 0 }}" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>





                                    <tr class="bg-gray-50 font-semibold">
                                        <td class="border border-gray-700 px-4 py-2" colspan="3">Total</td>
                                        <td class="border border-gray-700 px-4 py-2 text-right">
                                            <input type="number" name="bill_total" id="bill_total" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50 font-semibold">
                                        <td class="border border-gray-700 px-4 py-2" colspan="3">Total Paid</td>
                                        <td class="border border-gray-700 px-4 py-2 text-right">
                                            <input type="number" name="total_paid" id="total_paid" value="0" step="1" class="border-0 text-right w-full bg-transparent p-0 m-0">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>




                        <div class="self-end col-span-2 flex justify-end">
                            <input type="hidden" name="status" value="Paid">
                            <input type="submit" value="Print & Save"
                                class="font-mont print:hidden px-10 py-4 bg-cyan-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110"
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
                // Handle number input changes
                $('#fileReciveForm input[type="number"]').on('input', function() {
                    //Make sure all number inputs value should not be lower than 0.00
                    if (parseFloat($(this).val()) < 0) {
                        $(this).val('0.00');
                    }
                    calculateTotal();
                });
            }

            $(document).ready(function () {
                // Initialize handlers
                initializeEventHandlers();

                // Initial calculation
                calculateTotal();

                // Handle form submission
                $('#fileReciveForm').on('submit', function(e) {
                    e.preventDefault();

                    const $form = $(this);
                    const $submitBtn = $form.find('input[type="submit"]');

                    // Disable submit button to prevent double submission
                    $submitBtn.prop('disabled', true);

                    $.ajax({
                        url: $form.attr('action'),
                        method: 'POST',
                        data: $form.serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSubmit: function(arr, $form, options) {
                            console.log(data);
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                // Prepare print content
                                const $printArea = $('.printdiv').clone();
                                // Print the content
                                const originalContent = $('body').html();
                                $('body').empty().append($printArea);
                                window.print();
                                $('body').html(originalContent);

                                // Re-initialize event handlers after restoring content
                                initializeEventHandlers();
                                calculateTotal();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error details:', xhr.responseJSON || error);
                            alert('Error submitting form. Please try again or contact support.');
                        },
                        complete: function() {
                            // Re-enable submit button
                            $submitBtn.prop('disabled', false);
                        }
                    });
                });
            });

            // Calculate total cost
            function calculateTotal() {
                let total = 0.00;
                $('#fileReciveForm input[type="number"]').not('#bill_total,#lc_value,#total_paid').each(function() {
                    const value = parseFloat($(this).val()) || 0.00;
                    total += value;
                });
                // Update the total field with 2 decimal places
                $('#bill_total').val(total.toFixed(2));
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
