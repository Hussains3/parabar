<!-- Navigation Bar -->
<nav class="bg-white shadow-md">

    <!-- Desktop Menu -->
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="/" class="py-4">
                <div class="flex gap-2 items-center">
                    <img src="{{asset('bcnf.png')}}" alt="" srcset="" class="h-[50px]">
                    <p class="text:nblue text-2xl font-bold leading-none text-left">Benapole Customs<br/>C&F Agents Association</p>
                </div>
            </a>

            <!-- Menu Items (Desktop) -->
            <div class="hidden md:flex items-center">
                <a href="/" class="text-gray-800 hover:text-blue-500 px-3 py-2">Home</a>

                <!-- Dropdown Container -->
                <div class="relative">
                    <button id="desktop-dropdown-button" data-target="desktop" class="desktop-dropdown-button text-gray-800 hover:text-blue-500 px-3 py-2 flex items-center">ITC Reports
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="desktop-dropdown-menu" class="desktop-dropdown-menu absolute hidden bg-white shadow-md rounded-lg mt-2 py-2 w-48 z-10">
                        <a href="{{ route('itc-reports.monthly') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">Monthly</a>
                        <a href="{{ route('itc-reports.yearly') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">Yearly</a>
                        <a href="{{route('itc-reports.index')}}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">All</a>
                    </div>
                </div>

                <a class="md:p-4 py-2 block hover:text-bb" href="{{route('notices.index')}}">Notices</a>
                <a href="{{route('contact')}}" class="text-gray-800 hover:text-blue-500 px-3 py-2">Contact</a>

                <!-- Member Dropdown Container -->
                <div class="relative">
                    <button id="desktop-member-dropdown-button" data-target="desktop-member" class="desktop-member-dropdown-button text-gray-800 hover:text-blue-500 px-3 py-2 flex items-center">Members
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="desktop-member-dropdown-menu" class="desktop-member-dropdown-menu absolute hidden bg-white shadow-md rounded-lg mt-2 py-2 w-48 z-10">
                        <a href="{{ route('general-member') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">General Members</a>
                        <a href="{{ route('home').'/#ec-committee' }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">EC Committee</a>
                        <a href="{{ route('expresidents') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">Ex-Presidents</a>
                        <a href="{{ route('exgsecratary') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">Ex-General Secretaries</a>
                        <a href="{{ route('electioncommittee') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">Election Committee</a>
                        <a href="{{ route('internalaidcommittee') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">Internal Audit Committee</a>
                    </div>
                </div>
                @guest
                <a class="md:p-4 py-2 block hover:text-bb text-purple-500" href="{{route('login')}}">Login</a>
                @endguest

                @auth()

                <div class="relative">
                    <button class="agent-dropdown-button text-gray-800 hover:text-blue-500 px-3 py-2 flex items-center">
                        Others
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="agent-dropdown-menu absolute hidden bg-white shadow-md rounded-lg mt-2 py-2 w-48 z-10">
                        @role('agent')
                        <a href="{{ route('myagency') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">Agency</a>
                        @endrole
                        @unlessrole('agent')
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">Chada</a>
                        @endunlessrole

                        @role('admin')
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">Profile</a>
                        @endrole
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-gray-800 hover:bg-blue-50 w-full">Logout</button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden print:hidden">
                <button id="mobile-menu-button" class="text-gray-800 hover:text-blue-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <div class="container mx-auto px-4 py-2">
            <a href="/" class="block py-2 text-gray-800 hover:text-blue-500">Home</a>

            <!-- Mobile ITC Reports Dropdown -->
            <div class="relative">
                <button class="mobile-dropdown-button w-full text-left py-2 text-gray-800 hover:text-blue-500 flex items-center justify-between" data-target="mobile">
                    ITC Reports
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="mobile-dropdown-menu hidden pl-4">
                    <a href="{{ route('itc-reports.monthly') }}" class="block py-2 text-gray-800 hover:text-blue-500">Monthly</a>
                    <a href="{{ route('itc-reports.yearly') }}" class="block py-2 text-gray-800 hover:text-blue-500">Yearly</a>
                    <a href="{{route('itc-reports.index')}}" class="block py-2 text-gray-800 hover:text-blue-500">All</a>
                </div>
            </div>

            <a href="{{route('notices.index')}}" class="block py-2 text-gray-800 hover:text-blue-500">Notices</a>
            <a href="{{route('contact')}}" class="block py-2 text-gray-800 hover:text-blue-500">Contact</a>

            <!-- Mobile Members Dropdown -->
            <div class="relative">
                <button class="mobile-member-dropdown-button w-full text-left py-2 text-gray-800 hover:text-blue-500 flex items-center justify-between" data-target="mobile-member">
                    Members
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="mobile-member-dropdown-menu hidden pl-4">
                    <a href="{{ route('general-member') }}" class="block py-2 text-gray-800 hover:text-blue-500">General Members</a>
                    <a href="#" class="block py-2 text-gray-800 hover:text-blue-500">EC Committee</a>
                    <a href="#" class="block py-2 text-gray-800 hover:text-blue-500">Ex-Presidents</a>
                    <a href="#" class="block py-2 text-gray-800 hover:text-blue-500">Ex-General Secretaries</a>
                </div>
            </div>

            @guest
                <a href="{{route('login')}}" class="block py-2 text-purple-500 hover:text-purple-700">Login</a>
            @endguest

            @auth
                @role('admin|receiver|extra|operator|deliver|developer|accountant|manager')
                    <a href="{{route('dashboard')}}" class="block py-2 text-purple-500 hover:text-purple-700">Chada</a>
                @endrole

                <!-- Mobile Others Dropdown -->
                <div class="relative">
                    <button class="mobile-agent-dropdown-button w-full text-left py-2 text-gray-800 hover:text-blue-500 flex items-center justify-between">
                        Others
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="mobile-agent-dropdown-menu hidden pl-4">
                        @role('agent')
                            <a href="{{ route('myagency') }}" class="block py-2 text-gray-800 hover:text-blue-500">Agency</a>
                        @endrole
                        @unlessrole('agent')
                            <a href="{{ route('dashboard') }}" class="block py-2 text-gray-800 hover:text-blue-500">Chada</a>
                        @endunlessrole
                        <a href="{{ route('profile.edit') }}" class="block py-2 text-gray-800 hover:text-blue-500">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 text-gray-800 hover:text-blue-500">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
