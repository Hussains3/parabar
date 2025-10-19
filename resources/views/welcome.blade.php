<x-guest-layout>


    {{-- Title --}}
    <x-slot name="title">Home</x-slot>

    <main>
        {{-- check marquees value --}}
        @if ($marquees->count() > 0)
        <div class="overflow-hidden bg-gradient-to-r from-violet-400 to-purple-300 py-2">
            <div id="marquee" class="whitespace-nowrap">
                @foreach ($marquees as $marquee)
                    @if ($marquee->active)
                        <span class="font-bold text-white">{{ $marquee->content }} 🌟 </span>
                    @endif

                @endforeach
            </div>
        </div>

        @endif
        <section>
            <div class="mx-auto container px-4 py-4 flex flex-col sm:flex-row gap-4">
                <div class="flex-grow">
                    {{-- Hero section --}}
                    <!-- Carousel Container -->
                    <div class="carousel-container rounded-md">

                        {{-- Slide one --}}
                        <div class="carousel-slide active">
                            <img src="{{asset('images/herobg1.jpg')}}" alt="Slide 1" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center text-center px-6">

                            </div>
                        </div>
                        {{-- Slide one --}}
                        <div class="carousel-slide">
                            <img src="{{asset('images/herobg2.jpg')}}" alt="Slide 2" class="w-full h-full object-cover">
                        </div>
                        {{-- Slide one --}}
                        <div class="carousel-slide">
                            <img src="{{asset('images/herobg3.jpeg')}}" alt="Slide 3" class="w-full h-full object-cover">
                        </div>

                        <!-- Carousel Controls -->
                        <div class="carousel-btn prev-btn">❮</div>
                        <div class="carousel-btn next-btn">❯</div>

                        <div class="carousel-bullets">
                            <div class="bullet active" data-slide="0"></div>
                            <div class="bullet" data-slide="1"></div>
                            <div class="bullet" data-slide="2"></div>
                        </div>
                    </div>
                </div>
                @if ($president || $generalSecretary)
                <div class="card px-2 w-60 flex justify-between flex-col basis-1/5">

                    @if ($president)
                    {{-- President --}}
                    <div   class="block text-center px-4 py-2 bg-white shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg" href="">
                        <img src="{{ asset($president->photo) }}" alt="President" class="full h-auto">
                        <div class="text-center text-lg font-bold text-gray-800 py-4">
                            President
                        </div>
                    </div>

                    @endif

                    @if ($generalSecretary)
                    {{-- General Secretary --}}
                    <div   class="block text-center px-4 py-2 bg-white shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all w-full font-bold text-lg" href="">
                        <img src="{{ asset($generalSecretary->photo) }}" alt="General Secretary" class="full h-auto">
                        <div class="text-center text-lg font-bold text-gray-800 py-4">
                            General Secretary
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </section>

        <section class=" pb-10 pt-16">
            <div class="container mx-auto flex gap-4 px-4">
                <div class="basis-4/5">

                    {{-- Gallery section --}}
                    <div class="flex-grow mb-8">
                        <h2 class="text-3xl font-bold text-left mb-8 text-gray-800">Photo Of Recent Activities</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @forelse($galleries as $gallery)
                                <div class="gallery-item group relative overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl"
                                    style="min-height: 300px;">
                                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                                        style="background-image: url('{{ asset($gallery->image) }}')">
                                    </div>
                                    <div class="absolute inset-0 bg-black bg-opacity-0 transition-all duration-300 group-hover:bg-opacity-50">
                                    </div>
                                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white translate-y-full transition-transform duration-300 group-hover:translate-y-0">
                                        <h3 class="text-lg font-semibold">{{ $gallery->title }}</h3>
                                        @if($gallery->description)
                                            <p class="mt-2 text-sm opacity-90">{{ $gallery->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-12 bg-gray-50 rounded-lg">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2 text-gray-500">No gallery images available</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Notice Board --}}
                    {{-- <div class="flex-grow hidden">

                        <h2 class="text-3xl font-bold text-left mb-8 text-gray-800">Notice Board</h2>

                        <div class="flex flex-col gap-4">
                            @forelse ($notices as $notice)
                                <a href="{{ route('notices.show', $notice->id) }}" class="card px-6 py-4 shadow-md flex gap-4 justify-start items-center rounded-lg bg-white transform transition-transform duration-300 hover:scale-105 hover:shadow-lg"><i class="mdi mdi-arrow-right-bold-circle text-lg text-green-500"></i> {{ $notice->title }}
                                </a>
                            @empty
                                <p>No notices available.</p>
                            @endforelse
                            <div class="flex items-center justify-center mt-4">
                                <a class="text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-110 duration-150 transition-all  font-bold text-lg text-white" href="{{route('notices.index')}}">See All</a>
                            </div>
                        </div>
                    </div> --}}

                    <div class="flex flex-col gap-4">
                        @if ($president)
                        {{-- Message From the President and General Secretary --}}
                            {{-- Mesages From the President --}}
                            <div class="mt-12">
                                <h2 class="text-3xl font-bold text-left mb-8 text-gray-800">Mesages From the President</h2>


                                <div class="flex justify-between items-start gap-6">

                                    <div class="basis-1/4 flex flex-col items-center">
                                        {{-- image --}}
                                        <img src="{{ asset($president->photo) }}" alt="President">
                                    </div>

                                    <div class="text-gray-600 basis-3/4 flex-col justify-between h-full">
                                        <p class="text-justify">{{ $president->message }}</p>
                                        <div>
                                            <h3 class="font-bold text-lg text-gray-900">{{ $president->name }}</h3>
                                            <p class="text-gray-600">{{ $president->designation }}</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- message --}}

                            </div>
                        @endif

                        @if ($generalSecretary)
                            {{-- Mesages From General Secretary --}}
                            <div class="mt-12">
                                <h2 class="text-3xl font-bold text-left mb-8 text-gray-800">Mesages From General Secretary</h2>


                                <div class="flex justify-between items-start gap-6">

                                    <div class="basis-1/4 flex flex-col items-center">
                                        {{-- image --}}
                                        <img src="{{ asset($generalSecretary->photo) }}" alt="President">
                                    </div>

                                    <div class="text-gray-600 basis-3/4 flex-col justify-between h-full">
                                        <p class="text-justify">{{ $generalSecretary->message }}</p>
                                        <div>
                                            <h3 class="font-bold text-lg text-gray-900">{{ $generalSecretary->name }}</h3>
                                            <p class="text-gray-600">{{ $generalSecretary->designation }}</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- message --}}

                            </div>
                        @endif
                    </div>
                </div>
                {{-- Aside Menu --}}
                <div class="card px-2 w-60 flex gap-2 flex-col flex-grow">
                    <h4 class="text-lg font-bold">NBR Information</h4>

                    <a class="hover:scale-105 duration-150 transition-all w-full font-bold text-md text-violet-400" href="https://customs.gov.bd/files/All-SRO-2024-2025-Tracing-29-05-2024-SROs.pdf" target="_blank">SROs</a>
                    <a class="hover:scale-105 duration-150 transition-all w-full font-bold text-md text-violet-400" href="https://customs.gov.bd/files/BCT-2024-2025Final.pdf" target="_blank">First Schedule</a>
                    <a class="hover:scale-105 duration-150 transition-all w-full font-bold text-md text-violet-400" href="https://customs.gov.bd/files/Tariff-2025-2026(02-06-2025).pdf" target="_blank">Custom Tariff</a>
                    <a class="hover:scale-105 duration-150 transition-all w-full font-bold text-md text-violet-400" href="https://customs.gov.bd/files/Finance-BILL-2024-2025.pdf" target="_blank">Fainance Bill</a>
                    <a class="hover:scale-105 duration-150 transition-all w-full font-bold text-md text-violet-400" href="https://customs.gov.bd/files/Budget_Speech_2024_2025_B.pdf" target="_blank">Budget at a glance</a>
                    <a class="hover:scale-105 duration-150 transition-all w-full font-bold text-md text-violet-400" href="https://customs.gov.bd/portal/services/tariff/index.jsf" target="_blank">Customs related Instruction</a>
                    <h4 class="text-lg font-bold">Customs Information</h4>
                    <a class="hover:scale-105 duration-150 transition-all w-full font-bold text-md text-violet-400" href="{{route('documentation')}}" target="_blank">Documentation</a>
                    <a class="hover:scale-105 duration-150 transition-all w-full font-bold text-md text-violet-400" href="https://benapole.blpa.gov.bd/" target="_blank">Port Tariff</a>

                    <!-- Currency Converter Script - EXCHANGERATEWIDGET.COM -->
                    <div class="border border-violet-400 rounded-md overflow-hidden mt-6">
                        <div class="bg-gradient-to-r from-violet-400 to-purple-300 py-4 text-center font-bold" style="">
                            <a href="https://www.exchangeratewidget.com/" style="color:#FFFFFF;text-decoration:none;" rel="nofollow">Currency Converter</a>
                        </div>
                        <script type="text/javascript" src="//www.exchangeratewidget.com/converter.php?l=en&f=USD&t=BDT&a=1&d=F0F0F0&n=FFFFFF&o=000000&v=1"></script>
                    </div>
                    <!-- End of Currency Converter Script -->


                    <div class="border border-violet-400 rounded-md overflow-hidden">
                        <a class="weatherwidget-io" href="https://forecast7.com/en/23d1889d18/jessore/" data-label_1="JESSORE" data-label_2="WEATHER" data-theme="sky" >JESSORE WEATHER</a>
                        <script>
                        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
                        </script>
                    </div>

                    <img src="{{asset('numbers.jpg')}}" alt="Important Numbers" srcset="">
                </div>
            </div>
        </section>


        {{-- EC Committee --}}
        <section class=" py-10" id="ec-committee">
            <div class="container mx-auto flex gap-4 px-4">
                <div class="flex-grow">

                    <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">EC Committee</h2>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 mt-5">
                        @forelse ($advisories as $advisory)
                            {{-- Member --}}
                            <div class="card p-6 shadow-md flex gap-4 justify-start items-center rounded-lg bg-white transform transition-transform duration-300 hover:scale-105 hover:shadow-lg group relative overflow-hidden">
                                {{-- image --}}
                                <div class="w-20 h-20 rounded-full bg-cover bg-no-repeat" style="background-image: url({{ asset($advisory->photo) }})"></div>
                                <div>
                                    {{-- name --}}
                                    <h3 class="font-bold text-lg text-gray-900">{{ $advisory->name }}</h3>
                                    {{-- designation --}}
                                    <p class="text-gray-600">{{ $advisory->designation }}</p>
                                </div>
                                {{-- Tooltip on hover --}}

                                <div class="absolute inset-0 bg-gray-300 transition-all duration-300 hidden group-hover:block p-6">
                                    {{-- phone --}}
                                    <p class="text-gray-900 font-bold ">{{ $advisory->officename ?? '' }}</p>
                                    <p class="text-gray-900 ">Phone: {{ $advisory->phone ??'' }}, Email: {{ $advisory->email ?? '' }}</p>
                                    {{-- address --}}
                                    <p class="text-gray-900 ">Address: {{ $advisory->officeaddress ??'' }}</p>
                                </div>
                            </div>
                        @empty
                            {{-- No members found --}}
                            <div class="text-center col-span-2 sm:col-span-3">
                                <p class="text-gray-600">No advisory committee members found.</p>
                            </div>

                        @endforelse
                    </div>
                </div>
            </div>
        </section>


        {{-- Make a two colum add showing section --}}
        <section>
            <div class="container mx-auto flex gap-4 px-4 pb-8">
                <div class="">
                    <h2 class="text-3xl font-bold text-center mb-8 text-gray-800 hidden">Advertisement</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-5">
                        <a class="card p-6 shadow-md flex gap-4 justify-start items-center rounded-lg bg-white transform transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">Advertisement Title</h3>
                                <p class="text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia, molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium optio, eaque rerum!</p>
                            </div>
                        </a>
                        <a class="card p-6 shadow-md flex gap-4 justify-start items-center rounded-lg bg-white transform transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">Advertisement Title</h3>
                                <p class="text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia, molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium optio, eaque rerum!</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <x-slot name="script">

        {{-- Scripts --}}

        <script>

        </script>
    </x-slot>


</x-guest-layout>
