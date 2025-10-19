<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Transactions</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex gap-6">

        {{-- Form --}}
        <div class="card max-w-3xl">
            <div class="p-6">
                <h2 class="mb-4 text-xl">New Transaction</h2>

                <form class="" id="transactionCreateForm">

                    <div class="">
                        <div>
                            <label for="transaction_date" class="block mb-2">Transaction Date</label>
                            <input type="date" class="form-input" id="transaction_date" name="transaction_date" required>
                        </div> <!-- end -->

                        <div class="mt-4">
                            <label for="bank_account_id" class="block mb-2">Bank Account</label>
                            <select class="form-select" id="bank_account_id" name="bank_account_id" required>
                                <option selected="" disabled value="">Choose Account</option>
                                @foreach ($bankAccounts as $bankAccount)
                                    <option value="{{ $bankAccount->id }}">
                                        {{ $bankAccount->account_holder_name ?? '' }}{{ ' (' . $bankAccount->account_number . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div> <!-- end -->

                        <div class="mt-4">
                            <label for="txn_number" class="block mb-2">Transaction Number</label>
                            <input type="text" class="form-input" id="txn_number" name="txn_number"
                                placeholder="Account Number" required>
                        </div> <!-- end -->


                        <div class="mt-4">
                            <label class="block mb-2 after:content-['*'] after:text-red-500">Transaction Type</label>
                            <div class="flex gap-6">
                                <div class="flex items-center gap-4">
                                    <input type="radio" id="contactChoice1" name="type" value="deposit" checked>
                                    <label for="contactChoice1">Deposit</label>
                                </div>
                                <div class="flex items-center gap-4">
                                    <input type="radio" id="contactChoice2" name="type" value="withdrawal">
                                    <label for="contactChoice2">Withdrawal</label>
                                </div>
                            </div>
                        </div> <!-- end -->



                        <div class="mt-4">
                            <label for="amount" class="block mb-2">Amount</label>
                            <input type="number" class="form-input" id="amount" name="amount" step="0.01" value="0.00">
                        </div> <!-- end -->

                        <div class=" mt-4">
                            <button type="submit"
                                class="font-mont mt-2 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300"
                                id="baccountSaveBtn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex-grow">
            <div class="">
                <ul class="flex gap-2 font-medium">
                    <li class="">
                        <a href="{{route('transactions.index')}}" class="hover:bg-white shadow-none rounded-t-lg px-6 py-2 flex items-center text-blue-500"> <span> <i class="mdi mdi-swap-vertical mr-2 text-lg"></i>All</span></a>
                    </li>
                    <li class="">
                        <a href="{{route('btransactions.deposit')}}" class="hover:bg-white shadow-none rounded-t-lg px-6 py-2 flex items-center text-green-400"><span><i class="mdi mdi-arrow-down mr-2 text-lg"></i>Deposits</span></a>
                    </li>
                    <li class="">
                        <a href="{{route('btransactions.withdrawal')}}" class="card shadow-none rounded-b-none px-6 py-2 flex items-center text-orange-400"><span><i class="mdi mdi-arrow-up mr-2 text-lg"></i>Withdrawal</span></a>
                    </li>
                    <li class="">
                        <a href="{{route('btransactions.trash')}}" class="hover:bg-white shadow-none rounded-t-lg px-6 py-2 flex items-center text-red-400"><span><i class="mdi mdi-delete mr-2 text-lg"></i>Trash</span></a>
                    </li>
                </ul>
            </div>

            {{-- Table --}}
            <div class="card rounded-tl-none">
                <div class="p-6">

                    <h2 class="mb-4 text-xl">Withdrawal Transaction</h2>
                    <table id="transactionsTable" class="display stripe text-xs sm:text-base" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Transaction Date</th>
                                <th>Bank Account</th>
                                <th>Transaction Number </th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>


    </div>


    <x-slot name="script">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            var datatablelist = $('#transactionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('btransactions.withdrawal') !!}",
                columns: [{
                        "render": function(data, type, full, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'transaction_date',
                        name: 'transaction_date'
                    },
                    {
                        data: 'bank_account_id',
                        name: 'bank_account_id'
                    },
                    {
                        data: 'txn_number',
                        name: 'txn_number'
                    },


                    {
                        data: null,
                        render: function(data) {
                            if (data.type == 'deposit') {
                                return `<span class="bg-green-500/40 text-xs px-2 py1 rounded-full capitalize">${data.type}</span>`;
                            } else {
                                return `<span class="bg-red-500/40 text-xs px-2 py1 rounded-full capitalize">${data.type}</span>`;
                            }
                        }
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `<div class="flex flex-col sm:flex-row gap-5 justify-end items-center">
                                <a href="${BASE_URL}transactions/${data.id}" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-eye"></i></span>
                                </a>
                                <a href="${BASE_URL}transactions/${data.id}/edit" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                </a>
                                <button type="button"  class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl" onclick="transactionDelete(${data.id});">
                                    <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                    </button>
                                </div>`;
                        }
                    }
                ]
            });

            // Deleting Transaction
            function transactionDelete(slug) {
                Swal.fire({
                    title: "Delete ?",
                    text: "Are you sure to delete this Transaction ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Delete",
                    background: 'rgba(255, 255, 255, 0.6)',
                    padding: '20px',
                    confirmButtonColor: '#0db8a6',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            method: 'DELETE',
                            url: BASE_URL + 'transactions/' + slug,
                            success: function(response) {
                                if (response.success) {
                                    // Swal.fire('Success!', response.message, 'success');

                                    $("#ajaxflash div p").text(response.success);
                                    $("#ajaxflash").fadeIn().fadeOut(5000);

                                    datatablelist.draw();
                                } else {
                                    Swal.fire('Not deletable!', 'This transaction is connected to a role.',
                                        'error');
                                    datatablelist.draw();
                                }
                            }
                        });
                    }
                });
            }


            // Add New Transaction
            $("form#transactionCreateForm").submit(function(e) {
                e.preventDefault();

                let transaction_date = $("#transactionCreateForm #transaction_date").val();
                let bank_account_id = $("#transactionCreateForm #bank_account_id").val();
                let txn_number = $("#transactionCreateForm #txn_number").val();

                if (txn_number != "") {

                    $.ajax({
                        url: BASE_URL + 'transactions',
                        dataType: 'json',
                        data: $("form#transactionCreateForm").serialize(),
                        type: 'POST',
                        success: function(response) {

                            $("#ajaxflash").addClass('bg-seagreen').removeClass('bg-red-500');
                            $("#ajaxflash div p").text(response.success);
                            $("#ajaxflash").fadeIn().fadeOut(5000);
                            $("form#transactionCreateForm")[0].reset();
                            datatablelist.draw();

                        },
                        error: function(xhr, status, error) {
                            $("#ajaxflash").addClass('bg-red-500').removeClass('bg-seagreen');
                            $("#ajaxflash div p").text(error);
                            $("#ajaxflash").fadeIn().fadeOut(8000);
                        }
                    });

                } else {
                    $("#ajaxflash div p").text('Fill the required fields.');
                    $("#ajaxflash").fadeIn().fadeOut(5000);
                }
            });
        </script>
    </x-slot>
</x-app-layout>
