<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{$bankAccount->bank->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>



    {{-- Page Content --}}
    <div class="flex gap-6">
        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center gap-10 ">
                    <div class="">
                        <p class="py-0.5 font-medium text-xl">{{$bankAccount->account_holder_name ?? 'Unknown'}}</p>
                        <p class="py-0.5 font-medium mb-10">{{$bankAccount->account_number}}</p>
                        <a href="{{route('baccounts.edit', $bankAccount->id)}}" class="">
                            <button type="button" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white">Edit</button>
                        </a>
                    </div>

                    <div class="flex gap-4">
                        <p class="py-0.5 font-medium text-2xl"> &#2547; {{$bankAccount->balance}}</p>
                    </div>
                </div>
            </div>
        </div> <!-- end card -->


        <div class="card flex-grow">
            <div class="p-6">
                <h2 class="mb-4 text-xl">Transactions in this account</h2>
                <table id="transactionsTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Transaction Date</th>
                            <th>Transaction Number </th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bankAccount->transactions as $key => $transaction)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $transaction->transaction_date }}</td>
                                <td>{{ $transaction->txn_number }}</td>
                                <td>
                                    @if (  $transaction->type == 'deposit')
                                    <span class="bg-green-500/40 text-xs px-2 py1 rounded-full capitalize">{{$transaction->type}}</span>
                                    @else
                                    <span class="bg-red-500/40 text-xs px-2 py1 rounded-full capitalize">{{$transaction->type}}</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->amount }}</td>
                                <td class="text-right">
                                    <div class="flex flex-col sm:flex-row gap-5 justify-end items-center">
                                        <a href="{{route('transactions.show',$transaction->id)}}"
                                            class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl">
                                            <span class="menu-icon"><i class="mdi mdi-eye"></i></span>
                                        </a>
                                    </div>
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
            $(document).ready(function () {

                var datatablelist = $('#transactionsTable').DataTable();
                $("form #name").on('blur', () => {
                    const slug = slugify($("form #name").val());
                    $("form #slug").val(slug);
                });
            });
        </script>
    </x-slot>
</x-app-layout>



