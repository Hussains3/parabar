<x-guest-layout>
    <main>
        <section>
            <div class="bg-gradient-to-r from-violet-400 to-purple-300 py-8">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl font-bold text-center text-gray-800">Notice Details</h1>
                </div>
            </div>
            <div class="max-w-7xl mx-auto py-10">

                <!-- Notices List -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
                    <div class="flex justify-between items-center">

                        <h2 class="mb-4">{{$notice->title}}</h2>
                        <!-- Download Button -->
                        <a href="{{ $notice->file_link }}" download class="text-green-500 hover:text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>

                    <div class="flex justify-center">

                        <iframe src="{{ $notice->file_link }}" class="w-[720px] h-[600px] aspect-auto"></iframe>
                    </div>
                </div>


            </div>
        </section>
    </main>

</x-guest-layout>
