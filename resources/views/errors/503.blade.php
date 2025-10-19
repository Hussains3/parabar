<x-guest-layout>
    {{-- Title --}}
    <x-slot name="title">Service Unavailable</x-slot>

    <main class="min-h-screen flex flex-col justify-center items-center px-4">
        <div class="max-w-md w-full text-center">
            {{-- Error Icon --}}
            <div class="mb-8">
                <i class="mdi mdi-server-off text-8xl text-gray-400"></i>
            </div>

            {{-- Error Code --}}
            <p class="text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-violet-400 to-purple-300 mb-4">
                503
            </p>

            {{-- Error Message --}}
            <h1 class="text-4xl font-bold text-gray-800 mb-4">
                Service Unavailable
            </h1>
            
            <p class="text-gray-600 mb-8">
                Sorry, we are doing some maintenance. Please check back soon.
            </p>

            {{-- Back to Home Button --}}
            <div class="flex justify-center gap-4">
                <a href="{{ url()->previous() }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-md shadow-sm hover:bg-gray-50 transition-all duration-200 flex items-center">
                    <i class="mdi mdi-arrow-left mr-2"></i>
                    Go Back
                </a>
                <a href="{{ url('/') }}" class="px-6 py-3 bg-gradient-to-r from-violet-400 to-purple-300 text-white font-semibold rounded-md shadow-md hover:shadow-lg transition-all duration-200 flex items-center">
                    <i class="mdi mdi-home mr-2"></i>
                    Home
                </a>
            </div>

            {{-- Additional Info --}}
            <p class="mt-8 text-sm text-gray-500">
                If you continue to experience issues, please contact our support team.
            </p>
        </div>
    </main>
</x-guest-layout>
