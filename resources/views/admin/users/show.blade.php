<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{$user->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">
        <!-- User Profile Card -->
        <div class="card flex-grow">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div class="flex-grow">
                        <div class="flex items-center gap-4 mb-6">
                            @if ($user->photo)
                                <img src="{{asset($user->photo)}}" alt="{{$user->name}}'s photo" class="w-24 h-24 rounded-full object-cover border-4 border-seagreen">
                            @else
                                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-3xl text-gray-500">{{strtoupper(substr($user->name, 0, 1))}}</span>
                                </div>
                            @endif
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800">{{$user->name}}</h1>
                                <div class="flex gap-2 mt-2">
                                    @foreach ($user->roles as $role)
                                        <span class="px-3 py-1 text-sm font-semibold bg-seagreen text-white rounded-full">{{$role->name}}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <h2 class="text-xl font-semibold text-gray-700 border-b pb-2">Basic Information</h2>
                                <div class="space-y-2">
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">User ID:</span>
                                        <span class="font-medium">{{$user->id}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Email:</span>
                                        <span class="font-medium text-seagreen">{{$user->email}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Phone:</span>
                                        <span class="font-medium">{{$user->phone ?? 'Not provided'}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Address:</span>
                                        <span class="font-medium">{{$user->address ?? 'Not provided'}}</span>
                                    </p>
                                </div>
                            </div>
                            <!-- Contact Information -->
                            <div class="space-y-4">
                                <h2 class="text-xl font-semibold text-gray-700 border-b pb-2">Contact Information</h2>
                                <div class="space-y-2">
                                    <!-- Primary Contact -->
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Phone:</span>
                                        <span class="font-medium">{{$user->phone ?? 'Not provided'}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">WhatsApp:</span>
                                        <span class="font-medium">{{$user->whatsapp ?? 'Not provided'}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Email:</span>
                                        <span class="font-medium text-seagreen">{{$user->email}}</span>
                                    </p>

                                    <!-- Family Contacts -->
                                    <div class="mt-4 pt-4 border-t">
                                        <p class="text-sm font-semibold text-gray-700 mb-2">Family Contacts</p>
                                        <div class="space-y-2">
                                            <p class="flex items-center">
                                                <span class="w-32 text-gray-600">Father Mobile:</span>
                                                <span class="font-medium">{{$user->father_mobile ?? 'Not provided'}}</span>
                                            </p>
                                            <p class="flex items-center">
                                                <span class="w-32 text-gray-600">Mother Mobile:</span>
                                                <span class="font-medium">{{$user->mother_mobile ?? 'Not provided'}}</span>
                                            </p>
                                            @if($user->wife_name)
                                            <p class="flex items-center">
                                                <span class="w-32 text-gray-600">Wife Mobile:</span>
                                                <span class="font-medium">{{$user->wife_mobile ?? 'Not provided'}}</span>
                                            </p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Addresses -->
                                    <div class="mt-4 pt-4 border-t">
                                        <p class="text-sm font-semibold text-gray-700 mb-2">Addresses</p>
                                        <div class="space-y-2">
                                            <p class="flex items-start">
                                                <span class="w-32 text-gray-600">Present:</span>
                                                <span class="font-medium flex-1">{{$user->address ?? 'Not provided'}}</span>
                                            </p>
                                            <p class="flex items-start">
                                                <span class="w-32 text-gray-600">Home:</span>
                                                <span class="font-medium flex-1">{{$user->home_address ?? 'Not provided'}}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Reference -->
                                    <div class="mt-4 pt-4 border-t">
                                        <p class="flex items-center">
                                            <span class="w-32 text-gray-600">Reference:</span>
                                            <span class="font-medium">{{$user->ref_name ?? 'Not provided'}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Personal Information -->
                            <div class="space-y-4">
                                <h2 class="text-xl font-semibold text-gray-700 border-b pb-2">Personal Information</h2>
                                <div class="space-y-2">
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Mother Name:</span>
                                        <span class="font-medium">{{$user->mother_name ?? 'Not provided'}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Date of Birth:</span>
                                        <span class="font-medium">{{$user->date_of_birth ? $user->date_of_birth : 'Not provided'}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Gender:</span>
                                        <span class="font-medium">{{$user->gender ?? 'Not provided'}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">NID:</span>
                                        <span class="font-medium">{{$user->nid ?? 'Not provided'}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Occupation:</span>
                                        <span class="font-medium">{{$user->occupation ?? 'Not provided'}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Blood Group:</span>
                                        <span class="font-medium">{{$user->blood_group ?? 'Not provided'}}</span>
                                    </p>
                                </div>
                            </div>
                            <!-- Account Information -->
                            <div class="space-y-4">
                                <h2 class="text-xl font-semibold text-gray-700 border-b pb-2">Account Information</h2>
                                <div class="space-y-2">
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Status:</span>
                                        <span class="font-medium px-3 py-1 rounded-full text-sm {{$user->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}}">
                                            {{$user->status ? 'Active' : 'Inactive'}}
                                        </span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Created:</span>
                                        <span class="font-medium">{{$user->created_at->format('M d, Y h:i A')}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Last Update:</span>
                                        <span class="font-medium">{{$user->updated_at->format('M d, Y h:i A')}}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <span class="w-32 text-gray-600">Last Login:</span>
                                        <span class="font-medium">{{$user->last_login_at ?? 'Never logged in'}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-slot name="script">
        <script>

        </script>
    </x-slot>
</x-app-layout>



