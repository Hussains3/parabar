<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Certificate</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-4">
        <div class="card w-full">
            <div class="p-6">
                {{-- Certificate printing form --}}
                <form action="{{ route('agents.certificate.print') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input id="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" name="name" required autofocus />
                        </div>

                        <div>
                            <label for="license_number" class="block text-sm font-medium text-gray-700">License Number</label>
                            <input id="license_number" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" name="license_number" required />
                        </div>

                        <div>
                            <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date</label>
                            <input id="issue_date" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" name="issue_date" required />
                        </div>

                        <div>
                            <label for="expire_date" class="block text-sm font-medium text-gray-700">Expire Date</label>
                            <input id="expire_date" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" name="expire_date" required />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ __('Print Certificate') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- flex-end -->
</x-app-layout>
