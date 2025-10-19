<x-guest-layout>


    {{-- Title --}}
    <x-slot name="title">Gallery</x-slot>

    <main>
        <section>
            <div class="bg-gradient-to-r from-violet-400 to-purple-300 py-8">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl font-bold text-center text-gray-800">Photo Album</h1>
                </div>
            </div>
        </section>
        {{-- Contact us form --}}
        <section class="bg-gray-100 py-10">
            <div class="max-w-7xl mx-auto">
                {{-- Gallery section --}}
                <div class="flex-grow mb-8">
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
            </div>
        </section>

    </main>

    <x-slot name="script">

    </x-slot>


</x-guest-layout>
