<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit {{$ie_data->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">

                <form action="{{route('ie_datas.update', $ie_data->id)}}" class="" id="ieCreateForm" enctype="multipart/form-data" method="POST">

                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="bin_no" class="block mb-2">BIN No</label>
                            <input type="text" class="form-input" id="bin_no" name="bin_no" value="{{$ie_data->bin_no ?? ''}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="name" class="block mb-2">Importer / Exporter Name</label>
                            <input type="text" class="form-input" id="name" name="name" required value="{{$ie_data->name ?? ''}}">
                        </div> <!-- end -->


                        <div class="">
                            <label class="block mb-2 after:content-['*'] after:text-red-500">Importer / Exporter</label>
                            <div class="flex gap-6">
                                <div class="flex items-center gap-4">
                                    <input type="radio" id="contactChoice1" name="ie" value="Importer" checked>
                                    <label for="contactChoice1">Exporter</label>
                                </div>
                                <div class="flex items-center gap-4">
                                    <input type="radio" id="contactChoice2" name="ie" value="Exporter">
                                    <label for="contactChoice2">Exporter</label>
                                </div>
                            </div>
                        </div> <!-- end -->






                        <div class="">
                            <label for="owners_name" class="block mb-2">Owner / Manager Name</label>
                            <input type="text" class="form-input" id="owners_name" name="owners_name" value="{{$ie_data->owners_name ?? ''}}">
                        </div> <!-- end -->


                        <div>
                            <label class="block text-gray-600 mb-2" for="photo">Photo</label>
                            <input type="file" id="photo" class="form-input border" name="photo">
                        </div> <!-- end -->


                        <div class="">
                            <label for="destination" class="block mb-2">Designation</label>
                            <input type="text" class="form-input" id="destination" name="destination" value="{{$ie_data->destination ?? ''}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="office_address" class="block mb-2">Agent / Office Address</label>
                            <input type="text" class="form-input" id="office_address" name="office_address" value="{{$ie_data->office_address ?? ''}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="phone" class="block mb-2">Phone Number</label>
                            <input type="text" class="form-input" id="phone" name="phone" value="{{$ie_data->phone ?? ''}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="email" class="block mb-2">Email</label>
                            <input type="email" class="form-input" id="email" name="email" value="{{$ie_data->email ?? ''}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="house" class="block mb-2">House</label>
                            <input type="text" class="form-input" id="house" name="house" value="{{$ie_data->house ?? ''}}">
                        </div> <!-- end -->

                        <div class="col-span-2">
                            <label for="note" class="block mb-2">Note</label>
                            <textarea  class="form-input" name="note" id="note" cols="30" rows="5" placeholder="Note"></textarea>
                        </div> <!-- end -->

                        <div class=" ">
                            <button type="submit"
                                class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white"
                                id="baccountSaveBtn">Update</button>
                        </div>
                    </div>
                </form>

            </div>
        </div> <!-- end card -->



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



