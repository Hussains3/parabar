<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Add Team Member</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">

                <form action="{{ route('members.store') }}" method="post" enctype="multipart/form-data">
                    <div class="grid lg:grid-cols-2 gap-5">
                        @csrf
                        @method('post')


                        <div>
                            <label for="name" class="block mb-2">Name</label>
                            <input type="text" class="form-input" id="name" name="name" required>
                        </div> <!-- end -->

                        <div>
                            <label for="slug" class="block mb-2">Slug</label>
                            <input type="text" class="form-input" id="slug" name="slug" required=""
                                readonly>
                        </div> <!-- end -->

                        <div>
                            <label for="designation" class="block mb-2">Designation</label>
                            <input type="text" class="form-input" id="designation" name="designation" required>
                        </div> <!-- end -->

                        <div>
                            <label for="email" class="block mb-2">Email</label>
                            <input type="email" class="form-input" id="email" name="email">
                        </div> <!-- end -->

                        <div>
                            <label for="website" class="block mb-2">Website</label>
                            <input type="text" class="form-input" id="website" name="website">
                        </div> <!-- end -->


                        <div>
                            <label class="block text-gray-600 mb-2" for="photo">Photo</label>
                            <input type="file" id="photo" class="form-input border" name="photo" required>
                        </div> <!-- end -->


                        {{-- Social Midea --}}
                        <div class="lg-col-span-2 socialMediaFildSetParrent p-4 border border-gray-200 rounded-md">
                            <h2 class="mb-4 font-semibold text-lg">Your Social Medias</h2>
                            {{-- For each social Media --}}
                            <div class="fildset flex flex-flow gap-1 mb-2">
                                <div class="fbasis-1/5">
                                    <label class="block mb-2">Social Media</label>
                                    <input type="text" class="form-input" name="smedianame[]">
                                </div> <!-- end -->
                                <div class="flex-grow ">
                                    <label class="block mb-2">Profile Link</label>
                                    <input type="text" class="form-input" name="smedialink[]">
                                </div> <!-- end -->
                                <div class="fbasis-1/5">
                                    <label class="block mb-2">Media Icon</label>
                                    <input class="form-input" list="iconlist" name="smediaicon[]" />


                                </div> <!-- end -->
                                {{-- <div class="self-end basis-1/7">
                                    <button class="form-input bg-seagreen/40 hover:bg-seagreen" id="apsmidea"> <span
                                            class="menu-icon"><i class="mdi mdi-plus"></i></span></button>

                                </div> --}}

                            </div>

                            {{-- For each social Media --}}
                            <div class="fildset flex flex-flow gap-1 mb-2">
                                <div class="fbasis-1/5">
                                    <label class="block mb-2">Social Media</label>
                                    <input type="text" class="form-input" name="smedianame[]">
                                </div> <!-- end -->
                                <div class="flex-grow ">
                                    <label class="block mb-2">Profile Link</label>
                                    <input type="text" class="form-input" name="smedialink[]">
                                </div> <!-- end -->
                                <div class="fbasis-1/5">
                                    <label class="block mb-2">Media Icon</label>
                                    <input class="form-input" list="iconlist" name="smediaicon[]" />


                                </div> <!-- end -->
                                {{-- <div class="self-end basis-1/7">
                                    <button class="form-input bg-seagreen/40 hover:bg-seagreen" id="apsmidea"> <span
                                            class="menu-icon"><i class="mdi mdi-plus"></i></span></button>

                                </div> --}}

                            </div>

                            {{-- For each social Media --}}
                            <div class="fildset flex flex-flow gap-1 mb-2">
                                <div class="fbasis-1/5">
                                    <label class="block mb-2">Social Media</label>
                                    <input type="text" class="form-input" name="smedianame[]">
                                </div> <!-- end -->
                                <div class="flex-grow ">
                                    <label class="block mb-2">Profile Link</label>
                                    <input type="text" class="form-input" name="smedialink[]">
                                </div> <!-- end -->
                                <div class="fbasis-1/5">
                                    <label class="block mb-2">Media Icon</label>
                                    <input class="form-input" list="iconlist" name="smediaicon[]" />


                                </div> <!-- end -->
                                {{-- <div class="self-end basis-1/7">
                                    <button class="form-input bg-seagreen/40 hover:bg-seagreen" id="apsmidea"> <span
                                            class="menu-icon"><i class="mdi mdi-plus"></i></span></button>

                                </div> --}}

                            </div>

                            {{-- For each social Media --}}
                            <div class="fildset flex flex-flow gap-1 mb-2">
                                <div class="fbasis-1/5">
                                    <label class="block mb-2">Social Media</label>
                                    <input type="text" class="form-input" name="smedianame[]">
                                </div> <!-- end -->
                                <div class="flex-grow ">
                                    <label class="block mb-2">Profile Link</label>
                                    <input type="text" class="form-input" name="smedialink[]">
                                </div> <!-- end -->
                                <div class="fbasis-1/5">
                                    <label class="block mb-2">Media Icon</label>
                                    <input class="form-input" list="iconlist" name="smediaicon[]" />


                                </div> <!-- end -->
                                {{-- <div class="self-end basis-1/7">
                                    <button class="form-input bg-seagreen/40 hover:bg-seagreen" id="apsmidea"> <span
                                            class="menu-icon"><i class="mdi mdi-plus"></i></span></button>

                                </div> --}}

                            </div>



                        </div>

                        {{-- Skills --}}
                        <div class="lg-col-span-2 socialMediaFildSetParrent p-4 border border-gray-200 rounded-md">
                            <h2 class="mb-4 font-semibold text-lg">Your Skills and Experience</h2>
                            {{-- For each skills --}}
                            <div class="fildset flex flex-flow gap-1 mb-2">
                                <div class="flex-grow">
                                    <label class="block mb-2">Skill Name</label>
                                    <input type="text" class="form-input" name="skillname[]">
                                </div> <!-- end -->
                                <div class="fbasis-1/7">
                                    <label class="block mb-2">Experience Percent (%)</label>
                                    <input type="number" class="form-input" name="skillexp[]" min="0" max="100" value="0">
                                </div> <!-- end -->
                            </div>

                            {{-- For each skills --}}
                            <div class="fildset flex flex-flow gap-1 mb-2">
                                <div class="flex-grow">
                                    <label class="block mb-2">Skill Name</label>
                                    <input type="text" class="form-input" name="skillname[]">
                                </div> <!-- end -->
                                <div class="fbasis-1/7">
                                    <label class="block mb-2">Experience Percent (%)</label>
                                    <input type="number" class="form-input" name="skillexp[]" min="0" max="100" value="0">
                                </div> <!-- end -->
                            </div>

                            {{-- For each skills --}}
                            <div class="fildset flex flex-flow gap-1 mb-2">
                                <div class="flex-grow">
                                    <label class="block mb-2">Skill Name</label>
                                    <input type="text" class="form-input" name="skillname[]">
                                </div> <!-- end -->
                                <div class="fbasis-1/7">
                                    <label class="block mb-2">Experience Percent (%)</label>
                                    <input type="number" class="form-input" name="skillexp[]" min="0" max="100" value="0">
                                </div> <!-- end -->
                            </div>

                            {{-- For each skills --}}
                            <div class="fildset flex flex-flow gap-1 mb-2">
                                <div class="flex-grow">
                                    <label class="block mb-2">Skill Name</label>
                                    <input type="text" class="form-input" name="skillname[]">
                                </div> <!-- end -->
                                <div class="fbasis-1/7">
                                    <label class="block mb-2">Experience Percent (%)</label>
                                    <input type="number" class="form-input" name="skillexp[]" min="0" max="100" value="0">
                                </div> <!-- end -->
                            </div>

                        </div>


                        <div class="mt-5">
                            <h6 class="text-sm mb-2">Member Type</h6>
                            <div class="flex flex-wrap gap-5">
                                <div class="flex items-center">
                                    <input type="radio" class="form-radio text-primary" name="type" value="1" id="inhouse" checked="">
                                    <label class="ms-1.5" for="inhouse">Inhouse</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" class="form-radio text-primary" name="type" value="2" id="freelance">
                                    <label class="ms-1.5" for="freelance">Freelance</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" class="form-radio text-primary" name="type" value="3" id="xinhouse">
                                    <label class="ms-1.5" for="xinhouse">X Inhouse</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h6 class="text-sm mb-2">As - </h6>
                            <div class="flex flex-wrap gap-5">
                                <div class="flex items-center">
                                    <input type="radio" class="form-radio text-primary" name="executive" id="exicutive" value="1" checked="">
                                    <label class="ms-1.5" for="exicutive">Executive</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" class="form-radio text-primary" name="executive" id="nonexicutive" value="2">
                                    <label class="ms-1.5" for="nonexicutive">Non Exicutive</label>
                                </div>
                            </div>
                        </div>



                        <datalist id="iconlist">
                            <option value="facebook-tag">
                            <option value="twitter">
                            <option value="instagram">
                            <option value="linkedin">
                            <option value="github">
                            <option value="behance-tag">
                            <option value="dribbble">
                            <option value="pinterest">
                            <option value="youtube">
                        </datalist>




                        <div class="lg:col-span-2 mt-3">
                            <button type="submit"
                                class="font-mont mt-8 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SAVE'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Save</button>
                        </div> <!-- end button -->


                    </div>
                </form>

            </div>
        </div> <!-- end card -->



    </div>


    <x-slot name="script">
        <script>
            $(document).ready(function() {

                $("form #name").on('blur', () => {
                    const slug = slugify($("form #name").val());
                    $("form #slug").val(slug);
                });


                // Add new row
                // $("#apsmidea").click(function(e) {
                //     e.preventDefault();
                //     var html = '<div class="fildset flex flex-flow gap-1 mb-2"><div class="fbasis-1/5"><label class="block mb-2">Social Media</label><input type="text" class="form-input" name="smedianame[]"></div> <!-- end --><div class="flex-grow "><label class="block mb-2">Profile Link</label><input type="text" class="form-input" name="smedialink[]"></div> <!-- end --><div class="fbasis-1/5"><label class="block mb-2">Media Icon</label><input class="form-input" list="iconlist" name="smediaicon[]" /><datalist id="iconlist"><option value="facebook"><option value="Coconut"><option value="Mint"><option value="Strawberry"><option value="Vanilla"></datalist></div> <!-- end --><div class="self-end basis-1/7"><div class="delp form-input bg-red-500/40 hover:bg-red-500 cursor-pointer"><span class="menu-icon"><i class="mdi mdi-close"></i></span></div></div></div>';
                //     $(this).parents(".socialMediaFildSetParrent").append(html);
                // });


                // $("div.delp").click(function (e) {
                //     // e.preventDefault();
                //     console.log('clicked');
                // });


            });

            // Remove my parent
            // $(".delmyparent").click(function(e) {
                // e.preventDefault();
                // console.log('close');
                // alert('something');

                // $(this).parents(".fildset").remove();
            // });
        </script>
    </x-slot>
</x-app-layout>
