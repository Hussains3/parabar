<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit {{$ie_data->org_name ?? ""}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex justify-center items-center lg:flex-row gap-6">

        {{-- Form --}}
        <div class="card max-w-2xl">
            <div class="p-6">
                <h2 class="mb-4 text-xl text-center">New Importer / Exporter</h2>

                <form class="" id="ieCreateForm" enctype="multipart/form-data" action="{{route('ie_datas.update', $ie_data->id)}}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 flex gap-4">
                            <div class="basis-4/5">

                                <label for="org_name" class="block mb-2">Organization Name</label>
                                <input type="text" class="form-input" id="org_name" name="org_name" required autofocus value="{{$ie_data->org_name ?? ''}}">
                            </div>
                            <div class="col-span-2">
                                <label for="commission_percentage" class="block mb-2">%</label>
                                <input type="number" class="form-input" id="commission_percentage" name="commission_percentage" required value="{{$ie_data->commission_percentage ?? '0.15'}}" step="0.01">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2" for="org_logo">Logo</label>
                            <input type="file" id="org_logo" class="form-input border" name="org_logo">
                        </div> <!-- end -->
                        <div>
                            <label for="bin_no" class="block mb-2">BIN No</label>
                            <input type="text" class="form-input" id="bin_no" name="bin_no" value="{{$ie_data->bin_no ?? ''}}">
                        </div> <!-- end -->
                        <div>
                            <label for="tin_no" class="block mb-2">TIN No</label>
                            <input type="text" class="form-input" id="tin_no" name="tin_no" value="{{$ie_data->tin_no ?? ''}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="name" class="block mb-2">Importer / Exporter Name</label>
                            <input type="text" class="form-input" id="name" name="name" required value="{{$ie_data->name ?? ''}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="fax_telephone" class="block mb-2">Fax/Telephone</label>
                            <input type="text" class="form-input" id="fax_telephone" name="fax_telephone" value="{{$ie_data->fax_telephone ?? ''}}">
                        </div> <!-- end -->
                        <div class="">
                            <label for="phone_primary" class="block mb-2">Phone Number (Main)</label>
                            <input type="text" class="form-input" id="phone_primary" name="phone_primary" value="{{$ie_data->phone_primary ?? ''}}">
                        </div> <!-- end -->
                        <div class="">
                            <label for="phone_secondary" class="block mb-2">Secondary Phone Number</label>
                            <input type="text" class="form-input" id="phone_secondary" name="phone_secondary" value="{{$ie_data->phone_secondary ?? ''}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="email_primary" class="block mb-2">Email (Main)</label>
                            <input type="email" class="form-input" id="email_primary" name="email_primary" value="{{$ie_data->email_primary ?? ''}}">
                        </div> <!-- end -->
                        <div class="">
                            <label for="email_secondary" class="block mb-2">Secondary Email</label>
                            <input type="email" class="form-input" id="email_secondary" name="email_secondary" value="{{$ie_data->email_secondary ?? ''}}">
                        </div> <!-- end -->
                        <div class="">
                            <label for="whatsapp" class="block mb-2">Whatsapp Number</label>
                            <input type="text" class="form-input" id="whatsapp" name="whatsapp" value="{{$ie_data->whatsapp ?? ''}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="house_distric" class="block mb-2">Distric</label>
                            <select class="form-input" name="house_distric" id="house_distric">
                                <option value="Bagerhat" @if ($ie_data->house_distric == 'Bagerhat') selected @endif>Bagerhat</option>
                                <option value="Bandarban" @if ($ie_data->house_distric == 'Bandarban') selected @endif>Bandarban</option>
                                <option value="Barguna" @if ($ie_data->house_distric == 'Barguna') selected @endif>Barguna</option>
                                <option value="Barisal" @if ($ie_data->house_distric == 'Barisal') selected @endif>Barisal</option>
                                <option value="Bhola" @if ($ie_data->house_distric == 'Bhola') selected @endif>Bhola</option>
                                <option value="Bogra" @if ($ie_data->house_distric == 'Bogra') selected @endif>Bogra</option>
                                <option value="Brahmanbaria" @if ($ie_data->house_distric == 'Brahmanbaria') selected @endif>Brahmanbaria</option>
                                <option value="Chandpur" @if ($ie_data->house_distric == 'Chandpur') selected @endif>Chandpur</option>
                                <option value="Chittagong" @if ($ie_data->house_distric == 'Chittagong') selected @endif>Chittagong</option>
                                <option value="Chuadanga" @if ($ie_data->house_distric == 'Chuadanga') selected @endif>Chuadanga</option>
                                <option value="Comilla" @if ($ie_data->house_distric == 'Comilla') selected @endif>Comilla</option>
                                <option value="Cox'sBazar" @if ($ie_data->house_distric == "Cox'sBazar") selected @endif>Cox'sBazar</option>
                                <option value="Dhaka" @if ($ie_data->house_distric == 'Dhaka') selected @endif>Dhaka</option>
                                <option value="Dinajpur" @if ($ie_data->house_distric == 'Dinajpur') selected @endif>Dinajpur</option>
                                <option value="Faridpur" @if ($ie_data->house_distric == 'Faridpur') selected @endif>Faridpur</option>
                                <option value="Feni" @if ($ie_data->house_distric == 'Feni') selected @endif>Feni</option>
                                <option value="Gaibandha" @if ($ie_data->house_distric == 'Gaibandha') selected @endif>Gaibandha</option>
                                <option value="Gazipur" @if ($ie_data->house_distric == 'Gazipur') selected @endif>Gazipur</option>
                                <option value="Gopalganj" @if ($ie_data->house_distric == 'Gopalganj') selected @endif>Gopalganj</option>
                                <option value="Habiganj" @if ($ie_data->house_distric == 'Habiganj') selected @endif>Habiganj</option>
                                <option value="Jaipurhat" @if ($ie_data->house_distric == 'Jaipurhat') selected @endif>Jaipurhat</option>
                                <option value="Jamalpur" @if ($ie_data->house_distric == 'Jamalpur') selected @endif>Jamalpur</option>
                                <option value="Jessore" @if ($ie_data->house_distric == 'Jessore') selected @endif>Jessore</option>
                                <option value="Jhalokati" @if ($ie_data->house_distric == 'Jhalokati') selected @endif>Jhalokati</option>
                                <option value="Jhenaidah" @if ($ie_data->house_distric == 'Jhenaidah') selected @endif>Jhenaidah</option>
                                <option value="Khagrachari" @if ($ie_data->house_distric == 'Khagrachari') selected @endif>Khagrachari</option>
                                <option value="Khulna" @if ($ie_data->house_distric == 'Khulna') selected @endif>Khulna</option>
                                <option value="Kishoreganj" @if ($ie_data->house_distric == 'Kishoreganj') selected @endif>Kishoreganj</option>
                                <option value="Kurigram" @if ($ie_data->house_distric == 'Kurigram') selected @endif>Kurigram</option>
                                <option value="Kushtia" @if ($ie_data->house_distric == 'Kushtia') selected @endif>Kushtia</option>
                                <option value="Lakshmipur" @if ($ie_data->house_distric == 'Lakshmipur') selected @endif>Lakshmipur</option>
                                <option value="Lalmonirhat" @if ($ie_data->house_distric == 'Lalmonirhat') selected @endif>Lalmonirhat</option>
                                <option value="Madaripur" @if ($ie_data->house_distric == 'Madaripur') selected @endif>Madaripur</option>
                                <option value="Magura" @if ($ie_data->house_distric == 'Magura') selected @endif>Magura</option>
                                <option value="Manikganj" @if ($ie_data->house_distric == 'Manikganj') selected @endif>Manikganj</option>
                                <option value="Maulvibazar" @if ($ie_data->house_distric == 'Maulvibazar') selected @endif>Maulvibazar</option>
                                <option value="Meherpur" @if ($ie_data->house_distric == 'Meherpur') selected @endif>Meherpur</option>
                                <option value="Munshiganj" @if ($ie_data->house_distric == 'Munshiganj') selected @endif>Munshiganj</option>
                                <option value="Mymensingh" @if ($ie_data->house_distric == 'Mymensingh') selected @endif>Mymensingh</option>
                                <option value="Naogaon" @if ($ie_data->house_distric == 'Naogaon') selected @endif>Naogaon</option>
                                <option value="Narail" @if ($ie_data->house_distric == 'Narail') selected @endif>Narail</option>
                                <option value="Narayanganj" @if ($ie_data->house_distric == 'Narayanganj') selected @endif>Narayanganj</option>
                                <option value="Narsingdi" @if ($ie_data->house_distric == 'Narsingdi') selected @endif>Narsingdi</option>
                                <option value="Natore" @if ($ie_data->house_distric == 'Natore') selected @endif>Natore</option>
                                <option value="Nawabganj" @if ($ie_data->house_distric == 'Nawabganj') selected @endif>Nawabganj</option>
                                <option value="Netrokona" @if ($ie_data->house_distric == 'Netrokona') selected @endif>Netrokona</option>
                                <option value="Nilphamari" @if ($ie_data->house_distric == 'Nilphamari') selected @endif>Nilphamari</option>
                                <option value="Noakhali" @if ($ie_data->house_distric == 'Noakhali') selected @endif>Noakhali</option>
                                <option value="Pabna" @if ($ie_data->house_distric == 'Pabna') selected @endif>Pabna</option>
                                <option value="Panchagarh" @if ($ie_data->house_distric == 'Panchagarh') selected @endif>Panchagarh</option>
                                <option value="Patuakhali" @if ($ie_data->house_distric == 'Patuakhali') selected @endif>Patuakhali</option>
                                <option value="Pirojpur" @if ($ie_data->house_distric == 'Pirojpur') selected @endif>Pirojpur</option>
                                <option value="Rajbari" @if ($ie_data->house_distric == 'Rajbari') selected @endif>Rajbari</option>
                                <option value="Rajshahi" @if ($ie_data->house_distric == 'Rajshahi') selected @endif>Rajshahi</option>
                                <option value="Rangamati" @if ($ie_data->house_distric == 'Rangamati') selected @endif>Rangamati</option>
                                <option value="Rangpur" @if ($ie_data->house_distric == 'Rangpur') selected @endif>Rangpur</option>
                                <option value="Satkhira" @if ($ie_data->house_distric == 'Satkhira') selected @endif>Satkhira</option>
                                <option value="Shariatpur" @if ($ie_data->house_distric == 'Shariatpur') selected @endif>Shariatpur</option>
                                <option value="Sherpur" @if ($ie_data->house_distric == 'Sherpur') selected @endif>Sherpur</option>
                                <option value="Sirajganj" @if ($ie_data->house_distric == 'Sirajganj') selected @endif>Sirajganj</option>
                                <option value="Sunamganj" @if ($ie_data->house_distric == 'Sunamganj') selected @endif>Sunamganj</option>
                                <option value="Sylhet" @if ($ie_data->house_distric == 'Sylhet') selected @endif>Sylhet</option>
                                <option value="Tangail" @if ($ie_data->house_distric == 'Tangail') selected @endif>Tangail</option>
                                <option value="Thakurgaon" @if ($ie_data->house_distric == 'Thakurgaon') selected @endif>Thakurgaon</option>
                            </select>
                        </div> <!-- end -->

                        <div class="">
                            <label for="post" class="block mb-2">Post</label>
                            <input type="text" class="form-input" id="post" name="post" value="{{$ie_data->post ?? ''}}">
                        </div> <!-- end -->
                        <div class="">
                            <label for="address" class="block mb-2">Address</label>
                            <input type="text" class="form-input" id="address" name="address" value="{{$ie_data->address ?? ''}}">
                        </div> <!-- end -->

                        <div class="flex justify-end items-end ">
                            <button type="submit"
                                class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white"
                                id="baccountSaveBtn">Save</button>
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



