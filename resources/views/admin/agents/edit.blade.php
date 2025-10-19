<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit {{$agent->name}}</x-slot>

    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">
        {{-- Form --}}
        <div class="card flex-grow">
            <div class="p-6">
                <h2 class="mb-4 text-xl">Edit Agent</h2>

                <form action="{{route('agents.update', $agent->id)}}" class="" id="agentCreateForm" enctype="multipart/form-data" method="post" novalidate>
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="ain_no" class="block mb-2">AIN No <span class="text-red-500">*</span></label>
                            <input type="text" class="form-input @error('ain_no') border-red-500 @enderror"
                                id="ain_no" name="ain_no" required
                                placeholder="AIN Number" value="{{$agent->ain_no}}"
                                aria-describedby="ain_no_error">
                            @error('ain_no')
                                <p class="text-red-500 text-sm mt-1" id="ain_no_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="name" class="block mb-2">Agency Name <span class="text-red-500">*</span></label>
                            <input type="text" class="form-input @error('name') border-red-500 @enderror"
                                id="name" name="name" required
                                placeholder="Agent Name" value="{{$agent->name}}"
                                aria-describedby="name_error">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1" id="name_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="">
                            <label for="bangla_name" class="block mb-2">Bangla Name</label>
                            <input type="text" class="form-input" id="bangla_name" name="bangla_name" placeholder="Bangla Name" value="{{$agent->bangla_name}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="license_no" class="block mb-2">License No</label>
                            <input type="text" class="form-input" id="license_no" name="license_no" placeholder="License No" value="{{$agent->license_no}}">
                        </div> <!-- end -->
                        <div class="">
                            <label for="license_issue_date" class="block mb-2">Issue Date</label>
                            <input type="date" class="form-input" id="license_issue_date" name="license_issue_date" value="{{$agent->license_issue_date}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="membership_no" class="block mb-2">Membership No</label>
                            <input type="text" class="form-input" id="membership_no" name="membership_no" placeholder="Membership No" value="{{$agent->membership_no ?? ''}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="agency_logo" class="block mb-2">Agency Logo</label>
                            <input type="file" class="form-input pt-[3px] pb-[2px]" id="agency_logo" name="agency_logo">
                        </div> <!-- end -->

                        <div class="">
                            <label for="office_address" class="block mb-2">Office Address</label>
                            <textarea class="form-input @error('office_address') border-red-500 @enderror"
                                id="office_address" name="office_address"
                                placeholder="Office Address"
                                rows="2"
                                aria-describedby="office_address_error">{{$agent->office_address}}</textarea>
                            @error('office_address')
                                <p class="text-red-500 text-sm mt-1" id="office_address_error">{{ $message }}</p>
                            @enderror
                        </div> <!-- end -->

                        <div class="col-span-3 lg:col-span-4">
                            <p>Owner's Information <hr></p>
                        </div>

                        <div class="">
                            <label for="owners_name" class="block mb-2">Owner / Manager Name</label>
                            <input type="text" class="form-input" id="owners_name" name="owners_name" placeholder="Owner Name" value="{{$agent->owners_name}}">
                        </div> <!-- end -->

                        <div class="">
                            <label for="owners_gender" class="block mb-2">Owner Gender</label>
                            <select name="owners_gender" id="owners_gender" class="form-select text-gray-900">
                                <option value="">Select One . .</option>
                                <option value="Male" {{ $agent->owners_gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $agent->owners_gender == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ $agent->owners_gender == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div> <!-- end -->

                        <div class="">
                            <label for="owner_photo" class="block mb-2">Owner Photo</label>
                            <input type="file" class="form-input pt-[3px] pb-[2px]" id="owner_photo" name="owner_photo">
                        </div> <!-- end -->

                        <div>
                            <label for="owners_designation" class="block mb-2">Designation</label>
                            <select name="owners_designation" id="owners_designation"
                                class="form-select text-gray-900 @error('owners_designation') border-red-500 @enderror"
                                aria-describedby="owners_designation_error">
                                <option value="">Select One...</option>
                                <option value="Proprietor" {{ $agent->owners_designation == 'Proprietor' ? 'selected' : '' }}>Proprietor</option>
                                <option value="Managing Director" {{ $agent->owners_designation == 'Managing Director' ? 'selected' : '' }}>Managing Director</option>
                                <option value="Managing Partner" {{ $agent->owners_designation == 'Managing Partner' ? 'selected' : '' }}>Managing Partner</option>
                                <option value="Chairman" {{ $agent->owners_designation == 'Chairman' ? 'selected' : '' }}>Chairman</option>
                                <option value="Partner" {{ $agent->owners_designation == 'Partner' ? 'selected' : '' }}>Partner</option>
                                <option value="Director" {{ $agent->owners_designation == 'Director' ? 'selected' : '' }}>Director</option>
                            </select>
                            @error('owners_designation')
                                <p class="text-red-500 text-sm mt-1" id="owners_designation_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block mb-2">Phone Number <span class="text-red-500">*</span></label>
                            <input type="tel" class="form-input @error('phone') border-red-500 @enderror"
                                id="phone" name="phone" required
                                value="{{$agent->phone}}"
                                pattern="[0-9]{11}"
                                placeholder="01XXXXXXXXX"
                                aria-describedby="phone_error">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1" id="phone_error">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Format: 01XXXXXXXXX</p>
                        </div>

                        <div>
                            <label for="email" class="block mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" class="form-input @error('email') border-red-500 @enderror"
                                id="email" name="email" required
                                value="{{$agent->email}}"
                                placeholder="example@domain.com"
                                aria-describedby="email_error">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1" id="email_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="">
                            <label for="house" class="block mb-2">Station / House <span class="text-red-500">*</span></label>
                            <input type="text" class="form-input @error('house') border-red-500 @enderror"
                                id="house" name="house" required
                                value="{{$agent->house}}"
                                placeholder="Station or House"
                                aria-describedby="house_error">
                            @error('house')
                                <p class="text-red-500 text-sm mt-1" id="house_error">{{ $message }}</p>
                            @enderror
                        </div> <!-- end -->

                        <div class="col-span-3 lg:col-span-4">
                            <p>Others Information <hr></p>
                        </div>

                        <div class="">
                            <label for="parmanent_address" class="block mb-2">Parmanent Address</label>
                            <input type="text" class="form-input" id="parmanent_address" name="parmanent_address" placeholder="Parmanent Address" value="{{$agent->parmanent_address}}">
                        </div> <!-- end -->

                        <div class="col-span-2 lg:col-span-3">
                            <label for="note" class="block mb-2">Note</label>
                            <textarea class="form-input @error('note') border-red-500 @enderror"
                                name="note" id="note"
                                rows="2"
                                placeholder="Additional notes">{{$agent->note}}</textarea>
                            @error('note')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
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
    </x-slot>
</x-app-layout>



