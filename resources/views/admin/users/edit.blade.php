
<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit User</x-slot>
    {{-- Page Content --}}
        {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card max-w-4xl mx-auto">

            <div class="mt-5 md:mt-0 md:col-span-2">

                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="p-6  sm:p-6">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    User's personal and contact information.
                                </p>
                            </div>
                            <div class="grid grid-cols-6 gap-6">
                                <!-- Basic Information -->
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="name" class="block">Name</label>
                                    <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="email" class="block">Email</label>
                                    <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="password" class="block">Password <span class="text-sm text-gray-500">(Leave blank to keep current, minimum 8 character)</span></label>
                                    <input type="password" name="password" id="password" class="form-input">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="password_confirmation" class="block">Confirm Password <span class="text-sm text-gray-500">(Leave blank to keep current, minimum 8 character)</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="role" class="block">Role</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option disabled value="">Choose...</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ in_array($role->name, $userRole) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> <!-- end -->

                                <!-- Staff Information -->
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="staff_id_no" class="block">Staff ID</label>
                                    <input type="text" name="staff_id_no" id="staff_id_no" class="form-input" value="{{ old('staff_id_no', $user->staff_id_no) }}">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="post" class="block">Post</label>
                                    <input type="text" name="post" id="post" class="form-input" value="{{ old('post', $user->post) }}">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="work_site" class="block">Work Site</label>
                                    <input type="text" name="work_site" id="work_site" class="form-input" value="{{ old('work_site', $user->work_site) }}">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="blood_group" class="block">Blood Group</label>
                                    <select name="blood_group" id="blood_group" class="form-select">
                                        <option value="">Select Blood Group</option>
                                        @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                                            <option value="{{ $group }}" {{ old('blood_group', $user->blood_group) == $group ? 'selected' : '' }}>
                                                {{ $group }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Contact Information -->
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="phone" class="block">Phone</label>
                                    <input type="tel" name="phone" id="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="whatsapp" class="block">WhatsApp</label>
                                    <input type="tel" name="whatsapp" id="whatsapp" class="form-input" value="{{ old('whatsapp', $user->whatsapp) }}">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="date_of_birth" class="block">Date of Birth</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-input" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                </div>

                                <div class="col-span-6">
                                    <label for="home_address" class="block">Home Address</label>
                                    <input type="text" name="home_address" id="home_address" class="form-input" value="{{ old('home_address', $user->home_address) }}">

                                <!-- Family Information -->
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="father_name" class="block">Father's Name</label>
                                    <input type="text" name="father_name" id="father_name" class="form-input" value="{{ old('father_name', $user->father_name) }}">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="father_mobile" class="block">Father's Mobile</label>
                                    <input type="tel" name="father_mobile" id="father_mobile" class="form-input" value="{{ old('father_mobile', $user->father_mobile) }}">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="mother_name" class="block">Mother's Name</label>
                                    <input type="text" name="mother_name" id="mother_name" class="form-input" value="{{ old('mother_name', $user->mother_name) }}">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="mother_mobile" class="block">Mother's Mobile</label>
                                    <input type="tel" name="mother_mobile" id="mother_mobile" class="form-input" value="{{ old('mother_mobile', $user->mother_mobile) }}">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="wife_name" class="block">Spouse's Name</label>
                                    <input type="text" name="wife_name" id="wife_name" class="form-input" value="{{ old('wife_name', $user->wife_name) }}">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="wife_mobile" class="block">Spouse's Mobile</label>
                                    <input type="tel" name="wife_mobile" id="wife_mobile" class="form-input" value="{{ old('wife_mobile', $user->wife_mobile) }}">
                                </div>

                                <!-- Reference Information -->
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="ref_name" class="block">Reference Name</label>
                                    <input type="text" name="ref_name" id="ref_name" class="form-input" value="{{ old('ref_name', $user->ref_name) }}">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="address" class="block">Address</label>
                                    <input type="text" name="address" id="address" class="form-input" value="{{ old('address', $user->address) }}">
                                </div>

                                <!-- Photo Upload -->
                                <div class="col-span-6">
                                    <label class="block">Photo</label>
                                    <div class="mt-1 flex items-center space-x-5">
                                        @if ($user->photo)
                                            <img src="{{ asset($user->photo) }}" alt="{{ $user->name }}'s photo" class="h-12 w-12 rounded-full object-cover">
                                        @else
                                            <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </span>
                                        @endif
                                        <input type="file" name="photo" id="photo" class="py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        @if ($user->photo)
                                            <span class="text-sm text-gray-500">Leave empty to keep current photo</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <a href="{{ route('users.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700  hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <x-slot name="script">
    </x-slot>
</x-app-layout>
