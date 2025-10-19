<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Importer / Exporter</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col lg:flex-row gap-6">

        {{-- Form --}}
        <div class="card max-w-2xl">
            <div class="p-6">
                <h2 class="mb-4 text-xl">New Importer / Exporter</h2>

                <form class="" id="ieCreateForm" enctype="multipart/form-data">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="bin_no" class="block mb-2">BIN No</label>
                            <input type="text" class="form-input" id="bin_no" name="bin_no">
                        </div> <!-- end -->

                        <div class="col-span-2">
                            <label for="name" class="block mb-2">Importer / Exporter Name</label>
                            <input type="text" class="form-input" id="name" name="name" required autofocus>
                        </div> <!-- end -->


                        <div class="">
                            <label class="block mb-2 after:content-['*'] after:text-red-500">Importer / Exporter</label>
                            <div class="flex gap-6">
                                <div class="flex items-center gap-4">
                                    <input type="radio" id="contactChoice1" name="ie" value="Importer" checked>
                                    <label for="contactChoice1">Importer</label>
                                </div>
                                <div class="flex items-center gap-4">
                                    <input type="radio" id="contactChoice2" name="ie" value="Exporter">
                                    <label for="contactChoice2">Exporter</label>
                                </div>
                            </div>
                        </div> <!-- end -->






                        <div class="">
                            <label for="owners_name" class="block mb-2">Owner / Manager Name</label>
                            <input type="text" class="form-input" id="owners_name" name="owners_name">
                        </div> <!-- end -->


                        <div>
                            <label class="block text-gray-600 mb-2" for="photo">Photo</label>
                            <input type="file" id="photo" class="form-input border" name="photo">
                        </div> <!-- end -->


                        <div class="">
                            <label for="destination" class="block mb-2">Designation</label>
                            <input type="text" class="form-input" id="destination" name="destination">
                        </div> <!-- end -->

                        <div class="">
                            <label for="office_address" class="block mb-2">Agent / Office Address</label>
                            <input type="text" class="form-input" id="office_address" name="office_address">
                        </div> <!-- end -->

                        <div class="">
                            <label for="phone" class="block mb-2">Phone Number</label>
                            <input type="text" class="form-input" id="phone" name="phone">
                        </div> <!-- end -->

                        <div class="">
                            <label for="email" class="block mb-2">Email</label>
                            <input type="email" class="form-input" id="email" name="email">
                        </div> <!-- end -->

                        <div class="">
                            <label for="house" class="block mb-2">House</label>
                            <input type="text" class="form-input" id="house" name="house" value="Benapole">
                        </div> <!-- end -->

                        <div class="col-span-2">
                            <label for="note" class="block mb-2">Note</label>
                            <textarea  class="form-input" name="note" id="note" cols="30" rows="5" placeholder="Note"></textarea>
                        </div> <!-- end -->

                        <div class=" ">
                            <button type="submit"
                                class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white"
                                id="baccountSaveBtn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        {{-- Table --}}
        <div class="card rounded-tl-none">
            <div class="p-6">

                <h2 class="mb-4 text-xl">All Importer / Exporter</h2>
                <table id="ie_dataTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>BIN No</th>
                            <th>IM/EX Name</th>
                            <th>Owner Name</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>House / Station</th>
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
            var datatablelist = $('#ie_dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('ie_datas.index') !!}",
                columns: [{
                        "render": function(data, type, full, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'bin_no',
                        name: 'bin_no'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'owners_name',
                        name: 'owners_name',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                    },
                    {
                        data: 'ie',
                        name: 'ie',
                    },
                    {
                        data: 'house',
                        name: 'house'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `<div class="flex flex-col sm:flex-row gap-5 justify-end items-center">

                                <a href="${BASE_URL}ie_datas/${data.id}/edit" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                </a>
                                <button type="button"  class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl" onclick="ie_dataDelete(${data.id});">
                                    <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                    </button>
                                </div>`;
                        }
                    }
                ]
            });



            // Deleting Importer / Exporter
            function ie_dataDelete(id) {
                Swal.fire({
                    title: "Delete ?",
                    text: "Are you sure to delete this?",
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
                            url: BASE_URL + 'ie_datas/' + id,
                            success: function(response) {
                                $("#ajaxflash").addClass('bg-seagreen').removeClass('bg-red-500');
                                $("#ajaxflash div p").text(response.success);
                                $("#ajaxflash").fadeIn().fadeOut(5000);
                                datatablelist.draw();
                            },
                            error: function(xhr, status, error) {
                                $("#ajaxflash").addClass('bg-red-500').removeClass('bg-seagreen');
                                $("#ajaxflash div p").text(error);
                                $("#ajaxflash").fadeIn().fadeOut(8000);
                            }
                        });
                    }
                });
            }


            // Add New Importer / Exporter
            $("form#ieCreateForm").submit(function(e) {
                e.preventDefault();

                let transaction_date = $("#ieCreateForm #transaction_date").val();
                let bank_account_id = $("#ieCreateForm #bank_account_id").val();
                let txn_number = $("#ieCreateForm #txn_number").val();

                if (txn_number != "") {

                    $.ajax({
                        url: BASE_URL + 'ie_datas',
                        dataType: 'json',
                        data: $("form#ieCreateForm").serialize(),
                        type: 'POST',
                        beforeSend: function(data) {
                            console.log(data);
                        },
                        success: function(response) {

                            $("#ajaxflash").addClass('bg-seagreen').removeClass('bg-red-500');
                            $("#ajaxflash div p").text(response.success);
                            $("#ajaxflash").fadeIn().fadeOut(5000);
                            $("form#ieCreateForm")[0].reset();
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
