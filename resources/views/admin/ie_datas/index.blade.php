<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Importer / Exporter</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="">

        {{-- Table --}}
        <div class="card rounded-tl-none">
            <div class="p-6">

                <h2 class="mb-4 text-xl">All Importer / Exporter</h2>
                <table id="ie_dataTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>BIN No</th>
                            <th>TIN No</th>
                            <th>IM/EX Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
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
                        data: 'tin_no',
                        name: 'tin_no'
                    },
                    {
                        data: 'org_name',
                        name: 'org_name'
                    },
                    {
                        data: 'phone_primary',
                        name: 'phone_primary',
                    },
                    {
                        data: 'email_primary',
                        name: 'email_primary',
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `<div class="flex flex-col sm:flex-row gap-5 justify-end items-center">

                                <a href="${BASE_URL}ie_datas/${data.id}/edit" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                </a>
                                <a href="${BASE_URL}file_datas/create?id=${data.id}" class="text-orange-500/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-cash-100"></i></span>
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
