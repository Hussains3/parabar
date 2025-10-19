<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Dashboard</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-4">


        <div class="grid grid-cols-4 gap-4">
            <!-- card-start -->
            <div class="card ">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">
                            <h4 class="card-title">Total File</h4>
                            <p class="text-gray-400 font-normal">Today</p>
                        </div>
                        <h2 class="text-3xl font-normal">{{$todayFileDataCount}}</h2>
                    </div>
                </div>
            </div> <!-- card-end -->
            <!-- card-start -->
            <div class="card ">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">
                            <h4 class="card-title">Total Delivered</h4>
                            <p class="text-gray-400 font-normal">All Time</p>
                        </div>
                        <h2 class="text-3xl font-normal">{{$deliveredFileDataCount}}</h2>
                    </div>
                </div>
            </div> <!-- card-end -->
            <!-- card-start -->
            <div class="card ">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">
                            <h4 class="card-title">Total Printed</h4>
                            <p class="text-gray-400 font-normal">All time</p>
                        </div>
                        <h2 class="text-3xl font-normal">{{$printedFileDataCount}}</h2>
                    </div>
                </div>
            </div> <!-- card-end -->
            <!-- card-start -->
            <div class="card ">
                <div class="px-4 py-2">
                    <div class="flex items-center justify-between">
                        <div class="text-start">
                            <h4 class="card-title">Total Files</h4>
                            <p class="text-gray-400 font-normal">This Year</p>
                        </div>
                        <h2 class="text-3xl font-normal">{{$currentYearFileDataCount}}</h2>
                    </div>
                </div>
            </div> <!-- card-end -->

        </div> <!-- grid-end -->


        {{-- Table --}}
        <div class="card w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">

                    <h2 class="text-lg">Last 1000 Files</h2>
                    <div class="p-2 shadow-md rounded-lg  cardone">
                        <form action="{{route('dashboard')}}" method="get">
                            @csrf
                            @method('GET')
                            <div class="flex justify-center items-center gap-2">

                                <select name="stype" id="" class="form-input">
                                    <option value="be_number"  @role('extra') selected @endrole>B/E Number</option>
                                    <option value="manifest_no">Manifast Number</option>
                                    <option value="lodgement_no" @role('operator') selected @endrole>Lodgement Number</option>
                                    <option value="ain_no">AIN Number</option>
                                </select>
                                <input type="text" name="search" id="search" class="form-input w-28" placeholder="Search">
                                <button type="submit" class="font-space cursor-pointer px-4 py-2 bg-green-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110" id="">Search</button>
                                <a href="{{route('dashboard')}}" class="font-space cursor-pointer px-4 py-2 bg-indigo-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="">
                        @role('extra')
                        <a href="{{route('file_datas.create')}}">
                            <button type="submit" class="font-space px-2 py-2 bg-red-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110" id="">Receive Out</button>
                        </a>
                        <a href="{{route('file_datas.createin')}}">
                            <button type="submit" class="font-space px-2 py-2 bg-green-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110" id="">Receive In</button>
                        </a>
                        @endrole
                        <a href="{{route('ie_datas.index')}}">
                            <button type="submit" class="font-space px-2 py-2 bg-cyan-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110" id="">+ Imp/Exp</button>
                        </a>
                        @role('admin')
                        <a href="{{route('agents.index')}}">
                            <button type="submit" class="font-space px-2 py-2 bg-indigo-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110" id="">+ Agents</button>
                        </a>
                        @endrole
                    </div>
                </div>
                {{-- Table start here --}}
                <table id="suppliers" class="table is-narrow">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>M/F No</th>
                            <th>M/F Date</th>
                            <th>Lodg.No</th>
                            <th>Lodg.Date</th>
                            <th>B/E No</th>
                            <th>B/E Date</th>
                            <th>Agent Name</th>
                            <th>Imp/Exp</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($file_datas as $file_data)
                        <tr>
                            <th>{{ $loop->index+1 }}</th>
                            <td>{{$file_data->manifest_no}}</td>
                            <td>{{$file_data->manifest_date}}</td>
                            <td>{{$file_data->lodgement_no}}</td>
                            <td>{{$file_data->lodgement_date}}</td>
                            <td>{{$file_data->be_number}}</td>
                            <td>{{$file_data->be_date}}</td>
                            <td>
                                @if ($file_data->agent)
                                <a href="{{route('agents.show', $file_data->agent->id) }}" class="hover:text-green-600 cursor-pointer">
                                    {{$file_data->agent->name}}
                                </a>
                                @endif
                            </td>
                            <td>
                                @if ($file_data->ie_data)
                                {{-- <a href="{{route('ie_datas.show', $file_data->ie_data->id) }}" class="hover:text-green-600 cursor-pointer"></a> --}}
                                {{$file_data->ie_data->name ?? ''}}
                                @endif
                            </td>

                            <td>
                                @if ($file_data->status == 'Delivered')
                                    <span class="text-orange-400">Delivered</span>
                                @elseif ($file_data->status == 'Printed')
                                    <span class="text-red-500">Printed</span>
                                @else
                                    <span class="text-green-600">Received</span>

                                @endif
                            </td>

                            <td class="flex justify-end items-center gap-2">
                                @role('admin')
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
                                @endrole

                                @role('operator')
                                    <a class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-2xl" href="{{route('file_datas.edit', $file_data->id)}}"><span class="menu-icon"><i class="mdi mdi-key"></i></span></a>
                                @endrole

                                @role('extra')

                                    <a class="text-red-400 hover:text-red-600  hover:scale-105 transition duration-150 ease-in-out text-2xl" href="{{route('file_datas.show', $file_data->id)}}"><span class="menu-icon"><i class="mdi mdi-printer"></i></span></a>
                                @endrole
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div> <!-- flex-end -->

    <x-slot name="script">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $('#suppliers').DataTable({
                "pageLength": 100
            });

        </script>
    </x-slot>
</x-app-layout>
