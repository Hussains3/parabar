<div class="app-menu">

    <!-- Sidenav Brand Logo -->
    <a href="{{route('dashboard')}}" class="logo-box">
        <!-- Light Brand Logo -->
        <div class="logo-light">
            <div class="flex gap-2 items-center logo-lg">
                <img src="{{asset('bcnf.png')}}" alt="" srcset="" class="h-[50px] ">
                <p class="dark:text-white text-2xl uppercase font-bold leading-none">Parabar<br/> Shipping</p>
            </div>
            <div class="flex gap-2 items-center logo-sm">
                <img src="{{asset('bcnf.png')}}" alt="" srcset="" class="h-[50px] ">
            </div>
        </div>

        <!-- Dark Brand Logo -->
        <div class="logo-dark">
            <div class="flex gap-2 items-center logo-lg">
                <img src="{{asset('bcnf.png')}}" alt="" srcset="" class="h-[50px] ">
                <p class="dark:text-nblue text-2xl uppercase font-bold leading-none">Parabar<br/> Shipping</p>
            </div>
            <div class="flex gap-2 items-center logo-sm">
                <img src="{{asset('bcnf.png')}}" alt="" srcset="" class="h-[50px] ">
            </div>
        </div>
    </a>



    <!--- Menu -->
    <div data-simplebar="">
        <ul class="menu" data-fc-type="accordion">

            <li class="menu-item">
                <a href="https://parabarshipping.org" class="menu-link" target="_blank">
                    <span class="menu-icon"><i class="mdi mdi-eye"></i></span>
                    <span class="menu-text"> Site </span>
                </a>
            </li>




            {{-- Dashboard --}}
            {{-- Importer/Exporter --}}
            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-account-switch-outline"></i></span>
                    <span class="menu-text"> Importer/Exporter </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{route('ie_datas.index')}}" class="menu-link">
                            <span class="menu-text">All</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('ie_datas.create')}}" class="menu-link">
                            <span class="menu-text">Carete</span>
                        </a>
                    </li>
                </ul>
            </li>



            @role('admin|extra|operator')
            {{-- File Datas --}}
            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-file-document-outline"></i></span>
                    <span class="menu-text"> File Datas </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    @role('extra')
                    <li class="menu-item">
                        <a href="{{route('file_datas.create')}}" class="menu-link">
                            <span class="menu-text">Receive Out</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('file_datas.createin')}}" class="menu-link">
                            <span class="menu-text">Receive In</span>
                        </a>
                    </li>
                    @endrole
                    @role('operator')
                    <li class="menu-item">
                        <a href="{{route('baccounts.index')}}" class="menu-link">
                            <span class="menu-text">Operated File</span>
                        </a>
                    </li>
                    @endrole
                    {{-- <li class="menu-item">
                        <a href="{{route('transactions.index')}}" class="menu-link">
                            <span class="menu-text">Transactions</span>
                        </a>
                    </li> --}}
                    @role('admin|accountant|checker')
                    <li class="menu-item">
                        <a href="{{route('customfiles.index')}}" class="menu-link">
                            <span class="menu-text">Customs Files</span>
                        </a>
                    </li>
                    @endrole
                </ul>
            </li>
            @endrole

            @role('admin|accountant')

            {{-- Account --}}
            {{-- Finance --}}
            {{-- <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-bank-outline"></i></span>
                    <span class="menu-text"> Finance </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{route('banks.index')}}" class="menu-link">
                            <span class="menu-text">Banks</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('baccounts.index')}}" class="menu-link">
                            <span class="menu-text">Bank Accounts</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('transactions.index')}}" class="menu-link">
                            <span class="menu-text">Transactions</span>
                        </a>
                    </li>

                </ul>
            </li> --}}

            @endrole
            @role('admin')

            {{-- Activity Log --}}
            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-playlist-play"></i></span>
                    <span class="menu-text"> Activity Log </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{route('activity-logs.index')}}" class="menu-link">
                            <span class="menu-text">All</span>
                        </a>
                    </li>
                </ul>
            </li>


            {{-- User --}}
            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-account-supervisor-outline"></i></span>
                    <span class="menu-text"> Users </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{route('users.index')}}" class="menu-link">
                            <span class="menu-text">All User</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('users.create')}}" class="menu-link">
                            <span class="menu-text">New User</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('createagentuser')}}" class="menu-link">
                            <span class="menu-text">New Agent User</span>
                        </a>
                    </li>
                    {{-- <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">Add Salary</span>
                        </a>
                    </li> --}}
                    {{-- <li class="menu-item">
                        <a href="{{route('users.index')}}" class="menu-link">
                            <span class="menu-text">Trash</span>
                        </a>
                    </li> --}}
                    <li class="menu-item">
                        <a href="{{route('roles.index')}}" class="menu-link">
                            <span class="menu-text">All Role</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('roles.create')}}" class="menu-link">
                            <span class="menu-text">New Role</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('permissions.index')}}" class="menu-link">
                            <span class="menu-text">Permissions</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Repots --}}
            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-cards-outline"></i></span>
                    <span class="menu-text">Reports</span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{route('reports.receiver_report')}}" class="menu-link">
                            <span class="menu-text">Receiver Report</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('reports.deliver_report')}}" class="menu-link">
                            <span class="menu-text">Delivery Report</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('reports.operator_report')}}" class="menu-link">
                            <span class="menu-text">Operator Report</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('reports.financial.monthly')}}" class="menu-link">
                            <span class="menu-text">Financial Report</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('reports.unpaid')}}" class="menu-link">
                            <span class="menu-text">Unpaid Files Report</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('reports.paid')}}" class="menu-link">
                            <span class="menu-text">Daily Paid Report</span>
                        </a>
                    </li>
                </ul>
            </li>


            @endrole



        </ul>
    </div>
</div>
