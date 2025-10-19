<x-guest-layout>


    {{-- Title --}}
    <x-slot name="title">Ex-President</x-slot>

    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable CSS --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    </x-slot>

    <main>
        {{-- Ex-President --}}
        <section class="" id="">
            <div class="bg-gradient-to-r from-violet-400 to-purple-300 py-8">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl font-bold text-center text-gray-800">Ex-President</h1>
                </div>
            </div>
            <div class="container mx-auto flex gap-4 px-4 py-6">
                <div class="flex-grow">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                        @forelse ($advisories as $advisory)
                            {{-- Member --}}
                            <div class="card p-6 shadow-md flex gap-4 justify-start items-center rounded-lg bg-white transform transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                                {{-- image --}}
                                <div class="w-20 h-20 rounded-full bg-cover bg-no-repeat" style="background-image: url({{ asset($advisory->photo) }})"></div>
                                <div>
                                    {{-- name --}}
                                    <h3 class="font-bold text-lg text-gray-900">{{ $advisory->name }}</h3>
                                    {{-- designation --}}
                                    <p class="text-gray-600">{{ $advisory->designation }}</p>
                                </div>
                            </div>
                        @empty
                            {{-- No members found --}}
                            <div class="text-center col-span-2 sm:col-span-3">
                                <p class="text-gray-600">No Ex-President found.</p>
                            </div>

                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-guest-layout>
