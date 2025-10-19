<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Create New ITC Report</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6 ">
                <div>
                    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">ALL ITC Reports</h2>

                    <form action="{{ route('itc-reports.update', $itcReport->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name" class="block mb-2">Name:</label>
                            <input type="text" class="form-input" name="name" id="name" value="{{ $itcReport->name }}" required>
                        </div>
                        <div>
                            <label for="type" class="block mb-2">Type:</label>
                            <select class="form-select" name="type" id="type" required>
                                <option value="monthly" {{ $itcReport->type ?'monthly': selected }}>Monthly</option>
                                <option value="yearly" {{ $itcReport->type ? 'yearly' : selected}}>Yearly</option>
                            </select>
                        </div>
                        <div>
                            <label for="file" class="block mb-2">Upload New PDF (optional):</label>
                            <input type="file" class="form-input" name="file" id="file">
                        </div>
                        <div class="lg:col-span-2 mt-3">
                            <button type="submit"
                                class="font-mont mt-8 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SAVE'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Update</button>
                        </div> <!-- end button -->
                    </form>
                </div>


            </div>
        </div> <!-- end card -->



    </div>

</x-app-layout>
