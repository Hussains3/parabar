<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Bank Acconts</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex gap-6">
        <div class="card">
            <div class="p-6">
                <h2 class="mb-4 text-xl">New Account</h2>

                <form class="" id="baccountCreateForm">

                    <div class="">
                        <div>
                            <label for="bank" class="block mb-2">Bank</label>
                            <select class="form-select" id="bank_id" name="bank_id" required>
                                <option selected="" disabled value="">Choose Bank...</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div> <!-- end -->

                        <div class="mt-4">
                            <label for="account_number" class="block mb-2">Account Number</label>
                            <input type="text" class="form-input" id="account_number" name="account_number" placeholder="Account Number" required>
                        </div> <!-- end -->


                        <div class="mt-4">
                            <label for="account_holder_name" class="block mb-2">Account Holder Name</label>
                            <input type="text" class="form-input" id="account_holder_name" name="account_holder_name" placeholder="Name">
                        </div> <!-- end -->



                        <div class="mt-4">
                            <label for="balance" class="block mb-2">Balance</label>
                            <input type="number" class="form-input" id="balance" name="balance" step="0.01" value="0.00">
                        </div> <!-- end -->

                        <div class=" mt-4">
                            <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white"
                                id="baccountSaveBtn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card flex-grow">
            <div class="p-6">
                <h2 class="mb-4 text-xl">All Accounts</h2>
                <table id="baccountsTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Bank Name</th>
                            <th>AC Number</th>
                            <th>AC Holder Name</th>
                            <th>Balance</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                </table>
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
            var datatablelist = $('#baccountsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('baccounts.index') !!}",
                columns: [{
                        "render": function(data, type, full, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'bank_name',
                        name: 'bank_name'
                    },
                    {
                        data: 'account_number',
                        name: 'account_number'
                    },
                    {
                        data: 'account_holder_name',
                        name: 'account_holder_name'
                    },
                    {
                        data: 'balance',
                        name: 'balance'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `<div class="flex flex-col sm:flex-row gap-5 justify-end items-center">
                                <a href="${BASE_URL}baccounts/${data.id}" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-eye"></i></span>
                                </a>
                                <a href="${BASE_URL}baccounts/${data.id}/edit" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                </a>
                                <button type="button"  class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl" onclick="baccountDelete(${data.id});">
                                    <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                    </button>
                                </div>`;
                        }
                    }
                ]
            });

            // Deleting Account
            function baccountDelete(slug) {
                Swal.fire({
                    title: "Delete ?",
                    text: "Are you sure to delete this Account ?",
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
                            url: BASE_URL + 'baccounts/' + slug,
                            success: function(response) {
                                if (response.success) {
                                    // Swal.fire('Success!', response.message, 'success');

                                    $("#ajaxflash div p").text(response.success);
                                    $("#ajaxflash").fadeIn().fadeOut(5000);

                                    datatablelist.draw();
                                } else {
                                    Swal.fire('Not deletable!', 'This account have some transactions.', 'error');
                                    datatablelist.draw();
                                }
                            }
                        });
                    }
                });
            }


            // Add New Account
            $("form#baccountCreateForm").submit(function(e) {
                e.preventDefault();

                let bank_id = $("#baccountCreateForm #bank_id").val();
                let account_number = $("#baccountCreateForm #account_number").val();
                let account_holder_name = $("#baccountCreateForm #account_holder_name").val();
                let balance = $("#baccountCreateForm #balance").val();

                if (bank_id != "" && account_number != "") {
                    $.ajax({
                        url: BASE_URL + 'baccounts',
                        dataType: 'json',
                        data: {
                            bank_id: bank_id,
                            account_number: account_number,
                            account_holder_name: account_holder_name,
                            balance: balance,
                        },
                        type: 'POST',
                        success: function(response) {
                            if (response.error) {
                                $("#ajaxflash div p").text(response.error);
                                $("#ajaxflash").fadeIn().fadeOut(5000);
                            } else {
                                $("#ajaxflash div p").text(response.success);
                                $("#ajaxflash").fadeIn().fadeOut(5000);
                                datatablelist.draw();
                                $("form#baccountCreateForm")[0].reset();
                            }

                        },
                        error: function(xhr, status, error) {
                            $("#ajaxflash").addClass('bg-red-500').removeClass('bg-seagreen');
                            $("#ajaxflash div p").text(error);
                            $("#ajaxflash").fadeIn().fadeOut(8000);
                        }
                    });

                } else {
                    $("#ajaxflash div p").text('Name fild is required.');
                    $("#ajaxflash").fadeIn().fadeOut(5000);
                }
            });
        </script>
    </x-slot>
</x-app-layout>
