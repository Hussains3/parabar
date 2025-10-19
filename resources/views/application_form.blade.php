<x-guest-layout>


    {{-- Title --}}
    <x-slot name="title">Application Form</x-slot>

    <main>
        {{-- Application Form --}}
        <section class="" id="">
            <div class="bg-gradient-to-r from-violet-400 to-purple-300 py-8">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl font-bold text-center text-gray-800">Application Form</h1>
                </div>
            </div>
            <div class="bg-white py-8">
                <div class="max-w-6xl mx-auto px-4">
                    <div class="">
                        {{-- Individual links end --}}
                        @if(count($files) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($files as $file)
                                    <div class="bg-white rounded-lg shadow-md p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-lg font-semibold">{{ $file['name'] }}</h3>
                                            <span class="text-sm text-gray-500 uppercase">{{ $file['extension'] }}</span>
                                        </div>
                                        <div class="text-sm text-gray-600 mb-4">
                                            <p>Size: {{ number_format($file['size'] / 1024, 2) }} KB</p>
                                            <p>Last Modified: {{ date('Y-m-d H:i', $file['last_modified']) }}</p>
                                        </div>
                                        <a href="{{ $file['path'] }}"
                                        class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors"
                                        target="_blank">
                                            Download
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-gray-600">
                                No sample applications available.
                            </div>
                        @endif


                    </div>
                </div>
            </div>

        </section>

    </main>

</x-guest-layout>
