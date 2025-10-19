<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Create Project</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        <!-- quill css -->
        {{-- <link href="{{ asset('admindash/asset/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('admindash/asset/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css"> --}}
        <!-- Include stylesheet -->
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">

                <form action="{{ route('projects.store') }}" method="post" enctype="multipart/form-data">
                    <div class="grid lg:grid-cols-3 gap-5">
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
                            <label for="location" class="block mb-2">Location</label>
                            <input type="text" class="form-input" id="location" name="location">
                        </div> <!-- end -->

                        <div>
                            <label for="keywords" class="block mb-2">Keywords</label>
                            <input type="text" class="form-input" id="keywords" name="keywords" required="">
                        </div> <!-- end -->

                        <div>
                            <label for="skill" class="block mb-2">Skills</label>
                            <input type="text" class="form-input" id="skill" name="skill" required="">
                        </div> <!-- end -->

                        <div>
                            <label for="salary" class="block mb-2">Salary</label>
                            <input type="text" class="form-input" id="salary" name="salary" required="">
                        </div> <!-- end -->


                        <div>
                            <label class="block text-gray-600 mb-2" for="overvieew">Overview</label>
                            <textarea class="form-input snow-editor" id="overview" rows="5" name="overvieew"></textarea>
                            {{-- <div id="overvieew"></div> --}}
                        </div> <!-- end -->


                        <div>
                            <label class="block text-gray-600 mb-2" for="qualification">Qualification</label>
                            <textarea class="form-input" id="qualification" rows="15" name="qualification"></textarea>
                        </div> <!-- end -->


                        <div>
                            <label class="block text-gray-600 mb-2" for="resposibility">Responsibility</label>
                            <textarea class="form-input" id="resposibility" rows="10" name="resposibility"></textarea>
                        </div> <!-- end -->


                        <div>
                            <label class="block text-gray-600 mb-2" for="benifit">Benifits</label>
                            <textarea class="form-input" id="benifit" rows="10" name="benifit"></textarea>
                        </div> <!-- end -->

                        <div class="mt-5">
                            <h6 class="text-sm mb-2">Job Type</h6>
                            <div class="flex flex-wrap gap-5">
                                <div class="flex items-center">
                                    <input type="radio" class="form-radio text-primary" name="type" value="1"
                                        id="fulltime" checked="">
                                    <label class="ms-1.5" for="fulltime">Fulltime</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" class="form-radio text-primary" name="type" value="2"
                                        id="parttime">
                                    <label class="ms-1.5" for="parttime">Parttime</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" class="form-radio text-primary" name="type"
                                        value="3" id="freelance">
                                    <label class="ms-1.5" for="freelance">Freelance</label>
                                </div>
                            </div>
                        </div> <!-- end -->


                        <div class="mt-5">
                            <h6 class="text-sm mb-2">Remote ?</h6>
                            <div class="flex flex-wrap gap-5">
                                <div class="flex items-center">
                                    <input type="radio" class="form-radio text-primary" name="remote"
                                        value="1" id="yes" checked="">
                                    <label class="ms-1.5" for="yes">Yes</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" class="form-radio text-primary" name="remote"
                                        value="2" id="no">
                                    <label class="ms-1.5" for="parttime">No</label>
                                </div>
                            </div>
                        </div> <!-- end -->




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
        <!-- quill js -->
        {{-- <script src="{{ asset('admindash/asset/libs/quill/quill.min.js') }}"></script> --}}
        <!-- Include the Quill library -->
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script>
            $(document).ready(function() {
                $("form #name").on('blur', () => {
                    const slug = slugify($("form #name").val());
                    $("form #slug").val(slug);
                });
            });

            var quill = new Quill('#overview', {
                theme: 'snow'
            });

        </script>
    </x-slot>
</x-app-layout>
