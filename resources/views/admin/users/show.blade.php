<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{$user->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex gap-6">

        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div class="">
                        <h1 class="text-2xl font-semibold mt-4">{{$user->name}}</h1>
                        <p class="">Email: <span class="text-seagreen">{{$user->email}}</span></p>
                        <p class="">Created At: <span class="text-seagreen">{{$user->created_at}}</span></p>
                        <p class="">Updated At: <span class="text-seagreen">{{$user->updated_at}}</span></p>
                        <input type="hidden" name="" id="userid" value="{{$user->id}}">
                    </div>
                    @if ($user->photo)
                        <img src="{{asset($user->photo)}}" alt="" srcset="" class="w-24">
                    @endif
                </div>
                {{-- user role --}}
                <div class="grid grid-cols-4 gap-2 mt-4" id="rolediv">
                </div>
            </div>
        </div> <!-- end card -->

        <div class="card">
            <div class="p-6">

                <form action="{{ route('users.update',$user->id) }}" method="post" enctype="multipart/form-data">
                    <div class="grid lg:grid-cols-2 gap-5">
                        @csrf
                        @method('PATCH')


                        <div>
                            <label for="name" class="block mb-2">Name</label>
                            <input type="text" class="form-input" id="name" name="name" required value="{{$user->name}}">
                        </div> <!-- end -->

                        <div>
                            <label for="email" class="block mb-2">Email</label>
                            <input type="text" class="form-input" id="email" name="email" required="" value="{{$user->email}}">
                        </div> <!-- end -->

                        <div>
                            <label class="block text-gray-600 mb-2" for="photo">Profile Picture</label>
                            <input type="file" id="photo" class="form-input border" name="photo">
                        </div> <!-- end -->

                        @if ($user->agency)
                            
                        <div>
                            <label class="block text-gray-600 mb-2" for="agent_id">Select Agtent</label>
                            <select class="form-select" id="agent_id" name="agent_id" required>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" @if($agent->id == $user->agency->id) selected @endif>{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div> <!-- end -->
                        @endif


                        <div class="lg:col-span-2 mt-3">
                            <button type="submit"
                                class="font-mont mt-8 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Update</button>
                        </div> <!-- end button -->


                    </div>
                </form>

            </div>
        </div> <!-- end card -->
    </div>


    <x-slot name="script">
        <script>
            const rolesContainer = $('#rolediv');

            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                const userid = $('#userid').val();
                
                $.ajax({
                    url: '/users/showuserrole/'+ userid,
                    method: 'GET',
                    success: function (response) {
                        rolesContainer.empty(); // Clear the container

                        // Render user roles
                        response.userRoles.forEach(function (role) {
                            rolesContainer.append(`
                                <span class="inline-flex items-center gap-1.5 py-0.5 text-sm font-medium bg-seagreen text-white px-4 capitalize rounded-full hover:scale-110 cursor-pointer" onClick="roleUnmount('${role.name}',${userid})">
                                    ${role.name} x
                                </span>
                            `);
                        });

                        // Render roles excluding user roles
                        response.roles.forEach(function (role) {
                            let isUserRole = response.userRoles.some(userRole => userRole.id === role.id);
                            if (!isUserRole) {
                                rolesContainer.append(`
                                    <span class="inline-flex items-center gap-1.5 py-0.5 text-sm font-medium bg-red-500 text-white px-4 capitalize rounded-full hover:scale-110 cursor-pointer" onClick="roleMount('${role.name}',${userid});">
                                        ${role.name} +
                                    </span>
                                `);
                            }
                        });
                    },
                    error: function (error) {
                        console.log('Error fetching roles:', error);
                    }
                });
            });


            // Unassign role
            function roleUnmount(rolename,userID) {
                Swal.fire({
                    title: "Unassign ?",
                    text: "Are you sure to unassign this role ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Unassign",
                    background: 'rgba(255, 255, 255, 0.6)',
                    padding: '20px',
                    confirmButtonColor: '#0db8a6',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            method: 'POST',
                            url: BASE_URL + 'users/unassignrole',
                            dataType: 'json',
                            data: {
                                userid: userID,
                                rolename: rolename,
                            },
                            success: function(response) {
                                rolesContainer.empty(); // Clear the container

                                // Render user roles
                                response.userRoles.forEach(function (role) {
                                    rolesContainer.append(`
                                        <span class="inline-flex items-center gap-1.5 py-0.5 text-sm font-medium bg-seagreen text-white px-4 capitalize rounded-full hover:scale-110 cursor-pointer" onClick="roleUnmount('${role.name}',${userID})">
                                            ${role.name} x
                                        </span>
                                    `);
                                });

                                // Render roles excluding user roles
                                response.roles.forEach(function (role) {
                                    let isUserRole = response.userRoles.some(userRole => userRole.id === role.id);
                                    if (!isUserRole) {
                                        rolesContainer.append(`
                                            <span class="inline-flex items-center gap-1.5 py-0.5 text-sm font-medium bg-red-500 text-white px-4 capitalize rounded-full hover:scale-110 cursor-pointer" onClick="roleMount('${role.name}',${userID})">
                                                ${role.name} +
                                            </span>
                                        `);
                                    }
                                });
                            },
                            error: function (error) {
                                console.log('Error fetching roles:', error);
                            }
                        });
                    }
                });
            }


            // Assigning role
            function roleMount(rolename,userID) {
                Swal.fire({
                    title: "Assign ?",
                    text: "Are you sure to assign this role ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Assign",
                    background: 'rgba(255, 255, 255, 0.6)',
                    padding: '20px',
                    confirmButtonColor: '#0db8a6',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            method: 'POST',
                            url: BASE_URL + 'users/assignrole',
                            dataType: 'json',
                            data: {
                                userid: userID,
                                rolename: rolename,
                            },
                            success: function(response) {
                                rolesContainer.empty(); // Clear the container

                                // Render user roles
                                response.userRoles.forEach(function (role) {
                                    rolesContainer.append(`
                                        <span class="inline-flex items-center gap-1.5 py-0.5 text-sm font-medium bg-seagreen text-white px-4 capitalize rounded-full hover:scale-110 cursor-pointer" onClick="roleUnmount('${role.name}',${userID})">
                                            ${role.name} x
                                        </span>
                                    `);
                                });

                                // Render roles excluding user roles
                                response.roles.forEach(function (role) {
                                    let isUserRole = response.userRoles.some(userRole => userRole.id === role.id);
                                    if (!isUserRole) {
                                        rolesContainer.append(`
                                            <span class="inline-flex items-center gap-1.5 py-0.5 text-sm font-medium bg-red-500 text-white px-4 capitalize rounded-full hover:scale-110 cursor-pointer" onClick="roleMount('${role.name}',${userID})">
                                                ${role.name} +
                                            </span>
                                        `);
                                    }
                                });
                            },
                            error: function (error) {
                                console.log('Error fetching roles:', error);
                            }
                        });
                    }
                });
            }

        </script>
    </x-slot>
</x-app-layout>



