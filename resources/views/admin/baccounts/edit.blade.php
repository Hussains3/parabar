<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit Bank Account</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex justify-center items-center">
        <div class="card max-w-2xl">
            <div class="p-6">
                <h2 class="mb-4 text-xl">Edit Account</h2>

                <form class="" id="baccountCreateForm" action="{{route('baccounts.update',$bankAccount->id)}}" method="post">
                    @csrf
                    @method('PATCH')

                    <div class="">
                        <div>
                            <label for="bank" class="block mb-2">Bank</label>
                            <select class="form-select" id="bank_id" name="bank_id" required>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}" @if ($bank->id == $bankAccount->bank_id) selected @endif>{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div> <!-- end -->

                        <div class="mt-4">
                            <label for="account_number" class="block mb-2">Account Number</label>
                            <input type="text" class="form-input" id="account_number" name="account_number" value="{{$bankAccount->account_number}}" required>
                        </div> <!-- end -->


                        <div class="mt-4">
                            <label for="account_holder_name" class="block mb-2">Account Holder Name</label>
                            <input type="text" class="form-input" id="account_holder_name" name="account_holder_name" value="{{$bankAccount->account_holder_name ?? ''}}" placeholder="Name">
                        </div> <!-- end -->



                        <div class="mt-4">
                            <label for="balance" class="block mb-2">Balance</label>
                            <input type="number" class="form-input" id="balance" name="balance" step="0.01" value="{{$bankAccount->balance?? 0.00}}">
                        </div> <!-- end -->

                        <div class=" mt-4">
                            <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white"
                                id="baccountSaveBtn">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <x-slot name="script">
        <script>
            $(document).ready(function () {
                $("form #name").on('blur', () => {
                    const slug = slugify($("form #name").val());
                    $("form #slug").val(slug);
                });
            });
        </script>
    </x-slot>
</x-app-layout>



