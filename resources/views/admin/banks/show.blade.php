<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{ $bank->name }}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="gap-6">
        <div class="card flex-grow">
            <div class="p-6">
                <h2 class="mb-4 text-xl">All Acconts In {{ $bank->name }}</h2>
                <table id="baccountsTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>AC Number</th>
                            <th>AC Holder Name</th>
                            <th>Balance</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bank->accounts as $account)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$account->account_number}}</td>
                            <td>{{$account->account_holder_name ?? 'Unknown'}}</td>
                            <td>{{$account->balance}}</td>
                            <td>
                                <div class="flex flex-col sm:flex-row gap-5 justify-end items-center">
                                    <a href="{{route('baccounts.show',$account->id)}}"
                                        class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl">
                                        <span class="menu-icon"><i class="mdi mdi-eye"></i></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty

                        <tr>
                            <td ></td>
                            <td ></td>
                            <td class="text-red-500">No Account In This Bank</td>
                            <td ></td>
                            <td ></td>
                        </tr>
                        @endforelse
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
            const bankID = $('#bankID').val();
            var datatablelist = $('#baccountsTable').DataTable();

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
                                    Swal.fire('Not deletable!', 'This account have some transactions.',
                                        'error');
                                    datatablelist.draw();
                                }
                            }
                        });
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>
