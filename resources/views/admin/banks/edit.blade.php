<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit {{$bank->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex justify-center items-center">
        <div class="card max-w-2xl">
            <div class="p-6">
                <h2 class="mb-4 text-xl">Edit Bank</h2>

                <form class="" id="bankCreateForm" action="{{ route('banks.update', $bank->id) }}" method="post">
                    @csrf
                        @method('PATCH')

                    <div class="flex items-end gap-5">

                        <div>
                            <label for="name" class="block mb-2">Bank Name</label>
                            <input type="text" class="form-input" id="name" name="name" required value="{{$bank->name}}">
                        </div> <!-- end -->

                        <div class="lg:col-span-2 ">
                            <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white"
                                id="bankSaveBtn">Update</button>
                        </div>
                    </div>
                </form>
                <div class="flex justify-between mt-6">
                    <a href="{{route('baccounts.index')}}">
                        <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white" id="">New Account</button>
                    </a>
                    <a href="{{route('transactions.index')}}">
                        <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white" id="">New Transaction</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
    </x-slot>
</x-app-layout>
