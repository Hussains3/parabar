<x-guest-layout>


    {{-- Title --}}
    <x-slot name="title">Internal Audit Committee</x-slot>

    <main>
        {{-- Internal Audit Committee --}}
        <section class="" id="">
            <div class="bg-gradient-to-r from-violet-400 to-purple-300 py-8">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl font-bold text-center text-gray-800">Internal Audit Committee</h1>
                </div>
            </div>
            <div class="container mx-auto flex gap-4 px-4 py-6">
                <div class="flex-grow">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
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
                                <p class="text-gray-600">No Internal Audit Committee found.</p>
                            </div>

                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-guest-layout>
