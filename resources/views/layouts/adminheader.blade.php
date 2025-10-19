<header class="app-header">
    <div class="flex items-center px-6 gap-3">

        <!-- Sidenav Menu Toggle Button -->
        <button id="button-toggle-menu" class="nav-link p-2">
            <span class="sr-only">Menu Toggle Button</span>
            <span class="flex items-center justify-center h-6 w-6">
                <i data-lucide="menu" class="w-6 h-6 text-xl"></i>
            </span>
        </button>

        <!-- Page Title -->
        <div class="me-auto">
            <div class="md:flex hidden">
                <h4 class="page-title text-lg capitalize">@if (isset($title)) {{ $title }} @endif</h4>
            </div>
        </div>

        {{-- <div class="md:flex hidden items-center relative">
            <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                <i class="mdi mdi-magnify text-base opacity-60 -z-10"></i>
            </div>
            <input type="search" class="form-input pe-8 ps-4 rounded-full bg-gray-500/10 border-transparent focus:border-transparent placeholder:opacity-60" placeholder="Search...">
        </div> --}}

        <!-- Light/Dark Toggle Button -->
        <div class="flex">
            <button id="light-dark-mode" type="button" class="nav-link p-2">
                <span class="sr-only">Light/Dark Mode</span>
                <span class="flex items-center justify-center h-6 w-6">
                    <i data-lucide="moon" class="block dark:hidden"></i>
                    <i data-lucide="sun" class="hidden dark:block"></i>
                </span>
            </button>
        </div>

        <!-- Profile Dropdown Button -->
        <div class="relative">
            <button class="nav-link flex items-center profile-dropdown-button" data-target="profile">
                <span class="text-xl mx-2 font-bold">{{Auth::user()->name}}</span>
                <i class="mdi mdi-chevron-down"></i>
            </button>
            <div class="profile-dropdown-menu hidden absolute right-0 w-44 z-50 transition-all duration-300 bg-white shadow-lg border rounded py-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                <a class="flex items-center py-2 px-5 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="{{route('profile.edit')}}">
                    <i data-lucide="user" class="w-4 h-4 me-2"></i>
                    <span>My Account</span>
                </a>
                <a class="flex items-center py-2 px-5 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="apps-kanban.html">
                    <i data-lucide="settings" class="w-4 h-4 me-2"></i>
                    <span>Settings</span>
                </a>
                <hr class="my-2 -mx-2 border-gray-200 dark:border-gray-700">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="w-full flex items-center py-2 px-5 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                        <i data-lucide="log-out" class="w-4 h-4 me-2"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>
