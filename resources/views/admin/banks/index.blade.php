<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Banks</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex gap-6">
        <div class="card">
            <div class="p-6">
                <h2 class="mb-4 text-xl">New Bank</h2>

                <form class="" id="bankCreateForm">

                    <div class="flex items-end gap-5">

                        <div>
                            <label for="name" class="block mb-2">Bank Name</label>
                            <input type="text" class="form-input" id="name" name="name"
                                placeholder="Bank Name">
                        </div> <!-- end -->

                        <div class="lg:col-span-2 ">
                            <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white"
                                id="bankSaveBtn">Save</button>
                        </div>
                    </div>
                </form>
                <div class="flex justify-between mt-6">
                    <a href="{{route('baccounts.index')}}">
                        <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white" id="">New Account</button>
                    </a>
                    <a href="{{route('transactions.index')}}">
                        <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white" id="">New Transaction</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="card flex-grow">
            <div class="p-6">
                <h2 class="mb-4 text-xl">All Banks</h2>
                <table id="bankTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Action</th>
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
            var datatablelist = $('#bankTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('banks.index') !!}",
                columns: [{
                        "render": function(data, type, full, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `<div class="flex flex-col sm:flex-row gap-5 justify-end items-center">
                                <a href="${BASE_URL}banks/${data.id}" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-eye"></i></span>
                                </a>
                                <a href="${BASE_URL}banks/${data.id}/edit" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                </a>
                                <button type="button"  class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl" onclick="bankDelete(${data.id});">
                                    <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                    </button>
                                </div>`;
                        }
                    }
                ]
            });


            // Deleting Bank
            function bankDelete(catID) {
                Swal.fire({
                    title: "Delete ?",
                    text: "Are you sure to delete this Bank ?",
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
                            url: BASE_URL + 'banks/' + catID,
                            success: function(response) {
                                if (response.success) {
                                    // Swal.fire('Success!', response.message, 'success');

                                    $("#ajaxflash div p").text(response.success);
                                    $("#ajaxflash").fadeIn().fadeOut(5000);

                                    datatablelist.draw();
                                } else {
                                    Swal.fire('Not deletable!', 'This bank is connected somewhere.', 'error');
                                    datatablelist.draw();
                                }
                            }
                        });
                    }
                });
            }


            // Add New Bank
            $("form#bankCreateForm").submit(function(e) {
                e.preventDefault();

                let name = $("#bankCreateForm #name");

                if (name.val() != "") {
                    let nameValue = name.val();
                    $.ajax({
                        url: BASE_URL + 'banks',
                        dataType: 'json',
                        data: {
                            name: nameValue,
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
                                name.focus().val("");
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
                    name.focus();
                }
            });

        </script>
    </x-slot>
</x-app-layout>
