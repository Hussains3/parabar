<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>@if (isset($title)) {{ $title }} @endif | Chada - Benapole C&F Asso.</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="Chada - A File management web application for benapole port c &f association." name="description">
        <meta content="shadapixel" name="author">

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

        <!-- App css -->
        <link href="{{asset('css/app.min.css')}}" rel="stylesheet" type="text/css">

        <!-- Icons css -->
        <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css">

        <!-- Toastr css -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

        <!-- SweetAlert2 -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Frost UI -->
        <script src="https://unpkg.com/@agencyhive/frost-ui@1.0.0/dist/frost.min.js"></script>

        {{-- Custom css --}}
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">

        {{-- Header style --}}
        @if (isset($headerstyle))
            {{ $headerstyle }}
        @endif

        <link rel="stylesheet" href="{{asset('css/datatable.css')}}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Theme Config Js -->
        <script src="{{asset('js/config.js')}}"></script>

        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            let BASE_URL = {!! json_encode(url('/')) !!} + "/";
        </script>


    </head>
    <body class="font-space">

        <div class="flex wrapper">

            <!-- Menu -->
            @include('layouts.adminmenu')
            <!-- Sidenav Menu End  -->


            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="page-content bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/background.jpg') }}');">

                <!-- Topbar Start -->
                @include('layouts.adminheader')
                <!-- Topbar End -->

                <main class="p-6 relative bg-gray-700 h-full backdrop-blur-xs bg-opacity-70">
                    {{-- for php flash --}}
                    <x-auth-session-status :status="Session::get('message')" id="notificationflush" onclick="hideflash()"></x-auth-session-status>
                    {{-- for ajax flash --}}
                    <div class="bg-seagreen rounded px-4 py-2 font-medium text-sm text-white absolute top-4 right-6 z-[11111] hover:bg-seagreen hidden" id="ajaxflash">
                        <div class="flex gap-4">
                            <p></p>
                            <span class="menu-icon"><i class="mdi mdi-close"></i></span>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-600 backdrop-blur-sm px-4 py-2 font-medium text-sm text-white absolute top-4 right-6 z-[11111] hover:bg-seagreen" id="sessionerror">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-white">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- Page content --}}
                    {{ $slot }}
                </main>

                <!-- Footer Start -->
                @include('layouts.adminfooter')
                <!-- Footer End -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>

        <!-- Plugin Js -->
        <script src="{{asset('libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('libs/lucide/umd/lucide.min.js')}}"></script>

        <!-- App Js -->
        <script src="{{asset('js/app.js')}}"></script>

        <!-- knob plugin -->
        <script src="{{asset('libs/jquery-knob/jquery.knob.min.js')}}"></script>

        <!--Morris Chart-->
        <script src="{{asset('libs/morris.js06/morris.min.js')}}"></script>
        <script src="{{asset('libs/raphael/raphael.min.js')}}"></script>
        {{-- Sweet alert --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- Custom js --}}
        <script src="{{asset('js/custom.js')}}"></script>



        @if (isset($script))
        {{ $script }}
        @endif



    </body>
</html>
