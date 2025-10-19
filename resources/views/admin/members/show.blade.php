<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{$member->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">
        <div class="card max-w-7xl">
            <div class="p-6 flex gap-6">
                <div class="">
                    <img src="{{asset($member->photo)}}" alt="" srcset="" class="max-w-lg h-auto">
                </div>
                <div class="f flex-grow">
                    <h3 class="font-mont font-bold text-base sm:text-2xl">{{$member->name}}</h3>
                    <p class="font-dm font-normal text-xs sm:text-sm tracking-[.3em] uppercase mb-2">{{$member->designation}}</p>

                    {{-- Skills --}}
                    <div class="mt-12">
                        <h2 class="text-xl font-semibold mb-4">Skills</h2>
                        @forelse ($member->skills as $skill)
                            @if ($skill['name'] != NULL)

                            <div class="flex flex-flow py-2 px-4 border mb-2 items-center gap-5">
                                <p class="uppercase basis-1/6">{{$skill['name']}}</p>
                                <div class="flex w-full h-3 bg-gray-200  overflow-hidden dark:bg-gray-700">
                                    <div class="flex flex-col justify-center overflow-hidden bg-seagreen" role="progressbar" style="width: {{$skill['exp']}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            @endif

                        @empty
                            <p>OPS!</p>
                        @endforelse
                    </div>


                    {{-- Social medias --}}
                    <div class="mt-4">
                        <h2 class="text-xl font-semibold mb-4">Social Meadias</h2>
                        @forelse ($member->soocial_medias as $sm)
                            @if ($sm['name'] != NULL)

                            <div class="flex flex-flow py-2 px-4 border mb-2 items-center gap-5">
                                <p class="uppercase basis-1/6">{{$sm['name']}}</p>
                                <div class="flex w-full overflow-hidden ">
                                    <p>{{$sm['link']}}</p>
                                </div>
                            </div>
                            @endif

                        @empty
                            <p>OPS!</p>
                        @endforelse
                    </div>

                    <a href="{{route('members.edit',$member->slug)}}">

                        <button class="font-mont mt-8 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['EDIT'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Edit</button>
                    </a>

                </div>



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



