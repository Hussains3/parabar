<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Create Project</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        {{-- Form --}}
        <div class="card flex-grow">
            <div class="p-6">

                <div class="flex justify-between items-center mb-4">

                    <h2 class="text-xl">New Agent</h2>
                    <a href="{{route('agents.index')}}">
                        <button class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white " id="">All Agent</button>
                    </a>
                </div>

                <form class="" id="agentCreateForm" enctype="multipart/form-data" action="{{route('agents.store')}}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="grid grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="ain_no" class="block mb-2">AIN No</label>
                            <input type="text" class="form-input" id="ain_no" name="ain_no" required placeholder="AIN Number">
                        </div> <!-- end -->

                        <div class="">
                            <label for="name" class="block mb-2">Agency Name</label>
                            <input type="text" class="form-input" id="name" name="name" placeholder="Agent Name" required>
                        </div> <!-- end -->

                        <div class="">
                            <label for="bangla_name" class="block mb-2">Bangla Name</label>
                            <input type="text" class="form-input" id="bangla_name" name="bangla_name" placeholder="Bangla Name" >
                        </div> <!-- end -->

                        <div class="">
                            <label for="license_no" class="block mb-2">License No</label>
                            <input type="text" class="form-input" id="license_no" name="license_no" placeholder="License No" >
                        </div> <!-- end -->
                        <div class="">
                            <label for="license_issue_date" class="block mb-2">Issue Date</label>
                            <input type="date" class="form-input" id="license_issue_date" name="license_issue_date" >
                        </div> <!-- end -->

                        <div class="">
                            <label for="membership_no" class="block mb-2">Membership No</label>
                            <input type="text" class="form-input" id="membership_no" name="membership_no" placeholder="Membership No" >
                        </div> <!-- end -->

                        <div class="">
                            <label for="agency_logo" class="block mb-2">Agency Logo</label>
                            <input type="file" class="form-input pt-[3px] pb-[2px]" id="agency_logo" name="agency_logo">
                        </div> <!-- end -->




                        <div class="">
                            <label for="office_address" class="block mb-2">Office Address</label>
                            <input type="text" class="form-input" id="office_address" name="office_address" placeholder="Office Adderss">
                        </div> <!-- end -->

                        <div class="col-span-3 lg:col-span-4">
                            <p>Owner's Information <hr></p>
                        </div>

                        <div class="">
                            <label for="owners_name" class="block mb-2">Owner / Manager Name</label>
                            <input type="text" class="form-input" id="owners_name" name="owners_name" placeholder="Owner Name" >
                        </div> <!-- end -->

                        <div class="">
                            <label for="owners_gender" class="block mb-2">Owner Gender</label>
                            <select name="owners_gender" id="owners_gender" class="form-select text-gray-900" >
                                <option value="" >Selece One . .</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div> <!-- end -->


                        <div class="">
                            <label for="photo" class="block mb-2">Owner Photo</label>
                            <input type="file" class="form-input pt-[3px] pb-[2px]" id="photo" name="photo">
                        </div> <!-- end -->


                        <div class="">
                            <label for="owners_designation" class="block mb-2">Owner Designation</label>
                            <select name="owners_designation" id="owners_designation" class="form-select text-gray-900">
                                <option value="" >Selece One . .</option>
                                <option value="Proprietor">Proprietor</option>
                                <option value="Managing Director">Managing Director</option>
                                <option value="Managing Partner">Managing Partner</option>
                                <option value="Chairman">Chairman</option>
                                <option value="Partner">Partner</option>
                                <option value="Director">Director</option>
                            </select>
                        </div> <!-- end -->




                        <div class="">
                            <label for="phone" class="block mb-2">Phone Number</label>
                            <input type="text" class="form-input" id="phone" name="phone" required>
                        </div> <!-- end -->


                        <div class="">
                            <label for="email" class="block mb-2">Email</label>
                            <input type="email" class="form-input" id="email" name="email" required>
                        </div> <!-- end -->


                        <div class="">
                            <label for="house" class="block mb-2">Station / House</label>
                            <input type="text" class="form-input" id="house" name="house" required value="Benapole">
                        </div> <!-- end -->

                        <div class="col-span-3 lg:col-span-4">
                            <p>Others Information <hr></p>
                        </div>

                        <div class="">
                            <label for="parmanent_address" class="block mb-2">Parmanent Address</label>
                            <input type="text" class="form-input" id="parmanent_address" name="parmanent_address" placeholder="Parmanent Adderss">
                        </div> <!-- end -->


                        <div class="col-span-2 lg:col-span-3">
                            <label for="note" class="block mb-2">Note</label>
                            <textarea  class="form-input" name="note" id="note" cols="30" rows="1" placeholder="Note"></textarea>
                        </div> <!-- end -->

                        <div class="col-span-3 lg:col-span-4 ">
                            <button type="submit"
                                class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg text-white"
                                id="baccountSaveBtn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $("form #name").on('blur', () => {
                    const slug = slugify($("form #name").val());
                    $("form #slug").val(slug);
                });
            });
        </script>
    </x-slot>
</x-app-layout>
