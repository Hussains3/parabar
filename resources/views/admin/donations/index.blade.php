<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Donations</x-slot>


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

                    <h2 class="text-xl">All Donation</h2>
                    <a href="{{route('donations.create')}}">
                        <button type="submit" class="font-mont mt-2 px-4 py-2 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 " id="">Add</button>
                    </a>
                </div>

                <table id="donationTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Agent</th>
                            <th>Date</th>
                            <th>Perpose</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donations as $donation)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$donation->agent->name}}</td>
                            <td>{{ $donation->formatted_date }}</td>
                            <td>{{$donation->purpose}}</td>
                            <td>{{$donation->amount}}</td>
                            <td>{{$donation->status}}</td>
                            <td>
                                <div class="flex flex-col sm:flex-row gap-5 justify-end items-center">
                                    <a href="{{route('donations.edit',$donation->id)}}" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                        <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                    </a>

                                    <form action="{{ route('donations.destroy',$donation->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl">
                                            <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                        </button>
                                    </form>
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
            var datatablelist = $('#donationTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
            });
        </script>
    </x-slot>
</x-app-layout>
