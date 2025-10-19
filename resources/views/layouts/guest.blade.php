<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Benapole C&F Asso.</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css">
        <!-- Icons css -->
        <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css">
        {{-- Header style --}}
        @if (isset($headerstyle))
            {{ $headerstyle }}
        @endif
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Menu -->
        <header >
            @include('layouts.guestheader')
        </header>
        <!-- Sidenav Menu End  -->

        {{-- dark:bg-[radial-gradient(#f3f4f6_1px,transparent_1px)] --}}
        <div class="min-h-screen">
            {{ $slot }}
        </div>
        @include('layouts.guestfooter')

        <!-- Plugin Js -->
        <script src="{{asset('libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('js/custom.js')}}"></script>
        @if (isset($script))
        {{ $script }}
        @endif
    </body>
</html>

{{-- .bg-\[radial-gradient\(\#14353A_1px\,transparent_1px\)\] {
	background-image: radial-gradient(#14353A 1px,transparent 1px);
} --}}
