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


        {{-- Table --}}
        <div class="card w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">

                    <h2 class="text-xl">All Agent</h2>
                    @role('admin')
                    <a href="{{route('agents.create')}}">
                        <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white" id="">Add</button>
                    </a>
                    @endrole
                </div>

                <table id="agentsTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>AIN No</th>
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
                ajax: "{!! route('agents.index') !!}",
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
                                <a href="${BASE_URL}agents/${data.id}" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-eye"></i></span>
                                </a>
                                <a href="${BASE_URL}agents/${data.id}/edit" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                </a>
                                <button type="button"  class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl" onclick="agentDelete(${data.id});">
                                    <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                    </button>
                                </div>`;
                        }
                    }
                ]
            });

            // Deleting Agent
            function agentDelete(id) {
                Swal.fire({
                    title: "Delete ?",
                    text: "Are you sure to delete this Agent ?",
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
                            url: BASE_URL + 'agents/' + id,
                            success: function(response) {
                                if (response.success) {
                                    // Swal.fire('Success!', response.message, 'success');

                                    $("#ajaxflash div p").text(response.success);
                                    $("#ajaxflash").fadeIn().fadeOut(5000);

                                    datatablelist.draw();
                                } else {
                                    Swal.fire('Not deletable!', 'This agent is connected to a role.',
                                        'error');
                                    datatablelist.draw();
                                }
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
