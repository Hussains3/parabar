<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{$ie_data->org_name}}</x-slot>


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

                {{-- Organization Information Card --}}
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Organization Details --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-700 mb-3">Organization Details</h3>
                            <div class="space-y-2">
                                <p class="mb-3">
                                    <span class="font-medium text-red-600">Total Unpaid Amount:</span>
                                    <span class="text-red-600 font-bold">
                                        {{ $ie_data->file_datas->whereIn('status', ['Unpaid', 'Partial'])->sum('balance') }} Tk
                                    </span>
                                </p>
                                @if($ie_data->org_logo)
                                <div class="mb-4">
                                    <img src="{{ asset($ie_data->org_logo) }}" alt="Organization Logo" class="h-20 w-auto object-contain">
                                </div>
                                @endif
                                <p><span class="font-medium">Organization Name:</span> {{$ie_data->org_name}}</p>
                                <p><span class="font-medium">BIN Number:</span> {{$ie_data->bin_no ?: 'N/A'}}</p>
                                <p><span class="font-medium">TIN Number:</span> {{$ie_data->tin_no ?: 'N/A'}}</p>
                                <p><span class="font-medium">Commission Rate:</span> {{$ie_data->commission_percentage ?: 'N/A'}}</p>
                            </div>
                        </div>

                        {{-- Contact Information --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-700 mb-3">Contact Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Contact Name:</span> {{$ie_data->name}}</p>
                                <p><span class="font-medium">Primary Phone:</span> {{$ie_data->phone_primary ?: 'N/A'}}</p>
                                @if($ie_data->phone_secondary)
                                <p><span class="font-medium">Secondary Phone:</span> {{$ie_data->phone_secondary}}</p>
                                @endif
                                @if($ie_data->whatsapp)
                                <p><span class="font-medium">WhatsApp:</span> {{$ie_data->whatsapp}}</p>
                                @endif
                                <p><span class="font-medium">Primary Email:</span> {{$ie_data->email_primary ?: 'N/A'}}</p>
                                @if($ie_data->email_secondary)
                                <p><span class="font-medium">Secondary Email:</span> {{$ie_data->email_secondary}}</p>
                                @endif
                                @if($ie_data->fax_telephone)
                                <p><span class="font-medium">Fax/Telephone:</span> {{$ie_data->fax_telephone}}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Address Information --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-700 mb-3">Address Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Address:</span> {{$ie_data->address ?: 'N/A'}}</p>
                                <p><span class="font-medium">House/District:</span> {{$ie_data->house_distric ?: 'N/A'}}</p>
                                <p><span class="font-medium">Post:</span> {{$ie_data->post ?: 'N/A'}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="text-lg font-medium text-gray-700 mb-4">File Records</h3>
                {{-- Table start here --}}
                <table id="filedataTable" class="table is-narrow">
                    <thead>
                        <tr>
                            <th>Serial No</th>
                            <th>Bill No</th>
                            <th>Date</th>
                            <th>C Number</th>
                            <th>Package</th>
                            <th>Manifest No</th>
                            <th>Due Amount</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($ie_data->file_datas as $file_data)
                        <tr>
                            <th>{{ $loop->index+1 }}</th>
                            <td>{{$file_data->bill_no}}</td>
                            <td>{{$file_data->file_date}}</td>
                            <td>{{$file_data->be_number}}</td>
                            <td>{{$file_data->package}}</td>
                            <td>{{$file_data->manifest_number}}</td>
                            <td>{{$file_data->balance}}</td>
                            <td>
                                @if ($file_data->status == 'Unpaid')
                                    <span class="text-red-600">Unpaid</span>
                                @elseif ($file_data->status == 'Partial')
                                    <span class="text-orange-600">Partial</span>
                                @else
                                <span class="text-green-600">Paid</span>
                                @endif
                            </td>

                            <td class="flex justify-end items-center gap-2">
                                    <a class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-2xl" href="{{route('file_datas.edit', $file_data->id)}}">
                                        <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                    </a>
                                    <a class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-2xl" href="{{ route('file_datas.destroy', $file_data->id) }}"
                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $file_data->id }}').submit();">
                                    <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                    </a>

                                    <form id="delete-form-{{ $file_data->id }}" action="{{ route('file_datas.destroy', $file_data->id) }}" method="POST" style="display: none;">
                                        @method('DELETE')
                                        @csrf
                                    </form>

                                    <a class="text-orange-400 hover:text-red-600  hover:scale-105 transition duration-150 ease-in-out text-2xl" href="{{route('file_datas.editprint', $file_data->id)}}"><span class="menu-icon"><i class="mdi mdi-printer"></i></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

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
            var datatablelist = $('#filedataTable').DataTable();



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
