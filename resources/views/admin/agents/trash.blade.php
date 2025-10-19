<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Agents</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex gap-6">

        <div class="">
            {{-- Table --}}
            <div class="card">
                <div class="p-6">

                    <h2 class="mb-4 text-xl">All Agent</h2>
                    <table id="agentsTable" class=" stripe text-xs sm:text-base w-full">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Ain No</th>
                                <th>Agent Name</th>
                                <th>Owner Name</th>
                                <th>Phone</th>
                                <th>House / Station</th>
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
            var datatablelist = $('#agentsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('agents.trash') !!}",
                columns: [{
                        "render": function(data, type, full, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'ain_no',
                        name: 'ain_no'
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
                        data: 'house',
                        name: 'house'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `<div class="flex flex-col sm:flex-row gap-5 justify-end items-center">
                                <button type="button"  class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" onclick="transactionRestore(${data.id});">
                                    <span class="menu-icon"><i class="mdi mdi-backup-restore"></i></span>
                                    </button>
                                <button type="button"  class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl" onclick="transactionForceDelete(${data.id});">
                                    <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                    </button>
                                </div>`;
                        }
                    }
                ]
            });



            // Restore Transaction
            function transactionRestore(id) {
                Swal.fire({
                    title: "Restore ?",
                    text: "Are you sure to Restore this Transaction?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Restore",
                    background: 'rgba(255, 255, 255, 0.6)',
                    padding: '20px',
                    confirmButtonColor: '#0db8a6',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            method: 'PATCH',
                            url: BASE_URL + 'agentrestore/' + id ,
                            success: function(response) {
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



            // Deleting Transaction parmanantly
            function transactionForceDelete(id) {
                Swal.fire({
                    title: "Delete ?",
                    text: "Are you sure to delete this Transaction Parmanantly?",
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
                            url: BASE_URL + 'agentforcedelete/' + id ,
                            success: function(response) {
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
        </script>
    </x-slot>
</x-app-layout>
