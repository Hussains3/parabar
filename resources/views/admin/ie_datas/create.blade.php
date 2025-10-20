<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Importer / Exporter</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex justify-center items-center lg:flex-row gap-6">

        {{-- Form --}}
        <div class="card max-w-2xl">
            <div class="p-6">
                <h2 class="mb-4 text-xl text-center">New Importer / Exporter</h2>

                <form class="" id="ieCreateForm" enctype="multipart/form-data" action="{{ route('ie_datas.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="grid grid-cols-2 gap-4">
                        <div class="">
                            <label for="org_name" class="block mb-2">Organization Name</label>
                            <input type="text" class="form-input" id="org_name" name="org_name" required autofocus>
                        </div> <!-- end -->
                        <div>
                            <label class="block text-gray-600 mb-2" for="org_logo">Logo</label>
                            <input type="file" id="org_logo" class="form-input border" name="org_logo">
                        </div> <!-- end -->
                        <div>
                            <label for="bin_no" class="block mb-2">BIN No</label>
                            <input type="text" class="form-input" id="bin_no" name="bin_no">
                        </div> <!-- end -->
                        <div>
                            <label for="tin_no" class="block mb-2">TIN No</label>
                            <input type="text" class="form-input" id="tin_no" name="tin_no">
                        </div> <!-- end -->

                        <div class="">
                            <label for="name" class="block mb-2">Importer / Exporter Name</label>
                            <input type="text" class="form-input" id="name" name="name" required autofocus>
                        </div> <!-- end -->

                        <div class="">
                            <label for="fax_telephone" class="block mb-2">Fax/Telephone</label>
                            <input type="text" class="form-input" id="fax_telephone" name="fax_telephone">
                        </div> <!-- end -->
                        <div class="">
                            <label for="phone_primary" class="block mb-2">Phone Number (Main)</label>
                            <input type="text" class="form-input" id="phone_primary" name="phone_primary">
                        </div> <!-- end -->
                        <div class="">
                            <label for="phone_secondary" class="block mb-2">Secondary Phone Number</label>
                            <input type="text" class="form-input" id="phone_secondary" name="phone_secondary">
                        </div> <!-- end -->

                        <div class="">
                            <label for="email_primary" class="block mb-2">Email (Main)</label>
                            <input type="email" class="form-input" id="email_primary" name="email_primary">
                        </div> <!-- end -->
                        <div class="">
                            <label for="email_secondary" class="block mb-2">Secondary Email</label>
                            <input type="email" class="form-input" id="email_secondary" name="email_secondary">
                        </div> <!-- end -->
                        <div class="">
                            <label for="whatsapp" class="block mb-2">Whatsapp Number</label>
                            <input type="text" class="form-input" id="whatsapp" name="whatsapp">
                        </div> <!-- end -->

                        <div class="">
                            <label for="house_distric" class="block mb-2">Distric</label>
                            <select class="form-input" name="house_distric" id="house_distric">
                                <option value="Bagerhat">Bagerhat</option>
                                <option value="Bandarban">Bandarban</option>
                                <option value="Barguna">Barguna</option>
                                <option value="Barisal">Barisal</option>
                                <option value="Bhola">Bhola</option>
                                <option value="Bogra">Bogra</option>
                                <option value="Brahmanbaria">Brahmanbaria</option>
                                <option value="Chandpur">Chandpur</option>
                                <option value="Chittagong">Chittagong</option>
                                <option value="Chuadanga">Chuadanga</option>
                                <option value="Comilla">Comilla</option>
                                <option value="Cox'sBazar">Cox'sBazar</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Dinajpur">Dinajpur</option>
                                <option value="Faridpur">Faridpur</option>
                                <option value="Feni">Feni</option>
                                <option value="Gaibandha">Gaibandha</option>
                                <option value="Gazipur">Gazipur</option>
                                <option value="Gopalganj">Gopalganj</option>
                                <option value="Habiganj">Habiganj</option>
                                <option value="Jaipurhat">Jaipurhat</option>
                                <option value="Jamalpur">Jamalpur</option>
                                <option value="Jessore">Jessore</option>
                                <option value="Jhalokati">Jhalokati</option>
                                <option value="Jhenaidah">Jhenaidah</option>
                                <option value="Khagrachari">Khagrachari</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Kishoreganj">Kishoreganj</option>
                                <option value="Kurigram">Kurigram</option>
                                <option value="Kushtia">Kushtia</option>
                                <option value="Lakshmipur">Lakshmipur</option>
                                <option value="Lalmonirhat">Lalmonirhat</option>
                                <option value="Madaripur">Madaripur</option>
                                <option value="Magura">Magura</option>
                                <option value="Manikganj">Manikganj</option>
                                <option value="Maulvibazar">Maulvibazar</option>
                                <option value="Meherpur">Meherpur</option>
                                <option value="Munshiganj">Munshiganj</option>
                                <option value="Mymensingh">Mymensingh</option>
                                <option value="Naogaon">Naogaon</option>
                                <option value="Narail">Narail</option>
                                <option value="Narayanganj">Narayanganj</option>
                                <option value="Narsingdi">Narsingdi</option>
                                <option value="Natore">Natore</option>
                                <option value="Nawabganj">Nawabganj</option>
                                <option value="Netrokona">Netrokona</option>
                                <option value="Nilphamari">Nilphamari</option>
                                <option value="Noakhali">Noakhali</option>
                                <option value="Pabna">Pabna</option>
                                <option value="Panchagarh">Panchagarh</option>
                                <option value="Patuakhali">Patuakhali</option>
                                <option value="Pirojpur">Pirojpur</option>
                                <option value="Rajbari">Rajbari</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Rangamati">Rangamati</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Satkhira">Satkhira</option>
                                <option value="Shariatpur">Shariatpur</option>
                                <option value="Sherpur">Sherpur</option>
                                <option value="Sirajganj">Sirajganj</option>
                                <option value="Sunamganj">Sunamganj</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Tangail">Tangail</option>
                                <option value="Thakurgaon">Thakurgaon</option>
                            </select>
                        </div> <!-- end -->

                        <div class="">
                            <label for="post" class="block mb-2">Post</label>
                            <input type="text" class="form-input" id="post" name="post">
                        </div> <!-- end -->
                        <div class="">
                            <label for="address" class="block mb-2">Address</label>
                            <input type="text" class="form-input" id="address" name="address">
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

    </x-slot>
</x-app-layout>
