<x-admin-layout>
    {{-- Title --}}
    <x-slot name="title">Add Member to {{ $project->name }} Projects</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6 flex flex-flow gap-5">
                <div class="basis-2/5">
                    @if ($project->cover_home)
                        <div class="">
                            <h1 class="text-2xl mb-4 font-bold">{{ $project->name }}</h1>
                            <input type="hidden" value="{{ $project->id }}" id="projectid">
                            <img src="{{ asset($project->cover_home) }}" alt="" srcset="" class="w-full">
                        </div>
                    @endif
                </div>
                <div class="flex-grow">
                    <h2 class="text-2xl mb-4 font-bold">Project Members</h2>
                    <div class="relative w-full">
                        <form action="" id="membersearchform">
                            <input type="text" name="" id="membersearchinput" class="w-full form-input"
                                placeholder="Search member to add in this project">
                        </form>

                        <div class="bg-white/70 backdrop-blur-sm  shadow-md absolute top-full w-full" id="searchresult">
                            {{-- each result --}}

                        </div>
                    </div>


                    <div class="form">
                    </div>
                    <div class="mt-4" id="pmembershow">

                        @foreach ($project->members as $member)
                            <div class="eachProjectMember" id="epm{{ $member->id }}">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex gap-2 px-4 py-2 hover:bg-seagreen/10 flex-grow">
                                        <div class="p-1 w-12 aspect-square rounded-full bg-cover bg-center bg-no-repeat"
                                            style="background-image: url({{ asset($member->photo) }})"></div>
                                        <div class="">
                                            <h3 class="text-lg font-semibold">{{ $member->name }}</h3>
                                            <p>{{ $member->designation }}</p>
                                        </div>
                                    </div>
                                    <div class="flex h-8 w-8 justify-center items-center text-xl bg-seagreen/40 text-white hover:bg-seagreen ml-auto"
                                        onclick="deletethis({{ $member->id }})">
                                        <span class="mdi mdi-close"></span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>


            </div>
        </div> <!-- end card -->



    </div>


    <x-slot name="script">
        <script>
            $(document).ready(function() {
                

                let searchurl = 'projectmembers/search/';
                // Searching member
                $("form #membersearchinput").on('keyup', () => {
                    var query = $("#membersearchinput").val();
                    var srd = $("#searchresult");
                    if (query == '') {
                        srd.css('display', 'none');
                    } else {
                        srd.css('display', 'block');
                    }
                    $.ajax({
                        url: BASE_URL + searchurl + query,
                        dataType: 'json',
                        type: 'GET',
                        error: function() {
                            console.log(Error);
                        },
                        success: function(response) {

                            srd.html('');
                            srd.addClass('p-2');
                            response.data.forEach((item) => {
                                var appendble = `<div class="eachProjectMember ">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex gap-2 px-4 py-2 hover:bg-seagreen/10 flex-grow">
                                        <div class="p-1 w-12 aspect-square rounded-full bg-cover bg-center bg-no-repeat" style="background-image: url('${ BASE_URL+item.photo }')"></div>
                                        <div class="">
                                            <h3 class="text-lg font-semibold">${item.name}</h3>
                                            <p>${item.designation}</p>
                                        </div>
                                    </div>
                                    <div class="flex h-8 w-8 justify-center items-center text-xl bg-seagreen/40 text-white hover:bg-seagreen ml-auto" onclick="addtoproject(${item.id})">
                                        <span class="mdi mdi-plus"></span>
                                    </div>
                                </div>
                            </div>`;
                                srd.append(appendble);
                            })

                        },
                    });
                });


            });

            // Project ID
            var pid = $("#projectid").val();

            // Add member to project finction
            function addtoproject(memberid) {
                $.ajax({
                    url: BASE_URL + 'projectmembers/store',
                    dataType: 'json',
                    data: {
                        project_id: pid,
                        member_id: memberid,
                    },
                    type: 'POST',
                    success: function(response) {
                        let memshow = $("#pmembershow");
                        let srd = $("#searchresult");
                        if (response.error) {
                            $("#ajaxflash div p").text(response.error);
                            $("#ajaxflash").fadeIn().fadeOut(5000);
                            srd.html('').fadeOut(150);
                        } else {
                            $("#ajaxflash div p").text(response.success);
                            $("#ajaxflash").fadeIn().fadeOut(5000);
                            var appendble = `<div class="eachProjectMember " id="epm${response.data.id}">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex gap-2 px-4 py-2 hover:bg-seagreen/10 flex-grow">
                                            <div class="p-1 w-12 aspect-square rounded-full bg-cover bg-center bg-no-repeat" style="background-image: url('${ BASE_URL+response.data.photo }')"></div>
                                            <div class="">
                                                <h3 class="text-lg font-semibold">${response.data.name}</h3>
                                                <p>${response.data.designation}</p>
                                            </div>
                                        </div>
                                        <div class="flex h-8 w-8 justify-center items-center text-xl bg-seagreen/40 text-white hover:bg-seagreen ml-auto" onclick="deletethis(${response.data.id})">
                                            <span class="mdi mdi-close"></span>
                                        </div>
                                    </div>
                                </div>`;
                            memshow.append(appendble);
                            srd.html('').fadeOut(150);
                            $("form#membersearchform").trigger("reset");
                        }

                    },
                });
            }


            // Remove member from
            function deletethis(memberid) {

                let removeable = $("#epm"+memberid);

                $.ajax({
                    url: BASE_URL + 'projectmembers/delete/'+pid,
                    dataType: 'json',
                    data: {
                        project_id: pid,
                        member_id: memberid,
                    },
                    type: 'DELETE',
                    success: function(response) {
                        let memshow = $("#pmembershow");
                        let srd = $("#searchresult");
                        if (response.error) {
                            $("#ajaxflash div p").text(response.error);
                            $("#ajaxflash").fadeIn().fadeOut(5000);
                            srd.html('').fadeOut(150);
                        } else {

                            removeable.remove();
                            $("#ajaxflash div p").text(response.success);
                            $("#ajaxflash").fadeIn().fadeOut(5000);
                        }

                    },
                });
            }
        </script>



    </x-slot>
</x-admin-layout>
